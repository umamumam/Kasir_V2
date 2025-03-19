@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <!-- Header -->
        <div class="card-header text-center d-flex justify-content-between align-items-center"
            style="background: linear-gradient(90deg, #1e90ff, #00bfff); color: white; border-radius: 5px;">
            <h4 style="color: white"><i class="fas fa-cart-plus me-2"></i> Tambah Transaksi</h4>
        </div>

        <!-- Form -->
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <!-- Form Group -->
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <label for="kode" class="form-label">Kode Transaksi</label>
                    <input type="text" name="kode" class="form-control shadow-sm" id="kode"
                        value="{{ $kodeTransaksi }}" readonly required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggaltransaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tanggaltransaksi" class="form-control shadow-sm" id="tanggaltransaksi"
                        value="{{ old('tanggaltransaksi', now()->format('Y-m-d')) }}">
                </div>
            </div>

            <!-- Tombol Tambah Produk -->
            <div class="text-start">
                <button type="button" id="add-product" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Produk
                </button>
            </div>
            <div class="mb-3">
                <label for="barcode" class="form-label">Scan Barcode</label>
                <input type="text" id="barcode" class="form-control shadow-sm" placeholder="Masukkan atau scan barcode produk...">
            </div>
            

            <!-- Tabel Produk -->
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-hover" id="produk-table">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Stok</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="produk-table-body">
                        <!-- Produk yang ditambahkan akan muncul di sini -->
                    </tbody>
                </table>
            </div>

            <!-- Input Total dan Bayar -->
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <label for="total" class="form-label">Total Harga</label>
                    <input type="text" name="total" class="form-control shadow-sm" id="total" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bayar" class="form-label">Bayar</label>
                    <input type="number" name="bayar" class="form-control shadow-sm" id="bayar" placeholder="Masukkan jumlah bayar" required>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary mt-3 shadow">
                <i class="fas fa-save me-2"></i> Simpan Transaksi
            </button>
        </form>
    </div>
</div>

<!-- Modal Popup untuk Pilih Produk -->
<div class="modal fade" id="produkModal" tabindex="-1" aria-labelledby="produkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="produkModalLabel">Pilih Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="search-produk" class="form-control mb-3" placeholder="Cari produk..." oninput="filterProduk()">
                <div id="produk-list">
                    @foreach ($produks as $produk)
                        @if ($produk->stok > 0)
                            <div class="product-item" data-id="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}" data-kode="{{ $produk->kode }}" data-stok="{{ $produk->stok }}">
                                <p>{{ $produk->nama }} ({{ $produk->kode }})</p>
                            </div>
                        @endif
                    @endforeach                
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    document.getElementById('barcode').addEventListener('keypress', async function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();

            let barcode = e.target.value.trim();
            if (!barcode) return;

            // Cari produk berdasarkan barcode
            try {
                let response = await fetch(`/api/produk-by-barcode/${barcode}`);
                if (!response.ok) throw new Error('Produk tidak ditemukan');
                let produk = await response.json();

                if (produk) {
                    // Tambahkan produk ke tabel
                    let produkFields = document.getElementById('produk-table-body');
                    let newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>
                            <select name="produk_id[]" class="form-control produk-select shadow-sm" required>
                                <option value="${produk.id}" data-harga="${produk.harga_jual}">
                                    ${produk.nama} (Kode: ${produk.kode})
                                </option>
                            </select>
                        </td>
                        <td class="stok">${produk.stok}</td>
                        <td>
                            <input type="number" name="jumlah[]" class="form-control jumlah-input shadow-sm" min="1" value="1" required>
                        </td>
                        <td class="harga">Rp ${formatRupiah(produk.harga_jual)}</td>
                        <td class="total-harga">Rp ${formatRupiah(produk.harga_jual)}</td>
                        <td>
                            <button type="button" class="btn btn-danger cancel-product shadow-sm">
                                <i class="fas fa-trash-alt me-2"></i> Batal
                            </button>
                        </td>
                    `;
                    produkFields.appendChild(newRow);

                    updateTotalPrice();

                    // Bersihkan input barcode
                    e.target.value = '';
                } else {
                    alert('Produk tidak ditemukan.');
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan saat mencari produk.');
            }
        }
    });

    document.getElementById('add-product').addEventListener('click', function () {
        var produkModal = new bootstrap.Modal(document.getElementById('produkModal'));
        produkModal.show();
        document.getElementById('search-produk').focus();
    });

    document.getElementById('search-produk').addEventListener('input', function (e) {
        var query = e.target.value.trim();
        var produkItems = document.querySelectorAll('.product-item');
        var matchedItem = null;

        produkItems.forEach(function(item) {
            var productCode = item.getAttribute('data-kode').toLowerCase();
            var productName = item.querySelector('p').textContent.toLowerCase();

            if (productCode.includes(query) || productName.includes(query)) {
                item.style.display = '';

                if (/^\d+$/.test(query) && productCode === query) {
                    matchedItem = item;
                }
            } else {
                item.style.display = 'none';
            }
        });
        if (matchedItem) {
            matchedItem.click();
            e.target.value = ''; 
        }
    });

    document.querySelectorAll('.product-item').forEach(function(item) {
        item.addEventListener('click', function () {
            var productId = item.getAttribute('data-id');
            var productPrice = item.getAttribute('data-harga');
            var productStock = item.getAttribute('data-stok'); 
            var productName = item.querySelector('p').textContent;

            var produkFields = document.getElementById('produk-table-body');

            var newRow = document.createElement('tr');
            newRow.classList.add('produk-row', 'animated', 'fadeIn');
            newRow.innerHTML = `
                <td>
                    <select name="produk_id[]" class="form-control produk-select shadow-sm" required>
                        <option value="${productId}" data-harga="${productPrice}">${productName}</option>
                    </select>
                </td>
                <td class="stok">${productStock}</td>
                <td>
                    <input type="number" name="jumlah[]" class="form-control jumlah-input shadow-sm" min="1" value="1" required>
                </td>
                <td class="harga">Rp ${formatRupiah(productPrice)}</td>
                <td class="total-harga">Rp ${formatRupiah(productPrice)}</td>
                <td>
                    <button type="button" class="btn btn-danger cancel-product shadow-sm">
                        <i class="fas fa-trash-alt me-2"></i> Batal
                    </button>
                </td>
            `;

            produkFields.appendChild(newRow);
            updateTotalPrice();
            bootstrap.Modal.getInstance(document.getElementById('produkModal')).hide(); 
        });
    });

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);
    }

    function updateTotalPrice() {
        var total = 0;
        var rows = document.querySelectorAll('#produk-table-body tr');

        rows.forEach(function (row) {
            var jumlah = row.querySelector('.jumlah-input').value;
            var harga = row.querySelector('.produk-select').selectedOptions[0].getAttribute('data-harga');
            var totalHarga = jumlah * harga;

            row.querySelector('.harga').textContent = formatRupiah(harga);
            row.querySelector('.total-harga').textContent = formatRupiah(totalHarga);

            total += totalHarga;
        });

        document.getElementById('total').value = formatRupiah(total);
    }

    document.addEventListener('input', function (e) {
        if (e.target && e.target.classList.contains('jumlah-input')) {
            updateTotalPrice();
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('produk-select')) {
            updateTotalPrice();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('cancel-product')) {
            var row = e.target.closest('tr');
            row.classList.add('animated', 'fadeOut');
            setTimeout(function () {
                row.remove();
                updateTotalPrice();
            }, 300);
        }
    });

    document.addEventListener('input', function (e) {
        if (e.target && e.target.classList.contains('jumlah-input')) {
            var row = e.target.closest('tr');
            var stok = parseInt(row.querySelector('.stok').textContent.trim());
            var jumlah = parseInt(e.target.value);

            if (jumlah > stok) {
                alert('Jumlah melebihi stok yang tersedia!');
                e.target.value = stok; 
            }
            updateTotalPrice();
        }
    });

</script>
@endsection

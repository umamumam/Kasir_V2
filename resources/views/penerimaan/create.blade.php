@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 style="color: white"><i class="fas fa-box"></i> Tambah Penerimaan Barang</h4>
        </div>
        <div class="card-body" style="margin-top: 20px;">
            <form action="{{ route('penerimaan.store') }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered" id="produkTable">
                        <thead>
                            <tr class="table-info">
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Jual</th>
                                <th>Tanggal Penerimaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="produk_id[]" class="form-control produk-select" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach ($produks as $produk)
                                            <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">{{ $produk->nama }} ({{ $produk->kode }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="jumlah[]" class="form-control" required min="1"></td>
                                <td><input type="number" name="harga_jual[]" class="form-control harga-jual" required min="0" readonly></td>
                                <td><input type="date" name="tanggal[]" class="form-control tanggal" value="{{ date('Y-m-d') }}" required></td>
                                <td><button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash-alt"></i> Hapus</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mb-3">
                    <label for="barcode" class="form-label">Scan Barcode</label>
                    <input type="text" id="barcode" class="form-control" placeholder="Masukkan atau scan barcode produk...">
                </div>
                
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-success" id="addRow"><i class="fas fa-plus-circle"></i> Tambah Produk</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
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
                        <div class="product-item" data-id="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">
                            <p>{{ $produk->nama }} ({{ $produk->kode }})</p>
                        </div>                    
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('barcode').addEventListener('keypress', async function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            let barcode = e.target.value.trim();
            
            if (!barcode) return;

            // Lakukan pencarian produk berdasarkan barcode
            try {
                let response = await fetch(`/api/produk-by-barcode/${barcode}`);
                let produk = await response.json();

                if (produk) {
                    // Tambahkan produk ke tabel
                    let tableBody = document.querySelector('#produkTable tbody');
                    let newRow = `
                        <tr>
                            <td>
                                <select name="produk_id[]" class="form-control produk-select" required>
                                    <option value="${produk.id}" data-harga="${produk.harga_jual}">
                                        ${produk.nama} (Kode: ${produk.kode})
                                    </option>
                                </select>
                            </td>
                            <td><input type="number" name="jumlah[]" class="form-control" required min="1"></td>
                            <td><input type="number" name="harga_jual[]" class="form-control harga-jual" value="${produk.harga_jual}" readonly></td>
                            <td><input type="date" name="tanggal[]" class="form-control tanggal" value="{{ date('Y-m-d') }}" required></td>
                            <td><button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash-alt"></i> Hapus</button></td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', newRow);

                    // Bersihkan input barcode
                    e.target.value = '';
                } else {
                    alert('Produk dengan barcode ini tidak ditemukan.');
                }
            } catch (error) {
                console.error('Terjadi kesalahan:', error);
                alert('Gagal mencari produk. Periksa koneksi atau hubungi admin.');
            }
        }
    });

    // Show modal when add product button is clicked
    document.getElementById('addRow').addEventListener('click', function () {
        var produkModal = new bootstrap.Modal(document.getElementById('produkModal'));
        produkModal.show();
    });

    // Filter produk list based on search input
    function filterProduk() {
        var query = document.getElementById('search-produk').value.toLowerCase();
        var produkItems = document.querySelectorAll('.product-item');
        
        produkItems.forEach(function(item) {
            var productName = item.querySelector('p').textContent.toLowerCase();
            if (productName.includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Add selected product to the table
    document.querySelectorAll('.product-item').forEach(function(item) {
        item.addEventListener('click', function () {
            var productId = item.getAttribute('data-id');
            var productPrice = item.getAttribute('data-harga');
            var productName = item.querySelector('p').textContent;

            let tableBody = document.querySelector('#produkTable tbody');
            let newRow = `
                <tr>
                    <td>
                        <select name="produk_id[]" class="form-control produk-select" required>
                            <option value="${productId}" data-harga="${productPrice}">${productName}</option>
                        </select>
                    </td>
                    <td><input type="number" name="jumlah[]" class="form-control" required min="1"></td>
                    <td><input type="number" name="harga_jual[]" class="form-control harga-jual" value="${productPrice}"></td>
                    <td><input type="date" name="tanggal[]" class="form-control tanggal" value="{{ date('Y-m-d') }}" required></td>
                    <td><button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash-alt"></i> Hapus</button></td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', newRow);
            var produkModal = bootstrap.Modal.getInstance(document.getElementById('produkModal'));
            produkModal.hide();
        });
    });

    // Remove row when delete button is clicked
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });

    // Update harga jual based on selected product
    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('produk-select')) {
            let selectedOption = e.target.options[e.target.selectedIndex];
            let hargaInput = e.target.closest('tr').querySelector('.harga-jual');
            hargaInput.value = selectedOption.dataset.harga || 0;
        }
    });
</script>

@endsection

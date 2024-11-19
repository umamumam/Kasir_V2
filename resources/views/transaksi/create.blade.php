@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <!-- Header -->
        <div class="card-header text-center d-flex justify-content-between align-items-center"
            style="background: linear-gradient(90deg, #1e90ff, #00bfff); color: white; border-radius: 5px;">
            <h4 style="color: white"><i class="fas fa-exchange-alt me-2"></i> Tambah Transaksi</h4>
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
            <div class="text-end">
                <button type="button" id="add-product" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Produk
                </button>
            </div>

            <!-- Tabel Produk -->
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-hover" id="produk-table">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
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

<!-- Script -->
<script>
    document.getElementById('add-product').addEventListener('click', function () {
        var produkFields = document.getElementById('produk-table-body');

        var newRow = document.createElement('tr');
        newRow.classList.add('produk-row', 'animated', 'fadeIn');
        newRow.innerHTML = `
            <td>
                <select name="produk_id[]" class="form-control produk-select shadow-sm" required>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">{{ $produk->nama }} - Rp {{ number_format($produk->harga_jual, 2, ',', '.') }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="jumlah[]" class="form-control jumlah-input shadow-sm" min="1" value="1" required>
            </td>
            <td class="harga">Rp 0</td>
            <td class="total-harga">Rp 0</td>
            <td>
                <button type="button" class="btn btn-danger cancel-product shadow-sm">
                    <i class="fas fa-trash-alt me-2"></i> Batal
                </button>
            </td>
        `;

        produkFields.appendChild(newRow);
        updateTotalPrice();
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
</script>
@endsection

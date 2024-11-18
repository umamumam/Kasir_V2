@extends('layouts.app')

@section('content')
    <h1>Tambah Transaksi</h1>

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <div class="form-group row">
            <div class="col-md-6">
                <label for="kode">Kode Transaksi</label>
                <!-- Menampilkan kode transaksi otomatis -->
                <input type="text" name="kode" class="form-control" id="kode" value="{{ $kodeTransaksi }}" readonly
                    required>
            </div>

            <div class="col-md-6">
                <label for="tanggaltransaksi">tanggaltransaksi Transaksi</label>
                <!-- Input tanggaltransaksi transaksi dengan default tanggaltransaksi sekarang -->
                <input type="date" name="tanggaltransaksi" class="form-control" id="tanggaltransaksi"
                    value="{{ old('tanggaltransaksi', now()->format('Y-m-d')) }}">
            </div>
        </div>

        <div class="grid_12" style="margin: 10px;">
            <button type="button" id="add-product" class="btn btn-secondary">Tambah Produk</button>
        </div>

        <!-- Tabel untuk menampilkan produk yang ditambahkan -->
        <table class="table" id="produk-table">
            <thead>
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

        <div class="form-group mt-3">
            <label for="total">Total Harga</label>
            <input type="text" name="total" class="form-control" id="total" readonly>
        </div>

        <div class="form-group mt-3">
            <label for="bayar">Bayar</label>
            <input type="number" name="bayar" class="form-control" id="bayar" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Transaksi</button>
    </form>

    <script>
        document.getElementById('add-product').addEventListener('click', function() {
            var produkFields = document.getElementById('produk-table-body');

            var newRow = document.createElement('tr');
            newRow.classList.add('produk-row');
            newRow.innerHTML = `
            <td>
                <select name="produk_id[]" class="form-control produk-select" required>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">{{ $produk->nama }} - {{ number_format($produk->harga_jual, 2) }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" required>
            </td>
            <td class="harga">0</td>
            <td class="total-harga">0</td>
            <td>
                <button type="button" class="btn btn-danger cancel-product">Batal</button>
            </td>
        `;

            produkFields.appendChild(newRow);
            updateTotalPrice(); // Update harga total saat produk ditambahkan
        });

        // Fungsi untuk menghapus produk
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('cancel-product')) {
                var row = e.target.closest('tr');
                row.remove();
                updateTotalPrice(); // Update harga total setelah produk dibatalkan
            }
        });

        // Fungsi untuk menghitung total harga
        function updateTotalPrice() {
            var total = 0;
            var rows = document.querySelectorAll('#produk-table-body tr');

            rows.forEach(function(row) {
                var jumlah = row.querySelector('.jumlah-input').value;
                var harga = row.querySelector('.produk-select').selectedOptions[0].getAttribute('data-harga');
                var totalHarga = jumlah * harga;

                row.querySelector('.harga').textContent = harga;
                row.querySelector('.total-harga').textContent = totalHarga.toFixed(2);

                total += totalHarga;
            });

            // Update total harga di form
            document.getElementById('total').value = total.toFixed(2);
        }

        // Menghitung ulang total harga ketika jumlah produk diubah
        document.addEventListener('input', function(e) {
            if (e.target && e.target.classList.contains('jumlah-input')) {
                updateTotalPrice();
            }
        });

        // Menghitung ulang total harga ketika produk dipilih
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('produk-select')) {
                updateTotalPrice();
            }
        });
    </script>
@endsection

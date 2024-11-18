@extends('layouts.app')

@section('content')
    <h1>Edit Transaksi</h1>

    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group row">
            <div class="col-md-6">
                <label for="kode">Kode Transaksi</label>
                <input type="text" name="kode" class="form-control" id="kode"
                    value="{{ old('kode', $transaksi->kode) }}" readonly required>
            </div>

            <div class="col-md-6">
                <label for="tanggaltransaksi">tanggaltransaksi Transaksi</label>
                <input type="date" name="tanggaltransaksi" class="form-control" id="tanggaltransaksi"
                    value="{{ old('tanggaltransaksi', $transaksi->tanggaltransaksi) }}">
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
                <!-- Produk yang sudah ada -->
                @foreach ($transaksi->detailTransaksi as $detail)
                    <tr class="produk-row">
                        <td>
                            <select name="produk_id[]" class="form-control produk-select" required>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}" @if ($produk->id == $detail->produk_id) selected @endif
                                        data-harga="{{ $produk->harga_jual }}">
                                        {{ $produk->nama }} - {{ number_format($produk->harga_jual, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1"
                                value="{{ $detail->jumlah }}" required>
                        </td>
                        <td class="harga">{{ number_format($detail->produk->harga_jual, 2) }}</td>
                        <td class="total-harga">{{ number_format($detail->jumlah * $detail->produk->harga_jual, 2) }}</td>
                        <td>
                            <button type="button" class="btn btn-danger cancel-product">Batal</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-group mt-3">
            <label for="total">Total Harga</label>
            <input type="text" name="total" class="form-control" id="total"
                value="{{ old('total', $transaksi->total) }}" readonly>
        </div>

        <div class="form-group mt-3">
            <label for="bayar">Bayar</label>
            <input type="number" name="bayar" class="form-control" id="bayar"
                value="{{ old('bayar', $transaksi->bayar) }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Transaksi</button>
    </form>

    <script>
        // Fungsi untuk menambahkan produk baru ke dalam tabel
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

        // Fungsi untuk menghapus produk dari tabel
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

                row.querySelector('.harga').textContent = formatCurrency(harga);
                row.querySelector('.total-harga').textContent = formatCurrency(totalHarga.toFixed(2));

                total += totalHarga;
            });

            // Update total harga di form
            document.getElementById('total').value = formatCurrency(total.toFixed(2));
        }

        // Format number ke format mata uang
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
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

        // Inisialisasi harga saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateTotalPrice();
        });
    </script>
@endsection

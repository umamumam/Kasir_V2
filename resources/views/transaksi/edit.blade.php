@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <div class="card-header text-center d-flex justify-content-between align-items-center"
            style="background: linear-gradient(90deg, #1e90ff, #00bfff); color: white; border-radius: 5px;">
            <h4 style="color: white"><i class="fas fa-edit me-2"></i> Edit Transaksi</h4>
        </div>

        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <label for="kode" class="form-label">Kode Transaksi</label>
                    <input type="text" name="kode" class="form-control shadow-sm" id="kode"
                        value="{{ old('kode', $transaksi->kode) }}" readonly required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggaltransaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tanggaltransaksi" class="form-control shadow-sm" id="tanggaltransaksi"
                        value="{{ old('tanggaltransaksi', $transaksi->tanggaltransaksi ?? now()->format('Y-m-d')) }}"
                        required>
                </div>
            </div>

            <div class="text-end">
                <button type="button" id="add-product" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Produk
                </button>
            </div>

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
                        @foreach ($transaksi->detailTransaksi as $detail)
                        <tr class="produk-row">
                            <td>
                                <input type="text" name="produk_nama[]" class="form-control produk-input shadow-sm"
                                    list="produk-list" value="{{ $detail->produk->nama }}" required>
                                <input type="hidden" name="produk_id[]" value="{{ $detail->produk_id }}">
                            </td>
                            <td>
                                <input type="number" name="jumlah[]" class="form-control jumlah-input shadow-sm" min="1"
                                    value="{{ $detail->jumlah }}" required>
                            </td>
                            <td class="harga">
                                <input type="text" name="harga[]" class="form-control harga-input shadow-sm"
                                    value="{{ $detail->produk->harga_jual }}" readonly>
                            </td>
                            <td class="total-harga">
                                <input type="text" name="total_harga[]" class="form-control total-harga-input shadow-sm"
                                    value="{{ $detail->jumlah * $detail->produk->harga_jual }}" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger cancel-product shadow-sm">
                                    <i class="fas fa-trash-alt me-2"></i> Batal
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <label for="total" class="form-label">Total Harga</label>
                    <input type="text" name="total" class="form-control shadow-sm" id="total"
                        value="{{ old('total', $transaksi->total) }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bayar" class="form-label">Bayar</label>
                    <input type="number" name="bayar" class="form-control shadow-sm" id="bayar"
                        value="{{ old('bayar', $transaksi->bayar) }}" placeholder="Masukkan jumlah bayar" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3 shadow">
                <i class="fas fa-save me-2"></i> Update Transaksi
            </button>
        </form>
    </div>
</div>

<!-- DataList untuk Produk -->
<datalist id="produk-list">
    @foreach ($produks as $produk)
    <option value="{{ $produk->nama }}" data-id="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">
        {{ $produk->nama }} - Rp {{ number_format($produk->harga_jual, 2, ',', '.') }}
    </option>
    @endforeach
</datalist>

<script>
    document.getElementById('add-product').addEventListener('click', function() {
        var produkFields = document.getElementById('produk-table-body');

        var newRow = document.createElement('tr');
        newRow.classList.add('produk-row');
        newRow.innerHTML = `
        <td>
            <input type="text" name="produk_nama[]" class="form-control produk-input" list="produk-list" required>
            <input type="hidden" name="produk_id[]">
        </td>
        <td>
            <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" required>
        </td>
        <td>
            <input type="text" name="harga[]" class="form-control harga-input" readonly>
        </td>
        <td>
            <input type="text" name="total_harga[]" class="form-control total-harga-input" readonly>
        </td>
        <td>
            <button type="button" class="btn btn-danger cancel-product">Batal</button>
        </td>
    `;

        produkFields.appendChild(newRow);
    });
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('cancel-product')) {
            var row = e.target.closest('tr');
            if (row) {
                row.remove();
                updateTotalPrice(); // Update harga total setelah produk dibatalkan
            }
        }
    });
    document.addEventListener('input', function(e) {
        if (e.target && e.target.classList.contains('produk-input')) {
            var input = e.target;
            var list = document.getElementById('produk-list').options;
            for (var i = 0; i < list.length; i++) {
                if (list[i].value === input.value) {
                    var harga = list[i].getAttribute('data-harga');
                    var id = list[i].getAttribute('data-id');

                    input.parentElement.querySelector('input[name="produk_id[]"]').value = id;
                    input.parentElement.parentElement.querySelector('.harga-input').value = harga;
                    updateTotalPrice();
                    break;
                }
            }
        }

        if (e.target && e.target.classList.contains('jumlah-input')) {
            updateTotalPrice();
        }
    });

    function updateTotalPrice() {
        var total = 0;
        document.querySelectorAll('.produk-row').forEach(function(row) {
            var jumlah = row.querySelector('.jumlah-input').value;
            var harga = row.querySelector('.harga-input').value;
            var totalHarga = jumlah * harga;

            row.querySelector('.total-harga-input').value = totalHarga;
            total += totalHarga;
        });

        document.getElementById('total').value = total;
    }
</script>
@endsection
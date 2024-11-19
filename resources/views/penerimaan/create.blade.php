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
                                            <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">{{ $produk->nama }} (Stok: {{ $produk->stok }})</option>
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

                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-success" id="addRow"><i class="fas fa-plus-circle"></i> Tambah Produk</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('addRow').addEventListener('click', function () {
        let tableBody = document.querySelector('#produkTable tbody');
        let row = `
            <tr>
                <td>
                    <select name="produk_id[]" class="form-control produk-select" required>
                        <option value="">Pilih Produk</option>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">{{ $produk->nama }} (Stok: {{ $produk->stok }})</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="jumlah[]" class="form-control" required min="1"></td>
                <td><input type="number" name="harga_jual[]" class="form-control harga-jual" required min="0" readonly></td>
                <td><input type="date" name="tanggal[]" class="form-control tanggal" value="{{ date('Y-m-d') }}" required></td>
                <td><button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash-alt"></i> Hapus</button></td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', row);
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('produk-select')) {
            let selectedOption = e.target.options[e.target.selectedIndex];
            let hargaInput = e.target.closest('tr').querySelector('.harga-jual');
            hargaInput.value = selectedOption.dataset.harga || 0;
        }
    });
</script>

@endsection

<style>
    .table th, .table td {
        vertical-align: middle;
    }

    .table-responsive {
        margin-bottom: 20px;
    }

    .remove-row {
        width: 100%;
        text-align: center;
        font-size: 14px;
    }

    .form-control {
        font-size: 14px;
    }

    .btn {
        font-size: 14px;
        padding: 10px 15px;
    }

    .card-header {
        background-color: #007bff;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .d-flex .btn {
        width: auto;
        margin-left: 10px;
    }
    .fas {
        margin-right: 5px;
    }
    .btn-danger:hover, .btn-success:hover {
        opacity: 0.9;
    }
</style>

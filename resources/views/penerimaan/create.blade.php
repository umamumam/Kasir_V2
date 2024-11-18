@extends('layouts.app')

@section('content')
<h1>Tambah Penerimaan Barang</h1>

<form action="{{ route('penerimaan.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="produk_id">Produk</label>
        <select name="produk_id" class="form-control" required>
            <option value="">Pilih Produk</option>
            @foreach ($produks as $produk)
                <option value="{{ $produk->id }}">{{ $produk->nama }} (Stok: {{ $produk->stok }})</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="jumlah">Jumlah</label>
        <input type="number" name="jumlah" class="form-control" required min="1">
    </div>

    <div class="form-group">
        <label for="harga_jual">Harga Jual</label>
        <input type="number" name="harga_jual" class="form-control" required min="0">
    </div>

    <div class="form-group">
        <label for="tanggal">Tanggal Penerimaan</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection

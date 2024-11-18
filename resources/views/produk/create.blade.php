@extends('layouts.app')

@section('content')
<h1>Tambah Produk</h1>

<form action="{{ route('produk.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" name="nama" class="form-control" id="nama" required>
    </div>
    <div class="form-group">
        <label for="kode">Kode Produk</label>
        <input type="text" name="kode" class="form-control" id="kode" required>
    </div>
    <div class="form-group">
        <label for="harga_beli">Harga Beli</label>
        <input type="number" name="harga_beli" class="form-control" id="harga_beli" required>
    </div>
    <div class="form-group">
        <label for="harga_jual">Harga Jual</label>
        <input type="number" name="harga_jual" class="form-control" id="harga_jual" required>
    </div>
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" name="stok" class="form-control" id="stok" required>
    </div>
    <div class="form-group">
        <label for="kategori_id">Kategori</label>
        <select name="kategori_id" class="form-control" required>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection

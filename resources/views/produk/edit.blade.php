@extends('layouts.app')

@section('content')
<h1>Edit Produk</h1>

<form action="{{ route('produk.update', $produk) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" name="nama" class="form-control" value="{{ old('nama', $produk->nama) }}" required>
    </div>

    <div class="form-group">
        <label for="kode">Kode Produk</label>
        <input type="text" name="kode" class="form-control" value="{{ old('kode', $produk->kode) }}" required>
    </div>

    <div class="form-group">
        <label for="harga_beli">Harga Beli</label>
        <input type="number" name="harga_beli" class="form-control" value="{{ old('harga_beli', $produk->harga_beli) }}" required>
    </div>

    <div class="form-group">
        <label for="harga_jual">Harga Jual</label>
        <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual', $produk->harga_jual) }}" required>
    </div>

    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" name="stok" class="form-control" value="{{ old('stok', $produk->stok) }}" required>
    </div>

    <div class="form-group">
        <label for="kategori_id">Kategori</label>
        <select name="kategori_id" class="form-control" required>
            <option value="">Pilih Kategori</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ $produk->kategori_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Produk</button>
</form>

@endsection

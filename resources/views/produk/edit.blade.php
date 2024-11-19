@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Produk</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="col-xl">
        <div class="card mb-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Produk</h5>
                <small class="text-body float-end">Form Edit Produk</small>
            </div>
            <div class="card-body">
                <form action="{{ route('produk.update', $produk) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-name" class="input-group-text">
                            <i class="ri-price-tag-3-line ri-20px"></i>
                        </span>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Produk"
                            value="{{ old('nama', $produk->nama) }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-kode" class="input-group-text">
                            <i class="ri-barcode-line ri-20px"></i>
                        </span>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Produk"
                            value="{{ old('kode', $produk->kode) }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-harga-beli" class="input-group-text">
                            <i class="ri-money-dollar-circle-line ri-20px"></i>
                        </span>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli"
                            placeholder="Harga Beli" value="{{ old('harga_beli', $produk->harga_beli) }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-harga-jual" class="input-group-text">
                            <i class="ri-money-dollar-circle-line ri-20px"></i>
                        </span>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                            placeholder="Harga Jual" value="{{ old('harga_jual', $produk->harga_jual) }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-stok" class="input-group-text">
                            <i class="ri-stack-line ri-20px"></i>
                        </span>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Stok"
                            value="{{ old('stok', $produk->stok) }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-kategori" class="input-group-text">
                            <i class="ri-price-tag-3-line ri-20px"></i>
                        </span>
                        <select name="kategori_id" class="form-select" required aria-describedby="basic-icon-default-kategori">
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

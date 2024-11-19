@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Kategori</h4>

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
                <h5 class="mb-0">Edit Kategori</h5>
                <small class="text-body float-end">Form Ubah Kategori</small>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori.update', $kategori) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-name" class="input-group-text">
                            <i class="ri-price-tag-3-line ri-20px"></i>
                        </span>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kategori"
                            value="{{ old('nama', $kategori->nama) }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

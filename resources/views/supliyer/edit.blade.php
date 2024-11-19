@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Supplier</h4>

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
                <h5 class="mb-0">Edit Supplier</h5>
                <small class="text-body float-end">Form Edit Supplier</small>
            </div>
            <div class="card-body">
                <form action="{{ route('supliyer.update', $supliyer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-name" class="input-group-text">
                            <i class="ri-user-line ri-20px"></i>
                        </span>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $supliyer->nama) }}" placeholder="Nama Supplier" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-email" class="input-group-text">
                            <i class="ri-mail-line ri-20px"></i>
                        </span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $supliyer->email) }}" placeholder="Email Supplier">
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-telepon" class="input-group-text">
                            <i class="ri-phone-line ri-20px"></i>
                        </span>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $supliyer->telepon) }}" placeholder="Telepon Supplier">
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-alamat" class="input-group-text">
                            <i class="ri-map-pin-line ri-20px"></i>
                        </span>
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat Supplier">{{ old('alamat', $supliyer->alamat) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('supliyer.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
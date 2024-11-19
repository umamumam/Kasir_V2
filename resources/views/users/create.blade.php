@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Pengguna Baru</h4>

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
                <h5 class="mb-0">Tambah Pengguna Baru</h5>
                <small class="text-body float-end">Form Input Pengguna</small>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="ri-user-line ri-20px"></i>
                        </span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap"
                            value="{{ old('name') }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-company2" class="input-group-text">
                            <i class="ri-mail-line ri-20px"></i>
                        </span>
                        <input type="email" id="email" class="form-control" name="email" placeholder="Email"
                            value="{{ old('email') }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-company2" class="input-group-text">
                            <i class="ri-lock-line ri-20px"></i>
                        </span>
                        <input type="password" id="password" class="form-control" name="password" placeholder="Password"
                            required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-role2" class="input-group-text">
                            <i class="ri-user-star-line ri-20px"></i>
                        </span>
                        <select class="form-select" id="role" name="role" required aria-describedby="basic-icon-default-role2">
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                        </select>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-message2" class="input-group-text">
                            <i class="ri-chat-4-line ri-20px"></i>
                        </span>
                        <textarea id="basic-icon-default-message" class="form-control" name="notes"
                            placeholder="Catatan tambahan (Opsional)" aria-label="Catatan tambahan"
                            style="height: 60px"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
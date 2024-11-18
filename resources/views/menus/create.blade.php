@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Menu</h2>

    <form action="{{ route('menus.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input type="text" class="form-control" id="url" name="url" required>
        </div>
        <div class="mb-3">
            <label for="order" class="form-label">Urutan</label>
            <input type="number" class="form-control" id="order" name="order" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

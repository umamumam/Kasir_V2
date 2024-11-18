@extends('layouts.app')

@section('content')
<h1>Edit Kategori</h1>

<form action="{{ route('kategori.update', $kategori) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nama">Nama Kategori</label>
        <input type="text" name="nama" class="form-control" value="{{ old('nama', $kategori->nama) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Update Kategori</button>
</form>

@endsection

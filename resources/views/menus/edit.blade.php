@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Menu</h2>

    <form action="{{ route('menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input type="text" class="form-control" id="url" name="url" value="{{ old('url', $menu->url) }}" required>
        </div>
        <div class="mb-3">
            <label for="order" class="form-label">Urutan</label>
            <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $menu->order) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

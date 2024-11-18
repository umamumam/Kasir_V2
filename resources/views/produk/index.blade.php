@extends('layouts.app')

@section('content')
<h1>Daftar Produk</h1>
<a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Kategori</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produks as $produk)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $produk->nama }}</td>
                <td>{{ $produk->harga_jual }}</td>
                <td>{{ $produk->stok }}</td>
                <td>{{ $produk->kategori->nama }}</td>
                <td>
                    <a href="{{ route('produk.edit', $produk) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('produk.destroy', $produk) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

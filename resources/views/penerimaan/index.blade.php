@extends('layouts.app')

@section('content')
<h1>Daftar Penerimaan Barang</h1>

<a href="{{ route('penerimaan.create') }}" class="btn btn-primary mb-3">Tambah Penerimaan</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga Jual</th>
            <th>Tanggal Penerimaan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penerimaan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->produk->nama }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->harga_jual, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('penerimaan.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data penerimaan barang.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

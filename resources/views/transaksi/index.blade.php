@extends('layouts.app')

@section('content')
    <h1>Daftar Transaksi</h1>

    <!-- Tombol untuk menambahkan transaksi baru -->
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>

    <!-- Tabel daftar transaksi -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembalian</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaksi->tanggaltransaksi }}</td>
                    <td>{{ $transaksi->kode }}</td>
                    <td>{{ number_format($transaksi->total, 2) }}</td>
                    <td>{{ number_format($transaksi->bayar, 2) }}</td>
                    <td>{{ number_format($transaksi->kembalian, 2) }}</td>
                    <td>
                        <!-- Link untuk melihat detail transaksi -->
                        <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-info btn-sm">Detail</a>

                        <!-- Link untuk mengedit transaksi -->
                        <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Form untuk menghapus transaksi (optional) -->
                        <form action="{{ route('transaksi.destroy', $transaksi) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                        </form>
                        <a href="{{ route('transaksi.print', $transaksi) }}" class="btn btn-success btn-sm">Cetak Kuitansi</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

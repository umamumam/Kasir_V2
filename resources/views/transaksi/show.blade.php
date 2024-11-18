@extends('layouts.app')

@section('content')
<h1>Detail Transaksi</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi->detailTransaksi as $detail)
            <tr>
                <td>{{ $detail->produk->nama }}</td>
                <td>{{ number_format($detail->harga, 2) }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>{{ number_format($detail->subtotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    <p><strong>Total: </strong>{{ number_format($transaksi->total, 2) }}</p>
    <p><strong>Bayar: </strong>{{ number_format($transaksi->bayar, 2) }}</p>
    <p><strong>Kembalian: </strong>{{ number_format($transaksi->kembalian, 2) }}</p>
</div>

<a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>

<!-- Tombol untuk mencetak kuitansi -->
<a href="{{ route('transaksi.print', $transaksi) }}" class="btn btn-success">Cetak Kuitansi</a>

@endsection

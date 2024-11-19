@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Detail Transaksi</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Detail Produk</h5>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Produk</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->detailTransaksi as $detail)
                        <tr>
                            <td>{{ $detail->produk->nama }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga, 2) }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($detail->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informasi Pembayaran</h5>
                    <p><strong>Total:</strong> Rp {{ number_format($transaksi->total, 2) }}</p>
                    <p><strong>Bayar:</strong> Rp {{ number_format($transaksi->bayar, 2) }}</p>
                    <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->kembalian, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('transaksi.print', $transaksi) }}" class="btn btn-success">
            <i class="bi bi-printer"></i> Cetak Kuitansi
        </a>
    </div>
</div>
@endsection

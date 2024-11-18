@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Laporan</h1>

    <form method="GET" action="{{ route('dashboard.laporan') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">Dari Tanggal:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" 
                       value="{{ old('start_date', $start->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">Sampai Tanggal:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" 
                       value="{{ old('end_date', $end->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </div>
    </form>
    

    <h3>Laporan Transaksi ({{ $start->format('d M Y') }} - {{ $end->format('d M Y') }})</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $transaksi)
                <tr>
                    <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                    <td>{{ $transaksi->kode }}</td>
                    <td>Rp{{ number_format($transaksi->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

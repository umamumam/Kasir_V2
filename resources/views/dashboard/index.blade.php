@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    <!-- Info Produk, Pendapatan, Stok Rendah -->
    <div class="row mb-4">
        <!-- Total Produk -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <p class="h4">{{ $totalProduk ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Pendapatan Harian -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title">Pendapatan Harian</h5>
                    <p class="h4">Rp {{ number_format($pendapatanHarian ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Stok Rendah -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <h5 class="card-title">Stok Rendah</h5>
                    @if (count($stokRendah) > 0)
                        <ul class="list-unstyled">
                            @foreach ($stokRendah as $produk)
                                <li>{{ $produk->nama }} - Sisa Stok: {{ $produk->stok }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>-</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Penjualan -->
    <h3 class="mb-3">Grafik Penjualan Harian</h3>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <canvas id="salesChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Filter Laporan -->
    <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4">
        <div class="row d-flex align-items-center">
            <div class="col-md-4 mb-3">
                <label for="start_date">Dari Tanggal:</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ old('start_date', $start->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="end_date">Sampai Tanggal:</label>
                <input type="date" name="end_date" id="end_date" class="form-control"
                    value="{{ old('end_date', $end->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
    <!-- Tabel 5 Produk Terlaris -->
    <h3 class="mb-3">5 Produk Terlaris</h3>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produkTerlaris as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produk->nama ?? '-' }}</td>
                            <td>{{ $produk->total_terjual ?? '-' }}</td>
                        </tr>
                    @endforeach
                    @if ($produkTerlaris->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">-</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Penerimaan Terbaru -->
    <h3 class="mb-3">Penerimaan Terbaru</h3>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penerimaanTerbaru as $penerimaan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $penerimaan->produk->nama ?? '-' }}</td>
                            <td>{{ $penerimaan->jumlah ?? '-' }}</td>
                            <td>Rp {{ number_format($penerimaan->harga_jual, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($penerimaan->tanggal)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                    @if ($penerimaanTerbaru->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">-</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>


    <!-- Tabel Laporan Transaksi -->
    <h3 class="mb-3">Laporan Transaksi</h3>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Total Transaksi</th>
                        <th>Produk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaksi->tanggaltransaksi->format('Y-m-d') }}</td>
                            <td>Rp {{ number_format($transaksi->total, 2) }}</td>
                            <td>
                                @foreach ($transaksi->detailTransaksi as $detail)
                                    <div>{{ $detail->produk->nama ?? '-' }} - {{ $detail->jumlah ?? '-' }} item</div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    @if ($laporan->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">-</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line', // Tipe grafik yang digunakan
            data: {
                labels: @json($tanggal), // Tanggal penjualan
                datasets: [{
                    label: 'Penjualan Harian',
                    data: @json($penjualan), // Total penjualan per hari
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-body {
            padding: 1.5rem;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .table thead th {
            background-color: #f7f7f7;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ddd;
        }

        .card.shadow-sm {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

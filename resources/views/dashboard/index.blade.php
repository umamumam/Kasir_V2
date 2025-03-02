@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-6">
        <!-- Congratulations card -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Welcome {{ Auth::user()->name ?? 'Guest' }}! 🎉 to
                        Smartcashier
                    </h5>
                    <p class="mb-2">Best seller of the month</p>
                    <h4 class="text-primary mb-0">&nbsp;</h4>
                    <p class="mb-2">Smart Busines 🚀</p>
                    <a href="javascript:;" class="btn btn-sm btn-primary">View Sales</a>
                </div>
                <img src="{{ asset('toko.png') }}" class="position-absolute bottom-0 end-0 me-5 mb-5" width="120"
                    alt="view sales" />
            </div>
        </div>
        <!--/ Congratulations card -->

        <!-- Transactions -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Pendapatan Harian</h5>
                        <div class="datetime-container ms-auto text-end" style="margin-right: 15px;">
                            <b>
                                <div class="date" id="currentDate">Loading date...</div>
                                <div class="time" id="currentTime">Loading time...</div>
                            </b>
                        </div>
                        <div class="dropdown">
                            <button class="btn text-muted p-0" type="button" id="transactionID"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-more-2-line ri-24px"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                <a class="dropdown-item" href="javascript:void(0);">Update</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-primary mb-1">Rp {{ number_format($pendapatanHarian ?? 0, 2) }} </h4>
                </div>

                <div class="card-body pt-lg-0">
                    <div class="row g-4">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-primary rounded shadow-xs">
                                        <i class="ri-pie-chart-2-line ri-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Kategori</p>
                                    <h5 class="mb-0">{{ $totalKategori ?? '-' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-success rounded shadow-xs">
                                        <i class="ri-group-line ri-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Produk</p>
                                    <h5 class="mb-0">{{ $totalProduk ?? '-' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-warning rounded shadow-xs">
                                        <i class="ri-macbook-line ri-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Suppliyer</p>
                                    <h5 class="mb-0">{{ $totalSupliyer ?? '-' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-info rounded shadow-xs">
                                        <i class="ri-money-dollar-circle-line ri-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Stok Terendah</p>
                                    <h5 class="mb-0">{{ $stokRendah ?? '-' }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Transactions -->

        <!-- Weekly Overview Chart -->
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-1">Grafik Penjualan Mingguan</h5>
                </div>
                <div class="card-body pt-lg-2">
                    <div id="weeklyOverviewChart"></div>
        
                    <!-- Keterangan di bawah grafik -->
                    <div class="mt-3">
                        <h4 class="mb-1">Total Penjualan: Rp{{ number_format($totalMingguIni, 0, ',', '.') }}</h4>
                        <p class="mb-0">
                            Perbandingan dengan minggu lalu: 
                            <span class="{{ $persentasePerubahan >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($persentasePerubahan, 2) }}%
                                {!! $persentasePerubahan >= 0 ? '📈' : '📉' !!}
                            </span>
                        </p>
                    </div>
        
                    <!-- Tampilkan hari di bawah grafik -->
                    <div class="mt-3 text-center">
                        <strong>Hari dalam Minggu:</strong>
                        <div class="d-flex justify-content-between mt-2">
                            @foreach ($tanggalMingguan as $tanggal)
                                <span class="badge bg-primary">{{ $tanggal }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!--/ Weekly Overview Chart -->

        <!-- Total Earnings -->
        <div class="col-xl-8 col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="text-primary mb-1">🏆️ Top Produk Terlaris 🏆️</h4>
                    <div class="dropdown">
                        <button class="btn text-muted p-0" type="button" id="totalEarnings" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-line ri-24px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalEarnings">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Nama Produk</th>
                                <th style="text-align: center;">Jumlah Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produkTerlaris as $produk)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
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
        </div>
        <!--/ Total Earnings -->

    </div>
</div>

<!-- Filter Laporan -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('dashboard.index') }}">
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
    </div>
</div>


<!-- Tabel Penerimaan Terbaru -->
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h3 class="mb-0">Penerimaan Terbaru</h3>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('dashboard.exportExcel') }}" class="btn btn-success">Export Excel</a>
            <form class="d-flex" method="GET" action="{{ route('dashboard.index') }}">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
            </form>
        </div>
    </div>
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
                    <td colspan="5" class="text-center">Tidak ada data.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>


<!-- Tabel Laporan Transaksi -->
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h3 class="mb-0">Laporan Transaksi</h3>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('dashboard.exportLaporanExcel') }}" class="btn btn-success">Export Excel</a>
            <form class="d-flex ms-2" method="GET" action="{{ route('dashboard.index') }}">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari transaksi..." 
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
            </form>
        </div>
    </div>
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
                    <td colspan="4" class="text-center">Tidak ada data.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    function updateDateTime() {
            const now = new Date();
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

            document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', optionsDate);
            document.getElementById('currentTime').textContent = now.toLocaleTimeString('id-ID', optionsTime);
        }

        // Perbarui setiap detik
        setInterval(updateDateTime, 1000);

        // Panggilan awal agar tidak ada delay saat load
        updateDateTime();
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            chart: {
                type: "line",
                height: 280
            },
            series: [{
                name: "Penjualan",
                data: @json($penjualanMingguanData)
            }],
            xaxis: {
                categories: @json($tanggalMingguan)
            }
        };

        var chart = new ApexCharts(document.querySelector("#weeklyOverviewChart"), options);
        chart.render();
    });
</script>

@endsection
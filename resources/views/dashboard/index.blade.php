@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-6">
        <!-- Congratulations card -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Welcome {{ Auth::user()->name ?? 'Guest' }}! 🎉 to Smartcashier
                    </h5>
                    <p class="mb-2">Best seller of the month</p>
                    <h4 class="text-primary mb-0">&nbsp;</h4>
                    <p class="mb-2">Smart Busines 🚀</p>
                    <a href="javascript:;" class="btn btn-sm btn-primary">View Sales</a>
                </div>
                <img src="{{ asset('toko.png') }}"
                class="position-absolute bottom-0 end-0 me-5 mb-5" width="120" alt="view sales" />                                
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
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ri-more-2-line ri-24px"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="transactionID">
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
                                    <h5 class="mb-0">
                                        @if (count($stokRendah) > 0)
                                            <ul class="list-unstyled">
                                                @foreach ($stokRendah as $produk)
                                                    <li>{{ $produk->nama }} - Sisa Stok: {{ $produk->stok }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </h5>
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
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-1">Grafik Penjualan</h5>
                        <div class="dropdown">
                            <button class="btn text-muted p-0" type="button"
                                id="weeklyOverviewDropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ri-more-2-line ri-24px"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="weeklyOverviewDropdown">
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                <a class="dropdown-item" href="javascript:void(0);">Update</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-lg-2">
                    <div id="weeklyOverviewChart"></div>
                    <div class="mt-1 mt-md-3">
                        <div class="d-flex align-items-center gap-4">
                            <h4 class="mb-0">70%</h4>
                            <p class="mb-0">Your sales performance is 70% 😎 better compared to last
                                month</p>
                        </div>
                        <div class="d-grid mt-3 mt-md-4">
                            <button class="btn btn-primary" type="button">Details</button>
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
                        <button class="btn text-muted p-0" type="button" id="totalEarnings"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        </div>
        <!--/ Total Earnings -->

        {{-- <!-- Four Cards -->
        <div class="col-xl-4 col-md-6">
            <div class="row gy-6">
                <!-- Total Profit line chart -->
                <div class="col-sm-6">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h4 class="mb-0">$86.4k</h4>
                        </div>
                        <div class="card-body">
                            <div id="totalProfitLineChart" class="mb-3"></div>
                            <h6 class="text-center mb-0">Total Profit</h6>
                        </div>
                    </div>
                </div>
                <!--/ Total Profit line chart -->
                <!-- Total Profit Weekly Project -->
                <div class="col-sm-6">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="avatar">
                                <div class="avatar-initial bg-secondary rounded-circle shadow-xs">
                                    <i class="ri-pie-chart-2-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn text-muted p-0" type="button" id="totalProfitID"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="ri-more-2-line ri-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="totalProfitID">
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Update</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-1">Total Profit</h6>
                            <div class="d-flex flex-wrap mb-1 align-items-center">
                                <h4 class="mb-0 me-2">$25.6k</h4>
                                <p class="text-success mb-0">+42%</p>
                            </div>
                            <small>Weekly Project</small>
                        </div>
                    </div>
                </div>
                <!--/ Total Profit Weekly Project -->
                <!-- New Yearly Project -->
                <div class="col-sm-6">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="avatar">
                                <div class="avatar-initial bg-primary rounded-circle shadow-xs">
                                    <i class="ri-file-word-2-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn text-muted p-0" type="button" id="newProjectID"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="ri-more-2-line ri-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="newProjectID">
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Update</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-1">New Project</h6>
                            <div class="d-flex flex-wrap mb-1 align-items-center">
                                <h4 class="mb-0 me-2">862</h4>
                                <p class="text-danger mb-0">-18%</p>
                            </div>
                            <small>Yearly Project</small>
                        </div>
                    </div>
                </div>
                <!--/ New Yearly Project -->
                <!-- Sessions chart -->
                <div class="col-sm-6">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h4 class="mb-0">2,856</h4>
                        </div>
                        <div class="card-body">
                            <div id="sessionsColumnChart" class="mb-3"></div>
                            <h6 class="text-center mb-0">Sessions</h6>
                        </div>
                    </div>
                </div>
                <!--/ Sessions chart -->
            </div>
        </div>
        <!--/ Total Earning --> --}}

        <!-- Sales by Countries -->
        <div class="col-xl-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Sales by Countries</h5>
                    <div class="dropdown">
                        <button class="btn text-muted p-0" type="button" id="saleStatus"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-line ri-24px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="saleStatus">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar me-4">
                                <div class="avatar-initial bg-label-success rounded-circle">US</div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    <h6 class="mb-0">$8,656k</h6>
                                    <i class="ri-arrow-up-s-line ri-24px text-success"></i>
                                    <span class="text-success">25.8%</span>
                                </div>
                                <p class="mb-0">United states of america</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1">894k</h6>
                            <small class="text-muted">Sales</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar me-4">
                                <span
                                    class="avatar-initial bg-label-danger rounded-circle">UK</span>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    <h6 class="mb-0">$2,415k</h6>
                                    <i class="ri-arrow-down-s-line ri-24px text-danger"></i>
                                    <span class="text-danger">6.2%</span>
                                </div>
                                <p class="mb-0">United Kingdom</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1">645k</h6>
                            <small class="text-muted">Sales</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar me-4">
                                <span
                                    class="avatar-initial bg-label-warning rounded-circle">IN</span>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    <h6 class="mb-0">865k</h6>
                                    <i class="ri-arrow-up-s-line ri-24px text-success"></i>
                                    <span class="text-success"> 12.4%</span>
                                </div>
                                <p class="mb-0">India</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1">148k</h6>
                            <small class="text-muted">Sales</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar me-4">
                                <span
                                    class="avatar-initial bg-label-secondary rounded-circle">JA</span>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    <h6 class="mb-0">$745k</h6>
                                    <i class="ri-arrow-down-s-line ri-24px text-danger"></i>
                                    <span class="text-danger">11.9%</span>
                                </div>
                                <p class="mb-0">Japan</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1">86k</h6>
                            <small class="text-muted">Sales</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="avatar me-4">
                                <span
                                    class="avatar-initial bg-label-danger rounded-circle">KO</span>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    <h6 class="mb-0">$45k</h6>
                                    <i class="ri-arrow-up-s-line ri-24px text-success"></i>
                                    <span class="text-success">16.2%</span>
                                </div>
                                <p class="mb-0">Korea</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1">42k</h6>
                            <small class="text-muted">Sales</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Sales by Countries -->

        <!-- Deposit / Withdraw -->
        <div class="col-xl-8">
            <div class="card-group">
                <div class="card mb-0">
                    <div class="card-body card-separator">
                        <div
                            class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                            <h5 class="m-0 me-2">Deposit</h5>
                            <a class="fw-medium" href="javascript:void(0);">View all</a>
                        </div>
                        <div class="deposit-content pt-2">
                            <ul class="p-0 m-0">
                                <li class="d-flex mb-4 align-items-center pb-2">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/payments/gumroad.png') }}" 
                                            class="img-fluid" alt="gumroad" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Gumroad Account</h6>
                                            <p class="mb-0">Sell UI Kit</p>
                                        </div>
                                        <h6 class="text-success mb-0">+$4,650</h6>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center pb-2">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/payments/mastercard-2.png') }}" 
                                        class="img-fluid" alt="mastercard" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Mastercard</h6>
                                            <p class="mb-0">Wallet deposit</p>
                                        </div>
                                        <h6 class="text-success mb-0">+$92,705</h6>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center pb-2">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/payments/stripes.png') }}" 
                                        class="img-fluid" alt="stripes" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Stripe Account</h6>
                                            <p class="mb-0">iOS Application</p>
                                        </div>
                                        <h6 class="text-success mb-0">+$957</h6>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center pb-2">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/payments/american-bank.png') }}" 
                                        class="img-fluid" alt="american" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">American Bank</h6>
                                            <p class="mb-0">Bank Transfer</p>
                                        </div>
                                        <h6 class="text-success mb-0">+$6,837</h6>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/payments/citi.png') }}" 
                                        class="img-fluid" alt="citi" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Bank Account</h6>
                                            <p class="mb-0">Wallet deposit</p>
                                        </div>
                                        <h6 class="text-success mb-0">+$446</h6>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card mb-0">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                            <h5 class="m-0 me-2">Withdraw</h5>
                            <a class="fw-medium" href="javascript:void(0);">View all</a>
                        </div>
                        <div class="withdraw-content pt-2">
                            <ul class="p-0 m-0">
                                <li class="d-flex mb-4 align-items-center pb-2">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/brands/google.png') }}" 
                                        class="img-fluid" alt="google" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Google Adsense</h6>
                                            <p class="mb-0">Paypal deposit</p>
                                        </div>
                                        <h6 class="text-danger mb-0">-$145</h6>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center pb-2">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/brands/github.png') }}" 
                                        class="img-fluid" alt="github" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Github Enterprise</h6>
                                            <p class="mb-0">Security &amp; compliance</p>
                                        </div>
                                        <h6 class="text-danger mb-0">-$1870</h6>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center pb-2">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/brands/slack.png') }}" 
                                        class="img-fluid" alt="slack" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Upgrade Slack Plan</h6>
                                            <p class="mb-0">Debit card deposit</p>
                                        </div>
                                        <h6 class="text-danger mb-0">$450</h6>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center pb-2">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/payments/digital-ocean.png') }}"
                                        class="img-fluid" alt="digital" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Digital Ocean</h6>
                                            <p class="mb-0">Cloud Hosting</p>
                                        </div>
                                        <h6 class="text-danger mb-0">-$540</h6>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset('materio/assets/img/icons/brands/aws.png') }}" 
                                        class="img-fluid" alt="aws" height="30" width="30" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">AWS Account</h6>
                                            <p class="mb-0">Choosing a Cloud Platform</p>
                                        </div>
                                        <h6 class="text-danger mb-0">-$21</h6>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Deposit / Withdraw -->

        <!-- Data Tables -->
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="text-truncate">User</th>
                                <th class="text-truncate">Email</th>
                                <th class="text-truncate">Role</th>
                                <th class="text-truncate">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-4">
                                            <img src="{{ asset('materio/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Jordan Stevenson</h6>
                                            <small class="text-truncate">@amiccoo</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate">susanna.Lind57@gmail.com</td>
                                <td class="text-truncate">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-vip-crown-line ri-22px text-primary me-2"></i>
                                        <span>Admin</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-warning rounded-pill">Pending</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-4">
                                            <img src="{{ asset('materio/assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Benedetto Rossiter</h6>
                                            <small class="text-truncate">@brossiter15</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate">estelle.Bailey10@gmail.com</td>
                                <td class="text-truncate">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-edit-box-line text-warning ri-22px me-2"></i>
                                        <span>Editor</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-success rounded-pill">Active</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-4">
                                            <img src="{{ asset('materio/assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Bentlee Emblin</h6>
                                            <small class="text-truncate">@bemblinf</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate">milo86@hotmail.com</td>
                                <td class="text-truncate">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-computer-line text-danger ri-22px me-2"></i>
                                        <span>Author</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-success rounded-pill">Active</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-4">
                                            <img src="{{ asset('materio/assets/img/avatars/5.png') }}" alt="Avatar" class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Bertha Biner</h6>
                                            <small class="text-truncate">@bbinerh</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate">lonnie35@hotmail.com</td>
                                <td class="text-truncate">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-edit-box-line text-warning ri-22px me-2"></i>
                                        <span>Editor</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-warning rounded-pill">Pending</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-4">
                                            <img src="{{ asset('materio/assets/img/avatars/4.png') }}" alt="Avatar" class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Beverlie Krabbe</h6>
                                            <small class="text-truncate">@bkrabbe1d</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate">ahmad_Collins@yahoo.com</td>
                                <td class="text-truncate">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-pie-chart-2-line ri-22px text-info me-2"></i>
                                        <span>Maintainer</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-success rounded-pill">Active</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-4">
                                            <img src="{{ asset('materio/assets/img/avatars/7.png') }}" alt="Avatar" class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Bradan Rosebotham</h6>
                                            <small class="text-truncate">@brosebothamz</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate">tillman.Gleason68@hotmail.com</td>
                                <td class="text-truncate">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-edit-box-line text-warning ri-22px me-2"></i>
                                        <span>Editor</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-warning rounded-pill">Pending</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-4">
                                            <img src="{{ asset('materio/assets/img/avatars/6.png') }}" alt="Avatar" class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Bree Kilday</h6>
                                            <small class="text-truncate">@bkildayr</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate">otho21@gmail.com</td>
                                <td class="text-truncate">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-user-3-line ri-22px text-success me-2"></i>
                                        <span>Subscriber</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-success rounded-pill">Active</span></td>
                            </tr>
                            <tr class="border-transparent">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-4">
                                            <img src="{{ asset('materio/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Breena Gallemore</h6>
                                            <small class="text-truncate">@bgallemore6</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate">florencio.Little@hotmail.com</td>
                                <td class="text-truncate">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-user-3-line ri-22px text-success me-2"></i>
                                        <span>Subscriber</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-secondary rounded-pill">Inactive</span></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Data Tables -->
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
@endsection


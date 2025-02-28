@extends('layouts.app')

@section('content')
<div class="col-12">
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Daftar Transaksi</h5>
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
            </div>
            <!-- Search and Filter Form -->
            <form action="{{ route('transaksi.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <!-- Filter by Date -->
                <input type="date" name="tanggal_dari" class="form-control form-control-sm w-auto"
                    placeholder="Dari Tanggal" value="{{ request('tanggal_dari', now()->toDateString()) }}"
                    style="min-width: 150px;">
                <input type="date" name="tanggal_sampai" class="form-control form-control-sm w-auto"
                    placeholder="Sampai Tanggal" value="{{ request('tanggal_sampai', now()->toDateString()) }}"
                    style="min-width: 150px;">

                <!-- Filter by Transaction Code -->
                <input type="text" name="kode_transaksi" class="form-control form-control-sm w-auto"
                    placeholder="Cari Kode Transaksi..." value="{{ request('kode_transaksi') }}"
                    style="min-width: 200px;">

                <button type="submit" class="btn btn-primary btn-sm px-3" style="height: calc(2.2em + .5rem + 2px);">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
            @endif
            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                        showConfirmButton: true
                    });
                </script>
            @endif
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $transaksi)
                    <tr>
                        <td>{{ $loop->iteration + $transaksis->firstItem() - 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggaltransaksi)->format('d-m-Y') }}</td>
                        <td>{{ $transaksi->kode }}</td>
                        <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('transaksi.destroy', $transaksi) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            <a href="{{ route('transaksi.print', $transaksi) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination and Entries -->
            <div class="d-flex justify-content-between align-items-center mt-3 custom-container">
                <p class="mb-0">Menampilkan {{ $transaksis->firstItem() }} hingga {{ $transaksis->lastItem() }} dari {{
                    $transaksis->total() }} entri</p>

                <div class="pagination-links">
                    {{ $transaksis->links('pagination::bootstrap-5') }}
                </div>

                <form id="entriesForm" action="{{ route('transaksi.index') }}" method="GET" class="form-container">
                    <select name="entries" class="form-select form-select-sm"
                        onchange="document.getElementById('entriesForm').submit();">
                        <option value="5" {{ request('entries')==5 ? 'selected' : '' }}>5 entri</option>
                        <option value="10" {{ request('entries')==10 ? 'selected' : '' }}>10 entri</option>
                        <option value="25" {{ request('entries')==25 ? 'selected' : '' }}>25 entri</option>
                        <option value="50" {{ request('entries')==50 ? 'selected' : '' }}>50 entri</option>
                        <option value="100" {{ request('entries')==100 ? 'selected' : '' }}>100 entri</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-container {
        margin: 0 15px;
    }

    .pagination-links {
        margin: 0 10px;
    }

    .form-container {
        margin-right: 10px;
        margin-bottom: 10px;
        display: flex;
        justify-content: flex-end;
    }

    .table-responsive {
        margin-left: 10px;
        margin-right: 10px;
    }

    @media (max-width: 768px) {
        .table-responsive {
            margin-left: 5px;
            margin-right: 5px;
        }
    }
</style>

@endsection
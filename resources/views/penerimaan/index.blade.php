@extends('layouts.app')

@section('content')
<div class="col-12">
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Daftar Penerimaan Barang</h5>
                <a href="{{ route('penerimaan.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus"></i> Tambah Penerimaan
                </a>
            </div>
            <!-- Search Form -->
            <form action="{{ route('penerimaan.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Cari produk..."
                    value="{{ request('search') }}" style="min-width: 200px;">
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
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Tanggal Penerimaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penerimaan as $item)
                    <tr>
                        <td>{{ $loop->iteration + $penerimaan->firstItem() - 1 }}</td>
                        <td>{{ $item->produk->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('penerimaan.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination and Entries -->
            <div class="d-flex justify-content-between align-items-center mt-3 custom-container">
                <p class="mb-0">Menampilkan {{ $penerimaan->firstItem() }} hingga {{ $penerimaan->lastItem() }} dari
                    {{ $penerimaan->total() }} entri</p>

                <div class="pagination-links">
                    {{ $penerimaan->links('pagination::bootstrap-5') }}
                </div>

                <form id="entriesForm" action="{{ route('penerimaan.index') }}" method="GET" class="form-container">
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
</style>

@endsection

@extends('layouts.app')

@section('content')
<div class="col-12">
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <div class="w-100 w-md-auto text-center text-md-start mb-2 mb-md-0">
                <h5 class="card-title mb-0">Daftar Produk</h5>
                <a href="{{ route('produk.create') }}" class="btn btn-primary mt-2 tambah-produk">
                    <i class="ri-add-line"></i> Tambah Produk
                </a>
            </div>
            <!-- Search Form -->
            <form action="{{ route('produk.index') }}" method="GET" class="d-flex align-items-center gap-2 search-container ms-md-auto">
                <input type="text" name="search" class="form-control form-control-sm w-auto search-input"
                    placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary btn-sm search-button">
                    <i class="fas fa-search"></i> <span class="d-none d-md-inline">Cari</span>
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive" style="margin: 0 15px;">
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
                        <th>Nama Produk</th>
                        <th>Harga Jual</th>
                        <th>
                            <a href="{{ route('produk.index', array_merge(request()->query(), ['sort_stok' => request('sort_stok') == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                Stok
                                @if(request('sort_stok') == 'asc')
                                    ⬆️
                                @elseif(request('sort_stok') == 'desc')
                                    ⬇️
                                @endif
                            </a>
                        </th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr>
                        <td>{{ $loop->iteration + $produks->firstItem() - 1 }}</td>
                        <td>{{ $produk->nama }}</td>
                        <td>{{ 'Rp ' . number_format($produk->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ $produk->stok }}</td>
                        <td>{{ $produk->kategori->nama }}</td>
                        <td>
                            <a href="{{ route('produk.edit', $produk) }}" class="btn btn-warning btn-sm">
                                <i class="ri-edit-2-line"></i> <span>Edit</span>
                            </a>
                            <form action="{{ route('produk.destroy', $produk) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus produk ini?')">
                                    <i class="ri-delete-bin-line"></i> <span>Hapus</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination and Entries -->
            <div class="d-flex justify-content-between align-items-center mt-3 custom-container">
                <p class="mb-0">
                    Menampilkan {{ $produks->firstItem() }} hingga {{ $produks->lastItem() }} dari {{ $produks->total() }} entri
                </p>

                @if ($produks->hasPages())
                    <ul class="pagination justify-content-center">
                        @if ($produks->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $produks->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        @php
                            $currentPage = $produks->currentPage();
                            $lastPage = $produks->lastPage();
                            $start = max(1, $currentPage - 1);
                            $end = min($lastPage, $currentPage + 1);
                        @endphp

                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $produks->url(1) }}">1</a>
                            </li>
                            @if ($start > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                <a class="page-link" href="{{ $produks->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($end < $lastPage)
                            @if ($end < $lastPage - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $produks->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        @if ($produks->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $produks->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                        @endif
                    </ul>
                @endif

                <form id="entriesForm" action="{{ route('produk.index') }}" method="GET" class="form-container">
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
@media (max-width: 768px) {
    .card-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .tambah-produk {
        width: 100%;
    }

    .search-container {
        width: 100%;
        justify-content: space-between;
    }

    .search-input {
        flex: 1;
    }

    .search-button {
        width: 45px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-sm span {
        display: none;
    }
}


</style>
@endsection

@extends('layouts.app')

@section('content')
<div class="col-12">
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Daftar Kategori</h5>
                <a href="{{ route('kategori.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </a>
            </div>
            <!-- Search Form -->
            <form action="{{ route('kategori.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search..."
                    value="{{ request('search') }}" style="min-width: 200px;">
                <button type="submit" class="btn btn-primary btn-sm px-3" style="height: calc(2.2em + .5rem + 2px);">
                    <i class="fas fa-search"></i>
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
                        <th>Nama Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $kategori)
                    <tr>
                        <td>{{ $loop->iteration + $kategoris->firstItem() - 1 }}</td>
                        <td>{{ $kategori->nama }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination and Entries -->
            <div class="d-flex justify-content-between align-items-center mt-3 custom-container">
                <p class="mb-0">Showing {{ $kategoris->firstItem() }} to {{ $kategoris->lastItem() }} of
                    {{ $kategoris->total() }} entries</p>

                <div class="pagination-links">
                    {{ $kategoris->links('pagination::bootstrap-5') }}
                </div>

                <form id="entriesForm" action="{{ route('kategori.index') }}" method="GET" class="form-container">
                    <select name="entries" class="form-select form-select-sm"
                        onchange="document.getElementById('entriesForm').submit();">
                        <option value="5" {{ request('entries')==5 ? 'selected' : '' }}>5 entries</option>
                        <option value="10" {{ request('entries')==10 ? 'selected' : '' }}>10 entries</option>
                        <option value="25" {{ request('entries')==25 ? 'selected' : '' }}>25 entries</option>
                        <option value="50" {{ request('entries')==50 ? 'selected' : '' }}>50 entries</option>
                        <option value="100" {{ request('entries')==100 ? 'selected' : '' }}>100 entries</option>
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

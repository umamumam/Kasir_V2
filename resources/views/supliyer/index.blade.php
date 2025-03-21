@extends('layouts.app')

@section('content')
<div class="col-12">
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Daftar Supliyer</h5>
                <a href="{{ route('supliyer.create') }}" class="btn btn-primary mt-2">
                    <i class="ri-add-line"></i> Tambah Supliyer
                </a>
            </div>
            <!-- Search Form -->
            <form action="{{ route('supliyer.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Cari supliyer..."
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supliyers as $supliyer)
                    <tr>
                        <td>{{ $loop->iteration + $supliyers->firstItem() - 1 }}</td>
                        <td>{{ $supliyer->nama }}</td>
                        <td>{{ $supliyer->email }}</td>
                        <td>{{ $supliyer->telepon }}</td>
                        <td>{{ $supliyer->alamat }}</td>
                        <td>
                            <a href="{{ route('supliyer.edit', $supliyer->id) }}" class="btn btn-warning btn-sm">
                                <i class="ri-edit-2-line"></i> Edit
                            </a>
                            <form action="{{ route('supliyer.destroy', $supliyer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Anda yakin ingin menghapus supliyer ini?')">
                                    <i class="ri-delete-bin-line"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination and Entries -->
            <div class="d-flex justify-content-between align-items-center mt-3 custom-container">
                <p class="mb-0">Menampilkan {{ $supliyers->firstItem() }} hingga {{ $supliyers->lastItem() }} dari
                    {{ $supliyers->total() }} entri</p>

                <div class="pagination-links">
                    {{ $supliyers->links('pagination::bootstrap-5') }}
                </div>

                <form id="entriesForm" action="{{ route('supliyer.index') }}" method="GET" class="form-container">
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

@extends('layouts.app')

@section('content')
<div class="col-12">
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">User Management</h5>
                <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
            <form action="{{ route('users.index') }}" method="GET" class="d-flex align-items-center gap-2">
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
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        @php
                        $avatars = ['1.png', '2.png', '3.png', '4.png', '5.png', '6.png', '7.png'];
                        $randomAvatar = $avatars[array_rand($avatars)];
                        @endphp

                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-4">
                                    <img src="{{ asset('materio/assets/img/avatars/' . $randomAvatar) }}" alt="Avatar"
                                        class="rounded-circle" />
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">{{ $user->name }}</h6>
                                    <small class="text-truncate">{{ $user->username ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span
                                    class="badge bg-label-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'kasir' ? 'info' : 'secondary') }} rounded-pill">
                                    {{ $user->role }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3 custom-container">
                <p class="mb-0">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}
                    entries</p>

                <div class="pagination-links">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>

                <form id="entriesForm" action="{{ route('users.index') }}" method="GET" class="form-container">
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
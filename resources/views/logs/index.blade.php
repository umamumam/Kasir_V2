@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Riwayat Log Aktivitas</h5>
            </div>
            <form action="{{ route('logs.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <div class="d-flex flex-column">
                    <label for="start_date" class="form-label">Mulai Tanggal</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" 
                        value="{{ $startDate }}">
                </div>
                <div class="d-flex flex-column">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" 
                        value="{{ $endDate }}">
                </div>
                <div class="d-flex flex-column">
                    <label class="form-label" style="opacity: 0;">Filter</label>
                    <button type="submit" class="btn btn-primary btn-sm px-3" style="height: calc(2.2em + .5rem + 2px);">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>

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

            <table class="table table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Waktu</th>
                        <th>Aktivitas</th>
                        <th>Entitas Terkait</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $log->activity }}</td>
                            <td>{{ class_basename($log->loggable_type) }} #{{ $log->loggable_id }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada log yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3 mb-3" style="margin-left: 10px;">
                <p class="mb-0">Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} entries</p>
                <div class="pagination-links">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

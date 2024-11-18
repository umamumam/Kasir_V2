{{-- resources/views/logs/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Riwayat Log Aktivitas</h3>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Aktivitas</th>
                <th>Entitas Terkait</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->activity }}</td>
                    <td>{{ class_basename($log->loggable_type) }} #{{ $log->loggable_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

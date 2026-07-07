@extends('layouts.app')
@section('title', 'Log Aktivitas')
@section('breadcrumb')<li class="breadcrumb-item active">Log Aktivitas</li>@endsection
@section('content')
<x-page-header title="Log Aktivitas" subtitle="Audit trail seluruh aktivitas pengguna sistem" />
<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="modul" class="form-select form-select-sm">
                <option value="">Semua Modul</option>
                @foreach($modulList as $m)<option value="{{ $m }}" @selected(request('modul')===$m)>{{ ucfirst($m) }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-3"><input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control form-control-sm"></div>
        <div class="col-md-2"><button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Filter</button></div>
    </form>
    @if($log->isEmpty())
        <x-empty-state icon="bi-clock-history" message="Belum ada aktivitas tercatat." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Waktu</th><th>User</th><th>Aktivitas</th><th>Modul</th><th>IP Address</th></tr></thead>
            <tbody>
            @foreach($log as $l)
                <tr>
                    <td>{{ $l->created_at->format('d-m-Y H:i') }}</td>
                    <td class="fw-semibold">{{ $l->user->name ?? 'Sistem' }}</td>
                    <td>{{ $l->aktivitas }}</td>
                    <td><span class="badge bg-light text-dark">{{ $l->modul }}</span></td>
                    <td>{{ $l->ip_address }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="small text-muted mb-0">Menampilkan {{ $log->firstItem() }}–{{ $log->lastItem() }} dari {{ $log->total() }} data</p>
        {{ $log->links() }}
    </div>
    @endif
</x-data-table>
@endsection

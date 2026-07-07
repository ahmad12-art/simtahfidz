@extends('layouts.app')
@section('title', 'Target Hafalan')
@section('breadcrumb')<li class="breadcrumb-item active">Target Hafalan</li>@endsection
@section('content')
<x-page-header title="Target Hafalan" subtitle="Kelola target hafalan santri">
    <x-slot:actions><a href="{{ route('target-hafalan.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Target</a></x-slot:actions>
</x-page-header>
<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                @foreach(['berjalan','selesai','terlambat'] as $st)
                    <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Filter</button></div>
    </form>
    @if($target->isEmpty())
        <x-empty-state icon="bi-bullseye" message="Belum ada target hafalan." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Santri</th><th>Guru</th><th>Surah</th><th>Ayat</th><th>Deadline</th><th>Progress</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @foreach($target as $t)
                <tr>
                    <td class="fw-semibold">{{ $t->santri->nama }}</td>
                    <td>{{ $t->guru->nama }}</td>
                    <td>{{ $t->surah->nama_surah }}</td>
                    <td>{{ $t->ayat_awal }}-{{ $t->ayat_akhir }}</td>
                    <td>{{ $t->deadline?->format('d-m-Y') ?? '-' }}</td>
                    <td style="width:140px;">
                        <div class="progress" style="height:6px;">
                            <div class="progress-bar bg-success" style="width:{{ $t->persentase_progress }}%"></div>
                        </div>
                        <small class="text-muted">{{ $t->persentase_progress }}%</small>
                    </td>
                    <td><span class="badge badge-status-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('target-hafalan.edit', $t) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('target-hafalan.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus target ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="small text-muted mb-0">Menampilkan {{ $target->firstItem() }}–{{ $target->lastItem() }} dari {{ $target->total() }} data</p>
        {{ $target->links() }}
    </div>
    @endif
</x-data-table>
@endsection

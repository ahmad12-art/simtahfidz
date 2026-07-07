@extends('layouts.app')
@section('title', 'Setoran Hafalan')
@section('breadcrumb')<li class="breadcrumb-item active">Setoran Hafalan</li>@endsection
@section('content')
<x-page-header title="Setoran Hafalan" subtitle="Riwayat setoran hafalan santri">
    <x-slot:actions><a href="{{ route('setoran.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Input Setoran</a></x-slot:actions>
</x-page-header>
<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3"><input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control form-control-sm"></div>
        <div class="col-md-3"><input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control form-control-sm"></div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                @foreach(['lancar','mengulang','belum_lancar'] as $st)
                    <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst(str_replace('_',' ',$st)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Filter</button></div>
    </form>
    @if($setoran->isEmpty())
        <x-empty-state icon="bi-mic" message="Belum ada data setoran." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Tanggal</th><th>Santri</th><th>Guru</th><th>Surah</th><th>Ayat</th><th>Nilai</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @foreach($setoran as $s)
                <tr>
                    <td>{{ $s->tanggal->format('d-m-Y') }}</td>
                    <td class="fw-semibold">{{ $s->santri->nama }}</td>
                    <td>{{ $s->guru->nama }}</td>
                    <td>{{ $s->surah->nama_surah }}</td>
                    <td>{{ $s->ayat_awal }}-{{ $s->ayat_akhir }}</td>
                    <td><span class="fw-bold">{{ $s->nilai_akhir }}</span></td>
                    <td><span class="badge badge-status-{{ $s->status }}">{{ ucfirst(str_replace('_',' ',$s->status)) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('setoran.edit', $s) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('setoran.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data setoran ini?')">
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
        <p class="small text-muted mb-0">Menampilkan {{ $setoran->firstItem() }}–{{ $setoran->lastItem() }} dari {{ $setoran->total() }} data</p>
        {{ $setoran->links() }}
    </div>
    @endif
</x-data-table>
@endsection

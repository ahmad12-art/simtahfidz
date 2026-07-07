@extends('layouts.app')

@section('title', 'Data Santri')

@section('breadcrumb')
    <li class="breadcrumb-item active">Santri</li>
@endsection

@section('content')
<x-page-header title="Data Santri" subtitle="Kelola data santri tahfidz">
    <x-slot:actions>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('santri.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Santri</a>
        @endif
    </x-slot:actions>
</x-page-header>

<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama / NIS / wali...">
        </div>
        <div class="col-md-3">
            <select name="kelas_id" class="form-select form-select-sm">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" @selected(request('kelas_id')==$k->id)>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                @foreach(['aktif','lulus','pindah','nonaktif'] as $st)
                    <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    @if($santri->isEmpty())
        <x-empty-state icon="bi-people" message="Belum ada data santri." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>#</th><th>Foto</th><th>NIS</th><th>Nama</th><th>Kelas</th><th>Wali</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($santri as $s)
                <tr>
                    <td>{{ $loop->iteration + ($santri->currentPage()-1)*$santri->perPage() }}</td>
                    <td><img src="{{ $s->foto_url }}" class="avatar-table" onerror="this.src='https://ui-avatars.com/api/?background=2563eb&color=fff&name={{ urlencode($s->nama) }}'"></td>
                    <td>{{ $s->nis }}</td>
                    <td class="fw-semibold">{{ $s->nama }}</td>
                    <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $s->nama_wali ?? '-' }}</td>
                    <td><span class="badge badge-status-{{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('santri.show', $s) }}" class="btn btn-sm btn-light" title="Detail"><i class="bi bi-eye"></i></a>
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('santri.edit', $s) }}" class="btn btn-sm btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('santri.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data santri {{ $s->nama }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="small text-muted mb-0">Menampilkan {{ $santri->firstItem() }}–{{ $santri->lastItem() }} dari {{ $santri->total() }} data</p>
        {{ $santri->links() }}
    </div>
    @endif
</x-data-table>
@endsection

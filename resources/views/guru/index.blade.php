@extends('layouts.app')

@section('title', 'Data Guru')

@section('breadcrumb')
    <li class="breadcrumb-item active">Guru</li>
@endsection

@section('content')
<x-page-header title="Data Guru" subtitle="Kelola data guru tahfidz">
    <x-slot:actions>
        <a href="{{ route('guru.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Guru</a>
    </x-slot:actions>
</x-page-header>

<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama / NIP / email...">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="aktif" @selected(request('status')==='aktif')>Aktif</option>
                <option value="nonaktif" @selected(request('status')==='nonaktif')>Nonaktif</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    @if($guru->isEmpty())
        <x-empty-state icon="bi-person-badge" message="Belum ada data guru." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th><th>Foto</th><th>NIP</th><th>Nama</th><th>Jenis Kelamin</th><th>No HP</th><th>Status</th><th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guru as $g)
                <tr>
                    <td>{{ $loop->iteration + ($guru->currentPage()-1)*$guru->perPage() }}</td>
                    <td><img src="{{ $g->foto_url }}" class="avatar-table" onerror="this.src='https://ui-avatars.com/api/?background=059669&color=fff&name={{ urlencode($g->nama) }}'"></td>
                    <td>{{ $g->nip }}</td>
                    <td class="fw-semibold">{{ $g->nama }}</td>
                    <td>{{ $g->jenis_kelamin }}</td>
                    <td>{{ $g->no_hp ?? '-' }}</td>
                    <td><span class="badge badge-status-{{ $g->status }}">{{ ucfirst($g->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('guru.show', $g) }}" class="btn btn-sm btn-light" title="Detail"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('guru.edit', $g) }}" class="btn btn-sm btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('guru.destroy', $g) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data guru {{ $g->nama }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="small text-muted mb-0">Menampilkan {{ $guru->firstItem() }}–{{ $guru->lastItem() }} dari {{ $guru->total() }} data</p>
        {{ $guru->links() }}
    </div>
    @endif
</x-data-table>
@endsection

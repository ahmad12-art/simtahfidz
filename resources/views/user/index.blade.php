@extends('layouts.app')
@section('title', 'Manajemen User')
@section('breadcrumb')<li class="breadcrumb-item active">User</li>@endsection
@section('content')
<x-page-header title="Manajemen User" subtitle="Kelola akun pengguna sistem">
    <x-slot:actions><a href="{{ route('user.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah User</a></x-slot:actions>
</x-page-header>
<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama / username..."></div>
        <div class="col-md-3">
            <select name="role_id" class="form-select form-select-sm">
                <option value="">Semua Role</option>
                @foreach($roles as $r)<option value="{{ $r->id }}" @selected(request('role_id')==$r->id)>{{ $r->nama }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Cari</button></div>
    </form>
    @if($users->isEmpty())
        <x-empty-state icon="bi-person-gear" message="Belum ada data user." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>#</th><th>Foto</th><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}</td>
                    <td><img src="https://ui-avatars.com/api/?background=059669&color=fff&name={{ urlencode($u->name) }}" class="avatar-table"></td>
                    <td class="fw-semibold">{{ $u->name }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge bg-light text-dark">{{ $u->role->nama ?? '-' }}</span></td>
                    <td><span class="badge badge-status-{{ $u->status }}">{{ ucfirst($u->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('user.edit', $u) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('user.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user {{ $u->name }}?')">
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
        <p class="small text-muted mb-0">Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} data</p>
        {{ $users->links() }}
    </div>
    @endif
</x-data-table>
@endsection

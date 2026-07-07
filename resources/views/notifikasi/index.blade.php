@extends('layouts.app')
@section('title', 'Notifikasi')
@section('breadcrumb')<li class="breadcrumb-item active">Notifikasi</li>@endsection
@section('content')
<x-page-header title="Notifikasi" subtitle="Daftar notifikasi sistem untuk Anda" />
<x-data-table>
    @if($notifikasi->isEmpty())
        <x-empty-state icon="bi-bell" message="Belum ada notifikasi." />
    @else
        @foreach($notifikasi as $n)
        <div class="d-flex justify-content-between align-items-start border-bottom py-3 {{ $n->dibaca ? '' : 'bg-light' }}">
            <div>
                <p class="mb-1 fw-semibold small">{{ $n->judul }}</p>
                <p class="mb-1 small text-muted">{{ $n->pesan }}</p>
                <p class="mb-0 small text-muted">{{ $n->created_at->diffForHumans() }}</p>
            </div>
            @unless($n->dibaca)
            <form method="POST" action="{{ route('notifikasi.read', $n) }}">
                @csrf @method('PATCH')
                <button class="btn btn-sm btn-outline-emerald">Tandai Dibaca</button>
            </form>
            @endunless
        </div>
        @endforeach
        <div class="mt-3">{{ $notifikasi->links() }}</div>
    @endif
</x-data-table>
@endsection

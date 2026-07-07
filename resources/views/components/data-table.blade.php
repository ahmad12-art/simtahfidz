{{-- Wrapper kartu generik untuk halaman index (search bar + table + pagination) --}}
@props(['title' => null])
<div class="card content-card">
    @if($title)
        <div class="card-header bg-white border-0 pt-3">
            <h6 class="fw-bold mb-0">{{ $title }}</h6>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>

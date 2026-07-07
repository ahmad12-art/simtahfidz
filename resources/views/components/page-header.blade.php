@props(['title', 'subtitle' => null])
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-0">{{ $title }}</h4>
        @if($subtitle)
            <p class="text-muted small mb-0">{{ $subtitle }}</p>
        @endif
    </div>
    <div class="d-flex gap-2">
        {{ $actions ?? '' }}
    </div>
</div>

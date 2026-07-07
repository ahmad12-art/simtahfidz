@props(['icon' => 'bi-inbox', 'message' => 'Belum ada data.'])
<div class="empty-state text-center py-5">
    <i class="bi {{ $icon }} empty-state-icon"></i>
    <p class="text-muted mt-2 mb-0">{{ $message }}</p>
    {{ $slot ?? '' }}
</div>

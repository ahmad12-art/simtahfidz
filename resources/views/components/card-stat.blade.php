@props(['icon' => 'bi-bar-chart', 'label' => '', 'value' => 0, 'color' => 'emerald'])
<div class="stat-card stat-{{ $color }}">
    <div class="stat-icon"><i class="bi {{ $icon }}"></i></div>
    <div>
        <p class="stat-value">{{ $value }}</p>
        <p class="stat-label">{{ $label }}</p>
    </div>
</div>

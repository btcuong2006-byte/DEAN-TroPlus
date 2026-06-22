@props(['name'])

@php
    $name = trim($name);
    $lower = Str::lower($name);
    $icon = 'bi-check-circle text-muted';
    
    if (str_contains($lower, 'wifi')) {
        $icon = 'bi-wifi text-primary';
    } elseif (str_contains($lower, 'máy lạnh') || str_contains($lower, 'điều hòa') || str_contains($lower, 'máy điều hoà')) {
        $icon = 'bi-snow text-info';
    } elseif (str_contains($lower, 'bảo vệ') || str_contains($lower, 'an ninh')) {
        $icon = 'bi-shield-check text-success';
    } elseif (str_contains($lower, 'gác')) {
        $icon = 'bi-house text-warning';
    } elseif (str_contains($lower, 'tủ lạnh')) {
        $icon = 'bi-cup-hot text-danger';
    } elseif (str_contains($lower, 'máy giặt')) {
        $icon = 'bi-water text-primary';
    } elseif (str_contains($lower, 'tự do') || str_contains($lower, 'không chung chủ')) {
        $icon = 'bi-key text-warning';
    } elseif (str_contains($lower, 'xe') || str_contains($lower, 'nhà xe') || str_contains($lower, 'bãi xe')) {
        $icon = 'bi-bicycle text-success';
    } elseif (str_contains($lower, 'toilet') || str_contains($lower, 'vệ sinh riêng') || str_contains($lower, 'wc riêng') || str_contains($lower, 'khép kín')) {
        $icon = 'bi-door-closed text-danger';
    } elseif (str_contains($lower, 'bếp') || str_contains($lower, 'nấu ăn')) {
        $icon = 'bi-fire text-danger';
    } elseif (str_contains($lower, 'ban công') || str_contains($lower, 'cửa sổ')) {
        $icon = 'bi-window text-info';
    }
@endphp

@if($name)
    <span {{ $attributes->merge(['class' => 'badge bg-light text-dark border']) }}>
        <i class="bi {{ $icon }} me-1"></i>{{ $name }}
    </span>
@endif

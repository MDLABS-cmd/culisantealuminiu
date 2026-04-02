@props([
    'colors' => collect(),
    'limit' => null,
    'size' => '20px',
])

@php
    $items = $limit ? collect($colors)->take($limit) : collect($colors);
@endphp

<div style="display: flex; gap: 4px; align-items: center;">
    @forelse ($items as $color)
        <x-color-swatch
            :hex="$color->hex_code"
            :name="$color->name"
            :size="$size"
        />
    @empty
        <span>—</span>
    @endforelse
</div>

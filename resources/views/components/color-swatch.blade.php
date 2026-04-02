@props([
    'hex' => null,
    'name' => null,
    'size' => '20px',
])

<div
    {{ $attributes }}
    @if($name) title="{{ $name }}" @endif
    style="background-color: {{ $hex }}; width: {{ $size }}; height: {{ $size }}; border-radius: 4px; border: 1px solid #ccc; flex-shrink: 0;"
></div>

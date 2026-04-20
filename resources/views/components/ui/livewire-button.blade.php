@props(['title', 'loadingTarget' => null, 'loadingTitle' => null])

<button
    {{ $attributes->class([
            'inline-flex items-center justify-center gap-2 transition focus:outline-none disabled:cursor-not-allowed disabled:opacity-70',
        ])->merge(['type' => 'button']) }}
    wire:loading.attr="disabled" @if (filled($loadingTarget)) wire:target="{{ $loadingTarget }}" @endif>
    <span wire:loading.remove @if (filled($loadingTarget)) wire:target="{{ $loadingTarget }}" @endif>
        {{ $title }}
    </span>

    <span class="hidden items-center gap-2" wire:loading.class.remove="hidden" wire:loading.class="inline-flex"
        @if (filled($loadingTarget)) wire:target="{{ $loadingTarget }}" @endif>
        <svg class="h-4 w-4 shrink-0 animate-spin text-white/90" viewBox="0 0 24 24" aria-hidden="true" fill="none">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3">
            </circle>
            <path class="opacity-100" fill="currentColor" d="M12 2a10 10 0 0 1 10 10h-3a7 7 0 0 0-7-7V2Z"></path>
        </svg>
        <span>{{ $loadingTitle ?? $title }}</span>
    </span>
</button>

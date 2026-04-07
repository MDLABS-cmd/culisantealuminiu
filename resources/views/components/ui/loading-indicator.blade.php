@props([
    'message' => 'Se incarca...',
    'target' => null,
    'show' => true,
])

@if ($show)
    <div {{ $attributes->class(['mt-4 hidden items-center justify-center']) }} wire:loading.class.remove="hidden"
        wire:loading.class="flex" @if (filled($target)) wire:target="{{ $target }}" @endif>
        <div
            class="flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm dark:bg-gray-800 dark:text-gray-200">
            <div
                class="h-4 w-4 animate-spin rounded-full border-2 border-gray-300 border-t-gray-900 dark:border-gray-600 dark:border-t-white">
            </div>
            <span>{{ $message }}</span>
        </div>
    </div>
@endif

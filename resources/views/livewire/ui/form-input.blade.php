<div @class(['fi-fo-field', $containerClass])>
    @if (filled($label))
        <label class="fi-fo-field-label">
            <span @class(['fi-fo-field-label-content', $labelClass])>
                {{ $label }}
            </span>
        </label>
    @endif

    <div @class(['fi-input-wrp', $wrapperClass])>
        <div class="fi-input-wrp-content-ctn">
            <input type="{{ $type }}" @if (filled($placeholder)) placeholder="{{ $placeholder }}" @endif
                @if (filled($step)) step="{{ $step }}" @endif
                @if (filled($min)) min="{{ $min }}" @endif
                @if (filled($max)) max="{{ $max }}" @endif wire:model="value"
                {{ $attributes->except('class')->class(['fi-input w-full', $inputClass]) }} />
        </div>
    </div>
</div>

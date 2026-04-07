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
            <select wire:model.live="value" @disabled($disabled)
                {{ $attributes->except('class')->class(['fi-select-input fi-input w-full border-0 bg-transparent focus:ring-0', $selectClass]) }}>
                @if (filled($placeholder))
                    <option value="">{{ $placeholder }}</option>
                @endif

                @foreach ($options as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

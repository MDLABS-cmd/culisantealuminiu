<div class="mt-4">
    <x-pricing.card-shell>
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col gap-2">
                <p class="font-['Poppins'] text-sm font-normal text-gray-500">
                    Data aplicarii: <span class="text-gray-900">{{ now()->format('d M Y') }}</span>
                </p>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                    <livewire:ui.form-input :key="'global-adjustment-input'" wire:model.blur="global_adjustment" type="number"
                        label="Ajustare globala" placeholder="Introdu ajustare" step="0.01"
                        containerClass="w-full sm:w-54" labelClass="text-[20px] font-normal leading-none" />

                    <livewire:ui.form-input :key="'hourly-rate-input'" wire:model.blur="hourly_rate" type="number"
                        label="PRET ORA" placeholder="Introdu pret ora" step="0.01" containerClass="w-full sm:w-49"
                        labelClass="text-[20px] font-normal uppercase leading-none" />
                </div>
            </div>

            <div class="flex lg:self-end">
                <button type="button" wire:click="save"
                    class="inline-flex h-11.25 items-center justify-center rounded-[14px] bg-gray-900 px-6 py-2 font-['Poppins'] text-sm font-normal text-white shadow-[0_1px_4px_0_rgba(12,12,13,0.05)] transition hover:bg-black">
                    Modifica ajustare
                </button>
            </div>
        </div>
    </x-pricing.card-shell>
</div>

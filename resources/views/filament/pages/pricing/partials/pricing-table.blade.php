<div class="mt-4">
    <x-filament::card class="rounded-t-xl rounded-b-none">
        <div class="max-h-128 overflow-x-auto overflow-y-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th
                            class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Height (mm)
                        </th>
                        <th
                            class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Width (mm)
                        </th>
                        <th
                            class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Material Cost
                        </th>
                        <th
                            class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Working Hours
                        </th>
                        <th
                            class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Working Cost
                        </th>
                        <th
                            class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Price w/o VAT
                        </th>
                        <th
                            class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Additional Cost
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($rows as $dimId => $row)
                        <tr class="bg-white hover:bg-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800">
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                {{ $row['height'] }}
                            </td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                {{ $row['width'] }}
                            </td>
                            <td class="px-3 py-2">
                                <x-filament::input.wrapper
                                    class="w-28 bg-white ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-white/15">
                                    <x-filament::input type="number" step="0.5" min="0"
                                        wire:model.live="rows.{{ $dimId }}.material_cost"
                                        class="text-center text-sm font-medium text-gray-900 placeholder:text-gray-400 dark:text-white" />
                                </x-filament::input.wrapper>
                            </td>
                            <td class="px-3 py-2">
                                <x-filament::input.wrapper
                                    class="w-28 bg-white ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-white/15">
                                    <x-filament::input type="number" step="0.5" min="0"
                                        wire:model.live="rows.{{ $dimId }}.working_hours"
                                        class="text-center text-sm font-medium text-gray-900 placeholder:text-gray-400 dark:text-white" />
                                </x-filament::input.wrapper>
                            </td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                {{ number_format($row['working_cost'], 2) }}
                            </td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                {{ number_format($row['price_without_vat'], 2) }}
                            </td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                {{ number_format($row['additional_cost'], 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </x-filament::card>
    <div class=" flex items-center justify-between rounded-b-xl bg-gray-400 px-6 py-1.5">
        <div class="flex items-center gap-4 text-xs text-white">
            <span>Ajustare globala: <strong>{{ number_format($this->global_adjustment, 2) }}</strong></span>
            <span>Pret ora: <strong>{{ number_format($this->hourly_rate, 2) }}</strong></span>
        </div>
        <button wire:click="savePricing"
            class="rounded-[14px] bg-gray-900 px-6 py-2 text-sm text-white shadow-sm hover:bg-gray-800 focus:outline-none">
            Salvare
        </button>
    </div>
</div>

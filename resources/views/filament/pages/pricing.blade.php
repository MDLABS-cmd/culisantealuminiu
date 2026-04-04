<x-filament-panels::page>
    <div class="flex gap-4">
        <div class="flex-1">
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="selectedSystem">
                    <option value="">-- Select System --</option>
                    @foreach ($this->getSystems() as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>

        <div class="flex-1">
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="selectedSchema" :disabled="!$selectedSystem">
                    <option value="">-- Select Schema --</option>
                    @foreach ($this->getSchemas() as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>
    </div>

    <div class="mt-4">
        <x-filament::card>
            <x-filament::input.wrapper label="Global Adjustment" prefix="$">
                <x-filament::input type="number" step="0.01" wire:model.blur="global_adjustment" />
            </x-filament::input.wrapper>

            <x-filament::input.wrapper label="Hourly Rate" prefix="$" class="mt-4">
                <x-filament::input type="number" step="0.01" wire:model.blur="hourly_rate" />
            </x-filament::input.wrapper>

            <div class="mt-4">
                <x-filament::button wire:click="save" color="primary">Save</x-filament::button>
            </div>
        </x-filament::card>
    </div>

    @if (!empty($rows))
        <div class="mt-4">
            <x-filament::card>
                <div class="overflow-x-auto">
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
                                @foreach ($materials as $material)
                                    <th
                                        class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        {{ $material['name'] }}
                                    </th>
                                @endforeach
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
                                    Adaos
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
                                    @foreach ($materials as $material)
                                        <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                            {{ number_format($row['material_prices'][$material['id']] ?? 0, 2) }}
                                        </td>
                                    @endforeach
                                    <td class="px-3 py-2">
                                        <x-filament::input type="number" step="0.5" min="0"
                                            wire:model.live="rows.{{ $dimId }}.working_hours" class="w-24" />
                                    </td>
                                    <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                        {{ number_format($row['working_cost'], 2) }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                        {{ number_format($row['price_without_vat'], 2) }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                        {{ number_format($row['adaos'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-end">
                    <x-filament::button wire:click="savePricing" color="primary">
                        Save Pricing
                    </x-filament::button>
                </div>
            </x-filament::card>
        </div>
    @endif
</x-filament-panels::page>

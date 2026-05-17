<x-filament-panels::page>
    @php
        /** @var \App\Models\ConfiguratorSubmission $submission */
        $submission = $this->getRecord();
        $customer = $submission->customer;
        $accessories = $submission->accessories;

        $color = $submission->color;
        $dimension = $submission->dimension;
        $typeLabel = $submission->type?->value === 'order' ? 'Comanda' : 'Cerere oferta';
        $submittedAt = $submission->submitted_at?->format('d.m.Y H:i') ?? '-';
    @endphp

    <div class="flex flex-col gap-14">

        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xl font-medium text-[#111827]">#{{ $submission->id }} — {{ $typeLabel }}</p>
                <p class="mt-1 text-sm text-[#6b7280]">Trimisă la {{ $submittedAt }}</p>
            </div>
        </div>

        {{-- Client Details --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="flex flex-col gap-2">
                <p class="text-base font-medium text-[#111827]">Companie</p>
                <div
                    class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                    <p class="text-sm text-[#111827]">{{ $customer?->company_name ?: '-' }}</p>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-base font-medium text-[#111827]">Nume și Prenume</p>
                <div
                    class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                    <p class="text-sm text-[#111827]">
                        {{ trim(($customer?->first_name ?? '') . ' ' . ($customer?->last_name ?? '')) ?: '-' }}
                    </p>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-base font-medium text-[#111827]">Adresa de livrare</p>
                <div
                    class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                    <p class="text-sm text-[#111827]">{{ $customer?->address ?: '-' }}</p>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-base font-medium text-[#111827]">Telefon</p>
                <div
                    class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                    <p class="text-sm text-[#111827]">{{ $customer?->phone ?: '-' }}</p>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-base font-medium text-[#111827]">Email</p>
                <div
                    class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                    <p class="text-sm text-[#111827]">{{ $customer?->email ?: '-' }}</p>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-base font-medium text-[#111827]">Observații (opțional)</p>
                <div
                    class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                    <p class="text-sm text-[#9ca3af]">{{ $submission->observations ?: 'Nu sunt observații' }}</p>
                </div>
            </div>
        </div>

        {{-- Configuration Cards --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            {{-- Sistem, schemă --}}
            <div class="flex flex-col items-center gap-4 rounded-2xl bg-white p-6">
                <p class="text-xl text-[#111827]">Sistem, schemă</p>
                <div class="flex w-full gap-4">
                    <div class="flex min-w-0 flex-1 flex-col gap-2">
                        <p class="text-base font-medium text-[#111827]">Sistem</p>
                        <div
                            class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                            <p class="text-sm text-[#111827]">{{ $submission->system?->name ?: '-' }}</p>
                        </div>
                    </div>
                    <div class="flex min-w-0 flex-1 flex-col gap-2">
                        <p class="text-base font-medium text-[#111827]">Schemă</p>
                        <div
                            class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                            <p class="text-sm text-[#111827]">{{ $submission->schema?->name ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Culoare --}}
            <div class="flex flex-col items-center gap-4 rounded-2xl bg-white p-6">
                <p class="text-xl text-[#111827]">Culoare</p>
                <div class="w-full">
                    @if ($color)
                        <div class="flex flex-col items-start rounded-xl">
                            <div class="h-36 w-44 rounded-xl"
                                style="background-color: {{ $color->hex_code ? '#' . ltrim($color->hex_code, '#') : '#d9d9d9' }}">
                            </div>
                            <div class="flex flex-col gap-0.5 px-2 pb-2 pt-1">
                                <p class="text-xs text-[#6b7280]">{{ $color->code ?: '' }}</p>
                                <p class="text-sm text-[#111827]">{{ $color->name }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-[#6b7280]">-</p>
                    @endif
                </div>
            </div>

            {{-- Dimensiuni --}}
            <div class="flex flex-col items-center gap-4 rounded-2xl bg-white p-6">
                <p class="text-xl text-[#111827]">Dimensiuni</p>
                <div class="flex w-full gap-4">
                    <div class="flex min-w-0 flex-1 flex-col gap-2">
                        <p class="text-base font-medium text-[#111827]">Înălțime</p>
                        <div
                            class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                            <p class="text-sm text-[#111827]">{{ $dimension ? $dimension->height . ' mm' : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex min-w-0 flex-1 flex-col gap-2">
                        <p class="text-base font-medium text-[#111827]">Lățime</p>
                        <div
                            class="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                            <p class="text-sm text-[#111827]">{{ $dimension ? $dimension->width . ' mm' : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Accesorii --}}
            <div class="flex flex-col items-center gap-4 rounded-2xl bg-white p-6">
                <p class="text-xl text-[#111827]">Accesorii</p>
                <div class="flex w-full flex-col gap-0.5">
                    @forelse ($accessories as $acc)
                        <div class="flex items-center gap-2">
                            <span class="size-1.5 shrink-0 rounded-full bg-[#111827]"></span>
                            <p class="text-sm text-[#111827]">{{ $acc->accesory?->name ?: '-' }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-[#6b7280]">Nu au fost selectate accesorii.</p>
                    @endforelse
                </div>
            </div>

            {{-- Mâner --}}
            <div class="flex flex-col items-center gap-4 rounded-2xl bg-white p-6">
                <p class="text-xl text-[#111827]">Mâner</p>
                <div class="flex w-full flex-col">
                    @if ($submission->handle)
                        <div class="flex items-center gap-2">
                            <span class="size-1.5 shrink-0 rounded-full bg-[#111827]"></span>
                            <p class="text-sm text-[#111827]">{{ $submission->handle->name }}</p>
                        </div>
                    @else
                        <p class="text-sm text-[#6b7280]">-</p>
                    @endif
                </div>
            </div>

            {{-- Opțiune Custom --}}
            <div class="flex flex-col items-center gap-4 rounded-2xl bg-white p-6">
                <p class="text-xl text-[#111827]">Opțiune Custom</p>
                <div class="flex w-full flex-col">
                    @if ($submission->customOption)
                        <div class="flex items-center gap-2">
                            <span class="size-1.5 shrink-0 rounded-full bg-[#111827]"></span>
                            <p class="text-sm text-[#111827]">{{ $submission->customOption->name }}</p>
                        </div>
                    @else
                        <p class="text-sm text-[#6b7280]">-</p>
                    @endif
                </div>
            </div>

            {{-- Preț --}}
            <div class="flex flex-col items-center gap-4 rounded-2xl bg-white p-6">
                <p class="text-xl text-[#111827]">Preț</p>
                <div class="flex w-full items-start gap-1">
                    <div class="flex flex-1 flex-col gap-0.5">
                        <div class="flex items-center gap-2">
                            <span class="size-1.5 shrink-0 rounded-full bg-[#111827]"></span>
                            <p class="text-sm text-[#111827]">
                                Dimensiune: {{ $dimension ? $dimension->width . 'x' . $dimension->height : '-' }}
                                (+{{ number_format((float) $submission->base_price, 2, ',', '.') }} EUR)
                            </p>
                        </div>
                        @foreach ($accessories as $acc)
                            <div class="flex items-center gap-2">
                                <span class="size-1.5 shrink-0 rounded-full bg-[#111827]"></span>
                                <p class="text-sm text-[#111827]">{{ $acc->accesory?->name ?: '-' }}</p>
                            </div>
                        @endforeach
                        @if ($submission->handle)
                            <div class="flex items-center gap-2">
                                <span class="size-1.5 shrink-0 rounded-full bg-[#111827]"></span>
                                <p class="text-sm text-[#111827]">
                                    {{ $submission->handle->name }}
                                    (+{{ number_format((float) $submission->handle_price, 2, ',', '.') }} EUR)
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col items-end justify-end self-stretch">
                        <p class="text-xs uppercase text-[#111827]">Preț total</p>
                        <p class="text-xl text-[#111827]">
                            {{ number_format((float) $submission->total_price, 2, ',', '.') }} EUR
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-filament-panels::page>

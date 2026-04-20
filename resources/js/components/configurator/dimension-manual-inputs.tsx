import type { DimensionWithPricing } from '@/types';

type DimensionManualInputsProps = {
    manualWidth: string;
    manualHeight: string;
    matchedDimension: DimensionWithPricing | null;
    onWidthChange: (value: string) => void;
    onHeightChange: (value: string) => void;
};

export function DimensionManualInputs({
    manualWidth,
    manualHeight,
    matchedDimension,
    onWidthChange,
    onHeightChange,
}: DimensionManualInputsProps) {
    return (
        <>
            <div className="mt-4 grid gap-3 md:grid-cols-2">
                <div>
                    <label
                        htmlFor="manual-width"
                        className="text-[11px] font-medium tracking-[0.18em] text-[#6b7280] uppercase"
                    >
                        Latime (mm)
                    </label>
                    <input
                        id="manual-width"
                        type="number"
                        min="1"
                        step="1"
                        value={manualWidth}
                        onChange={(event) => {
                            onWidthChange(event.target.value);
                        }}
                        placeholder="Ex: 1200"
                        className="mt-2 w-full rounded-[14px] border border-[#d1d5db] bg-white px-4 py-3 text-sm font-medium text-[#111827] transition outline-none focus:border-[#111827] focus:ring-2 focus:ring-[#111827]/10"
                    />
                </div>

                <div>
                    <label
                        htmlFor="manual-height"
                        className="text-[11px] font-medium tracking-[0.18em] text-[#6b7280] uppercase"
                    >
                        Inaltime (mm)
                    </label>
                    <input
                        id="manual-height"
                        type="number"
                        min="1"
                        step="1"
                        value={manualHeight}
                        onChange={(event) => {
                            onHeightChange(event.target.value);
                        }}
                        placeholder="Ex: 2100"
                        className="mt-2 w-full rounded-[14px] border border-[#d1d5db] bg-white px-4 py-3 text-sm font-medium text-[#111827] transition outline-none focus:border-[#111827] focus:ring-2 focus:ring-[#111827]/10"
                    />
                </div>
            </div>

            <p className="mt-3 text-sm text-[#4b5563]">
                {matchedDimension
                    ? `Dimensiune selectata prin rotunjire: ${matchedDimension.width} x ${matchedDimension.height} mm`
                    : 'Introdu latimea si inaltimea pentru a gasi dimensiunea disponibila potrivita.'}
            </p>
        </>
    );
}

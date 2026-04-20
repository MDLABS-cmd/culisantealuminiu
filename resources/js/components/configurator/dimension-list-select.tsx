import { useConfigurator } from '@/hooks/use-configurator';

export function DimensionListSelect() {
    const {
        state: { options, selectedDimensionId },
        selectDimension,
    } = useConfigurator();
    const dimensions = options?.dimensions ?? [];

    return (
        <>
            <label
                htmlFor="dimension-selector"
                className="mt-4 block text-[11px] font-medium tracking-[0.18em] text-[#6b7280] uppercase"
            >
                Dimensiuni
            </label>
            <select
                id="dimension-selector"
                value={selectedDimensionId ?? ''}
                onChange={(event) => {
                    const value = Number(event.target.value);

                    if (Number.isFinite(value) && value > 0) {
                        selectDimension(value);
                    }
                }}
                className="mt-2 w-full rounded-[14px] border border-[#d1d5db] bg-white px-4 py-3 text-sm font-medium text-[#111827] transition outline-none focus:border-[#111827] focus:ring-2 focus:ring-[#111827]/10"
            >
                <option value="">Selecteaza dimensiunile</option>
                {dimensions.map((dimension) => {
                    const price = dimension.pricing?.price_without_vat ?? 0;

                    return (
                        <option key={dimension.id} value={dimension.id}>
                            {dimension.width} x {dimension.height} mm -{' '}
                            {Number(price).toFixed(2)}
                        </option>
                    );
                })}
            </select>
        </>
    );
}

import type { DimensionWithPricing } from '@/types';

type DimensionSelectorProps = {
    dimensions: DimensionWithPricing[];
    selectedDimensionId: number | null;
    loading: boolean;
    onSelect: (dimensionId: number) => void;
};

export function DimensionSelector({
    dimensions,
    selectedDimensionId,
    loading,
    onSelect,
}: DimensionSelectorProps) {
    if (loading) {
        return (
            <div className="mt-4 grid gap-3 md:grid-cols-2">
                {Array.from({ length: 4 }).map((_, index) => (
                    <div
                        key={index}
                        className="h-28 animate-pulse rounded-[20px] border border-[#e5e7eb] bg-[#f5f5f4]"
                    />
                ))}
            </div>
        );
    }

    if (dimensions.length === 0) {
        return (
            <p className="mt-3 text-sm text-[#6b7280]">
                No dimensions available for this schema.
            </p>
        );
    }

    return (
        <div className="mt-4">
            <label
                htmlFor="dimension-selector"
                className="text-[11px] font-medium tracking-[0.18em] text-[#6b7280] uppercase"
            >
                Dimensions
            </label>
            <select
                id="dimension-selector"
                value={selectedDimensionId ?? ''}
                onChange={(event) => {
                    const value = Number(event.target.value);

                    if (Number.isFinite(value) && value > 0) {
                        onSelect(value);
                    }
                }}
                className="mt-2 w-full rounded-[14px] border border-[#d1d5db] bg-white px-4 py-3 text-sm font-medium text-[#111827] transition outline-none focus:border-[#111827] focus:ring-2 focus:ring-[#111827]/10"
            >
                <option value="">Select dimensions</option>
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
        </div>
    );
}

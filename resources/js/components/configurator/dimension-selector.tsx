import { useConfigurator } from '@/hooks/use-configurator';
import { DimensionListSelect } from './dimension-list-select';
import { DimensionManualInputs } from './dimension-manual-inputs';
import { useDimensionSelector } from '@/hooks/use-dimension-selector';

export function DimensionSelector() {
    const {
        state: { options, loadingOptions },
    } = useConfigurator();
    const dimensions = options?.dimensions ?? [];

    const {
        useDimensionList,
        manualWidth,
        manualHeight,
        matchedDimension,
        setManualWidth,
        setManualHeight,
        handleModeChange,
    } = useDimensionSelector({
        dimensions,
    });

    if (loadingOptions) {
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
                Nu exista dimensiuni disponibile pentru aceasta schema.
            </p>
        );
    }

    return (
        <div className="mt-4">
            <label className="flex items-center gap-3 text-sm font-medium text-[#111827]">
                <input
                    type="checkbox"
                    checked={useDimensionList}
                    onChange={(event) => {
                        handleModeChange(event.target.checked);
                    }}
                    className="h-4 w-4 rounded border-[#d1d5db] text-[#111827] focus:ring-[#111827]/20"
                />
                Selecteaza dimensiunile din lista noastra
            </label>

            {useDimensionList ? (
                <DimensionListSelect />
            ) : (
                <DimensionManualInputs
                    manualWidth={manualWidth}
                    manualHeight={manualHeight}
                    matchedDimension={matchedDimension}
                    onWidthChange={setManualWidth}
                    onHeightChange={setManualHeight}
                />
            )}
        </div>
    );
}

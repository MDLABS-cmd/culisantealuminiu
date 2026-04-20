import { SelectionCheckboxCard } from '@/components/selection-checkbox-card';
import { EmptyState } from '@/components/ui/empty-state';
import type { Accesory } from '@/types';

type AccesorySelectorProps = {
    accesories: Accesory[];
    selectedAccesoryIds: number[];
    loading: boolean;
    onToggle: (accesoryId: number) => void;
};

export function AccesorySelector({
    accesories,
    selectedAccesoryIds,
    loading,
    onToggle,
}: AccesorySelectorProps) {
    if (loading) {
        return (
            <div className="mt-4 space-y-3">
                {Array.from({ length: 3 }).map((_, index) => (
                    <div
                        key={index}
                        className="h-18 animate-pulse rounded-[18px] border border-[#e5e7eb] bg-[#f5f5f4]"
                    />
                ))}
            </div>
        );
    }

    if (accesories.length === 0) {
        return <EmptyState title="No accessories available" />;
    }

    return (
        <div className="mt-4 space-y-3">
            {accesories.map((accesory) => {
                const selected = selectedAccesoryIds.includes(accesory.id);

                return (
                    <SelectionCheckboxCard
                        key={accesory.id}
                        checked={selected}
                        onChange={() => onToggle(accesory.id)}
                        title={accesory.name}
                        description="Optional add-on"
                        aside={
                            <span className="font-semibold text-[#111827]">
                                {Number(accesory.price).toFixed(2)}
                            </span>
                        }
                        className="rounded-xl border-[0.5px] border-[#e5e7eb] px-4 py-3"
                        titleClassName="font-medium"
                    />
                );
            })}
        </div>
    );
}

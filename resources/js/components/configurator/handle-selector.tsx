import { SelectionCheckboxCard } from '@/components/selection-checkbox-card';
import { EmptyState } from '@/components/ui/empty-state';
import type { Handle } from '@/types';

type HandleSelectorProps = {
    handles: Handle[];
    selectedHandleId: number | null;
    loading: boolean;
    onSelect: (handleId: number) => void;
};

export function HandleSelector({
    handles,
    selectedHandleId,
    loading,
    onSelect,
}: HandleSelectorProps) {
    if (loading) {
        return (
            <div className="mt-4 grid gap-3 md:grid-cols-2">
                {Array.from({ length: 4 }).map((_, index) => (
                    <div
                        key={index}
                        className="h-24 animate-pulse rounded-[20px] border border-[#e5e7eb] bg-[#f5f5f4]"
                    />
                ))}
            </div>
        );
    }

    if (handles.length === 0) {
        return <EmptyState title="Nu există mânere disponibile" />;
    }

    return (
        <div className="mt-4 space-y-3">
            {handles.map((handle) => (
                <SelectionCheckboxCard
                    key={handle.id}
                    checked={selectedHandleId === handle.id}
                    onChange={() => onSelect(handle.id)}
                    title={handle.name}
                    description={handle.type}
                    aside={
                        <span className="text-sm font-semibold text-[#111827]">
                            {Number(handle.price).toFixed(2)}
                        </span>
                    }
                    className="rounded-xl border-[0.5px] border-[#e5e7eb] px-4 py-3"
                />
            ))}
        </div>
    );
}

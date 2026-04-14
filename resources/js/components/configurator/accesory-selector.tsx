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
        return (
            <p className="mt-3 text-sm text-[#6b7280]">
                No accessories available.
            </p>
        );
    }

    return (
        <div className="mt-4 space-y-3">
            {accesories.map((accesory) => {
                const selected = selectedAccesoryIds.includes(accesory.id);

                return (
                    <label
                        key={accesory.id}
                        className={`flex w-full cursor-pointer items-start justify-between gap-3 rounded-2xl border px-4 py-3 text-left text-sm transition ${
                            selected
                                ? 'border-[#111827] bg-[#f9fafb]'
                                : 'border-[#e5e7eb] bg-white hover:border-[#d1d5db] hover:bg-[#fafaf9]'
                        }`}
                    >
                        <span className="flex items-start gap-3">
                            <input
                                type="checkbox"
                                checked={selected}
                                onChange={() => onToggle(accesory.id)}
                                className="mt-0.5 h-4 w-4 rounded border-[#cbd5e1] text-[#111827] focus:ring-[#111827]/20"
                            />
                            <span>
                                <span className="block font-medium text-[#111827]">
                                    {accesory.name}
                                </span>
                                <span className="mt-1 block text-xs text-[#6b7280]">
                                    Optional add-on
                                </span>
                            </span>
                        </span>
                        <span className="font-semibold text-[#111827]">
                            {Number(accesory.price).toFixed(2)}
                        </span>
                    </label>
                );
            })}
        </div>
    );
}

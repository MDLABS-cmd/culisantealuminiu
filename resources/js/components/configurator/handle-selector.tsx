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
        return (
            <p className="mt-3 text-sm text-[#6b7280]">No handles available.</p>
        );
    }

    return (
        <div className="mt-4 space-y-3">
            {handles.map((handle) => (
                <label
                    key={handle.id}
                    className={`flex cursor-pointer items-start justify-between gap-3 rounded-2xl border px-4 py-3 text-left text-sm transition ${
                        selectedHandleId === handle.id
                            ? 'border-[#111827] bg-[#f9fafb]'
                            : 'border-[#e5e7eb] bg-white hover:border-[#d1d5db] hover:bg-[#fafaf9]'
                    }`}
                >
                    <div className="flex items-start gap-3">
                        <input
                            type="checkbox"
                            checked={selectedHandleId === handle.id}
                            onChange={() => onSelect(handle.id)}
                            className="mt-0.5 h-4 w-4 rounded border-[#cbd5e1] text-[#111827] focus:ring-[#111827]/20"
                        />
                        <span>
                            <span className="block font-semibold text-[#111827]">
                                {handle.name}
                            </span>
                            <span className="mt-1 block text-xs text-[#6b7280]">
                                {handle.type}
                            </span>
                        </span>
                    </div>
                    <span className="text-sm font-semibold text-[#111827]">
                        {Number(handle.price).toFixed(2)}
                    </span>
                </label>
            ))}
        </div>
    );
}

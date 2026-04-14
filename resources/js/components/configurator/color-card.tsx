import type { Color } from '@/types';

type ColorCardProps = {
    color: Color;
    selected: boolean;
    onSelect: () => void;
};

export function ColorCard({ color, selected, onSelect }: ColorCardProps) {
    return (
        <button
            type="button"
            onClick={onSelect}
            aria-pressed={selected}
            className={`w-46 shrink-0 overflow-hidden rounded-[10px] border text-left transition`}
        >
            <span
                className="block h-32 w-full"
                style={{ backgroundColor: color.hex_code }}
            />

            <span className="mt-2 block min-h-14 px-2 py-1">
                <div className="flex items-center justify-between">
                    <span className="block text-xs text-[#6b7280]">
                        {color.code}
                    </span>
                    <span
                        className={`flex size-4 items-center justify-center rounded-full border-[1.5px] ${
                            selected ? 'border-[#6b7280]' : 'border-[#9ca3af]'
                        }`}
                        aria-hidden="true"
                    >
                        <span
                            className={`size-2 rounded-full transition-colors ${
                                selected ? 'bg-[#6b7280]' : 'bg-transparent'
                            }`}
                        />
                    </span>
                </div>
                <span className="mt-1 block text-sm font-normal text-[#111827]">
                    {color.name}
                </span>
            </span>
        </button>
    );
}

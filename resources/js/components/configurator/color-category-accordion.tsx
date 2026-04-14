import { Accordion } from '@/components/ui/accordion';
import type { ColorCategoryWithColors } from '@/types';
import { ColorCard } from './color-card';

type ColorCategoryAccordionProps = {
    category: ColorCategoryWithColors;
    isOpen: boolean;
    selectedColorId: number | null;
    onToggle: () => void;
    onSelectColor: (colorId: number) => void;
};

export function ColorCategoryAccordion({
    category,
    isOpen,
    selectedColorId,
    onToggle,
    onSelectColor,
}: ColorCategoryAccordionProps) {
    return (
        <Accordion
            title={category.name}
            open={isOpen}
            onOpenChange={onToggle}
            className="overflow-hidden rounded-xl border-[0.5px] border-[#e5e7eb] bg-white shadow-[0_1px_4px_0_rgba(12,12,13,0.05)]"
            triggerClassName="flex h-11 w-full items-center justify-between px-6 text-left"
            titleClassName="text-sm font-normal text-[#111827]"
            contentClassName="border-t border-[#e5e7eb] p-4"
            iconClassName="text-[#9ca3af]"
        >
            <div className="flex flex-wrap gap-3">
                {category.colors.map((color) => (
                    <ColorCard
                        key={color.id}
                        color={color}
                        selected={selectedColorId === color.id}
                        onSelect={() => onSelectColor(color.id)}
                    />
                ))}
            </div>
        </Accordion>
    );
}

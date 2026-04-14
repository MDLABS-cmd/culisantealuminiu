import { useState } from 'react';
import type { ColorCategoryWithColors } from '@/types';
import { ColorCategoryAccordion } from './color-category-accordion';

type ColorSelectorProps = {
    categories: ColorCategoryWithColors[];
    selectedColorIdsByCategory: Record<number, number | null>;
    loading: boolean;
    onSelect: (categoryId: number, colorId: number) => void;
};

export function ColorSelector({
    categories,
    selectedColorIdsByCategory,
    loading,
    onSelect,
}: ColorSelectorProps) {
    const [openCategoryId, setOpenCategoryId] = useState<number | null>(null);
    const activeCategoryId =
        openCategoryId &&
        categories.some((category) => category.id === openCategoryId)
            ? openCategoryId
            : (categories[0]?.id ?? null);

    if (loading) {
        return (
            <div className="mt-4 space-y-3">
                {Array.from({ length: 3 }).map((_, index) => (
                    <div
                        key={index}
                        className="h-28 animate-pulse rounded-[20px] border border-[#e5e7eb] bg-[#f5f5f4]"
                    />
                ))}
            </div>
        );
    }

    if (categories.length === 0) {
        return (
            <p className="mt-3 text-sm text-[#6b7280]">
                No color options available.
            </p>
        );
    }

    return (
        <div className="mt-4 space-y-3">
            {categories.map((category) => (
                <ColorCategoryAccordion
                    key={category.id}
                    category={category}
                    isOpen={activeCategoryId === category.id}
                    selectedColorId={selectedColorIdsByCategory[category.id]}
                    onToggle={() =>
                        setOpenCategoryId((previous) =>
                            previous === category.id ? null : category.id,
                        )
                    }
                    onSelectColor={(colorId) => onSelect(category.id, colorId)}
                />
            ))}
        </div>
    );
}

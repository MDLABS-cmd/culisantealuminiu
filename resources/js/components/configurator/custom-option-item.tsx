import { useConfigurator } from '@/hooks/use-configurator';
import type { CustomOption } from '@/types';
import { Button } from '../ui/button';

type CustomOptionItemProps = {
    option: CustomOption;
};

export function CustomOptionItem({ option }: CustomOptionItemProps) {
    const { state, toggleCustomOption } = useConfigurator();
    const isSelected = state.selectedCustomOptionIds.includes(option.id);

    const handleSelectCustomOption = () => {
        toggleCustomOption(option.id);
    };

    return (
        <div className="flex w-full flex-col gap-3 sm:flex-row sm:items-center sm:gap-10">
            <div className="flex h-10 w-full items-center rounded-xl border-[0.5px] border-[#e5e7eb] bg-white px-4 shadow-[0_1px_4px_0_rgba(12,12,13,0.05)] sm:flex-1">
                <span className="w-full text-center text-sm font-normal text-[#111827]">
                    {option.name}
                </span>
            </div>
            <Button
                onClick={handleSelectCustomOption}
                className="h-10 w-full sm:w-80"
                variant={isSelected ? 'customOutline' : 'dark'}
                size="default"
            >
                {isSelected ? 'Selectat' : 'Cere ofertă'}
            </Button>
        </div>
    );
}

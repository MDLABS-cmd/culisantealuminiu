import type { CustomOption } from '@/types';
import { EmptyState } from '../ui/empty-state';
import { CustomOptionItem } from './custom-option-item';

type CustomOptionsListProps = {
    customOptions: CustomOption[];
};

export function CustomOptionsList({ customOptions }: CustomOptionsListProps) {
    if (customOptions.length === 0) {
        return <EmptyState title="Nu există opțiuni personalizate" />;
    }

    return (
        <div className="space-y-4">
            {customOptions.map((option) => (
                <CustomOptionItem key={option.id} option={option} />
            ))}
        </div>
    );
}

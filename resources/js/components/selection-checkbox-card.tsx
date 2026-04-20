import type { ReactNode } from 'react';
import { cn } from '@/lib/utils';

type SelectionCheckboxCardProps = {
    checked: boolean;
    onChange: () => void;
    title: ReactNode;
    description?: ReactNode;
    aside?: ReactNode;
    className?: string;
    titleClassName?: string;
    descriptionClassName?: string;
    inputClassName?: string;
};

export function SelectionCheckboxCard({
    checked,
    onChange,
    title,
    description,
    aside,
    className,
    titleClassName,
    descriptionClassName,
    inputClassName,
}: SelectionCheckboxCardProps) {
    return (
        <label
            className={cn(
                'flex cursor-pointer items-start justify-between gap-3 text-left text-sm transition',
                className,
            )}
        >
            <div className="flex items-start gap-3">
                <input
                    type="checkbox"
                    checked={checked}
                    onChange={onChange}
                    className={cn(
                        'mt-0.5 h-4 w-4 rounded border-[#cbd5e1] text-[#111827] focus:ring-[#111827]/20',
                        inputClassName,
                    )}
                />
                <span>
                    <span
                        className={cn(
                            'block font-semibold text-[#111827]',
                            titleClassName,
                        )}
                    >
                        {title}
                    </span>
                    {description ? (
                        <span
                            className={cn(
                                'mt-1 block text-xs text-[#6b7280]',
                                descriptionClassName,
                            )}
                        >
                            {description}
                        </span>
                    ) : null}
                </span>
            </div>
            {aside ? aside : null}
        </label>
    );
}

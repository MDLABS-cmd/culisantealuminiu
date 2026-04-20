import type { ReactNode } from 'react';

import { cn } from '@/lib/utils';

type EmptyStateProps = {
    icon?: ReactNode;
    title: ReactNode;
    description?: ReactNode;
    action?: ReactNode;
    className?: string;
    titleClassName?: string;
    descriptionClassName?: string;
};

export function EmptyState({
    icon,
    title,
    description,
    action,
    className,
    titleClassName,
    descriptionClassName,
}: EmptyStateProps) {
    return (
        <div
            className={cn(
                'flex flex-col items-center justify-center gap-3 py-8 text-center',
                className,
            )}
        >
            {icon ? <div className="text-[#9ca3af]">{icon}</div> : null}
            <h3
                className={cn(
                    'text-sm font-semibold text-[#111827]',
                    titleClassName,
                )}
            >
                {title}
            </h3>
            {description ? (
                <p
                    className={cn(
                        'text-xs text-[#6b7280]',
                        descriptionClassName,
                    )}
                >
                    {description}
                </p>
            ) : null}
            {action ? <div className="mt-2">{action}</div> : null}
        </div>
    );
}

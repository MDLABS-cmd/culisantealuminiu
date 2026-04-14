import { cn } from '@/lib/utils';

type SectionProps = {
    title: string;
    description?: string;
    className?: string;
    titleClassName?: string;
    descriptionClassName?: string;
    children: React.ReactNode;
};

export function Section({
    title,
    description,
    className,
    titleClassName,
    descriptionClassName,
    children,
}: SectionProps) {
    return (
        <section
            className={cn(
                'rounded-xl border border-[#e5e7eb] bg-white p-5 md:p-6',
                className,
            )}
        >
            <h2
                className={cn(
                    'text-lg font-semibold text-[#111827]',
                    titleClassName,
                )}
            >
                {title}
            </h2>
            {description && (
                <p
                    className={cn(
                        'mt-2 text-sm text-[#6b7280]',
                        descriptionClassName,
                    )}
                >
                    {description}
                </p>
            )}
            {children}
        </section>
    );
}

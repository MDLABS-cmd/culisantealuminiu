import type { PropsWithChildren } from 'react';
import { AppHeader } from '@/components/app-header';
import { cn } from '@/lib/utils';
import type { BreadcrumbItem } from '@/types';

type ConfiguratorLayoutProps = PropsWithChildren<{
    breadcrumbs?: BreadcrumbItem[];
    noPadding?: boolean;
}>;

export default function ConfiguratorLayout({
    children,
    breadcrumbs = [],
    noPadding = false,
}: ConfiguratorLayoutProps) {
    return (
        <div className="min-h-screen bg-[#f9fafb] text-[#111827]">
            <AppHeader breadcrumbs={breadcrumbs} />
            <main
                className={cn(
                    'mx-auto w-full',
                    noPadding
                        ? ''
                        : 'max-w-450 px-4 py-6 md:px-8 md:py-8 xl:px-30',
                )}
            >
                {children}
            </main>
        </div>
    );
}

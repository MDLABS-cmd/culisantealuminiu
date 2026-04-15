import type { PropsWithChildren } from 'react';
import { AppHeader } from '@/components/app-header';
import type { BreadcrumbItem } from '@/types';

type ConfiguratorLayoutProps = PropsWithChildren<{
    breadcrumbs?: BreadcrumbItem[];
}>;

export default function ConfiguratorLayout({
    children,
    breadcrumbs = [],
}: ConfiguratorLayoutProps) {
    return (
        <div className="min-h-screen bg-[#f9fafb] text-[#111827]">
            <AppHeader breadcrumbs={breadcrumbs} />
            <main className="mx-auto w-full max-w-450 px-4 py-6 md:px-8 md:py-8 xl:px-30">
                {children}
            </main>
        </div>
    );
}

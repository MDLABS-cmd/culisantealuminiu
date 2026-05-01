import { Link } from '@inertiajs/react';
import { cn } from '@/lib/utils';
import type { System } from '@/types';

type SystemsLinksVariant = 'mobile' | 'desktop' | 'sidebar';

type SystemsLinksProps = {
    systems: System[];
    selectedSystemId?: number;
    homeUrl: string;
    variant: SystemsLinksVariant;
};

export function normalizeSystems(input: unknown): System[] {
    if (!Array.isArray(input)) {
        return [];
    }

    return (input as System[]).filter(
        (system): system is System =>
            Boolean(system) &&
            typeof system.id === 'number' &&
            Number.isFinite(system.id),
    );
}

export function SystemsLinks({
    systems,
    selectedSystemId,
    homeUrl,
    variant,
}: SystemsLinksProps) {
    if (systems.length === 0) {
        return null;
    }

    if (variant === 'mobile') {
        return (
            <div className="mt-6 space-y-2">
                {systems.map((system) => (
                    <Link
                        key={`mobile-system-${system.id}`}
                        href={`${homeUrl}?system=${system.id}`}
                        className={cn(
                            'block rounded-md px-3 py-2 text-sm font-medium text-[#111827]',
                            selectedSystemId === system.id &&
                                'bg-[#111827] text-white',
                        )}
                    >
                        {system.name}
                    </Link>
                ))}
            </div>
        );
    }

    if (variant === 'desktop') {
        return (
            <div className="absolute top-1/2 left-1/2 hidden -translate-x-1/2 -translate-y-1/2 items-center gap-5 lg:flex">
                {systems.map((system) => (
                    <Link
                        key={`desktop-system-${system.id}`}
                        href={`${homeUrl}?system=${system.id}`}
                        className="poppins-medium relative pb-1 text-[14px] leading-6 text-black"
                    >
                        {system.name}
                        {selectedSystemId === system.id && (
                            <span className="absolute bottom-0 left-0 h-0.75 w-full bg-[#111827]" />
                        )}
                    </Link>
                ))}
            </div>
        );
    }

    return (
        <div className="flex items-center gap-2 overflow-x-auto px-2 pb-2">
            {systems.map((system) => (
                <Link
                    key={`sidebar-system-${system.id}`}
                    href={`${homeUrl}?system=${system.id}`}
                    className={cn(
                        'rounded-md border px-3 py-1.5 text-xs font-medium whitespace-nowrap transition-colors',
                        selectedSystemId === system.id
                            ? 'border-[#111827] bg-[#111827] text-white'
                            : 'border-[#d1d5db] bg-white text-[#111827] hover:bg-[#f3f4f6]',
                    )}
                >
                    {system.name}
                </Link>
            ))}
        </div>
    );
}

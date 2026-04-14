import { Link, usePage } from '@inertiajs/react';
import { CircleUserRound, Menu, RotateCcw } from 'lucide-react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import { UserMenuContent } from '@/components/user-menu-content';
import { cn, toUrl } from '@/lib/utils';
import { configurator, login } from '@/routes';
import type { BreadcrumbItem, System } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

const brandTitle = 'NZEB WINDOWS';
const brandSubtitle = 'CULISANTE CU RIDICARE DIN ALUMINIU';

function normalizeSystems(input: unknown): System[] {
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

export function AppHeader({ breadcrumbs = [] }: Props) {
    const page = usePage();
    const { auth, activeSystems } = page.props;
    const authUser = auth?.user;
    const systems = normalizeSystems(activeSystems);
    const configuratorUrl = toUrl(configurator());

    const currentParams = new URLSearchParams(page.url.split('?')[1] ?? '');
    const selectedSystemId =
        Number(currentParams.get('system')) || systems[0]?.id;

    return (
        <>
            <div className="relative border-b border-zinc-200 bg-white shadow-[0px_1px_2px_0px_rgba(0,0,0,0.3),0px_1px_3px_0px_rgba(0,0,0,0.15)]">
                <div className="mx-auto flex h-14 items-center px-4 md:px-8 xl:px-30">
                    <div className="mr-2 lg:hidden">
                        <Sheet>
                            <SheetTrigger asChild>
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    className="h-8.5 w-8.5"
                                >
                                    <Menu className="h-5 w-5" />
                                </Button>
                            </SheetTrigger>
                            <SheetContent side="left" className="w-72 bg-white">
                                <SheetTitle className="sr-only">
                                    Navigation menu
                                </SheetTitle>
                                <SheetHeader className="text-left">
                                    <div>
                                        <p
                                            className="text-base leading-none font-medium text-[#111827]"
                                            style={{
                                                fontFamily:
                                                    'Poppins, sans-serif',
                                            }}
                                        >
                                            {brandTitle}
                                        </p>
                                        <p
                                            className="mt-1 text-[12px] leading-none text-[#111827]"
                                            style={{
                                                fontFamily:
                                                    'Poppins, sans-serif',
                                            }}
                                        >
                                            {brandSubtitle}
                                        </p>
                                    </div>
                                </SheetHeader>

                                <div className="mt-6 space-y-2">
                                    {systems.map((system, index) => (
                                        <Link
                                            key={`mobile-system-${system.id}-${index}`}
                                            href={`${configuratorUrl}?system=${system.id}`}
                                            className={cn(
                                                'block rounded-md px-3 py-2 text-sm font-medium text-[#111827]',
                                                selectedSystemId ===
                                                    system.id &&
                                                    'bg-[#111827] text-white',
                                            )}
                                        >
                                            {system.name}
                                        </Link>
                                    ))}
                                </div>
                            </SheetContent>
                        </Sheet>
                    </div>

                    <Link href={configurator()} prefetch className="shrink-0">
                        <p
                            className="text-base leading-none font-medium text-[#111827]"
                            style={{ fontFamily: 'Poppins, sans-serif' }}
                        >
                            {brandTitle}
                        </p>
                        <p
                            className="mt-1 text-[12px] leading-none text-[#111827]"
                            style={{ fontFamily: 'Poppins, sans-serif' }}
                        >
                            {brandSubtitle}
                        </p>
                    </Link>

                    <div className="absolute top-1/2 left-1/2 hidden -translate-x-1/2 -translate-y-1/2 items-center gap-5 lg:flex">
                        {systems.map((system, index) => (
                            <Link
                                key={`desktop-system-${system.id}-${index}`}
                                href={`${configuratorUrl}?system=${system.id}`}
                                className="relative pb-1 text-[14px] leading-6 font-medium text-black"
                                style={{ fontFamily: 'Poppins, sans-serif' }}
                            >
                                {system.name}
                                {selectedSystemId === system.id && (
                                    <span className="absolute bottom-0 left-0 h-0.75 w-full bg-[#111827]" />
                                )}
                            </Link>
                        ))}
                    </div>

                    <div className="ml-auto flex items-center gap-2">
                        <Button
                            variant="ghost"
                            size="icon"
                            asChild
                            className="h-9 w-9"
                        >
                            <Link href={configurator()} preserveScroll>
                                <RotateCcw className="h-6 w-6 text-[#111827]" />
                                <span className="sr-only">Reset</span>
                            </Link>
                        </Button>

                        {authUser ? (
                            <DropdownMenu>
                                <DropdownMenuTrigger asChild>
                                    <Button
                                        variant="ghost"
                                        size="icon"
                                        className="h-9 w-9"
                                    >
                                        <CircleUserRound className="h-7 w-7 text-[#111827]" />
                                        <span className="sr-only">
                                            User menu
                                        </span>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent
                                    className="w-56"
                                    align="end"
                                >
                                    <UserMenuContent user={authUser} />
                                </DropdownMenuContent>
                            </DropdownMenu>
                        ) : (
                            <Button
                                variant="ghost"
                                size="icon"
                                asChild
                                className="h-9 w-9"
                            >
                                <Link href={login()}>
                                    <CircleUserRound className="h-7 w-7 text-[#111827]" />
                                    <span className="sr-only">Login</span>
                                </Link>
                            </Button>
                        )}
                    </div>
                </div>
            </div>

            {breadcrumbs.length > 1 && (
                <div className="flex w-full border-b border-sidebar-border/70">
                    <div className="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                        <Breadcrumbs breadcrumbs={breadcrumbs} />
                    </div>
                </div>
            )}
        </>
    );
}

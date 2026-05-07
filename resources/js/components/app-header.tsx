import { Link, usePage } from '@inertiajs/react';
import { CircleUserRound, Menu } from 'lucide-react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { SystemsLinks, normalizeSystems } from '@/components/systems-links';
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
import { toUrl } from '@/lib/utils';
import { login, home } from '@/routes';
import { index as cataloguesIndex } from '@/routes/catalogues';
import type { BreadcrumbItem } from '@/types';
import { AppTopbar } from '@/components/app-topbar';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

const brandTitle = 'NZEB WINDOWS';
const brandSubtitle = 'CULISANTE CU RIDICARE DIN ALUMINIU';

export function AppHeader({ breadcrumbs = [] }: Props) {
    const page = usePage();
    const { auth, activeSystems, topbar } = page.props;
    const authUser = auth?.user;
    const systems = normalizeSystems(activeSystems);
    const homeUrl = toUrl(home());
    const phoneNumber = topbar.phoneNumber.trim();
    const email = topbar.email.trim();

    const currentParams = new URLSearchParams(page.url.split('?')[1] ?? '');
    const selectedSystemId =
        Number(currentParams.get('system')) || systems[0]?.id;

    return (
        <>
            <div className="border-b border-zinc-200 bg-white shadow-[0px_1px_2px_0px_rgba(0,0,0,0.3),0px_1px_3px_0px_rgba(0,0,0,0.15)]">
                <AppTopbar
                    phoneNumber={phoneNumber}
                    email={email}
                    catalogHref={cataloguesIndex.url()}
                />

                <div className="relative mx-auto flex h-14 items-center px-4 md:px-8 xl:px-30">
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
                                        <p className="poppins-medium text-base leading-none text-[#111827]">
                                            {brandTitle}
                                        </p>
                                        <p className="poppins-regular mt-1 text-[12px] leading-none text-[#111827]">
                                            {brandSubtitle}
                                        </p>
                                    </div>
                                </SheetHeader>

                                <SystemsLinks
                                    variant="mobile"
                                    systems={systems}
                                    homeUrl={homeUrl}
                                    selectedSystemId={selectedSystemId}
                                />
                            </SheetContent>
                        </Sheet>
                    </div>

                    <Link href={home()} prefetch className="shrink-0">
                        <p className="poppins-medium text-base leading-none text-[#111827]">
                            {brandTitle}
                        </p>
                        <p className="poppins-regular mt-1 text-[12px] leading-none text-[#111827]">
                            {brandSubtitle}
                        </p>
                    </Link>

                    <SystemsLinks
                        variant="desktop"
                        systems={systems}
                        homeUrl={homeUrl}
                        selectedSystemId={selectedSystemId}
                    />

                    <div className="ml-auto flex items-center gap-2">
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
                                            Meniu utilizator
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
                                    <span className="sr-only">Conectare</span>
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

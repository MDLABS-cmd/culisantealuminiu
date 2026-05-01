import { Link, usePage } from '@inertiajs/react';
import { LayoutGrid } from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { normalizeSystems } from '@/components/systems-links';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { toUrl } from '@/lib/utils';
import { dashboard } from '@/routes';
import { home } from '@/routes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Tablou de bord',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

export function AppSidebar() {
    const page = usePage();
    const systems = normalizeSystems(page.props.activeSystems);
    const homeUrl = toUrl(home());

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />

                {systems.length > 0 && (
                    <SidebarGroup className="px-2 py-2">
                        <SidebarGroupLabel>Sisteme</SidebarGroupLabel>
                        <SidebarMenu>
                            {systems.map((system) => (
                                <SidebarMenuItem
                                    key={`config-system-${system.id}`}
                                >
                                    <SidebarMenuButton
                                        asChild
                                        tooltip={{
                                            children: `Configurează ${system.name}`,
                                        }}
                                    >
                                        <Link
                                            href={`${homeUrl}?system=${system.id}`}
                                            className="truncate"
                                        >
                                            {system.name}
                                        </Link>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                            ))}
                        </SidebarMenu>
                    </SidebarGroup>
                )}
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}

import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { SharedData, type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { BookOpen, Calendar, Folder, LayoutGrid, Rocket } from 'lucide-react';
import AppLogo from './app-logo';
import { isAdmin } from '@/lib/utils';
import { CalendarPlus } from 'lucide-react';

const customerNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'My Bookings',
        href: '/bookings',
        icon: Calendar,
        isCheckFull: true,
    },
    {
        title: 'Book Service',
        href: '/bookings/create',
        icon: CalendarPlus,
        isCheckFull: true,
    },
];
const adminNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Service',
        href: '/services',
        icon: Folder
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/mj-manna/qtech-task',
        icon: Folder,
    },
    {
        title: 'Postman Api Documentation',
        href: 'https://documenter.getpostman.com/view/26294663/2sB3B8tDZY',
        icon: Rocket,
    },
    {
        title: 'Swagger Api Documentation',
        href: '/api/documentation#/',
        icon: Rocket,
    },
    {
        title: 'Documentation',
        href: 'https://github.com/mj-manna/qtech-task/blob/main/README.md',
        icon: BookOpen,
    },
];

export function AppSidebar() {

    const { auth } = usePage<SharedData>().props;

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={isAdmin(auth.user) ? adminNavItems : customerNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}

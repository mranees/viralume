<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Calendar,
    CalendarCheck,
    CalendarPlus,
    Clock,
    FolderBookmark,
    LayoutGrid,
    SlidersHorizontal,
    UserGroup,
    UserPlus,
    UserRoundKey,
    UsersRound,
} from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavMain from '@/components/NavMain.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavEntry, NavItem } from '@/types';

const mainNavItems: NavEntry[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Appointments',
        icon: Clock,
        children: [
            {
                title: 'Add New Appointment',
                href: '/',
                icon: CalendarPlus,
            },
            {
                title: 'List All Appointment',
                href: '/',
                icon: CalendarCheck,
            },
            {
                title: 'Today Schadule',
                href: '/',
                icon: Calendar,
            },
        ],
    },
    {
        title: 'Doctors',
        icon: UserRoundKey,
        children: [
            {
                title: 'Add New Doctor',
                href: '/doctors/create',
                icon: UserPlus,
            },
            {
                title: 'List All Doctors',
                href: '/doctors',
                icon: UsersRound,
            },
            {
                title: 'Specializations',
                href: '/specializations',
                icon: FolderBookmark,
            },
        ],
    },
    {
        title: 'Patients',
        icon: UserGroup,
        children: [
            {
                title: 'Add New Patient',
                href: '/patients/create',
                icon: UserPlus,
            },
            {
                title: 'List All Patients',
                href: '/patients',
                icon: UsersRound,
            },
        ],
    },
    {
        title: 'Settings',
        href: '/',
        icon: SlidersHorizontal,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo
                                name="ViraLume"
                                slogan="Clicnic Management System"
                            />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <hr />

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>
    </Sidebar>
    <slot />
</template>

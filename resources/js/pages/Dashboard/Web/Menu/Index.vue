<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
    CardAction,
} from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import Icon from '@/components/Icon.vue';
import SidebarMenuItemRecursive from '@/components/SidebarMenuItemRecursive.vue';

interface Props {
    menus: Array<any>;
    sidebarMenus: Array<any>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Menu',
        href: route('dashboard.web.menu.index'),
    },
];

const form = useForm({});

const deleteMenu = (id: string) => {
    if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
        form.delete(route('dashboard.web.menu.destroy', id));
    }
};
</script>

<template>
    <Head title="Manajemen Menu" />

    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="props.sidebarMenus">
        <Card>
            <CardHeader>
                <CardTitle>Manajemen Menu</CardTitle>
                <CardDescription>
                    Ini adalah halaman manajemen menu.
                </CardDescription>
                <CardAction>
                    <Button as-child size="sm">
                        <Link :href="route('dashboard.web.menu.create')">
                            <Icon name="Plus" class="w-4 h-4 mr-2" />
                            <span>Tambah</span>
                        </Link>
                    </Button>
                </CardAction>
            </CardHeader>
            <CardContent>
                <div class="space-y-4">
                    <SidebarMenuItemRecursive :menus="props.menus" />
                </div>
            </CardContent>
        </Card>
    </AppLayout>
</template>
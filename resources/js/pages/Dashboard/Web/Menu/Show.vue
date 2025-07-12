<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/Types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    menu: Record<string, any>;
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
    {
        title: 'Detail',
        href: route('dashboard.web.menu.show', props.menu.id),
    },
];
</script>

<template>

    <Head title="Detail Menu" />

    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="props.sidebarMenus">
        <div>
            <h1>Detail Menu</h1>
            <p><strong>Nama:</strong> {{ props.menu.name }}</p>
            <p><strong>URL:</strong> {{ props.menu.url }}</p>
            <p><strong>Ikon:</strong> {{ props.menu.icon }}</p>
            <p><strong>Urutan:</strong> {{ props.menu.order }}</p>
            <p v-if="props.menu.parent"><strong>Menu Induk:</strong> {{ props.menu.parent.name }}</p>
            <h2 v-if="props.menu.children && props.menu.children.length">Sub Menu:</h2>
            <ul v-if="props.menu.children && props.menu.children.length">
                <li v-for="child in props.menu.children" :key="child.id">{{ child.name }}</li>
            </ul>
            <Link :href="route('dashboard.web.menu.edit', props.menu.id)">Edit</Link>
            <Link :href="route('dashboard.web.menu.index')">Kembali ke Daftar</Link>
        </div>
    </AppLayout>
</template>
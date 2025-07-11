<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
        <div>
            <h1>Manajemen Menu</h1>
            <p>Ini adalah halaman manajemen menu.</p>
            <Link :href="route('dashboard.web.menu.create')">Tambah Menu Baru</Link>
            <ul>
                <li v-for="menu in props.menus" :key="menu.id">
                    {{ menu.name }} ({{ menu.url }})
                    <Link :href="route('dashboard.web.menu.show', menu.id)">Lihat</Link>
                    <Link :href="route('dashboard.web.menu.edit', menu.id)">Edit</Link>
                    <button @click="deleteMenu(menu.id)">Hapus</button>
                    <ul v-if="menu.children && menu.children.length">
                        <li v-for="child in menu.children" :key="child.id">
                            -- {{ child.name }} ({{ child.url }})
                            <Link :href="route('dashboard.web.menu.show', child.id)">Lihat</Link>
                            <Link :href="route('dashboard.web.menu.edit', child.id)">Edit</Link>
                            <button @click="deleteMenu(child.id)">Hapus</button>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </AppLayout>
</template>
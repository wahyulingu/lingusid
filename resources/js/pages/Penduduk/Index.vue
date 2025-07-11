<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Props {
    penduduk: Array<any>;
    sidebarMenus: Array<any>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Penduduk',
        href: route('dashboard.sid.penduduk.index'),
    },
];

const form = useForm({});

const deletePenduduk = (id: string) => {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        form.delete(route('dashboard.sid.penduduk.destroy', id));
    }
};
</script>

<template>
    <Head title="Penduduk" />

    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="props.sidebarMenus">
        <div>
            <h1>Daftar Penduduk</h1>
            <p>Ini adalah halaman daftar penduduk.</p>
            <Link :href="route('dashboard.sid.penduduk.create')">Tambah Penduduk</Link>
            <ul>
                <li v-for="p in props.penduduk" :key="p.id">
                    {{ p.nama_lengkap }} ({{ p.nik }})
                    <Link :href="route('dashboard.sid.penduduk.show', p.id)">Lihat</Link>
                    <Link :href="route('dashboard.sid.penduduk.edit', p.id)">Edit</Link>
                    <button @click="deletePenduduk(p.id)">Hapus</button>
                </li>
            </ul>
        </div>
    </AppLayout>
</template>
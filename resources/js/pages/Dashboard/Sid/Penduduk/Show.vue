<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    penduduk: Record<string, any>;
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
    {
        title: 'Detail',
        href: route('dashboard.sid.penduduk.show', props.penduduk.id),
    },
];
</script>

<template>
    <Head title="Detail Penduduk" />

    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="props.sidebarMenus">
        <div>
            <h1>Detail Penduduk</h1>
            <p><strong>NIK:</strong> {{ props.penduduk.nik }}</p>
            <p><strong>Nama Lengkap:</strong> {{ props.penduduk.nama_lengkap }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ props.penduduk.jenis_kelamin }}</p>
            <!-- Tampilkan detail lain sesuai kolom -->
            <Link :href="route('dashboard.sid.penduduk.edit', props.penduduk.id)">Edit</Link>
            <Link :href="route('dashboard.sid.penduduk.index')">Kembali ke Daftar</Link>
        </div>
    </AppLayout>
</template>
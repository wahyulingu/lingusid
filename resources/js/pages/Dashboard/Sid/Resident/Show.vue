<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    resident: Record<string, any>;
    sidebarMenus: Array<any>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Resident',
        href: route('dashboard.sid.resident.index'),
    },
    {
        title: 'Detail',
        href: route('dashboard.sid.resident.show', props.resident.id),
    },
];
</script>

<template>

    <Head title="Resident Details" />

    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="props.sidebarMenus">
        <div>
            <h1>Resident Details</h1>
            <p><strong>NIK:</strong> {{ props.resident.nik }}</p>
            <p><strong>Full Name:</strong> {{ props.resident.nama_lengkap }}</p>
            <p><strong>Gender:</strong> {{ props.resident.jenis_kelamin }}</p>
            <!-- Display other details according to columns -->
            <Link :href="route('dashboard.sid.resident.edit', props.resident.id)">Edit</Link>
            <Link :href="route('dashboard.sid.resident.index')">Back to List</Link>
        </div>
    </AppLayout>
</template>
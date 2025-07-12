<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/Types';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Props {
    resident: Array<any>;
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
];

const form = useForm({});

const deleteResident = (id: string) => {
    if (confirm('Are you sure you want to delete this data?')) {
        form.delete(route('dashboard.sid.resident.destroy', id));
    }
};
</script>

<template>

    <Head title="Resident" />

    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="props.sidebarMenus">
        <div>
            <h1>Resident List</h1>
            <p>This is the resident list page.</p>
            <Link :href="route('dashboard.sid.resident.create')">Add Resident</Link>
            <ul>
                <li v-for="p in props.resident" :key="p.id">
                    {{ p.nama_lengkap }} ({{ p.nik }})
                    <Link :href="route('dashboard.sid.resident.show', p.id)">View</Link>
                    <Link :href="route('dashboard.sid.resident.edit', p.id)">Edit</Link>
                    <button @click="deleteResident(p.id)">Delete</button>
                </li>
            </ul>
        </div>
    </AppLayout>
</template>
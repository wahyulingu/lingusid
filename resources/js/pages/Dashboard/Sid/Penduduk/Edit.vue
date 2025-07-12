<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/Types';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
        title: 'Edit',
        href: route('dashboard.sid.resident.edit', props.resident.id),
    },
];

const form = useForm({
    nik: props.resident.nik,
    nama_lengkap: props.resident.nama_lengkap,
    tempat_lahir: props.resident.tempat_lahir,
    tanggal_lahir: props.resident.tanggal_lahir,
    jenis_kelamin: props.resident.jenis_kelamin,
    alamat: props.resident.alamat,
    status_perkawinan: props.resident.status_perkawinan,
    pekerjaan: props.resident.pekerjaan,
});

const submit = () => {
    form.put(route('dashboard.sid.resident.update', props.resident.id));
};
</script>

<template>

    <Head title="Edit Resident" />

    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="props.sidebarMenus">
        <div>
            <h1>Edit Resident</h1>
            <form @submit.prevent="submit">
                <div>
                    <label for="nik">NIK:</label>
                    <input id="nik" v-model="form.nik" type="text" />
                    <div v-if="form.errors.nik">{{ form.errors.nik }}</div>
                </div>
                <div>
                    <label for="nama_lengkap">Full Name:</label>
                    <input id="nama_lengkap" v-model="form.nama_lengkap" type="text" />
                    <div v-if="form.errors.nama_lengkap">{{ form.errors.nama_lengkap }}</div>
                </div>
                <div>
                    <label for="jenis_kelamin">Gender:</label>
                    <select id="jenis_kelamin" v-model="form.jenis_kelamin">
                        <option value="Laki-laki">Male</option>
                        <option value="Perempuan">Female</option>
                    </select>
                    <div v-if="form.errors.jenis_kelamin">{{ form.errors.jenis_kelamin }}</div>
                </div>
                <!-- Add other inputs according to migration columns -->
                <button type="submit" :disabled="form.processing">Update</button>
            </form>
            <Link :href="route('dashboard.sid.resident.index')">Back</Link>
        </div>
    </AppLayout>
</template>
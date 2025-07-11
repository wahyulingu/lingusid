<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
        title: 'Edit',
        href: route('dashboard.sid.penduduk.edit', props.penduduk.id),
    },
];

const form = useForm({
    nik: props.penduduk.nik,
    nama_lengkap: props.penduduk.nama_lengkap,
    tempat_lahir: props.penduduk.tempat_lahir,
    tanggal_lahir: props.penduduk.tanggal_lahir,
    jenis_kelamin: props.penduduk.jenis_kelamin,
    alamat: props.penduduk.alamat,
    status_perkawinan: props.penduduk.status_perkawinan,
    pekerjaan: props.penduduk.pekerjaan,
});

const submit = () => {
    form.put(route('dashboard.sid.penduduk.update', props.penduduk.id));
};
</script>

<template>
    <Head title="Edit Penduduk" />

    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="props.sidebarMenus">
        <div>
            <h1>Edit Penduduk</h1>
            <form @submit.prevent="submit">
                <div>
                    <label for="nik">NIK:</label>
                    <input id="nik" v-model="form.nik" type="text" />
                    <div v-if="form.errors.nik">{{ form.errors.nik }}</div>
                </div>
                <div>
                    <label for="nama_lengkap">Nama Lengkap:</label>
                    <input id="nama_lengkap" v-model="form.nama_lengkap" type="text" />
                    <div v-if="form.errors.nama_lengkap">{{ form.errors.nama_lengkap }}</div>
                </div>
                <div>
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select id="jenis_kelamin" v-model="form.jenis_kelamin">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <div v-if="form.errors.jenis_kelamin">{{ form.errors.jenis_kelamin }}</div>
                </div>
                <!-- Tambahkan input lain sesuai kolom migrasi -->
                <button type="submit" :disabled="form.processing">Update</button>
            </form>
            <Link :href="route('dashboard.sid.penduduk.index')">Kembali</Link>
        </div>
    </AppLayout>
</template>
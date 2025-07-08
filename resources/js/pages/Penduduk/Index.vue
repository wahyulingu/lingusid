<template>
    <div>
        <h1>Daftar Penduduk</h1>
        <p>Ini adalah halaman daftar penduduk.</p>
        <Link :href="route('penduduk.create')">Tambah Penduduk</Link>
        <ul>
            <li v-for="p in penduduk" :key="p.id">
                {{ p.nama_lengkap }} ({{ p.nik }})
                <Link :href="route('penduduk.show', p.id)">Lihat</Link>
                <Link :href="route('penduduk.edit', p.id)">Edit</Link>
                <button @click="deletePenduduk(p.id)">Hapus</button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    penduduk: Array,
});

const form = useForm({});

const deletePenduduk = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        form.delete(route('penduduk.destroy', id));
    }
};
</script>
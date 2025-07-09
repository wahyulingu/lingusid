<template>
    <div>
        <h1>Detail Penduduk</h1>
        <p><strong>NIK:</strong> {{ penduduk.nik }}</p>
        <p><strong>Nama Lengkap:</strong> {{ penduduk.nama_lengkap }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ penduduk.jenis_kelamin }}</p>
        <!-- Tampilkan detail lain sesuai kolom -->
        <Link :href="route('penduduk.edit', penduduk.id)">Edit</Link>
        <Link :href="route('penduduk.index')">Kembali ke Daftar</Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    penduduk: Object,
});
</script>
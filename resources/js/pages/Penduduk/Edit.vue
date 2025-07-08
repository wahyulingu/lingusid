<template>
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
        <Link :href="route('penduduk.index')">Kembali</Link>
    </div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    penduduk: Object,
});

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
    form.put(route('penduduk.update', props.penduduk.id));
};
</script>
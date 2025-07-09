<template>
    <div>
        <h1>Tambah Menu Baru</h1>
        <form @submit.prevent="submit">
            <div>
                <label for="name">Nama Menu:</label>
                <input id="name" v-model="form.name" type="text" />
                <div v-if="form.errors.name">{{ form.errors.name }}</div>
            </div>
            <div>
                <label for="url">URL:</label>
                <input id="url" v-model="form.url" type="text" />
                <div v-if="form.errors.url">{{ form.errors.url }}</div>
            </div>
            <div>
                <label for="icon">Ikon (opsional):</label>
                <input id="icon" v-model="form.icon" type="text" />
                <div v-if="form.errors.icon">{{ form.errors.icon }}</div>
            </div>
            <div>
                <label for="order">Urutan:</label>
                <input id="order" v-model="form.order" type="number" />
                <div v-if="form.errors.order">{{ form.errors.order }}</div>
            </div>
            <div>
                <label for="parent_id">Menu Induk (opsional):</label>
                <select id="parent_id" v-model="form.parent_id">
                    <option :value="null">-- Pilih Induk --</option>
                    <option v-for="menu in parentMenus" :key="menu.id" :value="menu.id">{{ menu.name }}</option>
                </select>
                <div v-if="form.errors.parent_id">{{ form.errors.parent_id }}</div>
            </div>
            <button type="submit" :disabled="form.processing">Simpan</button>
        </form>
        <Link :href="route('menus.index')">Kembali</Link>
    </div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    parentMenus: Array,
});

const form = useForm({
    name: '',
    url: '',
    icon: '',
    order: 0,
    parent_id: null,
});

const submit = () => {
    form.post(route('menus.store'));
};
</script>
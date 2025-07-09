<template>
    <div>
        <h1>Manajemen Menu</h1>
        <p>Ini adalah halaman manajemen menu.</p>
        <Link :href="route('menus.create')">Tambah Menu Baru</Link>
        <ul>
            <li v-for="menu in menus" :key="menu.id">
                {{ menu.name }} ({{ menu.url }})
                <Link :href="route('menus.show', menu.id)">Lihat</Link>
                <Link :href="route('menus.edit', menu.id)">Edit</Link>
                <button @click="deleteMenu(menu.id)">Hapus</button>
                <ul v-if="menu.children && menu.children.length">
                    <li v-for="child in menu.children" :key="child.id">
                        -- {{ child.name }} ({{ child.url }})
                        <Link :href="route('menus.show', child.id)">Lihat</Link>
                        <Link :href="route('menus.edit', child.id)">Edit</Link>
                        <button @click="deleteMenu(child.id)">Hapus</button>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    menus: Array,
});

const form = useForm({});

const deleteMenu = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
        form.delete(route('menus.destroy', id));
    }
};
</script>
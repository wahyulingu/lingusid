<template>
    <div>
        <h1>Detail Menu</h1>
        <p><strong>Nama:</strong> {{ menu.name }}</p>
        <p><strong>URL:</strong> {{ menu.url }}</p>
        <p><strong>Ikon:</strong> {{ menu.icon }}</p>
        <p><strong>Urutan:</strong> {{ menu.order }}</p>
        <p v-if="menu.parent"><strong>Menu Induk:</strong> {{ menu.parent.name }}</p>
        <h2 v-if="menu.children && menu.children.length">Sub Menu:</h2>
        <ul v-if="menu.children && menu.children.length">
            <li v-for="child in menu.children" :key="child.id">{{ child.name }}</li>
        </ul>
        <Link :href="route('menus.edit', menu.id)">Edit</Link>
        <Link :href="route('menus.index')">Kembali ke Daftar</Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    menu: Object,
});
</script>
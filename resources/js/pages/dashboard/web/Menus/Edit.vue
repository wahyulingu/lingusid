<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Props {
    menu: Record<string, any>;
    parentMenus: Array<any>;
    sidebarMenus: Array<any>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Menu',
        href: route('dashboard.web.menu.index'),
    },
    {
        title: 'Edit',
        href: route('dashboard.web.menu.edit', props.menu.id),
    },
];

const form = useForm({
    name: props.menu.name,
    url: props.menu.url,
    icon: props.menu.icon,
    order: props.menu.order,
    parent_id: props.menu.parent_id,
});

const submit = () => {
    form.put(route('dashboard.web.menu.update', props.menu.id));
};
</script>

<template>
    <Head title="Edit Menu" />

    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="props.sidebarMenus">
        <div>
            <h1>Edit Menu</h1>
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
                <button type="submit" :disabled="form.processing">Update</button>
            </form>
            <Link :href="route('dashboard.web.menu.index')">Kembali</Link>
        </div>
    </AppLayout>
</template>
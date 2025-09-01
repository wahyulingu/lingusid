<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

interface Props {
    category: App.Models.Group;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Website',
        href: '/dashboard/web/articles',
    },
    {
        title: 'Kategori Artikel',
        href: '/dashboard/web/article-categories',
    },
    {
        title: props.category.name,
        href: `/dashboard/web/article-categories/${props.category.id}`,
    },
];

</script>

<template>
    <Head :title="props.category.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <CardTitle>{{ props.category.name }}</CardTitle>
                <CardDescription>{{ props.category.description }}</CardDescription>
            </CardHeader>
            <CardContent>
                <p>ID: {{ props.category.id }}</p>
                <p>Nama: {{ props.category.name }}</p>
                <p>Deskripsi: {{ props.category.description }}</p>
            </CardContent>
        </Card>
    </AppLayout>
</template>

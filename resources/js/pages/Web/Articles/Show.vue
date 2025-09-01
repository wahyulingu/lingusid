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
    article: {
        id: number;
        title: string;
        content: string;
        published_at: string;
        author: {
            name: string;
        };
    };
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
        title: 'Artikel',
        href: '/dashboard/web/articles',
    },
    {
        title: props.article.title,
        href: `/dashboard/web/articles/${props.article.id}`,
    },
];

</script>

<template>
    <Head :title="props.article.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <CardTitle>{{ props.article.title }}</CardTitle>
                <CardDescription>Ditulis oleh: {{ props.article.author.name }} | Diterbitkan pada: {{ props.article.published_at }}</CardDescription>
            </CardHeader>
            <CardContent>
                <div v-html="props.article.content"></div>
            </CardContent>
        </Card>
    </AppLayout>
</template>

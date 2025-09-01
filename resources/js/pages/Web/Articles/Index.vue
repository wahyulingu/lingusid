<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

interface Props {
    articles: {
        data: {
            id: number;
            title: string;
            slug: string;
            published_at: string;
            author: {
                name: string;
            };
        }[];
        links: any[];
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
];

</script>

<template>
    <Head title="Artikel" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle>Artikel</CardTitle>
                        <CardDescription>Daftar semua artikel yang terdaftar di dalam sistem.</CardDescription>
                    </div>
                    <Link :href="route('dashboard.web.articles.create')">
                        <Button>Tambah Artikel</Button>
                    </Link>
                </div>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Judul</TableHead>
                            <TableHead>Slug</TableHead>
                            <TableHead>Penulis</TableHead>
                            <TableHead>Tanggal Terbit</TableHead>
                            <TableHead>Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="article in props.articles.data" :key="article.id">
                            <TableCell>{{ article.title }}</TableCell>
                            <TableCell>{{ article.slug }}</TableCell>
                            <TableCell>{{ article.author.name }}</TableCell>
                            <TableCell>{{ article.groups.map(g => g.name).join(', ') }}</TableCell>
                            <TableCell>{{ article.published_at }}</TableCell>
                            <TableCell>
                                <div class="flex gap-2">
                                    <Link :href="route('dashboard.web.articles.edit', article.id)">
                                        <Button variant="outline" size="sm">Edit</Button>
                                    </Link>
                                    <Link :href="route('dashboard.web.articles.destroy', article.id)" method="delete" as="button" type="button">
                                        <Button variant="destructive" size="sm">Hapus</Button>
                                    </Link>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
        </Card>
    </AppLayout>
</template>

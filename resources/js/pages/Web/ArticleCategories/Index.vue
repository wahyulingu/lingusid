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
    categories: {
        data: App.Models.Group[];
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
        title: 'Kategori Artikel',
        href: '/dashboard/web/article-categories',
    },
];

</script>

<template>
    <Head title="Kategori Artikel" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle>Kategori Artikel</CardTitle>
                        <CardDescription>Daftar semua kategori artikel yang terdaftar di dalam sistem.</CardDescription>
                    </div>
                    <Link :href="route('dashboard.web.article-categories.create')">
                        <Button>Tambah Kategori Artikel</Button>
                    </Link>
                </div>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Nama</TableHead>
                            <TableHead>Deskripsi</TableHead>
                            <TableHead>Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="category in props.categories.data" :key="category.id">
                            <TableCell>{{ category.name }}</TableCell>
                            <TableCell>{{ category.description }}</TableCell>
                            <TableCell>
                                <div class="flex gap-2">
                                    <Link :href="route('dashboard.web.article-categories.edit', category.id)">
                                        <Button variant="outline" size="sm">Edit</Button>
                                    </Link>
                                    <Link :href="route('dashboard.web.article-categories.destroy', category.id)" method="delete" as="button" type="button">
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

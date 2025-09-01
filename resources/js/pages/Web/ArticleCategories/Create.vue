<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

const form = useForm({
    name: '',
    description: '',
});

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
        title: 'Tambah',
        href: '/dashboard/web/article-categories/create',
    },
];

const submit = () => {
    form.post(route('dashboard.web.article-categories.store'));
};

</script>

<template>
    <Head title="Tambah Kategori Artikel" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit">
            <Card>
                <CardHeader>
                    <CardTitle>Tambah Kategori Artikel</CardTitle>
                    <CardDescription>Isi formulir di bawah ini untuk menambahkan kategori artikel baru.</CardDescription>
                </CardHeader>
                <CardContent class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <Label for="name">Nama</Label>
                        <Input id="name" v-model="form.name" required />
                    </div>
                    <div class="space-y-2">
                        <Label for="description">Deskripsi</Label>
                        <Textarea id="description" v-model="form.description" />
                    </div>
                    <div class="flex justify-end">
                        <Button type="submit" :disabled="form.processing">Simpan</Button>
                    </div>
                </CardContent>
            </Card>
        </form>
    </AppLayout>
</template>

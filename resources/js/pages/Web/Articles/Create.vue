<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
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

const page = usePage();

const form = useForm({
    title: '',
    slug: '',
    content: '',
    published_at: '',
    author_id: page.props.auth.user.id,
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
        title: 'Artikel',
        href: '/dashboard/web/articles',
    },
    {
        title: 'Tambah',
        href: '/dashboard/web/articles/create',
    },
];

const submit = () => {
    form.post(route('dashboard.web.articles.store'));
};

</script>

<template>
    <Head title="Tambah Artikel" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit">
            <Card>
                <CardHeader>
                    <CardTitle>Tambah Artikel</CardTitle>
                    <CardDescription>Isi formulir di bawah ini untuk menambahkan artikel baru.</CardDescription>
                </CardHeader>
                <CardContent class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <Label for="title">Judul</Label>
                        <Input id="title" v-model="form.title" required />
                    </div>
                    <div class="space-y-2">
                        <Label for="slug">Slug</Label>
                        <Input id="slug" v-model="form.slug" required />
                    </div>
                    <div class="space-y-2">
                        <Label for="content">Konten</Label>
                        <Textarea id="content" v-model="form.content" required />
                    </div>
                    <div class="space-y-2">
                        <Label for="published_at">Tanggal Terbit</Label>
                        <Input id="published_at" type="datetime-local" v-model="form.published_at" />
                    </div>
                    <div class="space-y-2">
                        <Label for="group">Kategori</Label>
                        <Select v-model="form.group_id">
                            <SelectTrigger id="group">
                                <SelectValue placeholder="Pilih Kategori" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="group in props.groups" :key="group.id" :value="group.id">{{ group.name }}</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <div class="flex justify-end">
                        <Button type="submit" :disabled="form.processing">Simpan</Button>
                    </div>
                </CardContent>
            </Card>
        </form>
    </AppLayout>
</template>

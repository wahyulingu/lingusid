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
    residents: {
        data: App.Models.Sid.SidResident[];
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
        title: 'Kependudukan',
        href: '/dashboard/population/residents',
    },
    {
        title: 'Penduduk',
        href: '/dashboard/population/residents',
    },
];

</script>

<template>
    <Head title="Penduduk" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle>Penduduk</CardTitle>
                        <CardDescription>Daftar semua penduduk yang terdaftar di dalam sistem.</CardDescription>
                    </div>
                    <Link :href="route('dashboard.sid.population.residents.create')">
                        <Button>Tambah Penduduk</Button>
                    </Link>
                </div>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>NIK</TableHead>
                            <TableHead>Nama</TableHead>
                            <TableHead>Alamat</TableHead>
                            <TableHead>Jenis Kelamin</TableHead>
                            <TableHead>Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="resident in props.residents.data" :key="resident.id">
                            <TableCell>{{ resident.nik }}</TableCell>
                            <TableCell>{{ resident.name }}</TableCell>
                            <TableCell>{{ resident.address }}</TableCell>
                            <TableCell>{{ resident.gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</TableCell>
                            <TableCell>
                                <div class="flex gap-2">
                                    <Link :href="route('dashboard.sid.population.residents.edit', resident.id)">
                                        <Button variant="outline" size="sm">Edit</Button>
                                    </Link>
                                    <Link :href="route('dashboard.sid.population.residents.destroy', resident.id)" method="delete" as="button" type="button">
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

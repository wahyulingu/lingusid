<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

const form = useForm({
    nik: '',
    name: '',
    no_kk: '',
    address: '',
    birth_place: '',
    birth_date: '',
    gender: 'L',
    religion: '',
    marital_status: '',
    education: '',
    occupation: '',
    nationality: 'WNI',
    father_name: '',
    mother_name: '',
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Kependudukan',
        href: '/dashboard/sid/population/residents',
    },
    {
        title: 'Penduduk',
        href: '/dashboard/sid/population/residents',
    },
    {
        title: 'Tambah',
        href: '/dashboard/sid/population/residents/create',
    },
];

const submit = () => {
    form.post(route('dashboard.sid.population.residents.store'));
};

</script>

<template>
    <Head title="Tambah Penduduk" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit">
            <Card>
                <CardHeader>
                    <CardTitle>Tambah Penduduk</CardTitle>
                    <CardDescription>Isi formulir di bawah ini untuk menambahkan penduduk baru.</CardDescription>
                </CardHeader>
                <CardContent class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <Label for="nik">NIK</Label>
                        <Input id="nik" v-model="form.nik" required />
                    </div>
                    <div class="space-y-2">
                        <Label for="name">Nama Lengkap</Label>
                        <Input id="name" v-model="form.name" required />
                    </div>
                    <div class="space-y-2">
                        <Label for="no_kk">No. KK</Label>
                        <Input id="no_kk" v-model="form.no_kk" />
                    </div>
                    <div class="space-y-2">
                        <Label for="address">Alamat</Label>
                        <Input id="address" v-model="form.address" />
                    </div>
                    <div class="space-y-2">
                        <Label for="birth_place">Tempat Lahir</Label>
                        <Input id="birth_place" v-model="form.birth_place" />
                    </div>
                    <div class="space-y-2">
                        <Label for="birth_date">Tanggal Lahir</Label>
                        <Input id="birth_date" type="date" v-model="form.birth_date" />
                    </div>
                    <div class="space-y-2">
                        <Label for="gender">Jenis Kelamin</Label>
                        <Select v-model="form.gender">
                            <SelectTrigger id="gender">
                                <SelectValue placeholder="Pilih Jenis Kelamin" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="L">Laki-laki</SelectItem>
                                <SelectItem value="P">Perempuan</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <div class="space-y-2">
                        <Label for="religion">Agama</Label>
                        <Input id="religion" v-model="form.religion" />
                    </div>
                    <div class="space-y-2">
                        <Label for="marital_status">Status Perkawinan</Label>
                        <Input id="marital_status" v-model="form.marital_status" />
                    </div>
                    <div class="space-y-2">
                        <Label for="education">Pendidikan</Label>
                        <Input id="education" v-model="form.education" />
                    </div>
                    <div class="space-y-2">
                        <Label for="occupation">Pekerjaan</Label>
                        <Input id="occupation" v-model="form.occupation" />
                    </div>
                    <div class="space-y-2">
                        <Label for="nationality">Kewarganegaraan</Label>
                        <Input id="nationality" v-model="form.nationality" />
                    </div>
                    <div class="space-y-2">
                        <Label for="father_name">Nama Ayah</Label>
                        <Input id="father_name" v-model="form.father_name" />
                    </div>
                    <div class="space-y-2">
                        <Label for="mother_name">Nama Ibu</Label>
                        <Input id="mother_name" v-model="form.mother_name" />
                    </div>
                    <div class="col-span-1 md:col-span-2 flex justify-end">
                        <Button type="submit" :disabled="form.processing">Simpan</Button>
                    </div>
                </CardContent>
            </Card>
        </form>
    </AppLayout>
</template>

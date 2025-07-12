<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { type BreadcrumbItem } from '@/types';

const props = defineProps({
    menus: Array,
});

const isModalOpen = ref(false);
const isEditMode = ref(false);
const form = useForm({
    id: null,
    name: '',
    url: '',
    icon: '',
    group_id: null,
    parent_id: null,
});

const allMenus = computed(() => {
    return props.menus.flatMap(group => group.menus);
});

const openModal = (menu = null) => {
    isModalOpen.value = true;
    if (menu) {
        isEditMode.value = true;
        form.id = menu.id;
        form.name = menu.name;
        form.url = menu.url;
        form.icon = menu.icon;
        form.group_id = props.menus.find(g => g.menus.some(m => m.id === menu.id)).id;
        form.parent_id = menu.parent_id;
    } else {
        isEditMode.value = false;
        form.reset();
    }
};

const closeModal = () => {
    isModalOpen.value = false;
    isEditMode.value = false;
    form.reset();
};

const submit = () => {
    if (isEditMode.value) {
        form.put(route('dashboard.web.menu.update', form.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('dashboard.web.menu.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteMenu = (menu) => {
    if (confirm('Are you sure you want to delete this menu?')) {
        useForm({}).delete(route('dashboard.web.menu.destroy', menu.id));
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Menu Management',
        href: '/dashboard/web/menu',
    },
];
</script>

<template>
    <Head title="Menu Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="flex justify-end mb-4">
                <Button @click="openModal()">
                    Create Menu
                </Button>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div v-for="group in menus" :key="group.id" class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">{{ group.name }}</h3>
                    <div class="border rounded-md p-4">
                        <div v-for="element in group.menus" :key="element.id" class="p-2 border-b last:border-b-0">
                            <div class="flex justify-between items-center">
                                <span>{{ element.name }}</span>
                                <div>
                                    <Button variant="outline" size="sm" @click="openModal(element)" class="mr-2">Edit</Button>
                                    <Button variant="destructive" size="sm" @click="deleteMenu(element)">Delete</Button>
                                </div>
                            </div>
                            <div v-if="element.children && element.children.length > 0" class="ml-4 mt-2">
                                <div v-for="child in element.children" :key="child.id" class="p-2 border-b last:border-b-0">
                                    <div class="flex justify-between items-center">
                                        <span>{{ child.name }}</span>
                                        <div>
                                            <Button variant="outline" size="sm" @click="openModal(child)" class="mr-2">Edit</Button>
                                            <Button variant="destructive" size="sm" @click="deleteMenu(child)">Delete</Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Dialog :open="isModalOpen" @update:open="isModalOpen = $event">
            <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>{{ isEditMode ? 'Edit Menu' : 'Create Menu' }}</DialogTitle>
                    <DialogDescription>
                        {{ isEditMode ? 'Edit the menu details.' : 'Create a new menu item.' }}
                    </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="submit">
                    <div class="grid gap-4 py-4">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" required />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="url">URL</Label>
                            <Input id="url" v-model="form.url" />
                            <InputError :message="form.errors.url" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="icon">Icon</Label>
                            <Input id="icon" v-model="form.icon" />
                            <InputError :message="form.errors.icon" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="group">Category</Label>
                            <select v-model="form.group_id" id="group"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option v-for="group in menus" :key="group.id" :value="group.id">{{ group.name }}</option>
                            </select>
                            <InputError :message="form.errors.group_id" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="parent">Parent Menu</Label>
                            <select v-model="form.parent_id" id="parent"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option :value="null">None</option>
                                <option v-for="menu in allMenus" :key="menu.id" :value="menu.id">{{ menu.name }}</option>
                            </select>
                            <InputError :message="form.errors.parent_id" />
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose as-child>
                            <Button type="button" variant="secondary">Cancel</Button>
                        </DialogClose>
                        <Button type="submit" :disabled="form.processing">{{ isEditMode ? 'Update' : 'Create' }}</Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>

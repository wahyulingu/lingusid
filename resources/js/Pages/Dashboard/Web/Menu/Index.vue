<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from '@/Components/ui/dialog';
import draggable from 'vuedraggable';
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

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
</script>

<template>
    <AppLayout title="Menu Management">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Menu Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-end mb-4">
                            <button @click="openModal()"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Menu
                            </button>
                        </div>
                        <div v-for="group in menus" :key="group.id">
                            <h3 class="text-lg font-semibold mb-2">{{ group.name }}</h3>
                            <draggable v-model="group.menus" group="menus" @start="drag = true" @end="drag = false"
                                item-key="id">
                                <template #item="{ element }">
                                    <div class="p-2 border rounded mb-2">
                                        <div class="flex justify-between items-center">
                                            <span>{{ element.name }}</span>
                                            <div>
                                                <button @click="openModal(element)"
                                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">Edit</button>
                                                <button @click="deleteMenu(element)"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs ml-2">Delete</button>
                                            </div>
                                        </div>
                                        <draggable v-model="element.children" group="menus" @start="drag = true"
                                            @end="drag = false" item-key="id" class="ml-4 mt-2">
                                            <template #item="{ element: child }">
                                                <div class="p-2 border rounded mb-2">
                                                    <div class="flex justify-between items-center">
                                                        <span>{{ child.name }}</span>
                                                        <div>
                                                            <button @click="openModal(child)"
                                                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">Edit</button>
                                                            <button @click="deleteMenu(child)"
                                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs ml-2">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </draggable>
                                    </div>
                                </template>
                            </draggable>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Dialog :open="isModalOpen" @update:open="isModalOpen = $event">
            <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>{{ isEditMode ? 'Edit Menu' : 'Create Menu' }}</DialogTitle>
                </DialogHeader>
                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" v-model="form.name" id="name"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="mt-4">
                        <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                        <input type="text" v-model="form.url" id="url"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="mt-4">
                        <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                        <input type="text" v-model="form.icon" id="icon"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="mt-4">
                        <label for="group" class="block text-sm font-medium text-gray-700">Category</label>
                        <select v-model="form.group_id" id="group"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option v-for="group in menus" :key="group.id" :value="group.id">{{ group.name }}</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="parent" class="block text-sm font-medium text-gray-700">Parent Menu</label>
                        <select v-model="form.parent_id" id="parent"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option :value="null">None</option>
                            <option v-for="menu in allMenus" :key="menu.id" :value="menu.id">{{ menu.name }}</option>
                        </select>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <DialogClose as-child>
                            <button type="button"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                        </DialogClose>
                        <button type="submit"
                            class="ml-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{
                                isEditMode ?
                                    'Update' : 'Create' }}</button>
                    </div>
                </form>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>

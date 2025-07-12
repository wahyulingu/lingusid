<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import {
    SidebarMenuItem,
    SidebarMenuButton,
    SidebarMenuSub,
    SidebarMenuSubButton,
} from '@/Components/ui/sidebar';
import Icon from '@/components/Icon.vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import { Button } from '@/Components/ui/button';

interface Menu {
    id: number;
    name: string;
    url?: string;
    icon?: string;
    order: number;
    parent_id?: number;
    children?: Menu[];
}

const props = defineProps<{ menus: Menu[] }>();

const form = useForm({});

const deleteMenu = (id: string) => {
    if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
        form.delete(route('dashboard.web.menu.destroy', id));
    }
};
</script>

<template>
    <template v-for="menu in menus" :key="menu.id">
        <SidebarMenuItem class="flex items-center justify-between">
            <SidebarMenuButton :as-child="!!menu.url">
                <Link v-if="menu.url" :href="menu.url">
                <Icon v-if="menu.icon" :name="menu.icon" />
                <span>{{ menu.name }}</span>
                </Link>
                <template v-else>
                    <Icon v-if="menu.icon" :name="menu.icon" />
                    <span>{{ menu.name }}</span>
                </template>
            </SidebarMenuButton>
            <div class="flex items-center">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="ghost" size="icon" as-child>
                            <Icon name="MoreVertical" class="w-4 h-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent>
                        <DropdownMenuItem as-child>
                            <Link :href="route('dashboard.web.menu.show', menu.id)">
                            Lihat
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link :href="route('dashboard.web.menu.edit', menu.id)">
                            Edit
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="deleteMenu(menu.id)">
                            Hapus
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </SidebarMenuItem>
        <template v-if="menu.children && menu.children.length">
            <SidebarMenuSub>
                <SidebarMenuSubButton>
                    <SidebarMenuItemRecursive :menus="menu.children" />
                </SidebarMenuSubButton>
            </SidebarMenuSub>
        </template>
    </template>
</template>
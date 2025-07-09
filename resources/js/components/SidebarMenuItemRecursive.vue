<template>
    <template v-for="menu in menus" :key="menu.id">
        <SidebarMenuItem>
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
            <template v-if="menu.children && menu.children.length">
                <SidebarMenuSub>
                    <SidebarMenuSubButton>
                        <SidebarMenuItemRecursive :menus="menu.children" />
                    </SidebarMenuSubButton>
                </SidebarMenuSub>
            </template>
        </SidebarMenuItem>
    </template>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { SidebarMenuItem, SidebarMenuButton, SidebarMenuSub, SidebarMenuSubButton } from '@/components/ui/sidebar';
import Icon from '@/components/Icon.vue'; // Pastikan komponen Icon Anda ada

interface MenuItem {
    id: number;
    name: string;
    url?: string;
    icon?: string;
    order: number;
    parent_id?: number;
    group_id: number;
    children?: MenuItem[];
}

const props = defineProps<{ menus: Menu[] }>();
</script>
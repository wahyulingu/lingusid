<script setup lang="ts">
import AppContent from '@/Components/AppContent.vue';
import AppShell from '@/Components/AppShell.vue';
import AppSidebar from '@/Components/AppSidebar.vue';
import AppSidebarHeader from '@/Components/AppSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/Types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    sidebarMenus?: Array<any>;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    sidebarMenus: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar :menus="sidebarMenus" />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
    </AppShell>
</template>

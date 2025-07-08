<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/types';

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

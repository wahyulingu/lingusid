<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
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
    <AppLayout :breadcrumbs="breadcrumbs" :sidebar-menus="sidebarMenus">
        <slot />
    </AppLayout>
</template>

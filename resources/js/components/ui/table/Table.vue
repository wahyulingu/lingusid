<script setup lang="ts">
import { HTMLAttributes, computed } from 'vue'
import { tv } from 'tailwind-variants'
import { cn } from '@/lib/utils'

const props = defineProps<{
    class?: HTMLAttributes['class']
}>()

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props
    return delegated
})
</script>

<template>
    <div class="relative w-full overflow-auto">
        <table :class="cn('w-full caption-bottom text-sm', props.class)" v-bind="delegatedProps">
            <slot />
        </table>
    </div>
</template>

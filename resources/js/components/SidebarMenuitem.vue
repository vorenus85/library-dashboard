<template>
    <li class="sidebar-menuitem">
        <RouterLink :to="path">
            <UiIcon :icon="icon" class="sidebar-menuitem-icon" />
            {{ title }}</RouterLink
        >
    </li>
</template>
<script setup>
import UiIcon from '@/components/UiIcon.vue'

defineProps({
    icon: { type: String, required: true },
    path: { type: String, required: true },
    title: { type: String, required: true },
})
</script>

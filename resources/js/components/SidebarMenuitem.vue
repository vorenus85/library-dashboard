<template>
    <li class="sidebar-menuitem">
        <RouterLink :to="path"
            ><i :class="`pi pi-fw pi-${icon} sidebar-menuitem-icon`"></i> {{ title }}</RouterLink
        >
    </li>
</template>
<script setup>
defineProps({
    icon: { type: String, required: true },
    path: { type: String, required: true },
    title: { type: String, required: true },
})
</script>

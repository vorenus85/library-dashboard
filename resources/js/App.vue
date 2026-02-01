<script setup>
import { ConfirmDialog, Toast } from 'primevue'
import ProjectCredits from './components/ProjectCredits.vue'
</script>

<template>
    <RouterView />
    <div>
        <Toast />
        <ConfirmDialog />
        <slot />
    </div>
    <ProjectCredits />
</template>

<template>
    <RouterView />
    <div>
        <Toast />
        <ConfirmDialog />
        <slot />
    </div>
</template>

<script setup>
import { ConfirmDialog, Toast } from 'primevue'
</script>

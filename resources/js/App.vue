<template>
    <RouterView />
    <div>
        <Toast />
        <slot />
    </div>
</template>

<script setup>
import { Toast } from 'primevue'
</script>

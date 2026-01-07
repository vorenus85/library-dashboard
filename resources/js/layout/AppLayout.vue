<template>
    <div class="min-h-screen app-layout">
        <AppTopBar />
        <AppSideBar />

        <div class="layout-main-container">
            <main class="layout-main"><slot /></main>
        </div>
    </div>
</template>

<script setup>
import AppTopBar from '@/layout/AppTopBar.vue'
import AppSideBar from '@/layout/AppSideBar.vue'
</script>

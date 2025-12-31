<template>
    <div class="min-h-screen bg-gray-100 app-layout">
        <AppTopBar />
        <AppSideBar />

        <div class="layout-main-container">
            <main class="layout-main"><slot /></main>
        </div>
    </div>
</template>

<script setup>
import AppTopBar from './AppTopBar.vue'
import AppSideBar from './AppSideBar.vue'
</script>

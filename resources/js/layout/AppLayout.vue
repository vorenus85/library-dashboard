<template>
    <div
        class="min-h-screen layout-wrapper"
        :class="{ 'sidebar-is-toggled': libraryStore.isDrawerOpen }"
    >
        <AppTopBar />
        <AppSideBar />

        <div class="layout-main-container">
            <main class="layout-main"><slot /></main>
        </div>
        <div class="layout-mask animate-fadein" @click="libraryStore.toggleDrawer"></div>
    </div>
</template>

<script setup>
import AppTopBar from '@/layout/AppTopBar.vue'
import AppSideBar from '@/layout/AppSideBar.vue'
import { useLibraryStore } from '@/stores/library'
import { useLayout } from '@/composables/useLayout'
import { onBeforeRouteLeave } from 'vue-router'

const { isMobile } = useLayout()
const libraryStore = useLibraryStore()

onBeforeRouteLeave((to, from, next) => {
    if (!isMobile.value) {
        next()
        return
    }

    libraryStore.closeDrawer()

    setTimeout(() => {
        next()
    }, 250)
})
</script>

<template>
    <header class="bg-white shadow layout-topbar">
        <div class="layout-topbar-logo-container">
            <button
                @click="toggleDrawer"
                type="button"
                class="layout-menu-button layout-topbar-action"
            >
                <UiIcon icon="bars"></UiIcon>
            </button>
            <div class="app-name">
                <router-link to="/">
                    <div class="flex gap-3"><LogoIcon></LogoIcon> Library</div>
                </router-link>
            </div>
        </div>
        <div class="layout-topbar-actions">
            <button @click="toggleDarkMode" type="button" class="layout-topbar-action">
                <UiIcon icon="sun"></UiIcon>
            </button>
        </div>
    </header>
</template>
<script setup>
import UiIcon from '@/components/UiIcon.vue'
import LogoIcon from '@/components/LogoIcon.vue'
import { useLibraryStore } from '@/stores/library'

const libraryStore = useLibraryStore()

const toggleDrawer = () => {
    libraryStore.toggleDrawer()
}

const toggleDarkMode = () => {
    alert('Todo toggle dark mode logic')
}
</script>

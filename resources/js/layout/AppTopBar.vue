<template>
    <header class="bg-white shadow layout-topbar">
        <div class="layout-topbar-logo-container">
            <button
                @click="toggleSiderbar"
                type="button"
                class="layout-menu-button layout-topbar-action"
            >
                <UiIcon icon="bars"></UiIcon>
            </button>
            <div class="app-name">
                <router-link to="/">Library</router-link>
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

const toggleSiderbar = () => {
    alert('Todo toggle sidebar logic')
}

const toggleDarkMode = () => {
    alert('Todo toggle dark mode logic')
}
</script>

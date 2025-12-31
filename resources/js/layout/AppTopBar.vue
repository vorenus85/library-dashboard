<template>
    <header class="bg-white shadow layout-topbar">
        <div class="layout-topbar-logo-container">
            <button type="button" class="layout-menu-button layout-topbar-action">
                <UiIcon icon="bars"></UiIcon>
            </button>
            <div class="app-name">Library</div>
        </div>
        <div class="layout-topbar-actions">
            <button type="button" class="layout-topbar-action">
                <UiIcon icon="sun"></UiIcon>
            </button>
        </div>
    </header>
</template>
<script setup>
import UiIcon from '../components/UiIcon.vue'
</script>

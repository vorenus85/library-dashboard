<template>
    <div class="layout-sidebar">
        <ul class="sidebar-menu">
            <template v-for="menu in menus">
                <SidebarMenuitem :icon="menu.icon" :path="menu.path" :title="menu.title" />
            </template>
        </ul>
    </div>
</template>
<script setup>
import SidebarMenuitem from '../components/SidebarMenuitem.vue'

const menus = [
    {
        icon: 'home',
        path: '/',
        title: 'Dashboard',
    },
    {
        icon: 'book',
        path: '/books',
        title: 'Books',
    },
    {
        icon: 'bookmark',
        path: '/whislist',
        title: 'Whislist',
    },
    {
        icon: 'user',
        path: '/authors',
        title: 'Authors',
    },
    {
        icon: 'tags',
        path: '/genres',
        title: 'Genres',
    },
]
</script>

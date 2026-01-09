<template>
    <div class="layout-sidebar shadow">
        <ul class="sidebar-menu">
            <template v-for="menu in menus" :key="menu.title">
                <SidebarMenuitem :icon="menu.icon" :path="menu.path" :title="menu.title" />
            </template>
        </ul>
    </div>
</template>
<script setup>
import SidebarMenuitem from '@/components/SidebarMenuitem.vue'

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
        path: '/wishlist',
        title: 'Wishlist',
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

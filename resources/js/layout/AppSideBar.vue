<template>
    <div class="layout-sidebar shadow">
        <ul class="sidebar-menu">
            <template v-for="menu in menus" :key="menu.title">
                <SidebarMenuitem
                    :icon="menu.icon"
                    :route-name="menu.routeName"
                    :title="menu.title"
                />
            </template>
        </ul>
    </div>
</template>
<script setup>
import SidebarMenuitem from '@/components/SidebarMenuitem.vue'

const menus = [
    {
        icon: 'home',
        routeName: 'dashboard',
        title: 'Dashboard',
    },
    {
        icon: 'book',
        routeName: 'books',
        title: 'Books',
    },
    {
        icon: 'user',
        routeName: 'authors',
        title: 'Authors',
    },
    {
        icon: 'tags',
        routeName: 'genres',
        title: 'Genres',
    },
    {
        icon: 'sign-out',
        routeName: 'logout',
        title: 'Logout',
    },
]
</script>

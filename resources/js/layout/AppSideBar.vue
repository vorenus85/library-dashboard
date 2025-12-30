<template>
    <div class="layout-sidebar">
        <ul class="sidebar-menu">
            <li class="sidebar-menuitem">
                <RouterLink to="/"
                    ><i class="pi pi-fw pi-home sidebar-menuitem-icon"></i> Dashboard</RouterLink
                >
            </li>
            <li class="sidebar-menuitem">
                <RouterLink to="/books"
                    ><i class="pi pi-fw pi-book sidebar-menuitem-icon"></i> Books</RouterLink
                >
            </li>
            <li class="sidebar-menuitem">
                <RouterLink to="/whislist"
                    ><i class="pi pi-fw pi-bookmark sidebar-menuitem-icon"></i> Whislist</RouterLink
                >
            </li>
            <li class="sidebar-menuitem">
                <RouterLink to="/authors"
                    ><i class="pi pi-fw pi-user sidebar-menuitem-icon"></i> Authors</RouterLink
                >
            </li>
            <li class="sidebar-menuitem">
                <RouterLink to="/genres"
                    ><i class="pi pi-fw pi-tags sidebar-menuitem-icon"></i> Genre</RouterLink
                >
            </li>
        </ul>
    </div>
</template>
<script setup></script>

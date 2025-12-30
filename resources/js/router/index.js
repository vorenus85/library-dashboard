import { createRouter, createWebHistory } from 'vue-router'

import DashboardPage from '../views/pages/DashboardPage.vue'
import WhislistPage from '../views/pages/WhislistPage.vue'
import AuthorListPage from '../views/pages/AuthorListPage.vue'
import BookListPage from '../views/pages/BookListPage.vue'
import GenreListPage from '../views/pages/GenreListPage.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', name: 'home', component: DashboardPage },
        { path: '/books', name: 'books', component: BookListPage },
        { path: '/whislist', name: 'whislist', component: WhislistPage },
        { path: '/authors', name: 'authors', component: AuthorListPage },
        { path: '/genres', name: 'genres', component: GenreListPage },
    ],
})

export default router

import { createRouter, createWebHistory } from 'vue-router'

import DashboardPage from '../views/pages/DashboardPage.vue'
import WhislistPage from '../views/pages/WhislistPage.vue'

import AuthorListPage from '../views/pages/Author/ListPage.vue'
import AuthorCreatePage from '../views/pages/Author/CreatePage.vue'
import AuthorEditPage from '../views/pages/Author/EditPage.vue'

import BookListPage from '../views/pages/Book/ListPage.vue'
import BookCreatePage from '../views/pages/Book/CreatePage.vue'
import BookEditPage from '../views/pages/Book/EditPage.vue'

import GenreListPage from '../views/pages/Genre/ListPage.vue'
import GenreCreatePage from '../views/pages/Genre/CreatePage.vue'
import GenreEditPage from '../views/pages/Genre/EditPage.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', name: 'home', component: DashboardPage },
        { path: '/whislist', name: 'whislist', component: WhislistPage },

        { path: '/books', name: 'books', component: BookListPage },
        { path: '/books/create', name: 'books.create', component: BookCreatePage },
        { path: '/books/:bookId', name: 'books.show', component: BookEditPage },

        { path: '/authors', name: 'authors', component: AuthorListPage },
        { path: '/authors/:authorId', name: 'authors.show', component: AuthorEditPage },
        { path: '/authors/create', name: 'authors.create', component: AuthorCreatePage },

        { path: '/genres', name: 'genres', component: GenreListPage },
        { path: '/genres/create', name: 'genres.create', component: GenreCreatePage },
        { path: '/genres/:genreId', name: 'genres.show', component: GenreEditPage },
    ],
})

export default router

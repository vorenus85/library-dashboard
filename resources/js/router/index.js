import { createRouter, createWebHistory } from 'vue-router'

import NotFoundPage from '@/views/pages/NotFoundPage.vue'
import DashboardPage from '@/views/pages/DashboardPage.vue'
import LoginPage from '@/views/pages/LoginPage.vue'

import AuthorListPage from '@/views/pages/Author/ListPage.vue'
import AuthorCreatePage from '@/views/pages/Author/CreatePage.vue'
import AuthorEditPage from '@/views/pages/Author/EditPage.vue'

import BookListPage from '@/views/pages/Book/ListPage.vue'
import BookCreatePage from '@/views/pages/Book/CreatePage.vue'
import BookEditPage from '@/views/pages/Book/EditPage.vue'

import GenreListPage from '@/views/pages/Genre/ListPage.vue'
import GenreCreatePage from '@/views/pages/Genre/CreatePage.vue'
import GenreEditPage from '@/views/pages/Genre/EditPage.vue'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/:pathMatch(.*)*', name: 'notFound', component: NotFoundPage },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: DashboardPage,
            meta: {
                requiresAuth: true,
            },
        },
        { path: '/', name: 'login', component: LoginPage },

        {
            path: '/books',
            name: 'books',
            component: BookListPage,
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: '/books/create',
            name: 'books.create',
            component: BookCreatePage,
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: '/books/:bookId',
            name: 'books.show',
            component: BookEditPage,
            meta: {
                requiresAuth: true,
            },
        },

        {
            path: '/authors',
            name: 'authors',
            component: AuthorListPage,
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: '/authors/:authorId',
            name: 'authors.show',
            component: AuthorEditPage,
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: '/authors/create',
            name: 'authors.create',
            component: AuthorCreatePage,
            meta: {
                requiresAuth: true,
            },
        },

        {
            path: '/genres',
            name: 'genres',
            component: GenreListPage,
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: '/genres/create',
            name: 'genres.create',
            component: GenreCreatePage,
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: '/genres/:genreId',
            name: 'genres.show',
            component: GenreEditPage,
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: '/logout',
            name: 'logout',
            meta: { requiresAuth: true },
        },
    ],
})

router.beforeEach(async to => {
    const auth = useAuthStore()

    if (to.meta.requiresAuth) {
        if (!auth.loaded) {
            await auth.fetchUser()
        }

        if (!auth.user?.id) {
            return { name: 'login' }
        }
    }

    if (to.name === 'login' && auth.user?.id) {
        return { name: 'dashboard' }
    }

    if (to.name === 'logout') {
        await auth.logout()
        return { name: 'login' }
    }
})

export default router

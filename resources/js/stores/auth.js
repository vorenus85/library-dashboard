import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        loaded: false,
    }),
    actions: {
        async fetchUser() {
            try {
                // @TODO move axios to service
                const res = await axios.get('/auth/me', { withCredentials: true })
                this.user = res?.data
                this.loaded = true
            } catch {
                this.user = null
                this.loaded = true
            }
        },
        async login(email, password) {
            await axios.get('/sanctum/csrf-cookie', { withCredentials: true })

            const res = await axios.post(
                '/auth/login',
                { email, password },
                { withCredentials: true }
            )

            this.user = res.data.user
        },
        async logout() {
            // @TODO move axios to service
            await axios.post('/auth/logout', null, { withCredentials: true })
            this.user = null
            console.log('logout')
        },
    },
})

import './bootstrap'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import PrimeVue from 'primevue/config'
import ToastService from 'primevue/toastservice'
import ConfirmationService from 'primevue/confirmationservice'
import Aura from '@primeuix/themes/aura'
import 'primeicons/primeicons.css'

import '../css/app.css'

// Your main App.vue
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(ToastService)
app.use(ConfirmationService)
app.use(PrimeVue, {
    theme: {
        preset: Aura,
    },
})
app.use(router)

app.mount('#app')

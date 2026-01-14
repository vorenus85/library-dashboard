import { ref, onMounted, onUnmounted } from 'vue'

export function useDrawer() {
    const isMobile = ref(window.innerWidth <= 991)

    const update = () => {
        isMobile.value = window.innerWidth <= 991
    }

    onMounted(() => {
        window.addEventListener('resize', update)
    })

    onUnmounted(() => {
        window.removeEventListener('resize', update)
    })

    return {
        isMobile,
    }
}

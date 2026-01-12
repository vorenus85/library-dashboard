import { useToast } from 'primevue/usetoast'
import { reactive, ref } from 'vue'
import { useRoute } from 'vue-router'

export function useGenre() {
    const route = useRoute()
    const loading = ref(false)
    const genres = ref([])
    const genreId = route.params.genreId
    const formKey = ref(0)
    const toast = useToast()

    const initialValues = reactive({
        name: '',
        description: '',
    })

    const getGenresMinimal = async () => {
        loading.value = true

        try {
            const { data } = await axios.get('/genres/?minimal=1')
            genres.value = data
            loading.value = false
        } catch (e) {
            console.log(e)
            loading.value = false
        }
    }

    const getGenres = async () => {
        loading.value = true

        try {
            const { data } = await axios.get('/genres')
            genres.value = data
            loading.value = false
        } catch (e) {
            console.log(e)
            loading.value = false
        }
    }

    const getGenre = async () => {
        loading.value = true

        try {
            const { data } = await axios.get(`/genres/${genreId}`)
            initialValues.name = data.name
            initialValues.description = data.description
            formKey.value++ // to remount primevue/form to trigger form resolver/validation https://github.com/primefaces/primevue/issues/7792
            loading.value = false
        } catch (e) {
            console.log(e)
            loading.value = false
        }
    }

    const deleteGenre = async id => {
        loading.value = true

        try {
            await axios.delete(`/genres/${id}`)

            const idIndex = genres.value.findIndex(el => {
                return el.id === id
            })

            genres.value.splice(idIndex, 1)

            toast.add({
                severity: 'success',
                summary: 'Genre deleted successfully!',
                life: 3000,
            })

            loading.value = false
        } catch (e) {
            console.log(e)
            loading.value = false
        }
    }

    return {
        initialValues,
        getGenres,
        getGenresMinimal,
        getGenre,
        deleteGenre,
        genres,
        loading,
        genreId,
        formKey,
    }
}

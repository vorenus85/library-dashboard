import { reactive, ref } from 'vue'
import { useRoute } from 'vue-router'

export function useGenre() {
    const route = useRoute()
    const loading = ref(false)
    const genres = ref([])
    const genreId = route.params.genreId
    const formKey = ref(0)

    const genreInitialValues = reactive({
        name: '',
        description: '',
    })

    const getGenres = async () => {
        loading.value = true
        return await axios
            .get('/genres')
            .catch(error => {
                console.error(error)
            })
            .then(response => {
                genres.value = response.data
            })
            .finally(() => {
                loading.value = false
            })
    }

    const getGenre = async () => {
        return await axios
            .get(`/genres/${genreId}`)
            .then(response => {
                genreInitialValues.name = response.data.name
                genreInitialValues.description = response.data.description
                formKey.value++ // to remount primevue/form to trigger form resolver/validation https://github.com/primefaces/primevue/issues/7792
            })
            .catch(e => {
                console.error(e)
            })
    }

    return {
        genreInitialValues,
        getGenres,
        getGenre,
        genres,
        loading,
        genreId,
        formKey,
    }
}

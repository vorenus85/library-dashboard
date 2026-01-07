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
        return await axios
            .get('/genres/?minimal=1')
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

    const getGenres = async () => {
        loading.value = true
        return await axios
            .get('/genres')
            .catch(error => {
                console.error(error)
            })
            .then(response => {
                console.log(response.data)
                genres.value = response.data
            })
            .finally(() => {
                loading.value = false
            })
    }

    const getGenre = async () => {
        loading.value = true
        return await axios
            .get(`/genres/${genreId}`)
            .then(response => {
                initialValues.name = response.data.name
                initialValues.description = response.data.description
                formKey.value++ // to remount primevue/form to trigger form resolver/validation https://github.com/primefaces/primevue/issues/7792
            })
            .catch(e => {
                console.error(e)
            })
            .finally(() => {
                loading.value = false
            })
    }

    const deleteGenre = async id => {
        loading.value = true
        return await axios
            .delete(`/genres/${id}`)
            .catch(error => {
                console.error(error)
            })
            .then(() => {
                const idIndex = genres.value.findIndex(el => {
                    return el.id === id
                })
                genres.value.splice(idIndex, 1)
                toast.add({
                    severity: 'success',
                    summary: 'Genre deleted successfully!',
                    life: 3000,
                })
            })
            .finally(() => {
                loading.value = false
            })
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

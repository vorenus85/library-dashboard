import { useCustomToast } from '@/composables/useCustomToast'
import { reactive, ref } from 'vue'
import { useRoute } from 'vue-router'
import {
    fetchMinimalGenres,
    fetchGenres,
    fetchGenre,
    deleteGenreById,
} from '@/services/genreService'

export const useGenre = () => {
    const route = useRoute()
    const loading = ref(false)
    const genres = ref([])
    const genreId = route.params.genreId
    const formKey = ref(0)

    const { customToast } = useCustomToast()

    const initialValues = reactive({
        name: '',
        description: '',
    })

    const genreValidator = ({ values }) => {
        const errors = {}

        if (!values.name) {
            errors.name = [{ message: 'Genre name is required.' }]
        }

        if (Object.keys(errors).length) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            })
        }

        return {
            values,
            errors,
        }
    }

    const getGenresMinimal = async () => {
        loading.value = true

        try {
            const { data } = await fetchMinimalGenres()
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
            const { data } = await fetchGenres()
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
            const { data } = await fetchGenre(genreId)
            initialValues.name = data.name
            initialValues.description = data.description
            formKey.value++ // to remount primevue/form to trigger form resolver/validation https://github.com/primefaces/primevue/issues/7792
            loading.value = false
        } catch (e) {
            // console.log(e)
            loading.value = false
        }
    }

    const deleteGenre = async id => {
        loading.value = true

        try {
            await deleteGenreById(id)

            const idIndex = genres.value.findIndex(el => {
                return el.id === id
            })

            genres.value.splice(idIndex, 1)

            customToast.success('Genre deleted successfully!')

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
        genreValidator,
    }
}

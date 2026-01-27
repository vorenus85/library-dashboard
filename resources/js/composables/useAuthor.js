import { reactive, ref } from 'vue'
import { useCustomToast } from '@/composables/useCustomToast'
import { useRoute } from 'vue-router'
import {
    fetchAuthors,
    fetchMinimalAuthors,
    fetchAuthor,
    deleteAuthorById,
} from '@/services/authorService'

export const useAuthor = () => {
    const loading = ref(false)
    const authors = ref([])
    const formKey = ref(0)
    const route = useRoute()
    const authorId = route.params.authorId

    const { customToast } = useCustomToast()

    const initialValues = reactive({
        name: '',
        description: '',
    })

    const authorValidator = ({ values }) => {
        const errors = {}

        if (!values.name) {
            errors.name = [{ message: 'Author name is required.' }]
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

    const getAuthorsMinimal = async () => {
        loading.value = true

        try {
            const { data } = await fetchMinimalAuthors()
            authors.value = data
            loading.value = false
        } catch (e) {
            loading.value = false
            void e // to avoid unused variable lint error
            // console.error(e) -- IGNORE --
        }
    }

    const getAuthors = async () => {
        loading.value = true

        try {
            const { data } = await fetchAuthors()
            authors.value = data
            loading.value = false
        } catch (e) {
            loading.value = false
            void e // to avoid unused variable lint error
            // console.error(e) -- IGNORE --
        }
    }

    const getAuthor = async () => {
        loading.value = true

        try {
            const { data } = await fetchAuthor(authorId)
            initialValues.name = data.name
            initialValues.description = data.description
            formKey.value++ // to remount primevue/form to trigger form resolver/validation https://github.com/primefaces/primevue/issues/7792
            loading.value = false
        } catch (e) {
            loading.value = false
            void e // to avoid unused variable lint error
            // console.error(e) -- IGNORE --
        }
    }

    const deleteAuthor = async id => {
        loading.value = true

        try {
            await deleteAuthorById(id)
            const idIndex = authors.value.findIndex(el => {
                return el.id === id
            })
            authors.value.splice(idIndex, 1)

            customToast.success('Author deleted successfully!')

            loading.value = false
        } catch (e) {
            loading.value = false
            void e // to avoid unused variable lint error
            // console.error(e) -- IGNORE --
        }
    }

    return {
        deleteAuthor,
        getAuthors,
        getAuthorsMinimal,
        loading,
        authors,
        initialValues,
        formKey,
        authorId,
        getAuthor,
        authorValidator,
    }
}

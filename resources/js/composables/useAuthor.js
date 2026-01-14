import { reactive, ref } from 'vue'
import { useToast } from 'primevue'
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
    const toast = useToast()
    const formKey = ref(0)
    const route = useRoute()
    const authorId = route.params.authorId

    const initialValues = reactive({
        name: '',
        description: '',
    })

    const getAuthorsMinimal = async () => {
        loading.value = true

        try {
            const { data } = await fetchMinimalAuthors()
            authors.value = data
            loading.value = false
        } catch (e) {
            console.error(e)
            loading.value = false
        }
    }

    const getAuthors = async () => {
        loading.value = true

        try {
            const { data } = await fetchAuthors()
            authors.value = data
            loading.value = false
        } catch (e) {
            console.error(e)
            loading.value = false
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
            console.error(e)
            loading.value = false
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

            toast.add({
                severity: 'success',
                summary: 'Author deleted successfully!',
                life: 3000,
            })

            loading.value = false
        } catch (e) {
            console.error(e)
            loading.value = false
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
    }
}

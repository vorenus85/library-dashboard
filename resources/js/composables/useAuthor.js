import { reactive, ref } from 'vue'
import { useToast } from 'primevue'
import { useRoute } from 'vue-router'

export function useAuthor() {
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
        return await axios
            .get('/authors/?minimal=1')
            .catch(error => {
                console.error(error)
            })
            .then(response => {
                authors.value = response.data
            })
            .finally(() => {
                loading.value = false
            })
    }

    const getAuthors = async () => {
        loading.value = true
        return await axios
            .get('/authors')
            .catch(error => {
                console.error(error)
            })
            .then(response => {
                authors.value = response.data
            })
            .finally(() => {
                loading.value = false
            })
    }

    const getAuthor = async () => {
        loading.value = true
        return await axios
            .get(`/authors/${authorId}`)
            .then(response => {
                initialValues.name = response.data.name
                initialValues.description = response.data.description
                formKey.value++ // to remount primevue/form to trigger form resolver/validation https://github.com/primefaces/primevue/issues/7792
            })
            .catch(e => {
                console.log(e)
            })
            .finally(() => {
                loading.value = false
            })
    }

    const deleteAuthor = async id => {
        loading.value = true
        return await axios
            .delete(`/authors/${id}`)
            .catch(error => {
                console.error(error)
            })
            .then(() => {
                const idIndex = authors.value.findIndex(el => {
                    return el.id === id
                })
                authors.value.splice(idIndex, 1)

                toast.add({
                    severity: 'success',
                    summary: 'Author deleted successfully!',
                    life: 3000,
                })
            })
            .finally(() => {
                loading.value = false
            })
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

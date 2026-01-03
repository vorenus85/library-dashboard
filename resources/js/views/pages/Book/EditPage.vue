<template>
    <AppLayout>
        <PageTitle title="Edit book">
            <template v-slot:actions>
                <Button icon="pi pi-angle-left" label="Back to list" primary @click="backToList" />
            </template>
        </PageTitle>
        <div class="card" v-if="formKey">
            <Form
                :key="formKey"
                v-slot="$form"
                :initialValues
                :resolver
                @submit="onFormSubmit"
                class="flex flex-col gap-4 w-full md:w-112 sm:w-56"
                :validateOnValueUpdate="true"
                :validateOnBlur="true"
                :validateOnMount="true"
            >
                <div class="flex flex-col gap-1">
                    <label for="bookTitle">Book title</label>
                    <InputText
                        id="bookTitle"
                        name="title"
                        type="text"
                        placeholder="Harry Potter and the Half Blood Prince"
                        fluid
                    />
                    <Message
                        v-if="$form.title?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.title.error?.message }}</Message
                    >
                </div>
                <div class="flex flex-col gap-1">
                    <label for="author">Book author</label>
                    <Select
                        filter
                        v-model="selectedAuthor"
                        :options="authors"
                        optionLabel="name"
                        placeholder="Select author"
                        checkmark
                        id="author"
                        name="author"
                        :highlightOnSelect="false"
                        class="w-full md:w-56"
                    />
                </div>

                <div class="flex flex-col gap-1">
                    <label for="bookDescription">Book description</label>
                    <Textarea
                        id="bookDescription"
                        name="description"
                        rows="5"
                        cols="30"
                        style="resize: none"
                        placeholder="J. K. Rowling write the worldwide famous Harry Potter series"
                    />
                    <Message
                        v-if="$form.description?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.description.error?.message }}</Message
                    >
                </div>
                <div class="flex flex-col gap-1">
                    <label for="bookPublisedYear">Publised year</label>
                    <InputText
                        id="bookPublisedYear"
                        name="publised_year"
                        type="number"
                        placeholder="2000"
                        fluid
                    />
                    <Message
                        v-if="$form.publised_year?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.publised_year.error?.message }}</Message
                    >
                </div>
                <div class="flex flex-col gap-1">
                    <label for="bookIsbn">ISBN</label>
                    <InputText
                        id="bookIsbn"
                        name="isbn"
                        type="text"
                        placeholder="9781156923443"
                        fluid
                    />
                    <Message
                        v-if="$form.isbn?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.isbn.error?.message }}</Message
                    >
                </div>
                <div class="flex flex-col gap-1">
                    <label for="bookPages">Pages no.</label>
                    <InputText id="bookPages" name="pages" type="number" placeholder="430" fluid />
                    <Message
                        v-if="$form.pages?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.pages.error?.message }}</Message
                    >
                </div>
                <div class="flex flex-col gap-1">
                    <label for="bookPages">Is read</label>
                    <ToggleSwitch name="is_read" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="bookPages">Is wishlist</label>
                    <ToggleSwitch name="is_wishlist" />
                </div>
                <Button type="submit" severity="primary" label="Save" />
            </Form>
        </div>
    </AppLayout>
</template>
<script setup>
import { Form } from '@primevue/forms'
import { Button, InputText, Message, Select, Textarea, ToggleSwitch } from 'primevue'
import PageTitle from '../../../components/PageTitle.vue'
import AppLayout from '../../../layout/AppLayout.vue'
import { useRoute, useRouter } from 'vue-router'
import { onMounted, reactive, ref } from 'vue'
import { useToast } from 'primevue/usetoast'

const formKey = ref(0)
const route = useRoute()
const toast = useToast()
const selectedAuthor = ref({})
const authors = ref([])
const loading = ref(false)

const router = useRouter()

const resolver = ({ values }) => {
    const errors = {}

    if (!values.title) {
        errors.title = [{ message: 'Book title is required.' }]
    }

    return {
        values, // (Optional) Used to pass current form values to submit event.
        errors,
    }
}

const getAuthors = async () => {
    loading.value = true
    return await axios
        .get('/authors-simple')
        .catch(error => {
            loading.value = false
            console.error(error)
        })
        .then(response => {
            loading.value = false
            authors.value = response.data
        })
}

const initialValues = reactive({})

const backToList = () => {
    router.push({ name: 'books' })
}

const onFormSubmit = async ({ valid, values }) => {
    const bookId = route.params.bookId
    values.author = selectedAuthor.value
    if (valid) {
        await axios
            .put(`/books/${bookId}`, values)
            .catch(error => {
                toast.add({
                    severity: 'error',
                    summary: error.response.data.message,
                    life: 3000,
                })
            })
            .then(response => {
                toast.add({
                    severity: 'success',
                    summary: 'Book updated successfully!',
                    life: 3000,
                })

                setTimeout(() => {
                    router.push({ name: 'books' })
                }, 300)
            })
    }
}

const getBook = async () => {
    const bookId = route.params.bookId

    return await axios
        .get(`/books/${bookId}`)
        .then(response => {
            console.log(response.data)
            initialValues.title = response.data.title
            selectedAuthor.value = response.data.author
            initialValues.description = response.data.description
            initialValues.publised_year = response.data.publised_year
            initialValues.isbn = response.data.isbn
            initialValues.pages = response.data.pages
            initialValues.is_read = response.data.is_read
            initialValues.is_wishlist = response.data.is_wishlist
            formKey.value++ // to remount primevue/form to trigger form resolver/validation https://github.com/primefaces/primevue/issues/7792
        })
        .catch(e => {
            console.error(e)
        })
}

onMounted(() => {
    getAuthors()
    getBook()
})
</script>

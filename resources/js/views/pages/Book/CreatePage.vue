<template>
    <AppLayout>
        <PageTitle title="Add new book">
            <template v-slot:actions>
                <Button icon="pi pi-angle-left" label="Back to list" primary @click="toBookList" />
            </template>
        </PageTitle>
        <div class="card">
            <Form
                v-slot="$form"
                :initialValues
                :resolver
                @submit="onFormSubmit"
                class="flex flex-col gap-4 w-full md:w-112 sm:w-56"
                :validateOnValueUpdate="true"
                :validateOnBlur="true"
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
                <InputText name="image" type="hidden" />

                <div class="flex flex-col gap-1">
                    <label for="image">Book image</label>
                    <div class="file-upload-clean">
                        <FileUpload
                            name="file"
                            customUpload
                            @uploader="onImageUpload"
                            :multiple="false"
                            accept="image/*"
                            :maxFileSize="1000000"
                            @remove="onRemove"
                            @clear="onClear"
                            :disabled="isUploading || !!uploadedImage"
                        />
                    </div>

                    <ProgressBar v-if="isUploading" :value="uploadProgress" />
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
                    <label for="genres">Genres</label>
                    <MultiSelect
                        v-model="selectedGenres"
                        :options="genres"
                        name="genres[]"
                        optionLabel="name"
                        filter
                        placeholder="Select Genres"
                        :maxSelectedLabels="3"
                        class="w-full md:w-80"
                        display="chip"
                    />
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
import {
    Button,
    FileUpload,
    InputText,
    Message,
    MultiSelect,
    ProgressBar,
    Select,
    Textarea,
    ToggleSwitch,
} from 'primevue'
import PageTitle from '@/components/PageTitle.vue'
import AppLayout from '@/layout/AppLayout.vue'
import { onMounted, reactive, ref } from 'vue'
import { useToast } from 'primevue/usetoast'
import { useRedirects } from '@/composables/useRedirects.js'
import { useGenre } from '@/composables/useGenre'
import { useAuthor } from '@/composables/useAuthor'

const { genres, getGenresMinimal } = useGenre()
const { authors, getAuthorsMinimal } = useAuthor()

const { toBookList } = useRedirects()
const toast = useToast()
const selectedAuthor = ref({})
const selectedGenres = ref([])
const isUploading = ref(false)
const uploadProgress = ref(0)
const uploadedImage = ref(null)

const resolver = ({ values }) => {
    const errors = {}

    if (!values.title) {
        errors.title = [{ message: 'Book title is required.' }]
    }

    return {
        values,
        errors,
    }
}

const initialValues = reactive({
    title: '',
    description: '',
})

const onFormSubmit = async ({ valid, values }) => {
    values.image = uploadedImage.value
    values.genres = values.genres.map(e => {
        return e.id
    })

    if (valid) {
        try {
            await axios.post('/books', values)

            toast.add({
                severity: 'success',
                summary: 'Book created successfully!',
                life: 3000,
            })

            setTimeout(() => {
                toBookList()
            }, 300)
        } catch (error) {
            console.log(error)
            toast.add({
                severity: 'error',
                summary: error.response.data.message,
                life: 3000,
            })
        }
    }
}

const onRemove = () => {
    isUploading.value = false
    uploadProgress.value = 0
}

const onClear = () => {
    isUploading.value = false
    uploadProgress.value = 0
}

const onImageUpload = async event => {
    try {
        isUploading.value = true
        const file = event.files[0]

        const formData = new FormData()
        formData.append('file', file)

        const { data } = await axios.post('/books/image/upload', formData, {
            onUploadProgress: e => {
                if (!e.total) return

                uploadProgress.value = Math.round((e.loaded * 100) / e.total)
            },
        })

        uploadedImage.value = data.filename
    } catch (e) {
        isUploading.value = false
        console.error(e)
    }
}

onMounted(() => {
    getAuthorsMinimal()
    getGenresMinimal()
})
</script>

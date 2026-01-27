<template>
    <AppLayout>
        <PageTitle title="Edit book">
            <template #actions>
                <Button icon="pi pi-angle-left" label="Back to list" primary @click="toBookList" />
            </template>
        </PageTitle>
        <div v-if="formKey" class="card">
            <Form
                :key="formKey"
                v-slot="$form"
                :initial-values
                :resolver="bookValidator"
                class="flex flex-col gap-4 w-full lg:w-1/2"
                :validate-on-value-update="true"
                :validate-on-blur="true"
                :validate-on-mount="true"
                @submit="onFormSubmit"
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
                        id="author"
                        v-model="selectedAuthor"
                        filter
                        :options="authors"
                        option-label="name"
                        placeholder="Select author"
                        checkmark
                        name="author"
                        :highlight-on-select="false"
                        class="w-full md:w-56"
                    />
                    <Message
                        v-if="$form.author?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.author.error?.message }}</Message
                    >
                </div>

                <div class="flex flex-col gap-1">
                    <label for="genres">Genres</label>
                    <MultiSelect
                        v-model="selectedGenres"
                        :options="genres"
                        name="genres[]"
                        option-label="name"
                        filter
                        placeholder="Select Genres"
                        :max-selected-labels="3"
                        class="w-full"
                        display="chip"
                    />
                    <Message
                        v-if="$form.genres?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.genres.error?.message }}</Message
                    >
                </div>

                <InputText name="image" type="hidden" />

                <div class="flex flex-col gap-1">
                    <label for="image">Book image</label>

                    <template v-if="initialValues.image">
                        <div class="flex items-center gap-5">
                            <Image
                                :src="
                                    initialValues?.image
                                        ? `${initialValues.image_url}`
                                        : '/no-image.jpg'
                                "
                                :alt="initialValues?.title"
                                width="90"
                                preview
                            />
                            <Button
                                icon="pi pi-trash"
                                severity="danger"
                                aria-label="Delete image"
                                @click="deleteImage()"
                            />
                        </div>
                    </template>

                    <template v-if="!initialValues.image">
                        <div class="file-upload-clean">
                            <FileUpload
                                name="file"
                                custom-upload
                                :max-file-size="1000000"
                                accept="image/*"
                                :multiple="false"
                                :disabled="isUploading || !!uploadedImage"
                                @uploader="onImageUpload"
                                @remove="onRemoveBookImage"
                                @clear="onClearUploaderStatus"
                            />
                        </div>

                        <ProgressBar v-if="isUploading" :value="uploadProgress" />
                    </template>
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

                <div class="flex flex-col gap-1 w-full lg:w-1/2">
                    <label for="bookPublisedYear">Publised year</label>
                    <InputText
                        id="bookPublisedYear"
                        name="published_year"
                        type="number"
                        placeholder="2000"
                        fluid
                    />
                    <Message
                        v-if="$form.published_year?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.published_year.error?.message }}</Message
                    >
                </div>
                <div class="flex flex-col gap-1 w-full lg:w-1/2">
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
                <div class="flex flex-col gap-1 w-full lg:w-1/2">
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
                <div class="flex flex-col">
                    <Button
                        type="submit"
                        severity="primary"
                        label="Save"
                        class="ml-auto"
                        size="large"
                        style="width: 150px"
                    />
                </div>
            </Form>
        </div>
    </AppLayout>
</template>
<script setup>
import { Form } from '@primevue/forms'
import {
    Button,
    FileUpload,
    Image,
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
import { useRoute } from 'vue-router'
import { onMounted, ref } from 'vue'
import { useCustomToast } from '@/composables/useCustomToast'
import { useRedirects } from '@/composables/useRedirects'
import { useGenre } from '@/composables/useGenre'
import { useAuthor } from '@/composables/useAuthor'
import { updateBookById, fetchBook } from '@/services/bookService'
import { useBook } from '@/composables/useBook'

const { genres, getGenresMinimal } = useGenre()
const { authors, getAuthorsMinimal } = useAuthor()
const { toBookList } = useRedirects()
const {
    initialValues,
    bookValidator,
    isUploading,
    uploadProgress,
    uploadedImage,
    deleteImage,
    onImageUpload,
    onRemoveBookImage,
    onClearUploaderStatus,
    bookId,
} = useBook()

const formKey = ref(0)
const route = useRoute()
const { customToast } = useCustomToast()
const selectedAuthor = ref({})
const selectedGenres = ref([])

const onFormSubmit = async ({ valid, values }) => {
    if (valid) {
        try {
            values.author = selectedAuthor.value
            values.image = uploadedImage.value
            values.genres = values.genres.map(e => {
                return e.id
            })

            await updateBookById(bookId.value, values)

            customToast.success('Book updated successfully!')

            setTimeout(() => {
                toBookList()
            }, 300)
        } catch (e) {
            void e // to avoid unused variable lint error
            // console.error(e) -- IGNORE --
        }
    }
}

const getBook = async () => {
    try {
        const { data } = await fetchBook(bookId.value)
        initialValues.title = data.title
        selectedAuthor.value = data.author
        selectedGenres.value = data.genres.map(e => {
            return { id: e.id, name: e.name }
        })
        initialValues.author = selectedAuthor.value
        initialValues.genres = selectedGenres.value
        initialValues.description = data.description
        initialValues.published_year = data.published_year
        initialValues.isbn = data.isbn
        initialValues.image = data.image
        initialValues.image_url = data.image_url
        uploadedImage.value = initialValues.image
        initialValues.pages = data.pages
        initialValues.is_read = data.is_read
        initialValues.is_wishlist = data.is_wishlist
        formKey.value++ // to remount primevue/form to trigger form resolver/validation https://github.com/primefaces/primevue/issues/7792
    } catch (e) {
        void e // to avoid unused variable lint error
        // console.error(e) -- IGNORE --
    }
}

onMounted(() => {
    bookId.value = route.params.bookId
    getBook()
    getAuthorsMinimal()
    getGenresMinimal()
})
</script>

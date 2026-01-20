<template>
    <AppLayout>
        <PageTitle title="Add new book">
            <template #actions>
                <Button icon="pi pi-angle-left" label="Back to list" primary @click="toBookList" />
            </template>
        </PageTitle>
        <div class="card">
            <Form
                v-slot="$form"
                :initial-values
                :resolver="bookValidator"
                class="flex flex-col gap-4 w-full lg:w-1/2"
                :validate-on-value-update="true"
                :validate-on-blur="true"
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
                        class="w-full md:w-80"
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
                    <div class="file-upload-clean">
                        <FileUpload
                            name="file"
                            customUpload
                            @uploader="onImageUpload"
                            :multiple="false"
                            accept="image/*"
                            :maxFileSize="1000000"
                            @remove="onRemoveBookImage"
                            @clear="onClearUploaderStatus"
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
import { onMounted, ref } from 'vue'
import { useToast } from 'primevue/usetoast'
import { useRedirects } from '@/composables/useRedirects.js'
import { useGenre } from '@/composables/useGenre'
import { useAuthor } from '@/composables/useAuthor'
import { createBook } from '@/services/bookService'
import { useBook } from '@/composables/useBook'

const { genres, getGenresMinimal } = useGenre()
const { authors, getAuthorsMinimal } = useAuthor()
const {
    bookValidator,
    initialValues,
    isUploading,
    uploadProgress,
    onRemoveBookImage,
    onClearUploaderStatus,
    onImageUpload,
    uploadedImage,
} = useBook()
const { toBookList } = useRedirects()
const toast = useToast()

const selectedAuthor = ref({})
const selectedGenres = ref([])

const onFormSubmit = async ({ valid, values }) => {
    if (valid) {
        try {
            values.image = uploadedImage.value
            values.genres = values.genres.map(e => {
                return e.id
            })
            await createBook(values)

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

onMounted(() => {
    getAuthorsMinimal()
    getGenresMinimal()
})
</script>

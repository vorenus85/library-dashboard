<template>
    <AppLayout>
        <PageTitle title="Books">
            <template v-slot:actions>
                <Button icon="pi pi-plus" label="New" primary @click="toCreateBook" />
                <SplitButton
                    icon="pi pi-export"
                    label="Export"
                    :model="exportTypes"
                    severity="secondary"
                />
            </template>
        </PageTitle>
        <div class="card pages-list-books shadow list-page">
            <DataTable
                v-model:filters="filters"
                :value="books"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                tableStyle="min-width: 50rem"
                :loading="loading"
                :globalFilterFields="['title', 'description', 'author.name']"
                dataKey="id"
            >
                <template #header>
                    <div class="flex justify-start gap-5">
                        <Button
                            type="button"
                            icon="pi pi-filter-slash"
                            label="Clear"
                            variant="outlined"
                            @click="clearFilter()"
                            class="mr-auto"
                        />
                        <IconField>
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText
                                v-model="filters['global'].value"
                                placeholder="Keyword Search"
                            />
                        </IconField>
                        <Select
                            filter
                            :options="genres"
                            :value="selectedGenre"
                            optionLabel="name"
                            placeholder="Select a Genre"
                            class="w-full md:w-56"
                            @change="changeGenreFilter"
                            showClear
                            :key="genreSelectKey"
                        >
                        </Select>
                    </div>
                </template>
                <template #empty> No results found. </template>
                <Column sortable field="title" header="Title" style="width: 25%">
                    <template #body="slotProps">
                        <div class="flex gap-5 items-center">
                            <Image
                                :src="
                                    slotProps.data?.image
                                        ? `/storage/uploads/${slotProps.data.image}`
                                        : '/no-image.jpg'
                                "
                                :alt="slotProps.data?.title"
                                preview
                                width="45"
                            />
                            <Chip :label="slotProps.data?.title" />
                        </div>
                    </template>
                </Column>
                <Column sortable field="author.name" header="Author" style="width: 15%">
                    <template #body="slotProps">
                        <Button asChild variant="link" v-slot="buttonProps">
                            <RouterLink
                                :to="{
                                    name: 'authors.show',
                                    params: {
                                        authorId: slotProps.data?.author?.id,
                                    },
                                }"
                                :class="buttonProps.class + ' px-0'"
                                >{{ slotProps.data?.author?.name }}</RouterLink
                            >
                        </Button>
                    </template>
                </Column>
                <Column field="is_read" header="Is read" style="width: 10%">
                    <template #body="slotProps">
                        <ToggleSwitch
                            :model-value="Boolean(slotProps.data.is_read)"
                            @change="toggleRead(slotProps.data.id)"
                        /> </template
                ></Column>
                <Column field="is_wishlist" header="Is wishlist" style="width: 10%">
                    <template #body="slotProps">
                        <ToggleSwitch
                            :model-value="Boolean(slotProps.data.is_wishlist)"
                            @change="toggleWishlist(slotProps.data.id)"
                        /> </template
                ></Column>
                <Column field="description" header="Description" style="width: 25%"></Column>
                <Column field="pages" header="Pages no." style="width: 25%"></Column>
                <Column header="Actions" style="width: 10%">
                    <template #body="slotProps">
                        <div class="flex items-center justify-start gap-3">
                            <Button severity="info" asChild v-slot="buttonProps">
                                <RouterLink
                                    :to="{
                                        name: 'books.show',
                                        params: {
                                            bookId: slotProps.data?.id,
                                        },
                                    }"
                                    :class="buttonProps.class"
                                    >Edit</RouterLink
                                >
                            </Button>
                            <Button
                                icon="pi pi-trash"
                                severity="danger"
                                @click="deleteConfirm(slotProps.data.id)"
                            />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </AppLayout>
</template>
<script setup>
import {
    Button,
    Chip,
    Column,
    DataTable,
    IconField,
    Image,
    InputIcon,
    InputText,
    Select,
    SplitButton,
    ToggleSwitch,
    useToast,
    useConfirm,
} from 'primevue'
import PageTitle from '@/components/PageTitle.vue'
import AppLayout from '@/layout/AppLayout.vue'
import { onMounted, ref, watch } from 'vue'
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import { useRedirects } from '@/composables/useRedirects'
import { useGenre } from '@/composables/useGenre'
import { useBooksExport } from '@/composables/useBooksExport'
import { useCustomConfirm } from '@/composables/useCustomConfirm'

const { confirmAction } = useCustomConfirm()
const { exportBooksCsv, exportBooksExcel } = useBooksExport()
const confirm = useConfirm()
const toast = useToast()
const { genres, getGenresMinimal } = useGenre()
const { toCreateBook } = useRedirects()

const filters = ref()
const allBooks = ref([])
const books = ref([])
const loading = ref(false)
const selectedGenre = ref(null)
const genreSelectKey = ref(1)

const exportTypes = [
    {
        label: 'Export CSV',
        command: () => {
            exportBooksCsv()
        },
    },
    {
        label: 'Export Excel',
        command: () => {
            exportBooksExcel()
        },
    },
]

const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        title: {
            operator: FilterOperator.OR,
            constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
        },
        description: {
            operator: FilterOperator.OR,
            constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
        },
        'author.name': {
            operator: FilterOperator.OR,
            constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
        },
    }
}

initFilters()

const deleteConfirm = id => {
    confirmAction(confirm, {
        action: () => {
            deleteBook(id)
        },
        acceptLabel: 'Delete',
    })
}

const toggleRead = async id => {
    try {
        await axios.patch(`/books/${id}/toggle-read`)

        books.value = books.value.map(book =>
            book.id === id ? { ...book, is_read: !book.is_read } : book
        )
    } catch (error) {
        console.error(error)
    }
}

const toggleWishlist = async id => {
    try {
        await axios.patch(`/books/${id}/toggle-wishlist`)

        books.value = books.value.map(book =>
            book.id === id ? { ...book, is_wishlist: !book.is_wishlist } : book
        )
    } catch (e) {
        console.error(e)
    }
}

const getBooks = async () => {
    loading.value = true

    try {
        const { data } = await axios.get('/books')

        allBooks.value = data
        books.value = data

        loading.value = false
    } catch (e) {
        console.error(e)
        loading.value = false
    }
}

const deleteBook = async id => {
    loading.value = true

    try {
        await axios.delete(`/books/${id}`)

        const indexId = books.value.findIndex(el => {
            return el.id === id
        })

        books.value.splice(indexId, 1)

        toast.add({
            severity: 'success',
            summary: 'Book deleted successfully',
            life: 3000,
        })

        loading.value = false
    } catch (e) {
        console.error(e)
        loading.value = false
    }
}

const clearFilter = () => {
    initFilters()
    selectedGenre.value = null
    genreSelectKey.value++
}

const changeGenreFilter = event => {
    selectedGenre.value = event.value
}

watch(selectedGenre, async (newGenre, oldGenre) => {
    if (!newGenre?.id) {
        books.value = allBooks.value
        return
    }

    books.value = allBooks.value.filter(book => book.genres.some(genre => genre.id === newGenre.id))
})

onMounted(() => {
    getBooks()
    getGenresMinimal()
})
</script>

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
                            width="80px"
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
                        <div class="max-sm:hidden">
                            <Select
                                filter
                                :options="genres"
                                :value="selectedGenre"
                                optionLabel="name"
                                placeholder="Select a Genre"
                                @change="changeGenreFilter"
                                showClear
                                :key="genreSelectKey"
                            >
                            </Select>
                        </div>
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
                            />
                            <Button asChild v-slot="buttonProps" severity="secondary">
                                <RouterLink
                                    :to="{
                                        name: 'books.show',
                                        params: {
                                            bookId: slotProps.data?.id,
                                        },
                                    }"
                                    :class="buttonProps.class"
                                    >{{ slotProps.data?.title }}</RouterLink
                                >
                            </Button>
                        </div>
                    </template>
                </Column>
                <Column sortable field="author.name" header="Author" style="width: 10%"> </Column>
                <Column sortable field="is_read" header="Is read" style="width: 5%">
                    <template #body="slotProps">
                        <ToggleSwitch
                            :model-value="Boolean(slotProps.data.is_read)"
                            @change="toggleRead(slotProps.data.id)"
                        /> </template
                ></Column>
                <Column sortable field="is_wishlist" header="Is wishlist" style="width: 5%">
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
import { useBook } from '@/composables/useBook'

const { confirmAction } = useCustomConfirm()
const { exportBooksCsv, exportBooksExcel } = useBooksExport()
const confirm = useConfirm()
const { genres, getGenresMinimal } = useGenre()
const { toCreateBook } = useRedirects()
const { loading, allBooks, books, deleteBook, getBooks, toggleRead, toggleWishlist } = useBook()

const filters = ref()
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

<template>
    <AppLayout>
        <PageTitle title="Books">
            <template v-slot:actions>
                <Button icon="pi pi-plus" label="New" primary @click="toCreateBook" />
                <Button
                    icon="pi pi-file-export"
                    label="Export"
                    severity="info"
                    @click="exportBooks()"
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
                :globalFilterFields="['name', 'description', 'author.name']"
                dataKey="id"
            >
                <template #header>
                    <div class="flex justify-between">
                        <Button
                            type="button"
                            icon="pi pi-filter-slash"
                            label="Clear"
                            variant="outlined"
                            @click="clearFilter()"
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
                            <Button primary asChild v-slot="buttonProps">
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
                                @click="deleteBook(slotProps.data.id)"
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
    ToggleSwitch,
    useToast,
} from 'primevue'
import PageTitle from '@/components/PageTitle.vue'
import AppLayout from '@/layout/AppLayout.vue'
import { onMounted, ref } from 'vue'
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import { useRedirects } from '@/composables/useRedirects'

const toast = useToast()
const filters = ref()
const { toCreateBook } = useRedirects()
const books = ref([])
const loading = ref(false)

const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        name: {
            operator: FilterOperator.AND,
            constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
        },
        description: {
            operator: FilterOperator.AND,
            constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
        },
        'author.name': {
            operator: FilterOperator.AND,
            constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
        },
    }
}

initFilters()

const clearFilter = () => {
    initFilters()
}

const toggleRead = async id => {
    return await axios
        .patch(`/books/${id}/toggle-read`)
        .catch(e => {
            console.log(e)
        })
        .then(response => {
            // console.log(response)
        })
}

const toggleWishlist = async id => {
    return await axios
        .patch(`/books/${id}/toggle-wishlist`)
        .catch(e => {
            console.log(e)
        })
        .then(response => {})
}

const getBooks = async () => {
    loading.value = true
    return await axios
        .get('/books')
        .catch(error => {
            loading.value = false
            console.error(error)
        })
        .then(response => {
            loading.value = false
            books.value = response.data
        })
}

const deleteBook = async id => {
    loading.value = true

    return await axios
        .delete(`/books/${id}`)
        .catch(e => {
            loading.value = false
            console.log(e)
        })
        .then(response => {
            loading.value = false
            const indexId = books.value.findIndex(el => {
                return el.id === id
            })

            books.value.splice(indexId, 1)

            toast.add({
                severity: 'success',
                summary: 'Book deleted successfully',
                life: 3000,
            })
        })
}

const exportBooks = () => {
    alert('Todo export books')
}

onMounted(() => {
    getBooks()
})
</script>

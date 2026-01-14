<template>
    <div class="card">
        <WidgetTitle title="Wishlist Books" />
        <DataTable
            v-model:filters="filters"
            :value="wishListedBooks"
            paginator
            :rows="5"
            :rowsPerPageOptions="[5, 10, 20, 50]"
            tableStyle="min-width: 50rem"
            :loading="loading"
            :globalFilterFields="['title', 'description', 'author.name']"
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
                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
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
                            class="book-image"
                            width="90"
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
            <Column field="description" header="Description" style="width: 25%"></Column>
            <Column field="pages" header="Pages no." style="width: 25%"></Column>
        </DataTable>
    </div>
</template>
<script setup>
import { Button, Chip, Column, DataTable, IconField, Image, InputIcon, InputText } from 'primevue'
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import { onMounted, ref } from 'vue'
import WidgetTitle from '@/components/WidgetTitle.vue'
import { fetchWishlistBooks } from '@/services/bookService'

const wishListedBooks = ref([])
const filters = ref()
const loading = ref(false)

const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        title: {
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

const getWishlistedBooks = async () => {
    loading.value = true
    try {
        const response = await fetchWishlistBooks()

        wishListedBooks.value = response.data
        loading.value = false
    } catch (error) {
        console.log(error)
        loading.value = false
    }
}

onMounted(() => {
    getWishlistedBooks()
})
</script>

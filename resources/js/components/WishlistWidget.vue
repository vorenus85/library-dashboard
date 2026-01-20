<template>
    <div class="card">
        <WidgetTitle title="Recently Wishlisted Books" />
        <DataTable
            v-model:filters="filters"
            :value="wishListedBooks"
            table-style="min-width: 50rem"
            :loading="loading"
            :global-filter-fields="['title', 'description', 'author.name']"
            data-key="id"
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
                        />
                        <Button v-slot="buttonProps" as-child severity="secondary">
                            <RouterLink
                                :to="{
                                    name: 'books.show',
                                    params: {
                                        bookId: slotProps.data?.id,
                                    },
                                }"
                                :class="buttonProps.class"
                            >
                                {{ slotProps.data?.title }}</RouterLink
                            >
                        </Button>
                    </div>
                </template>
            </Column>
            <Column sortable field="author.name" header="Author" style="width: 10%"> </Column>
            <Column field="description" header="Description" style="width: 25%; min-width: 250px">
            </Column>
            <Column field="pages" header="Pages no." style="width: 10%"></Column>
            <Column field="wishlisted_at" header="Wishlisted at" style="width: 10%">
                <template #body="slotProps">
                    <Chip>
                        <span class="text-nowrap">{{ slotProps.data.wishlisted_at }}</span></Chip
                    >
                </template></Column
            >
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

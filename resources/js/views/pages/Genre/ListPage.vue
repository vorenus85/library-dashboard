<template>
    <AppLayout>
        <PageTitle title="Genres">
            <template #actions>
                <Button icon="pi pi-plus" label="New" primary @click="toCreateGenre" />
            </template>
        </PageTitle>
        <div class="card pages-list-genres shadow list-page">
            <DataTable
                v-model:filters="filters"
                :value="genres"
                paginator
                :rows="10"
                :rows-per-page-options="[5, 10, 20, 50]"
                table-style="min-width: 50rem"
                :loading="loading"
                :global-filter-fields="['name', 'description']"
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
                            <InputText
                                v-model="filters['global'].value"
                                placeholder="Keyword Search"
                            />
                        </IconField>
                    </div>
                </template>
                <template #empty> No results found. </template>
                <Column sortable field="name" header="Name" style="width: 25%">
                    <template #body="slotProps"> <Chip :label="slotProps.data.name" /></template>
                </Column>
                <Column sortable field="books_count" header="Books" style="width: 5%"></Column>
                <Column field="description" header="Description" style="width: 25%"></Column>
                <Column header="Actions" style="width: 10%">
                    <template #body="slotProps">
                        <div class="flex items-center justify-list gap-3">
                            <Button v-slot="buttonProps" severity="info" as-child>
                                <RouterLink
                                    :to="{
                                        name: 'genres.show',
                                        params: {
                                            genreId: slotProps.data?.id,
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
import { onMounted, ref } from 'vue'
import PageTitle from '@/components/PageTitle.vue'
import AppLayout from '@/layout/AppLayout.vue'
import {
    Button,
    Chip,
    Column,
    DataTable,
    IconField,
    InputIcon,
    InputText,
    useConfirm,
} from 'primevue'

import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import { useRedirects } from '@/composables/useRedirects.js'
import { useGenre } from '@/composables/useGenre'
import { useCustomConfirm } from '@/composables/useCustomConfirm'

const confirm = useConfirm()
const { loading, genres, getGenres, deleteGenre } = useGenre()
const { toCreateGenre } = useRedirects()
const { confirmAction } = useCustomConfirm()

const filters = ref()

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
    }
}

initFilters()

const clearFilter = () => {
    initFilters()
}

const deleteConfirm = id => {
    confirmAction(confirm, {
        action: () => {
            deleteGenre(id)
        },
        acceptLabel: 'Delete',
    })
}

onMounted(() => {
    getGenres()
})
</script>

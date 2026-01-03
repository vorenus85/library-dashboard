<template>
    <AppLayout>
        <PageTitle title="Authors">
            <template v-slot:actions>
                <Button icon="pi pi-plus" label="New" primary @click="toCreateAuthor" />
            </template>
        </PageTitle>
        <div class="card pages-list-genres shadow list-page">
            <DataTable
                v-model:filters="filters"
                :value="authors"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                tableStyle="min-width: 50rem"
                :loading="loading"
                :globalFilterFields="['name', 'description']"
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
                <Column sortable field="name" header="Name" style="width: 25%">
                    <template #body="slotProps"> <Chip :label="slotProps.data?.name" /></template
                ></Column>
                <Column field="books_count" header="Book No." style="width: 5%"></Column>
                <Column field="description" header="Description" style="width: 25%"></Column>
                <Column header="Actions" style="width: 10%">
                    <template #body="slotProps">
                        <div class="flex items-center justify-start gap-3">
                            <Button primary asChild v-slot="buttonProps">
                                <RouterLink
                                    :to="{
                                        name: 'authors.show',
                                        params: {
                                            authorId: slotProps.data?.id,
                                        },
                                    }"
                                    :class="buttonProps.class"
                                    >Edit</RouterLink
                                >
                            </Button>
                            <Button
                                icon="pi pi-trash"
                                severity="danger"
                                @click="deleteAuthor(slotProps.data.id)"
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
import PageTitle from '../../../components/PageTitle.vue'
import AppLayout from '../../../layout/AppLayout.vue'
import { Button, Chip, Column, DataTable, IconField, InputIcon, InputText } from 'primevue'
import { RouterLink, useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'

const filters = ref()
const toast = useToast()
const authors = ref([])
const loading = ref(false)
const router = useRouter()

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

const toCreateAuthor = () => {
    router.push({ name: 'authors.create' })
}

const getAuthors = async () => {
    loading.value = true
    return await axios
        .get('/authors')
        .catch(error => {
            loading.value = false
            console.error(error)
        })
        .then(response => {
            loading.value = false
            authors.value = response.data
        })
}

const deleteAuthor = async id => {
    loading.value = true
    return await axios
        .delete(`/authors/${id}`)
        .catch(error => {
            loading.value = false
            console.error(error)
        })
        .then(() => {
            loading.value = false
            const idIndex = authors.value.findIndex(el => {
                return el.id === id
            })
            authors.value.splice(idIndex, 1)

            toast.add({
                severity: 'success',
                summary: 'Author deleted successfully!',
                life: 3000,
            })
        })
}

onMounted(() => {
    getAuthors()
})
</script>

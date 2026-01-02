<template>
    <AppLayout>
        <PageTitle title="Authors">
            <template v-slot:actions>
                <Button icon="pi pi-plus" label="New" primary @click="toCreateAuthor" />
                <Button icon="pi pi-file-export" label="Export" severity="info" />
            </template>
        </PageTitle>
        <div class="card pages-list-genres shadow list-page">
            <DataTable
                :value="authors"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                tableStyle="min-width: 50rem"
                :loading="loading"
            >
                <Column sortable field="name" header="Name" style="width: 25%">
                    <template #body="slotProps"> <Chip :label="slotProps.data.name" /></template
                ></Column>
                <Column field="description" header="Description" style="width: 25%"></Column>
                <Column header="Actions" style="width: 10%">
                    <template #body="slotProps">
                        <div class="flex items-center justify-start gap-3">
                            <Button icon="pi pi-pen-to-square" label="Edit" primary />
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
import { Button, Chip, Column, DataTable } from 'primevue'
import { useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'

const toast = useToast()
const authors = ref([])
const loading = ref(false)
const router = useRouter()

const toCreateAuthor = () => {
    router.push({ name: 'authors.create' })
}

const getAuthors = async () => {
    loading.value = true
    return await axios
        .get('/api/authors')
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
        .delete(`/api/authors/${id}`)
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

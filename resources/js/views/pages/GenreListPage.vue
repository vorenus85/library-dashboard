<template>
    <AppLayout>
        <PageTitle title="Genres">
            <template v-slot:actions>
                <Button icon="pi pi-plus" label="New" primary @click="toNewGenre" />
                <Button icon="pi pi-file-export" label="Export" severity="info" />
            </template>
        </PageTitle>
        <div class="card pages-list-genres shadow list-page">
            <DataTable
                :value="genres"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                tableStyle="min-width: 50rem"
                :loading="loading"
            >
                <Column sortable field="name" header="Name" style="width: 25%">
                    <template #body="slotProps"> <Chip :label="slotProps.data.name" /></template>
                </Column>
                <Column field="description" header="Description" style="width: 25%"></Column>
                <Column header="Actions" style="width: 10%">
                    <template #body="slotProps">
                        <div class="flex items-center justify-list gap-3">
                            <Button icon="pi pi-pen-to-square" label="Edit" primary />
                            <Button
                                icon="pi pi-trash"
                                severity="danger"
                                @click="deleteGenre(slotProps.data.id)"
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
import PageTitle from '../../components/PageTitle.vue'
import AppLayout from '../../layout/AppLayout.vue'
import { Button, Chip, Column, DataTable, ToggleSwitch } from 'primevue'
import { useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'

const toast = useToast()
const genres = ref([])
const loading = ref(false)
const router = useRouter()

const toNewGenre = () => {
    router.push({ name: 'genres.create' })
}

const getGenres = async () => {
    loading.value = true
    return await axios
        .get('/api/genres')
        .catch(error => {
            loading.value = false
            console.error(error)
        })
        .then(response => {
            loading.value = false
            genres.value = response.data
        })
}

const deleteGenre = async id => {
    loading.value = true
    return await axios
        .delete(`/api/genres/${id}`)
        .catch(error => {
            loading.value = false
            console.error(error)
        })
        .then(() => {
            loading.value = false
            const idIndex = genres.value.findIndex(el => {
                return el.id === id
            })
            genres.value.splice(idIndex, 1)
            toast.add({
                severity: 'success',
                summary: 'Genre deleted successfully!',
                life: 3000,
            })
        })
}

onMounted(() => {
    getGenres()
})
</script>

<template>
    <AppLayout>
        <div class="card pages-list-genres">
            <PageTitle title="Genres" />
            <div class="card">
                <DataTable
                    :value="genres"
                    paginator
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                    tableStyle="min-width: 50rem"
                >
                    <Column sortable field="name" header="Name" style="width: 25%"></Column>
                    <Column field="description" header="Description" style="width: 25%"></Column>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import { onMounted, ref } from 'vue'
import PageTitle from '../../components/PageTitle.vue'
import AppLayout from '../../layout/AppLayout.vue'
import { Column, DataTable } from 'primevue'

const genres = ref([])

const getGenres = async () => {
    return await axios
        .get('/api/genres')
        .catch(error => {
            console.error(error)
        })
        .then(response => {
            genres.value = response.data
        })
}

onMounted(() => {
    getGenres()
})
</script>

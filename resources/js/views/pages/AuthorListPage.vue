<template>
    <AppLayout>
        <div class="card pages-list-genres">
            <PageTitle title="Authors" />
            <div class="card">
                <DataTable
                    :value="authors"
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

const authors = ref([])

const getAuthors = async () => {
    return await axios
        .get('/api/authors')
        .catch(error => {
            console.error(error)
        })
        .then(response => {
            authors.value = response.data
        })
}

onMounted(() => {
    getAuthors()
})
</script>

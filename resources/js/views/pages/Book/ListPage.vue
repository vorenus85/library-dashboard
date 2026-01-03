<template>
    <AppLayout>
        <PageTitle title="Books">
            <template v-slot:actions>
                <Button icon="pi pi-plus" label="New" primary @click="toCreateBook" />
                <Button icon="pi pi-file-export" label="Export" severity="info" />
            </template>
        </PageTitle>
        <div class="card pages-list-books shadow list-page">
            <DataTable
                :value="books"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                tableStyle="min-width: 50rem"
                :loading="loading"
            >
                <Column sortable field="title" header="Title" style="width: 25%"></Column>
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
import { Button, Column, DataTable, useToast } from 'primevue'
import PageTitle from '../../../components/PageTitle.vue'
import AppLayout from '../../../layout/AppLayout.vue'
import { useRouter } from 'vue-router'
import { onMounted, ref } from 'vue'
const toast = useToast()

const router = useRouter()
const books = ref([])
const loading = ref(false)

const toCreateBook = () => {
    router.push({ name: 'books.create' })
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

onMounted(() => {
    getBooks()
})
</script>

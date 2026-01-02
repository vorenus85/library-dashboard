<template>
    <AppLayout>
        <PageTitle title="Books">
            <template v-slot:actions>
                <Button icon="pi pi-plus" label="New" primary @click="toCreateBook" />
                <Button icon="pi pi-file-export" label="Export" severity="info" />
            </template>
        </PageTitle>
        <div class="card pages-list-books shadow list-page"></div>
    </AppLayout>
</template>
<script setup>
import { Button } from 'primevue'
import PageTitle from '../../../components/PageTitle.vue'
import AppLayout from '../../../layout/AppLayout.vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const toCreateBook = () => {
    router.push({ name: 'books.create' })
}
</script>

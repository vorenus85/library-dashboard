<template>
    <AppLayout>
        <PageTitle title="Add new genre">
            <template v-slot:actions>
                <Button
                    icon="pi pi-angle-left"
                    label="Back to list"
                    primary
                    @click="backToGenreList"
                />
            </template>
        </PageTitle>
    </AppLayout>
</template>
<script setup>
import { Button } from 'primevue'
import PageTitle from '../../components/PageTitle.vue'
import AppLayout from '../../layout/AppLayout.vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const backToGenreList = () => {
    router.push({ name: 'genres' })
}
</script>

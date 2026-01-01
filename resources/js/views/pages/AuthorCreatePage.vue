<template>
    <AppLayout>
        <PageTitle title="Add new author">
            <template v-slot:actions>
                <Button
                    icon="pi pi-angle-left"
                    label="Back to list"
                    primary
                    @click="backToAuthorsList"
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

const backToAuthorsList = () => {
    router.push({ name: 'authors' })
}
</script>

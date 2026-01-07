<template>
    <AppLayout>
        <PageTitle title="Edit genre">
            <template v-slot:actions>
                <Button icon="pi pi-angle-left" label="Back to list" primary @click="toGenreList" />
            </template>
        </PageTitle>
        <div class="card" v-if="formKey">
            <Form
                :key="formKey"
                v-slot="$form"
                :initialValues
                :resolver
                @submit="onFormSubmit"
                class="flex flex-col gap-4 w-full md:w-112 sm:w-56"
                :validateOnValueUpdate="true"
                :validateOnBlur="true"
                :validateOnMount="true"
            >
                <div class="flex flex-col gap-1">
                    <label for="genreName">Genre name</label>
                    <InputText id="genreName" name="name" type="text" placeholder="Sci-fi" fluid />
                    <Message
                        v-if="$form.name?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.name.error?.message }}</Message
                    >
                </div>
                <div class="flex flex-col gap-1">
                    <label for="genreDescription">Genre description</label>
                    <Textarea
                        name="description"
                        rows="5"
                        cols="30"
                        style="resize: none"
                        placeholder="Sci-fi is worldwide famous genre"
                    />
                    <Message
                        v-if="$form.description?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.description.error?.message }}</Message
                    >
                </div>
                <Button type="submit" severity="primary" label="Save" />
            </Form>
        </div>
    </AppLayout>
</template>
<script setup>
import { Form } from '@primevue/forms'
import { Button, InputText, Message, Textarea } from 'primevue'
import PageTitle from '../../../components/PageTitle.vue'
import AppLayout from '../../../layout/AppLayout.vue'
import { useRoute } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import { onMounted, reactive, ref } from 'vue'
import { useRedirects } from '@/composables/useRedirects'

const { toGenreList } = useRedirects()
const toast = useToast()
const formKey = ref(0)
const route = useRoute()

const resolver = ({ values }) => {
    const errors = {}

    if (!values.name) {
        errors.name = [{ message: 'Genre name is required.' }]
    }

    return {
        values,
        errors,
    }
}

const initialValues = reactive({
    name: '',
    description: '',
})

const onFormSubmit = async ({ valid, values }) => {
    const genreId = route.params.genreId

    if (valid) {
        try {
            await axios.put(`/genres/${genreId}`, values)

            toast.add({
                severity: 'success',
                summary: 'Genre updated successfully!',
                life: 3000,
            })
        } catch (error) {
            toast.add({
                severity: 'error',
                summary: error.response.data.message,
                life: 3000,
            })
        }
    }
}

const getGenre = async () => {
    const genreId = route.params.genreId

    return await axios
        .get(`/genres/${genreId}`)
        .then(response => {
            initialValues.name = response.data.name
            initialValues.description = response.data.description
            formKey.value++ // to remount primevue/form to trigger form resolver/validation https://github.com/primefaces/primevue/issues/7792
        })
        .catch(e => {
            console.error(e)
        })
}

onMounted(() => {
    getGenre()
})
</script>

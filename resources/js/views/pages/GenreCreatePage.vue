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
        <div class="card">
            <Form
                v-slot="$form"
                :initialValues
                :resolver
                @submit="onFormSubmit"
                class="flex flex-col gap-4 w-full md:w-112 sm:w-56"
                :validateOnValueUpdate="true"
                :validateOnBlur="true"
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
import PageTitle from '../../components/PageTitle.vue'
import AppLayout from '../../layout/AppLayout.vue'
import { useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import { reactive } from 'vue'
const toast = useToast()

const router = useRouter()

const resolver = ({ values }) => {
    const errors = {}

    if (!values.name) {
        errors.name = [{ message: 'Genre name is required.' }]
    }

    return {
        values, // (Optional) Used to pass current form values to submit event.
        errors,
    }
}

const backToGenreList = () => {
    router.push({ name: 'genres' })
}

const initialValues = reactive({
    name: '',
    description: '',
})

const onFormSubmit = async ({ valid, values }) => {
    if (valid) {
        try {
            await axios.post('/api/genres', values)

            toast.add({
                severity: 'success',
                summary: 'Genre created successfully!',
                life: 3000,
            })

            setTimeout(() => {
                router.push({ name: 'genres' })
            }, 300)
        } catch (error) {
            toast.add({
                severity: 'error',
                summary: error.response.data.message,
                life: 3000,
            })
        }
    }
}
</script>

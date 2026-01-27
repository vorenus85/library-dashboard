<template>
    <AppLayout>
        <PageTitle title="Add new genre">
            <template #actions>
                <Button icon="pi pi-angle-left" label="Back to list" primary @click="toGenreList" />
            </template>
        </PageTitle>
        <div class="card">
            <Form
                v-slot="$form"
                :initial-values
                :resolver="genreValidator"
                class="flex flex-col gap-4 w-full lg:w-1/2"
                :validate-on-value-update="true"
                :validate-on-blur="true"
                @submit="onFormSubmit"
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
                <div class="flex flex-col">
                    <Button
                        type="submit"
                        severity="primary"
                        label="Save"
                        class="ml-auto"
                        size="large"
                        style="width: 150px"
                    />
                </div>
            </Form>
        </div>
    </AppLayout>
</template>
<script setup>
import { Form } from '@primevue/forms'
import { Button, InputText, Message, Textarea } from 'primevue'
import PageTitle from '@/components/PageTitle.vue'
import AppLayout from '@/layout/AppLayout.vue'
import { useCustomToast } from '@/composables/useCustomToast'
import { useRedirects } from '@/composables/useRedirects'
import { useGenre } from '@/composables/useGenre'
import { createGenre } from '@/services/genreService'

const { customToast } = useCustomToast()
const { toGenreList } = useRedirects()
const { initialValues, genreValidator } = useGenre()

const onFormSubmit = async ({ valid, values }) => {
    if (valid) {
        try {
            await createGenre(values)

            customToast.success('Genre created successfully!')

            setTimeout(() => {
                toGenreList()
            }, 300)
        } catch (error) {
            const msg = error?.response?.data?.message
            customToast.error(msg || 'Please try again.')
        }
    }
}
</script>

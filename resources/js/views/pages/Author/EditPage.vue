<template>
    <AppLayout>
        <PageTitle title="Edit author">
            <template #actions>
                <Button
                    icon="pi pi-angle-left"
                    label="Back to list"
                    primary
                    @click="toAuthorList"
                />
            </template>
        </PageTitle>
        <div v-if="formKey" class="card">
            <Form
                :key="formKey"
                v-slot="$form"
                :initial-values
                :resolver="authorValidator"
                class="flex flex-col gap-4 w-full lg:w-1/2"
                :validate-on-value-update="true"
                :validate-on-blur="true"
                :validate-on-mount="true"
                @submit="onFormSubmit"
            >
                <div class="flex flex-col gap-1">
                    <label for="authorName">Author name</label>
                    <InputText
                        id="authorName"
                        name="name"
                        type="text"
                        placeholder="J. K. Rowling"
                        fluid
                    />
                    <Message
                        v-if="$form.name?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ $form.name.error?.message }}</Message
                    >
                </div>
                <div class="flex flex-col gap-1">
                    <label for="authorDescription">Author description</label>
                    <Textarea
                        id="authorDescription"
                        name="description"
                        rows="5"
                        cols="30"
                        style="resize: none"
                        placeholder="J. K. Rowling write the worldwide famous Harry Potter series"
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
import { onMounted } from 'vue'
import { useToast } from 'primevue/usetoast'
import { useRedirects } from '@/composables/useRedirects.js'
import { useAuthor } from '@/composables/useAuthor'
import { updateAuthorById } from '@/services/authorService'

const { formKey, authorId, initialValues, getAuthor, authorValidator } = useAuthor()
const { toAuthorList } = useRedirects()
const toast = useToast()

const onFormSubmit = async ({ valid, values }) => {
    if (valid) {
        try {
            await updateAuthorById(authorId, values)

            toast.add({
                severity: 'success',
                summary: 'Author edited successfully!',
                life: 3000,
            })

            setTimeout(() => {
                toAuthorList()
            }, 300)
        } catch (error) {
            console.log(error)
            toast.add({
                severity: 'error',
                summary: error.response.data.message,
                life: 3000,
            })
        }
    }
}

onMounted(() => {
    getAuthor()
})
</script>

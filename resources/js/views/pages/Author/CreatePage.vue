<template>
    <AppLayout>
        <PageTitle title="Add new author">
            <template v-slot:actions>
                <Button
                    icon="pi pi-angle-left"
                    label="Back to list"
                    primary
                    @click="toAuthorList"
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
                <Button type="submit" severity="primary" label="Save" />
            </Form>
        </div>
    </AppLayout>
</template>
<script setup>
import { Form } from '@primevue/forms'
import { Button, InputText, Message, Textarea } from 'primevue'
import PageTitle from '@/components/PageTitle.vue'
import AppLayout from '@/layout/AppLayout.vue'
import { useToast } from 'primevue/usetoast'
import { useRedirects } from '@/composables/useRedirects.js'
import { useAuthor } from '@/composables/useAuthor'

const { initialValues } = useAuthor()
const { toAuthorList } = useRedirects()
const toast = useToast()
const resolver = ({ values }) => {
    const errors = {}

    if (!values.name) {
        errors.name = [{ message: 'Author name is required.' }]
    }

    return {
        values, // (Optional) Used to pass current form values to submit event.
        errors,
    }
}

const onFormSubmit = async ({ valid, values }) => {
    if (valid) {
        try {
            await axios.post('/authors', values)

            toast.add({
                severity: 'success',
                summary: 'Author created successfully!',
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
</script>

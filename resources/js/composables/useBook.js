import { useCustomToast } from '@/composables/useCustomToast'
import { reactive, ref } from 'vue'
import {
    fetchBooks,
    deleteBookById,
    toggleBookReadStatus,
    toggleBookWishlistStatus,
    deleteBookImage,
    uploadBookImage,
} from '@/services/bookService'

export const useBook = () => {
    const { customToast } = useCustomToast()

    const isUploading = ref(false)
    const uploadProgress = ref(0)
    const uploadedImage = ref(null)
    const loading = ref(false)
    const allBooks = ref([])
    const books = ref([])
    const bookId = ref(0)
    const initialValues = reactive({
        title: '',
        description: '',
        author: '',
    })

    const bookValidator = ({ values }) => {
        const errors = {}

        if (!values.title) {
            errors.title = [{ message: 'Book title is required.' }]
        }

        if (!values.author) {
            errors.author = [{ message: 'Author is required.' }]
        }

        if (!values.genres || !values?.genres.length) {
            errors.genres = [{ message: 'Choose at leat one genre.' }]
        }

        if (Object.keys(errors).length) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            })
        }

        return {
            values,
            errors,
        }
    }

    const onRemoveBookImage = () => {
        isUploading.value = false
        uploadProgress.value = 0
    }

    const onClearUploaderStatus = () => {
        isUploading.value = false
        uploadProgress.value = 0
    }

    const onImageUpload = async event => {
        try {
            isUploading.value = true
            const file = event.files[0]

            const formData = new FormData()
            formData.append('file', file)

            const { data } = await uploadBookImage(file, progress => {
                uploadProgress.value = progress
            })

            uploadedImage.value = data.filename
        } catch (e) {
            isUploading.value = false
            // console.error(e)
        }
    }

    const deleteBook = async id => {
        loading.value = true

        try {
            await deleteBookById(id)

            const indexId = books.value.findIndex(el => {
                return el.id === id
            })

            books.value.splice(indexId, 1)
            customToast.success('Book deleted successfully!')

            loading.value = false
        } catch (e) {
            // console.error(e)
            loading.value = false
        }
    }

    const getBooks = async () => {
        loading.value = true

        try {
            const { data } = await fetchBooks()

            allBooks.value = data
            books.value = data

            loading.value = false
        } catch (e) {
            // console.error(e)
            loading.value = false
        }
    }

    const toggleRead = async id => {
        try {
            await toggleBookReadStatus(id)

            books.value = books.value.map(book =>
                book.id === id ? { ...book, is_read: !book.is_read } : book
            )
        } catch (error) {
            console.error(error)
        }
    }

    const toggleWishlist = async id => {
        try {
            await toggleBookWishlistStatus(id)

            books.value = books.value.map(book =>
                book.id === id ? { ...book, is_wishlist: !book.is_wishlist } : book
            )
        } catch (e) {
            console.error(e)
        }
    }

    const deleteImage = async () => {
        try {
            await deleteBookImage(bookId.value)
            initialValues.image = ''
            uploadedImage.value = ''
        } catch (e) {
            console.log(e)
        }
    }

    return {
        bookValidator,
        initialValues,
        isUploading,
        uploadProgress,
        onRemoveBookImage,
        onClearUploaderStatus,
        onImageUpload,
        uploadedImage,
        deleteBook,
        loading,
        allBooks,
        books,
        getBooks,
        toggleRead,
        toggleWishlist,
        deleteImage,
        bookId,
    }
}

import { useRouter } from 'vue-router'

export function useRedirects() {
    const router = useRouter()

    const toCreateBook = () => {
        router.push({ name: 'books.create' })
    }

    const toBookList = () => {
        router.push({ name: 'books' })
    }

    return {
        toCreateBook,
        toBookList,
    }
}

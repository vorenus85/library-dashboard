import { useRouter } from 'vue-router'

export function useRedirects() {
    const router = useRouter()

    const toCreateBook = () => {
        router.push({ name: 'books.create' })
    }

    const toBookList = () => {
        router.push({ name: 'books' })
    }

    const toAuthorList = () => {
        router.push({ name: 'authors' })
    }

    const toCreateAuthor = () => {
        router.push({ name: 'authors.create' })
    }

    return {
        toCreateBook,
        toBookList,
        toAuthorList,
        toCreateAuthor,
    }
}

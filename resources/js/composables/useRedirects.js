import { useRouter } from 'vue-router'

export function useRedirects() {
    const router = useRouter()

    const toCreateBook = () => {
        router.push({ name: 'books.create' })
    }

    const toBookList = () => {
        router.push({ name: 'books' })
    }
    const toCreateAuthor = () => {
        router.push({ name: 'authors.create' })
    }

    const toAuthorList = () => {
        router.push({ name: 'authors' })
    }

    const toCreateGenre = () => {
        router.push({ name: 'genres.create' })
    }

    const toGenreList = () => {
        router.push({ name: 'genres' })
    }

    return {
        toCreateBook,
        toBookList,
        toAuthorList,
        toCreateAuthor,
        toCreateGenre,
        toGenreList,
    }
}

export const fetchBooks = () => {
    return axios.get('/books')
}

export const fetchBook = id => {
    return axios.get(`/books/${id}`)
}

export const deleteBookById = id => {
    return axios.delete(`/books/${id}`)
}

export const createBook = values => {
    return axios.post('/books', values)
}

export const updateBookById = (id, values) => {
    return axios.put(`/books/${id}`, values)
}

export const toggleBookReadStatus = id => {
    return axios.patch(`/books/${id}/toggle-read`)
}

export const toggleBookWishlistStatus = id => {
    return axios.patch(`/books/${id}/toggle-wishlist`)
}

export const uploadBookImage = (file, onProgress) => {
    const formData = new FormData()
    formData.append('file', file)

    return axios.post('/books/image/upload', formData, {
        onUploadProgress: event => {
            if (!event.total || !onProgress) return
            onProgress(Math.round((event.loaded * 100) / event.total))
        },
    })
}

export const deleteBookImage = id => {
    return axios.delete(`/books/image/delete/${id}`)
}

export const fetchTopAuthors = () => {
    return axios.get('/topAuthors')
}

export const fetchTopGenres = () => {
    return axios.get('/topGenres')
}

export const fetchTopGenreWithName = () => {
    return axios.get('/topGenreWithName')
}

export const fetchWishlistBooks = () => {
    return axios.get('/wishlist')
}

export const fetchBookCount = () => {
    return axios.get('/bookCount')
}

export const fetchIsReadRate = () => {
    return axios.get('/isReadRate')
}

export const fetchIsWishlistCount = () => {
    return axios.get('/isWishlistCount')
}

export const exportBooksByType = type => {
    return axios.get(`/books/export?format=${type}`, {
        responseType: 'blob',
    })
}

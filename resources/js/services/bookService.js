export const fetchBooks = () => {
    return axios.get('/api/admin/books')
}

export const fetchBook = id => {
    return axios.get(`/api/admin/books/${id}`)
}

export const deleteBookById = id => {
    return axios.delete(`/api/admin/books/${id}`)
}

export const createBook = values => {
    return axios.post('/api/admin/books', values)
}

export const updateBookById = (id, values) => {
    return axios.put(`/api/admin/books/${id}`, values)
}

export const toggleBookReadStatus = id => {
    return axios.patch(`/api/admin/books/${id}/toggle-read`)
}

export const toggleBookWishlistStatus = id => {
    return axios.patch(`/api/admin/books/${id}/toggle-wishlist`)
}

export const uploadBookImage = (file, onProgress) => {
    const formData = new FormData()
    formData.append('file', file)

    return axios.post('/api/admin/books/image/upload', formData, {
        onUploadProgress: event => {
            if (!event.total || !onProgress) return
            onProgress(Math.round((event.loaded * 100) / event.total))
        },
    })
}

export const deleteBookImage = id => {
    return axios.delete(`/api/admin/books/image/delete/${id}`)
}

export const fetchTopAuthors = () => {
    return axios.get('/api/admin/topAuthors')
}

export const fetchTopGenres = () => {
    return axios.get('/api/admin/topGenres')
}

export const fetchTopGenreWithName = () => {
    return axios.get('/api/admin/topGenreWithName')
}

export const fetchWishlistBooks = () => {
    return axios.get('/api/admin/wishlist')
}

export const fetchBookCount = () => {
    return axios.get('/api/admin/bookCount')
}

export const fetchIsReadRate = () => {
    return axios.get('/api/admin/isReadRate')
}

export const fetchIsWishlistCount = () => {
    return axios.get('/api/admin/isWishlistCount')
}

export const exportBooksByType = type => {
    return axios.get(`/api/admin/books/export?format=${type}`, {
        responseType: 'blob',
    })
}

export const fetchGenres = () => {
    return axios.get('/api/admin/genres')
}

export const fetchMinimalGenres = () => {
    return axios.get('/api/admin/genres/?minimal=1')
}

export const fetchGenre = id => {
    return axios.get(`/api/admin/genres/${id}`)
}

export const deleteGenreById = id => {
    return axios.delete(`/api/admin/genres/${id}`)
}

export const createGenre = values => {
    return axios.post('/api/admin/genres', values)
}

export const updateGenreById = (id, values) => {
    return axios.put(`/api/admin/genres/${id}`, values)
}

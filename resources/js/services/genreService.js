export const fetchGenres = () => {
    return axios.get('/genres')
}

export const fetchMinimalGenres = () => {
    return axios.get('/genres/?minimal=1')
}

export const fetchGenre = id => {
    return axios.get(`/genres/${id}`)
}

export const deleteGenreById = id => {
    return axios.delete(`/genres/${id}`)
}

export const createGenre = values => {
    return axios.post('/genres', values)
}

export const updateGenreById = (id, values) => {
    return axios.put(`/genres/${id}`, values)
}

export const fetchAuthors = () => {
    return axios.get('/api/admin/authors')
}

export const fetchMinimalAuthors = () => {
    return axios.get('/api/admin/authors/?minimal=1')
}

export const fetchAuthor = id => {
    return axios.get(`/api/admin/authors/${id}`)
}

export const deleteAuthorById = id => {
    return axios.delete(`/api/admin/authors/${id}`)
}

export const createAuthor = values => {
    return axios.post('/api/admin/authors', values)
}

export const updateAuthorById = (id, values) => {
    return axios.put(`/api/admin/authors/${id}`, values)
}

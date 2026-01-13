export const fetchAuthors = () => {
    return axios.get('/authors')
}

export const fetchMinimalAuthors = () => {
    return axios.get('/authors/?minimal=1')
}

export const fetchAuthor = id => {
    return axios.get(`/authors/${id}`)
}

export const deleteAuthorById = id => {
    return axios.delete(`/authors/${id}`)
}

export const createAuthor = values => {
    return axios.post('/authors', values)
}

export const updateAuthorById = (id, values) => {
    return axios.put(`/authors/${id}`, values)
}

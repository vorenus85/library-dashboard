export const checkAuth = async () => {
    const res = await axios.get('/auth/check')
    console.log(res)
}

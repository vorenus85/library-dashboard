export const useAuth = () => {
    const loginValidator = ({ values }) => {
        const errors = {}

        if (!values.email) {
            errors.email = [{ message: 'Email is required.' }]
        }

        if (!values.password) {
            errors.password = [{ message: 'Password is required.' }]
        }

        if (Object.keys(errors).length) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            })
        }

        return {
            values,
            errors,
        }
    }

    return { loginValidator }
}

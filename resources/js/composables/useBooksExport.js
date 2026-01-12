import { useDate } from '@/composables/useDate'
const { getTimestampString } = useDate()

export function useBooksExport() {
    const exportBooksCsv = async () => {
        try {
            const response = await axios.get('/books/export?format=csv', {
                responseType: 'blob',
            })

            const url = window.URL.createObjectURL(new Blob([response.data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', 'books_' + getTimestampString() + '.csv')
            document.body.appendChild(link)
            link.click()
            link.remove()
        } catch (error) {
            console.error('Csv export error', error)
        }
    }

    const exportBooksExcel = async () => {
        try {
            const response = await axios.get('/books/export?format=excel', {
                responseType: 'blob',
            })

            const url = window.URL.createObjectURL(new Blob([response.data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', 'books_' + getTimestampString() + '.xlsx')
            document.body.appendChild(link)
            link.click()
            link.remove()
        } catch (error) {
            console.error('Excel export error', error)
        }
    }

    return {
        exportBooksExcel,
        exportBooksCsv,
    }
}

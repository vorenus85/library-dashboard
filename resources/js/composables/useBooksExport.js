import { useDate } from '@/composables/useDate'
import { exportBooksByType } from '@/services/bookService'

const { getTimestampString } = useDate()

export const useBooksExport = () => {
    const exportBooksCsv = async () => {
        try {
            const response = await exportBooksByType('csv')

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
            const response = await exportBooksByType('excel')

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

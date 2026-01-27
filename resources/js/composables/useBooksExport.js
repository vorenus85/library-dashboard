import { useDate } from '@/composables/useDate'
import { exportBooksByType } from '@/services/bookService'
import { useCustomToast } from '@/composables/useCustomToast'

const { getTimestampString } = useDate()

export const useBooksExport = () => {
    const { customToast } = useCustomToast()
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
            void error // to avoid unused variable lint error
            customToast.error('Failed to export books as CSV.')
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
            void error // to avoid unused variable lint error
            customToast.error('Failed to export books as EXCEL.')
        }
    }

    return {
        exportBooksExcel,
        exportBooksCsv,
    }
}

import { onMounted, ref } from 'vue'

export function useChart() {
    const paletteColors = [
        { base: 'primary-500', hover: 'primary-400' },
        { base: 'primary-700', hover: 'primary-600' },
        { base: 'blue-500', hover: 'blue-400' },
        { base: 'blue-700', hover: 'blue-600' },
        { base: 'green-500', hover: 'green-400' },
        { base: 'green-700', hover: 'green-600' },
        { base: 'yellow-500', hover: 'yellow-400' },
        { base: 'yellow-700', hover: 'yellow-600' },
        { base: 'cyan-500', hover: 'cyan-400' },
        { base: 'cyan-700', hover: 'cyan-600' },
        { base: 'pink-500', hover: 'pink-400' },
        { base: 'pink-700', hover: 'pink-600' },
        { base: 'indigo-500', hover: 'indigo-400' },
        { base: 'indigo-700', hover: 'indigo-600' },
        { base: 'teal-500', hover: 'teal-400' },
        { base: 'teal-700', hover: 'teal-600' },
        { base: 'orange-500', hover: 'orange-400' },
        { base: 'orange-700', hover: 'orange-600' },
        { base: 'bluegray-500', hover: 'bluegray-400' },
        { base: 'bluegray-700', hover: 'bluegray-600' },
        { base: 'purple-500', hover: 'purple-400' },
        { base: 'purple-700', hover: 'purple-600' },
        { base: 'red-500', hover: 'red-400' },
        { base: 'red-700', hover: 'red-600' },
        { base: 'gray-500', hover: 'gray-400' },
        { base: 'gray-700', hover: 'gray-600' },
        { base: 'primary-300', hover: 'primary-200' },
        { base: 'blue-300', hover: 'blue-200' },
        { base: 'green-300', hover: 'green-200' },
        { base: 'teal-300', hover: 'teal-200' },
    ]

    const setBarChartOptions = () => {
        const documentStyle = getComputedStyle(document.documentElement)
        const textColor = documentStyle.getPropertyValue('--p-text-color')
        const textColorSecondary = documentStyle.getPropertyValue('--p-text-muted-color')
        const surfaceBorder = documentStyle.getPropertyValue('--p-content-border-color')

        return {
            plugins: {
                legend: {
                    labels: {
                        color: textColor,
                    },
                },
            },
            scales: {
                x: {
                    ticks: {
                        color: textColorSecondary,
                    },
                    grid: {
                        color: surfaceBorder,
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: textColorSecondary,
                    },
                    grid: {
                        color: surfaceBorder,
                    },
                },
            },
        }
    }

    const setDoughnutChartOptions = () => {
        const documentStyle = getComputedStyle(document.documentElement)
        const textColor = documentStyle.getPropertyValue('--p-text-color')

        return {
            cutout: '60%',
            plugins: {
                legend: {
                    labels: {
                        color: textColor,
                    },
                },
            },
        }
    }

    const getColors = colors => {
        const documentStyle = getComputedStyle(document.body)

        const getBackgroundColors = colors.map(color => {
            return documentStyle.getPropertyValue(`--p-${color.base}`)
        })

        const getHoverBackgroundColors = colors.map(color => {
            return documentStyle.getPropertyValue(`--p-${color.hover}`)
        })

        return {
            getBackgroundColors,
            getHoverBackgroundColors,
        }
    }

    const allBackgroundColors = getColors(paletteColors).getBackgroundColors
    const allHoverBackgroundColors = getColors(paletteColors).getHoverBackgroundColors

    return {
        allHoverBackgroundColors,
        allBackgroundColors,
        setBarChartOptions,
        setDoughnutChartOptions,
    }
}

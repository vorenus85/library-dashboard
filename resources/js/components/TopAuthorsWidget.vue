<template>
    <div class="card">
        <span class="block text-muted-color font-medium">Top authors</span>
        <Chart type="bar" :data="chartData" :options="chartOptions" />
    </div>
</template>

<script setup>
import Chart from 'primevue/chart'
import { ref, onMounted, computed } from 'vue'
import { useChart } from '@/composables/useChart.js'

const { setBarChartOptions, allBackgroundColors } = useChart()

const chartOptions = ref()
const backgroundColors = ref([])
const authorLabels = ref([])
const authorData = ref([])

const chartData = computed(() => ({
    labels: authorLabels.value,
    datasets: [
        {
            label: 'Books',
            data: authorData.value,
            backgroundColor: backgroundColors.value,
        },
    ],
}))

const getTopAuthors = async () => {
    try {
        const { data } = await axios.get('/topAuthors')
        const topAuthors = data.topAuthors

        authorLabels.value = topAuthors.map(e => {
            return e.name
        })

        authorData.value = topAuthors.map(e => {
            return e.books_count
        })

        backgroundColors.value = allBackgroundColors.slice(0, topAuthors.length)
    } catch (error) {
        console.log(error)
    }
}

onMounted(() => {
    getTopAuthors()
    chartOptions.value = setBarChartOptions()
})
</script>

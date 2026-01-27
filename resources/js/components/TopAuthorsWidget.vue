<template>
    <div class="card">
        <WidgetTitle title="Top Authors" />
        <Chart type="bar" :data="chartData" :options="chartOptions" />
    </div>
</template>

<script setup>
import Chart from 'primevue/chart'
import { ref, onMounted, computed } from 'vue'
import { useChart } from '@/composables/useChart.js'
import WidgetTitle from '@/components/WidgetTitle.vue'
import { fetchTopAuthors } from '@/services/bookService'

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
        const { data } = await fetchTopAuthors()
        const topAuthors = data.topAuthors

        authorLabels.value = topAuthors.map(e => {
            return e.name
        })

        authorData.value = topAuthors.map(e => {
            return e.books_count
        })

        backgroundColors.value = allBackgroundColors.slice(0, topAuthors.length)
    } catch (error) {
        void error // to avoid unused variable lint error
        // console.error(error) -- IGNORE --
    }
}

onMounted(() => {
    getTopAuthors()
    chartOptions.value = setBarChartOptions()
})
</script>

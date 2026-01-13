<template>
    <div class="card">
        <WidgetTitle title="Top Genres" />
        <div class="flex justify-center">
            <Chart
                type="doughnut"
                :data="chartData"
                :options="chartOptions"
                class="w-full md:w-[30rem]"
            />
        </div>
    </div>
</template>

<script setup>
import Chart from 'primevue/chart'
import { ref, onMounted, computed } from 'vue'
import { useChart } from '@/composables/useChart.js'
import WidgetTitle from '@/components/WidgetTitle.vue'
import { fetchTopGenres } from '@/services/bookService'

const { setDoughnutChartOptions, allBackgroundColors, allHoverBackgroundColors } = useChart()

const chartOptions = ref(null)
const backgroundColors = ref([])
const hoverBackgroundColors = ref([])
const genreLabels = ref([])
const genreData = ref([])

const chartData = computed(() => ({
    labels: genreLabels.value,
    datasets: [
        {
            data: genreData.value,
            backgroundColor: backgroundColors.value,
            hoverBackgroundColor: hoverBackgroundColors.value,
        },
    ],
}))

const getTopGenres = async () => {
    try {
        const { data } = await fetchTopGenres()
        const topGenres = data.topGenres

        genreLabels.value = topGenres.map(e => {
            return e.name
        })

        genreData.value = topGenres.map(e => {
            return e.books_count
        })

        backgroundColors.value = allBackgroundColors.slice(0, topGenres.length)
        hoverBackgroundColors.value = allHoverBackgroundColors.slice(0, topGenres.length)
    } catch (error) {
        console.log(error)
    }
}

onMounted(() => {
    getTopGenres()
    chartOptions.value = setDoughnutChartOptions()
})
</script>

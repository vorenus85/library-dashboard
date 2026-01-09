<template>
    <div class="col-span-12 lg:col-span-6 card">
        <span class="block text-muted-color font-medium">Genre distribution</span>
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

const getGenreDistributution = async () => {
    try {
        const { data } = await axios.get('/genreDistribution')
        const genreDistribution = data.genreDistribution

        genreLabels.value = genreDistribution.map(e => {
            return e.name
        })

        genreData.value = genreDistribution.map(e => {
            return e.books_count
        })

        backgroundColors.value = allBackgroundColors.slice(0, genreDistribution.length)
        hoverBackgroundColors.value = allHoverBackgroundColors.slice(0, genreDistribution.length)
    } catch (error) {
        console.log(error)
    }
}

onMounted(() => {
    getGenreDistributution()
    chartOptions.value = setDoughnutChartOptions()
})
</script>

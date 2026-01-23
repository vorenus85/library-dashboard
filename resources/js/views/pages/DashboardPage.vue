<template>
    <AppLayout>
        <PageTitle title="Dashboard"> </PageTitle>
        <div class="dashboard grid grid-cols-12 gap-8">
            <div class="col-span-12 lg:col-span-6 xl:col-span-3 dashboard-kpi">
                <DashboardKpi
                    title="Total Books"
                    :kpi-value="bookCount"
                    icon="book"
                    color="blue"
                ></DashboardKpi>
            </div>
            <div class="col-span-12 lg:col-span-6 xl:col-span-3 dashboard-kpi">
                <DashboardKpi
                    title="Wishlist Books"
                    :kpi-value="countIsWishList"
                    icon="bookmark"
                    color="orange"
                ></DashboardKpi>
            </div>
            <div class="col-span-12 lg:col-span-6 xl:col-span-3 dashboard-kpi">
                <DashboardKpi
                    title="Books Read"
                    :kpi-value="countIsRead"
                    :rate="countIsReadRate"
                    icon="check-circle"
                    color="purple"
                ></DashboardKpi>
            </div>

            <div class="col-span-12 lg:col-span-6 xl:col-span-3 dashboard-kpi">
                <DashboardKpi
                    title="Top Genre"
                    :kpi-value="topGenre"
                    :count="topGenreCount"
                    icon="star"
                    color="cyan"
                ></DashboardKpi>
            </div>
            <div class="col-span-12 widget-wishlist">
                <WishlistWidget></WishlistWidget>
            </div>
            <div class="col-span-12 xl:col-span-4 widget-top-genres">
                <TopGenresWidget></TopGenresWidget>
            </div>

            <div class="col-span-12 xl:col-span-8 widget-top-authors">
                <TopAuthorsWidget></TopAuthorsWidget>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layout/AppLayout.vue'

import { ref, onMounted } from 'vue'
import PageTitle from '@/components/PageTitle.vue'
import DashboardKpi from '@/components/DashboardKpi.vue'
import TopGenresWidget from '@/components/TopGenresWidget.vue'
import TopAuthorsWidget from '@/components/TopAuthorsWidget.vue'
import WishlistWidget from '@/components/WishlistWidget.vue'
import {
    fetchBookCount,
    fetchIsReadRate,
    fetchIsWishlistCount,
    fetchTopGenreWithName,
} from '@/services/bookService'

const bookCount = ref('0')
const countIsWishList = ref('0')
const countIsRead = ref('0')
const countIsReadRate = ref(0)
const topGenre = ref('')
const topGenreCount = ref(0)

const getBookCount = async () => {
    const { data } = await fetchBookCount()
    bookCount.value = data.bookCount.toString()
}

const getIsReadRate = async () => {
    const { data } = await fetchIsReadRate()
    countIsRead.value = data.countIsRead.toString()
    countIsReadRate.value = data.countIsReadRate
}

const getIsWishlistCount = async () => {
    const { data } = await fetchIsWishlistCount()
    countIsWishList.value = data.countIsWishList.toString()
}

const getTopGenreWithName = async () => {
    const { data } = await fetchTopGenreWithName()
    topGenre.value = data.topGenre?.name.toString()
    topGenreCount.value = data.topGenre?.books_count
}

onMounted(() => {
    getBookCount()
    getIsReadRate()
    getIsWishlistCount()
    getTopGenreWithName()
})
</script>

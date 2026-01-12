<template>
    <AppLayout>
        <PageTitle title="Dashboard"> </PageTitle>
        <div class="dashboard grid grid-cols-12 gap-8">
            <div class="col-span-12 md:col-span-12 lg:col-span-4 xl:col-span-4 dashboard-kpi">
                <DashboardKpi
                    title="Total Books"
                    :kpiValue="bookCount"
                    icon="book"
                    color="blue"
                ></DashboardKpi>
            </div>
            <div class="col-span-12 md:col-span-12 lg:col-span-4 xl:col-span-4 dashboard-kpi">
                <DashboardKpi
                    title="Wishlist Books"
                    :kpiValue="countIsWishList"
                    icon="bookmark"
                    color="orange"
                ></DashboardKpi>
            </div>
            <div class="col-span-12 md:col-span-12 lg:col-span-4 xl:col-span-4 dashboard-kpi">
                <DashboardKpi
                    title="Books Read"
                    :kpiValue="countIsRead"
                    :rate="countIsReadRate"
                    icon="book"
                    color="purple"
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

const bookCount = ref(0)
const countIsWishList = ref(0)
const countIsRead = ref(0)
const countIsReadRate = ref(0)

const getBookCount = async () => {
    const { data } = await axios.get('/bookCount')
    bookCount.value = data.bookCount
}

const getIsReadRate = async () => {
    const { data } = await axios.get('/isReadRate')
    countIsRead.value = data.countIsRead
    countIsReadRate.value = data.countIsReadRate
}

const getIsWishlistCount = async () => {
    const { data } = await axios.get('/isWishlistCount')
    countIsWishList.value = data.countIsWishList
}

onMounted(() => {
    getBookCount()
    getIsReadRate()
    getIsWishlistCount()
})
</script>

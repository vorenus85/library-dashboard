<template>
    <AppLayout>
        <PageTitle title="Dashboard"> </PageTitle>
        <div class="dashboard grid grid-cols-12 gap-8">
            <DashboarKpi
                title="Book no."
                :kpiValue="bookCount"
                icon="book"
                color="blue"
            ></DashboarKpi>
            <DashboarKpi
                title="Is Read no."
                :kpiValue="countIsRead"
                :rate="countIsReadRate"
                icon="book"
                color="purple"
            ></DashboarKpi>
            <DashboarKpi
                title="Is Wishlist no."
                :kpiValue="countIsWishList"
                icon="bookmark"
                color="orange"
            ></DashboarKpi>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layout/AppLayout.vue'

import { ref, onMounted } from 'vue'
import PageTitle from '../../components/PageTitle.vue'
import DashboarKpi from '../../components/DashboarKpi.vue'

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

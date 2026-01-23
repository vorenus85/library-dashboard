<template>
    <div class="card mb-0 shadow">
        <div class="dashboard-kpi-header flex justify-between mb-4">
            <span class="block text-muted-color font-medium">{{ title }}</span>
            <template v-if="icon">
                <div
                    :class="`dashboard-kpi-icon flex items-center justify-center bg-${color}-100 dark:bg-${color}-400/10 rounded-border`"
                >
                    <UiIcon :icon="icon" />
                </div>
            </template>
        </div>
        <div class="dashboard-kpi-footer flex justify-between">
            <span class="text-surface-900 dark:text-surface-0 font-medium text-xl">{{
                kpiValue
            }}</span>
            <template v-if="rate">
                <Tag severity="success">{{ rate }} %</Tag>
            </template>
            <template v-if="count">
                <Tag severity="success">{{ count }}</Tag>
            </template>
        </div>
    </div>
</template>
<script setup>
import { Tag } from 'primevue'
import UiIcon from '@/components/UiIcon.vue'
defineProps({
    title: {
        type: String,
        required: true,
    },
    kpiValue: {
        type: String,
        default: '0',
    },
    icon: {
        type: String,
        default: '',
    },
    rate: {
        type: Number,
        default: 0,
    },
    count: {
        type: Number,
        default: 0,
    },
    color: {
        type: String,
        default: '',
    },
})
</script>

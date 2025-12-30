<template>
    <div class="font-semibold text-xl">{{ title }}</div>
</template>
<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
})
</script>

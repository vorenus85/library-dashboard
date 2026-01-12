<template>
    <div class="font-semibold text-xl mb-4">{{ title }}</div>
</template>
<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
})
</script>

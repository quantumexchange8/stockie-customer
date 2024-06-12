<script setup>
defineProps({
    value: String,
})
</script>

<template>
    <label class="block text-xs font-medium text-gray-900">
        <span v-if="value">{{ value }}</span>

        <span v-else><slot /></span>
    </label>
</template>
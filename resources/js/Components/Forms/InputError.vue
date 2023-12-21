<script setup lang="ts">
const props = defineProps({
    message: {
        type: String,
        required: false,
    },
})
</script>

<template>
    <span v-if="message" class="text-danger">
        {{ message }}
    </span>
</template>

<style scoped>
span{
    font-size: .8em;
}
</style>

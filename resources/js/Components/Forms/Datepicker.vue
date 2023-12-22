<script setup lang="ts">
defineOptions({
    inheritAttrs: false,
})

const props = defineProps({
    modelValue: {
        type: String,
        required: false,
    },
    label: {
        type: String,
        required: true,
    },
    id: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: false,
    },
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div>
        <label :for="name ?? id" class="form-label">{{ label }}</label>
        <input
            :id="name ?? id"
            :name="name"
            :value="modelValue"
            type="date"
            class="form-control"
            v-bind="$attrs"
            @input="emit('update:modelValue', $event.target.value)">
    </div>
</template>

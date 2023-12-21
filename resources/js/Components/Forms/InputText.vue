<script setup>
defineOptions({
  inheritAttrs: false
})

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
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
    type: {
        type: String,
        required: false,
        default: 'text',
    },
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <label :for="name ?? id" class="form-label">{{ label }}</label>
    <input
        :id="name ?? id"
        :name="name"
        :value="modelValue"
        :type="type"
        @input="emit('update:modelValue', $event.target.value)"
        class="form-control"
        v-bind="$attrs"
    >
</template>

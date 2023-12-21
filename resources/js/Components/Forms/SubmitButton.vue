<script setup lang="ts">

defineOptions({
    inheritAttrs: false,
})

</script>

<template>
    <button
        type="submit"
        class="btn btn-primary"
        v-bind="$attrs">
        <slot />
    </button>
</template>

<script setup>
import { ref } from 'vue';
import Header from '@/Components/Layout/Header.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <Header />
    <div>
        <slot></slot>
    </div>
</template>

<script setup lang="ts">
import Header from '@/Components/Layout/Header.vue'
</script>

<template>
    <div>
        <Header />
        <main>
            <slot />
        </main>
    </div>
</template>

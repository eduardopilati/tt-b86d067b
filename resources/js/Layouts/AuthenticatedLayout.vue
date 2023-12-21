<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import Header from '@/Components/Layout/Header.vue'

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <div>
        <Head :title="title" />
        <header>
            <Header />
        </header>
        <main class="container">
            <header class="row align-items-center mb-4">
                <div class="col">
                    <h1>{{ title }}</h1>
                </div>
                <div class="col-auto">
                    <slot name="actions" />
                </div>
            </header>
            <article>
                <slot />
            </article>
        </main>
    </div>
</template>

<style scoped>
main {
    margin-top: 4rem;
}
</style>

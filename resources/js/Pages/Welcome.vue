<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Logo from '@/Components/App/Logo.vue';

</script>

<template>
    <Head title="Welcome" />
    <div class="landingPage">
        <Logo />
        <h1>Há 59 anos te levando aos seus sonhos</h1>
        <Link href="/login" class="btn btn-primary">Quero alugar um Carro!</Link>
    </div>
</template>

<style scoped>
.landingPage {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 48px;
    background-color: #ddd;
}

.landingPage img {
    margin: 36px 0;
    display: block;
    max-width: 75vw;
}

.landingPage h1 {
    text-align: center;
    font-size: 32px;
}

.landingPage .btn {
    margin-top: 36px;
}
</style>

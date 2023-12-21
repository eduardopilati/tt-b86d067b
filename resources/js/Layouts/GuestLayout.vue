<script setup>
import { Link } from '@inertiajs/vue3';
import Logo from '@/Components/App/Logo.vue';
</script>

<template>
    <div class="container center-container">
        <div class="d-flex justify-content-center">
            <Link href="/">
                <Logo />
            </Link>
        </div>

        <div>
            <slot />
        </div>
    </div>
</template>

<style scoped>
.app-logo{
    width: 200px;
    margin-bottom: 24px;
}

.center-container{
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 100vh;
}
</style>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Logo from '@/Components/App/Logo.vue'
</script>

<template>
    <nav class="navbar fixed-top bg-body-tertiary">
        <div class="d-flex">
            <Link class="navbar-brand" :href="route('dashboard')">
                <Logo />
            </Link>
            <ul class="navbar-nav flex-row">
                <li class="nav-item">
                    <Link class="nav-link" :href="route('users.index')">
                        Usuários
                    </Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link" :href="route('logout')" method="post" as="button">
                        Sair
                    </Link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<style scoped>
.navbar-brand img{
    height: 24px;
}

.nav-item{
    margin-right: 1rem;
}
</style>

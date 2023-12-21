<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <template #header>
            <h2>Dashboard</h2>
        </template>

        <div>
            <div>
                <div>
                    <div>You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

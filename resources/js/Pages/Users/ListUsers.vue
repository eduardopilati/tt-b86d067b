<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Pagination from '@/Components/Layout/Pagination.vue'

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <AuthenticatedLayout title="Usuários">
        <template #actions>
            <Link class="btn btn-primary" :href="route('users.create')">
                Novo usuário
            </Link>
        </template>
        <div class="card card-default">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap m-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Documento</th>
                            <th>Data de Cadastro</th>
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.document }}</td>
                            <td>{{ new Date(user.created_at).toLocaleDateString('br', { timeZone: 'UTC' }) }}</td>
                            <td>
                                <Link :href="route('users.edit', user.id)" class="btn btn-sm btn-secondary">
                                    Editar
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Pagination class="mt-4" :links="users.links" />
    </AuthenticatedLayout>
</template>

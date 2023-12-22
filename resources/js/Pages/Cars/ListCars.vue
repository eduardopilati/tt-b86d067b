<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Pagination from '@/Components/Layout/Pagination.vue'

const props = defineProps({
    cars: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <AuthenticatedLayout title="Carros">
        <template #actions>
            <Link class="btn btn-primary" :href="route('cars.create')">
                Novo Carro
            </Link>
        </template>
        <div class="card card-default">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap m-0">
                    <thead>
                        <tr>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Placa</th>
                            <th>Ano</th>
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="car in cars.data" :key="car.id">
                            <td>{{ car.model }}</td>
                            <td>{{ car.brand }}</td>
                            <td>{{ car.plate }}</td>
                            <td>{{ car.year }}</td>
                            <td>
                                <Link :href="route('cars.edit', car.id)" class="btn btn-sm btn-secondary">
                                    Editar
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Pagination class="mt-4" :links="cars.links" />
    </AuthenticatedLayout>
</template>

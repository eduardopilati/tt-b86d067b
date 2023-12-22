<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Pagination from '@/Components/Layout/Pagination.vue'
import Filter from './Components/Filter.vue'

const props = defineProps({
    bookings: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: false,
    },
    car: {
        type: Object,
        required: false,
    },
})
</script>

<template>
    <AuthenticatedLayout title="Reservas">
        <template #actions>
            <Link class="btn btn-primary" :href="route('bookings.create')">
                Nova Reserva
            </Link>
        </template>

        <Filter :user="user" :car="car" class="mb-3" />

        <div class="card card-default">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap m-0">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Carro</th>
                            <th>Data de Início</th>
                            <th>Data de Fim</th>
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="booking in bookings.data" :key="booking.id">
                            <td>{{ booking.user.name }}</td>
                            <td>{{ booking.car.plate }}</td>
                            <td>{{ new Date(booking.start_date).toLocaleDateString('br', { timeZone: 'UTC' }) }}</td>
                            <td>{{ new Date(booking.end_date).toLocaleDateString('br', { timeZone: 'UTC' }) }}</td>
                            <td>
                                <Link :href="route('bookings.destroy', booking.id)" class="btn btn-sm btn-secondary" method="delete" as="button">Remover</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex mt-3">
            <div class="flex-fill">
                <Pagination class="mt-4" :links="bookings.links" />
            </div>
            <div>
                <Link class="btn btn-primary" :href="route('bookings.print', { user: user?.id, car: car?.id })">
                    Imprimir
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
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
    <div class="m-5">
        <div>
            <h1 class="text-center d-block mb-2">
                Reservas
            </h1>
            <span v-if="user" class="d-block mb-2">Usuário: {{ user?.name }}</span>
            <span v-if="car" class="d-block mb-2">Carro: {{ car?.plate }}</span>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Documento</th>
                    <th>Modelo</th>
                    <th>Placa</th>
                    <th>Data de Início</th>
                    <th>Data de Fim</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="booking in bookings" :key="booking.id">
                    <td>{{ booking.user.name }}</td>
                    <td>{{ booking.user.document }}</td>
                    <td>{{ booking.car.model }}</td>
                    <td>{{ booking.car.plate }}</td>
                    <td>{{ new Date(booking.start_date).toLocaleDateString('br', { timeZone: 'UTC' }) }}</td>
                    <td>{{ new Date(booking.end_date).toLocaleDateString('br', { timeZone: 'UTC' }) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

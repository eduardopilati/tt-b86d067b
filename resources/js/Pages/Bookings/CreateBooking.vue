<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/Forms/InputError.vue'
import Datepicker from '@/Components/Forms/Datepicker.vue'
import SelectAjax from '@/Components/Forms/SelectAjax.vue'

const props = defineProps({
    car: {
        type: Object,
        required: false,
    },
    user: {
        type: Object,
        required: false,
    },
})

const form = useForm({
    car_id: props.car?.id,
    user_id: props.user?.id,
    start_date: new Date().toLocaleDateString('br', { timeZone: 'UTC' }),
    end_date: new Date().toLocaleDateString('br', { timeZone: 'UTC' }),
})

function submit() {
    form.post(route('bookings.store'))
}
</script>

<template>
    <AuthenticatedLayout title="Criar Reserva">
        <template #actions>
            <Link class="btn btn-primary" :href="route('bookings.index')">
                Voltar
            </Link>
        </template>
        <form @submit.prevent="submit">
            <div class="card card-default">
                <div class="card-body">
                    <div class="mb-3">
                        <SelectAjax
                            id="car_id"
                            v-model="form.car_id"
                            :href="route('cars.search')"
                            label="Carro"
                            preload />

                        <InputError class="mt-2" :message="form.errors.car_id" />
                    </div>

                    <div class="mb-3">
                        <SelectAjax
                            id="user_id"
                            v-model="form.user_id"
                            :href="route('users.search')"
                            label="Usuário"
                            preload />

                        <InputError class="mt-2" :message="form.errors.user_id" />
                    </div>

                    <div class="mb-3">
                        <Datepicker
                            id="start_date"
                            v-model="form.start_date"
                            label="Data de Início" />

                        <InputError class="mt-2" :message="form.errors.start_date" />
                    </div>

                    <div class="mb-3">
                        <Datepicker
                            id="end_date"
                            v-model="form.end_date"
                            label="Data de Fim" />

                        <InputError class="mt-2" :message="form.errors.end_date" />
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="form.processing">
                        Criar Reserva
                    </button>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

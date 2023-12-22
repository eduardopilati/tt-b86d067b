<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/Forms/InputError.vue'
import InputText from '../../Components/Forms/InputText.vue'
import Checkbox from '@/Components/Forms/Checkbox.vue'

const props = defineProps({
    car: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    model: props.car.model,
    brand: props.car.brand,
    plate: props.car.plate,
    year: props.car.year,
})

function submit() {
    form.put(route('cars.update', props.car.id))
}
</script>

<template>
    <AuthenticatedLayout title="Atualizar Carro">
        <template #actions>
            <Link class="btn btn-primary" :href="route('cars.index')">
                Voltar
            </Link>
        </template>
        <form @submit.prevent="submit">
            <div class="card card-default">
                <div class="card-body">
                    <div class="mb-3">
                        <InputText
                            id="model"
                            v-model="form.model"
                            label="Modelo"
                            type="text"
                            class="form-control"
                            autofocus />
                        <InputError :message="form.errors.model" />
                    </div>
                    <div class="mb-3">
                        <InputText
                            id="brand"
                            v-model="form.brand"
                            label="Marca"
                            type="text"
                            class="form-control"
                            autofocus />
                        <InputError :message="form.errors.brand" />
                    </div>
                    <div class="mb-3">
                        <InputText
                            id="plate"
                            v-model="form.plate"
                            label="Placa"
                            type="text"
                            class="form-control"
                            autofocus />
                        <InputError :message="form.errors.plate" />
                    </div>
                    <div class="mb-3">
                        <InputText
                            id="year"
                            v-model="form.year"
                            label="Ano"
                            type="number"
                            class="form-control"
                            autofocus />
                        <InputError :message="form.errors.year" />
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="form.processing">
                        Atualizar Carro
                    </button>
                    <Link :href="route('cars.destroy', car.id)" class="btn btn-danger ms-3" method="delete">
                        Excluir Carro
                    </Link>
                    <Link :href="route('bookings.index', { car: car.id })" class="btn btn-secondary ms-3">
                        Ver Reservas
                    </Link>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

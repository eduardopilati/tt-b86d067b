<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/Forms/InputError.vue'
import InputText from '../../Components/Forms/InputText.vue'

const form = useForm({
    model: '',
    brand: '',
    plate: '',
    year: new Date().getFullYear(),
})

function submit() {
    form.post(route('cars.store'))
}
</script>

<template>
    <AuthenticatedLayout title="Criar Carro">
        <template #actions>
            <Link class="btn btn-primary" :href="route('users.index')">
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
                        Criar Carro
                    </button>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

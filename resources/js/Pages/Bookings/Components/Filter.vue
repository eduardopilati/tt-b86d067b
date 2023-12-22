<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3'
import SelectAjax from '@/Components/Forms/SelectAjax.vue'

type SelectAjaxOption = {
    id: number,
    text: string,
}

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
})

const options: {
    car: SelectAjaxOption[],
    user: SelectAjaxOption[],
} = {
    car: [],
    user: [],
}

if (props.user) {
    options.user.push({
        id: props.user.id,
        text: props.user.name,
    })
}

if (props.car) {
    options.car.push({
        id: props.car.id,
        text: props.car.plate,
    })
}
</script>

<template>
    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Filtros</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <SelectAjax
                        id="car_id"
                        v-model="form.car_id"
                        :href="route('cars.search')"
                        label="Carro"
                        :options="options.car" />
                </div>
                <div class="col">
                    <SelectAjax
                        id="user_id"
                        v-model="form.user_id"
                        :href="route('users.search')"
                        label="Usuario"
                        :options="options.user" />
                </div>
            </div>
        </div>
        <div v-if="form.isDirty" class="card-footer">
            <Link as="button" class="btn btn-primary" :href="route('bookings.index', { car: form.data().car_id, user: form.data().user_id })">
                Atualizar
            </Link>
        </div>
    </div>
</template>

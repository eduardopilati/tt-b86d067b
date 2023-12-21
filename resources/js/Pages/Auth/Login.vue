<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Checkbox from '@/Components/Forms/Checkbox.vue'
import InputError from '@/Components/Forms/InputError.vue'
import InputText from '../../Components/Forms/InputText.vue'
import SubmitButton from '../../Components/Forms/SubmitButton.vue'

defineProps({
    status: {
        type: String,
    },
})

const form = useForm({
    document: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="alert alert-warning">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="mb-3">
                <InputText
                    id="document"
                    v-model="form.document"
                    type="text"
                    label="CPF"
                    required
                    autofocus
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.document" />
            </div>

            <div class="mb-3">
                <InputText
                    id="password"
                    v-model="form.password"
                    type="password"
                    label="Senha"
                    required
                    autocomplete="current-password"
                    containerClass="mb-3" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <Checkbox id="remember" v-model="form.remember" label="Mantenha Logado" class="mt-3" />

            <div class="mt-3 d-flex justify-content-between">
                <SubmitButton :disabled="form.processing">
                    Entrar
                </SubmitButton>
            </div>
        </form>
    </GuestLayout>
</template>

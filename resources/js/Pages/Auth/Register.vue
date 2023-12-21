<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Forms/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputText from '../../Components/Forms/InputText.vue';
import SubmitButton from '../../Components/Forms/SubmitButton.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div class="mb-3">

                <InputText
                    id="name"
                    type="text"
                    label="Nome"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mb-3">
                <InputText
                    id="email"
                    type="email"
                    label="E-mail"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError :message="form.errors.email" />
            </div>

            <div class="mb-3">
                <InputText
                    id="password"
                    type="password"
                    label="Senha"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" />
            </div>

            <div class="mb-3">
                <InputText
                    id="password_confirmation"
                    type="password"
                    label="Confirmar Senha"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-3 d-flex justify-content-between">
                <SubmitButton :disabled="form.processing">
                    Registrar
                </SubmitButton>

                <Link :href="route('login')">
                    Já tem conta?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import Checkbox from '@/Components/Forms/Checkbox.vue';
import InputError from '@/Components/Forms/InputError.vue';
import InputText from '../../Components/Forms/InputText.vue';
import SubmitButton from '../../Components/Forms/SubmitButton.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
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
                    id="email"
                    type="email"
                    label="E-mail"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mb-3">
                <InputText
                    id="password"
                    type="password"
                    label="Senha"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    containerClass="mb-3"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <Checkbox id="remember" v-model="form.remember" label="Mantenha Logado" class="mt-3" />

            <div class="mt-3 d-flex justify-content-between">
                <SubmitButton :disabled="form.processing">
                    Entrar
                </SubmitButton>
                <Link href="/register" class="btn btn-link">
                    Registrar
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

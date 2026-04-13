<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InvitadoLayout from '@/Layouts/InvitadoLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: { type: String },
});

const form = useForm({
    codigo_cliente: '',
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
    <InvitadoLayout>
        <Head title="Iniciar Sesión" />

        <div class="mx-auto max-w-md mt-10 p-6 bg-white shadow-md rounded-lg">
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="codigo_cliente" value="Código de Cliente" />
                    <TextInput
                        id="codigo_cliente"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.codigo_cliente"
                        required
                        autofocus
                    />
                    <InputError class="mt-2" :message="form.errors.codigo_cliente" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Contraseña" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4 block">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600">Recordarme</span>
                    </label>
                </div>

                <div class="mt-6 flex items-center justify-center">
                    <PrimaryButton
                        class="w-full justify-center"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Entrar al Sistema
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </InvitadoLayout>
</template>
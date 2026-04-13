<script setup>
import InvitadoLayout from '@/Layouts/InvitadoLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    codigo_cliente: '', // Cambiado de email a codigo_cliente
    role: 'invitado',   // Campo necesario para tu DB
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
    <InvitadoLayout>
        <Head title="Registrar Usuario" />

        <div class="mx-auto max-w-md mt-10 p-6 bg-white shadow-md rounded-lg">
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Nombre Completo" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="codigo_cliente" value="Código de Cliente" />
                    <TextInput
                        id="codigo_cliente"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.codigo_cliente"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.codigo_cliente" />
                </div>

                <div class="mt-4">
                    <InputLabel for="role" value="Rol del Usuario" />
                    <select 
                        v-model="form.role"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    >
                        <option value="invitado">Invitado</option>
                        <option value="admin">Administrador</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.role" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Contraseña" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="mt-6">
                    <PrimaryButton
                        class="w-full justify-center"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Registrar Usuario
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </InvitadoLayout>
</template>
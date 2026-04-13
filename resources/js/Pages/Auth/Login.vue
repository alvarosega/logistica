<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

// Nota: No usamos un Layout aquí para que la pantalla de login sea limpia
defineProps({
    status: { type: String },
});

const form = useForm({
    legajo: '', // Identificador numérico
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
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <Head title="Acceso al Sistema" />

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-center text-xl font-bold text-gray-700 mb-6">Logística Vayu - Interno</h2>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="legajo" value="Número de Legajo" />
                    <TextInput
                        id="legajo"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.legajo"
                        required
                        autofocus
                    />
                    <InputError class="mt-2" :message="form.errors.legajo" />
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

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600">Recordar sesión</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Ingresar
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
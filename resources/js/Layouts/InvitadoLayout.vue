<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex shrink-0 items-center font-bold text-gray-700">
                            MIS PEDIDOS
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink :href="route('invitado.dashboard')" :active="route().current('invitado.dashboard')">
                                Seguimiento
                            </NavLink>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button type="button" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                                    {{ $page.props.auth.user ? $page.props.auth.user.name : 'Invitado' }}
                                </button>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('logout')" method="post" as="button">Salir</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <slot />
        </main>
    </div>
</template>
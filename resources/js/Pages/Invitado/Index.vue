<script setup>
import InvitadoLayout from '@/Layouts/InvitadoLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    orders: {
        type: Object,
        default: () => ({ data: [], links: [] })
    }
});

const formatDate = (dateString) => {
    if (!dateString) return '-';
    // Si la fecha llega como string YYYY-MM-DD
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('es-ES', options);
};
</script>

<template>
    <Head title="Mis Pedidos" />

    <InvitadoLayout>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-gray-800">Seguimiento de Entregas</h1>

                <div v-if="orders && orders.data && orders.data.length > 0" class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cant.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Camión</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Encargado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ formatDate(order.fecha_entrega) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ order.producto }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ order.cantidad }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ order.codigo_camion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div v-if="order.truck">
                                        <p class="font-medium">{{ order.truck.nombre }}</p>
                                        <p class="text-xs text-indigo-600">{{ order.truck.cel }}</p>
                                    </div>
                                    <span v-else class="text-gray-400 italic">No asignado</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else class="text-center py-10">
                    <p class="text-gray-500 italic">No tienes pedidos registrados actualmente.</p>
                </div>

                <div v-if="orders && orders.links && orders.links.length > 3" class="mt-6 flex justify-center space-x-2">
                    <Link
                        v-for="link in orders.links"
                        :key="link.label"
                        :href="link.url || ''"
                        v-html="link.label"
                        class="px-4 py-2 border rounded-md text-sm"
                        :class="{'bg-indigo-600 text-white': link.active, 'text-gray-500': !link.url}"
                    />
                </div>
            </div>
        </div>
    </InvitadoLayout>
</template>
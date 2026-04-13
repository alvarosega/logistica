<script setup>
import EcoLayout from '@/Layouts/EcoLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    orders: Object,
    user_territorio: [Number, String]
});

// Formateo técnico de fecha
const formatDate = (dateString) => {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('es-ES', {
        day: '2-digit', month: '2-digit', year: 'numeric'
    });
};

// Formateo de enlace telefónico para acción rápida
const telLink = (number) => `tel:${number?.toString().replace(/\s/g, '')}`;
</script>

<template>
    <Head title="Reporte de Territorio" />

    <EcoLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-mono text-xl text-gray-800 leading-tight">
                    TERRITORIO_ID: <span class="text-cyan-600 font-bold">{{ user_territorio }}</span>
                </h2>
                <div class="text-xs text-gray-500 font-mono uppercase tracking-widest">
                    Estado: <span class="text-green-500">Live / Sincronizado</span>
                </div>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-lg">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-mono font-bold text-gray-500 uppercase tracking-tighter">Fecha</th>
                                    <th class="px-4 py-3 text-left text-xs font-mono font-bold text-gray-500 uppercase tracking-tighter">Cliente_Cod</th>
                                    <th class="px-4 py-3 text-left text-xs font-mono font-bold text-gray-500 uppercase tracking-tighter">Producto</th>
                                    <th class="px-4 py-3 text-right text-xs font-mono font-bold text-gray-500 uppercase tracking-tighter">Cant.</th>
                                    <th class="px-4 py-3 text-left text-xs font-mono font-bold text-gray-500 uppercase tracking-tighter">Camión_ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-mono font-bold text-gray-500 uppercase tracking-tighter">Encargado / Contacto</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100 font-mono">
                                <tr v-for="order in orders.data" :key="order.id" class="hover:bg-cyan-50/50 transition-colors group">
                                    <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-600">
                                        {{ formatDate(order.fecha_entrega) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-gray-900 group-hover:text-cyan-700">
                                        {{ order.codigo_cliente }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-600 truncate max-w-[200px]">
                                        {{ order.producto }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right font-bold text-gray-900">
                                        {{ order.cantidad }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs text-indigo-600 font-bold uppercase">
                                        {{ order.codigo_camion }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs">
                                        <div v-if="order.truck" class="flex flex-col">
                                            <span class="text-gray-900 font-semibold">{{ order.truck.nombre }}</span>
                                            <a :href="telLink(order.truck.cel)" class="text-cyan-600 hover:underline decoration-cyan-300">
                                                {{ order.truck.cel }}
                                            </a>
                                        </div>
                                        <span v-else class="text-gray-400 italic">No asignado</span>
                                    </td>
                                </tr>
                                <tr v-if="orders.data.length === 0">
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500 italic font-mono">
                                        NO_DATA_AVAILABLE_FOR_TERRITORY_{{ user_territorio }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="orders.links.length > 3" class="bg-white px-4 py-3 border-t border-gray-100 flex items-center justify-center sm:px-6">
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <Link
                                v-for="link in orders.links"
                                :key="link.label"
                                :href="link.url || '#'"
                                v-html="link.label"
                                class="relative inline-flex items-center px-4 py-2 border text-xs font-mono transition-colors"
                                :class="{
                                    'z-10 bg-cyan-600 border-cyan-600 text-white': link.active,
                                    'bg-white border-gray-200 text-gray-500 hover:bg-gray-50': !link.active && link.url,
                                    'bg-gray-50 text-gray-300 border-gray-200 cursor-not-allowed': !link.url
                                }"
                            />
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </EcoLayout>
</template>
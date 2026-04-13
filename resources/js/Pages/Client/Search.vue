<script setup>
import { ref } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';

const props = defineProps({
    orders: Object,
    filters: Object
});

const codigo = ref(props.filters.codigo || '');

const consultar = () => {
    // Realiza la búsqueda pasando el código como parámetro en la URL
    router.get('/', { codigo: codigo.value }, { 
        preserveState: true, 
        replace: true 
    });
};

const formatDate = (dateString) => {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric', month: 'long', day: 'numeric'
    });
};
</script>

<template>
    <Head title="Rastreo de Pedidos" />

    <div class="min-h-screen bg-gray-50 flex flex-col items-center py-12 px-4">
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">LOGÍSTICA VAYU</h1>
            <p class="text-gray-500 mt-2">Consulta el estado de tus entregas en tiempo real.</p>
        </div>

        <div class="w-full max-w-2xl bg-white shadow-xl rounded-xl p-8 border border-gray-100">
            <div class="flex flex-col sm:flex-row gap-4">
                <input 
                    v-model="codigo"
                    type="text" 
                    placeholder="Introduce tu código de cliente"
                    class="flex-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg"
                    @keyup.enter="consultar"
                />
                <button 
                    @click="consultar"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200 shadow-lg shadow-blue-200"
                >
                    CONSULTAR
                </button>
            </div>
        </div>

        <div v-if="orders && orders.data.length > 0" class="w-full max-w-5xl mt-12 bg-white shadow-2xl rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha Entrega</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cantidad</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Camión / Encargado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ formatDate(order.fecha_entrega) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ order.producto }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                                {{ order.cantidad }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div v-if="order.truck">
                                    <span class="block font-semibold">{{ order.codigo_camion }}</span>
                                    <span class="text-xs text-gray-500">{{ order.truck.nombre }} ({{ order.truck.cel }})</span>
                                </div>
                                <span v-else class="text-gray-400">En proceso de asignación</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="orders.links.length > 3" class="bg-gray-50 px-6 py-4 border-t flex justify-center gap-2">
                <Link 
                    v-for="link in orders.links" 
                    :key="link.label"
                    :href="link.url || '#'"
                    v-html="link.label"
                    class="px-4 py-2 border rounded-md text-sm transition"
                    :class="{
                        'bg-blue-600 text-white border-blue-600': link.active,
                        'bg-white text-gray-700 hover:bg-gray-100': !link.active && link.url,
                        'text-gray-300 cursor-not-allowed': !link.url
                    }"
                />
            </div>
        </div>

        <div v-else-if="filters.codigo" class="mt-16 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 mb-4 text-yellow-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <p class="text-gray-600 text-lg">No se han encontrado registros para el código: <span class="font-bold text-gray-800">{{ filters.codigo }}</span></p>
        </div>
    </div>
</template>
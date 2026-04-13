<script setup>
import EcoLayout from '@/Layouts/EcoLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    orders: Object,
    user_territorio: [Number, String]
});

const formatDate = (dateString) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit' });
};

const whatsappLink = (number, cliente) => {
    const msg = encodeURIComponent(`LOGISTICA VAYU\nConsulta de pedido\nCliente: ${cliente}\nTerritorio: ${props.user_territorio}`);
    return `https://wa.me/${number?.toString().replace(/\s/g, '')}?text=${msg}`;
};
</script>

<template>
    <Head title="Panel de Logística" />

    <EcoLayout>
        <template #header>
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Territorio</span>
                <span class="text-sm font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                    {{ user_territorio }}
                </span>
            </div>
        </template>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Fecha</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-slate-900 uppercase tracking-widest">Cód. Cliente</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Razón Social</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Producto</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-slate-900 uppercase tracking-widest text-right">Cantidad</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="order in orders.data" :key="order.id" class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-4 py-4 text-xs text-slate-500 font-medium">
                                {{ formatDate(order.fecha_entrega) }}
                            </td>
                            <td class="px-4 py-4 text-sm font-black text-slate-900">
                                {{ order.codigo_cliente }}
                            </td>
                            <td class="px-4 py-4 text-xs font-bold text-slate-700 uppercase">
                                {{ order.razon_social }}
                            </td>
                            <td class="px-4 py-4 text-xs text-slate-500 italic">
                                {{ order.producto }}
                            </td>
                            <td class="px-4 py-4 text-sm text-right font-black text-slate-900 tabular-nums">
                                {{ order.cantidad }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                <a 
                                    v-if="order.truck?.cel"
                                    :href="whatsappLink(order.truck.cel, order.codigo_cliente)" 
                                    target="_blank"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-sm transition-all active:scale-95"
                                >
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    <span class="text-xs font-bold">Contactar</span>
                                </a>
                                <span v-else class="text-slate-300 text-[10px] font-bold uppercase">Sin Contacto</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="orders.links.length > 3" class="bg-slate-50 p-4 border-t border-slate-200 flex justify-between items-center">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    Página {{ orders.current_page }} de {{ orders.last_page }}
                </span>
                <div class="flex gap-1">
                    <Link 
                        v-for="link in [orders.links[0], orders.links[orders.links.length - 1]]" 
                        :key="link.label"
                        :href="link.url || '#'"
                        class="px-4 py-2 bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 rounded-lg transition-all"
                        :class="{ 'opacity-30 cursor-not-allowed': !link.url }"
                    >
                        {{ link.label.includes('Previous') ? 'Anterior' : 'Siguiente' }}
                    </Link>
                </div>
            </div>
        </div>
    </EcoLayout>
</template>
<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { ref } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';

const props = defineProps({
    orders: Object,
    filters: Object
});

const codigo = ref(props.filters.codigo || '');

const consultar = () => {
    router.get('/', { codigo: codigo.value }, { 
        preserveState: true, 
        replace: true 
    });
};

const formatDate = (dateString) => {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('es-ES', {
        day: '2-digit', month: '2-digit', year: 'numeric'
    });
};

// Generar link de WhatsApp para el cliente final
const whatsappLink = (number, cliente) => {
    const msg = encodeURIComponent(`Hola, mi código de cliente es ${cliente}. Consulto por el estado de mi pedido.`);
    return `https://wa.me/${number?.toString().replace(/\s/g, '')}?text=${msg}`;
};
</script>

<template>
    <Head title="Rastreo de Pedidos" />

    <PublicLayout>
        <div class="max-w-3xl mx-auto text-center mb-16">
            <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-4 uppercase">
                Logística
            </h1>
            <p class="text-slate-500 text-lg mb-10">
                Consulta el estado de tus entregas ingresando tu código de cliente.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm focus-within:border-slate-400 transition-colors">
                <input 
                    v-model="codigo"
                    type="text" 
                    placeholder="Código de cliente..."
                    class="flex-1 block w-full border-none focus:ring-0 text-lg px-6 py-3 placeholder:text-slate-300 font-medium"
                    @keyup.enter="consultar"
                />
                <button 
                    @click="consultar"
                    class="bg-slate-900 hover:bg-black text-white font-bold py-4 px-10 rounded-xl transition-all active:scale-95 uppercase text-xs tracking-widest"
                >
                    Consultar
                </button>
            </div>
        </div>

        <div v-if="orders && orders.data.length > 0" class="animate-in fade-in slide-in-from-bottom-4 duration-700">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Entrega</th>
                                <th class="px-6 py-5 text-[10px] font-bold text-slate-900 uppercase tracking-widest">Razón Social</th>
                                <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Producto</th>
                                <th class="px-6 py-5 text-[10px] font-bold text-slate-900 uppercase tracking-widest text-right">Cant.</th>
                                <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Contacto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="order in orders.data" :key="order.id" class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-5 text-sm font-medium text-slate-500">
                                    {{ formatDate(order.fecha_entrega) }}
                                </td>
                                <td class="px-6 py-5 text-sm font-black text-slate-900 uppercase">
                                    {{ order.razon_social }}
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-600 italic">
                                    {{ order.producto }}
                                </td>
                                <td class="px-6 py-5 text-lg text-right font-black text-slate-900 tabular-nums">
                                    {{ order.cantidad }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div v-if="order.truck?.cel" class="flex flex-col items-center gap-2">
                                        <a 
                                            :href="whatsappLink(order.truck.cel, order.codigo_cliente)" 
                                            target="_blank"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-sm transition-all active:scale-95 group"
                                        >
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                            <span class="text-[10px] font-black uppercase tracking-widest">Chat</span>
                                        </a>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                            Chofer: {{ order.truck.nombre }}
                                        </span>
                                    </div>
                                    <span v-else class="text-[10px] font-bold text-slate-300 uppercase italic">
                                        Asignando transporte
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="orders.links.length > 3" class="p-6 bg-slate-50 border-t border-slate-100 flex justify-center gap-2">
                    <Link 
                        v-for="link in orders.links" 
                        :key="link.label"
                        :href="link.url || '#'"
                        v-html="link.label"
                        class="px-5 py-2 text-[10px] font-bold rounded-lg transition-all uppercase tracking-widest"
                        :class="{
                            'bg-slate-900 text-white': link.active,
                            'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100': !link.active && link.url,
                            'text-slate-200 cursor-not-allowed': !link.url
                        }"
                    />
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
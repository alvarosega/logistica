<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isSidebarOpen = ref(true);
</script>

<template>
    <div class="min-h-screen bg-gray-900 text-gray-100 flex font-sans">
        <aside :class="isSidebarOpen ? 'w-64' : 'w-20'" class="bg-black border-r border-cyan-900/30 transition-all duration-300">
            <div class="p-6 font-mono font-bold text-cyan-500 tracking-tighter">
                {{ isSidebarOpen ? 'VAYU_ADMIN' : 'V_A' }}
            </div>
            <nav class="mt-10 space-y-2 px-4 font-mono text-sm uppercase">
                <Link :href="route('admin.dashboard')" class="block py-2 px-4 hover:bg-cyan-900/20 hover:text-cyan-400 rounded transition">Dashboard</Link>
                </nav>
            <div class="absolute bottom-10 px-4 w-full">
                <Link :href="route('logout')" method="post" as="button" class="text-xs text-red-500 hover:text-red-400 uppercase font-mono italic">Disconnect_</Link>
            </div>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="h-16 border-b border-cyan-900/20 flex items-center px-8 justify-between bg-black/50 backdrop-blur-md">
                <button @click="isSidebarOpen = !isSidebarOpen" class="text-cyan-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <div class="text-xs font-mono text-cyan-800">SYSTEM_STATUS: <span class="text-green-500 italic">OPTIMAL</span></div>
            </header>
            <section class="p-8">
                <slot />
            </section>
        </main>
    </div>
</template>
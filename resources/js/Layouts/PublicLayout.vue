<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-white font-sans antialiased text-slate-900 flex flex-col">
        <header class="h-20 flex items-center justify-center border-b border-slate-100 bg-white sticky top-0 z-50">
            <Link href="/" class="text-xl font-black tracking-tighter uppercase text-slate-900">
                LOGISTICA
            </Link>
        </header>

        <main class="flex-1 w-full max-w-7xl mx-auto p-6 sm:p-12">
            <slot />
        </main>

        <footer class="py-10 border-t border-slate-50 text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                &copy; 2026 Consulta de Telemetría Logística
            </p>
        </footer>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-slate-50 flex flex-col font-sans selection:bg-cyan-100">
        <header class="py-8 text-center">
            <Link href="/" class="text-xl font-black tracking-tighter text-gray-900">
                LOGISTICA<span class="text-cyan-600">VAYU</span>
            </Link>
        </header>

        <main class="flex-1 flex flex-col items-center justify-center px-4">
            <slot />
        </main>

        <footer class="py-8 text-center text-[10px] font-mono text-gray-400 uppercase tracking-widest">
            &copy; 2026 Telemetría Logística Directa_
        </footer>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-white flex flex-col font-sans text-gray-900">
        <nav class="h-14 border-b border-gray-100 px-8 flex items-center justify-between bg-white/80 backdrop-blur-sm sticky top-0 z-50">
            <div class="flex items-center gap-6">
                <span class="font-mono font-black text-xs tracking-widest text-gray-400 uppercase">Silo_Eco</span>
                <div class="h-4 w-[1px] bg-gray-200"></div>
                <slot name="header" />
            </div>
            <div class="flex items-center gap-4">
                <span class="text-[10px] font-mono text-gray-400 uppercase tracking-tighter">{{ $page.props.auth.user.name }}</span>
                <Link :href="route('logout')" method="post" as="button" class="text-[10px] font-bold text-gray-900 hover:text-cyan-600 uppercase border border-gray-900 px-3 py-1 rounded-full transition">Salir</Link>
            </div>
        </nav>

        <main class="flex-1 max-w-[1600px] mx-auto w-full p-6">
            <slot />
        </main>
    </div>
</template>
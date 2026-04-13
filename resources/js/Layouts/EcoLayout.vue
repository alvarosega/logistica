<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gray-50 font-sans antialiased text-slate-900">
        <nav class="h-16 bg-white border-b border-slate-200 sticky top-0 z-50 px-4 sm:px-8 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <span class="text-sm font-black tracking-tighter uppercase text-slate-900">
                    LOGISTICA
                </span>
                <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                <slot name="header" />
            </div>

            <div class="flex items-center gap-6">
                <span class="text-xs font-medium text-slate-500 hidden md:block">
                    {{ $page.props.auth.user.name }}
                </span>
                <Link 
                    :href="route('logout')" 
                    method="post" 
                    as="button" 
                    class="text-xs font-bold text-red-600 hover:text-red-700 transition-colors uppercase tracking-wider"
                >
                    Cerrar Sesión
                </Link>
            </div>
        </nav>

        <main class="max-w-[1400px] mx-auto p-4 sm:p-8">
            <slot />
        </main>
    </div>
</template>
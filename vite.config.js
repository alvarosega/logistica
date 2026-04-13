import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: '5173-firebase-logistica-1775220020021.cluster-j6d3cbsvdbe5uxnhqrfzzeyj7i.cloudworkstations.dev',
            clientPort: 443,
            protocol: 'wss',
        },
        origin: 'https://5173-firebase-logistica-1775220020021.cluster-j6d3cbsvdbe5uxnhqrfzzeyj7i.cloudworkstations.dev',
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
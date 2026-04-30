import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: process.env.VITE_DEV_SERVER_HOST || '127.0.0.1',
        port: Number(process.env.VITE_DEV_SERVER_PORT || 5173),
        strictPort: true,
        hmr: {
            host: process.env.VITE_HMR_HOST || '127.0.0.1',
            protocol: process.env.VITE_HMR_PROTOCOL || 'ws',
            port: Number(process.env.VITE_HMR_PORT || process.env.VITE_DEV_SERVER_PORT || 5173),
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
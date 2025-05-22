import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/datatables/datatables.custom.css',
                'resources/css/globalcss/globalcss.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@": "/resources/js"
        }
    },
    build: {
        chunkSizeWarningLimit: 1000
    }
});

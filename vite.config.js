import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/globalcss/globalcss.css',
                'resources/js/app.js',
                'resources/js/pages/climate-reports/weather-reports.js'
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

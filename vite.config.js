import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/sb-admin-2.min.css',
                'resources/js/sb-admin-2.min.js',
                'resources/css/profile.css',
            ],
            refresh: true,
        }),
    ],
});

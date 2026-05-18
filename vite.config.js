import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

/**
 * Vite Configuration — Rueda Verde
 * Plugins: Laravel, React (JSX), TailwindCSS
 */
export default defineConfig({
    plugins: [
        laravel({
            // Punto de entrada principal con React + Inertia
            input: ['resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

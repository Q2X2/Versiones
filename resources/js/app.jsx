/**
 * app.jsx — Punto de entrada principal de React + Inertia
 *
 * Inicializa la aplicación Inertia con React.
 * Cada página del CRUD es un componente React independiente.
 */

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// Inicializar la aplicación Inertia
createInertiaApp({
    // Título de la pestaña: "Página | Rueda Verde"
    title: (title) => `${title} | Rueda Verde`,

    // Resolver componentes de página automáticamente desde resources/js/Pages
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx')
        ),

    // Montar React en el elemento #app del blade
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
});

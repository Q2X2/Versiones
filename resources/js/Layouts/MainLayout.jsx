/**
 * MainLayout.jsx — Layout principal compartido
 *
 * Envuelve todas las páginas con el header de Rueda Verde
 * y muestra mensajes flash de éxito/error automáticamente.
 */

import { usePage, Link } from '@inertiajs/react';

export default function MainLayout({ children, title, backRoute }) {
    // Obtener mensajes flash inyectados desde el backend Laravel
    const { flash } = usePage().props;

    return (
        <div style={{
            maxWidth: '420px',
            margin: '0 auto',
            minHeight: '100vh',
            backgroundColor: '#fff',
            fontFamily: 'Inter, sans-serif',
        }}>

            {/* Header con título y botón volver */}
            {title && (
                <header style={{
                    background: '#48C9B0',
                    padding: '16px',
                    display: 'flex',
                    alignItems: 'center',
                    gap: '12px',
                }}>
                    {backRoute && (
                        <Link href={backRoute} style={{ color: '#fff', fontSize: '20px', textDecoration: 'none' }}>
                            ←
                        </Link>
                    )}
                    <h2 style={{ color: '#fff', margin: 0, fontSize: '18px', fontWeight: '600' }}>
                        {title}
                    </h2>
                </header>
            )}

            {/* Mensaje flash de éxito */}
            {flash?.success && (
                <div style={{
                    background: '#d4edda',
                    color: '#155724',
                    border: '1px solid #c3e6cb',
                    borderRadius: '8px',
                    padding: '12px 16px',
                    margin: '10px 15px',
                    fontSize: '14px',
                    fontWeight: '500',
                }}>
                    ✅ {flash.success}
                </div>
            )}

            {/* Mensaje flash de error */}
            {flash?.error && (
                <div style={{
                    background: '#f8d7da',
                    color: '#721c24',
                    border: '1px solid #f5c6cb',
                    borderRadius: '8px',
                    padding: '12px 16px',
                    margin: '10px 15px',
                    fontSize: '14px',
                }}>
                    ❌ {flash.error}
                </div>
            )}

            {/* Contenido de la página */}
            <main style={{ padding: '0' }}>
                {children}
            </main>

        </div>
    );
}

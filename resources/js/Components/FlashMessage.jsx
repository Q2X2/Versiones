/**
 * FlashMessage.jsx — Componente de mensajes flash
 *
 * Muestra mensajes de éxito o error provenientes del backend Laravel.
 * Se auto-oculta después de 3 segundos.
 */

import { useEffect, useState } from 'react';

export default function FlashMessage({ message, type = 'success' }) {
    // Estado para controlar visibilidad del mensaje
    const [visible, setVisible] = useState(true);

    // Auto-ocultar después de 3 segundos
    useEffect(() => {
        if (message) {
            const timer = setTimeout(() => setVisible(false), 3000);
            return () => clearTimeout(timer);
        }
    }, [message]);

    if (!message || !visible) return null;

    return (
        <div style={{
            background: type === 'success' ? '#d4edda' : '#f8d7da',
            color: type === 'success' ? '#155724' : '#721c24',
            border: `1px solid ${type === 'success' ? '#c3e6cb' : '#f5c6cb'}`,
            borderRadius: '8px',
            padding: '12px 16px',
            margin: '10px 15px',
            fontSize: '14px',
            fontWeight: '500',
        }}>
            {type === 'success' ? '✅' : '❌'} {message}
        </div>
    );
}

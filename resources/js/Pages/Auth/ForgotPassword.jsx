/**
 * Auth/ForgotPassword.jsx — Recuperación de contraseña (Laravel Breeze)
 */

import { useForm, Head, Link } from '@inertiajs/react';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({ email: '' });

    function handleSubmit(e) {
        e.preventDefault();
        post('/forgot-password');
    }

    return (
        <>
            <Head title="Recuperar contraseña" />

            <div style={containerStyle}>

                <h1 style={{ fontSize: '22px', fontWeight: '700', marginBottom: '8px' }}>
                    ¿Olvidaste tu contraseña?
                </h1>
                <p style={{ fontSize: '13px', color: '#888', textAlign: 'center', marginBottom: '20px' }}>
                    Ingresa tu correo y te enviaremos un enlace para restablecerla.
                </p>

                {status && (
                    <div style={{ background: '#d4edda', color: '#155724', borderRadius: '8px',
                        padding: '10px 14px', marginBottom: '14px', fontSize: '13px', width: '100%' }}>
                        {status}
                    </div>
                )}

                <form onSubmit={handleSubmit} style={{ width: '100%' }}>
                    <div style={{ marginBottom: '14px' }}>
                        <label style={{ fontSize: '13px', color: '#555', display: 'block', marginBottom: '4px' }}>
                            Correo electrónico
                        </label>
                        <input type="email" value={data.email}
                            onChange={e => setData('email', e.target.value)}
                            required autoFocus
                            style={{
                                width: '100%', padding: '12px', borderRadius: '8px', boxSizing: 'border-box',
                                border: errors.email ? '1.5px solid #e74c3c' : '1px solid #ddd',
                                fontSize: '15px',
                            }}
                            placeholder="correo@ejemplo.com" />
                        {errors.email && (
                            <span style={{ color: '#e74c3c', fontSize: '12px' }}>{errors.email}</span>
                        )}
                    </div>

                    <button type="submit" disabled={processing} style={{
                        width: '100%', padding: '14px', background: '#48C9B0',
                        color: '#fff', border: 'none', borderRadius: '10px',
                        fontSize: '16px', fontWeight: '600', cursor: 'pointer',
                    }}>
                        {processing ? 'Enviando...' : 'Enviar enlace'}
                    </button>
                </form>

                <Link href="/login" style={{ fontSize: '13px', color: '#48C9B0', marginTop: '14px' }}>
                    ← Volver al inicio de sesión
                </Link>

            </div>
        </>
    );
}

const containerStyle = {
    maxWidth: '420px', margin: '0 auto', minHeight: '100vh',
    backgroundColor: '#fff', fontFamily: 'Inter, sans-serif',
    display: 'flex', flexDirection: 'column',
    alignItems: 'center', justifyContent: 'center', padding: '32px 24px',
};

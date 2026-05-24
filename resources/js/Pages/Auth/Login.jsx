/**
 * Auth/Login.jsx — Página de inicio de sesión (Laravel Breeze)
 *
 * Formulario de login con email y contraseña.
 * Maneja errores y estado de procesamiento via Inertia useForm.
 */

import { useForm, Head, Link } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    function handleSubmit(e) {
        e.preventDefault();
        post('/login', { onFinish: () => reset('password') });
    }

    return (
        <>
            <Head title="Iniciar sesión" />

            <div style={containerStyle}>

                {/* Logo */}
                <img src="/img/logo-rueda-verde.png" alt="Rueda Verde"
                    style={{ width: '90px', marginBottom: '14px' }} />

                <h1 style={{ fontSize: '24px', fontWeight: '700', color: '#1a1a1a', margin: '0 0 4px' }}>
                    Rueda Verde
                </h1>
                <p style={{ fontSize: '13px', color: '#888', marginBottom: '24px' }}>
                    Autolavado — Sistema de Turnos
                </p>

                {/* Estado (ej: contraseña restablecida) */}
                {status && (
                    <div style={{ background: '#d4edda', color: '#155724', borderRadius: '8px',
                        padding: '10px 14px', marginBottom: '14px', fontSize: '13px', width: '100%' }}>
                        {status}
                    </div>
                )}

                <form onSubmit={handleSubmit} style={{ width: '100%' }}>

                    {/* Email */}
                    <div style={{ marginBottom: '14px' }}>
                        <label style={labelStyle}>Correo electrónico</label>
                        <input
                            type="email"
                            value={data.email}
                            onChange={e => setData('email', e.target.value)}
                            required autoFocus autoComplete="username"
                            style={inputStyle(errors.email)}
                            placeholder="correo@ejemplo.com"
                        />
                        {errors.email && <span style={errorStyle}>{errors.email}</span>}
                    </div>

                    {/* Contraseña */}
                    <div style={{ marginBottom: '14px' }}>
                        <label style={labelStyle}>Contraseña</label>
                        <input
                            type="password"
                            value={data.password}
                            onChange={e => setData('password', e.target.value)}
                            required autoComplete="current-password"
                            style={inputStyle(errors.password)}
                            placeholder="••••••••"
                        />
                        {errors.password && <span style={errorStyle}>{errors.password}</span>}
                    </div>

                    {/* Recordarme */}
                    <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '16px' }}>
                        <input type="checkbox" id="remember"
                            checked={data.remember}
                            onChange={e => setData('remember', e.target.checked)} />
                        <label htmlFor="remember" style={{ fontSize: '13px', color: '#555' }}>
                            Recordarme
                        </label>
                    </div>

                    <button type="submit" disabled={processing} style={submitBtn}>
                        {processing ? 'Ingresando...' : 'Iniciar sesión'}
                    </button>

                </form>

                <div style={{ marginTop: '16px', display: 'flex', flexDirection: 'column', alignItems: 'center', gap: '8px' }}>
                    {canResetPassword && (
                        <Link href="/forgot-password" style={{ fontSize: '13px', color: '#48C9B0' }}>
                            ¿Olvidaste tu contraseña?
                        </Link>
                    )}
                    <Link href="/register" style={{ fontSize: '13px', color: '#555' }}>
                        ¿No tienes cuenta? <span style={{ color: '#48C9B0', fontWeight: '600' }}>Regístrate</span>
                    </Link>
                </div>

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
const labelStyle = { fontSize: '13px', color: '#555', display: 'block', marginBottom: '4px' };
const inputStyle = (err) => ({
    width: '100%', padding: '12px', borderRadius: '8px', boxSizing: 'border-box',
    border: err ? '1.5px solid #e74c3c' : '1px solid #ddd',
    fontSize: '15px', fontFamily: 'Inter, sans-serif',
});
const errorStyle = { color: '#e74c3c', fontSize: '12px', marginTop: '3px', display: 'block' };
const submitBtn = {
    width: '100%', padding: '14px', background: '#48C9B0',
    color: '#fff', border: 'none', borderRadius: '10px',
    fontSize: '16px', fontWeight: '600', cursor: 'pointer',
};

/**
 * Auth/Register.jsx — Página de registro de usuario (Laravel Breeze)
 *
 * Formulario de registro para nuevos trabajadores del autolavado.
 * Nombre, email y contraseña con confirmación.
 */

import { useForm, Head, Link } from '@inertiajs/react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post('/register', { onFinish: () => reset('password', 'password_confirmation') });
    }

    return (
        <>
            <Head title="Registro" />

            <div style={containerStyle}>

                <img src="/img/logo-rueda-verde.png" alt="Rueda Verde"
                    style={{ width: '80px', marginBottom: '12px' }} />

                <h1 style={{ fontSize: '22px', fontWeight: '700', color: '#1a1a1a', margin: '0 0 4px' }}>
                    Crear cuenta
                </h1>
                <p style={{ fontSize: '13px', color: '#888', marginBottom: '20px' }}>
                    Registro de trabajador — Rueda Verde
                </p>

                <form onSubmit={handleSubmit} style={{ width: '100%' }}>

                    {/* Nombre */}
                    <div style={{ marginBottom: '14px' }}>
                        <label style={labelStyle}>Nombre completo</label>
                        <input type="text" value={data.name}
                            onChange={e => setData('name', e.target.value)}
                            required autoFocus autoComplete="name"
                            style={inputStyle(errors.name)}
                            placeholder="Tu nombre" />
                        {errors.name && <span style={errorStyle}>{errors.name}</span>}
                    </div>

                    {/* Email */}
                    <div style={{ marginBottom: '14px' }}>
                        <label style={labelStyle}>Correo electrónico</label>
                        <input type="email" value={data.email}
                            onChange={e => setData('email', e.target.value)}
                            required autoComplete="username"
                            style={inputStyle(errors.email)}
                            placeholder="correo@ejemplo.com" />
                        {errors.email && <span style={errorStyle}>{errors.email}</span>}
                    </div>

                    {/* Contraseña */}
                    <div style={{ marginBottom: '14px' }}>
                        <label style={labelStyle}>Contraseña</label>
                        <input type="password" value={data.password}
                            onChange={e => setData('password', e.target.value)}
                            required autoComplete="new-password"
                            style={inputStyle(errors.password)}
                            placeholder="Mínimo 8 caracteres" />
                        {errors.password && <span style={errorStyle}>{errors.password}</span>}
                    </div>

                    {/* Confirmar contraseña */}
                    <div style={{ marginBottom: '20px' }}>
                        <label style={labelStyle}>Confirmar contraseña</label>
                        <input type="password" value={data.password_confirmation}
                            onChange={e => setData('password_confirmation', e.target.value)}
                            required autoComplete="new-password"
                            style={inputStyle(errors.password_confirmation)}
                            placeholder="Repite la contraseña" />
                        {errors.password_confirmation && (
                            <span style={errorStyle}>{errors.password_confirmation}</span>
                        )}
                    </div>

                    <button type="submit" disabled={processing} style={submitBtn}>
                        {processing ? 'Registrando...' : 'Crear cuenta'}
                    </button>

                </form>

                <Link href="/login" style={{ fontSize: '13px', color: '#555', marginTop: '14px' }}>
                    ¿Ya tienes cuenta? <span style={{ color: '#48C9B0', fontWeight: '600' }}>Inicia sesión</span>
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

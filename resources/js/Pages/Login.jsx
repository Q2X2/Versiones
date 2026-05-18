/**
 * Login.jsx — Página de inicio de sesión
 *
 * Punto de entrada de la aplicación Rueda Verde.
 * Formulario con validación de errores vía Inertia.
 */

import { useForm, Head } from '@inertiajs/react';

export default function Login({ errors }) {
    // useForm de Inertia maneja el estado y el envío del formulario
    const { data, setData, post, processing } = useForm({
        login_input: '',
    });

    // Enviar formulario al backend (POST /login)
    function handleSubmit(e) {
        e.preventDefault();
        post('/login');
    }

    return (
        <>
            {/* Título de la pestaña */}
            <Head title="Inicio de sesión" />

            <div style={{
                maxWidth: '420px',
                margin: '0 auto',
                minHeight: '100vh',
                backgroundColor: '#fff',
                fontFamily: 'Inter, sans-serif',
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
                justifyContent: 'center',
                padding: '32px 24px',
            }}>

                {/* Logo */}
                <img
                    src="/img/logo-rueda-verde.png"
                    alt="Logo Rueda Verde"
                    style={{ width: '100px', marginBottom: '16px' }}
                />

                <h1 style={{ fontSize: '26px', fontWeight: '700', color: '#1a1a1a', margin: '0 0 8px' }}>
                    Rueda Verde
                </h1>

                <h3 style={{ fontSize: '16px', fontWeight: '600', color: '#333', margin: '0 0 8px' }}>
                    Inicio de sesión
                </h3>

                <p style={{ fontSize: '14px', color: '#888', textAlign: 'center', marginBottom: '24px' }}>
                    Ingresa tu usuario o placa del vehículo
                </p>

                {/* Formulario de login */}
                <form onSubmit={handleSubmit} style={{ width: '100%' }}>

                    <input
                        type="text"
                        placeholder="Usuario o placa"
                        value={data.login_input}
                        onChange={e => setData('login_input', e.target.value)}
                        required
                        style={{
                            width: '100%',
                            padding: '14px',
                            borderRadius: '10px',
                            border: '1px solid #ddd',
                            fontSize: '15px',
                            fontFamily: 'Inter, sans-serif',
                            boxSizing: 'border-box',
                            marginBottom: '8px',
                        }}
                    />

                    {/* Error de validación inyectado por Laravel */}
                    {errors?.login_input && (
                        <p style={{ color: '#e74c3c', fontSize: '13px', marginBottom: '8px' }}>
                            {errors.login_input}
                        </p>
                    )}

                    <button
                        type="submit"
                        disabled={processing}
                        style={{
                            width: '100%',
                            padding: '14px',
                            background: '#48C9B0',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '10px',
                            fontSize: '16px',
                            fontWeight: '600',
                            cursor: processing ? 'not-allowed' : 'pointer',
                            marginTop: '8px',
                        }}
                    >
                        {processing ? 'Cargando...' : 'Continuar'}
                    </button>

                </form>

                <p style={{ fontSize: '12px', color: '#aaa', marginTop: '24px', textAlign: 'center' }}>
                    Al hacer clic en continuar aceptas nuestros términos
                </p>

            </div>
        </>
    );
}

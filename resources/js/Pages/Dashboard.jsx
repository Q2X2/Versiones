/**
 * Dashboard.jsx — Panel principal con resumen y explorador de API
 *
 * Funcionalidad 5: Muestra estadísticas del sistema y permite
 * consultar la API REST directamente desde la interfaz.
 * Los datos llegan via Inertia desde DashboardController@index.
 */

import { Head, Link, usePage } from '@inertiajs/react';
import { useState } from 'react';
import MainLayout from '../Layouts/MainLayout';

export default function Dashboard({ totalVehiculos, totalClientes, vehiculosPorEstado }) {
    const [apiResult, setApiResult] = useState(null);
    const [loadingApi, setLoadingApi] = useState(false);
    const [activeEndpoint, setActiveEndpoint] = useState(null);

    // Consultar la API REST desde el navegador (funcionalidad API aplicada)
    async function consultarApi(endpoint, label) {
        setLoadingApi(true);
        setActiveEndpoint(label);
        try {
            const res = await fetch(`/api/${endpoint}`, {
                headers: { Accept: 'application/json' },
            });
            const data = await res.json();
            setApiResult(data);
        } catch (e) {
            setApiResult({ error: 'No se pudo conectar con la API.' });
        } finally {
            setLoadingApi(false);
        }
    }

    const estadoColor = (estado) => {
        if (estado === 'Listo') return { bg: '#d4edda', color: '#155724' };
        if (estado === 'En proceso') return { bg: '#fff3cd', color: '#856404' };
        return { bg: '#f8d7da', color: '#721c24' };
    };

    return (
        <>
            <Head title="Dashboard" />

            <MainLayout title="Panel de Control" backRoute="/">

                <div style={{ padding: '16px' }}>

                    {/* Tarjetas de estadísticas */}
                    <div style={{ display: 'flex', gap: '10px', marginBottom: '16px' }}>
                        <div style={statCard('#48C9B0')}>
                            <span style={{ fontSize: '28px', fontWeight: '700' }}>{totalVehiculos}</span>
                            <span style={{ fontSize: '12px', opacity: 0.9 }}>Vehículos</span>
                        </div>
                        <div style={statCard('#2ecc71')}>
                            <span style={{ fontSize: '28px', fontWeight: '700' }}>{totalClientes}</span>
                            <span style={{ fontSize: '12px', opacity: 0.9 }}>Clientes</span>
                        </div>
                    </div>

                    {/* Estado de vehículos */}
                    {vehiculosPorEstado && vehiculosPorEstado.length > 0 && (
                        <div style={{ marginBottom: '20px' }}>
                            <h3 style={{ fontSize: '14px', color: '#555', marginBottom: '8px' }}>Estado actual</h3>
                            {vehiculosPorEstado.map(({ estado, total }) => {
                                const c = estadoColor(estado);
                                return (
                                    <div key={estado} style={{
                                        display: 'flex', justifyContent: 'space-between', alignItems: 'center',
                                        background: c.bg, color: c.color, borderRadius: '8px',
                                        padding: '10px 14px', marginBottom: '6px', fontSize: '14px', fontWeight: '600',
                                    }}>
                                        <span>{estado}</span>
                                        <span>{total} vehículo{total !== 1 ? 's' : ''}</span>
                                    </div>
                                );
                            })}
                        </div>
                    )}

                    {/* Navegación rápida */}
                    <div style={{ display: 'flex', gap: '8px', marginBottom: '20px' }}>
                        <Link href="/vehicles" style={{ flex: 1 }}>
                            <button style={navBtn('#48C9B0')}>🚗 Vehículos</button>
                        </Link>
                        <Link href="/clientes" style={{ flex: 1 }}>
                            <button style={navBtn('#2ecc71')}>👤 Clientes</button>
                        </Link>
                    </div>

                    {/* Explorador de API REST */}
                    <div style={{ border: '1px solid #eee', borderRadius: '12px', padding: '14px' }}>
                        <h3 style={{ fontSize: '14px', color: '#333', margin: '0 0 10px', fontWeight: '700' }}>
                            🔌 Explorador de API REST
                        </h3>
                        <p style={{ fontSize: '12px', color: '#888', marginBottom: '10px' }}>
                            Consulta los endpoints de la API directamente:
                        </p>

                        {[
                            { label: 'GET /api/', endpoint: '' },
                            { label: 'GET /api/vehicles', endpoint: 'vehicles' },
                            { label: 'GET /api/clientes', endpoint: 'clientes' },
                            { label: 'GET /api/vehicles/estado/Listo', endpoint: 'vehicles/estado/Listo' },
                        ].map(({ label, endpoint }) => (
                            <button
                                key={label}
                                onClick={() => consultarApi(endpoint, label)}
                                style={{
                                    display: 'block', width: '100%', textAlign: 'left',
                                    padding: '8px 12px', marginBottom: '6px',
                                    background: activeEndpoint === label ? '#48C9B0' : '#f4f4f4',
                                    color: activeEndpoint === label ? '#fff' : '#333',
                                    border: 'none', borderRadius: '8px', fontSize: '12px',
                                    fontFamily: 'monospace', cursor: 'pointer',
                                }}
                            >
                                {label}
                            </button>
                        ))}

                        {/* Resultado de la API */}
                        {loadingApi && (
                            <p style={{ fontSize: '13px', color: '#888', textAlign: 'center', padding: '10px' }}>
                                Consultando...
                            </p>
                        )}
                        {apiResult && !loadingApi && (
                            <div style={{
                                background: '#1a1a2e', color: '#48C9B0', borderRadius: '8px',
                                padding: '12px', fontSize: '11px', fontFamily: 'monospace',
                                overflowX: 'auto', maxHeight: '200px', overflowY: 'auto',
                                marginTop: '10px',
                            }}>
                                <pre style={{ margin: 0, whiteSpace: 'pre-wrap', wordBreak: 'break-word' }}>
                                    {JSON.stringify(apiResult, null, 2)}
                                </pre>
                            </div>
                        )}
                    </div>

                </div>

            </MainLayout>
        </>
    );
}

const statCard = (bg) => ({
    flex: 1, background: bg, color: '#fff', borderRadius: '12px',
    padding: '16px', display: 'flex', flexDirection: 'column',
    alignItems: 'center', gap: '4px',
});

const navBtn = (bg) => ({
    width: '100%', padding: '12px', background: bg,
    color: '#fff', border: 'none', borderRadius: '10px',
    fontSize: '14px', fontWeight: '600', cursor: 'pointer',
});

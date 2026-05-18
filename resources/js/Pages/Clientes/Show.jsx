/**
 * Clientes/Show.jsx — Vista de detalle del cliente
 *
 * Muestra toda la información de un cliente y sus vehículos asociados.
 * Los datos llegan via Inertia desde ClienteController@show.
 */

import { Head, Link } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';

export default function ClientesShow({ cliente }) {
    return (
        <>
            <Head title={`Cliente: ${cliente.nombre}`} />

            <MainLayout title="Detalle de Cliente" backRoute="/clientes">

                <div style={{ padding: '20px' }}>

                    {/* Tarjeta de información del cliente */}
                    <div style={{ background: '#f9f9f9', borderRadius: '12px', padding: '16px', border: '1px solid #eee', marginBottom: '20px' }}>
                        <h3 style={{ margin: '0 0 12px', fontSize: '16px', color: '#333' }}>Información</h3>
                        {[
                            ['Nombre', cliente.nombre],
                            ['Teléfono', cliente.telefono || '—'],
                            ['Correo', cliente.correo || '—'],
                        ].map(([label, value]) => (
                            <div key={label} style={{
                                display: 'flex', justifyContent: 'space-between',
                                padding: '10px 0', borderBottom: '1px solid #eee',
                            }}>
                                <span style={{ color: '#888', fontSize: '14px' }}>{label}</span>
                                <span style={{ fontWeight: '600', fontSize: '14px' }}>{value}</span>
                            </div>
                        ))}
                    </div>

                    {/* Vehículos asociados */}
                    <h3 style={{ fontSize: '16px', color: '#333', marginBottom: '10px' }}>
                        🚗 Vehículos ({cliente.vehiculos?.length || 0})
                    </h3>

                    {cliente.vehiculos?.length === 0 ? (
                        <p style={{ color: '#888', fontSize: '14px' }}>No tiene vehículos registrados.</p>
                    ) : (
                        cliente.vehiculos?.map(v => (
                            <div key={v.id_vehiculo} style={{
                                background: '#f9f9f9', borderRadius: '10px',
                                padding: '12px', marginBottom: '10px', border: '1px solid #eee',
                            }}>
                                <p style={{ margin: '0 0 4px', fontWeight: '600', fontSize: '14px' }}>{v.placa} — {v.propietario}</p>
                                <p style={{ margin: '0 0 2px', fontSize: '13px', color: '#555' }}>{v.servicio}</p>
                                <span style={{
                                    fontSize: '12px', padding: '2px 8px', borderRadius: '20px',
                                    background: v.estado === 'Listo' ? '#d4edda' : v.estado === 'En proceso' ? '#fff3cd' : '#f8d7da',
                                    color: v.estado === 'Listo' ? '#155724' : v.estado === 'En proceso' ? '#856404' : '#721c24',
                                }}>
                                    {v.estado}
                                </span>
                            </div>
                        ))
                    )}

                    {/* Botón editar */}
                    <Link href={`/clientes/${cliente.id_cliente}/edit`}>
                        <button style={{
                            width: '100%', padding: '14px', background: '#48C9B0',
                            color: '#fff', border: 'none', borderRadius: '10px',
                            fontSize: '16px', fontWeight: '600', cursor: 'pointer', marginTop: '16px',
                        }}>
                            Editar cliente
                        </button>
                    </Link>

                </div>

            </MainLayout>
        </>
    );
}

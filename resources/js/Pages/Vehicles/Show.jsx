/**
 * Vehicles/Show.jsx — Vista de detalle/estado del vehículo
 *
 * Muestra toda la información de un vehículo específico.
 * Los datos llegan via Inertia desde VehicleController@show.
 */

import { Head, Link } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';

export default function VehiclesShow({ vehicle }) {
    return (
        <>
            <Head title="Estado del Vehículo" />

            <MainLayout title="Estado del Vehículo" backRoute="/vehicles">

                <div style={{ padding: '20px' }}>

                    {/* Imagen del vehículo */}
                    <div style={{ textAlign: 'center', marginBottom: '20px' }}>
                        <img src="/img/carro.jpg" alt="Vehículo"
                            style={{ width: '180px', borderRadius: '12px', objectFit: 'cover' }} />
                    </div>

                    {/* Tarjeta de información */}
                    <div style={{ background: '#f9f9f9', borderRadius: '12px', padding: '16px', border: '1px solid #eee' }}>
                        {[
                            ['Propietario', vehicle.propietario],
                            ['Placa', vehicle.placa],
                            ['Modelo', vehicle.modelo || '—'],
                            ['Servicio', vehicle.servicio],
                            ['Estado', vehicle.estado],
                            vehicle.hora ? ['Hora', vehicle.hora] : null,
                            vehicle.telefono ? ['Teléfono', vehicle.telefono] : null,
                            vehicle.cliente ? ['Cliente', vehicle.cliente.nombre] : null,
                        ].filter(Boolean).map(([label, value]) => (
                            <div key={label} style={{
                                display: 'flex', justifyContent: 'space-between',
                                padding: '10px 0', borderBottom: '1px solid #eee',
                            }}>
                                <span style={{ color: '#888', fontSize: '14px' }}>{label}</span>
                                <span style={{ fontWeight: '600', fontSize: '14px' }}>{value}</span>
                            </div>
                        ))}
                    </div>

                    {/* Calificación visual */}
                    <div style={{ textAlign: 'center', fontSize: '28px', marginTop: '20px', color: '#f39c12' }}>
                        ★★★★★
                    </div>

                    {/* Botón editar */}
                    <Link href={`/vehicles/${vehicle.id_vehiculo}/edit`}>
                        <button style={{
                            width: '100%', padding: '14px', background: '#48C9B0',
                            color: '#fff', border: 'none', borderRadius: '10px',
                            fontSize: '16px', fontWeight: '600', cursor: 'pointer', marginTop: '16px',
                        }}>
                            Editar vehículo
                        </button>
                    </Link>

                </div>

            </MainLayout>
        </>
    );
}

/**
 * Clientes/Index.jsx — Lista de clientes
 *
 * Muestra todos los clientes con sus vehículos asociados y acciones CRUD.
 * Los datos llegan via Inertia desde ClienteController@index.
 */

import { Head, Link, router, usePage } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';
import FlashMessage from '../../Components/FlashMessage';

export default function ClientesIndex({ clientes }) {
    const { flash } = usePage().props;

    // Eliminar cliente con confirmación
    function handleDelete(id) {
        if (confirm('¿Estás seguro de eliminar este cliente?')) {
            router.delete(`/clientes/${id}`);
        }
    }

    return (
        <>
            <Head title="Clientes" />

            <MainLayout title="Clientes" backRoute="/vehicles">

                <FlashMessage message={flash?.success} type="success" />

                <div style={{ padding: '12px' }}>
                    <Link href="/clientes/create">
                        <button style={{
                            width: '100%', padding: '12px', background: '#48C9B0',
                            color: '#fff', border: 'none', borderRadius: '10px',
                            fontSize: '14px', fontWeight: '600', cursor: 'pointer', marginBottom: '12px',
                        }}>
                            + Registrar Cliente
                        </button>
                    </Link>
                </div>

                <div style={{ padding: '0 12px' }}>
                    {clientes.length === 0 ? (
                        <p style={{ textAlign: 'center', color: '#888', padding: '40px 0' }}>
                            No hay clientes registrados.
                        </p>
                    ) : (
                        clientes.map(cliente => (
                            <div key={cliente.id_cliente} style={{
                                display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start',
                                background: '#f9f9f9', borderRadius: '12px',
                                padding: '14px', marginBottom: '12px', border: '1px solid #eee',
                            }}>

                                {/* Info del cliente */}
                                <div>
                                    <p style={{ fontWeight: '700', fontSize: '15px', margin: '0 0 4px' }}>
                                        {cliente.nombre}
                                    </p>
                                    {cliente.telefono && (
                                        <p style={{ fontSize: '13px', color: '#555', margin: '0 0 2px' }}>
                                            📞 {cliente.telefono}
                                        </p>
                                    )}
                                    {cliente.correo && (
                                        <p style={{ fontSize: '12px', color: '#888', margin: '0 0 2px' }}>
                                            ✉ {cliente.correo}
                                        </p>
                                    )}
                                    <p style={{ fontSize: '12px', color: '#48C9B0', margin: 0 }}>
                                        🚗 {cliente.vehiculos?.length || 0} vehículo(s)
                                    </p>
                                </div>

                                {/* Acciones */}
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '6px', alignItems: 'center' }}>
                                    <Link href={`/clientes/${cliente.id_cliente}/edit`}
                                        style={{ fontSize: '12px', color: '#48C9B0', textDecoration: 'none' }}>
                                        Editar
                                    </Link>
                                    <button
                                        onClick={() => handleDelete(cliente.id_cliente)}
                                        style={{ fontSize: '11px', padding: '4px 8px', background: '#e74c3c',
                                            color: '#fff', border: 'none', borderRadius: '6px', cursor: 'pointer' }}>
                                        Eliminar
                                    </button>
                                </div>

                            </div>
                        ))
                    )}
                </div>

            </MainLayout>
        </>
    );
}

/**
 * Vehicles/Index.jsx — Lista de vehículos (turnos)
 *
 * Muestra todos los vehículos registrados con opciones CRUD.
 * Los datos llegan via Inertia desde VehicleController@index.
 */

import { Head, Link, router, usePage } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';
import FlashMessage from '../../Components/FlashMessage';

export default function VehiclesIndex({ vehicles }) {
    // Obtener mensajes flash del backend
    const { flash } = usePage().props;

    // Eliminar vehículo con confirmación
    function handleDelete(id) {
        if (confirm('¿Estás seguro de eliminar este vehículo?')) {
            router.delete(`/vehicles/${id}`);
        }
    }

    return (
        <>
            <Head title="Turnos de Vehículos" />

            <MainLayout title="Turnos de Vehículos" backRoute="/">

                {/* Mensaje flash de éxito */}
                <FlashMessage message={flash?.success} type="success" />

                {/* Botones de acción */}
                <div style={{ padding: '12px', display: 'flex', gap: '8px' }}>
                    <Link href="/vehicles/create" style={{ flex: 1 }}>
                        <button style={btnStyle('#48C9B0')}>+ Vehículo</button>
                    </Link>
                    <Link href="/clientes" style={{ flex: 1 }}>
                        <button style={btnStyle('#2ecc71')}>👤 Clientes</button>
                    </Link>
                </div>

                {/* Lista de vehículos */}
                <div style={{ padding: '0 12px' }}>
                    {vehicles.length === 0 ? (
                        <p style={{ textAlign: 'center', color: '#888', padding: '40px 0' }}>
                            No hay vehículos registrados.
                        </p>
                    ) : (
                        vehicles.map(vehicle => (
                            <div key={vehicle.id_vehiculo} style={cardStyle}>

                                {/* Info del vehículo */}
                                <div style={{ flex: 1 }}>
                                    <p style={{ fontWeight: '700', fontSize: '15px', margin: '0 0 4px' }}>
                                        {vehicle.propietario}
                                    </p>
                                    <p style={{ fontSize: '13px', color: '#555', margin: '0 0 2px' }}>
                                        {vehicle.servicio}
                                    </p>
                                    <p style={{ fontSize: '12px', color: '#888', margin: '0 0 2px' }}>
                                        Placa: {vehicle.placa}
                                    </p>
                                    <p style={{ fontSize: '12px', color: '#888', margin: '0 0 2px' }}>
                                        Estado: {vehicle.estado}
                                    </p>
                                    {/* Cliente asociado si existe */}
                                    {vehicle.cliente && (
                                        <p style={{ fontSize: '12px', color: '#48C9B0', margin: 0 }}>
                                            Cliente: {vehicle.cliente.nombre}
                                        </p>
                                    )}
                                </div>

                                {/* Acciones */}
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '6px', alignItems: 'center' }}>
                                    <img src="/img/carro.jpg" alt="Vehículo"
                                        style={{ width: '60px', height: '50px', objectFit: 'cover', borderRadius: '8px' }} />

                                    <Link href={`/vehicles/${vehicle.id_vehiculo}`}
                                        style={{ fontSize: '12px', color: '#555', textDecoration: 'none' }}>
                                        Ver
                                    </Link>

                                    <Link href={`/vehicles/${vehicle.id_vehiculo}/edit`}
                                        style={{ fontSize: '12px', color: '#48C9B0', textDecoration: 'none' }}>
                                        Editar
                                    </Link>

                                    <button
                                        onClick={() => handleDelete(vehicle.id_vehiculo)}
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

// Estilos reutilizables
const cardStyle = {
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
    background: '#f9f9f9',
    borderRadius: '12px',
    padding: '14px',
    marginBottom: '12px',
    border: '1px solid #eee',
};

const btnStyle = (bg) => ({
    width: '100%',
    padding: '12px',
    background: bg,
    color: '#fff',
    border: 'none',
    borderRadius: '10px',
    fontSize: '14px',
    fontWeight: '600',
    cursor: 'pointer',
});

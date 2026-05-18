/**
 * Vehicles/Edit.jsx — Formulario de edición de vehículo
 *
 * Carga los datos actuales del vehículo y permite actualizarlos.
 * Usa PUT via Inertia con validación automática del backend.
 */

import { useForm, Head } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';
import InputField from '../../Components/InputField';

export default function VehiclesEdit({ vehicle, clientes }) {
    // Inicializar formulario con datos actuales del vehículo
    const { data, setData, put, processing, errors } = useForm({
        placa: vehicle.placa || '',
        propietario: vehicle.propietario || '',
        telefono: vehicle.telefono || '',
        modelo: vehicle.modelo || '',
        estado: vehicle.estado || 'En espera',
        servicio: vehicle.servicio || '',
        hora: vehicle.hora || '',
        id_cliente: vehicle.id_cliente || '',
    });

    function handleChange(e) {
        setData(e.target.name, e.target.value);
    }

    // Enviar actualización al backend (PUT /vehicles/{id})
    function handleSubmit(e) {
        e.preventDefault();
        put(`/vehicles/${vehicle.id_vehiculo}`);
    }

    return (
        <>
            <Head title="Editar Vehículo" />

            <MainLayout title="Editar Vehículo" backRoute="/vehicles">

                <div style={{ padding: '20px' }}>
                    <form onSubmit={handleSubmit}>

                        <InputField label="Placa" name="placa" value={data.placa}
                            onChange={handleChange} errors={errors} placeholder="Placa" />

                        <InputField label="Propietario" name="propietario" value={data.propietario}
                            onChange={handleChange} errors={errors} placeholder="Nombre del propietario" />

                        <InputField label="Teléfono" name="telefono" value={data.telefono}
                            onChange={handleChange} errors={errors} placeholder="Teléfono" />

                        <InputField label="Modelo" name="modelo" value={data.modelo}
                            onChange={handleChange} errors={errors} placeholder="Modelo del vehículo" />

                        {/* Campo: Estado */}
                        <div style={{ marginBottom: '14px' }}>
                            <label style={{ fontSize: '13px', color: '#555', display: 'block', marginBottom: '4px' }}>Estado</label>
                            <select name="estado" value={data.estado} onChange={handleChange} style={selectStyle}>
                                <option value="En espera">En espera</option>
                                <option value="En proceso">En proceso</option>
                                <option value="Listo">Listo</option>
                            </select>
                        </div>

                        <InputField label="Servicio" name="servicio" value={data.servicio}
                            onChange={handleChange} errors={errors} placeholder="Servicio" />

                        <InputField label="Hora" name="hora" type="time" value={data.hora}
                            onChange={handleChange} errors={errors} />

                        {/* Campo: Cliente */}
                        {clientes.length > 0 && (
                            <div style={{ marginBottom: '14px' }}>
                                <label style={{ fontSize: '13px', color: '#555', display: 'block', marginBottom: '4px' }}>
                                    Cliente (opcional)
                                </label>
                                <select name="id_cliente" value={data.id_cliente} onChange={handleChange} style={selectStyle}>
                                    <option value="">-- Sin cliente --</option>
                                    {clientes.map(c => (
                                        <option key={c.id_cliente} value={c.id_cliente}>{c.nombre}</option>
                                    ))}
                                </select>
                            </div>
                        )}

                        <button type="submit" disabled={processing} style={submitBtn}>
                            {processing ? 'Actualizando...' : 'Actualizar'}
                        </button>

                    </form>
                </div>

            </MainLayout>
        </>
    );
}

const selectStyle = {
    width: '100%', padding: '12px', borderRadius: '8px',
    border: '1px solid #ddd', fontSize: '15px',
    fontFamily: 'Inter, sans-serif', boxSizing: 'border-box',
};

const submitBtn = {
    width: '100%', padding: '14px', background: '#48C9B0',
    color: '#fff', border: 'none', borderRadius: '10px',
    fontSize: '16px', fontWeight: '600', cursor: 'pointer', marginTop: '8px',
};

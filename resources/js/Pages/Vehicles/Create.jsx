/**
 * Vehicles/Create.jsx — Formulario para registrar un nuevo vehículo
 *
 * Usa useForm de Inertia para manejar estado y envío.
 * Los errores de validación llegan automáticamente desde $request->validate.
 */

import { useForm, Head, Link } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';
import InputField from '../../Components/InputField';

export default function VehiclesCreate({ clientes, lang }) {
    // Estado del formulario manejado por Inertia
    const { data, setData, post, processing, errors } = useForm({
        placa: '',
        propietario: '',
        telefono: '',
        modelo: '',
        estado: 'En espera',
        servicio: '',
        hora: '',
        id_cliente: '',
    });

    // Manejar cambio de campos
    function handleChange(e) {
        setData(e.target.name, e.target.value);
    }

    // Enviar formulario al backend (POST /vehicles)
    function handleSubmit(e) {
        e.preventDefault();
        post('/vehicles');
    }

    return (
        <>
            <Head title="Registrar Vehículo" />

            <MainLayout title="Registrar Vehículo" backRoute="/vehicles">

                <div style={{ padding: '20px' }}>
                    <form onSubmit={handleSubmit}>

                        {/* Campo: Placa */}
                        <InputField
                            label="Placa"
                            name="placa"
                            value={data.placa}
                            onChange={handleChange}
                            errors={errors}
                            placeholder="Ej: ABC123"
                        />

                        {/* Campo: Propietario */}
                        <InputField
                            label="Nombre del propietario"
                            name="propietario"
                            value={data.propietario}
                            onChange={handleChange}
                            errors={errors}
                            placeholder="Nombre completo"
                        />

                        {/* Campo: Teléfono */}
                        <InputField
                            label="Teléfono"
                            name="telefono"
                            value={data.telefono}
                            onChange={handleChange}
                            errors={errors}
                            placeholder="Teléfono de contacto"
                        />

                        {/* Campo: Modelo */}
                        <InputField
                            label="Modelo del vehículo"
                            name="modelo"
                            value={data.modelo}
                            onChange={handleChange}
                            errors={errors}
                            placeholder="Ej: Toyota Corolla 2020"
                        />

                        {/* Campo: Estado */}
                        <div style={{ marginBottom: '14px' }}>
                            <label style={{ fontSize: '13px', color: '#555', display: 'block', marginBottom: '4px' }}>
                                Estado
                            </label>
                            <select
                                name="estado"
                                value={data.estado}
                                onChange={handleChange}
                                style={selectStyle}
                            >
                                <option value="En espera">En espera</option>
                                <option value="En proceso">En proceso</option>
                                <option value="Listo">Listo</option>
                            </select>
                        </div>

                        {/* Campo: Servicio */}
                        <InputField
                            label="Servicio"
                            name="servicio"
                            value={data.servicio}
                            onChange={handleChange}
                            errors={errors}
                            placeholder="Ej: Lavado completo"
                        />

                        {/* Campo: Hora */}
                        <InputField
                            label="Hora"
                            name="hora"
                            type="time"
                            value={data.hora}
                            onChange={handleChange}
                            errors={errors}
                        />

                        {/* Campo: Cliente asociado (opcional) */}
                        {clientes.length > 0 && (
                            <div style={{ marginBottom: '14px' }}>
                                <label style={{ fontSize: '13px', color: '#555', display: 'block', marginBottom: '4px' }}>
                                    Cliente (opcional)
                                </label>
                                <select name="id_cliente" value={data.id_cliente} onChange={handleChange} style={selectStyle}>
                                    <option value="">-- Sin cliente asociado --</option>
                                    {clientes.map(c => (
                                        <option key={c.id_cliente} value={c.id_cliente}>{c.nombre}</option>
                                    ))}
                                </select>
                                {errors.id_cliente && (
                                    <span style={{ color: '#e74c3c', fontSize: '12px' }}>{errors.id_cliente}</span>
                                )}
                            </div>
                        )}

                        {/* Botón registrar */}
                        <button type="submit" disabled={processing} style={submitBtn}>
                            {processing ? 'Registrando...' : 'Registrar'}
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

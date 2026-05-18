/**
 * Clientes/Edit.jsx — Formulario de edición de cliente
 *
 * Carga los datos actuales del cliente y permite actualizarlos.
 * Usa PUT via Inertia con validación automática del backend.
 */

import { useForm, Head } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';
import InputField from '../../Components/InputField';

export default function ClientesEdit({ cliente }) {
    // Inicializar con datos actuales del cliente
    const { data, setData, put, processing, errors } = useForm({
        nombre: cliente.nombre || '',
        telefono: cliente.telefono || '',
        correo: cliente.correo || '',
    });

    function handleChange(e) {
        setData(e.target.name, e.target.value);
    }

    // Enviar actualización (PUT /clientes/{id})
    function handleSubmit(e) {
        e.preventDefault();
        put(`/clientes/${cliente.id_cliente}`);
    }

    return (
        <>
            <Head title="Editar Cliente" />

            <MainLayout title="Editar Cliente" backRoute="/clientes">

                <div style={{ padding: '20px' }}>
                    <form onSubmit={handleSubmit}>

                        <InputField label="Nombre completo" name="nombre" value={data.nombre}
                            onChange={handleChange} errors={errors} placeholder="Nombre del cliente" />

                        <InputField label="Teléfono" name="telefono" value={data.telefono}
                            onChange={handleChange} errors={errors} placeholder="Teléfono" />

                        <InputField label="Correo electrónico" name="correo" type="email" value={data.correo}
                            onChange={handleChange} errors={errors} placeholder="correo@ejemplo.com" />

                        <button type="submit" disabled={processing} style={{
                            width: '100%', padding: '14px', background: '#48C9B0',
                            color: '#fff', border: 'none', borderRadius: '10px',
                            fontSize: '16px', fontWeight: '600', cursor: 'pointer', marginTop: '8px',
                        }}>
                            {processing ? 'Actualizando...' : 'Actualizar'}
                        </button>

                    </form>
                </div>

            </MainLayout>
        </>
    );
}

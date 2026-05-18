/**
 * Clientes/Create.jsx — Formulario para registrar un nuevo cliente
 *
 * Usa useForm de Inertia. Los errores de validación llegan
 * automáticamente desde $request->validate en ClienteController.
 */

import { useForm, Head } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';
import InputField from '../../Components/InputField';

export default function ClientesCreate() {
    const { data, setData, post, processing, errors } = useForm({
        nombre: '',
        telefono: '',
        correo: '',
    });

    function handleChange(e) {
        setData(e.target.name, e.target.value);
    }

    // Enviar formulario (POST /clientes)
    function handleSubmit(e) {
        e.preventDefault();
        post('/clientes');
    }

    return (
        <>
            <Head title="Registrar Cliente" />

            <MainLayout title="Registrar Cliente" backRoute="/clientes">

                <div style={{ padding: '20px' }}>
                    <form onSubmit={handleSubmit}>

                        <InputField label="Nombre completo" name="nombre" value={data.nombre}
                            onChange={handleChange} errors={errors} placeholder="Nombre del cliente" />

                        <InputField label="Teléfono" name="telefono" value={data.telefono}
                            onChange={handleChange} errors={errors} placeholder="Teléfono de contacto" />

                        <InputField label="Correo electrónico" name="correo" type="email" value={data.correo}
                            onChange={handleChange} errors={errors} placeholder="correo@ejemplo.com" />

                        <button type="submit" disabled={processing} style={{
                            width: '100%', padding: '14px', background: '#48C9B0',
                            color: '#fff', border: 'none', borderRadius: '10px',
                            fontSize: '16px', fontWeight: '600', cursor: 'pointer', marginTop: '8px',
                        }}>
                            {processing ? 'Registrando...' : 'Registrar'}
                        </button>

                    </form>
                </div>

            </MainLayout>
        </>
    );
}

/**
 * InputField.jsx — Componente reutilizable de campo de formulario
 *
 * Muestra un input con su label y mensaje de error si existe.
 * Recibe errors desde Inertia (inyectados por $request->validate en Laravel).
 */

export default function InputField({ label, name, type = 'text', value, onChange, errors, placeholder }) {
    return (
        <div style={{ marginBottom: '14px' }}>
            {/* Label del campo */}
            {label && (
                <label style={{ fontSize: '13px', color: '#555', display: 'block', marginBottom: '4px' }}>
                    {label}
                </label>
            )}

            {/* Input del campo */}
            <input
                type={type}
                name={name}
                value={value}
                onChange={onChange}
                placeholder={placeholder}
                style={{
                    width: '100%',
                    padding: '12px',
                    borderRadius: '8px',
                    border: errors?.[name] ? '1.5px solid #e74c3c' : '1px solid #ddd',
                    fontSize: '15px',
                    fontFamily: 'Inter, sans-serif',
                    boxSizing: 'border-box',
                    outline: 'none',
                }}
            />

            {/* Mensaje de error inyectado por Laravel vía Inertia */}
            {errors?.[name] && (
                <span style={{ color: '#e74c3c', fontSize: '12px', marginTop: '4px', display: 'block' }}>
                    {errors[name]}
                </span>
            )}
        </div>
    );
}

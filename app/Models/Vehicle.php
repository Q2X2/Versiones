<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Vehicle (Vehiculo)
 * 
 * Representa un vehículo registrado en el sistema de autolavado.
 * Se relaciona con el modelo Cliente mediante id_cliente.
 * 
 * Tabla: vehiculo
 * PK:    id_vehiculo
 */
class Vehicle extends Model
{
    // Nombre de la tabla en snake_case
    protected $table = 'vehiculo';

    // Llave primaria personalizada en snake_case
    protected $primaryKey = 'id_vehiculo';

    // Sin timestamps (created_at / updated_at)
    public $timestamps = false;

    // Campos permitidos para asignación masiva (snake_case)
    protected $fillable = [
        'placa',
        'propietario',
        'telefono',
        'modelo',
        'servicio',
        'estado',
        'hora',
        'id_cliente',
    ];

    /**
     * Relación: un vehículo pertenece a un cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }
}

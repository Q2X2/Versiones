<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Cliente
 * 
 * Representa un cliente registrado en el sistema de autolavado.
 * Un cliente puede tener múltiples vehículos asociados.
 * 
 * Tabla: cliente
 * PK:    id_cliente
 */
class Cliente extends Model
{
    // Nombre de la tabla en snake_case
    protected $table = 'cliente';

    // Llave primaria personalizada en snake_case
    protected $primaryKey = 'id_cliente';

    // Sin timestamps
    public $timestamps = false;

    // Campos permitidos para asignación masiva (snake_case)
    protected $fillable = [
        'nombre',
        'telefono',
        'correo',
    ];

    /**
     * Relación: un cliente puede tener muchos vehículos.
     */
    public function vehiculos()
    {
        return $this->hasMany(Vehicle::class, 'id_cliente', 'id_cliente');
    }
}

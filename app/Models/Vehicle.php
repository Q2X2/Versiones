<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehiculo';

    protected $primaryKey = 'id_vehiculo';

    public $timestamps = false;

    protected $fillable = [
        'placa',
        'propietario',
        'telefono',
        'modelo',
        'servicio',
        'estado',
        'hora',
    ];
}

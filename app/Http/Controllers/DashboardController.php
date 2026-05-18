<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Cliente;
use Inertia\Inertia;

/**
 * DashboardController
 *
 * Controlador del panel de control principal.
 * Muestra estadísticas y permite explorar la API REST.
 * Accesible tras el login como trabajador (TurnosTrabajadores).
 */
class DashboardController extends Controller
{
    /**
     * GET /dashboard
     * Retorna la página React Dashboard con estadísticas del sistema.
     */
    public function index()
    {
        // Total de vehículos y clientes registrados
        $totalVehiculos = Vehicle::count();
        $totalClientes  = Cliente::count();

        // Cantidad de vehículos agrupados por estado
        $vehiculosPorEstado = Vehicle::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get()
            ->map(fn($v) => ['estado' => $v->estado, 'total' => $v->total])
            ->values();

        return Inertia::render('Dashboard', [
            'totalVehiculos'    => $totalVehiculos,
            'totalClientes'     => $totalClientes,
            'vehiculosPorEstado' => $vehiculosPorEstado,
        ]);
    }
}

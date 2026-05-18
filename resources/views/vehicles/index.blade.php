{{-- Vista: Lista de Vehículos / Turnos --}}
{{-- Muestra todos los vehículos en turno con sus acciones CRUD --}}

@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/turnos.css">
@endpush

@section('content')

<header class="header-container">
    <a href="{{ route('index') }}" class="back-btn">←</a>
    <h2>Turnos de Vehículos</h2>
</header>

<div style="padding: 12px; display:flex; gap:8px;">
    {{-- Botón registrar vehículo --}}
    <a href="{{ route('vehicles.create') }}" style="flex:1;">
        <button type="button">+ Vehículo</button>
    </a>
    {{-- Botón ir a clientes --}}
    <a href="{{ route('clientes.index') }}" style="flex:1;">
        <button type="button" style="background:#48C9B0;">👤 Clientes</button>
    </a>
</div>

<div class="turnos-container">

    @forelse($vehicles as $vehicle)
    <div class="card-turno">

        <div>
            {{-- Información del vehículo --}}
            <p><strong>{{ $vehicle->propietario }}</strong></p>
            <p>{{ $vehicle->servicio }}</p>
            <p style="font-size:12px; color:#888;">Placa: {{ $vehicle->placa }}</p>
            <p style="font-size:12px; color:#888;">Estado: {{ $vehicle->estado }}</p>
            {{-- Mostrar cliente si está asociado --}}
            @if($vehicle->cliente)
                <p style="font-size:12px; color:#48C9B0;">
                    Cliente: {{ $vehicle->cliente->nombre }}
                </p>
            @endif
        </div>

        <div style="display:flex; flex-direction:column; align-items:center; gap:8px;">
            <img src="/img/carro.jpg" class="avatar" alt="Vehículo">

            {{-- Botón ver detalle --}}
            <a href="{{ route('vehicles.show', $vehicle->id_vehiculo) }}"
               style="font-size:12px; color:#555;">Ver</a>

            {{-- Botón editar --}}
            <a href="{{ route('vehicles.edit', $vehicle->id_vehiculo) }}"
               style="font-size:12px; color:#48C9B0;">Editar</a>

            {{-- Formulario eliminar --}}
            <form action="{{ route('vehicles.destroy', $vehicle->id_vehiculo) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    style="font-size:11px; padding:4px 8px; background:#e74c3c; color:white; width:auto;"
                    onclick="return confirm('¿Eliminar este vehículo?')">
                    Eliminar
                </button>
            </form>
        </div>

    </div>
    @empty
    {{-- Mensaje si no hay vehículos --}}
    <p style="padding:20px; text-align:center; color:#888;">No hay vehículos registrados.</p>
    @endforelse

</div>

@endsection

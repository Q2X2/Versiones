{{-- Vista: Lista de Clientes --}}
{{-- Muestra todos los clientes registrados con opción de editar y eliminar --}}

@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/turnos.css">
@endpush

@section('content')

<header class="header-container">
    <a href="{{ route('vehicles.index') }}" class="back-btn">←</a>
    <h2>Clientes</h2>
</header>

<div style="padding: 12px;">
    {{-- Botón para registrar nuevo cliente --}}
    <a href="{{ route('clientes.create') }}">
        <button type="button" style="margin-bottom:12px;">+ Registrar Cliente</button>
    </a>
</div>

<div class="turnos-container">

    @forelse($clientes as $cliente)
    <div class="card-turno">

        <div>
            {{-- Datos del cliente --}}
            <p><strong>{{ $cliente->nombre }}</strong></p>
            @if($cliente->telefono)
                <p style="font-size:13px; color:#555;">📞 {{ $cliente->telefono }}</p>
            @endif
            @if($cliente->correo)
                <p style="font-size:12px; color:#888;">✉ {{ $cliente->correo }}</p>
            @endif
            {{-- Cantidad de vehículos asociados --}}
            <p style="font-size:12px; color:#48C9B0;">
                🚗 {{ $cliente->vehiculos->count() }} vehículo(s)
            </p>
        </div>

        <div style="display:flex; flex-direction:column; align-items:center; gap:8px;">
            {{-- Botón editar --}}
            <a href="{{ route('clientes.edit', $cliente->id_cliente) }}"
               style="font-size:12px; color:#48C9B0;">Editar</a>

            {{-- Formulario eliminar con confirmación --}}
            <form action="{{ route('clientes.destroy', $cliente->id_cliente) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    style="font-size:11px; padding:4px 8px; background:#e74c3c; color:white; width:auto;"
                    onclick="return confirm('¿Eliminar este cliente?')">
                    Eliminar
                </button>
            </form>
        </div>

    </div>
    @empty
    {{-- Mensaje cuando no hay clientes --}}
    <p style="padding:20px; text-align:center; color:#888;">No hay clientes registrados.</p>
    @endforelse

</div>

@endsection

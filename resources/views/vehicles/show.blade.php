{{-- Vista: Estado del Vehículo --}}
{{-- Muestra el detalle completo del vehículo y su estado en el autolavado --}}

@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/estado.css">
@endpush

@section('content')

<header class="header-container">
    <a href="{{ route('vehicles.index') }}" class="back-btn">←</a>
    <h2>Estado del Vehículo</h2>
</header>

<div class="estado-container">

    {{-- Imagen del vehículo --}}
    <div class="car-card">
        <img src="/img/carro.jpg" alt="Vehículo">
    </div>

    {{-- Información detallada del vehículo --}}
    <div class="info">

        <div class="info-item">
            <span>Propietario</span>
            <span>{{ $vehicle->propietario }}</span>
        </div>

        <div class="info-item">
            <span>Placa</span>
            <span>{{ $vehicle->placa }}</span>
        </div>

        <div class="info-item">
            <span>Modelo</span>
            <span>{{ $vehicle->modelo ?? '—' }}</span>
        </div>

        <div class="info-item">
            <span>Servicio</span>
            <span>{{ $vehicle->servicio }}</span>
        </div>

        <div class="info-item">
            <span>Estado</span>
            <span>{{ $vehicle->estado }}</span>
        </div>

        {{-- Mostrar hora solo si fue registrada --}}
        @if($vehicle->hora)
        <div class="info-item">
            <span>Hora</span>
            <span>{{ $vehicle->hora }}</span>
        </div>
        @endif

        {{-- Mostrar teléfono si existe --}}
        @if($vehicle->telefono)
        <div class="info-item">
            <span>Teléfono</span>
            <span>{{ $vehicle->telefono }}</span>
        </div>
        @endif

        {{-- Mostrar cliente asociado si existe --}}
        @if($vehicle->cliente)
        <div class="info-item">
            <span>Cliente</span>
            <span>{{ $vehicle->cliente->nombre }}</span>
        </div>
        @endif

    </div>

    {{-- Calificación visual --}}
    <div class="calificacion">
        ★★★★★
    </div>

</div>

@endsection

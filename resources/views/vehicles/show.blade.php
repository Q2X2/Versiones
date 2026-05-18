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

    <div class="car-card">
        <img src="/img/carro.jpg" alt="Vehículo">
    </div>

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
            <span>{{ $vehicle->estado ?? 'En espera' }}</span>
        </div>

        @if($vehicle->hora)
        <div class="info-item">
            <span>Hora</span>
            <span>{{ $vehicle->hora }}</span>
        </div>
        @endif

        @if($vehicle->telefono)
        <div class="info-item">
            <span>Teléfono</span>
            <span>{{ $vehicle->telefono }}</span>
        </div>
        @endif

    </div>

    <div class="calificacion">
        ★★★★★
    </div>

</div>

@endsection

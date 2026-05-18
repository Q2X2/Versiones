{{-- Vista: Formulario de Registro de Vehículo --}}
{{-- Permite registrar un nuevo vehículo con todos sus datos --}}

@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/registro.css">
@endpush

@section('content')

<header class="header-container">
    <a href="{{ route('vehicles.index') }}" class="back-btn">←</a>
    <h2>Registrar Vehículo</h2>
</header>

<div class="registro-container">

    {{-- Formulario POST para crear vehículo --}}
    <form action="{{ route('vehicles.store') }}" method="POST">
        @csrf

        {{-- Campo: Placa --}}
        <div class="form-group">
            <input type="text" name="placa" placeholder="Placa"
                value="{{ old('placa') }}" required>
            @error('placa')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Campo: Propietario --}}
        <div class="form-group">
            <input type="text" name="propietario" placeholder="Nombre del propietario"
                value="{{ old('propietario') }}" required>
            @error('propietario')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Campo: Teléfono --}}
        <div class="form-group">
            <input type="text" name="telefono" placeholder="Teléfono"
                value="{{ old('telefono') }}">
        </div>

        {{-- Campo: Modelo --}}
        <div class="form-group">
            <input type="text" name="modelo" placeholder="Modelo del vehículo"
                value="{{ old('modelo') }}">
        </div>

        {{-- Campo: Estado --}}
        <div class="form-group">
            <select name="estado" style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; font-family:Inter; font-size:15px;">
                <option value="En espera" {{ old('estado') == 'En espera' ? 'selected' : '' }}>En espera</option>
                <option value="En proceso" {{ old('estado') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="Listo" {{ old('estado') == 'Listo' ? 'selected' : '' }}>Listo</option>
            </select>
        </div>

        {{-- Campo: Servicio --}}
        <div class="form-group">
            <input type="text" name="servicio" placeholder="Servicio (ej: Lavado completo)"
                value="{{ old('servicio') }}" required>
            @error('servicio')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Campo: Hora --}}
        <div class="form-group">
            <input type="time" name="hora" value="{{ old('hora') }}">
        </div>

        {{-- Campo: Cliente asociado (opcional) --}}
        @if($clientes->count() > 0)
        <div class="form-group">
            <select name="id_cliente" style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; font-family:Inter; font-size:15px;">
                <option value="">-- Asociar a cliente (opcional) --</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id_cliente }}"
                        {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_cliente')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>
        @endif

        <button type="submit">Registrar</button>

    </form>

</div>

@endsection

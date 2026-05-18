{{-- Vista: Formulario de Edición de Vehículo --}}
{{-- Permite actualizar los datos de un vehículo existente --}}

@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/registro.css">
@endpush

@section('content')

<header class="header-container">
    <a href="{{ route('vehicles.index') }}" class="back-btn">←</a>
    <h2>Editar Vehículo</h2>
</header>

<div class="registro-container">

    {{-- Formulario PUT para actualizar vehículo --}}
    <form action="{{ route('vehicles.update', $vehicle->id_vehiculo) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Campo: Placa --}}
        <div class="form-group">
            <input type="text" name="placa" placeholder="Placa"
                value="{{ old('placa', $vehicle->placa) }}" required>
            @error('placa')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Campo: Propietario --}}
        <div class="form-group">
            <input type="text" name="propietario" placeholder="Nombre del propietario"
                value="{{ old('propietario', $vehicle->propietario) }}" required>
            @error('propietario')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Campo: Teléfono --}}
        <div class="form-group">
            <input type="text" name="telefono" placeholder="Teléfono"
                value="{{ old('telefono', $vehicle->telefono) }}">
        </div>

        {{-- Campo: Modelo --}}
        <div class="form-group">
            <input type="text" name="modelo" placeholder="Modelo"
                value="{{ old('modelo', $vehicle->modelo) }}">
        </div>

        {{-- Campo: Estado --}}
        <div class="form-group">
            <select name="estado" style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; font-family:Inter; font-size:15px;">
                <option value="En espera" {{ old('estado', $vehicle->estado) == 'En espera' ? 'selected' : '' }}>En espera</option>
                <option value="En proceso" {{ old('estado', $vehicle->estado) == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="Listo" {{ old('estado', $vehicle->estado) == 'Listo' ? 'selected' : '' }}>Listo</option>
            </select>
        </div>

        {{-- Campo: Servicio --}}
        <div class="form-group">
            <input type="text" name="servicio" placeholder="Servicio"
                value="{{ old('servicio', $vehicle->servicio) }}" required>
            @error('servicio')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Campo: Hora --}}
        <div class="form-group">
            <input type="time" name="hora" value="{{ old('hora', $vehicle->hora) }}">
        </div>

        {{-- Campo: Cliente asociado --}}
        @if($clientes->count() > 0)
        <div class="form-group">
            <select name="id_cliente" style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; font-family:Inter; font-size:15px;">
                <option value="">-- Sin cliente asociado --</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id_cliente }}"
                        {{ old('id_cliente', $vehicle->id_cliente) == $cliente->id_cliente ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <button type="submit">Actualizar</button>

    </form>

</div>

@endsection

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

    <form action="{{ route('vehicles.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <input type="text" name="placa" placeholder="Placa" value="{{ old('placa') }}" required>
            @error('placa') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <input type="text" name="propietario" placeholder="Nombre del propietario" value="{{ old('propietario') }}" required>
            @error('propietario') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <input type="text" name="telefono" placeholder="Teléfono" value="{{ old('telefono') }}">
        </div>

        <div class="form-group">
            <input type="text" name="modelo" placeholder="Modelo" value="{{ old('modelo') }}">
        </div>

        <div class="form-group">
            <select name="estado" style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; font-family:Inter; font-size:15px;">
                <option value="" disabled selected>Estado</option>
                <option value="En espera" {{ old('estado') == 'En espera' ? 'selected' : '' }}>En espera</option>
                <option value="En proceso" {{ old('estado') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="Listo" {{ old('estado') == 'Listo' ? 'selected' : '' }}>Listo</option>
            </select>
        </div>

        <div class="form-group">
            <input type="text" name="servicio" placeholder="Servicio (ej: Lavado completo)" value="{{ old('servicio') }}" required>
            @error('servicio') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <input type="time" name="hora" placeholder="Hora" value="{{ old('hora') }}">
        </div>

        <button type="submit">Registrar</button>

    </form>

</div>

@endsection

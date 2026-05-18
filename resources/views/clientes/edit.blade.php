{{-- Vista: Formulario de Edición de Cliente --}}
{{-- Permite actualizar los datos de un cliente existente --}}

@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/registro.css">
@endpush

@section('content')

<header class="header-container">
    <a href="{{ route('clientes.index') }}" class="back-btn">←</a>
    <h2>Editar Cliente</h2>
</header>

<div class="registro-container">

    {{-- Formulario PUT para actualizar cliente --}}
    <form action="{{ route('clientes.update', $cliente->id_cliente) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Campo: Nombre --}}
        <div class="form-group">
            <input type="text" name="nombre" placeholder="Nombre completo"
                value="{{ old('nombre', $cliente->nombre) }}" required>
            @error('nombre')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Campo: Teléfono --}}
        <div class="form-group">
            <input type="text" name="telefono" placeholder="Teléfono"
                value="{{ old('telefono', $cliente->telefono) }}">
        </div>

        {{-- Campo: Correo --}}
        <div class="form-group">
            <input type="email" name="correo" placeholder="Correo electrónico"
                value="{{ old('correo', $cliente->correo) }}">
            @error('correo')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Actualizar</button>

    </form>

</div>

@endsection

{{-- Vista: Formulario de Registro de Cliente --}}
{{-- Permite registrar un nuevo cliente con nombre, teléfono y correo --}}

@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/registro.css">
@endpush

@section('content')

<header class="header-container">
    <a href="{{ route('clientes.index') }}" class="back-btn">←</a>
    <h2>Registrar Cliente</h2>
</header>

<div class="registro-container">

    {{-- Formulario POST para crear cliente --}}
    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        {{-- Campo: Nombre --}}
        <div class="form-group">
            <input type="text" name="nombre" placeholder="Nombre completo"
                value="{{ old('nombre') }}" required>
            @error('nombre')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Campo: Teléfono --}}
        <div class="form-group">
            <input type="text" name="telefono" placeholder="Teléfono"
                value="{{ old('telefono') }}">
        </div>

        {{-- Campo: Correo --}}
        <div class="form-group">
            <input type="email" name="correo" placeholder="Correo electrónico"
                value="{{ old('correo') }}">
            @error('correo')
                <span style="color:red; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Registrar</button>

    </form>

</div>

@endsection

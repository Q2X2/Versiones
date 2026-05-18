@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/login.css">
@endpush

@section('content')

<div class="login-container">

    <img src="/img/logo-rueda-verde.png" class="logo" alt="Logo Rueda Verde">

    <h1 class="titulo">Rueda Verde</h1>

    <h3 class="subtitulo">Inicio de sesión</h3>

    <p class="descripcion">
        Ingresa tu usuario o placa del vehículo
    </p>

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <input
            id="loginInput"
            class="login-input"
            type="text"
            name="login_input"
            placeholder="Usuario o placa"
            value="{{ old('login_input') }}"
            required
        >

        @if(session('error'))
            <p style="color:red; font-size:14px; margin-top:8px;">{{ session('error') }}</p>
        @endif

        <button type="submit" class="login-btn">Continuar</button>

    </form>

    <p class="terminos">
        Al hacer clic en continuar aceptas nuestros términos
    </p>

</div>

@endsection

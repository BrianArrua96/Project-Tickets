@extends('layouts.master')

@section('title', 'Login')
@section('metadades', 'Inicia sesión en tu cuenta para poder crear eventos nuevos o modificar los existentes.')


@section('content')
    <div class="login">
        <div class="login-div">
            @if ($errors->has('error'))
                <span class="msg-error">{{ $errors->first('error') }}</span>
            @elseif($errors->has('vali'))
                <span class="msg-valido">{{ $errors->first('vali') }}</span>
            @endif
            <h2>Login</h2>
            <form action="{{ route('iniciarSesion') }}" method="post" id="loginForm" class="login-form">
                @csrf
                <div class="login-input">
                    <label for="usuario" class="form-label">Nombre de usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Contraseña" required>
                    <a href="recuperar">Contraseña olvidada?</a>
                </div>
                <input type="submit" value="Acceder" class="btn btn-orange">
            </form>
        </div>
    </div>
@endsection

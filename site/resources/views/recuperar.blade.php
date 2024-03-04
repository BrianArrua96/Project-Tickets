@extends('layouts.master')

@section('title', 'Recuperar')
@section('metadades','Reccupera tu cuenta con tan solo poner tu email.')

@section('content')
    <div class="login">
        <div class="login-div">
            @if ($errors->has('error'))
                <span class="msg-error">{{ $errors->first('error') }}</span>
            @endif
            <h2>Contraseña Olvidada</h2>
            <span id="indicador">Escriba la cuenta a recuperar.</span> <br> <br>
            <form action="{{ route('recuperar-form') }}" method="post" id="recuperarForm">
                @csrf
                <div class="login-input">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div>
                    <a href="{{ route('login') }}" class="btn btn-red" id="atras">Atrás</a>
                    <input type="submit" value="Enviar" class="btn btn-orange">
                </div>
            </form>
        </div>
    </div>
@endsection

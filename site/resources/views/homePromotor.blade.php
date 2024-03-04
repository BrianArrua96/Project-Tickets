@extends('layouts.master')

@section('title', 'Home')

@section('content')

        <div class="bg">
            @if (session('key'))
                <div class="button-container">
                    <a href="{{ route('administrar-esdeveniments') }}" class="btn btn-blue">Administrar Eventos</a>
                    <a href="{{ route('llistat-sessions' )}}" class="btn btn-blue">Listado de sesiones</a>
                    <a href="{{ route('crear-esdeveniment') }}" class="btn btn-blue">Crear Evento</a>
                    <!--<a href="{{ route('crear-esdeveniment') }}" class="btn btn-blue">Descargar validacion de tickets</a> -->
                </div>
            @endif
        </div>
@endsection

@extends('layouts.master')

@section('title', 'resultados')
@section('metadades', 'Administra todos los eventos que hayas creados, modificalos, eliminalos, ponlos en oculto o públicalos.')

@section('content')
    @if ($esdeveniments->isEmpty())
        <div class="center-message">
            <p class="info-alert">No se ha encontrado ningún evento.</p>
        </div>
    @else
        <div class="info-message">
            <p class="info-text">Haz clic sobre un evento para poder editarlo.</p>
        </div>

        <div class="event-cards">
            @foreach ($esdeveniments as $esdeveniment)
                <a href="{{ route('editar-esdeveniment', ['id' => $esdeveniment->id]) }}" class="event-link">
                    {{-- Incluir el componente de tarjeta de evento --}}
                    @include('components.event-card', ['esdeveniment' => $esdeveniment])
                </a>
            @endforeach
        </div>
        <div class="pages">{{ $esdeveniments->links('pagination::bootstrap-5') }}</div>
    @endif
@endsection

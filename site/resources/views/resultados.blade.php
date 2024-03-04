@extends('layouts.master')

@section('title', 'resultados')
@section('metadades','Entra en ShowTickt para poder comprar tickets a los mejores eventos disponibles.')

@section('content')
    <div class="container">
        <form action="{{ route('cerca') }}" method="get" class="form form-filtre" id="filtre">
            <div class="input-group">
                <select name="category" class="form-control" onchange="this.form.submit()">
                    <option value="" disabled>Categorías</option>
                    <option value="" {{ $categoryId === null ? 'selected' : '' }}>Mostrar todos</option>
                    @foreach ($categoriesWithEventCount as $category)
                        <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->tipus }} ({{ $category->eventCount }} eventos)
                        </option>
                    @endforeach
                </select>
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path
                            d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" />
                    </svg>
                </div>
            </div>
        </form>



        <!-- Formulario de búsqueda -->
        <form action="{{ route('cerca') }}" method="get" class="form form-cerca" id="cerca">
            <div class="input-group">
                <!-- Campo de entrada oculto para la categoría -->
                <input type="hidden" name="category" value="{{ $categoryId }}">
                <input type="text" name="q" class="form-control" placeholder="Buscar" value="{{ request('q') }}">
                <button type="submit" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" height="16"
                        width="16"
                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                        <path fill="#1e91d9"
                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                    </svg></button>
            </div>
        </form>
        <form id="promotores" class="form form-promotores" method="POST"
            action="@if (session('key')) {{ route('homePromotor') }}
            @else{{ route('login') }} @endif">
            @csrf
            <input class="btn btn-orange" type="submit" value="PROMOTORES">
        </form>
    </div>

    @if ($esdeveniments->isEmpty())
        <div class="center-message">
            <p class="info-alert">No se ha encontrado ningún evento.</p>
        </div>
    @else
        <div class="event-cards">
            @foreach ($esdeveniments as $esdeveniment)
                <a href="{{ route('mostrar-esdeveniment', ['id' => $esdeveniment->id]) }}" class="event-link">
                    {{-- Incluir el componente de tarjeta de evento --}}
                    @include('components.event-card', ['esdeveniment' => $esdeveniment])
                </a>
            @endforeach
        </div>
        <div class="pages">{{ $esdeveniments->links('pagination::bootstrap-5') }}</div>
    @endif
@endsection

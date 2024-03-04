@extends('layouts.master')

@section('title', 'Editar Evento')
@section('metadades', 'Edita tu evento para actualizar correctamente los datos de este.')

@section('content')
    <div class="containerEvent">
        <div class="textEvent">
            <h1>{{ $esdeveniment->nom }}</h1>
            @if (isset($estado))
                @if ($estado == true)
                    <div id="estado" class="estadoSesion msg-valido">
                        <p>Sesión Abierta con éxito</p>
                    </div>
                @else
                    <div id="estado" class="estadoSesion msg-error">
                        <p>Sesión Cerrada con éxito</p>
                    </div>
                @endif
            @endif
            <button id="fechaButton">Fechas
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="10"
                    width="10"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path
                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                </svg>
            </button>
            <div class="form-select" id="fechaDiv" name="fecha" style="display: none;">
                <button id="exit"><svg xmlns="http://www.w3.org/2000/svg" height="14" width="10.5"
                        viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path
                            d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                    </svg></button>
                @foreach ($fechas as $fecha)
                    <div class="fecha">
                        <form action="{{ route('editarSesion') }}" method="GET" class="SessionEditar">
                            <input type="hidden" name="eventoId" value="{{ $esdeveniment->id }}">
                            <input type="hidden" name="fechaId" value="{{ $fecha->id }}">
                            <p value="{{ $fecha->id }}">{{ $fecha->data }}</p>
                            <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="14" width="14"
                                    viewBox="0 0 512 512">
                                    <path
                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                </svg></button>
                        </form>
                        @if ($fecha->estado != true)
                            <form action="{{ route('abrirSesion') }}" method="post">
                                @csrf
                                <input type="hidden" name="eventoId" value="{{ $esdeveniment->id }}">
                                <input type="hidden" name="fechaId" value="{{ $fecha->id }}">
                                <button type="submit" alt="Abrir Sesion">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="14" width="14"
                                        viewBox="0 0 576 512">
                                        <path
                                            d="M352 144c0-44.2 35.8-80 80-80s80 35.8 80 80v48c0 17.7 14.3 32 32 32s32-14.3 32-32V144C576 64.5 511.5 0 432 0S288 64.5 288 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H352V144z" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('cerrarSesion') }}" method="post">
                                @csrf
                                <input type="hidden" name="eventoId" value="{{ $esdeveniment->id }}">
                                <input type="hidden" name="fechaId" value="{{ $fecha->id }}">
                                <button type="submit" alt="Cerrar Sesion">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="14" width="14"
                                        viewBox="0 0 448 512">
                                        <path
                                            d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                                    </svg>
                                </button>
                            </form>
                        @endif

                    </div>
                @endforeach
            </div>
            <form method="get" action="{{ route('añadirSession') }}">
                <input type="hidden" name="event-id" value="{{ $esdeveniment->id }}">
                <button type="submit" class="btn btn-orange">Añadir Sesión</button>
            </form>
            <p class="down">Lugar: {{ $esdeveniment->recinte->lloc }}</p>
            <!-- Otros detalles del evento -->

            <form method="get" action="{{ route('crearOpinion') }}">
                <input type="hidden" name="event-id" value="{{ $esdeveniment->id }}">
                <button type="submit" class="btn btn-orange">Añadir Opinion</button>
            </form>
        </div>
        <div class="slider-container">
            @foreach ($esdeveniment->imatge as $index => $imatge)
                <img class="mySlides" src="{{ Storage::url('public/images/' . $imatge->imatge) }}"
                    alt="Imatge de l'esdeveniment">
            @endforeach

            <button class="btn btn-blue left-button" onclick="plusDivs(-1)">&#10094;</button>
            <button class="btn btn-blue right-button" onclick="plusDivs(+1)">&#10095;</button>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n) {
            showDivs(slideIndex += n);
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            if (n > x.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = x.length
            };
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            x[slideIndex - 1].style.display = "block";
        }
    </script>
    <script>
        const fechasDiv = document.querySelector('#fechaDiv');
        const buttonFechas = document.querySelector('#fechaButton');
        const exit = document.querySelector('#exit');
        buttonFechas.addEventListener('click', function(e) {
            fechasDiv.style.display = 'grid';
            buttonFechas.style.display = 'none';

        })
        exit.addEventListener('click', function(e) {
            fechasDiv.style.display = 'none';
            buttonFechas.style.display = 'block';
        })
        setTimeout(function() {
            document.getElementById("estado").style.display = "none";
        }, 5000);
    </script>
@endsection

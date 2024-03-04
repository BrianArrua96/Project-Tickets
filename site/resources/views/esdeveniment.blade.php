@extends('layouts.master')

@section('title', 'Detalles del Evento')
@section('metadades')'Mira los detalles sobre el evento {{ $esdeveniment->nom }} y adquiere sus entradas.'@endsection
@section('metaimages')'@foreach ($esdeveniment->imatge as $index => $imatge)
    {{ Storage::url('public/images/' . $imatge->imatge) }}
@endforeach'@endsection

@section('content')
    <div class="containerEvent">

        <div class="infoEvent">
            <h1>{{ $event->nom }}</h1>
            <h4>{{ $event->descripcio }}</h4>
        </div>
        <div class="textEvent">
            <form action="{{ route('detallesLocal', ['id' => $esdeveniment->id]) }}" method="get"
                class="detallesLocal espacioEventos" id="detallesLocal">
                <p><strong>Local:</strong> {{ $esdeveniment->lloc }}</p>
                <button type="submit" class="btn btn-blue">Ver Local</button>
            </form>

            <form action="{{ route('confirmacioCompra') }}" method="post" class="ComprarEntrada espacioEventos"
                id="ComprarEntrada" enctype="multipart/form-data" style="justify-self: normal">
                @csrf
                <input type="hidden" id="nameEvent" name='nameEvent' value='{{ $esdeveniment->nom }}'>
                <input type="hidden" id="idEvent" name='idEvent' value='{{ $esdeveniment->id }}'>
                @if (count($fechas) == 1)
                    @foreach ($fechas as $fecha)
                        <label for="session" class="form-label espacioEventos" id="fechaSesion"><strong>Sesiones:</strong>
                            {{ $fecha->data }}</label>
                    @endforeach
                    @php
                        $fechaSola = true;
                    @endphp
                @else
                    <div class="espacioEventos">
                        <label for="session" class="form-label" id="fechaSesion"><strong>Sesiones:</strong></label>
                        <button id="buttonSesion" class="btn btn-blue" style="display: none;">Cambiar sesión</button>
                    </div>
                    <div id="calendar"></div>
                @endif
                <div id="estado" class="msg-error" style="display:none">
                    <p>Session cerrada</p>
                </div>

                <div class="form-group espacioEventos" id="entradas" style="display:none;">
                    <label id="preu" class="form-label">Escoge el tipo de entrada:</label>
                    @foreach ($fechas as $fecha)
                        <select class="tiposTickets" id="{{ $fecha->id }}" name="preu" style="display:none;">
                            <option value="" disabled selected>Entradas</option>
                            @foreach ($entradas as $entrada)
                                @if ($entrada->sessios_id == $fecha->id)
                                    <option
                                        value="{{ $entrada->preu }},{{ $entrada->quantitat }},{{ $entrada->nom }},{{ $entrada->id }},{{ $entrada->nominal }}">
                                        {{ $entrada->nom }} {{ $entrada->preu }}€ </option>
                                @endif
                            @endforeach
                        </select>
                    @endforeach
                    {{-- @endif --}}


                    <label for="cantidad" class="form-label" id="escogerCantidad">Escoge la cantidad:</label>
                    <div class="form-group" id="errorCantidad" style="display:none;">
                        <p id="mensajeError" class="msg-error"></p>
                    </div>
                    <div class="añadirTickets">
                        <input type="number" id="cantidad" name="cantidad" min="1" max="10" value="1">
                        <button type="button" id="reservarEntrada" class="btn btn-blue">Añadir Tickets</button>
                    </div>

                    <div class="form-group" id="listaEntradas" style="display:none;">
                        <label for="cantidad" class="form-label ">Lista de Tickets:</label>
                        <br>
                        <div id="containerList">

                        </div>
                    </div>
                    <div class="form-group DivsConBotonesDerecho">
                        <p id="precioTotal" class="form-label">Total: 0€ </p>
                        <input type="hidden" id="arrayEntradas" name='arrayEntradas'>
                        <input type="hidden" id="inputTotal" name='inputTotal'>
                        <button type="submit" id="bottonCompra" class="btn btn-orange">Realizar Compra</button>
                    </div>
                </div>
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
    <div class="opinion-cards">
        @foreach ($opiniones as $opinion)
            <div class="opinion-card">
                <div class="opinion-content">
                    <p>Nombre: {{ $opinion->nom }}</p>
                    <p>Valoración: {!! $opinion->emocio !!}</p>
                    <p>Puntuación: {!! $opinion->estrellas !!}</p>
                    <p>Titulo: {{ $opinion->titol }}</p>
                    <p>Comentario: {{ $opinion->comentari }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/esdeveniment.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

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
        const fechasSessiones = @json($fechas);
        const entradaPrecio = @json($entradas);
        const fechaSola = @json($fechaSola);

        // Ordenar el array utilizando la función de comparación
        fechasSessiones.sort(compararFechas);
        if (fechaSola) {
            sessionSelect(fechasSessiones[0]);
            console.log(1);
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                let buenas;
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek'
                    },
                    selectable: true,
                    events: crearEventos(fechasSessiones),
                    eventClick: function(event) {
                        let sessionId = event.event.title.split(" ");
                        document.getElementById('calendar').style.display = 'none';
                        document.getElementById('fechaSesion').parentNode.classList.add(
                            "DivsConBotonesDerecho");
                        document.getElementById('fechaSesion').innerHTML =
                            `<strong>Sesion:</strong> ${fechasSessiones[(parseInt(sessionId[0]) - 1)].data}`;
                        document.getElementById('buttonSesion').style.display = 'block';
                        sessionSelect(fechasSessiones[(parseInt(sessionId[0]) - 1)]);

                    }
                });
                calendar.render();
            });
            document.getElementById('buttonSesion').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('calendar').style.display = 'block';
                document.getElementById('fechaSesion').innerHTML =
                    `<strong>Sesiones:</strong>`;
                document.getElementById('fechaSesion').parentNode.classList.remove("DivsConBotonesDerecho");
                document.getElementById('buttonSesion').style.display = 'none';
            })
        }
    </script>
@endsection

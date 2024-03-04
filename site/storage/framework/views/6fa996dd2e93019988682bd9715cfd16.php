<?php $__env->startSection('title', 'Detalles del Evento'); ?>
<?php $__env->startSection('metadades'); ?>'Mira los detalles sobre el evento <?php echo e($esdeveniment->nom); ?> y adquiere sus entradas.'<?php $__env->stopSection(); ?>
<?php $__env->startSection('metaimages'); ?>'<?php $__currentLoopData = $esdeveniment->imatge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $imatge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo e(Storage::url('public/images/' . $imatge->imatge)); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>'<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="containerEvent">

        <div class="infoEvent">
            <h1><?php echo e($event->nom); ?></h1>
            <h4><?php echo e($event->descripcio); ?></h4>
        </div>
        <div class="textEvent">
            <form action="<?php echo e(route('detallesLocal', ['id' => $esdeveniment->id])); ?>" method="get"
                class="detallesLocal espacioEventos" id="detallesLocal">
                <p><strong>Local:</strong> <?php echo e($esdeveniment->lloc); ?></p>
                <button type="submit" class="btn btn-blue">Ver Local</button>
            </form>

            <form action="<?php echo e(route('confirmacioCompra')); ?>" method="post" class="ComprarEntrada espacioEventos"
                id="ComprarEntrada" enctype="multipart/form-data" style="justify-self: normal">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="nameEvent" name='nameEvent' value='<?php echo e($esdeveniment->nom); ?>'>
                <input type="hidden" id="idEvent" name='idEvent' value='<?php echo e($esdeveniment->id); ?>'>
                <?php if(count($fechas) == 1): ?>
                    <?php $__currentLoopData = $fechas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fecha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label for="session" class="form-label espacioEventos" id="fechaSesion"><strong>Sesiones:</strong>
                            <?php echo e($fecha->data); ?></label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $fechaSola = true;
                    ?>
                <?php else: ?>
                    <div class="espacioEventos">
                        <label for="session" class="form-label" id="fechaSesion"><strong>Sesiones:</strong></label>
                        <button id="buttonSesion" class="btn btn-blue" style="display: none;">Cambiar sesión</button>
                    </div>
                    <div id="calendar"></div>
                <?php endif; ?>
                <div id="estado" class="msg-error" style="display:none">
                    <p>Session cerrada</p>
                </div>

                <div class="form-group espacioEventos" id="entradas" style="display:none;">
                    <label id="preu" class="form-label">Escoge el tipo de entrada:</label>
                    <?php $__currentLoopData = $fechas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fecha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <select class="tiposTickets" id="<?php echo e($fecha->id); ?>" name="preu" style="display:none;">
                            <option value="" disabled selected>Entradas</option>
                            <?php $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($entrada->sessios_id == $fecha->id): ?>
                                    <option
                                        value="<?php echo e($entrada->preu); ?>,<?php echo e($entrada->quantitat); ?>,<?php echo e($entrada->nom); ?>,<?php echo e($entrada->id); ?>,<?php echo e($entrada->nominal); ?>">
                                        <?php echo e($entrada->nom); ?> <?php echo e($entrada->preu); ?>€ </option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    


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
            <?php $__currentLoopData = $esdeveniment->imatge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $imatge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img class="mySlides" src="<?php echo e(Storage::url('public/images/' . $imatge->imatge)); ?>"
                    alt="Imatge de l'esdeveniment">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <button class="btn btn-blue left-button" onclick="plusDivs(-1)">&#10094;</button>
            <button class="btn btn-blue right-button" onclick="plusDivs(+1)">&#10095;</button>
        </div>
    </div>
    <div class="opinion-cards">
        <?php $__currentLoopData = $opiniones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opinion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="opinion-card">
                <div class="opinion-content">
                    <p>Nombre: <?php echo e($opinion->nom); ?></p>
                    <p>Valoración: <?php echo $opinion->emocio; ?></p>
                    <p>Puntuación: <?php echo $opinion->estrellas; ?></p>
                    <p>Titulo: <?php echo e($opinion->titol); ?></p>
                    <p>Comentario: <?php echo e($opinion->comentari); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/esdeveniment.js')); ?>"></script>
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
        const fechasSessiones = <?php echo json_encode($fechas, 15, 512) ?>;
        const entradaPrecio = <?php echo json_encode($entradas, 15, 512) ?>;
        const fechaSola = <?php echo json_encode($fechaSola, 15, 512) ?>;

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/esdeveniment.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Crear Opinión'); ?>
<?php $__env->startSection('metadades','Añade tu opinión sobre el evento para que los demás sepan que tal te ha ido.'); ?>

<?php $__env->startSection('content'); ?>
    <div id="content-container">
        <form method="post" action="<?php echo e(route('crearOpinion.store')); ?>" class="addEvent" id="addOpinion"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="event-id" value="<?php echo e($id); ?>">

            <div class="form-group">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" maxlength="50" id="nombre" name="nombre" class="form-controller" required>
                <div id="errorDivnombre" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-nombre"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="valoracion" class="form-label">Qué te ha parecido</label>
                <div class="emoji-selector">
                    <span class="emoji-option" onclick="selectEmoji('😠')">😠</span>
                    <span class="emoji-option" onclick="selectEmoji('😞')">😞</span>
                    <span class="emoji-option" onclick="selectEmoji('😐')">😐</span>
                    <span class="emoji-option" onclick="selectEmoji('😊')">😊</span>
                    <span class="emoji-option" onclick="selectEmoji('😃')">😃</span>
                    <input type="hidden" name="valoracion" id="emojiValue">
                </div>
                <div id="errorDivvaloracion" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-valoracion"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="puntuacion">Puntuación:</label>
                <div class="star-rating">
                    <span class="star" data-rating="1">&#9733;</span>
                    <span class="star" data-rating="2">&#9733;</span>
                    <span class="star" data-rating="3">&#9733;</span>
                    <span class="star" data-rating="4">&#9733;</span>
                    <span class="star" data-rating="5">&#9733;</span>
                    <input type="hidden" name="puntuacion" id="ratingValue">
                </div>
                <div id="errorDivpuntuacion" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-puntuacion"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="titulo" class="form-label">Título del Comentario</label>
                <input type="text" maxlength="50" id="titulo" name="titulo" class="form-controller" required>
                <div id="errorDivtitulo" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-titulo"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea type="textarea" maxlength="640" id="comentario" name="comentario" class="form-controller" rows="3"
                    required></textarea>
                <div id="errorDivcomentario" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-comentario"></div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-blue" id="validarYGuardar">Guardar Opinión</button>
        </form>
    </div>
    <script>
        function selectEmoji(value) {
            const emojis = document.querySelectorAll('.emoji-option');
            emojis.forEach(emoji => {
                if (emoji.innerHTML === value) {
                    emoji.classList.add('selected');
                } else {
                    emoji.classList.remove('selected');
                }
            });

            document.getElementById('emojiValue').value = value;
        }
        document.addEventListener('DOMContentLoaded', function() {
            var stars = document.querySelectorAll('.star');
            var ratingValue = document.getElementById('ratingValue');

            stars.forEach(function(star, index) {
                star.addEventListener('click', function() {
                    var rating = index + 1; // La posición de la estrella más 1 es la puntuación
                    ratingValue.value = rating;

                    // Remueve la clase 'selected' de todas las estrellas
                    stars.forEach(function(s) {
                        s.classList.remove('selected');
                    });

                    // Resalta las estrellas seleccionadas y anteriores
                    for (var i = 0; i <= index; i++) {
                        stars[i].classList.add('selected');
                    }
                });

                star.addEventListener('mouseover', function() {
                    var rating = this.getAttribute('data-rating');
                    stars.forEach(function(s) {
                        if (s.getAttribute('data-rating') <= rating) {
                            s.classList.add('hover');
                        } else {
                            s.classList.remove('hover');
                        }
                    });
                });

                star.addEventListener('mouseout', function() {
                    stars.forEach(function(s) {
                        s.classList.remove('hover');
                    });
                });
            });

            function validarCampos() {
                var nombre = document.getElementById('nombre').value.trim();
                var emojiValue = document.getElementById('emojiValue').value.trim();
                var ratingValue = document.getElementById('ratingValue').value.trim();
                var titulo = document.getElementById('titulo').value.trim();
                var comentario = document.getElementById('comentario').value.trim();

                if (nombre === '') {
                    mostrarMissatge('nombre', 'Debes introducir un nombre para enviar la opinion.');
                    return false;
                } else {
                    ocultarMissatge('nombre');
                }

                if (nombre.length > 50) {
                    mostrarMissatge('nombre', 'El nombre no puede tener más de 50 caracteres.');
                    return false;
                } else {
                    ocultarMissatge('nombre');
                }

                if (emojiValue === '') {
                    mostrarMissatge('valoracion', 'Debes seleccionar un emoji para enviar la opinión.');
                    return false;
                } else {
                    ocultarMissatge('valoracion');
                }

                if (ratingValue === '') {
                    mostrarMissatge('puntuacion',
                        'Debes seleccionar una puntuación con estrellas para enviar la opinión.');
                    return false;
                } else {
                    ocultarMissatge('puntuacion');
                }

                if (titulo === '') {
                    mostrarMissatge('titulo', 'El titulo de la opinion es un campo obligatorio.');
                    return false;
                } else {
                    ocultarMissatge('titulo');
                }

                if (titulo.length > 50) {
                    mostrarMissatge('titulo', 'El titulo de la opinión no puede tener más de 50 caracteres');
                    return false;
                } else {
                    ocultarMissatge('titulo');
                }

                if (comentario === '') {
                    mostrarMissatge('comentario', 'El comentario de la opinión no puede quedar vacío.');
                    return false;
                } else {
                    ocultarMissatge('comentario');
                }

                if (comentario.length > 640) {
                    mostrarMissatge('comentario',
                        'El comentario de la opinión debe tener un máximo de 640 caracteres.');
                    return false;
                } else {
                    ocultarMissatge('comentario');
                }

                return true;

            }

            validarYGuardar.addEventListener('click', function() {
                if (validarCampos()) {
                    document.getElementById('addOpinion').submit();
                }
            });

            function mostrarMissatge(campo, missatge) {
                // Mostrar el mensaje de error junto al campo correspondiente
                var errorDiv = document.getElementById('errorDiv' + campo);
                var errorContent = document.getElementById('errorContent');
                var errorCampo = document.getElementById('error-' + campo);
                var errorMessage = document.getElementById('error-message');

                errorCampo.innerHTML = missatge;
                errorDiv.style.display = 'block';
            }

            function ocultarMissatge(campo) {
                var errorDiv = document.getElementById('errorDiv' + campo);
                errorDiv.style.display = 'none';
            }

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/crearOpinion.blade.php ENDPATH**/ ?>
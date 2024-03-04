<?php $__env->startSection('title', 'crear'); ?>
<?php $__env->startSection('metadades', 'Crea un evento nuevo.'); ?>

<?php $__env->startSection('content'); ?>
    <div id="content-container">
        <form action="<?php echo e(route('crear-esdeveniment.store')); ?>" method="post" class="addEvent" id="addEvent"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="user_id" id="user_id" value="<?php echo e(session('user_id')); ?>">

            <div class="form-group">
                <label for="titol" class="form-label">Título del evento</label>
                <input type="text" maxlength="20" class="form-controller" id="titol" name="titol"
                    value="<?php echo e(old('titol')); ?>" required>
            </div>

            <div class="form-group">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('categoria') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->tipus); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group <?php if(count($recintes) === 0): ?> d-none <?php endif; ?>">
                <label for="recinte" class="form-label">Recinto</label>
                <select class="form-select" id="recinteSelect" name="recinte">
                    <?php if(count($recintes) === 0): ?>
                        <option value="" selected disabled>No hay recintos disponibles</option>
                    <?php else: ?>
                        <option value="">Selecciona un recinto existente</option>
                        <?php $__currentLoopData = $recintes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recinte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($recinte->id); ?>" <?php echo e(old('recinte') == $recinte->id ? 'selected' : ''); ?>>
                                <?php echo e($recinte->nom); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>

            <?php if(session('error')): ?>
                <div class="alertDiv">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <div class="form-group">
                <a href="<?php echo e(route('crear-recinte')); ?>" id="mostrarNovaAdreca" class="btn btn-blue">Añadir nueva
                    dirección</a>
            </div>

            <div class="form-group">
                <label for="imatge" class="form-label">Imagen principal del evento</label>
                <input type="file" class="form-controller" id="imatge" name="imatge[]" accept="image/*"
                    value="<?php echo e(old('imatge')); ?>" multiple required>
            </div>

            <div class="form-group">
                <label for="descripcio" class="form-label">Descripción del evento</label>
                <textarea type="textarea" class="form-controller" maxlength="640" id="descripcio" name="descripcio" rows="3"
                    required><?php echo e(old('descripcio')); ?></textarea>
            </div>

            <div class="form-group">
                <label for="data_hora" class="form-label">Fecha y hora de la celebración</label>
                <input type="datetime-local" class="form-controller" id="data_hora" name="data_hora"
                    value="<?php echo e(old('data_hora')); ?>" required>
            </div>

            <div class="form-group">
                <label for="aforament_maxim" class="form-label">Aforo máximo</label>
                <input type="number" class="form-controller" id="aforament_maxim" name="aforament_maxim"
                    value="<?php echo e(old('aforament_maxim')); ?>" required>
            </div>

            <!-- Tipos de Entradas -->
            <div class="form-group">
                <h2>Tipos de Entradas</h2>
                <div id="tiposEntradas">
                    <!-- Contenido dinámico para los tipos de entradas -->
                </div>
                <div class="button-container">
                    <button type="button" class="btn btn-blue" id="agregarTipoEntrada">Agregar Tipo de Entrada</button>
                    <button type="button" class="btn btn-red" id="eliminarTipoEntrada" style="display: none;">Eliminar Entrada</button>
                </div>
            </div>

            <div class="form-group">
                <label for="tancamentVenda" class="form-label">Fecha de cierre de ventas</label>
                <select id="tancamentVenda" class="form-select" name="tancamentVenda">
                    <option value="esdeveniment" <?php echo e(old('tancamentVenda') == 'esdeveniment' ? 'selected' : ''); ?>>
                        Inicio de la celebración
                    </option>
                    <option value="1hora" <?php echo e(old('tancamentVenda') == '1hora' ? 'selected' : ''); ?>>
                        1 hora antes
                    </option>
                    <option value="2hores" <?php echo e(old('tancamentVenda') == '2hores' ? 'selected' : ''); ?>>
                        2 horas antes
                    </option>
                    <option value="personalitzat" <?php echo e(old('tancamentVenda') == 'personalitzat' ? 'selected' : ''); ?>>
                        Personalizado (escogemos fecha y hora)
                    </option>
                </select>

                <div id="personalitzatTancament" style="display: none;">
                    <label for="dataHoraPersonalitzada" class="form-label">Fecha y hora del cierre</label>
                    <input type="datetime-local" class="form-controller" id="dataHoraPersonalitzada"
                        name="dataHoraPersonalitzada" value="<?php echo e(old('dataHoraPersonalitzada')); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="ocultarEsdeveniment" class="form-label">Evento Oculto</label>
                <input type="checkbox" id="ocultarEsdeveniment" name="ocultarEsdeveniment"
                    <?php if(old('ocultarEsdeveniment')): ?> checked <?php endif; ?>>
            </div>

            <button type="button" class="btn btn-blue" id="validarYCrear">Crear Evento</button>

        </form>
    </div>
    <script>
        let recinteSelect = document.getElementById('recinteSelect');
        let tiposEntradas = document.getElementById('tiposEntradas');
        let agregarTipoEntrada = document.getElementById('agregarTipoEntrada');
        let tancamentVendaSelect = document.getElementById('tancamentVenda');
        let personalitzatTancamentDiv = document.getElementById('personalitzatTancament');
        let dataHoraPersonalitzadaInput = document.getElementById('dataHoraPersonalitzada');
        let dataHoraEsdevenimentInput = document.getElementById('data_hora');
        let titol = document.getElementById('titol');
        let nousCamps = document.getElementById('nousCamps');
        let imatgeInput = document.getElementById('imatge');
        let descripcionInput = document.getElementById('descripcio');
        let fechaHoraInput = document.getElementById('data_hora');
        let aforoInput = document.getElementById('aforament_maxim');

        function establirValorPerDefecte() {
            var tancamentValue = tancamentVendaSelect.value;

            if (tancamentValue === 'personalitzat') {
                personalitzatTancamentDiv.style.display = 'block';
            } else {
                personalitzatTancamentDiv.style.display = 'none';

                if (tancamentValue === '1hora' || tancamentValue === '2hores') {
                    // Calcula la data de tancament ajustant-hi les hores segons l'opció seleccionada
                    var dataEsdeveniment = new Date(dataHoraEsdevenimentInput.value);
                    var horesAbans = (tancamentValue === '1hora') ? 1 : 2;
                    var dataTancament = new Date(dataEsdeveniment.getTime() - (horesAbans - 1) * 60 * 60 *
                        1000);

                    // Formateja la data de tancament com a string per a l'input datetime-local
                    var dataTancamentString = dataTancament.toISOString().slice(0, -8);
                    dataHoraPersonalitzadaInput.value = dataTancamentString;
                } else {
                    // Assigna la data de tancament en base a la selecció
                    dataHoraPersonalitzadaInput.value = dataHoraEsdevenimentInput.value;
                }
            }
        }
        // Funció per validar la data de tancament
        function validarDataTancament() {
            var dataEsdeveniment = new Date(dataHoraEsdevenimentInput.value);
            var dataTancament = new Date(dataHoraPersonalitzadaInput.value);

            // Comprova si la data de tancament és anterior o igual a la data de l'esdeveniment
            return dataTancament <= dataEsdeveniment;
        }

        function validarCamposVacios() {
            if (document.querySelectorAll(".ticket-error").length > 0) {
                document.querySelectorAll(".ticket-error").forEach(element => {
                    element.remove();
                });
            }

            if (titol.value === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                titol.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El título del evento es un campo obligatorio.`;
                DivEntrada.appendChild(entradaP);
            } else if (titol.length > 20) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                titol.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El título del evento no puede tener más de 20 caracteres.`;
                DivEntrada.appendChild(entradaP);
            }

            if (imatgeInput.files.length === 0) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                imatgeInput.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `Debe seleccionar una imagen para el evento.`;
                DivEntrada.appendChild(entradaP);
            } else if (imatgeInput.files.length > 0) {
                var allowedTypes = ['image/jpeg', 'image/png', 'image/bmp', 'image/webp',
                    'image/jpg'
                ]; // Tipos de archivo permitidos
                var selectedFileType = imatgeInput.files[0].type;

                // Verificar si el tipo de archivo está permitido
                if (allowedTypes.indexOf(selectedFileType) === -1) {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    imatgeInput.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent =
                        `El archivo seleccionado no es una imagen válida. Por favor, elige un archivo JPEG, PNG, BMP o WebP.`;
                    DivEntrada.appendChild(entradaP);
                    // Limpiar el campo de imatge
                    imatgeInput.value = '';
                }
            }

            if (descripcionInput.value === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                descripcionInput.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `La descripción del evento no puede estar vacía.`;
                DivEntrada.appendChild(entradaP);
            } else if (descripcionInput.length > 640) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                descripcionInput.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `La descripción del evento debe tener un máximo de 640 caracteres.`;
                DivEntrada.appendChild(entradaP);
            }

            if (fechaHoraInput.value === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                fechaHoraInput.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El campo de fecha y hora de la celebración no puede estar vacío.`;
                DivEntrada.appendChild(entradaP);
            }

            var fechaHoraActual = new Date();
            // Obtener la fecha y hora del evento
            var fechaHoraEvento = new Date(dataHoraEsdevenimentInput.value);

            // Verificar que la fecha del evento no sea anterior a la fecha y hora actual
            if (fechaHoraEvento < fechaHoraActual) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                dataHoraEsdevenimentInput.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent =
                    `La fecha y hora de inicio del evento no puede ser anterior a la fecha y hora actual.`;
                DivEntrada.appendChild(entradaP);
            }

            if (aforoInput.value === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                aforoInput.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El campo de aforo máximo no puede estar vacío.`;
                DivEntrada.appendChild(entradaP);
            } else if (isNaN(aforoInput.value)) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                aforoInput.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El valor del aforo máximo debe ser numérico.`;
                DivEntrada.appendChild(entradaP);
            } else if (parseInt(aforoInput.value) < 1) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                aforoInput.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El aforo debe ser de almenos 1 persona.`;
                DivEntrada.appendChild(entradaP);
            }
            // Obtener la lista de entradas
            var entradas = document.querySelectorAll('.tipo-entrada');
            var butonElement = document.querySelector('#validarYCrear');

            // Verificar que haya al menos una entrada
            if (entradas.length === 0) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                butonElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `Debe agregar al menos una entrada antes de crear el evento.`;
                DivEntrada.appendChild(entradaP);
            }

            const nombre = document.querySelectorAll("#entradesNom");
            const preu = document.querySelectorAll("#entradesPreu");
            const quantitat = document.querySelectorAll("#entradesQuantitat");

            nombre.forEach(element => {
                if (element.value === '') {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    element.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent = `El nombre del tipo de entrada no puede estar vacío.`;
                    DivEntrada.appendChild(entradaP);
                } else if (element.value.length > 20) {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    element.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent =
                        `El nombre del tipo de entrada debe tener máximo 20 caracteres.`;
                    DivEntrada.appendChild(entradaP);
                }

            });

            preu.forEach(element => {
                if (element.value === '' || isNaN(element.value) || parseFloat(element.value) <=
                    0) {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    element.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent = `El precio debe ser un valor numérico mayor que 0.`;
                    DivEntrada.appendChild(entradaP);
                } else if (parseFloat(element.value) > 1000) {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    element.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent = `El precio no puede ser superior a 1.000.€`;
                    DivEntrada.appendChild(entradaP);
                }
            });

            quantitat.forEach(element => {
                if (element.value === '' || isNaN(element.value) || parseInt(element.value) <=
                    0) {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    element.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent =
                        `La cantidad disponible debe ser un valor numérico mayor que 0.`;
                    DivEntrada.appendChild(entradaP);
                }
            });

            if (tancamentVendaSelect.value === 'personalitzat' && personalitzatTancamentDiv.style.display !==
                'none') {
                if (dataHoraPersonalitzadaInput.value === '') {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    dataHoraPersonalitzadaInput.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent = `La fecha y hora personalizada no puede estar vacía.`;
                    DivEntrada.appendChild(entradaP);
                }

                var fechaHoraActual = new Date();
                // Obtener la fecha y hora del evento
                var fechaHoraCierre = new Date(dataHoraPersonalitzadaInput.value);

                // Verificar que la fecha del evento no sea anterior a la fecha y hora actual
                if (fechaHoraCierre < fechaHoraActual) {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    dataHoraPersonalitzadaInput.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent =
                        `La fecha y hora de cierre de ventas del evento no puede ser anterior a la fecha y hora actual.`;
                    DivEntrada.appendChild(entradaP);
                }
            }

            if (!validarDataTancament()) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                dataHoraPersonalitzadaInput.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent =
                    `La fecha de cierre de ventas debe ser anterior o igual a la fecha de inicio.`;
                DivEntrada.appendChild(entradaP);
            }

            if (document.querySelectorAll(".ticket-error").length > 0) {
                return false;
            } else {
                return true;
            }
        }

        function verificarQuantitats() {
            var entradas = document.querySelectorAll('.tipo-entrada');
            var aforamentMaxim = parseInt(document.getElementById('aforament_maxim').value);
            var totalQuantitats = 0;

            for (var i = 0; i < entradas.length; i++) {
                var entrada = entradas[i];
                var quantitatInput = entrada.querySelector('[name="entrades-quantitat[]"]');
                var quantitat = parseInt(quantitatInput.value);

                // Assigna l'aforament màxim si el camp quantitat està buit
                if (isNaN(quantitat) || quantitat <= 0) {
                    quantitatInput.value = aforamentMaxim;
                    quantitat = aforamentMaxim;
                }

                totalQuantitats += quantitat;

                // Verifica que la quantitat no superi la capacitat total del local
                if (quantitat > aforamentMaxim) {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    quantitatInput.insertAdjacentElement("afterend", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent =
                        `La cantidad disponible para este tipo de entrada no puede superar la capacidad total del local.`;
                    DivEntrada.appendChild(entradaP);
                    return false;
                }
            }

            // Verifica que el total de quantitats disponibles no superi l'aforament màxim
            if (totalQuantitats > aforamentMaxim) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                quantitatInput.insertAdjacentElement("afterend", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent =
                    `La suma total de cantidades de entradas disponibles no puede superar el aforo máximo.`;
                DivEntrada.appendChild(entradaP);
                return false; // Evitar l'enviament del formulari
            }

            // Si tot està bé, permet l'enviament del formulari
            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            agregarTipoEntrada.addEventListener('click', function() {
                var nuevoTipoEntrada = document.createElement('div');
                var index = document.querySelectorAll('.tipo-entrada').length + 1;

                nuevoTipoEntrada.innerHTML = `
                    <div class="tipo-entrada">
                        <label for="entrades-nom" class="form-label">Nombre del Tipo</label>
                        <input type="text" maxlength="20" class="form-controller" id="entradesNom" name="entrades-nom[]" required>

                        <label for="entrades-preu" class="form-label">Precio</label>
                        <input type="text" class="form-controller" id="entradesPreu" name="entrades-preu[]" required>

                        <label for="entrades-quantitat" class="form-label">Cantidad disponible</label>
                        <input type="number" class="form-controller" id="entradesQuantitat" name="entrades-quantitat[]" required>

                        <label for="entradaNominal" class="form-label">Entradas Nominales</label>
                        <input type="hidden" value="False" name="entradaNominalCheck[]" id="entradaNominalCheck">
                        <input type="checkbox" id="entradaNominal" name="entradaNominal[]"
                            <?php if(old('entradaNominal')): ?> checked <?php endif; ?>>
                        </div>
                    </div>`;

                tiposEntradas.appendChild(nuevoTipoEntrada);

                // Mostrar el botón de eliminar si hay al menos un tipo de entrada
                var eliminarTipoEntradaButton = document.getElementById('eliminarTipoEntrada');
                eliminarTipoEntradaButton.style.display = 'block';

                document.querySelectorAll('#entradaNominal').forEach(element => {
                    element.addEventListener('click', function(e) {
                        let parent = element.parentNode;
                        if (element.checked) {
                            parent.querySelector('#entradaNominalCheck').value = 'True';
                        } else {
                            parent.querySelector('#entradaNominalCheck').value = 'False';
                        }
                    })
                });
            });


            // Eliminar Último Tipo de Entrada
            eliminarTipoEntrada.addEventListener('click', function() {
                // Obtener el contenedor de tipos de entrada
                var tiposEntradasContainer = document.getElementById('tiposEntradas');

                // Obtener la lista de tipos de entrada
                var tiposEntradas = tiposEntradasContainer.querySelectorAll('.tipo-entrada');
                var eliminarElement = document.querySelector('#entradesQuantitat');

                // Verificar que haya al menos un tipo de entrada para eliminar
                if (tiposEntradas.length > 1) {
                    // Obtener el último tipo de entrada
                    var ultimoTipoEntrada = tiposEntradas[tiposEntradas.length - 1];

                    // Eliminar el último tipo de entrada
                    ultimoTipoEntrada.parentNode.removeChild(ultimoTipoEntrada);
                }

                // Ocultar el botón de eliminar si no hay más tipos de entrada
                if (tiposEntradas.length <= 1) {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    eliminarElement.insertAdjacentElement("afterend", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent = `Debe haber al menos un tipo de entrada.`;
                    DivEntrada.appendChild(entradaP);
                }
            });

            tancamentVendaSelect.addEventListener('change', establirValorPerDefecte);



            validarYCrear.addEventListener('click', function() {
                establirValorPerDefecte();

                if (validarCamposVacios()) {
                    // Realitzar les validacions addicionals
                    if (verificarQuantitats()) {
                        // Si tot està bé, enviar el formulari
                        document.getElementById('addEvent').submit();
                    }

                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/crearEsdeveniment.blade.php ENDPATH**/ ?>
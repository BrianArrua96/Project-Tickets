<?php $__env->startSection('title', 'crear'); ?>
<?php $__env->startSection('metadades', 'Añade un nuevo local a la base de datos para poder añadirla al momento de crear tu evento.'); ?>


<?php $__env->startSection('content'); ?>
    <div id="content-container">
        <form action="<?php echo e(route('recinte-nou')); ?>" method="GET" id="nousCamps" class="addEvent" style="display: block;">
            <div class="form-group">
                <label for="nova_nom" class="form-label">Nombre del Local</label>
                <input type="text" maxlength="50" class="form-controller" id="nova_nom" name="nova_nom" value="<?php echo e(old('nova_nom')); ?>">
            </div>

            <div class="form-group">
                <label for="nova_provincia" class="form-label">Provincia</label>
                <input type="text" maxlength="50" class="form-controller" id="nova_provincia" name="nova_provincia"
                    value="<?php echo e(old('nova_provincia')); ?>">
            </div>

            <div class="form-group">
                <label for="nova_ciutat" class="form-label">Ciudad</label>
                <input type="text" maxlength="50" class="form-controller" id="nova_ciutat" name="nova_ciutat"
                    value="<?php echo e(old('nova_ciutat')); ?>">
            </div>

            <div class="form-group">
                <label for="nova_carrer" class="form-label">Nombre de la calle</label>
                <input type="text" class="form-controller" id="nova_carrer" name="nova_carrer"
                    value="<?php echo e(old('nova_carrer')); ?>">
            </div>

            <div class="form-group">
                <label for="nova_numero" class="form-label">Número de la calle</label>
                <input type="number" class="form-controller" id="nova_numero" name="nova_numero"
                    value="<?php echo e(old('nova_numero')); ?>">
            </div>

            <div class="form-group">
                <label for="nova_codi_postal" class="form-label">Codigo Postal</label>
                <input type="number" min="0" max="99999" class="form-controller" id="nova_codi_postal" name="nova_codi_postal"
                    value="<?php echo e(old('nova_codi_postal')); ?>">
            </div>

            <div class="form-group">
                <label for="nova_capacitat" class="form-label">Aforo</label>
                <input type="number" min="1" class="form-controller" id="nova_capacitat" name="nova_capacitat"
                    value="<?php echo e(old('nova_capacitat')); ?>">
            </div>

            <input type="hidden" name="nova_user_id" value="<?php echo e(session('user_id')); ?>">
            <button type="submit" id="addAddress" class="btn btn-blue">Añadir nueva dirección</button>

        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function validarCamposVacios() {
            if (document.querySelectorAll(".ticket-error").length > 0) {
                document.querySelectorAll(".ticket-error").forEach(element => {
                    element.remove();
                });
            }
            let esError = true;
            var novaNom = document.getElementById('nova_nom').value.trim();
            var novaProvincia = document.getElementById('nova_provincia').value.trim();
            var novaCiutat = document.getElementById('nova_ciutat').value.trim();
            var novaCarrer = document.getElementById('nova_carrer').value.trim();
            var novaNumero = document.getElementById('nova_numero').value.trim();
            var novaCodiPostal = document.getElementById('nova_codi_postal').value.trim();
            var novaCapacitat = document.getElementById('nova_capacitat').value.trim();
            var nomElement = document.getElementById('nova_nom');
            var provinciaElement = document.getElementById('nova_provincia');
            var ciutatElement = document.getElementById('nova_ciutat');
            var carrerElement = document.getElementById('nova_carrer');
            var numeroElement = document.getElementById('nova_numero');
            var codiPostalElement = document.getElementById('nova_codi_postal');
            var capacitatElement = document.getElementById('nova_capacitat');

            // Validar que la capacidad sea numérica
            if (isNaN(novaCapacitat)) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                capacitatElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El aforo debe ser un valor numérico.`;
                DivEntrada.appendChild(entradaP);
            } else if (novaCapacitat === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                capacitatElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `Debes indicar la capacidad del recinto.`;
                DivEntrada.appendChild(entradaP);
            }

            if (novaNom === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                nomElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `Introduce el nombre del local.`;
                DivEntrada.appendChild(entradaP);
            } else if (novaNom.length > 50) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                nomElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El nombre del local no puede tener más de 50 caracteres.`;
                DivEntrada.appendChild(entradaP);
            }

            if (novaProvincia === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                provinciaElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `Debes incluir la provincia del recinto.`;
                DivEntrada.appendChild(entradaP);
            } else if (novaProvincia.length > 50){
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                provinciaElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `La provincia no puede tener más de 50 caracteres`;
                DivEntrada.appendChild(entradaP);
            }

            if (novaCiutat === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                ciutatElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `Debes introducir la ciudad del recinto.`;
                DivEntrada.appendChild(entradaP);
            } else if (novaCiutat.length > 50){
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                ciutatElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `La ciudad no puede tener más de 50 caracteres`;
                DivEntrada.appendChild(entradaP);
            }

            if (novaCarrer === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                carrerElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `Debes introducir la calle del recinto.`;
                DivEntrada.appendChild(entradaP);
            } else if (novaCarrer.length > 50) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                carrerElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `La calle no puede tener más de 50 caracteres`;
                DivEntrada.appendChild(entradaP);
            }

            if (novaNumero === '') {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                numeroElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `Debes introducir el numero de la calle del recinto.`;
                DivEntrada.appendChild(entradaP);
            } else if (isNaN(novaCapacitat)) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                numeroElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El numero de calle debe ser un valor numérico.`;
                DivEntrada.appendChild(entradaP);
            }

            // Validar que el código postal tenga el formato adecuado (5 dígitos)
            var codiPostalRegExp = /^\d{5}$/;
            if (!codiPostalRegExp.test(novaCodiPostal)) {
                const DivEntrada = document.createElement("div");
                DivEntrada.classList.add("ticket-error");
                codiPostalElement.insertAdjacentElement("beforebegin", DivEntrada);
                let entradaP = document.createElement("p");
                entradaP.textContent = `El código postal debe tener 5 dígitos.`;
                DivEntrada.appendChild(entradaP);
            }
            if (document.querySelectorAll(".ticket-error").length > 0) {
                return false;
            } else {
                return true;
            }
        }
        document.querySelector('#addAddress').addEventListener('click', function(e) {
            e.preventDefault();
            if (validarCamposVacios()) {
                document.getElementById('nousCamps').submit();
            }
        })
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/crearRecinte.blade.php ENDPATH**/ ?>
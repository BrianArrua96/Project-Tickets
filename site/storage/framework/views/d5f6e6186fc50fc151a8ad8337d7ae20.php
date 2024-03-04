<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('metadades', 'Entra en ShowTickt para poder comprar tickets a los mejores eventos disponibles.'); ?>

<?php $__env->startSection('content'); ?>
    <?php if($events->isEmpty()): ?>
        <div class="center-message">
            <p class="info-alert">No se ha encontrado ningún evento.</p>
        </div>
    <?php else: ?>
        <div class="container">
            <form action="<?php echo e(route('cerca')); ?>" method="get" class="form form-filtre" id="filtre">
                <div class="input-group">
                    <select name="category" class="form-control" onchange="this.form.submit()">
                        <option value="" disabled selected>Categorías</option>
                        <option value="" <?php echo e($categoryId === null ? 'selected' : ''); ?>>Mostrar todos</option>
                        <?php $__currentLoopData = $categoriesWithEventCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e($categoryId == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->tipus); ?> (<?php echo e($category->eventCount); ?> eventos)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <form action="<?php echo e(route('cerca')); ?>" method="get" class="form form-cerca" id="cerca">
                <div class="input-group">
                    <!-- Campo de entrada oculto para la categoría -->
                    <input type="hidden" name="category" value="<?php echo e($categoryId); ?>" >
                    <input type="text" name="q" class="form-control" placeholder="Buscar">
                    <button type="submit" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" height="16"
                            width="16"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path fill="#1e91d9"
                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                        </svg></button>
                </div>
            </form>
            <form id="promotores" class="form form-promotores" method="POST"
                action="<?php if(session('key')): ?> <?php echo e(route('homePromotor')); ?>

            <?php else: ?><?php echo e(route('login')); ?> <?php endif; ?>">
                <?php echo csrf_field(); ?>
                <input class="btn btn-orange" type="submit" value="PROMOTORES">
            </form>
        </div>
        <?php if(isset($compra)): ?>
            <?php if($compra == true): ?>
                <div class="ticket-verdad" id="valorTicket">
                    <p>Entrada comprada con Exito</p>
                </div>
            <?php else: ?>
                <div class="ticket-error" id="valorTicket">
                    <p>Hubo un fallo al comprar la entrada</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>



        <?php $__currentLoopData = $categoriesWith3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="event-home">
                <h2><?php echo e($category->tipus); ?></h2>
                <?php
                    $cont = 0;
                ?>
                <?php $__currentLoopData = $esdeveniments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $esdeveniment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($esdeveniment->categoria_id == $category->id && $cont < 3): ?>
                        <?php
                            $cont++;
                        ?>
                        <a href="<?php echo e(route('mostrar-esdeveniment', ['id' => $esdeveniment->id])); ?>" class="event-link">
                            
                            <?php echo $__env->make('components.event-card', ['esdeveniment' => $esdeveniment], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <form action="<?php echo e(route('cerca')); ?>" method="get" class="event-form">
                    <div class="event-group">
                        <input type="hidden" name="category" value="<?php echo e($category->id); ?>">
                        <button type="submit" class="event-btn">ver mas ></button>
                    </div>
                </form>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        setTimeout(function() {
            document.getElementById("valorTicket").style.display ="none";
        }, 5000);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/home.blade.php ENDPATH**/ ?>
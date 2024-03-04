<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>

        <div class="bg">
            <?php if(session('key')): ?>
                <div class="button-container">
                    <a href="<?php echo e(route('administrar-esdeveniments')); ?>" class="btn btn-blue">Administrar Eventos</a>
                    <a href="<?php echo e(route('llistat-sessions' )); ?>" class="btn btn-blue">Listado de sesiones</a>
                    <a href="<?php echo e(route('crear-esdeveniment')); ?>" class="btn btn-blue">Crear Evento</a>
                    <a href="<?php echo e(route('crear-esdeveniment')); ?>" class="btn btn-blue">Descargar validacion de tickets</a>
                </div>
            <?php endif; ?>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/homePromotor.blade.php ENDPATH**/ ?>
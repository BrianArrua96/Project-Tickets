<?php $__env->startSection('title', 'resultados'); ?>
<?php $__env->startSection('metadades', 'Administra todos los eventos que hayas creados, modificalos, eliminalos, ponlos en oculto o públicalos.'); ?>

<?php $__env->startSection('content'); ?>
    <?php if($esdeveniments->isEmpty()): ?>
        <div class="center-message">
            <p class="info-alert">No se ha encontrado ningún evento.</p>
        </div>
    <?php else: ?>
        <div class="info-message">
            <p class="info-text">Haz clic sobre un evento para poder editarlo.</p>
        </div>

        <div class="event-cards">
            <?php $__currentLoopData = $esdeveniments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $esdeveniment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('editar-esdeveniment', ['id' => $esdeveniment->id])); ?>" class="event-link">
                    
                    <?php echo $__env->make('components.event-card', ['esdeveniment' => $esdeveniment], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="pages"><?php echo e($esdeveniments->links('pagination::bootstrap-5')); ?></div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/administrarEsdeveniments.blade.php ENDPATH**/ ?>
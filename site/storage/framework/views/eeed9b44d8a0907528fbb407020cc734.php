

<?php $__env->startSection('title', 'Tauler'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-page">
    <?php if(session('key')): ?>
        <p>Tauller d'administració</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/taullerAdministracio.blade.php ENDPATH**/ ?>
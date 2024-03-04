<?php $__env->startSection('title', 'perfil'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-page">
  <?php if(session('key')): ?>
      <p>Bienvenido, <?php echo e(session('key')); ?></p>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/perfil.blade.php ENDPATH**/ ?>
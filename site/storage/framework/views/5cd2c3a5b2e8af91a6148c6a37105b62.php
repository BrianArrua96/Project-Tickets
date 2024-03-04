

<?php $__env->startSection('title', 'compra aceptada'); ?>
<?php $__env->startSection('content'); ?>

    <div class="login">
        <div class="login-div">
            <div class="login-form">
                <h2>Compra realizada con exito</h1>
                <h5>Revise su correo Electronico</h5>
            </div>
        </div>
    </div>
    <form action="<?php echo e(route('home')); ?>" id="vueltaAtras">
        <?php echo csrf_field(); ?>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        setTimeout(function() {
            do cument.getElementById("vueltaAtras").submit();
        }, 30000);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/finalCompra.blade.php ENDPATH**/ ?>
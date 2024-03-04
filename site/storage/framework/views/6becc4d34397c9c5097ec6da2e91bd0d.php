<?php $__env->startSection('title', 'Recuperar'); ?>
<?php $__env->startSection('metadades','Reccupera tu cuenta con tan solo poner tu email.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="login">
        <div class="login-div">
            <?php if($errors->has('error')): ?>
                <span class="msg-error"><?php echo e($errors->first('error')); ?></span>
            <?php endif; ?>
            <h2>Contraseña Olvidada</h2>
            <span id="indicador">Escriba la cuenta a recuperar.</span> <br> <br>
            <form action="<?php echo e(route('recuperar-form')); ?>" method="post" id="recuperarForm">
                <?php echo csrf_field(); ?>
                <div class="login-input">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-red" id="atras">Atrás</a>
                    <input type="submit" value="Enviar" class="btn btn-orange">
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/recuperar.blade.php ENDPATH**/ ?>
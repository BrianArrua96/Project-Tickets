<?php $__env->startSection('title', 'Login'); ?>
<?php $__env->startSection('metadades', 'Inicia sesión en tu cuenta para poder crear eventos nuevos o modificar los existentes.'); ?>


<?php $__env->startSection('content'); ?>
    <div class="login">
        <div class="login-div">
            <?php if($errors->has('error')): ?>
                <span class="msg-error"><?php echo e($errors->first('error')); ?></span>
            <?php elseif($errors->has('vali')): ?>
                <span class="msg-valido"><?php echo e($errors->first('vali')); ?></span>
            <?php endif; ?>
            <h2>Login</h2>
            <form action="<?php echo e(route('iniciarSesion')); ?>" method="post" id="loginForm" class="login-form">
                <?php echo csrf_field(); ?>
                <div class="login-input">
                    <label for="usuario" class="form-label">Nombre de usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Contraseña" required>
                    <a href="recuperar">Contraseña olvidada?</a>
                </div>
                <input type="submit" value="Acceder" class="btn btn-orange">
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/login.blade.php ENDPATH**/ ?>
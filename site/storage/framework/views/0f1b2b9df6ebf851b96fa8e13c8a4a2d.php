

<?php $__env->startSection('title', 'targeta'); ?>
<?php $__env->startSection('content'); ?>

    <div class="login">
      <div class="login-div">
          <h2>Forma de pago</h2>
          <form action="<?php echo e(route('finCompra')); ?>" method="post" class="login-form" id="ComprarEntrada">
            <?php echo csrf_field(); ?>
            <div class="login-input">
                <label>Tarjeta de credito</label>
                <input type="text" name="tarjetaCredito">
                <label>fecha de caducidad</label>
                <input type="text" name="fechaCaducidad" maxlength="5">
                <label>CVV</label>
                <input type="number" name="cvv" maxlength="3">
                
            </div>
            <button type="submit" id="buttonCompra" class="btn btn-orange">Acceder</button>
        </form>
        <form name="from" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1">
                <input type="hidden" name="Ds_MerchantParameters" value="<?php echo e($params); ?>">
                <input type="hidden" name="Ds_Signature" value="<?php echo e($signature); ?>">
          <button type="submit" id="bottonCompra" class="btn btn-blue" style="height: 32px;">redsys</button>
      </form>
      </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/targeta.blade.php ENDPATH**/ ?>
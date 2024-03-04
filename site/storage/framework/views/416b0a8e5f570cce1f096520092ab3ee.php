<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Confirmar compra</title>
</head>
<body>
  <form action="https://sis-t.redsys.es:25443/sis/realizarPago" method="post" id="redsys">
    <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1">
  <input type="hidden" name="Ds_MerchantParameters" value="<?php echo e($params); ?>"/>
  <input type="hidden" name="Ds_Signature" value="<?php echo e($signature); ?>"/>
  </form>
  <script>
    document.getElementById("redsys").submit();
  </script>
</body>
</html>
<?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/reenviodatos.blade.php ENDPATH**/ ?>
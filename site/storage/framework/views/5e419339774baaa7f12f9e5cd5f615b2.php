<style>
    body {
        margin: 0;
        font-family: "Nunito", sans-serif;
        display: flex;
        flex-direction: column;
    }

    .page-break {
        page-break-after: always;
    }

    .logo {
        width: 100px;
    }

    .titol-pdf {
        background-color: #000;
        color: #fff line-height: 40%;
    }

    .event-info {
        align-items: center;
    }

    .entrada-info {
        align-items: center;
    }

    .codi-qr {
        align-items: center;
    }
</style>

<body>
    <div>
        <br><br><br>
        <div class="event-info">
            <h2>Evento: <?php echo e($event->nom); ?></h2>
            <h5><?php echo e($event->descripcio); ?></h5>
            <h4>Fecha: <?php echo e($sessio); ?></h4>
            <h4>Ubicación: <?php echo e($lloc); ?></h4>
        </div>
    </div>
    <div class="page-break"></div>
    <?php
    $contador = 0;
    ?>
    <?php $__currentLoopData = $entrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <table>
        <tr>
            <td>
                <h3>Entrada: <?php echo e($entrada->nom); ?></h3>
                <?php if($entrada->nominal): ?>
                    <h5>Nombre Asistente: <?php echo e($entrada->nomComprador); ?></h5>
                <?php else: ?>
                    <h5>Nombre Comprador: <?php echo e($entrada->nomComprador); ?></h5>
                <?php endif; ?>
                <p>DNI/NIE: <?php echo e($entrada->dniComprador); ?></p>
                <p>Precio: <?php echo e($entrada->precio); ?>€</p>
            </td>
            <td>
                <h3>Código QR:</h3>
                <?php
                    $renderer = new \BaconQrCode\Renderer\ImageRenderer(new \BaconQrCode\Renderer\RendererStyle\RendererStyle(400), new \BaconQrCode\Renderer\Image\SvgImageBackEnd());
                    $writer = new \BaconQrCode\Writer($renderer);
                    $svgString = $writer->writeString($entrada->numeroIdentificador);
                    $tempFilePath = tempnam(sys_get_temp_dir(), 'qrcode') . '.svg';
                    file_put_contents($tempFilePath, $svgString);
                ?>
                <img src="<?php echo e($tempFilePath); ?>" alt="qrcode" height="100" width="100">
                <p><?php echo e($entrada->numeroIdentificador); ?></p>
            </td>
        </tr>
    </table>
    <?php
    $contador += 1;
    ?>
    <?php if(!(count($entrades)) == $contador): ?>
        <div class="page-break"></div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
<?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/pdfs/entradas.blade.php ENDPATH**/ ?>
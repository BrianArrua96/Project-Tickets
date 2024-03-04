<?php $__env->startSection('title', 'local'); ?>

<?php $__env->startSection('content'); ?>
    <div class="containerEvent">
        <div class="textEvent">
            <h1><?php echo e($esdeveniment->nom); ?></h1>
            <p><strong>Provincia:</strong><?php echo e($esdeveniment->provincia); ?></p>
            <p><strong>Lugar:</strong><?php echo e($esdeveniment->lloc); ?></p>
        </div>

    </div>
    <div class="mapaLocal">
      <?php if (isset($component)) { $__componentOriginal28e4e112271cfb1b754f610097af82da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal28e4e112271cfb1b754f610097af82da = $attributes; } ?>
<?php $component = Larswiegers\LaravelMaps\Components\Leaflet::resolve(['centerPoint' => ['lat' => $lat, 'long' => $long]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('maps-leaflet'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Larswiegers\LaravelMaps\Components\Leaflet::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'event-imagen']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal28e4e112271cfb1b754f610097af82da)): ?>
<?php $attributes = $__attributesOriginal28e4e112271cfb1b754f610097af82da; ?>
<?php unset($__attributesOriginal28e4e112271cfb1b754f610097af82da); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal28e4e112271cfb1b754f610097af82da)): ?>
<?php $component = $__componentOriginal28e4e112271cfb1b754f610097af82da; ?>
<?php unset($__componentOriginal28e4e112271cfb1b754f610097af82da); ?>
<?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/detallesLocal.blade.php ENDPATH**/ ?>
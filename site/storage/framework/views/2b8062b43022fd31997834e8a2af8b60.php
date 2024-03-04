<?php $__env->startSection('title', 'resultados'); ?>

<?php $__env->startSection('content'); ?>
    <?php if($sesiones->isEmpty()): ?>
        <div class="center-message">
            <p class="info-alert">No se ha encontrado ninguna sesión.</p>
        </div>
    <?php else: ?>
        <div class="event-cards">
            <?php $__currentLoopData = $sesiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sessio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="event-link">
                    <div class="event-card">
                        <div class="event-details">
                            <h1><?php echo e($sessio->esdeveniment->nom); ?></h1>
                            <h3><?php echo e($sessio->data); ?></h3>
                            <?php if($sessio->entrades->isNotEmpty()): ?>
                                <h2><?php echo e($sessio->entrades->sum('quantitat')); ?> entradas</h2>
                            <?php else: ?>
                                <h2>Sin entradas</h2>
                            <?php endif; ?>
                            <div class="buttons">
                                <!-- Botones -->
                                <a href="<?php echo e(route('detalls-esdeveniment', ['id' => $sessio->esdeveniment->id])); ?>"
                                    title="Mostrar detalles del evento">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                                        viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path
                                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                    </svg>
                                </a>
                                <a href="<?php echo e(route('administrar-esdeveniment', ['id' => $sessio->esdeveniment->id])); ?>"
                                    title="Administrar el evento">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path
                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                    </svg>
                                </a>
                                <a href="<?php echo e(route('llistats-entrades', ['id' => $sessio->id])); ?>"
                                    title="Ver listados de entradas">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path
                                            d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <img src="<?php echo e(Storage::url('public/images/' . $sessio->esdeveniment->imatge->first()->imatge)); ?>" alt="Imatge de l'esdeveniment" loading="lazy">
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="pages"><?php echo e($sesiones->links('pagination::bootstrap-5')); ?></div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/llistatSessions.blade.php ENDPATH**/ ?>
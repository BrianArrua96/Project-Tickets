<!-- resources/views/components/event-card.blade.php -->

<div class="event-card">
    <div class="event-details">
        <h1><?php echo e($esdeveniment->nom); ?></h1>
        <?php if($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->data !== null): ?>
            <h3><?php echo e($esdeveniment->sesions->first()->data); ?></h3>
        <?php else: ?>
            <h3>No hay sesiones</h3>
        <?php endif; ?>
        <h4><?php echo e($esdeveniment->recinte->lloc); ?></h4>
        <?php if($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->entrades->isNotEmpty()): ?>
            <h2><?php echo e($esdeveniment->sesions->first()->entrades->first()->preu); ?> €</h2>
        <?php else: ?>
            <h2>Entradas Agotadas</h2>
        <?php endif; ?>
    </div>
    <?php if($esdeveniment->imatge->isNotEmpty()): ?>
        <?php
        $imagePath = Storage::url('public/images/' . $esdeveniment->imatge->first()->imatge);
        $imageFullPath = storage_path('app/public/images/' . $esdeveniment->imatge->first()->imatge);
        $lastModified = filemtime($imageFullPath);
        $lastModifiedTime = gmdate('D, d M Y H:i:s', $lastModified) . ' GMT';
        $expirationTime = gmdate('D, d M Y H:i:s', strtotime('+2 months')) . ' GMT';
        
        // Configura les capçaleres de control de la memòria cau
        header("Last-Modified: $lastModifiedTime");
        header("Expires: $expirationTime");
        header('Cache-Control: public, max-age=15552000');
        
        
        ?>
        <img src="<?php echo e($imagePath); ?>" alt="Imatge de l'esdeveniment" loading="lazy"
            cache-control="public, max-age=15552000">
    <?php else: ?>
        <img src="https://via.placeholder.com/640x480.png/00dd22?text=imagenEvento" alt="Imatge de l'esdeveniment"
            loading="lazy">
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/components/event-card.blade.php ENDPATH**/ ?>
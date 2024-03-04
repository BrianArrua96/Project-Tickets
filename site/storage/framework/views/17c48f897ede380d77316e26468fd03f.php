<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $__env->yieldContent('metadades'); ?>">
    <meta name="image" content="<?php echo $__env->yieldContent('metaimages'); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('imagen/logo-definitivo.ico')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>

<body class="w3-content">
    <header>
        <a href="<?php echo e(route('home')); ?>"><img class="logo" alt="logoShowTickt"
                src="<?php echo e(asset('imagen/logo-definitivo.png')); ?>"></a>
        <h1 class="titulo">ShowTickt</h1>


        <?php if(session('key')): ?>
            <button id="openOpt" class="selOpt ahref"><?php echo e(session('key')); ?></button>
            <div id="opciones">
                <form action="<?php echo e(route('session')); ?>" method="get" id="form">
                    <button id="profile" class="optionProfile">Perfil</button>
                    <button id="sesion" class="optionProfile">Salir</button>
                    <input type="hidden" name="sesionOpcion" id="sesionOpcion">
                </form>
            </div>
        <?php else: ?>
            <form action="<?php echo e(route('session')); ?>" method="post" id="form">
                <?php echo csrf_field(); ?>
                <button id="iniciar" class="selOpt ahref">Iniciar Sesión</button>
                <input type="hidden" name="sesionOpcion" id="iniciarSesion" value="openSession">
            </form>
        <?php endif; ?>
    </header>
    <div class="masterBody">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <footer>
        <!-- Boton que redirige a la pagina home dentro del footer -->
        <a id="footerHome" href="<?php echo e(route('home')); ?>">HOME</a>
        <!-- Boton que redirige a la pagina home promotor dentro del footer -->
        <form method="POST"
            action="<?php if(session('key')): ?> <?php echo e(route('homePromotor')); ?>

    <?php else: ?><?php echo e(route('login')); ?> <?php endif; ?>">
            <?php echo csrf_field(); ?>
            <input class="ahref" type="submit" value="PROMOTORES">
        </form>

        <!-- Boton de compartir que redirige a la pagina de telegram -->
        <div class="footer-button">
            <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-share-url="http://127.0.0.1:8000"
                data-comment="Visita este enlace!" data-size="large"></script>
        </div>

        <!-- Boton de compartir que redirige a la pagina de twitter (X) -->
        <div class="footer-button"><a class="twitter-share-button"
                href="https://twitter.com/intent/tweet?text=Visita%20este%20enlace" data-size="large"
                data-text="Compartir"></a></div>
        <!-- Load Facebook SDK for JavaScript -->
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <!-- Your share button code -->
        <!-- Boton de compartir que redirige a la pagina de facebook -->
        <div class="footer-button">
            <div class="fb-share-button" data-href="http://127.0.0.1:8000" data-layout="button" data-size="large">
            </div>
        </div>
    </footer>
    <script>
        window.twttr = (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0],
                t = window.twttr || {};
            if (d.getElementById(id)) return t;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);

            t._e = [];
            t.ready = function(f) {
                t._e.push(f);
            };

            return t;
        }(document, "script", "twitter-wjs"));
    </script>
    <script>
        const options = document.getElementById('opciones');
        const profileOption = document.querySelector('#profile');
        const sessionOption = document.querySelector('#sesion');
        const form = document.querySelector('#form');
        const iniciar = document.querySelector('#iniciar');
        let hiddenInp = document.querySelector('#sesionOpcion');

        options.style.display = 'none';
        const button = document.querySelector('.selOpt');
        window.addEventListener('click', function(e) {
            if (button.contains(e.target)) {
                button.style.display = 'none';
                options.style.display = 'block';
            } else {
                button.style.display = 'block';
                options.style.display = 'none';
            }
        })
        profileOption.addEventListener('click', function(e) {
            e.preventDefault();
            hiddenInp.value = 'profile';
            form.submit();

        });
        sessionOption.addEventListener('click', function(e) {
            e.preventDefault();
            hiddenInp.value = 'closeSession';
            form.submit();
        });
        iniciar.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#iniciarSesion').value = 'openSession';
            form.submit();
        })
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/layouts/master.blade.php ENDPATH**/ ?>
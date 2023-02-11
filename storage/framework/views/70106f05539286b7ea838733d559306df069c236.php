<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php echo $__env->yieldPushContent('js'); ?>
<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/superhero/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-R/oa7KS0iDoHwdh4Gyl3/fU7pgvSCt7oyuQ79pkw+e+bMWD9dzJJa+Zqd+XJS0AD" crossorigin="anonymous">
    <link href="<?php echo e(asset('/css/fontello.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="<?php echo e(route('admin.home')); ?>"><?php echo e(config('app.name', 'Laravel')); ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav ml-auto">
                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                    </li>
                    <?php if(Route::has('register')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('super-admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.field.index')); ?>"><?php echo e(__('Category Fields')); ?></a>
                    </li>
                    <?php endif; ?>

                    <?php if(auth()->check() && auth()->user()->hasRole('organizer|super-admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.search.index')); ?>"><?php echo e(__('Aramalar')); ?></a>
                    </li>
                    <?php endif; ?>

                    <?php if(auth()->check() && auth()->user()->hasRole('organizer|super-admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.auctions.index')); ?>"><?php echo e(__('İlanlar')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.category.index')); ?>"><?php echo e(__('Categories')); ?></a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <?php echo e(__('Logout')); ?>

                            </a>

                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            
        </div>
    </nav>

    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
</body>
</html>
<?php /**PATH /home/mehmet/Desktop/GitProjects/nealiyorsan/resources/views/layouts/app.blade.php ENDPATH**/ ?>
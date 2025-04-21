<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name', '@Master Layout')); ?></title>

    <!-- q-read: Favicon -->
    <link rel="icon" href="<?php echo e(asset('assets/img/favicon.svg')); ?>" type="image/svg+xml" />
    
    <!-- <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.css')); ?>"> -->

    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/fontawesome_v6_7_1/css/all_z.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('assets/css/animate.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet">

    <!-- q-read: Custom css -->
    <link href="<?php echo e(asset('__custom.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body class="">
    <div id="wrapper">
        <?php echo $__env->make('layouts.partial.left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div id="page-wrapper" class="gray-bg">
            <?php echo $__env->make('layouts.partial.header', ['notification_count' => $notification_count ?? ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <?php echo $__env->yieldContent('content'); ?>
            </div>

            <?php echo $__env->make('layouts.partial.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <?php echo $__env->make('layouts.partial.right-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <!-- q-read: scripts -->
    
    <!-- <script src="<?php echo e(asset('assets/js/jquery-3.4.1.js')); ?>"></script> -->

    <!-- Mainly scripts -->
    <script src="<?php echo e(asset('assets/js/jquery-3.1.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/metisMenu/jquery.metisMenu.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js')); ?>"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo e(asset('assets/js/inspinia.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/pace/pace.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>

    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\ProjectManager\resources\views/layouts/master.blade.php ENDPATH**/ ?>
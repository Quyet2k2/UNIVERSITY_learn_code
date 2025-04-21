
<!-- q-read: title -->
<?php $__env->startSection('title', 'Error!'); ?>

<!-- q-read: content -->
<?php $__env->startSection('content'); ?>
    <?php
    $code = isset($code) ? $code : 404;
    $title = isset($title) ? $title : 'Page not found!';
    $message = isset($message) ? $message : 'Page does not exist.';
    ?>

    <div class="jumbotron">
        <div class="container">
            <h1><?php echo e($code); ?>, <?php echo e($title); ?></h1>
            <p><?php echo e($message); ?></p>

            

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/home/error.blade.php ENDPATH**/ ?>
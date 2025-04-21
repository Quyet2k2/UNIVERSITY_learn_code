
<?php $__env->startSection('title', 'Account Details'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default text-center">
                <div class="panel-body">
                    <!-- Avatar -->
                    <img src="<?php echo e($user->avatar_url); ?>" alt="Avatar"
                        class="img-circle profile-avatar img-responsive center-block">
                    <h2 class="profile-name"><?php echo e($user->name); ?></h2>
                    <p class="profile-role"><?php echo e(implode(', ', $user->getRoles->pluck('name')->toArray())); ?></p>
                </div>
            </div>

            <!-- Thông tin tài khoản -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Account Details</h3>
                </div>
                <div class="panel-body">
                    <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
                    <p><strong>Created At:</strong> <?php echo e(get_local_date_format($user->created_at)); ?></p>
                    <p><strong>Updated At:</strong> <?php echo e(get_local_date_format($user->updated_at)); ?></p>
                </div>

                <!-- Actions -->
                <div class="panel-footer text-center">
                    <div class="btn-group btn-group-responsive">
                        <a <?php echo Auth::user()->hasPermission('admin.users.edit') && (Auth::id() == $user->id || Auth::id() == 1)
                            ? ''
                            : "disabled onclick='return false;'"; ?> href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                            class="btn btn-warning">
                            <i class="fa fa-pencil"></i> Edit Account
                        </a>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .profile-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .profile-role {
            font-size: 16px;
            color: #777;
        }

        .inline-form {
            display: inline-block;
        }

        .btn-group-responsive {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/admin/users/show.blade.php ENDPATH**/ ?>
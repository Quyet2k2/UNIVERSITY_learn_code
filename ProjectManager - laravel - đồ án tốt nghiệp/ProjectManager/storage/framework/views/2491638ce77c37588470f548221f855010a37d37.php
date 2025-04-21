<?php $__env->startSection('title', 'Admin | Edit Role'); ?>

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

    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Edit Role</div>
        <div class="panel-body">
            <form action="<?php echo e(route('admin.roles.update', $model->id)); ?>" method="POST" role="form">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                <!-- q-read: Name Role -->
                <div class="form-group">
                    <label>Name role</label>
                    <!-- Được sửa role name khi: (có quyền update) và (không là các role mặc định) -->
                    <input <?php echo !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4) ? '' : 'readonly'; ?> type="text" class="form-control" name="name"
                        value="<?php echo e($model->name); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger mt-2 "><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- q-read: Permission List Label -->
                <label>Permission List</label>
                <div class="form-group" style="height: 300px; overflow-y: scroll">
                    <?php $__errorArgs = ['routes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger mt-2"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $isChecked = in_array($route, old('routes', $permissions)) ? 'checked' : ''; ?>
                        <div class="checkbox">
                            <label>
                                <!-- Được sửa role khi: (có quyền update) và (không là các role mặc định) -->
                                <input <?php echo !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4) ? '' : 'disabled'; ?> type="checkbox" name="routes[]" class="role-item"
                                    <?php echo e($isChecked); ?> value="<?php echo e($route); ?>">
                                <?php echo e($route); ?>

                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- q-read: Submit -->
                <div class="pull-left">
                    <!-- Có thể sửa role khi: (có quyền update) và (không là các role mặc định) -->
                    <button <?php echo Auth::user()->hasPermission('admin.roles.update') &&
                    !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4)
                        ? ''
                        : "disabled onclick='return false;'"; ?> type="submit" class="btn btn-primary">
                        <i class="fat fa-pen-to-square"></i>
                        Update</button>

                    <label>
                        <!-- Có thể checkAll role khi: (có quyền update) và (không là các role mặc định) -->
                        <input <?php echo !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4)
                            ? ''
                            : "disabled onclick='return false;'"; ?> type="checkbox" id="checkAll">
                        Check all
                    </label>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('#checkAll').click(function() {
                $('.role-item').prop('checked', this.checked);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/admin/roles/edit.blade.php ENDPATH**/ ?>
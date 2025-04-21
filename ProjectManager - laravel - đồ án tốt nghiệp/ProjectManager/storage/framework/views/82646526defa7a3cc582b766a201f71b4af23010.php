<?php $__env->startSection('title', 'Admin | Group Permission List'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>


    <div class="panel panel-primary">
        <div class="panel-heading">Group Permission List</div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Created At</th>
                    <th>Modified At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($model->id); ?></td>
                        <td><?php echo e($model->name); ?></td>
                        <td><?php echo e(get_local_date_format($model->created_at)); ?></td>
                        <td><?php echo e(get_local_date_format($model->updated_at)); ?></td>
                        <td>
                            
                            <a <?php echo Auth::user()->hasPermission('admin.roles.show') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('admin.roles.show', $model->id)); ?>"
                                class="btn btn-info btn-sm m-2">
                                <i class="far fa-eye"></i>
                                Show
                            </a>

                            
                            <a <?php echo Auth::user()->hasPermission('admin.roles.edit') &&
                            !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4)
                                ? ''
                                : "disabled onclick='return false;'"; ?> href="<?php echo e(route('admin.roles.edit', $model->id)); ?>"
                                class="btn btn-info btn-sm m-2 btn-warning">
                                <i class="fa fa-pencil"></i>
                                Edit Role
                            </a>

                            
                            <form style="display:inline-block" action="<?php echo e(route('admin.roles.destroy', $model->id)); ?>"
                                method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button <?php echo Auth::user()->hasPermission('admin.roles.destroy') &&
                                !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4)
                                    ? 'onclick="return confirm(\'Do you really want to delete this role?\')"'
                                    : "disabled onclick='return false;'"; ?> type="submit" class="btn btn-info btn-sm m-2 btn-danger">
                                    <i class="fa-sharp fa-solid fa-trash fa-fw"></i>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="panel-footer">
            <?php echo e($data->links('pagination::bootstrap-4')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/admin/roles/index.blade.php ENDPATH**/ ?>
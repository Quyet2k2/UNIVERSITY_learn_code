
<?php $__env->startSection('title', 'Task List'); ?>
<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="panel panel-primary">
        <div class="panel-heading text-center"><strong>Task List</strong></div>
        <div class="panel-body">
            
            <div class="row m-b-sm m-t-sm">
                
                <div class="col-sm-12 col-md-1 mb-2 mb-md-0">
                    <a href="<?php echo e(route('user.tasks.index')); ?>" class="btn btn-white btn-sm w-100">
                        <i class="fa fa-refresh"></i> Refresh
                    </a>
                </div>
                
                <div class="col-sm-12 col-md-11">
                    <form class="input-group" action="<?php echo e(route('user.tasks.index')); ?>" method="GET">
                        <input name="search_by_task_name" value="<?php echo e(request('search_by_task_name')); ?>" type="text"
                            placeholder="Search by Task Name" class="input-sm form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Go!</button>
                        </span>
                    </form>
                </div>
            </div>

            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Task Name</th>
                            <th>Assigned To</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Task Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <!-- q-read: project và project_manager_id -->
                            <?php
                                $project = get_project_by_id($task->project_id);
                                $project_manager_id = $project->project_manager_assigned_to;
                                // q-read: Đặt màu cho trạng thái task
                                $task_status_label = match ($task->status) {
                                    'Open' => 'label-primary',
                                    'Processing' => 'label-info',
                                    'Testing', 'PM' => 'label-warning',
                                    'Completed' => 'label-danger',
                                    default => 'label-default',
                                };
                            ?>
                            
                            <tr <?php echo Auth::user()->hasPermission('user.tasks.show') ? '' : "disabled onclick='return false;'"; ?>

                                onclick="window.location='<?php echo e(route('user.tasks.show', $task->id)); ?>'"
                                style="cursor: pointer;">
                                <td><?php echo e($task->id); ?></td>
                                <td>
                                    <?php echo e($task->name); ?>

                                </td>
                                <td>
                                    <?php echo e(get_user_by_id($task->assigned_to)->name ?? 'No User found!'); ?>

                                </td>
                                <td><?php echo e($task->start_time); ?></td>
                                <td><?php echo e($task->end_time); ?></td>
                                <td><span class="label <?php echo e($task_status_label); ?>"><?php echo e($task->status); ?></span></td>
                                <td>
                                    <!-- q-read: Được edit task khi: (có quyền edit) và (tài khoản đăng nhập phải là - (tài khoản được gán) hoặc (tài khoản project manager) hoặc (tài khoản super admin)) -->
                                    <a <?php echo Auth::user()->hasPermission('user.tasks.edit') &&
                                    (Auth::id() == $task->assigned_to || Auth::id() == $project_manager_id || Auth::id() == 1)
                                        ? ''
                                        : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.tasks.edit', $task->id)); ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa fa-pencil"></i> Edit Task
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No tasks found!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <div class="text-center"><?php echo e($tasks->appends(request()->query())->links('pagination::simple-bootstrap-4')); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/user/tasks/index.blade.php ENDPATH**/ ?>
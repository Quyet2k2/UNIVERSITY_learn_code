<?php
// q-read: Đặt màu cho trạng thái dự án
$project_status_label = '';
switch (set_project_status_by_tasks($project->id)) {
    case 'Open':
        $project_status_label = 'label-primary';
        break;
    case 'Processing':
        $project_status_label = 'label-info';
        break;
    case 'UAT':
        $project_status_label = 'label-warning';
        break;
    case 'Closed':
        $project_status_label = 'label-danger';
        break;
} ?>


<?php $__env->startSection('title', 'Project Details'); ?>
<?php $__env->startSection('content'); ?>
    <h1 class="text-center">Project Details</h1>

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

    <div class="ibox">
        <div class="ibox-title">
            <div class="pull-right">
                <!-- Được sửa project khi: (có quyền update) và ((là tài khoản project manager) hoặc (tài khoản super admin)) -->
                <a <?php echo Auth::user()->hasPermission('user.projects.edit') &&
                (Auth::id() == $project->project_manager_assigned_to || Auth::id() == 1)
                    ? ''
                    : "disabled onclick='return false;'"; ?> class=" btn btn-sm btn-warning m-2"
                    href="<?php echo e(route('user.projects.edit', $project->id)); ?>">
                    <i class="fa fa-pencil"></i>
                    Edit project
                </a>

                
                
            </div>

            <h2><?php echo e($project->name); ?></h2>
        </div>
        <div class="ibox-content">
            
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>Status:</dt>
                        <dd>
                            <span class="label <?php echo e($project_status_label); ?>">
                                <?php echo e(set_project_status_by_tasks($project->id) ?: 'No Status'); ?>

                            </span>
                        </dd>
                    </dl>
                </div>
            </div>

            
            <div class="row">
                <div class="col-lg-5">
                    <dl class="dl-horizontal">
                        <dt>Start Time:</dt>
                        <dd><?php echo e($project->start_time); ?></dd>
                        <dt>Project Manager:</dt>
                        <dd>
                            
                            <a <?php echo Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'"; ?>

                                href="<?php echo e(route('admin.users.show', $project->project_manager_assigned_to)); ?>">
                                <?php echo e($pm->name ?: 'No PM found!'); ?>

                            </a>
                        </dd>
                        <dt>Participants:</dt>
                        <dd class="project-people">
                            <?php $__currentLoopData = $usersOfProject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <a <?php echo Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('admin.users.show', $user->id)); ?>">
                                    <img alt="image" class="img-circle"
                                        src="<?php echo e($user?->avatar_url ?: asset('storage/default_images/default-avatar.jpg')); ?>"
                                        title="<?php echo e($user?->name ?: 'No User found!'); ?>">
                                    
                                </a>
                                <?php if(!$loop->last): ?>
                                    ,
                                <?php else: ?>
                                    .
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </dd>
                    </dl>
                </div>

                <div class="col-lg-7" id="cluster_info">
                    <dl class="dl-horizontal">
                        <dt> End Time:</dt>
                        <dd><?php echo e($project->end_time); ?></dd>
                        <dt>Last Updated:</dt>
                        <dd> <?php echo e(get_local_date_format($project->updated_at)); ?> </dd>
                        <dt>Created:</dt>
                        <dd> <?php echo e(get_local_date_format($project->created_at)); ?></dd>
                    </dl>
                </div>
            </div>

            
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>Completed:</dt>
                        <dd>
                            <div class="progress progress-striped active m-b-sm">
                                <div style="width: <?php echo e(project_calc_percent($project->id)); ?>%;" class="progress-bar"></div>
                            </div>
                            <small>Project completed in <strong><?php echo e(project_calc_percent($project->id)); ?>%</strong>.
                                Remaining close the project, sign a contract and invoice.
                            </small>
                        </dd>
                    </dl>
                </div>
            </div>

            
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal ">
                        <dt>Description:</dt>
                        <dd><?php echo e($project->description ?: 'No Description'); ?></dd>
                    </dl>
                </div>
            </div>

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">
                        
                        <a <?php echo Auth::user()->hasPermission('user.tasks.create') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.tasks.create', ['project_id' => $project->id])); ?>"
                            class="btn btn-primary btn-sm pull-right">
                            <i class="fa fa-plus"></i>
                            Add Task
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel blank-panel">

                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab">Tasks</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Title</th>
                                                    <th>End Time</th>
                                                    <th>Task KPI</th>
                                                    <th>Assigned To</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <?php
                                                        $project = get_project_by_id($task->project_id);
                                                        $project_manager_id = $project->project_manager_assigned_to;

                                                        // q-read: Đặt màu cho trạng thái task
                                                        $task_status_label = '';
                                                        switch ($task->status) {
                                                            case 'Open':
                                                                $task_status_label = 'label-primary';
                                                                break;
                                                            case 'Processing':
                                                                $task_status_label = 'label-info';
                                                                break;
                                                            case 'Testing':
                                                                $task_status_label = 'label-warning';
                                                                break;
                                                            case 'PM':
                                                                $task_status_label = 'label-warning';
                                                                break;
                                                            case 'Completed':
                                                                $task_status_label = 'label-danger';
                                                                break;
                                                        }
                                                    ?>

                                                    
                                                    <tr <?php echo Auth::user()->hasPermission('user.tasks.show') ? '' : "disabled onclick='return false;'"; ?>

                                                        onclick="window.location.href = '<?php echo e(route('user.tasks.show', $task->id)); ?>'"
                                                        style="cursor: pointer;">
                                                        <td>
                                                            <span class="label <?php echo e($task_status_label); ?>">
                                                                <i class="fa fa-check"></i>
                                                                <?php echo e(ucfirst($task->status ?: 'No Status')); ?>

                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php echo e($task->name ?: 'No Name'); ?>

                                                        </td>
                                                        <td> <?php echo e(get_local_date_format($task->end_time)); ?> </td>
                                                        <td>
                                                            <strong>
                                                                <?php echo e(rtrim(rtrim(number_format($task->bill, 2), '0'), '.')); ?>

                                                            </strong>
                                                        </td>
                                                        <td>
                                                            <p class="small">
                                                                <?php echo e(get_user_by_id($task->assigned_to)->name ?: 'No User found!'); ?>

                                                            </p>
                                                        </td>
                                                        <td>
                                                            <!-- Được edit task khi: (có quyền edit) và (tài khoản đăng nhập phải là - (tài khoản được gán) hoặc (tài khoản project manager) hoặc (tài khoản super admin)) -->
                                                            <a <?php echo Auth::user()->hasPermission('user.tasks.edit') &&
                                                            (Auth::id() == $task->assigned_to || Auth::id() == $project_manager_id || Auth::id() == 1)
                                                                ? ''
                                                                : "disabled onclick='return false;'"; ?>

                                                                href="<?php echo e(route('user.tasks.edit', $task->id)); ?>"
                                                                class="btn btn-warning btn-sm m-2">
                                                                <i class="fa fa-pencil"></i>
                                                                Edit Task
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="55" class="text-center">No Task Found!</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    
                                    <div class="text-center">
                                        <?php echo e($tasks->appends(request()->query())->links('pagination::simple-bootstrap-4')); ?>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager\resources\views/pages/user/projects/show.blade.php ENDPATH**/ ?>
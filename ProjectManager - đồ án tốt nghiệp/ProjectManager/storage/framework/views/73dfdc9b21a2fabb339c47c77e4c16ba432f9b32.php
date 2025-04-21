<?php
    $task_completed_percentage = task_calc_percent($task) ?? 0;
?>

<?php $__env->startSection('title', 'Task Details'); ?>
<?php $__env->startSection('content'); ?>
    <h1 class="text-center">Task Details</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="ibox">
        <div class="ibox-title">
            <h2><?php echo e($task->name); ?></h2>
        </div>
        <div class="ibox-content">

            
            <div class="row">
                <div class="col-md-12 text-right pb-3">
                    <!-- q-read: Được sửa Task khi: (có quyền update) && (tài khoản đăng nhập phải là tài khoản - (được gán) hoặc (tài khoản project manager) hoặc (tài khoản super admin)) -->
                    <a <?php echo Auth::user()->hasPermission('user.tasks.edit') &&
                    (Auth::id() == $task->assigned_to || Auth::id() == $project_manager_id || Auth::id() == 1)
                        ? ''
                        : "disabled onclick='return false;'"; ?> class="btn m-1 btn-warning" href="<?php echo e(route('user.tasks.edit', $task->id)); ?>">
                        <i class="fa fa-pencil"></i> Edit Task
                    </a>

                    
                    
                </div>
            </div>

            <!-- q-read: Status Task -->
            <div class="row">
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Status:</dt>
                        
                        <dd><span class="label <?php echo e($task_status_label); ?>"><?php echo e($task->status ?: 'No Status'); ?></span></dd>

                        <dt>First Completed At:</dt>
                        <dd><?php echo e($task->first_completed_at ?: 'Not Completed Yet'); ?></dd>

                        <dt>Start Time:</dt>
                        <dd><?php echo e($task->start_time); ?></dd>

                        <dt>End Time:</dt>
                        <dd><?php echo e($task->end_time); ?></dd>
                    </dl>
                </div>

                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Task KPI:</dt>
                        <dd><strong><?php echo e(rtrim(rtrim(number_format($task->bill, 2), '0'), '.')); ?></strong></dd>

                        <dt>Project:</dt>
                        <dd>
                            
                            <a <?php echo Auth::user()->hasPermission('user.projects.show') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.projects.show', $project->id)); ?>">
                                <?php echo e($project->name ?: 'No Project Name'); ?>

                            </a>
                        </dd>

                        <dt>Last Updated:</dt>
                        <dd><?php echo e(get_local_date_format($task->updated_at)); ?></dd>

                        <dt>Created:</dt>
                        <dd><?php echo e(get_local_date_format($task->created_at)); ?></dd>
                    </dl>
                </div>
            </div>

            <!-- q-read: assigned_to -->
            <div class="row">
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Assigned To:</dt>
                        <dd>
                            
                            <a <?php echo Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('admin.users.show', $task->assigned_to)); ?>">
                                <?php echo e(get_user_by_id($task->assigned_to)->name ?: 'No User found!'); ?>

                            </a>
                        </dd>

                        <dt>Project Manager:</dt>
                        <dd>
                            
                            <a <?php echo Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('admin.users.show', $project_manager_id)); ?>">
                                <?php echo e($project_manager->name ?: 'No User found!'); ?>

                            </a>
                        </dd>
                    </dl>
                </div>

                <!-- q-read: Completed -->
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Completed:</dt>
                        <dd>
                            <div class="progress progress-striped active m-b-xs">
                                <div style="width: <?php echo e(task_calc_percent($task)); ?>%;"
                                    class="progress-bar progress-bar-success"></div>
                            </div>
                            <small>Task completed in <strong><?php echo e(task_calc_percent($task)); ?>%</strong>.</small>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- q-read: Description -->
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>Description:</dt>
                        <dd><?php echo e($task->description ?: 'No Description'); ?></dd>
                    </dl>
                </div>
            </div>

            <!-- q-read: Được thêm Comment khi: (có quyền create) -->
            <div class="row">
                <div class="col-md-12 text-right">
                    <a <?php echo Auth::user()->hasPermission('user.comments.create') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.comments.create', ['task_id' => $task->id])); ?>"
                        class="btn btn-success btn-sm" style="margin-bottom: 10px;">
                        <i class="fa fa-plus"></i> Add Comment
                    </a>
                </div>
            </div>

            <!-- q-read: Comments -->
            <div class="panel blank-panel">
                <div class="panel-heading">
                    <div class="panel-options">
                        
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-comments" data-toggle="tab">Comments</a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-comments">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Content</th>
                                            <th>Attachment</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $commentsOfTask; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>
                                                    <a <?php echo Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'"; ?>

                                                        href="<?php echo e(route('admin.users.show', $comment->user_id)); ?>">
                                                        <?php echo e(get_user_by_id($comment->user_id)->name ?: 'No User found!'); ?>

                                                    </a>
                                                </td>
                                                <td style="white-space: pre-line; word-wrap: break-word; min-width: 300px;">
                                                    <?php echo e($comment->content ?: 'No Content'); ?></td>
                                                <td>
                                                    <?php if($comment->attachment): ?>
                                                        <a href="<?php echo e(asset('storage/' . $comment->attachment)); ?>"
                                                            class="btn btn-primary btn-sm" download target="_blank">
                                                            <i class="fa fa-download"></i> Download
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($comment->created_at->diffForHumans()); ?></td>
                                                <td>
                                                    <a <?php echo Auth::user()->hasPermission('user.comments.edit') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                                                        ? ''
                                                        : "disabled onclick='return false;'"; ?> class="btn btn-warning btn-sm"
                                                        href="<?php echo e(route('user.comments.edit', $comment->id)); ?>">
                                                        Edit Comment
                                                    </a>
                                                    <form action="<?php echo e(route('user.comments.destroy', $comment->id)); ?>"
                                                        method="POST" style="display:inline-block;">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button <?php echo Auth::user()->hasPermission('user.comments.destroy') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                                                            ? 'onclick="return confirm(\'Do you really want to delete this comment?\')"'
                                                            : "disabled onclick='return false;'"; ?> class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Delete Comment
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No Comments Found!</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/user/tasks/show.blade.php ENDPATH**/ ?>
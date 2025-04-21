
<?php $__env->startSection('title', 'Project List'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="text-center">Project List</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="ibox">
        <div class="ibox-title d-flex justify-content-between align-items-center flex-wrap">
            <h5>All projects assigned to this account</h5>
            <div class="ibox-tools mt-2 mt-md-0">
                <a <?php echo Auth::user()->hasPermission('user.projects.create') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.projects.create')); ?>" class="btn btn-primary btn-xs">
                    <i class="fa fa-plus"></i> Add Project
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row m-b-sm m-t-sm">
                <div class="col-sm-12 col-md-1 mb-2 mb-md-0">
                    <a href="<?php echo e(route('user.projects.index')); ?>" class="btn btn-white btn-sm w-100">
                        <i class="fa fa-refresh"></i> Refresh
                    </a>
                </div>
                <div class="col-sm-12 col-md-11">
                    <form class="input-group" action="<?php echo e(route('user.projects.index')); ?>" method="GET">
                        <input name="search_by_project_name" value="<?php echo e(request('search_by_project_name')); ?>" type="text"
                            placeholder="Search by Project Name" class="input-sm form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Go!</button>
                        </span>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                            $project_status_label = match (set_project_status_by_tasks($project->id)) {
                                'Open' => 'label-primary',
                                'Processing' => 'label-info',
                                'UAT' => 'label-warning',
                                'Closed' => 'label-danger',
                                default => '',
                            };
                            ?>

                            <tr class="project-row" <?php echo Auth::user()->hasPermission('user.projects.show')
                                ? "onclick='redirectToProject({$project->id})' style='cursor: pointer;'"
                                : "disabled onclick='return false;'"; ?>>

                                <td class="project-status">
                                    <span class="label <?php echo e($project_status_label); ?>">
                                        <?php echo e(set_project_status_by_tasks($project->id) ?: 'No Status'); ?>

                                    </span>
                                </td>

                                <td class="project-title">
                                    <strong style="font-size: 1.3rem;"><?php echo e($project->name); ?></strong> <br>
                                    <small>Created <?php echo e($project->created_at->diffForHumans()); ?></small>
                                </td>

                                <td class="project-completion" style="width: 20%; min-width: 150px;">
                                    <small>Completion: <?php echo e(project_calc_percent($project->id)); ?>%</small>
                                    <div class="progress progress-mini">
                                        <div class="progress-bar progress-bar-striped active"
                                            style="width: <?php echo e(project_calc_percent($project->id)); ?>%;">
                                        </div>
                                    </div>
                                </td>

                                <td class="project-people text-nowrap">
                                    <div class="text-success font-weight-bold">
                                        <i class="fa fa-calendar"></i> Start: <?php echo e($project->start_time); ?>

                                    </div>
                                    <div class="text-danger font-weight-bold">
                                        <i class="fa fa-calendar-times"></i> End: <?php echo e($project->end_time); ?>

                                    </div>
                                </td>

                                <td class="project-actions">
                                    <a <?php echo Auth::user()->hasPermission('user.projects.edit') &&
                                    (Auth::id() == 1 || Auth::id() == $project->project_manager_assigned_to)
                                        ? ''
                                        : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.projects.edit', $project->id)); ?>"
                                        class="btn btn-warning btn-sm m-2">
                                        <i class="fa fa-pencil"></i> Edit Project
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="55" class="text-center">No projects found!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <?php echo e($projects->appends(request()->query())->links('pagination::simple-bootstrap-4')); ?> </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function redirectToProject(projectId) {
            window.location.href = "<?php echo e(url('user/projects')); ?>/" + projectId;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager\resources\views/pages/user/projects/index.blade.php ENDPATH**/ ?>
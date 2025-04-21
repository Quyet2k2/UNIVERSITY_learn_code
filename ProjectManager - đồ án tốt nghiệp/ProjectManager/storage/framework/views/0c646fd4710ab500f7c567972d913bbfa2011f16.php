
<?php $__env->startSection('title', 'Employee KPI Reports'); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="text-center">Employee KPI Reports</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <!-- Search Form in Panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Filter Employee</strong>
        </div>
        <div class="panel-body">
            <form method="GET" action="<?php echo e(route('user.reports.index')); ?>">
                <div class="row">
                    <div class="mt-3 col-sm-3">
                        <label for="user_id" class="control-label">Select Employee:</label>
                    </div>
                    <div class="mt-3 col-sm-7">
                        <select name="user_id" id="user_id" class="form-control input-sm">
                            <option value="" disabled selected>-- All --</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mt-3 col-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- KPI Report Table in Panel -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <strong>KPI Report</strong>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Total KPI</th>
                            <th>Total Tasks</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($report->assignedUser->id); ?></td>
                                <td><?php echo e($report->assignedUser->name); ?></td>
                                <td><?php echo e(number_format($report->total_kpi, 2)); ?></td>
                                <td><?php echo e($report->total_tasks); ?></td>
                                <td>
                                    <a href="<?php echo e(route('user.reports.user', $report->assigned_to)); ?>"
                                        class="btn btn-info btn-xs">
                                        View KPI Details
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <div class="text-center"><?php echo e($reports->appends(request()->query())->links('pagination::simple-bootstrap-4')); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/select2/select2.full.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#user_id').select2({
                placeholder: 'Select an Employee',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('assets/css/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/user/reports/index.blade.php ENDPATH**/ ?>
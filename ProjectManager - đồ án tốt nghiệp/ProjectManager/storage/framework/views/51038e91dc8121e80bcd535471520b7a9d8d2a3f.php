
<?php $__env->startSection('title', "KPI Report for {$user->name}"); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">KPI Report for "<?php echo e($user->name); ?>"</h3>
        </div>
        <div class="panel-body">
            <!-- Filter Form -->
            <form method="GET" action="<?php echo e(route('user.reports.user', $user->id)); ?>" class="mb-3">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="month">Month:</label>
                        <select name="month" id="month" class="form-control input-sm">
                            <option value="">-- Select Month --</option> 
                            <?php for($m = 1; $m <= 12; $m++): ?>
                                <option value="<?php echo e($m); ?>" <?php echo e(request('month') == $m ? 'selected' : ''); ?>>
                                    Month <?php echo e($m); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="year">Year:</label>
                        <select name="year" id="year" class="form-control input-sm">
                            <option value="">-- Select Year --</option> 
                            
                            
                            <?php for($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                <option value="<?php echo e($y); ?>" <?php echo e(request('year') == $y ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 25px;">Filter</button>
                        <a href="<?php echo e(route('user.reports.user', $user->id)); ?>" class="btn btn-default btn-sm"
                            style="margin-top: 25px;">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">KPI and Task List</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Task</th>
                            <th>Completion Date</th>
                            <th>KPI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="active">
                                <td colspan="3"><strong><?php echo e($r->period); ?></strong></td>
                                <td><strong><?php echo e(number_format($r->total_kpi, 2)); ?></strong></td>
                            </tr>
                            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <?php if(date('Y-m', strtotime($task->first_completed_at)) == $r->period): ?>
                                    <?php $hasTask = true; ?>
                                    <tr>
                                        <td></td>
                                        <td><a href="<?php echo e(route('user.tasks.show', $task->id)); ?>"><?php echo e($task->name); ?></a>
                                        </td>
                                        <td><?php echo e(date('d-m-Y', strtotime($task->first_completed_at))); ?></td>
                                        <td><?php echo e(number_format($task->bill, 2)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center">Không có task nào!</td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td colspan="4"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/select2/select2.full.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#month').select2({
                allowClear: true,
                width: '100%',
                placeholder: '-- Select Month --'
            });

            $('#year').select2({
                allowClear: true,
                width: '100%',
                placeholder: '-- Select Year --'
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('assets/css/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/user/reports/user.blade.php ENDPATH**/ ?>
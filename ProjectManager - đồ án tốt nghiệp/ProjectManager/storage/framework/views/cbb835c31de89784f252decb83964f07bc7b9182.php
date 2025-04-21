
<?php $__env->startSection('title', 'Employee KPI Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="jumbotron text-center">
        <h2>Employee KPI Reports</h2>
        <p><?php echo e($quoteOfTheDay); ?></p>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="thumbnail text-center">
                <h1>User: <?php echo e($user->name); ?></h1>
            </div>
        </div>
    </div>

    <!-- Bộ lọc nhân viên -->
    <div class="well">
        <form method="GET" action="<?php echo e(route('user.dashboard')); ?>">
            <?php $__currentLoopData = request()->except('search'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <label for="user_id">Select Employee:</label>
            <select name="user_id" id="user_id" class="form-control">
                <option value="" disabled selected></option>
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($employee->id); ?>" <?php echo e($selectedUser == $employee->id ? 'selected' : ''); ?>>
                        <?php echo e($employee->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="btn btn-primary btn-block mt-2">Search</button>
        </form>
    </div>

    <!-- Thống kê KPI cá nhân -->
    <?php if($selectedUser != 1): ?>
        <div class="row">
            <div class="col-sm-4">
                <div class="thumbnail text-center">
                    <h3>Total KPI Last Month</h3>
                    <p><?php echo e($kpiData['total_kpi']); ?></p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumbnail text-center">
                    <h3>Total Tasks Last Month</h3>
                    <p><?php echo e($kpiData['total_tasks']); ?></p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumbnail text-center">
                    <h3>Performance Score Last Month</h3>
                    <p><?php echo e($kpiData['performance_score']); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Xếp hạng KPI -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">🏆 Top Employees KPI (All Time)</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total KPI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $rankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($employee->id == $selectedUser ? 'success' : ''); ?>">
                                <td><?php echo e($employee->rank); ?></td>
                                <td><?php echo e($employee->name); ?></td>
                                <td><?php echo e(round($employee->total_kpi, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                
                
                <?php echo e($rankings->appends(request()->query())->links('pagination::simple-bootstrap-4')); ?>

            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">📅 Top Employees KPI (This Month)</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total KPI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $monthlyRankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($employee->id == $selectedUser ? 'success' : ''); ?>">
                                <td><?php echo e($employee->rank); ?></td>
                                <td><?php echo e($employee->name); ?></td>
                                <td><?php echo e(round($employee->total_kpi, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                
                
                <?php echo e($monthlyRankings->appends(request()->query())->links('pagination::simple-bootstrap-4')); ?>

            </div>
        </div>
    </div>

    <?php if($selectedUser != 1): ?>
        <div class="alert alert-info text-center">
            <h4>📊 Your Rank: #<?php echo e($userRank); ?> (All Time) | #<?php echo e($userMonthlyRank); ?> (This Month)</h4>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/toastr/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/select2/select2.full.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 10000
                };
                toastr.success("<?php echo e($quoteOfTheDay); ?>", 'Daily Motivation');
            }, 1300);

            $('#user_id').select2({
                placeholder: 'Select a User',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('assets/css/plugins/toastr/toastr.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/home/dashboard.blade.php ENDPATH**/ ?>
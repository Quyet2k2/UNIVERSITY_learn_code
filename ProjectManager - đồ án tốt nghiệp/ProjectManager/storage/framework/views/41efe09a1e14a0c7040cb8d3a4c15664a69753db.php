
<?php $__env->startSection('title', 'Add Task'); ?>
<?php $__env->startSection('content'); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-center">Add Task</h3>
        </div>
        <div class="panel-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <form action="<?php echo e(route('user.tasks.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <!-- q-read: Task Name -->
                        <label for="name">Task Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name')); ?>"
                            required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-sm-6 form-group">
                        <!-- q-read: Select Project -->
                        <label for="project_id" class="form-label">Select Project</label>
                        <select <?php echo e(Auth::id() == 1 ? '' : 'disabled'); ?> id="project_id" class="form-control"
                            name="project_id" required>
                            <option value="" disabled selected> </option>
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    <?php echo e(old('project_id') == $project->id || $project_id == $project->id ? 'selected' : ''); ?>

                                    value="<?php echo e($project->id); ?>"> <?php echo e($project->name); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <?php if(Auth::id() != 1): ?>
                        <input type="hidden" name="project_id" value="<?php echo e(old('project_id', $project_id)); ?>" />
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <!-- q-read: assigned_to -->
                        <label for="assigned_to">Assigned To</label>
                        <select name="assigned_to" id="assigned_to" class="form-control" required>
                            <option value="" disabled selected> </option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"
                                    <?php echo e(old('assigned_to') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['assigned_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-sm-6 form-group">
                        <!-- q-read: Task Bill -->
                        <label for="bill">Task Bill (KPI)</label>
                        <input type="number" step="0.01" value="<?php echo e(old('bill')); ?>" name="bill" id="bill"
                            class="form-control" required>
                        <?php $__errorArgs = ['bill'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 form-group">
                        <!-- q-read: description -->
                        <label for="description">Task Description:</label>
                        <textarea name="description" id="description" class="form-control" rows="5"><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <!-- q-read: start time -->
                        <label for="start_time">Start Time:</label>
                        <input type="datetime-local" name="start_time" id="start_time" class="form-control"
                            value="<?php echo e(old('start_time')); ?>">
                        <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-sm-6 form-group">
                        <!-- q-read: end time -->
                        <label for="end_time">End Time:</label>
                        <input type="datetime-local" name="end_time" id="end_time" class="form-control"
                            value="<?php echo e(old('end_time')); ?>">
                        <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- q-read: Submit -->
                <div class="form-group text-center">
                    
                    <button <?php echo Auth::user()->hasPermission('user.tasks.store') ? '' : "disabled onclick='return false;'"; ?> type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save
                    </button>

                    
                    <a <?php echo Auth::user()->hasPermission('user.projects.show')
                        ? "onclick=\"return confirm('Do you really want to view this project?')\""
                        : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.projects.show', $project_id)); ?>" class="btn btn-info">
                        <i class="fa fa-info-circle"></i> Project Details
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/select2/select2.full.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#project_id').select2({
                placeholder: 'Select a Project',
                allowClear: true,
                width: '100%'
            });

            $('#assigned_to').select2({
                placeholder: 'Select a User',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('assets/css/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/user/tasks/create.blade.php ENDPATH**/ ?>
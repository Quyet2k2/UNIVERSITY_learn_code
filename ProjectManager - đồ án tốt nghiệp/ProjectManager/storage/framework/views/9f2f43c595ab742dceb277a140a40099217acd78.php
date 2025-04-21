

<?php $__env->startSection('title', 'Edit Comment'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 class="text-center">Edit Comment</h2>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="panel panel-primary">
                <div class="panel-heading">Comment Details</div>
                <div class="panel-body">
                    <form action="<?php echo e(route('user.comments.update', $comment->id)); ?>" enctype="multipart/form-data"
                        method="POST">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                        <!-- q-read: content -->
                        <div class="form-group">
                            <label for="content">Content of comment:</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required><?php echo e(old('content', $comment->content)); ?></textarea>
                            <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- q-read: File Attachment (Hiển thị tệp cũ nếu có) -->
                        <?php if($comment->attachment): ?>
                            <div class="form-group">
                                <label>Current Attachment:</label>
                                <div>
                                    <a href="<?php echo e(asset('storage/' . $comment->attachment)); ?>" download target="_blank"
                                        class="btn btn-info btn-sm">Download</a>
                                    <p class="help-block">Click above to view or download the current file.</p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- q-read: Chọn tệp mới để thay thế (nếu có) -->
                        <div class="form-group">
                            <label for="attachment">Attach a new file (optional):</label>
                            <input type="file" name="attachment" id="attachment" class="form-control">
                            <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group text-center">
                            <!-- q-read: Được update comment khi: (có quyền update) và (tài khoản đăng nhập phải là tài khoản người dùng) hoặc (tài khoản đăng nhập phải tài khoản super admin) -->
                            <button <?php echo Auth::user()->hasPermission('user.comments.update') && ($comment->user_id == Auth::id() || Auth::id() == 1)
                                ? ''
                                : "disabled onclick='return false;'"; ?> type="submit" class="btn btn-warning">
                                <i class="fat fa-pen-to-square"></i> Update
                            </button>

                            <!-- Được xem task khi: (có quyền xem) -->
                            <a <?php echo Auth::user()->hasPermission('user.tasks.show')
                                ? "onclick=\"return confirm('Do you really want to view this task?')\""
                                : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.tasks.show', $comment->task_id)); ?>"
                                class="btn btn-info">
                                <i class="fa fa-info-circle"></i> View Task Details
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/user/comments/edit.blade.php ENDPATH**/ ?>
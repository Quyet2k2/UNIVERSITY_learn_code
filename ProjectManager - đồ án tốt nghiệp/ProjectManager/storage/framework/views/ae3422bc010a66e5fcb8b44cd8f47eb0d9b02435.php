

<?php $__env->startSection('title', 'Add Comment'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12">
            <h2 class="text-center">
                Add Comment for Task: <br>
                <strong><?php echo e($task->name); ?></strong>
            </h2>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Comment Details</h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo e(route('user.comments.store', $task->id)); ?>" enctype="multipart/form-data"
                        method="POST">
                        <?php echo csrf_field(); ?>

                        <!-- Nội dung bình luận -->
                        <div class="form-group">
                            <label for="content">Content of Comment:</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required><?php echo e(old('content')); ?></textarea>
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

                        <!-- Tải file đính kèm -->
                        <div class="form-group">
                            <label for="attachment">Attachment (Optional):</label>
                            <input type="file" name="attachment" id="attachment" class="form-control">
                            <small class="text-muted">Allowed: .docx, .txt, .pdf, images</small>
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
                            <!-- Xem trước ảnh (nếu có) -->
                            <img id="preview-img" class="img-thumbnail hidden" style="max-width: 150px; margin-top: 10px;">
                        </div>

                        <!-- ID Task -->
                        <input type="hidden" name="task_id" value="<?php echo e($task->id); ?>">

                        <!-- Nút lưu (Chỉ hiển thị nếu có quyền) -->
                        <div class="text-center">
                            <button <?php echo Auth::user()->hasPermission('user.comments.store') ? '' : "disabled onclick='return false;'"; ?> type="submit" class="btn btn-success">
                                <i class="fa fa-floppy-disk"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Nếu không có quyền, hiển thị thông báo -->
            <?php if(!Auth::user()->hasPermission('user.comments.store')): ?>
                <div class="alert alert-warning text-center">
                    <strong>Warning:</strong> You do not have permission to add comments.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .panel-body {
                padding: 15px;
            }

            textarea {
                font-size: 14px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.getElementById('attachment').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('preview-img').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('preview-img').classList.add('hidden');
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/user/comments/create.blade.php ENDPATH**/ ?>
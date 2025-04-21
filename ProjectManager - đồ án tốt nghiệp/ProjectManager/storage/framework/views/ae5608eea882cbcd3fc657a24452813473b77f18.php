

<?php $__env->startSection('title', 'Comments of Task'); ?>

<?php $__env->startSection('content'); ?>
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

    <div class="panel panel-primary">
        <div class="panel-heading"><strong>Comments List</strong></div>
        <div class="panel-body">

            
            <div class="row m-b-sm m-t-sm px-3">
                
                <div class="col-md-1 m-b-sm">
                    <a href="<?php echo e(route('user.comments.index')); ?>" class="btn btn-white btn-sm">
                        <i class="fa fa-refresh"></i>
                        Refresh
                    </a>
                </div>
                
                <div class="col-md-11 m-b-sm">
                    <form class="input-group" action="<?php echo e(route('user.comments.index')); ?>" method="GET">
                        <input name="search_by_comment_content" value="<?php echo e(request('search_by_comment_content')); ?>"
                            type="text" placeholder="Search by Comment Content" class="input-sm form-control">

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Go!</button>
                        </span>
                    </form>
                </div>
            </div>

            
            <div class="table-responsive m-t-md">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Comment Content</th>
                            <th>Attachment</th>
                            <th>Comment Time</th>
                            <th>Comment User</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                
                                <td><?php echo e($comment->id); ?></td>
                                
                                <td style="white-space: pre-line; word-wrap: break-word;">
                                    <?php echo e($comment->content); ?></td>
                                
                                <td>
                                    <!-- Hiển thị tệp đính kèm nếu có -->
                                    <?php if($comment->attachment): ?>
                                        <a href="<?php echo e(asset('storage/' . $comment->attachment)); ?>" download
                                            class="btn btn-primary btn-sm m-2" target="_blank">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    <?php endif; ?>
                                </td>
                                
                                <td> <?php echo e($comment->created_at->diffForHumans()); ?></td>
                                
                                <td> <strong><?php echo e($comment->user->name); ?></strong> </td>

                                <td>
                                    <!-- Được xem task khi: (có quyền xem) -->
                                    <a <?php echo Auth::user()->hasPermission('user.tasks.show') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.tasks.show', $comment->task_id)); ?>"
                                        class="btn btn-info btn-sm m-2">
                                        <i class="fa-classic fa-thin fa-circle-info fa-fw"></i>
                                        View Task Details
                                    </a>

                                    
                                    <a <?php echo Auth::user()->hasPermission('user.comments.edit') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                                        ? ''
                                        : "disabled onclick='return false;'"; ?> href="<?php echo e(route('user.comments.edit', $comment->id)); ?>"
                                        class="btn btn-warning btn-sm m-2">
                                        <i class="fa fa-pencil"></i>
                                        Edit Comment
                                    </a>

                                    <!-- delete comment -->
                                    <form action="<?php echo e(route('user.comments.destroy', $comment->id)); ?>" method="POST"
                                        style="display:inline-block;">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <!-- Được xóa comment khi: (có quyền destroy) và ((phải đăng nhập đúng tài khoản của mình) hoặc (tài khoản đăng nhập phải là tài khoản super admin)) -->
                                        <button <?php echo Auth::user()->hasPermission('user.comments.destroy') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                                            ? "onclick=\"return confirm('Do you really want to delete this comment?')\""
                                            : "disabled onclick='return false;'"; ?> type="submit" class="btn btn-danger btn-sm m-2">
                                            <i class="fa-sharp fa-solid fa-trash fa-fw"></i>
                                            Delete Comment
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="55" class="text-center">No Comments found!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center"><?php echo e($comments->appends(request()->query())->links('pagination::simple-bootstrap-4')); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/pages/user/comments/index.blade.php ENDPATH**/ ?>
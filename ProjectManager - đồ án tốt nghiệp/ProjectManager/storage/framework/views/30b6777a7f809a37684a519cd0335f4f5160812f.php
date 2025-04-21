

<?php $__env->startSection('title', 'Account List'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        
        <div class="col-lg-12 text-right">
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle mb-3" aria-expanded="false">
                    Import / Export Excel File
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a data-toggle="modal" data-target="#importModal">
                            <i class="fa fa-upload"></i>
                            Import Accounts
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.users.export')); ?>">
                            <i class="fa fa-download"></i>
                            Export Accounts
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo e(route('admin.users.sample_import')); ?>" download>
                            <i class="fa fa-download"></i>
                            Download Import Sample
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        
        <div id="importModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-left">
                        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        <h4 class="modal-title">Excel Import</h4>
                    </div>
                    <div class="modal-body">
                        <form id="api_import_account_form">
                            <?php echo csrf_field(); ?>
                            <div class="form-group text-left">
                                <label for="account_import_file">Select Excel File</label>
                                <input type="file" name="account_import_file" id="account_import_file"
                                    class="form-control">
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Account List</h3>
                </div>
                <div class="panel-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('error')); ?>

                            <?php if(session('error_file')): ?>
                                <a href="<?php echo e(session('error_file')); ?>" class="btn btn-warning">Download Error File</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-sm-6 m-b-sm">
                            <a <?php echo Auth::user()->hasPermission('admin.users.create') ? '' : "disabled onclick='return false;'"; ?> href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add Account
                            </a>
                        </div>
                        <div class="col-sm-6 m-b-sm text-right">
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-default">
                                <i class="fa fa-refresh"></i> Refresh
                            </a>
                        </div>
                    </div>

                    <form class="input-group" action="<?php echo e(route('admin.users.index')); ?>" method="GET">
                        <input name="search_by_account_email" value="<?php echo e(request('search_by_account_email')); ?>"
                            type="text" placeholder="Search by Account Email" class="form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary"> Go!</button>
                        </span>
                    </form>

                    <div class="table-responsive m-t-md">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Modified At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr <?php echo Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'"; ?>

                                        onclick="window.location='<?php echo e(route('admin.users.show', $user->id)); ?>';"
                                        style="cursor: pointer;">
                                        <td><?php echo e($user->id); ?></td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td><?php echo e($user->getRoles->pluck('name')->implode(', ')); ?></td>
                                        <td><?php echo e(get_local_date_format($user->created_at)); ?></td>
                                        <td><?php echo e(get_local_date_format($user->updated_at)); ?></td>
                                        <td>
                                            <a <?php echo Auth::user()->hasPermission('admin.users.edit') && ($user->id == Auth::id() || Auth::id() == 1)
                                                ? ''
                                                : "disabled onclick='return false;'"; ?> href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i> Edit Account
                                            </a>

                                            
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No user found!</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <?php echo e($accounts->appends(request()->query())->links('pagination::simple-bootstrap-4')); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            $("#api_import_account_form").submit(function(e) {
                e.preventDefault();

                let submitBtn = $(this).find("button[type='submit']");
                let formData = new FormData(this);
                let csrfToken = $('meta[name="csrf-token"]').attr('content'); // Lấy từ meta tag
                formData.append("_token", csrfToken);

                // Đổi trạng thái nút
                submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Importing...');

                $.ajax({
                    url: "<?php echo e(route('admin.users.import')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                            if (response.error_file) {
                                console.log(response.error_file);

                                window.location.href = response.error_file;
                            }
                        } else {
                            alert(response.success);
                            $("#api_import_account_form")[0].reset();
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = "Lỗi: " + xhr.status;
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg += " - " + xhr.responseJSON.message;
                        }
                        alert(errorMsg);
                        console.error("Lỗi chi tiết:", xhr);
                    },
                    complete: function() {
                        // Trả nút về trạng thái ban đầu
                        submitBtn.prop("disabled", false).html('Import');
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProjectManager\resources\views/pages/admin/users/index.blade.php ENDPATH**/ ?>
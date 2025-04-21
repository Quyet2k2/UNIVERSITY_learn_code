<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" class="img-circle" src="<?php echo e(Auth::user()->avatar_url); ?>" width="50" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">
                                    <?php echo e(Auth::user()->name); ?>

                                    <!-- <b class="caret"></b> -->
                                </strong>
                            </span>
                            <span class="text-muted text-xs block">
                                <?php if(Auth::user()->id == 1): ?>
                                    <!-- Hiển thị 'Super Admin' nếu người dùng có id = 1 -->
                                    <?php echo e(Auth::user()->getRoles->where('name', 'Super Admin')->first()?->name ?? 'Not Super Admin'); ?>

                                <?php else: ?>
                                    <!-- Lọc và hiển thị vai trò khác ngoài 'Super Admin' -->
                                    <?php echo e(Auth::user()->getRoles->whereNotIn('name', ['Super Admin'])->first()?->name ?? 'No Role'); ?>

                                <?php endif; ?>
                                <b class="caret"></b>
                            </span>
                        </span>
                    </a>

                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a href="<?php echo e(route('admin.users.show', ['user' => Auth::id()])); ?>">
                                <i class="fa fa-user"></i> View My Account Detail
                            </a>
                        </li>
                        <li><a href="<?php echo e(route('logout')); ?>"> Logout </a></li>
                    </ul>
                </div>
                <div class="logo-element"> AHT </div>
            </li>

            <?php
            $user = Auth::user();
            $menu = config('_custom_menu');
            ?>
            <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- q-read: menu level 1 -->
                <?php if($user->can($m1['route'])): ?>
                    <li
                        class="<?php echo e(isset($m1['route']) && Route::is($m1['route']) ? 'active' : ''); ?> 
      <?php echo e(isset($m1['request']) && Request::is($m1['request']) ? 'active' : ''); ?>">
                        <a href="<?php echo e(route($m1['route'])); ?>">
                            <?php echo $m1['icon']; ?>

                            <span class="nav-label"><?php echo e($m1['label'] ?? ''); ?></span>
                            <?php if(isset($m1['submenu'])): ?>
                                <span class="fa arrow"></span>
                            <?php endif; ?>
                        </a>

                        <!-- q-read: menu level 2 -->
                        <?php if(isset($m1['submenu'])): ?>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <?php $__currentLoopData = $m1['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li
                                        class="<?php echo e(isset($m2['route']) && Route::is($m2['route']) ? 'active' : ''); ?> 
      <?php echo e(isset($m2['request']) && Request::is($m2['request']) ? 'active' : ''); ?>">
                                        <a href="<?php echo e(route($m2['route'])); ?>"><?php echo e($m2['label'] ?? ''); ?>

                                            <?php if(isset($m2['submenu'])): ?>
                                                <span class="fa arrow"></span>
                                            <?php endif; ?>
                                        </a>

                                        <!-- q-read: menu level 3 -->
                                        <?php if(isset($m2['submenu'])): ?>
                                            <ul class="nav nav-third-level collapse" style="height: 0px;">
                                                <?php $__currentLoopData = $m2['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li
                                                        class="<?php echo e(isset($m3['route']) && Route::is($m3['route']) ? 'active' : ''); ?>">
                                                        <a
                                                            href="<?php echo e(route($m3['route'])); ?>"><?php echo e($m3['label'] ?? ''); ?></a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </ul>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\ProjectManager2\resources\views/layouts/partial/left-sidebar.blade.php ENDPATH**/ ?>
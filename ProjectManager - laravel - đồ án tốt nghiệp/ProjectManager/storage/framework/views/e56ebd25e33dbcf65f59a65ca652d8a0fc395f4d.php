<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " id="toggleNavbarButton" href="#">
                <i class="fa fa-bars"></i>
            </a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome to AHT - Web App.</span>
            </li>
            

            <li>
                <a href="<?php echo e(route('admin.users.show', ['user' => Auth::id()])); ?>">
                    <i class="fa fa-user"></i> <?php echo e(Auth::user()->name); ?>

                </a>
            </li>
            <li>
                <a href="<?php echo e(route('logout')); ?>">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
            
        </ul>

    </nav>
</div>


<script>
    // Lấy phần tử body và nút toggle
    const body = document.body;
    const toggleButton = document.getElementById('toggleNavbarButton');

    // Kiểm tra xem trạng thái của navbar đã được lưu trong sessionStorage chưa
    if (localStorage.getItem('toggleNavbar') === "false") // Nếu đang đóng thì thêm class
        body.classList.add('mini-navbar');

    // Thêm sự kiện click để thay đổi trạng thái thu gọn của navbar
    toggleButton.addEventListener('click', function() {
        const isCollapsed = body.classList.contains('mini-navbar'); // Nếu true là đang bị đóng
        localStorage.setItem('toggleNavbar', isCollapsed); // Lưu trạng thái vào localStorage
    });
</script>
<?php /**PATH C:\xampp\htdocs\ProjectManager\resources\views/layouts/partial/header.blade.php ENDPATH**/ ?>
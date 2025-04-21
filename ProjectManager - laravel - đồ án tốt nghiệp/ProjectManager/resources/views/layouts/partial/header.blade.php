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
            {{-- <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i> <span class="label label-primary">{{ $notification_count }}</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <!-- <li class="divider"></li> -->
                    <li>
                        <div class="text-center link-block">
                            <a href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li> --}}

            <li>
                <a href="{{ route('admin.users.show', ['user' => Auth::id()]) }}">
                    <i class="fa fa-user"></i> {{ Auth::user()->name }}
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
            {{-- <li> <a class="right-sidebar-toggle"> <i class="fa fa-tasks"></i> </a> </li> --}}
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

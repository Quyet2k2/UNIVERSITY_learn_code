<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" class="img-circle" src="{{ Auth::user()->avatar_url }}" width="50" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">
                                    {{ Auth::user()->name }}
                                    <!-- <b class="caret"></b> -->
                                </strong>
                            </span>
                            <span class="text-muted text-xs block">
                                @if (Auth::user()->id == 1)
                                    <!-- Hiển thị 'Super Admin' nếu người dùng có id = 1 -->
                                    {{ Auth::user()->getRoles->where('name', 'Super Admin')->first()?->name ?? 'Not Super Admin' }}
                                @else
                                    <!-- Lọc và hiển thị vai trò khác ngoài 'Super Admin' -->
                                    {{ Auth::user()->getRoles->whereNotIn('name', ['Super Admin'])->first()?->name ?? 'No Role' }}
                                @endif
                                <b class="caret"></b>
                            </span>
                        </span>
                    </a>

                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a href="{{ route('admin.users.show', ['user' => Auth::id()]) }}">
                                <i class="fa fa-user"></i> View My Account Detail
                            </a>
                        </li>
                        <li><a href="{{ route('logout') }}"> Logout </a></li>
                    </ul>
                </div>
                <div class="logo-element"> AHT </div>
            </li>

            <?php
            $user = Auth::user();
            $menu = config('_custom_menu');
            ?>
            @foreach ($menu as $m1)
                <!-- q-read: menu level 1 -->
                @if ($user->can($m1['route']))
                    <li
                        class="{{ isset($m1['route']) && Route::is($m1['route']) ? 'active' : '' }} 
      {{ isset($m1['request']) && Request::is($m1['request']) ? 'active' : '' }}">
                        <a href="{{ route($m1['route']) }}">
                            {!! $m1['icon'] !!}
                            <span class="nav-label">{{ $m1['label'] ?? '' }}</span>
                            @if (isset($m1['submenu']))
                                <span class="fa arrow"></span>
                            @endif
                        </a>

                        <!-- q-read: menu level 2 -->
                        @if (isset($m1['submenu']))
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                @foreach ($m1['submenu'] as $m2)
                                    <li
                                        class="{{ isset($m2['route']) && Route::is($m2['route']) ? 'active' : '' }} 
      {{ isset($m2['request']) && Request::is($m2['request']) ? 'active' : '' }}">
                                        <a href="{{ route($m2['route']) }}">{{ $m2['label'] ?? '' }}
                                            @if (isset($m2['submenu']))
                                                <span class="fa arrow"></span>
                                            @endif
                                        </a>

                                        <!-- q-read: menu level 3 -->
                                        @if (isset($m2['submenu']))
                                            <ul class="nav nav-third-level collapse" style="height: 0px;">
                                                @foreach ($m2['submenu'] as $m3)
                                                    <li
                                                        class="{{ isset($m3['route']) && Route::is($m3['route']) ? 'active' : '' }}">
                                                        <a
                                                            href="{{ route($m3['route']) }}">{{ $m3['label'] ?? '' }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach


        </ul>
    </div>
</nav>

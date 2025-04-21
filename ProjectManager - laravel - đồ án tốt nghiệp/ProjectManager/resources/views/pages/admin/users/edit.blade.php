@extends('layouts.master')
@section('title', 'Edit Account')
@section('content')
    {{-- <pre>{{ print_r(session()->all(), true) }}</pre> --}}

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="panel panel-primary">
        <div class="panel-heading text-center">Edit Account</div>
        <div class="panel-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" role="form"
                enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <!-- Được sửa name khi: (tài khoản đăng nhập phải là - (tài khoản super admin) hoặc (tài khoản người dùng đang edit)) -->
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input {{ Auth::id() == $user->id ? '' : 'readonly' }} type="text" id="name"
                                name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Được sửa email khi: (tài khoản đăng nhập phải là tài khoản người dùng đang edit) -->
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input {{ Auth::id() == $user->id ? '' : 'readonly' }} type="email" id="email"
                                name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Được sửa password khi: (tài khoản đăng nhập phải là tài khoản người dùng đang edit) -->
                        <div class="form-group">
                            <label for="password">Password (if you want to change):</label>
                            <input {{ Auth::id() == $user->id ? '' : 'readonly' }} type="password" id="password"
                                name="password" class="form-control"
                                placeholder="Leave blank if you don't want to change the password!">
                            @error('password')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Được sửa password_confirmation khi: (tài khoản đăng nhập phải là tài khoản người dùng đang edit) -->
                        <div class="form-group">
                            <label for="password_confirmation">Password Confirmation:</label>
                            <input {{ Auth::id() == $user->id ? '' : 'readonly' }} type="password"
                                id="password_confirmation" name="password_confirmation" class="form-control">
                            @error('password')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Hiển thị avatar hiện tại nếu có -->
                        @if ($user->avatar)
                            <div class="form-group">
                                <label>Current Avatar:</label><br>
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Current Avatar"
                                    class="img-thumbnail" style="width: 100px; height: 100px; border-radius: 50%;">
                            </div>
                        @endif

                        <!-- Được sửa avatar khi: (tài khoản đăng nhập phải là tài khoản người dùng đang edit) -->
                        <div class="form-group">
                            @if (Auth::id() == $user->id)
                                <label for="avatar">Avatar:</label>
                                <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                            @endif
                            @error('avatar')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Được sửa roles khi: (tài khoản đăng nhập phải là tài khoản super admin hoặc tài khoản tự chỉnh sửa) -->
                        <div class="form-group" {!! Auth::id() == 1 ? '' : 'style="opacity: 0.7"' !!}>
                            <label>Roles</label>
                            @error('roles')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="panel panel-default" style="max-height: 200px; overflow-y: auto; padding: 10px;">
                                @foreach ($roles as $role)
                                    <?php $isChecked = in_array($role->name, $roles_assigned) || in_array($role->id, old('roles', [])) ? 'checked' : ''; ?>
                                    <div class="checkbox">
                                        <label>
                                            {{-- Không cho phép cấp quyền Super Admin --}}
                                            <input {!! Auth::id() == 1 && $role->id != 1 ? '' : 'onclick="return false;" style="opacity: 0.2"' !!} {{ $isChecked }} value="{{ $role->id }}"
                                                name="roles[]" type="checkbox">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- q-read: Actions --}}
                        <div class="form-group text-center">
                            {{-- <!-- Được sửa account khi: (có quyền update) và (tài khoản đăng nhập phải là - (tài khoản người dùng đang edit) hoặc (tài khoản super admin)) --> --}}
                            <button {!! Auth::user()->hasPermission('admin.users.update') && (Auth::id() == $user->id || Auth::id() == 1)
                                ? ''
                                : "disabled onclick='return false;'" !!} type="submit" class="btn btn-primary"><i
                                    class="fat fa-pen-to-square"></i> Update</button>

                            <a href="{{ route('admin.users.show', $user->id) }}" {!! Auth::user()->hasPermission('admin.users.show')
                                ? "onclick=\"return confirm('Do you really want to view this account?')\""
                                : "disabled onclick='return false;'" !!}
                                class="btn btn-info"><i class="fa fa-info-circle"></i> View Account Details</a></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

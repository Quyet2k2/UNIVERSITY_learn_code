@extends('layouts.master')
@section('title', 'Add Account')
@section('content')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="panel panel-primary">
        <div class="panel-heading text-center"><strong>Add Account</strong></div>
        <div class="panel-body">
            <form action="{{ route('admin.users.store') }}" method="POST" role="form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="roles">Roles:</label>
                            <div class="panel panel-default" style="max-height: 200px; overflow-y: auto; padding: 10px;">
                                @foreach ($roles as $role)
                                    <?php $isChecked = in_array($role->id, old('roles', [])) ? 'checked' : ''; ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                {{ $isChecked }} {{ $role->id != 1 ? '' : 'disabled' }}>
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    {{-- Được lưu mới account khi: (tài khoản đăng nhập phải là tài khoản super admin) --}}
                    <button {!! Auth::user()->hasPermission('admin.users.store') && Auth::id() == 1
                        ? ''
                        : "disabled onclick='return false;'" !!} type="submit" class="btn btn-primary">
                        <i class="fa fa-floppy-disk"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

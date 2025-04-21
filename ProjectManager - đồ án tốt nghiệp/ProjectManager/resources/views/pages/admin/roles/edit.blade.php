@extends('layouts.master')

@section('title', 'Admin | Edit Role')

@section('content')

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
        <!-- Default panel contents -->
        <div class="panel-heading">Edit Role</div>
        <div class="panel-body">
            <form action="{{ route('admin.roles.update', $model->id) }}" method="POST" role="form">
                @csrf @method('PUT')

                <!-- q-read: Name Role -->
                <div class="form-group">
                    <label>Name role</label>
                    <!-- Được sửa role name khi: (có quyền update) và (không là các role mặc định) -->
                    <input {!! !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4) ? '' : 'readonly' !!} type="text" class="form-control" name="name"
                        value="{{ $model->name }}" required>
                    @error('name')
                        <div class="text-danger mt-2 ">{{ $message }}</div>
                    @enderror
                </div>

                <!-- q-read: Permission List Label -->
                <label>Permission List</label>
                <div class="form-group" style="height: 300px; overflow-y: scroll">
                    @error('routes')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror

                    @foreach ($routes as $route)
                        <?php $isChecked = in_array($route, old('routes', $permissions)) ? 'checked' : ''; ?>
                        <div class="checkbox">
                            <label>
                                <!-- Được sửa role khi: (có quyền update) và (không là các role mặc định) -->
                                <input {!! !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4) ? '' : 'disabled' !!} type="checkbox" name="routes[]" class="role-item"
                                    {{ $isChecked }} value="{{ $route }}">
                                {{ $route }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- q-read: Submit -->
                <div class="pull-left">
                    <!-- Có thể sửa role khi: (có quyền update) và (không là các role mặc định) -->
                    <button {!! Auth::user()->hasPermission('admin.roles.update') &&
                    !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4)
                        ? ''
                        : "disabled onclick='return false;'" !!} type="submit" class="btn btn-primary">
                        <i class="fat fa-pen-to-square"></i>
                        Update</button>

                    <label>
                        <!-- Có thể checkAll role khi: (có quyền update) và (không là các role mặc định) -->
                        <input {!! !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4)
                            ? ''
                            : "disabled onclick='return false;'" !!} type="checkbox" id="checkAll">
                        Check all
                    </label>
                </div>
            </form>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#checkAll').click(function() {
                $('.role-item').prop('checked', this.checked);
            });
        });
    </script>
@endsection

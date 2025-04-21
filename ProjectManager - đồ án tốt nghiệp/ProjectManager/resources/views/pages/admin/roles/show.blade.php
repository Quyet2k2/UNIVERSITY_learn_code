@extends('layouts.master')
@section('title', 'Admin | Role Details')
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
        <div class="panel-heading"> Role Details </div>
        <div class="panel-body">
            <!-- q-read: Role Name -->
            <div class=" form-group">
                <label>Role Name </label>
                <input type="text" class="form-control" name="name" value="{{ $model->name }}" readonly>
            </div>

            <!-- q-read: Permission List -->
            <label>Permission List</label>
            <div class="form-group" style="height: 300px; overflow-y: scroll">
                <?php $isChecked = in_array($routes, $permissions) ? 'checked' : ''; ?>

                <!-- q-read: Chỉ hiện thị các permission được phép, không hiển thị các permission khác -->
                @foreach ($permissions as $permission)
                    @if (strpos($permission, 'admin.') === false && strpos($permission, 'user.') === false)
                        @continue
                    @endif

                    <div class="checkbox">
                        <label>
                            <input disabled type="checkbox" name="routes[]" class="role-item" checked
                                value="{{ $permission }}">
                            {{ $permission }}
                        </label>
                    </div>
                @endforeach
            </div>
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

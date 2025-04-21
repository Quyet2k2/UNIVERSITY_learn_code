@extends('layouts.master')

@section('title', 'Admin | Add Role')

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
        <div class="panel-heading">Add Role</div>
        <div class="panel-body">

            <form action="{{ route('admin.roles.store') }}" method="POST" role="form">
                @csrf

                <!-- q-read: Name Role -->
                <div class="form-group">
                    <label>Name Role</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                        placeholder="Input role name" required>
                    @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- q-read: Permission List - Routes -->
                <label>Permission List</label>
                <div class="form-group" style="height: 300px; overflow-y: scroll">
                    @error('routes')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror

                    @foreach ($routes as $route)
                        <!-- Tự động nhập lại checkbox trong trường hợp sai -->
                        <?php $isChecked = in_array($route, old('routes', [])) ? 'checked' : ''; ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="routes[]" class="role-item" {{ $isChecked }}
                                    value="{{ $route }}">
                                {{ $route }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- q-read: Save -->
                <div class="pull-left">
                    <!-- Có thể thêm role khi: (có quyền thêm) -->
                    <button {!! Auth::user()->hasPermission('admin.roles.store') ? '' : "disabled onclick='return false;'" !!} type="submit" class="btn btn-primary">
                        <i class="fa-classic fa-thin fa-floppy-disk fa-fw"></i>
                        Save
                    </button>

                    <label>
                        <!-- Có thể checkAll role khi: (có quyền thêm) -->
                        <input {!! Auth::user()->hasPermission('admin.roles.store') ? '' : "disabled onclick='return false;'" !!} type="checkbox" id="checkAll">
                        Check all
                    </label>
                </div>
            </form>
        </div>
    </div>

@stop

@section('scripts')
    <script type="text/javascript">
        $('#checkAll').click(function() {
            $('.role-item').prop('checked', this.checked);
        });
    </script>
@stop

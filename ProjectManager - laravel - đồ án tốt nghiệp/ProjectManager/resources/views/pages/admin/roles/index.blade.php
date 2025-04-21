@extends('layouts.master')

@section('title', 'Admin | Group Permission List')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ session('error') }}
        </div>
    @endif


    <div class="panel panel-primary">
        <div class="panel-heading">Group Permission List</div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Created At</th>
                    <th>Modified At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $model)
                    <tr>
                        <td>{{ $model->id }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ get_local_date_format($model->created_at) }}</td>
                        <td>{{ get_local_date_format($model->updated_at) }}</td>
                        <td>
                            {{--  q-read: Được xem role khi: (có quyền xem)  --}}
                            <a {!! Auth::user()->hasPermission('admin.roles.show') ? '' : "disabled onclick='return false;'" !!} href="{{ route('admin.roles.show', $model->id) }}"
                                class="btn btn-info btn-sm m-2">
                                <i class="far fa-eye"></i>
                                Show
                            </a>

                            {{--  q-read: Được sửa role khi: (có quyền sửa) và (không phải là các role mặc định)  --}}
                            <a {!! Auth::user()->hasPermission('admin.roles.edit') &&
                            !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4)
                                ? ''
                                : "disabled onclick='return false;'" !!} href="{{ route('admin.roles.edit', $model->id) }}"
                                class="btn btn-info btn-sm m-2 btn-warning">
                                <i class="fa fa-pencil"></i>
                                Edit Role
                            </a>

                            {{-- q-read: Được xóa role khi: (có quyền xóa) và (không phải là các role mặc định) --}}
                            <form style="display:inline-block" action="{{ route('admin.roles.destroy', $model->id) }}"
                                method="POST">
                                @csrf @method('DELETE')
                                <button {!! Auth::user()->hasPermission('admin.roles.destroy') &&
                                !($model->id != 1 && $model->id != 2 && $model->id != 3 && $model->id != 4)
                                    ? 'onclick="return confirm(\'Do you really want to delete this role?\')"'
                                    : "disabled onclick='return false;'" !!} type="submit" class="btn btn-info btn-sm m-2 btn-danger">
                                    <i class="fa-sharp fa-solid fa-trash fa-fw"></i>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="panel-footer">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>
    </div>
@stop

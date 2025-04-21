@extends('layouts.master')
@section('title', 'Task List')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="panel panel-primary">
        <div class="panel-heading text-center"><strong>Task List</strong></div>
        <div class="panel-body">
            {{-- q-read: Tìm kiếm và refresh --}}
            <div class="row m-b-sm m-t-sm">
                {{-- q-read: Refresh --}}
                <div class="col-sm-12 col-md-1 mb-2 mb-md-0">
                    <a href="{{ route('user.tasks.index') }}" class="btn btn-white btn-sm w-100">
                        <i class="fa fa-refresh"></i> Refresh
                    </a>
                </div>
                {{-- q-read: Tìm kiếm --}}
                <div class="col-sm-12 col-md-11">
                    <form class="input-group" action="{{ route('user.tasks.index') }}" method="GET">
                        <input name="search_by_task_name" value="{{ request('search_by_task_name') }}" type="text"
                            placeholder="Search by Task Name" class="input-sm form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Go!</button>
                        </span>
                    </form>
                </div>
            </div>

            {{-- q-read: Danh sách task --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Task Name</th>
                            <th>Assigned To</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Task Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <!-- q-read: project và project_manager_id -->
                            @php
                                $project = get_project_by_id($task->project_id);
                                $project_manager_id = $project->project_manager_assigned_to;
                                // q-read: Đặt màu cho trạng thái task
                                $task_status_label = match ($task->status) {
                                    'Open' => 'label-primary',
                                    'Processing' => 'label-info',
                                    'Testing', 'PM' => 'label-warning',
                                    'Completed' => 'label-danger',
                                    default => 'label-default',
                                };
                            @endphp
                            {{-- q-read: Được xem chi tiết người dùng khi: (có quyền show) --}}
                            <tr {!! Auth::user()->hasPermission('user.tasks.show') ? '' : "disabled onclick='return false;'" !!}
                                onclick="window.location='{{ route('user.tasks.show', $task->id) }}'"
                                style="cursor: pointer;">
                                <td>{{ $task->id }}</td>
                                <td>
                                    {{ $task->name }}
                                </td>
                                <td>
                                    {{ get_user_by_id($task->assigned_to)->name ?? 'No User found!' }}
                                </td>
                                <td>{{ $task->start_time }}</td>
                                <td>{{ $task->end_time }}</td>
                                <td><span class="label {{ $task_status_label }}">{{ $task->status }}</span></td>
                                <td>
                                    <!-- q-read: Được edit task khi: (có quyền edit) và (tài khoản đăng nhập phải là - (tài khoản được gán) hoặc (tài khoản project manager) hoặc (tài khoản super admin)) -->
                                    <a {!! Auth::user()->hasPermission('user.tasks.edit') &&
                                    (Auth::id() == $task->assigned_to || Auth::id() == $project_manager_id || Auth::id() == 1)
                                        ? ''
                                        : "disabled onclick='return false;'" !!} href="{{ route('user.tasks.edit', $task->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa fa-pencil"></i> Edit Task
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No tasks found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- q-read: Phân trang --}}
            <div class="text-center">{{ $tasks->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    </div>
@stop

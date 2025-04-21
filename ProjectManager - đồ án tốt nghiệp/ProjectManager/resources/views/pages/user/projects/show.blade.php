<?php
// q-read: Đặt màu cho trạng thái dự án
$project_status_label = '';
switch (set_project_status_by_tasks($project->id)) {
    case 'Open':
        $project_status_label = 'label-primary';
        break;
    case 'Processing':
        $project_status_label = 'label-info';
        break;
    case 'UAT':
        $project_status_label = 'label-warning';
        break;
    case 'Closed':
        $project_status_label = 'label-danger';
        break;
} ?>

@extends('layouts.master')
@section('title', 'Project Details')
@section('content')
    <h1 class="text-center">Project Details</h1>

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

    <div class="ibox">
        <div class="ibox-title">
            <div class="pull-right">
                <!-- Được sửa project khi: (có quyền update) và ((là tài khoản project manager) hoặc (tài khoản super admin)) -->
                <a {!! Auth::user()->hasPermission('user.projects.edit') &&
                (Auth::id() == $project->project_manager_assigned_to || Auth::id() == 1)
                    ? ''
                    : "disabled onclick='return false;'" !!} class=" btn btn-sm btn-warning m-2"
                    href="{{ route('user.projects.edit', $project->id) }}">
                    <i class="fa fa-pencil"></i>
                    Edit project
                </a>

                {{-- <!-- delete project --> --}}
                {{-- <form action="{{ route('user.projects.destroy', $project->id) }}" method="POST"
                    style="display:inline-block;" class="">
                    @csrf @method('DELETE')
                    <!-- Được xóa dự án khi: (có quyền destroy) và (tài khoản đăng nhập phải là tài khoản super admin) -->
                    <button {!! Auth::user()->hasPermission('user.projects.destroy') && Auth::id() == 1
                        ? 'onclick="return confirm(\'Do you really want to delete this project?\')"'
                        : "disabled onclick='return false;'" !!} type="submit" class="btn btn-sm btn-danger m-2" >
                        <i class="fa-sharp fa-solid fa-trash fa-fw"></i>
                        Delete
                    </button>
                </form> --}}
            </div>

            <h2>{{ $project->name }}</h2>
        </div>
        <div class="ibox-content">
            {{-- q-read:  Status --}}
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>Status:</dt>
                        <dd>
                            <span class="label {{ $project_status_label }}">
                                {{ set_project_status_by_tasks($project->id) ?: 'No Status' }}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>

            {{-- q-read: Start Time --}}
            <div class="row">
                <div class="col-lg-5">
                    <dl class="dl-horizontal">
                        <dt>Start Time:</dt>
                        <dd>{{ $project->start_time }}</dd>
                        <dt>Project Manager:</dt>
                        <dd>
                            {{-- q-read: Được xem chi tiết người dùng khi: (có quyền show) --}}
                            <a {!! Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'" !!}
                                href="{{ route('admin.users.show', $project->project_manager_assigned_to) }}">
                                {{ $pm->name ?: 'No PM found!' }}
                            </a>
                        </dd>
                        <dt>Participants:</dt>
                        <dd class="project-people">
                            @foreach ($usersOfProject as $user)
                                {{-- q-read: Được xem chi tiết người dùng khi: (có quyền show) --}}
                                <a {!! Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'" !!} href="{{ route('admin.users.show', $user->id) }}">
                                    <img alt="image" class="img-circle"
                                        src="{{ $user?->avatar_url ?: asset('storage/default_images/default-avatar.jpg') }}"
                                        title="{{ $user?->name ?: 'No User found!' }}">
                                    {{-- {{ $user->name }} --}}
                                </a>
                                @if (!$loop->last)
                                    ,
                                @else
                                    .
                                @endif
                            @endforeach
                        </dd>
                    </dl>
                </div>

                <div class="col-lg-7" id="cluster_info">
                    <dl class="dl-horizontal">
                        <dt> End Time:</dt>
                        <dd>{{ $project->end_time }}</dd>
                        <dt>Last Updated:</dt>
                        <dd> {{ get_local_date_format($project->updated_at) }} </dd>
                        <dt>Created:</dt>
                        <dd> {{ get_local_date_format($project->created_at) }}</dd>
                    </dl>
                </div>
            </div>

            {{-- q-read: Completed --}}
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>Completed:</dt>
                        <dd>
                            <div class="progress progress-striped active m-b-sm">
                                <div style="width: {{ project_calc_percent($project->id) }}%;" class="progress-bar"></div>
                            </div>
                            <small>Project completed in <strong>{{ project_calc_percent($project->id) }}%</strong>.
                                Remaining close the project, sign a contract and invoice.
                            </small>
                        </dd>
                    </dl>
                </div>
            </div>

            {{-- q-read: Description --}}
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal ">
                        <dt>Description:</dt>
                        <dd>{{ $project->description ?: 'No Description' }}</dd>
                    </dl>
                </div>
            </div>

            {{-- q-read: Add Task Button --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">
                        {{-- q-read: Được thêm task khi: (có quyền create) --}}
                        <a {!! Auth::user()->hasPermission('user.tasks.create') ? '' : "disabled onclick='return false;'" !!} href="{{ route('user.tasks.create', ['project_id' => $project->id]) }}"
                            class="btn btn-primary btn-sm pull-right">
                            <i class="fa fa-plus"></i>
                            Add Task
                        </a>
                    </div>
                </div>
            </div>

            {{-- q-read: Tasks --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel blank-panel">

                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab">Tasks</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Title</th>
                                                    <th>End Time</th>
                                                    <th>Task KPI</th>
                                                    <th>Assigned To</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- q-read: Danh sách task --}}
                                                @forelse ($tasks as $task)
                                                    @php
                                                        $project = get_project_by_id($task->project_id);
                                                        $project_manager_id = $project->project_manager_assigned_to;

                                                        // q-read: Đặt màu cho trạng thái task
                                                        $task_status_label = '';
                                                        switch ($task->status) {
                                                            case 'Open':
                                                                $task_status_label = 'label-primary';
                                                                break;
                                                            case 'Processing':
                                                                $task_status_label = 'label-info';
                                                                break;
                                                            case 'Testing':
                                                                $task_status_label = 'label-warning';
                                                                break;
                                                            case 'PM':
                                                                $task_status_label = 'label-warning';
                                                                break;
                                                            case 'Completed':
                                                                $task_status_label = 'label-danger';
                                                                break;
                                                        }
                                                    @endphp

                                                    {{-- q-read: Được xem task khi: (có quyền xem) --}}
                                                    <tr {!! Auth::user()->hasPermission('user.tasks.show') ? '' : "disabled onclick='return false;'" !!}
                                                        onclick="window.location.href = '{{ route('user.tasks.show', $task->id) }}'"
                                                        style="cursor: pointer;">
                                                        <td>
                                                            <span class="label {{ $task_status_label }}">
                                                                <i class="fa fa-check"></i>
                                                                {{ ucfirst($task->status ?: 'No Status') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ $task->name ?: 'No Name' }}
                                                        </td>
                                                        <td> {{ get_local_date_format($task->end_time) }} </td>
                                                        <td>
                                                            <strong>
                                                                {{ rtrim(rtrim(number_format($task->bill, 2), '0'), '.') }}
                                                            </strong>
                                                        </td>
                                                        <td>
                                                            <p class="small">
                                                                {{ get_user_by_id($task->assigned_to)->name ?: 'No User found!' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <!-- Được edit task khi: (có quyền edit) và (tài khoản đăng nhập phải là - (tài khoản được gán) hoặc (tài khoản project manager) hoặc (tài khoản super admin)) -->
                                                            <a {!! Auth::user()->hasPermission('user.tasks.edit') &&
                                                            (Auth::id() == $task->assigned_to || Auth::id() == $project_manager_id || Auth::id() == 1)
                                                                ? ''
                                                                : "disabled onclick='return false;'" !!}
                                                                href="{{ route('user.tasks.edit', $task->id) }}"
                                                                class="btn btn-warning btn-sm m-2">
                                                                <i class="fa fa-pencil"></i>
                                                                Edit Task
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="55" class="text-center">No Task Found!</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- q-read: Phân trang --}}
                                    <div class="text-center">
                                        {{ $tasks->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

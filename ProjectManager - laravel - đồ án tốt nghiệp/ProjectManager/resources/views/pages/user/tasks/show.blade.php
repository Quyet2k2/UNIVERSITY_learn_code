@php
    $task_completed_percentage = task_calc_percent($task) ?? 0;
@endphp
@extends('layouts.master')
@section('title', 'Task Details')
@section('content')
    <h1 class="text-center">Task Details</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="ibox">
        <div class="ibox-title">
            <h2>{{ $task->name }}</h2>
        </div>
        <div class="ibox-content">

            {{-- q-read: actions --}}
            <div class="row">
                <div class="col-md-12 text-right pb-3">
                    <!-- q-read: Được sửa Task khi: (có quyền update) && (tài khoản đăng nhập phải là tài khoản - (được gán) hoặc (tài khoản project manager) hoặc (tài khoản super admin)) -->
                    <a {!! Auth::user()->hasPermission('user.tasks.edit') &&
                    (Auth::id() == $task->assigned_to || Auth::id() == $project_manager_id || Auth::id() == 1)
                        ? ''
                        : "disabled onclick='return false;'" !!} class="btn m-1 btn-warning" href="{{ route('user.tasks.edit', $task->id) }}">
                        <i class="fa fa-pencil"></i> Edit Task
                    </a>

                    {{-- q-read: xóa task --}}
                    {{-- <form action="{{ route('user.tasks.destroy', $task->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf @method('DELETE')
                        <!-- Được xóa task khi: (có quyền xóa) và (tài khoản đăng nhập phải là - (tài khoản project manager) hoặc (tài khoản super admin)) -->
                        <button {!! Auth::user()->hasPermission('user.tasks.destroy') && (Auth::id() == $project_manager_id || Auth::id() == 1)
                            ? 'onclick="return confirm(\'Do you really want to delete this task?\')"'
                            : "disabled onclick='return false;'" !!} type="submit" class="btn m-1 btn-danger" >
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form> --}}
                </div>
            </div>

            <!-- q-read: Status Task -->
            <div class="row">
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Status:</dt>
                        {{-- q-read: task status --}}
                        <dd><span class="label {{ $task_status_label }}">{{ $task->status ?: 'No Status' }}</span></dd>

                        <dt>First Completed At:</dt>
                        <dd>{{ $task->first_completed_at ?: 'Not Completed Yet' }}</dd>

                        <dt>Start Time:</dt>
                        <dd>{{ $task->start_time }}</dd>

                        <dt>End Time:</dt>
                        <dd>{{ $task->end_time }}</dd>
                    </dl>
                </div>

                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Task KPI:</dt>
                        <dd><strong>{{ rtrim(rtrim(number_format($task->bill, 2), '0'), '.') }}</strong></dd>

                        <dt>Project:</dt>
                        <dd>
                            {{-- q-read: Được xem chi tiết project khi: (có quyền show) --}}
                            <a {!! Auth::user()->hasPermission('user.projects.show') ? '' : "disabled onclick='return false;'" !!} href="{{ route('user.projects.show', $project->id) }}">
                                {{ $project->name ?: 'No Project Name' }}
                            </a>
                        </dd>

                        <dt>Last Updated:</dt>
                        <dd>{{ get_local_date_format($task->updated_at) }}</dd>

                        <dt>Created:</dt>
                        <dd>{{ get_local_date_format($task->created_at) }}</dd>
                    </dl>
                </div>
            </div>

            <!-- q-read: assigned_to -->
            <div class="row">
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Assigned To:</dt>
                        <dd>
                            {{-- q-read: Được xem chi tiết assigned_to khi: (có quyền show) --}}
                            <a {!! Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'" !!} href="{{ route('admin.users.show', $task->assigned_to) }}">
                                {{ get_user_by_id($task->assigned_to)->name ?: 'No User found!' }}
                            </a>
                        </dd>

                        <dt>Project Manager:</dt>
                        <dd>
                            {{-- q-read: Được xem chi tiết project_manager khi: (có quyền show) --}}
                            <a {!! Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'" !!} href="{{ route('admin.users.show', $project_manager_id) }}">
                                {{ $project_manager->name ?: 'No User found!' }}
                            </a>
                        </dd>
                    </dl>
                </div>

                <!-- q-read: Completed -->
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Completed:</dt>
                        <dd>
                            <div class="progress progress-striped active m-b-xs">
                                <div style="width: {{ task_calc_percent($task) }}%;"
                                    class="progress-bar progress-bar-success"></div>
                            </div>
                            <small>Task completed in <strong>{{ task_calc_percent($task) }}%</strong>.</small>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- q-read: Description -->
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>Description:</dt>
                        <dd>{{ $task->description ?: 'No Description' }}</dd>
                    </dl>
                </div>
            </div>

            <!-- q-read: Được thêm Comment khi: (có quyền create) -->
            <div class="row">
                <div class="col-md-12 text-right">
                    <a {!! Auth::user()->hasPermission('user.comments.create') ? '' : "disabled onclick='return false;'" !!} href="{{ route('user.comments.create', ['task_id' => $task->id]) }}"
                        class="btn btn-success btn-sm" style="margin-bottom: 10px;">
                        <i class="fa fa-plus"></i> Add Comment
                    </a>
                </div>
            </div>

            <!-- q-read: Comments -->
            <div class="panel blank-panel">
                <div class="panel-heading">
                    <div class="panel-options">
                        {{-- q-read: Tabs --}}
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-comments" data-toggle="tab">Comments</a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">
                    {{-- q-read: Tab Content --}}
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-comments">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Content</th>
                                            <th>Attachment</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($commentsOfTask as $comment)
                                            <tr>
                                                <td>
                                                    <a {!! Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'" !!}
                                                        href="{{ route('admin.users.show', $comment->user_id) }}">
                                                        {{ get_user_by_id($comment->user_id)->name ?: 'No User found!' }}
                                                    </a>
                                                </td>
                                                <td style="white-space: pre-line; word-wrap: break-word; min-width: 300px;">
                                                    {{ $comment->content ?: 'No Content' }}</td>
                                                <td>
                                                    @if ($comment->attachment)
                                                        <a href="{{ asset('storage/' . $comment->attachment) }}"
                                                            class="btn btn-primary btn-sm" download target="_blank">
                                                            <i class="fa fa-download"></i> Download
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ $comment->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <a {!! Auth::user()->hasPermission('user.comments.edit') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                                                        ? ''
                                                        : "disabled onclick='return false;'" !!} class="btn btn-warning btn-sm"
                                                        href="{{ route('user.comments.edit', $comment->id) }}">
                                                        Edit Comment
                                                    </a>
                                                    <form action="{{ route('user.comments.destroy', $comment->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf @method('DELETE')
                                                        <button {!! Auth::user()->hasPermission('user.comments.destroy') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                                                            ? 'onclick="return confirm(\'Do you really want to delete this comment?\')"'
                                                            : "disabled onclick='return false;'" !!} class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Delete Comment
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No Comments Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

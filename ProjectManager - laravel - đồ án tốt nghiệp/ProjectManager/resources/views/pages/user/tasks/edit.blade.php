<?php //  q-read: project và project_manager_id
$project = get_project_by_id($task->project_id);
$project_manager_id = $project->project_manager_assigned_to; ?>
@extends('layouts.master')
@section('title', 'Edit Task')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-center">Edit Task: {{ $task->name }}</h3>
        </div>
        <div class="panel-body">
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

            <form action="{{ route('user.tasks.update', $task->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <!-- q-read: Task Name -->
                        <label for="name">Task Name:</label>
                        <!-- Được sửa Task Name khi: (có quyền update) && (tài khoản đăng nhập phải là tài khoản - (tài khoản project manager) hoặc (tài khoản super admin)) -->
                        <input {!! Auth::id() == 1 || Auth::id() == $project_manager_id ? '' : 'readonly' !!} type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $task->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6 form-group">
                        <!-- q-read: Select Project -->
                        <label for="project_id" class="form-label">Select Project</label>
                        <input type="hidden" name="project_id" value="{{ old('project_id', $task->project_id) }}">
                        <select disabled id="project_id" class="form-control" name="project_id" required>
                            <option value="" disabled selected> </option>
                            @foreach ($projects as $project)
                                <option
                                    {{ old('project_id') == $project->id || $task->project_id == $project->id ? 'selected' : '' }}
                                    value="{{ $project->id }}"> {{ $project->name }} </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @if (Auth::id() != 1)
                    <input type="hidden" name="project_id" value="{{ old('project_id', $task->project_id) }}" />
                @endif

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <!-- q-read: assigned_to -->
                        <label for="assigned_to">Assigned To</label>
                        <select name="assigned_to" id="assigned_to" class="form-control" required>
                            <option value="" disabled selected> </option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('assigned_to') == $user->id || $task->assigned_to == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6 form-group">
                        <!-- q-read: status -->
                        <label for="status">Task Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="" disabled selected> </option>
                            <option value="Open" {{ old('status', $task->status) == 'Open' ? 'selected' : '' }}>
                                Open
                            </option>
                            <option value="Processing"
                                {{ old('status', $task->status) == 'Processing' ? 'selected' : '' }}>
                                Processing
                            </option>
                            <option value="Testing" {{ old('status', $task->status) == 'Testing' ? 'selected' : '' }}>
                                Testing
                            </option>
                            <option value="PM" {{ old('status', $task->status) == 'PM' ? 'selected' : '' }}>
                                PM
                            </option>
                            {{-- q-read: Chỉ cho Super Admin và Project Manager được đóng task --}}
                            <option value="Completed"
                                {{ Auth::id() == 1 || Auth::id() == $project_manager_id ? '' : 'disabled' }}
                                {{ old('status', $task->status) == 'Completed' ? 'selected' : '' }}>
                                Completed
                            </option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 form-group">
                        <!-- q-read: description -->
                        <label for="description">Task Description:</label>
                        <textarea {!! Auth::id() == $project_manager_id || Auth::id() == 1 ? '' : 'readonly' !!} name="description" id="description" class="form-control" rows="5">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <!-- q-read: start time -->
                        <label for="start_time">Start Time:</label>
                        <input {!! Auth::id() == $project_manager_id || Auth::id() == 1 ? '' : 'readonly' !!} type="datetime-local" name="start_time" id="start_time"
                            class="form-control" value="{{ old('start_time', get_date_time_string($task->start_time)) }}">
                        @error('start_time')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6 form-group">
                        <!-- q-read: end time -->
                        <label for="end_time">End Time:</label>
                        <input {!! Auth::id() == $project_manager_id || Auth::id() == 1 ? '' : 'readonly' !!} type="datetime-local" name="end_time" id="end_time"
                            class="form-control" value="{{ old('end_time', get_date_time_string($task->end_time)) }}">
                        @error('end_time')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <!-- q-read: Task Bill -->
                    <label for="bill">Task Bill (KPI)</label>
                    {{-- q-read: Task Bill khi: (có quyền update) && (tài khoản đăng nhập phải là tài khoản - (tài khoản project manager) hoặc (tài khoản super admin)) --}}
                    <input {{ Auth::id() == $project_manager_id || Auth::id() == 1 ? '' : 'readonly' }} type="number"
                        step="0.01" value="{{ old('bill', rtrim(rtrim(number_format($task->bill, 2), '0'), '.')) }}"
                        name="bill" id="bill" class="form-control" required>
                    @error('bill')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-center">
                    <!-- q-read: submit -->
                    <button {!! Auth::user()->hasPermission('user.tasks.update') &&
                    (Auth::id() == $task->assigned_to || Auth::id() == $project_manager_id || Auth::id() == 1)
                        ? ''
                        : "disabled onclick='return false;'" !!} type="submit" class="btn btn-primary"><i
                            class="fat fa-pen-to-square"></i>
                        Update</button>
                    <a {!! Auth::user()->hasPermission('user.tasks.show')
                        ? "onclick=\"return confirm('Do you really want to view this task?')\""
                        : "disabled onclick='return false;'" !!} href="{{ route('user.tasks.show', $task->id) }}" class="btn btn-info">
                        <i class="fa fa-info-circle"></i>
                        Task Details</a>
                </div>
            </form>
        </div>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#project_id').select2({
                placeholder: 'Select a Project',
                allowClear: true,
                width: '100%'
            });
            $('#assigned_to').select2({
                placeholder: 'Select a User',
                allowClear: true,
                width: '100%'
            });
            $('#status').select2({
                placeholder: 'Select a Status',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
@section('styles')
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

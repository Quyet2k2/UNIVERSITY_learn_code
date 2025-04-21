@extends('layouts.master')
@section('title', 'Add Task')
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-center">Add Task</h3>
        </div>
        <div class="panel-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('user.tasks.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <!-- q-read: Task Name -->
                        <label for="name">Task Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6 form-group">
                        <!-- q-read: Select Project -->
                        <label for="project_id" class="form-label">Select Project</label>
                        <select {{ Auth::id() == 1 ? '' : 'disabled' }} id="project_id" class="form-control"
                            name="project_id" required>
                            <option value="" disabled selected> </option>
                            @foreach ($projects as $project)
                                <option
                                    {{ old('project_id') == $project->id || $project_id == $project->id ? 'selected' : '' }}
                                    value="{{ $project->id }}"> {{ $project->name }} </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (Auth::id() != 1)
                        <input type="hidden" name="project_id" value="{{ old('project_id', $project_id) }}" />
                    @endif
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <!-- q-read: assigned_to -->
                        <label for="assigned_to">Assigned To</label>
                        <select name="assigned_to" id="assigned_to" class="form-control" required>
                            <option value="" disabled selected> </option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6 form-group">
                        <!-- q-read: Task Bill -->
                        <label for="bill">Task Bill (KPI)</label>
                        <input type="number" step="0.01" value="{{ old('bill') }}" name="bill" id="bill"
                            class="form-control" required>
                        @error('bill')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 form-group">
                        <!-- q-read: description -->
                        <label for="description">Task Description:</label>
                        <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <!-- q-read: start time -->
                        <label for="start_time">Start Time:</label>
                        <input type="datetime-local" name="start_time" id="start_time" class="form-control"
                            value="{{ old('start_time') }}">
                        @error('start_time')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6 form-group">
                        <!-- q-read: end time -->
                        <label for="end_time">End Time:</label>
                        <input type="datetime-local" name="end_time" id="end_time" class="form-control"
                            value="{{ old('end_time') }}">
                        @error('end_time')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- q-read: Submit -->
                <div class="form-group text-center">
                    {{-- q-read: Được lưu task khi: (có quyền store) --}}
                    <button {!! Auth::user()->hasPermission('user.tasks.store') ? '' : "disabled onclick='return false;'" !!} type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save
                    </button>

                    {{-- q-read: Được xem chi tiết project khi: (có quyền show) --}}
                    <a {!! Auth::user()->hasPermission('user.projects.show')
                        ? "onclick=\"return confirm('Do you really want to view this project?')\""
                        : "disabled onclick='return false;'" !!} href="{{ route('user.projects.show', $project_id) }}" class="btn btn-info">
                        <i class="fa fa-info-circle"></i> Project Details
                    </a>
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
        });
    </script>
@endsection

@section('styles')
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

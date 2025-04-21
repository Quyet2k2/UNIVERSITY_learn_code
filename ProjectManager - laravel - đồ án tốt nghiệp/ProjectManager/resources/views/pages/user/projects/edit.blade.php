@extends('layouts.master')

@section('title', 'Edit Project')

@section('content')
    {{-- <pre>{{ print_r(session()->all(), true) }}</pre> --}}

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h2>Edit Project</h2>
        </div>
        <div class="panel-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Edit Project -->
            <form action="{{ route('user.projects.update', $project->id) }}" method="POST">
                @csrf @method('PUT')

                <!-- q-read: name -->
                <div class="form-group">
                    <label for="name" class="form-label">Project Name</label>
                    <input {!! Auth::id() == 1 ? '' : 'readonly' !!} type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $project->name) }}" required>
                    @error('name')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- q-read: project_manager_assigned_to -->
                <div class="form-group">
                    <label for="project_manager_assigned_to">Project Manager Assigned To</label>
                    <select {!! Auth::id() == 1 ? '' : 'disabled' !!} name="project_manager_assigned_to" id="project_manager_assigned_to"
                        class="form-control select2" required>
                        @foreach ($PM_user_ids as $PM_user_id)
                            <option value="{{ $PM_user_id }}"
                                {{ old('project_manager_assigned_to', $project->project_manager_assigned_to) == $PM_user_id ? 'selected' : '' }}>
                                {{ get_user_by_id($PM_user_id)->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_manager_assigned_to')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                    @if (Auth::id() != 1)
                        <input type="hidden" name="project_manager_assigned_to"
                            value="{{ $project->project_manager_assigned_to }}">
                    @endif
                </div>

                <!-- q-read: project_assigned_to -->
                <div class="form-group">
                    <label for="project_assigned_to">Project Assigned To</label>
                    <select name="project_assigned_to[]" id="project_assigned_to" class="form-control" multiple="multiple"
                        required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $usersOfProject->pluck('id')->contains($user->id) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_assigned_to')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- q-read: status -->
                <div class="form-group">
                    <label for="status">Project Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="Open" {{ old('status', $project->status) == 'Open' ? 'selected' : '' }}>Open
                        </option>
                        <option value="Processing" {{ old('status', $project->status) == 'Processing' ? 'selected' : '' }}>
                            Processing</option>
                        <option value="UAT" {{ old('status', $project->status) == 'UAT' ? 'selected' : '' }}>UAT
                        </option>
                        <option value="Closed" {{ old('status', $project->status) == 'Closed' ? 'selected' : '' }}>Closed
                        </option>
                    </select>
                    @error('status')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- q-read: description -->
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <!-- q-read: Start Time; End Time -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="start_time">Start Time</label>
                            <input type="datetime-local" name="start_time" id="start_time" class="form-control" required
                                value="{{ old('start_time', $project->start_time) }}">
                            @error('start_time')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="end_time">End Time</label>
                            <input type="datetime-local" name="end_time" id="end_time" class="form-control" required
                                value="{{ old('end_time', $project->end_time) }}">
                            @error('end_time')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- q-read: submit -->
                <div class="form-group text-center">
                    <button {!! Auth::user()->hasPermission('user.projects.update') &&
                    (Auth::id() == 1 || Auth::id() == $project->project_manager_assigned_to)
                        ? ''
                        : "disabled onclick='return false;'" !!} type="submit" class="btn btn-primary">
                        <i class="fat fa-pen-to-square"></i>
                        Update</button>
                    <a {!! Auth::user()->hasPermission('user.projects.show')
                        ? "onclick=\"return confirm('Do you really want to view this project?')\""
                        : "disabled onclick='return false;'" !!} href="{{ route('user.projects.show', $project->id) }}" class="btn btn-info">
                        <i class="fa fa-info-circle"></i> Project Details
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#project_assigned_to').select2({
                allowClear: true,
                width: '100%',
                placeholder: "Select Users"
            });

            $('#project_manager_assigned_to').select2({
                allowClear: true,
                width: '100%',
                placeholder: "Select an User"
            });

            $('#status').select2({
                allowClear: true,
                width: '100%',
                placeholder: "Select a Status"
            });
        });
    </script>
@endsection

@section('styles')
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

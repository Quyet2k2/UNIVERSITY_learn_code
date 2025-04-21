@extends('layouts.master')

@section('title', 'Add Project')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-folder-open"></i> Add Project</h3>
                </div>
                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('user.projects.store') }}" method="POST">
                        @csrf

                        <!-- Project Name -->
                        <div class="form-group">
                            <label for="name" class="control-label">Project Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Project Manager -->
                        <div class="form-group">
                            <label for="project_manager_assigned_to">Project Manager</label>
                            <select name="project_manager_assigned_to" id="project_manager_assigned_to" class="form-control"
                                required>
                                <option value="" disabled selected>-- Select Manager --</option>
                                @foreach ($PM_user_ids as $PM_user_id)
                                    <option value="{{ $PM_user_id }}"
                                        {{ old('project_manager_assigned_to') == $PM_user_id ? 'selected' : '' }}>
                                        {{ get_user_by_id($PM_user_id)->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_manager_assigned_to')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Project Assigned To -->
                        <div class="form-group">
                            <label for="project_assigned_to">Assign Users</label>
                            <select name="project_assigned_to[]" id="project_assigned_to" class="form-control"
                                multiple="multiple" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, old('project_assigned_to', [])) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_assigned_to')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="start_time">Start Date</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="datetime-local" class="form-control" id="start_time" name="start_time"
                                        value="{{ old('start_time') }}" required>
                                </div>
                                @error('start_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="end_time">End Date</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="datetime-local" class="form-control" id="end_time" name="end_time"
                                        value="{{ old('end_time') }}" required>
                                </div>
                                @error('end_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="form-group text-right">
                            {{-- q-read: Submit khi: (có quyền store) --}}
                            <button {!! Auth::user()->hasPermission('user.projects.store') ? '' : "disabled onclick='return false;'" !!} type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#project_manager_assigned_to').select2({
                placeholder: 'Select a Project Manager',
                allowClear: true,
                width: '100%'
            });

            $('#project_assigned_to').select2({
                placeholder: "Select Users of Project",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

@section('styles')
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

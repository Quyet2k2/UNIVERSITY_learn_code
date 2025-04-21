@extends('layouts.master')
@section('title', 'Project List')

@section('content')
    <h1 class="text-center">Project List</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="ibox">
        <div class="ibox-title d-flex justify-content-between align-items-center flex-wrap">
            <h5>All projects assigned to this account</h5>
            <div class="ibox-tools mt-2 mt-md-0">
                <a {!! Auth::user()->hasPermission('user.projects.create') ? '' : "disabled onclick='return false;'" !!} href="{{ route('user.projects.create') }}" class="btn btn-primary btn-xs">
                    <i class="fa fa-plus"></i> Add Project
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row m-b-sm m-t-sm">
                <div class="col-sm-12 col-md-1 mb-2 mb-md-0">
                    <a href="{{ route('user.projects.index') }}" class="btn btn-white btn-sm w-100">
                        <i class="fa fa-refresh"></i> Refresh
                    </a>
                </div>
                <div class="col-sm-12 col-md-11">
                    <form class="input-group" action="{{ route('user.projects.index') }}" method="GET">
                        <input name="search_by_project_name" value="{{ request('search_by_project_name') }}" type="text"
                            placeholder="Search by Project Name" class="input-sm form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Go!</button>
                        </span>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <tbody>
                        @forelse ($projects as $project)
                            <?php
                            $project_status_label = match (set_project_status_by_tasks($project->id)) {
                                'Open' => 'label-primary',
                                'Processing' => 'label-info',
                                'UAT' => 'label-warning',
                                'Closed' => 'label-danger',
                                default => '',
                            };
                            ?>

                            <tr class="project-row" {!! Auth::user()->hasPermission('user.projects.show')
                                ? "onclick='redirectToProject({$project->id})' style='cursor: pointer;'"
                                : "disabled onclick='return false;'" !!}>

                                <td class="project-status">
                                    <span class="label {{ $project_status_label }}">
                                        {{ set_project_status_by_tasks($project->id) ?: 'No Status' }}
                                    </span>
                                </td>

                                <td class="project-title">
                                    <strong style="font-size: 1.3rem;">{{ $project->name }}</strong> <br>
                                    <small>Created {{ $project->created_at->diffForHumans() }}</small>
                                </td>

                                <td class="project-completion" style="width: 20%; min-width: 150px;">
                                    <small>Completion: {{ project_calc_percent($project->id) }}%</small>
                                    <div class="progress progress-mini">
                                        <div class="progress-bar progress-bar-striped active"
                                            style="width: {{ project_calc_percent($project->id) }}%;">
                                        </div>
                                    </div>
                                </td>

                                <td class="project-people text-nowrap">
                                    <div class="text-success font-weight-bold">
                                        <i class="fa fa-calendar"></i> Start: {{ $project->start_time }}
                                    </div>
                                    <div class="text-danger font-weight-bold">
                                        <i class="fa fa-calendar-times"></i> End: {{ $project->end_time }}
                                    </div>
                                </td>

                                <td class="project-actions">
                                    <a {!! Auth::user()->hasPermission('user.projects.edit') &&
                                    (Auth::id() == 1 || Auth::id() == $project->project_manager_assigned_to)
                                        ? ''
                                        : "disabled onclick='return false;'" !!} href="{{ route('user.projects.edit', $project->id) }}"
                                        class="btn btn-warning btn-sm m-2">
                                        <i class="fa fa-pencil"></i> Edit Project
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="55" class="text-center">No projects found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{ $projects->appends(request()->query())->links('pagination::simple-bootstrap-4') }} </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function redirectToProject(projectId) {
            window.location.href = "{{ url('user/projects') }}/" + projectId;
        }
    </script>
@endsection

@extends('layouts.master')
@section('title', 'Employee KPI Reports')

@section('content')
    <h2 class="text-center">Employee KPI Reports</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Search Form in Panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Filter Employee</strong>
        </div>
        <div class="panel-body">
            <form method="GET" action="{{ route('user.reports.index') }}">
                <div class="row">
                    <div class="mt-3 col-sm-3">
                        <label for="user_id" class="control-label">Select Employee:</label>
                    </div>
                    <div class="mt-3 col-sm-7">
                        <select name="user_id" id="user_id" class="form-control input-sm">
                            <option value="" disabled selected>-- All --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3 col-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- KPI Report Table in Panel -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <strong>KPI Report</strong>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Total KPI</th>
                            <th>Total Tasks</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ $report->assignedUser->id }}</td>
                                <td>{{ $report->assignedUser->name }}</td>
                                <td>{{ number_format($report->total_kpi, 2) }}</td>
                                <td>{{ $report->total_tasks }}</td>
                                <td>
                                    <a href="{{ route('user.reports.user', $report->assigned_to) }}"
                                        class="btn btn-info btn-xs">
                                        View KPI Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- q-read: Phân trang --}}
            <div class="text-center">{{ $reports->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#user_id').select2({
                placeholder: 'Select an Employee',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

@section('styles')
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

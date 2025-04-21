@extends('layouts.master')
@section('title', 'Employee KPI Dashboard')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="jumbotron text-center">
        <h2>Employee KPI Reports</h2>
        <p>{{ $quoteOfTheDay }}</p>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="thumbnail text-center">
                <h1>User: {{ $user->name }}</h1>
            </div>
        </div>
    </div>

    <!-- Bộ lọc nhân viên -->
    <div class="well">
        <form method="GET" action="{{ route('user.dashboard') }}">
            @foreach (request()->except('search') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <label for="user_id">Select Employee:</label>
            <select name="user_id" id="user_id" class="form-control">
                <option value="" disabled selected></option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $selectedUser == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-block mt-2">Search</button>
        </form>
    </div>

    <!-- Thống kê KPI cá nhân -->
    @if ($selectedUser != 1)
        <div class="row">
            <div class="col-sm-4">
                <div class="thumbnail text-center">
                    <h3>Total KPI Last Month</h3>
                    <p>{{ $kpiData['total_kpi'] }}</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumbnail text-center">
                    <h3>Total Tasks Last Month</h3>
                    <p>{{ $kpiData['total_tasks'] }}</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumbnail text-center">
                    <h3>Performance Score Last Month</h3>
                    <p>{{ $kpiData['performance_score'] }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Xếp hạng KPI -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">🏆 Top Employees KPI (All Time)</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total KPI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rankings as $employee)
                            <tr class="{{ $employee->id == $selectedUser ? 'success' : '' }}">
                                <td>{{ $employee->rank }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ round($employee->total_kpi, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{-- {{ $rankings->appends(request()->query())->links('pagination::bootstrap-4') }} --}}
                {{-- {{ $rankings->appends(request()->query())->links('layouts.partial.custom-paginator') }} --}}
                {{ $rankings->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">📅 Top Employees KPI (This Month)</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total KPI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyRankings as $employee)
                            <tr class="{{ $employee->id == $selectedUser ? 'success' : '' }}">
                                <td>{{ $employee->rank }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ round($employee->total_kpi, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{-- {{ $monthlyRankings->appends(request()->query())->links('pagination::simple-bootstrap-4') }} --}}
                {{-- {{ $monthlyRankings->appends(request()->query())->links('layouts.partial.custom-paginator') }} --}}
                {{ $monthlyRankings->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    </div>

    @if ($selectedUser != 1)
        <div class="alert alert-info text-center">
            <h4>📊 Your Rank: #{{ $userRank }} (All Time) | #{{ $userMonthlyRank }} (This Month)</h4>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 10000
                };
                toastr.success("{{ $quoteOfTheDay }}", 'Daily Motivation');
            }, 1300);

            $('#user_id').select2({
                placeholder: 'Select a User',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

@section('styles')
    <link href="{{ asset('assets/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@extends('layouts.master')
@section('title', "KPI Report for {$user->name}")

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">KPI Report for "{{ $user->name }}"</h3>
        </div>
        <div class="panel-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('user.reports.user', $user->id) }}" class="mb-3">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="month">Month:</label>
                        <select name="month" id="month" class="form-control input-sm">
                            <option value="">-- Select Month --</option> {{-- Giá trị mặc định --}}
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    Month {{ $m }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="year">Year:</label>
                        <select name="year" id="year" class="form-control input-sm">
                            <option value="">-- Select Year --</option> {{-- Giá trị mặc định --}}
                            {{-- Viêc trừ đi 5 là giới hạn số năm báo cáo trong vòng 5 năm về trước, tránh việc báo cáo quá nhiều năm --}}
                            {{-- Nếu muốn báo cáo nhiều năm hơn thì tăng số năm bị trừ đi, vì trừ là tương tương số năm hiện tại trừ đi về trước --}}
                            @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 25px;">Filter</button>
                        <a href="{{ route('user.reports.user', $user->id) }}" class="btn btn-default btn-sm"
                            style="margin-top: 25px;">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">KPI and Task List</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Task</th>
                            <th>Completion Date</th>
                            <th>KPI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($report as $r)
                            <tr class="active">
                                <td colspan="3"><strong>{{ $r->period }}</strong></td>
                                <td><strong>{{ number_format($r->total_kpi, 2) }}</strong></td>
                            </tr>
                            @foreach ($tasks as $task)
                                {{-- q-read: Lọc task theo tháng --}}
                                @if (date('Y-m', strtotime($task->first_completed_at)) == $r->period)
                                    @php $hasTask = true; @endphp
                                    <tr>
                                        <td></td>
                                        <td><a href="{{ route('user.tasks.show', $task->id) }}">{{ $task->name }}</a>
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($task->first_completed_at)) }}</td>
                                        <td>{{ number_format($task->bill, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach

                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Không có task nào!</td>
                            </tr>
                        @endforelse

                        <tr>
                            <td colspan="4"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#month').select2({
                allowClear: true,
                width: '100%',
                placeholder: '-- Select Month --'
            });

            $('#year').select2({
                allowClear: true,
                width: '100%',
                placeholder: '-- Select Year --'
            });
        });
    </script>
@endsection

@section('styles')
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

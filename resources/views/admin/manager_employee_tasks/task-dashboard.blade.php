@extends('layouts.app')

@section('title', 'Visual Productivity Dashboard')

@section('content')

    <style>

        .dashboard-title {

            background: #1f4e78;
            color: #fff;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            padding: 12px;
            margin-bottom: 15px;
        }

        .dashboard-subtitle {

            text-align: center;
            color: #777;
            margin-bottom: 20px;
        }

        .kpi-card {

            border-radius: 0;
            border: 1px solid #cfcfcf;
            box-shadow: none;
        }

        .kpi-header {

            color: #fff;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            padding: 6px;
        }

        .kpi-value {

            text-align: center;
            font-size: 38px;
            font-weight: bold;
            padding-top: 15px;
        }

        .kpi-footer {

            text-align: center;
            color: #666;
            font-size: 12px;
            padding-bottom: 10px;
        }

        .blue {
            background: #1f4e78;
        }

        .orange {
            background: #c88719;
        }

        .green {
            background: #2e7d32;
        }

        .gold {
            background: #d39e00;
        }

        .filter-box {

            margin-bottom: 20px;
        }

    </style>

    <div class="container-fluid">

        <div class="dashboard-title">

            VISUAL DASHBOARD — Team Productivity at a Glance

        </div>

        <div class="dashboard-subtitle">

            {{ \Carbon\Carbon::parse($month)->format('F Y') }}

        </div>

        <form method="GET">

            <div class="row filter-box">

                <div class="col-md-3">

                    <input type="month" name="month" id="monthFilter" class="form-control" value="{{ $month }}">

                </div>

                <div class="col-md-2">

                    <button class="btn btn-primary w-100">

                        Load Dashboard

                    </button>

                </div>

            </div>

        </form>
        <div id="dashboardContent">
            <div class="row">

                <div class="col-md-3">

                    <div class="card kpi-card">

                        <div class="kpi-header blue">

                            TOTAL HOURS LOGGED

                        </div>

                        <div class="kpi-value text-primary">

                            {{ number_format($totalHours, 0) }}

                        </div>

                        <div class="kpi-footer">

                            Hours Worked

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card kpi-card">

                        <div class="kpi-header blue">

                            TOTAL ACTIVITIES

                        </div>

                        <div class="kpi-value text-primary">

                            {{ $totalActivities }}

                        </div>

                        <div class="kpi-footer">

                            Tasks Logged

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card kpi-card">

                        <div class="kpi-header gold">

                            VERIFICATION COVERAGE

                        </div>

                        <div class="kpi-value text-warning">

                            {{ $verificationCoverage }}%

                        </div>

                        <div class="kpi-footer">

                            Verified Tasks

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card kpi-card">

                        <div class="kpi-header green">

                            DAYS ALIGNED

                        </div>

                        <div class="kpi-value text-success">

                            {{ $daysAligned }}

                        </div>

                        <div class="kpi-footer">

                            Self vs Manager

                        </div>

                    </div>

                </div>

            </div>
        </div>

        {{-- ========================= --}}
        {{-- Chart 1 --}}
        {{-- ========================= --}}

        <div class="row mt-4">
            <div class="col-md-6">
                {{-- ========================= --}}
                {{-- Chart 3 --}}
                {{-- ========================= --}}

                <div class="card">

                    <div class="card-header">

                        Verification Status Of Employee

                    </div>
                    <div class="card-body">
                     <canvas id="verificationChart"></canvas>
                    </div>

                </div>
            </div>

            <div class="col-md-6">

                <div class="card h-100">

                    <div class="card-header">

                        Total Hours Logged Of Employee

                    </div>
                    <div class="card-body">
                      <canvas id="hoursChart" height=""></canvas>
                    </div>

                </div>

            </div>
        </div>


        <div class="card mt-4">

            <div class="card-header bg-primary text-white">

                <strong>EMPLOYEE MONTHLY SUMMARY</strong>

            </div>

            <div class="card-body p-0">

                <table class="table table-bordered table-striped mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>Employee</th>

                            <th>Hours</th>

                            <th>Activities</th>

                            <th>Days Aligned</th>

                            <th>Days Mismatch</th>

                            <th>Awaiting</th>

                            <th>Self Avg</th>

                            <th>Mgr Avg</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($summary as $row)

                            <tr>

                                <td>{{ $row->name }}</td>

                                <td>{{ number_format($row->hours, 1) }}</td>

                                <td>{{ $row->activities }}</td>

                                <td>

                                    <span class="badge bg-success">

                                        {{ $row->aligned }}

                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-danger">

                                        {{ $row->mismatch }}

                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-warning text-dark">

                                        {{ $row->awaiting }}

                                    </span>

                                </td>

                                <td>

                                    {{ round($row->self_avg, 1) }}%

                                </td>

                                <td>

                                    {{ round($row->manager_avg, 1) }}%

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center">

                                    No data available.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

@endsection
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>



            const verification = @json($verification);

            const hoursPerEmployee = @json($hoursPerEmployee);

            /*====================================================
            VERIFICATION
            ====================================================*/

            new Chart(document.getElementById('verificationChart'), {

                type: 'bar',

                data: {

                    labels: verification.map(x => x.name),

                    datasets: [

                        {

                            label: 'Aligned',

                            data: verification.map(x => x.aligned),

                            backgroundColor: '#5CB85C'

                        },

                        {

                            label: 'Mismatch',

                            data: verification.map(x => x.mismatch),

                            backgroundColor: '#D9534F'

                        },

                        {

                            label: 'Awaiting',

                            data: verification.map(x => x.awaiting),

                            backgroundColor: '#F0AD4E'

                        }

                    ]

                },

                options: {

                    responsive: true,

                    indexAxis: 'y',

                    plugins: {

                        legend: { position: 'bottom' }

                    },

                    scales: {

                        x: {

                            stacked: true

                        },

                        y: {

                            stacked: true

                        }

                    }

                }

            });

            /*====================================================
            HOURS
            ====================================================*/

            new Chart(document.getElementById('hoursChart'), {

                type: 'bar',

                data: {

                    labels: hoursPerEmployee.map(x => x.name),

                    datasets: [

                        {

                            label: 'Hours',

                            data: hoursPerEmployee.map(x => x.total_hours),

                            backgroundColor: '#4F81BD'

                        }

                    ]
                },
                options: {
                    responsive: true,
                    plugins: {

                        legend: { display: false }

                    }
                }
            });
           

            $('#monthFilter').change(function () {

                let month = $(this).val();

                $.ajax({

                    url: "{{ route('main.dashboard') }}",

                    data: { month: month },

                    success: function (response) {

                        $('#dashboardContent').html(

                            $(response).find('#dashboardContent').html()

                        );

                    }

                });

            });

        </script>
    @endpush
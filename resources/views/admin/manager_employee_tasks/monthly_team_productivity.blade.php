@extends('layouts.app')

@section('content')

        <style>
            .dashboard-title {
                background: #1f4e78;
                color: #fff;
                font-weight: bold;
                font-size: 22px;
                text-align: center;
                padding: 12px;
                margin-bottom: 15px;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .productivity-table {
                width: 100%;
                border-collapse: collapse;
                white-space: nowrap;
                font-size: 13px;
            }

            .productivity-table th,
            .productivity-table td {

                border: 1px solid #d8d8d8;
                text-align: center;
                padding: 7px;
            }

            .productivity-table thead th {

                background: #d9eaf7;
                font-weight: bold;
            }

            .employee-column {

                min-width: 220px;
                text-align: left !important;
                font-weight: 600;
                background: #eef5fb;
                position: sticky;
                left: 0;
                z-index: 5;
            }

            .section-title {

                background: #1f4e78;
                color: white;
                text-align: center;
                font-weight: bold;
                font-size: 16px;
            }

            .avg-column {

                background: #eef5fb;
                font-weight: bold;
            }

            .rating-column {

                background: #fbe5d6;
                font-weight: bold;
            }

            .score-good {

                background: #c6efce;
                color: #006100;
            }

            .score-average {

                background: #fff2cc;
            }

            .score-low {

                background: #f4cccc;
            }

            .score-empty {

                background: white;
            }

            .month-card {

                background: #f8f9fa;
                border: 1px solid #ddd;
                padding: 15px;
                margin-bottom: 15px;
            }
            .card{

        border-radius:10px;

    }

    .card-header{

        font-size:18px;

        font-weight:bold;

    }

    .table-bordered th{

        background:#eef5fb;

    }

    .badge{

        font-size:14px;

        padding:8px 12px;

    }

    @media(max-width:768px){

    .employee-column{

    min-width:180px;

    }

    .productivity-table{

    font-size:11px;

    }

    }
        </style>

        <div class="container-fluid">

            <div class="dashboard-title">

                MONTHLY TEAM PRODUCTIVITY DASHBOARD

            </div>

            <div class="month-card">

                <form method="GET" action="{{ route('productivity.dashboard') }}">

                    <div class="row">

                        <div class="col-md-3">

                            <label><strong>Select Month</strong></label>

                            <input type="month" name="month" class="form-control" value="{{ $month }}">

                        </div>

                        <div class="col-md-2">

                            <label>&nbsp;</label>

                            <button class="btn btn-primary form-control">

                                Load Dashboard

                            </button>

                        </div>

                        <div class="col-md-3">

                            <label><strong>Working Days</strong></label>

                            <input type="text" class="form-control" readonly value="{{ $daysInMonth }}">

                        </div>

                    </div>

                </form>

            </div>

            <div class="table-responsive">

                <table class="productivity-table">

                    <thead>

                        <tr>

                            <th colspan="{{ $daysInMonth + 3 }}" class="section-title">

                                SELF-REPORTED PRODUCTIVITY — Daily Score Per Employee

                            </th>

                        </tr>

                        <tr>

                            <th class="employee-column">

                                Employee

                            </th>

                            @for($day = 1; $day <= $daysInMonth; $day++)

                                <th>

                                    {{ $day }}

                                </th>

                            @endfor

                            <th class="avg-column">

                                Avg

                            </th>

                            <th class="rating-column">

                                Rating

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($employees as $employee)

                            @php

    $total = 0;

    $count = 0;

                            @endphp

                            <tr>

                                <td class="employee-column">

                                    {{ $employee->name }}

                                </td>

                                @for($day = 1; $day <= $daysInMonth; $day++)

                                    @php

        $score = $selfCalendar[$employee->employee_id][$day] ?? null;

        if ($score !== null) {

            $total += $score;

            $count++;

        }

        $class = 'score-empty';

        if ($score !== null) {

            if ($score >= 80) {

                $class = 'score-good';

            } elseif ($score >= 60) {

                $class = 'score-average';

            } else {

                $class = 'score-low';

            }

        }

                                    @endphp

                                    <td class="{{ $class }}">

                                        @if($score)

                                            {{ $score }}%

                                        @endif

                                    </td>

                                @endfor

                                @php

    $avg = $count ? round($total / $count, 1) : 0;

                                @endphp

                                <td class="avg-column">

                                    {{ $avg }}%

                                </td>

                                <td class="rating-column">

                                    @if($avg >= 90)

                                        Outstanding

                                    @elseif($avg >= 80)

                                        Excellent

                                    @elseif($avg >= 70)

                                        Good

                                    @elseif($avg >= 60)

                                        Satisfactory

                                    @elseif($avg >= 40)

                                        Needs Improvement

                                    @else

                                        Poor

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- ============================= --}}
            {{-- MANAGER VERIFIED PRODUCTIVITY --}}
            {{-- ============================= --}}

            <br>
            <br>

            <div class="table-responsive">

                <table class="productivity-table">

                    <thead>

                        <tr>

                            <th colspan="{{ $daysInMonth + 3 }}" class="section-title">

                                MANAGER-VERIFIED PRODUCTIVITY — Daily Score Per Employee

                            </th>

                        </tr>

                        <tr>

                            <th class="employee-column">

                                Employee

                            </th>

                            @for ($day = 1; $day <= $daysInMonth; $day++)

                                <th>{{ $day }}</th>

                            @endfor

                            <th class="avg-column">

                                Avg

                            </th>

                            <th class="rating-column">

                                Rating

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($employees as $employee)

                            @php

    $total = 0;
    $count = 0;

                            @endphp

                            <tr>

                                <td class="employee-column">

                                    {{ $employee->name }}

                                </td>

                                @for ($day = 1; $day <= $daysInMonth; $day++)

                                    @php

        $score = $managerCalendar[$employee->employee_id][$day] ?? null;

        if ($score !== null) {
            $total += $score;
            $count++;
        }

        $class = 'score-empty';

        if ($score !== null) {

            if ($score >= 80) {

                $class = 'score-good';

            } elseif ($score >= 60) {

                $class = 'score-average';

            } else {

                $class = 'score-low';

            }

        }

                                    @endphp

                                    <td class="{{ $class }}">

                                        @if ($score !== null)

                                            {{ $score }}%

                                        @endif

                                    </td>

                                @endfor

                                @php

    $avg = $count ? round($total / $count, 1) : 0;

                                @endphp

                                <td class="avg-column">

                                    {{ $avg }}%

                                </td>

                                <td class="rating-column">

                                    @if ($avg >= 90)

                                        Outstanding

                                    @elseif($avg >= 80)

                                        Excellent

                                    @elseif($avg >= 70)

                                        Good

                                    @elseif($avg >= 60)

                                        Satisfactory

                                    @elseif($avg >= 40)

                                        Needs Improvement

                                    @else

                                        Poor

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
            <br>
            <br>

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <strong>DEPARTMENT MONTHLY SNAPSHOT</strong>

                </div>

                <div class="card-body p-0">

                    <table class="table table-bordered mb-0">

                        <tbody>

                            <tr>

                                <th width="35%">Top Performer (Self)</th>

                                <td>

                                    {{ optional($topSelf)->name ?? '-' }}

                                </td>

                            </tr>

                            <tr>

                                <th>Top Performer (Manager Verified)</th>

                                <td>

                                    {{ optional($topManager)->name ?? '-' }}

                                </td>

                            </tr>

                            <tr>

                                <th>Department Avg — Self</th>

                                <td>

                                    {{ $departmentSelfAverage }}%

                                </td>

                            </tr>

                            <tr>

                                <th>Department Avg — Manager</th>

                                <td>

                                    {{ $departmentManagerAverage }}%

                                </td>

                            </tr>

                            <tr>

                                <th>Total Hours Logged</th>

                                <td>

                                    {{ number_format($totalHours, 2) }}

                                </td>

                            </tr>

                            <tr>

                                <th>Total Activities</th>

                                <td>

                                    {{ $totalActivities }}

                                </td>

                            </tr>

                            <tr>

                                <th>Total Days Aligned</th>

                                <td>

                                    <span class="badge bg-success">

                                        {{ $totalAligned }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>Total Days Mismatch</th>

                                <td>

                                    <span class="badge bg-danger">

                                        {{ $totalMismatch }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>Awaiting Verification</th>

                                <td>

                                    <span class="badge bg-warning text-dark">

                                        {{ $awaitingVerification }}

                                    </span>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <br><br>

@endsection
<script>

    document.querySelector('input[name="month"]')
        .addEventListener('change', function () {

            this.form.submit();

        });

</script>
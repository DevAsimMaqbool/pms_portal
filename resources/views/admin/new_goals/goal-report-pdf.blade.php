<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Employees Goals Report</title>

    <style>
        @page {
            size: A4;
            margin: 105px 12px 35px 12px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            line-height: 1.45;
            color: #253449;
        }

        .primary {
            color: #1f4e79;
        }

        .muted {
            color: #718096;
        }

        /* Fixed header: repeats on every page */
        .fixed-header {
            position: fixed;
            top: -82px;
            left: 12px;
            right: 12px;
            height: 70px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px solid #b78116;
        }

        .header-table td {
            padding: 5px 0 10px;
            vertical-align: middle;
        }

        .title-cell {
            width: 80%;
        }

        .logo-cell {
            width: 20%;
            text-align: right;
        }

        .report-title {
            margin: 0 0 4px;
            color: #173a5c;
            font-size: 19px;
            font-weight: bold;
        }

        .report-subtitle {
            color: #718096;
            font-size: 8px;
        }

        .report-logo {
            max-width: 75px;
            max-height: 55px;
        }

        .page {
            width: 100%;
        }

        /* Report information */
        .info-card {
            width: 100%;
            margin-bottom: 14px;
            padding: 10px;
            background: #f5f8fc;
            border: 1px solid #dfe6ee;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .info-table td {
            width: 50%;
            padding: 4px 6px;
            vertical-align: top;
        }

        .info-label {
            margin-bottom: 2px;
            color: #718096;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .info-value {
            color: #253449;
            font-size: 9px;
            font-weight: bold;
            word-wrap: break-word;
        }

        /* Section heading */
        .section-title {
            padding: 8px 10px;
            margin-bottom: 7px;
            background: #1f4e79;
            border-left: 5px solid #b78116;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
        }

        .section-subtitle {
            padding: 6px 9px;
            margin-bottom: 8px;
            background: #edf4fa;
            border: 1px solid #d8e4ef;
            color: #1f4e79;
            font-size: 8px;
            font-weight: bold;
        }

        /* Driver group */
        .driver-heading {
            padding: 7px 9px;
            margin-top: 12px;
            background: #1f4e79;
            border-left: 4px solid #b78116;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
        }

        .driver-count {
            color: #f3d58a;
            font-size: 7px;
            font-weight: normal;
        }

        /* Goal table */
        table.goal-table {
            width: 100%;
            margin: 0 0 10px;
            border-collapse: collapse;
            table-layout: fixed;
            page-break-inside: auto;
        }

        .goal-table thead {
            display: table-header-group;
        }

        .goal-table tr {
            page-break-inside: avoid;
        }

        .goal-table th {
            padding: 7px 5px;
            background: #edf4fa;
            border: 1px solid #d7dee8;
            border-bottom: 2px solid #b78116;
            color: #1f4e79;
            font-size: 7px;
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .goal-table td {
            padding: 7px 5px;
            border: 1px solid #d7dee8;
            color: #344256;
            font-size: 7.5px;
            line-height: 1.5;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .goal-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .goal-name {
            color: #173a5c;
            font-size: 8px;
            font-weight: bold;
        }

        .target-text {
            padding: 5px;
            background: #f5f8fc;
            border-left: 2px solid #1f4e79;
            color: #253449;
        }

        .progress-box {
            padding: 5px;
            background: #fffaf0;
            border-left: 2px solid #b78116;
            color: #344256;
        }

        .owner-name {
            color: #1f4e79;
            font-weight: bold;
        }

        .empty {
            padding: 18px;
            background: #f8fafc;
            border: 1px solid #dfe6ee;
            color: #718096;
            text-align: center;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: -23px;
            left: 0;
            right: 0;
            padding-top: 5px;
            border-top: 1px solid #dfe5ec;
            color: #718096;
            font-size: 7px;
            text-align: center;
        }

        .footer strong {
            color: #1f4e79;
        }
    </style>
</head>

<body>

    {{-- FIXED HEADER --}}

    <div class="fixed-header">
        <table class="header-table">
            <tr>
                <td class="title-cell">
                    <div class="report-title">
                        Employee Performance Report
                    </div>

                    <div class="report-subtitle">
                        Performance Goals &amp; S2R Driver Alignment
                    </div>
                </td>

                <td class="logo-cell">
                    {{-- <img
                        src="{{ public_path('images/sup-logo.png') }}"
                        class="report-logo"
                        alt="Institution Logo"
                    > --}}
                </td>
            </tr>
        </table>
    </div>

    {{-- FIXED FOOTER --}}

    <div class="footer">
        <strong>All Employees Goals Report</strong>
        &nbsp; | &nbsp;
        Manager: {{ $currentUser->name ?? '—' }}
        &nbsp; | &nbsp;
        Generated: {{ $reportDate }}
    </div>

    <div class="page">

        {{-- REPORT INFORMATION --}}

        <div class="info-card">
            <table class="info-table">
                <tr>
                    <td>
                        <div class="info-label">Reporting Manager</div>
                        <div class="info-value">
                            {{ $currentUser->name ?? '—' }}
                        </div>
                    </td>

                    <td>
                        <div class="info-label">Report Generated</div>
                        <div class="info-value">
                            {{ $reportDate }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="info-label">Employees</div>
                        <div class="info-value">
                            {{ $groupedGoals->flatten(1)->pluck('user_id')->unique()->count() }}
                        </div>
                    </td>

                    <td>
                        <div class="info-label">Total Goals</div>
                        <div class="info-value">
                            {{ $groupedGoals->sum(fn ($goals) => $goals->count()) }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- GOALS SECTION --}}

        <div class="section-title">
            Goals &amp; Progress Overview
        </div>

        <div class="section-subtitle">
            Goals are grouped by their assigned S2R Driver.
        </div>

        @forelse ($groupedGoals as $driverId => $driverGoals)

            @php
                $firstGoal = $driverGoals->first();

                $driverName = $firstGoal->s2rDriver->driver_name
                    ?? 'No Driver Assigned';
            @endphp

            {{-- DRIVER GROUP HEADING --}}

            <div class="driver-heading">
                {{ $driverName }}

                <span class="driver-count">
                    &nbsp; | &nbsp;
                    {{ $driverGoals->count() }}
                    {{ $driverGoals->count() === 1 ? 'Goal' : 'Goals' }}
                </span>
            </div>

            {{-- GOALS TABLE --}}

            <table class="goal-table">
                <thead>
                    <tr>
                        <th style="width: 7%; text-align: center;">
                            No.
                        </th>

                        <th style="width: 27%;">
                            Goal
                        </th>

                        <th style="width: 22%;">
                            Goal Target
                        </th>

                        <th style="width: 24%;">
                            Achieved / Progress
                        </th>

                        <th style="width: 20%;">
                            Owner
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($driverGoals as $goalIndex => $goal)
                        <tr>
                            <td style="text-align: center;">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="goal-name">
                                    {{ $goal->goal ?? '—' }}
                                </div>
                            </td>

                            <td>
                                @if (filled($goal->target))
                                    <div class="target-text">
                                        {{ $goal->target }}
                                    </div>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>

                            <td>
                                @if (filled($goal->latestSelfReport?->progress_against_goal))
                                    <div class="progress-box">
                                        {{ $goal->latestSelfReport->progress_against_goal }}
                                    </div>
                                @else
                                    <span class="muted">
                                        No progress reported.
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span class="owner-name">
                                    {{ $goal->user->name ?? '—' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @empty
            <div class="empty">
                No goals found for employees reporting to this manager.
            </div>
        @endforelse

    </div>

</body>
</html>
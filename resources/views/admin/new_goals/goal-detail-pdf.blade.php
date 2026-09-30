<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>
        Performance Evaluation Report
    </title>

    <style>

        @page {
            margin: 28px 30px 35px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #253449;
            font-size: 9px;
            line-height: 1.45;
            margin: 0;
            padding: 0;
        }

        /* =========================================================
           COLORS
        ========================================================= */

        .primary {
            color: #1f4e79;
        }

        .gold {
            color: #b78116;
        }

        .muted {
            color: #718096;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .report-header {
            border-bottom: 3px solid #b78116;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .report-title {
            font-size: 20px;
            font-weight: bold;
            color: #173a5c;
            margin: 0 0 4px 0;
        }

        .report-subtitle {
            font-size: 9px;
            color: #718096;
        }

        /* =========================================================
           EMPLOYEE CARD
        ========================================================= */

        .employee-card {
            width: 100%;
            border: 1px solid #dfe6ee;
            background: #f5f8fc;
            padding: 11px;
            margin-bottom: 15px;
        }

        .employee-table {
            width: 100%;
            border-collapse: collapse;
        }

        .employee-table td {
            width: 25%;
            padding: 5px 7px;
            vertical-align: top;
        }

        .employee-label {
            color: #718096;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .employee-value {
            color: #253449;
            font-size: 9px;
            font-weight: bold;
        }

        /* =========================================================
           SUMMARY
        ========================================================= */

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px 0;
            margin: 0 -6px 16px -6px;
        }

        .summary-card {
            border: 1px solid #dfe6ee;
            background: #ffffff;
            padding: 9px;
            text-align: center;
        }

        .summary-label {
            font-size: 7px;
            color: #718096;
            text-transform: uppercase;
            font-weight: bold;
        }

        .summary-value {
            font-size: 17px;
            font-weight: bold;
            color: #1f4e79;
            margin-top: 3px;
        }

        /* =========================================================
           SECTION
        ========================================================= */

        .section {
            margin-top: 15px;
        }

        .section-title {
            background: #1f4e79;
            color: #ffffff;
            padding: 8px 10px;
            font-size: 11px;
            font-weight: bold;
            border-left: 5px solid #b78116;
        }

        .section-subtitle {
            background: #edf4fa;
            color: #1f4e79;
            padding: 6px 10px;
            font-size: 8px;
            font-weight: bold;
            border: 1px solid #d8e4ef;
            border-top: 0;
            margin-bottom: 8px;
        }

        /* =========================================================
           GOAL TABLE
        ========================================================= */

        table.goal-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .goal-table th {
            background: #edf1f6;
            color: #526174;
            border: 1px solid #d7dee8;
            padding: 7px 5px;
            font-size: 7.5px;
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
        }

        .goal-table td {
            border: 1px solid #d7dee8;
            padding: 7px 5px;
            vertical-align: top;
            font-size: 8px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .goal-table tr:nth-child(even) td {
            background: #fbfcfe;
        }

        /* =========================================================
           GOAL
        ========================================================= */

        .goal-number {
            display: inline-block;
            background: #1f4e79;
            color: #ffffff;
            font-weight: bold;
            padding: 3px 6px;
            margin-right: 4px;
            font-size: 7px;
        }

        .goal-name {
            color: #173a5c;
            font-weight: bold;
            font-size: 8.5px;
        }

        .goal-objective {
            color: #718096;
            font-size: 7.5px;
            margin-top: 4px;
        }

        /* =========================================================
           TARGET
        ========================================================= */

        .target-text {
            color: #253449;
            font-weight: 600;
        }

        .deadline {
            margin-top: 5px;
            font-size: 7px;
            color: #718096;
        }

        /* =========================================================
           PROGRESS
        ========================================================= */

        .progress-label {
            font-size: 7px;
            color: #718096;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .progress-text {
            color: #1f4e79;
            font-weight: 600;
            font-size: 8px;
        }

        /* =========================================================
           RATINGS
        ========================================================= */

        .rating {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            color: #1f4e79;
        }

        .manager-rating {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            color: #b78116;
        }

        .rating-max {
            font-size: 7px;
            color: #718096;
            font-weight: normal;
        }

        /* =========================================================
           MANAGER REMARKS
        ========================================================= */

        .manager-remarks {
           
            font-size: 7.8px;
        }

        .no-remark {
            color: #a0aec0;
            font-style: italic;
        }

        /* =========================================================
           EMPTY
        ========================================================= */

        .empty {
            padding: 18px;
            text-align: center;
            color: #718096;
            background: #f8fafc;
            border: 1px solid #e0e6ed;
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            margin-top: 18px;
            padding-top: 8px;
            border-top: 1px solid #dfe5ec;
            text-align: center;
            color: #718096;
            font-size: 7px;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

    </style>

</head>

<body>

<div class="page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="report-header">

        <div class="report-title">
            Performance Evaluation Report
        </div>

        <div class="report-subtitle">
            Performance Goals &amp; Manager Evaluation — FY 2025-2026
        </div>

    </div>

    {{-- =========================================================
         EMPLOYEE INFORMATION
    ========================================================== --}}

    <div class="employee-card">

        <table class="employee-table">

            <tr>

                <td>

                    <div class="employee-label">
                        Employee
                    </div>

                    <div class="employee-value">
                        {{ $user->name ?? '—' }}
                    </div>

                </td>

                <td>

                    <div class="employee-label">
                        Employee Code
                    </div>

                    <div class="employee-value">
                        {{ $user->barcode ?? $user->employee_id ?? '—' }}
                    </div>

                </td>

                <td>

                    <div class="employee-label">
                        Designation
                    </div>

                    <div class="employee-value">
                        {{ $user->job_title ?? '—' }}
                    </div>

                </td>

                <td>

                    <div class="employee-label">
                        Department
                    </div>

                    <div class="employee-value">
                        {{ $user->department ?? '—' }}
                    </div>

                </td>

            </tr>

            <tr>

                <td colspan="2">

                    <div class="employee-label">
                        Reporting Manager
                    </div>

                    <div class="employee-value">
                        {{ $user->manager_name ?? '—' }}
                    </div>

                </td>

                <td colspan="2">

                    <div class="employee-label">
                        Report Generated
                    </div>

                    <div class="employee-value">
                        {{ now()->format('d M Y, h:i A') }}
                    </div>

                </td>

            </tr>

        </table>

    </div>

    {{-- =========================================================
         SUMMARY
    ========================================================== --}}

    {{-- =========================================================
         GOALS
    ========================================================== --}}

    <div class="section">

        <div class="section-title">
            Goals &amp; Manager Evaluation
        </div>

        <div class="section-subtitle">
            Complete list of employee goals with latest progress,
            employee rating and manager evaluation.
        </div>

        @if($reports->count())

            <table class="goal-table">

                <thead>

                <tr>

                    <th style="width:22%;">
                        Goal
                    </th>

                    <th style="width:16%;">
                        Goal Target
                    </th>

                    <th style="width:22%;">
                        Goal Progress
                    </th>

                    <th style="width:9%; text-align:center;">
                        Goal Rating
                    </th>

                    <th style="width:20%;">
                        Manager Remarks
                    </th>

                    <th style="width:11%; text-align:center;">
                        Manager Rating
                    </th>

                </tr>

                </thead>

                <tbody>

                @foreach($reports as $index => $goal)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | LATEST SELF REPORT
                        |--------------------------------------------------------------------------
                        */

                        $report =
                            $goal->latest_self_report;

                        /*
                        |--------------------------------------------------------------------------
                        | MANAGER REVIEW
                        |--------------------------------------------------------------------------
                        */

                        $managerReview =
                            $goal->latest_manager_review;

                        /*
                        |--------------------------------------------------------------------------
                        | PROGRESS
                        |--------------------------------------------------------------------------
                        |
                        | IMPORTANT:
                        | Progress comes ONLY from
                        | GoalSelfReport.progress_against_goal
                        |
                        */

                        $progress =
                            $report->progress_against_goal
                            ?? null;

                        /*
                        |--------------------------------------------------------------------------
                        | MANAGER REMARKS
                        |--------------------------------------------------------------------------
                        */

                        $managerRemarks =
                            $goal->manager_remarks
                            ?? null;

                    @endphp

                    <tr class="avoid-break">

                        {{-- =================================================
                             GOAL
                        ================================================== --}}

                        <td>

                            <div>

                                <span class="goal-number">
                                    {{ $index + 1 }}
                                </span>

                                <span class="goal-name">
                                    {{ $goal->goal ?? '—' }}
                                </span>

                            </div>

                            @if(!empty($goal->objectives))

                                <div class="goal-objective">

                                    <strong>
                                        Objective:
                                    </strong>

                                    {{ $goal->objectives }}

                                </div>

                            @endif

                            @if($goal->s2rDriver)

                                <div
                                    style="
                                        margin-top:5px;
                                        font-size:7px;
                                        color:#718096;
                                    "
                                >

                                    <strong class="primary">
                                        S2R:
                                    </strong>

                                    {{ $goal->s2rDriver->driver_name ?? '—' }}

                                </div>

                            @endif

                        </td>

                        {{-- =================================================
                             TARGET
                        ================================================== --}}

                        <td>

                            @if(!empty($goal->target))

                                <div class="target-text">
                                    {{ $goal->target }}
                                </div>

                            @else

                                <span class="muted">
                                    —
                                </span>

                            @endif

                        </td>

                        {{-- =================================================
                             PROGRESS
                        ================================================== --}}

                        <td>

                            @if(filled($progress))

                                <div class="progress-box">

                                        {{ $progress }}
                                    
                                </div>

                            @else

                                <span class="no-remark">
                                    No progress reported.
                                </span>

                            @endif

                        </td>

                        {{-- =================================================
                             GOAL RATING
                        ================================================== --}}

                        <td style="text-align:center;">

                            @if(
                                $report &&
                                $report->rating !== null &&
                                $report->rating !== ''
                            )

                                <div class="rating">

                                    {{ $report->rating }}

                                    <span class="rating-max">
                                        / 5
                                    </span>

                                </div>

                            @else

                                <span class="muted">
                                    —
                                </span>

                            @endif

                        </td>

                        {{-- =================================================
                             MANAGER REMARKS
                        ================================================== --}}

                        <td>

                            @if(filled($managerRemarks))

                                <div class="manager-remarks">

                                    {{ $managerRemarks }}

                                </div>

                            @endif

                        </td>

                        {{-- =================================================
                             MANAGER RATING
                        ================================================== --}}

                        <td style="text-align:center;">

                            @if(
                                $report &&
                                $report->manager_rating !== null &&
                                $report->manager_rating !== ''
                            )

                                <div class="manager-rating">

                                    {{ $report->manager_rating }}

                                    <span class="rating-max">
                                        / 5
                                    </span>

                                </div>

                            @else

                                <span class="muted">
                                    / 5
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        @else

            <div class="empty">

                No goals have been created for this employee.

            </div>

        @endif

    </div>

    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <div class="footer">

        Performance Goals Report — FY 2025-2026

        <br>

        {{ $user->name ?? 'Employee' }}

        &nbsp;|&nbsp;

        Auto Generated on
        {{ now()->format('d M Y, h:i A') }}

    </div>

</div>

</body>

</html>
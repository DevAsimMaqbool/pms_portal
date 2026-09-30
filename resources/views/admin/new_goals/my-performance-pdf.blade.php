<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Performance Appraisal Report</title>

    <style>

        @page {
            margin: 25px 28px 32px 28px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #253449;
            font-size: 9px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .page {
            width: 100%;
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
            border-bottom: 2px solid #b78116;
            padding-bottom: 10px;
            margin-bottom: 13px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-left {
            width: 72%;
            vertical-align: bottom;
        }

        .header-right {
            width: 28%;
            text-align: right;
            vertical-align: bottom;
        }

        .report-title {
            font-size: 19px;
            font-weight: bold;
            color: #173a5c;
            margin: 0;
        }

        .report-subtitle {
            margin-top: 3px;
            color: #718096;
            font-size: 8.5px;
        }

        .report-period {
            display: inline-block;
            border: 1px solid #d8e2ec;
            background: #f6f8fb;
            padding: 5px 8px;
            color: #1f4e79;
            font-size: 8px;
            font-weight: bold;
        }

        /* =========================================================
           EMPLOYEE INFORMATION
        ========================================================= */

        .employee-card {
            border: 1px solid #d9e1ea;
            background: #f7f9fc;
            margin-bottom: 13px;
        }

        .employee-heading {
            background: #1f4e79;
            color: #ffffff;
            padding: 6px 9px;
            font-size: 9px;
            font-weight: bold;
            border-left: 4px solid #b78116;
        }

        .employee-table {
            width: 100%;
            border-collapse: collapse;
        }

        .employee-table td {
            width: 25%;
            padding: 7px 9px;
            vertical-align: top;
            border-right: 1px solid #e2e7ed;
        }

        .employee-table td:last-child {
            border-right: none;
        }

        .employee-table tr + tr td {
            border-top: 1px solid #e2e7ed;
        }

        .employee-label {
            color: #7a8796;
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
           SCORE SUMMARY
        ========================================================= */

        .score-heading {
            color: #173a5c;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .score-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 5px 0;
            margin-left: -5px;
            margin-right: -5px;
            margin-bottom: 14px;
        }

        .score-card {
            width: 20%;
            border: 1px solid #dce3ea;
            background: #ffffff;
            text-align: center;
            padding: 8px 5px;
            vertical-align: middle;
        }

        .score-label {
            color: #7a8796;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .score-value {
            color: #1f4e79;
            font-size: 16px;
            font-weight: bold;
            margin-top: 3px;
        }

        .score-weight {
            color: #8a96a3;
            font-size: 6.5px;
            margin-top: 2px;
        }

        .score-manager {
            border-top: 3px solid #c47f00;
        }

        .score-manager .score-value {
            color: #a86600;
        }

        .score-feedback {
            border-top: 3px solid #7b61a8;
        }

        .score-feedback .score-value {
            color: #70559a;
        }

        .score-total {
            border-top: 3px solid #1f4e79;
            background: #f5f8fc;
        }

        .score-total .score-value {
            color: #173a5c;
            font-size: 18px;
        }

        .score-hr {
            border-top: 3px solid #2f855a;
        }

        .score-hr .score-value {
            color: #287a4b;
        }

        .score-final {
            border: 1px solid #b78116;
            border-top: 3px solid #b78116;
            background: #fffaf0;
        }

        .score-final .score-value {
            color: #9b6a0e;
            font-size: 18px;
        }

        /* =========================================================
           SECTION
        ========================================================= */

        .section {
            margin-top: 14px;
            page-break-inside: auto;
        }

        .section-title {
            background: #1f4e79;
            color: #ffffff;
            padding: 7px 9px;
            font-size: 10px;
            font-weight: bold;
            border-left: 4px solid #b78116;
        }

        .section-subtitle {
            background: #f2f6fa;
            color: #617184;
            padding: 5px 9px;
            font-size: 7.5px;
            border: 1px solid #dce5ed;
            border-top: none;
        }

        /* =========================================================
           TABLE
        ========================================================= */

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .report-table th {
            background: #eef2f6;
            color: #4e5d6d;
            border: 1px solid #d6dee7;
            padding: 6px 5px;
            font-size: 7px;
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
        }

        .report-table td {
            border: 1px solid #dce3ea;
            padding: 6px 5px;
            vertical-align: top;
            font-size: 7.8px;
            line-height: 1.35;
        }

        .report-table tr:nth-child(even) td {
            background: #fafbfd;
        }

        .report-table strong {
            color: #253449;
        }

        /* =========================================================
           BADGES
        ========================================================= */

        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 6.5px;
            font-weight: bold;
            border-radius: 8px;
        }

        .badge-blue {
            background: #e8f1f8;
            color: #1f4e79;
        }

        .badge-green {
            background: #e7f4ec;
            color: #287a4b;
        }

        .badge-orange {
            background: #fff2dc;
            color: #a76000;
        }

        .badge-red {
            background: #fdecec;
            color: #b42318;
        }

        .badge-gray {
            background: #edf0f3;
            color: #5e6b78;
        }

        /* =========================================================
           SCORE INLINE
        ========================================================= */

        .inline-score {
            color: #1f4e79;
            font-weight: bold;
        }

        .manager-score {
            color: #a86600;
            font-weight: bold;
        }

        /* =========================================================
           FEEDBACK
        ========================================================= */

        .feedback-box {
            border: 1px solid #dce4ec;
            border-left: 4px solid #1f4e79;
            background: #f7f9fb;
            padding: 9px;
            margin-top: 6px;
            font-size: 8px;
            line-height: 1.5;
        }

        .feedback-title {
            color: #1f4e79;
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        /* =========================================================
           VIRTUES
        ========================================================= */

        .virtue-score {
            color: #1f4e79;
            font-weight: bold;
        }

        .virtue-na {
            color: #718096;
        }

        .virtue-summary {
            margin-top: 7px;
            border: 1px solid #dce4ec;
            background: #f7f9fc;
            padding: 7px 9px;
            font-size: 8px;
        }

        /* =========================================================
           INITIATIVES
        ========================================================= */

        .initiative-card {
            border: 1px solid #d9e1e9;
            margin-top: 8px;
            page-break-inside: avoid;
            background: #ffffff;
        }

        .initiative-header {
            background: #f5f8fb;
            border-bottom: 1px solid #dce4eb;
            padding: 7px 9px;
        }

        .initiative-title {
            font-size: 9px;
            font-weight: bold;
            color: #173a5c;
        }

        .initiative-meta {
            width: 100%;
            border-collapse: collapse;
        }

        .initiative-meta td {
            width: 33.33%;
            border-right: 1px solid #e0e6ed;
            border-bottom: 1px solid #e0e6ed;
            padding: 6px 8px;
            vertical-align: top;
        }

        .initiative-meta td:last-child {
            border-right: none;
        }

        .meta-label {
            color: #7b8794;
            font-size: 6.5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .meta-value {
            color: #253449;
            font-size: 7.5px;
            font-weight: bold;
            margin-top: 2px;
        }

        .initiative-description {
            background: #fafbfd;
            border-top: 1px solid #e1e7ed;
            padding: 7px 9px;
            font-size: 7.8px;
            line-height: 1.45;
        }

        .initiative-description strong {
            color: #1f4e79;
        }

        .initiative-manager {
            background: #fffaf2;
        }

        .initiative-manager strong {
            color: #a86600;
        }

        /* =========================================================
           EMPTY
        ========================================================= */

        .empty {
            padding: 10px;
            text-align: center;
            color: #718096;
            background: #f8fafc;
            border: 1px solid #dfe5eb;
            font-size: 8px;
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            margin-top: 18px;
            padding-top: 7px;
            border-top: 1px solid #dfe5ec;
            text-align: center;
            color: #7a8795;
            font-size: 6.5px;
            line-height: 1.5;
        }

        .page-break {
            page-break-before: always;
        }

        .nowrap {
            white-space: nowrap;
        }

        .text-center {
            text-align: center;
        }

    </style>

</head>

<body>

<div class="page">

    {{-- =========================================================
         REPORT HEADER
    ========================================================== --}}

    <div class="report-header">

        <table class="header-table">

            <tr>

                <td class="header-left">

                    <div class="report-title">
                        Performance Appraisal Report
                    </div>

                    <div class="report-subtitle">
                        Employee Performance &amp; Development Summary
                    </div>

                </td>

                <td class="header-right">

                    <span class="report-period">
                        FY 2025–2026
                    </span>

                </td>

            </tr>

        </table>

    </div>

    {{-- =========================================================
         EMPLOYEE INFORMATION
    ========================================================== --}}

    <div class="employee-card">

        <div class="employee-heading">
            Employee Information
        </div>

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
                        {{ $user->barcode ?? '—' }}
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
                        @php
                        $departmentName = $user->hr_department_name;
                        if (str_contains($departmentName, '/')) {
                            $departmentName = trim(last(explode('/', $departmentName)));
                        }
                        @endphp
                        {{ $departmentName ?? '—' }}
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
         SCORE SUMMARY
    ========================================================== --}}

    <div class="score-heading">
        Performance Score Summary
    </div>

    @php

        $managerScore =
            $managerOverallRating !== null
                ? ($managerOverallRating * 20)
                : null;

        $feedbackScore =
            $virtueOverall !== null
                ? $virtueOverall
                : null;

        $weightedTotal =
            ($feedbackScore !== null ? $feedbackScore * 0.30 : 0)
            +
            ($managerScore !== null ? $managerScore * 0.70 : 0);

        $hasWeightedTotal =
            $feedbackScore !== null ||
            $managerScore !== null;

        $hrScore =
            $hrOverallRating !== null
                ? ($hrOverallRating * 20)
                : null;

    @endphp

    <table class="score-table">

        <tr>

            {{-- MANAGER --}}
            <td class="score-card score-manager">

                <div class="score-label">
                    Manager Score
                </div>

                <div class="score-value">
                    {{ $managerScore !== null ? number_format($managerScore, 2) : '—' }}
                </div>

                @if($managerScore !== null)
                    <div class="score-weight">
                        Weightage: 70%
                    </div>
                @endif

            </td>

            {{-- FEEDBACK --}}
            <td class="score-card score-feedback">

                <div class="score-label">
                    Feedback Score
                </div>

                <div class="score-value">
                    {{ $feedbackScore !== null ? number_format($feedbackScore, 2) : '—' }}
                </div>

                @if($feedbackScore !== null)
                    <div class="score-weight">
                        Weightage: 30%
                    </div>
                @endif

            </td>

            {{-- TOTAL --}}
            <td class="score-card score-total">

                <div class="score-label">
                    Weighted Total
                </div>

                <div class="score-value">
                    {{ $hasWeightedTotal ? number_format($weightedTotal, 2) : '—' }}
                </div>

                <div class="score-weight">
                    Manager 70% + Feedback 30%
                </div>

            </td>

            {{-- HR --}}
            <td class="score-card score-hr">

                <div class="score-label">
                    HR Score
                </div>

                <div class="score-value">
                    {{ $hrScore !== null ? number_format($hrScore, 2) : '—' }}
                </div>

            </td>

            {{-- FINAL --}}
            <td class="score-card score-final">

                <div class="score-label">
                    Final Score
                </div>

                <div class="score-value">
                    {{ $hrScore !== null ? number_format($hrScore, 2) : '—' }}
                </div>

                <div class="score-weight">
                    HR Finalization
                </div>

            </td>

        </tr>

    </table>

    {{-- =========================================================
         GOALS
    ========================================================== --}}

    <div class="section">

        <div class="section-title">
            Goals, Self Report &amp; Manager Validation
        </div>

        <div class="section-subtitle">
            Consolidated view of employee goals, progress and management validation
        </div>

        @if($reports->count())

            <table class="report-table">

                <thead>

                <tr>

                    <th style="width:15%;">
                        Goal / Objective
                    </th>

                    <th style="width:11%;">
                        S2R Alignment
                    </th>

                    <th style="width:11%;">
                        Target
                    </th>

                    <th style="width:15%;">
                        Progress
                    </th>

                    <th style="width:7%;">
                        Self Rating
                    </th>

                    <th style="width:7%;">
                        Manager Rating
                    </th>

                    <th style="width:26%;">
                        Manager Comment
                    </th>

                </tr>

                </thead>

                <tbody>

                @foreach($reports as $report)

                    @php

                        $goal = $report->goal;

                        $managerReview = $report->reviews
                            ->where('reviewer_type', 'manager')
                            ->sortByDesc('id')
                            ->first();

                        $decision = $managerReview->decision ?? null;

                        $decisionClass = match ($decision) {
                            'manager_approved' => 'badge-green',
                            'manager_rejected' => 'badge-red',
                            default => 'badge-orange',
                        };

                        $decisionLabel = match ($decision) {
                            'manager_approved' => 'Approved',
                            'manager_rejected' => 'Rejected',
                            default => 'Pending / Reviewed',
                        };

                    @endphp

                    <tr>

                        <td>

                            <strong>
                                {{ $goal->goal ?? '—' }}
                            </strong>

                            @if(!empty($goal->objectives))

                                <div style="margin-top:3px;color:#718096;">
                                    {{ $goal->objectives }}
                                </div>

                            @endif

                        </td>

                        <td>
                            {{ $goal->s2rDriver->driver_name ?? '—' }}
                        </td>

                        <td>
                            {{ $goal->target ?? '—' }}
                        </td>

                        <td>
                            {{ $report->progress_against_goal ?? '—' }}
                        </td>

                        <td class="text-center">

                            <strong class="inline-score">
                                {{ $report->rating ?? '—' }}
                            </strong>

                            @if($report->rating !== null)
                                / 5
                            @endif

                        </td>

                        <td class="text-center">

                            <strong class="manager-score">
                                {{ $report->manager_rating ?? '—' }}
                            </strong>

                            @if($report->manager_rating !== null)
                                / 5
                            @endif

                        </td>

                        <td>

                            @if($managerReview && $managerReview->comments)

                                {{ $managerReview->comments }}

                            @else

                                <span class="muted">
                                    —
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        @else

            <div class="empty">
                No goal self reports have been submitted.
            </div>

        @endif

    </div>

    {{-- =========================================================
         VIRTUE FEEDBACK
    ========================================================== --}}

    <div class="section">

        <div class="section-title">
            Manager Feedback
        </div>

        <div class="section-subtitle">
            Blended Manager / Self / Social / Objective Feedback
        </div>

        <table class="report-table">

            <thead>

            <tr>

                <th>
                    Virtue
                </th>

                <th style="width:25%;">
                    Score (1–100)
                </th>

            </tr>

            </thead>

            <tbody>

            @foreach($virtueScores as $virtue => $score)

                <tr>

                    <td>
                        <strong>
                            {{ $virtue }}
                        </strong>
                    </td>

                    <td>

                        @if($score !== null)

                            <span class="virtue-score">
                                {{ number_format($score, 2) }}
                            </span>

                        @else

                            <span class="virtue-na">
                                —
                            </span>

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

        <div class="virtue-summary">

            <strong>
                Clarity of Purpose:
            </strong>

            <span class="primary">

                @if($virtueOverall !== null)
                    {{ number_format($virtueOverall, 2) }}
                @else
                    —
                @endif

            </span>

        </div>

    </div>

    {{-- =========================================================
         MANAGER OVERALL FEEDBACK
    ========================================================== --}}

    <div class="section">

        <div class="section-title">
            Manager Overall Feedback
        </div>

        @if($managerOverallFeedback)

            <div class="feedback-box">

                <div class="feedback-title">
                    Line Manager
                </div>

                {{ $managerOverallFeedback }}

            </div>

        @else

            <div class="empty">
                No overall manager feedback available.
            </div>

        @endif

    </div>

    {{-- =========================================================
         SPECIAL INITIATIVES
    ========================================================== --}}

    @if($initiatives->count())

        <div class="section page-break">

            <div class="section-title">
                Special Initiatives / Extra Roles
            </div>

            <div class="section-subtitle">
                Additional contributions submitted independently from Goal Management
            </div>

            @foreach($initiatives as $initiative)

                @php

                    $decisionClass = match($initiative->manager_decision) {

                        'approved',
                        'approved_with_amendment'
                            => 'badge-green',

                        'rejected'
                            => 'badge-red',

                        default
                            => 'badge-orange',

                    };

                    $decisionLabel = match($initiative->manager_decision) {

                        'approved'
                            => 'Approved',

                        'approved_with_amendment'
                            => 'Approved with Amendment',

                        'rejected'
                            => 'Rejected',

                        default
                            => 'Pending Validation',

                    };

                @endphp

                <div class="initiative-card">

                    <div class="initiative-header">

                        <span class="initiative-title">
                            {{ $initiative->title }}
                        </span>

                        <span
                            class="badge {{ $decisionClass }}"
                            style="float:right;"
                        >
                            {{ $decisionLabel }}
                        </span>

                    </div>

                    <table class="initiative-meta">

                        <tr>

                            <td>

                                <div class="meta-label">
                                    From Date
                                </div>

                                <div class="meta-value">
                                    {{ optional($initiative->from_date)->format('d M Y') ?? '—' }}
                                </div>

                            </td>

                            <td>

                                <div class="meta-label">
                                    To Date
                                </div>

                                <div class="meta-value">
                                    {{ optional($initiative->to_date)->format('d M Y') ?? '—' }}
                                </div>

                            </td>

                            <td>

                                <div class="meta-label">
                                    Nature
                                </div>

                                <div class="meta-value">

                                    {{ $initiative->nature_of_initiative ?? '—' }}

                                    @if(
                                        $initiative->nature_of_initiative === 'Others'
                                        && $initiative->nature_other
                                    )

                                        — {{ $initiative->nature_other }}

                                    @endif

                                </div>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                <div class="meta-label">
                                    Scope
                                </div>

                                <div class="meta-value">

                                    {{
                                        match($initiative->scope) {
                                            'individual' => 'Individual',
                                            'team_peer' => 'Team / Peer',
                                            'departmental' => 'Departmental',
                                            'faculty_wide' => 'Faculty Wide',
                                            'institution_wide' => 'Institution Wide',
                                            default => '—',
                                        }
                                    }}

                                </div>

                            </td>

                            <td>

                                <div class="meta-label">
                                    Status
                                </div>

                                <div class="meta-value">

                                    {{
                                        ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $initiative->status ?? ''
                                            )
                                        )
                                    }}

                                </div>

                            </td>

                            <td>

                                <div class="meta-label">
                                    Manager
                                </div>

                                <div class="meta-value">

                                    {{
                                        optional($initiative->manager)->name
                                        ?? ($user->manager_name ?? '—')
                                    }}

                                </div>

                            </td>

                        </tr>

                    </table>

                    @if($initiative->description)

                        <div class="initiative-description">

                            <strong>
                                Description
                            </strong>

                            <br>

                            {{ $initiative->description }}

                        </div>

                    @endif

                    @if($initiative->outcome)

                        <div class="initiative-description">

                            <strong>
                                Outcome
                            </strong>

                            <br>

                            {{ $initiative->outcome }}

                        </div>

                    @endif

                    @if($initiative->impact_reach || $initiative->impact_outcome)

                        <div class="initiative-description">

                            <strong>
                                Impact
                            </strong>

                            <br>

                            @if($initiative->impact_reach)

                                <strong>Reach:</strong>
                                {{ $initiative->impact_reach }}

                                <br>

                            @endif

                            @if($initiative->impact_outcome)

                                <strong>Outcome:</strong>
                                {{ $initiative->impact_outcome }}

                            @endif

                        </div>

                    @endif

                    @if($initiative->manager_remarks)

                        <div class="initiative-description initiative-manager">

                            <strong>
                                Manager Remarks
                            </strong>

                            <br>

                            {{ $initiative->manager_remarks }}

                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    @endif

    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <div class="footer">

        Performance Appraisal Report • FY 2025–2026

        <br>

        Auto Generated on
        {{ now()->format('d M Y, h:i A') }}

    </div>

</div>

</body>
</html>
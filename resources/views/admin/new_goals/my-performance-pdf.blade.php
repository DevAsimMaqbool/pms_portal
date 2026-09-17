<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
<title>Performance Appraisal Report</title>

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
        font-size: 10px;
        line-height: 1.45;
        margin: 0;
        padding: 0;
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
        border-bottom: 3px solid #b78116;
        padding-bottom: 12px;
        margin-bottom: 16px;
    }

    .report-title {
        font-size: 21px;
        font-weight: bold;
        color: #173a5c;
        margin: 0 0 4px 0;
    }

    .report-subtitle {
        font-size: 10px;
        color: #718096;
    }

    .employee-card {
        width: 100%;
        border: 1px solid #dfe6ee;
        background: #f5f8fc;
        border-radius: 8px;
        padding: 12px;
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
        font-size: 8px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .employee-value {
        color: #253449;
        font-size: 10px;
        font-weight: bold;
    }

    /* =========================================================
       SCORE CARDS
    ========================================================= */

    .score-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 7px 0;
        margin: 0 -7px 18px -7px;
    }

    .score-card {
        border: 1px solid #dfe6ee;
        background: #fff;
        padding: 10px;
        text-align: center;
        border-radius: 8px;
    }

    .score-label {
        font-size: 8px;
        color: #718096;
        text-transform: uppercase;
        font-weight: bold;
    }

    .score-value {
        font-size: 19px;
        font-weight: bold;
        color: #1f4e79;
        margin-top: 3px;
    }

    .score-manager .score-value {
        color: #c47f00;
    }

    .score-hr .score-value {
        color: #2f855a;
    }

    .score-virtue .score-value {
        color: #7b61a8;
    }

    /* =========================================================
       SECTION
    ========================================================= */

    .section {
        margin-top: 16px;
        page-break-inside: avoid;
    }

    .section-title {
        background: #1f4e79;
        color: #fff;
        padding: 8px 10px;
        font-size: 12px;
        font-weight: bold;
        border-left: 5px solid #b78116;
        margin-bottom: 0;
    }

    .section-subtitle {
        background: #edf4fa;
        color: #1f4e79;
        padding: 6px 10px;
        font-size: 9px;
        font-weight: bold;
        border: 1px solid #d8e4ef;
        border-top: 0;
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
        background: #edf1f6;
        color: #526174;
        border: 1px solid #d7dee8;
        padding: 7px 6px;
        font-size: 8px;
        font-weight: bold;
        text-align: left;
    }

    .report-table td {
        border: 1px solid #d7dee8;
        padding: 7px 6px;
        vertical-align: top;
        font-size: 8.5px;
    }

    .report-table tr:nth-child(even) td {
        background: #fbfcfe;
    }

    /* =========================================================
       BADGES
    ========================================================= */

    .badge {
        display: inline-block;
        padding: 3px 7px;
        border-radius: 12px;
        font-size: 7.5px;
        font-weight: bold;
    }

    .badge-blue {
        background: #e8f1f8;
        color: #1f4e79;
    }

    .badge-green {
        background: #e8f6ee;
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
       FEEDBACK
    ========================================================= */

    .feedback-box {
        border: 1px solid #d8e4ef;
        border-left: 5px solid #1f4e79;
        background: #f7fafc;
        padding: 11px;
        margin-top: 7px;
        border-radius: 5px;
        font-size: 9px;
    }

    .feedback-title {
        color: #1f4e79;
        font-size: 9px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    /* =========================================================
       VIRTUES
    ========================================================= */

    .virtue-score {
        font-weight: bold;
        color: #1f4e79;
    }

    .virtue-na {
        color: #718096;
    }

    /* =========================================================
       INITIATIVE CARDS
    ========================================================= */

    .initiative-card {
        border: 1px solid #dce4ec;
        margin-top: 9px;
        padding: 10px;
        page-break-inside: avoid;
    }

    .initiative-title {
        font-size: 11px;
        font-weight: bold;
        color: #173a5c;
        margin-bottom: 7px;
    }

    .initiative-meta {
        width: 100%;
        border-collapse: collapse;
    }

    .initiative-meta td {
        width: 33.33%;
        border: 1px solid #e0e6ed;
        padding: 6px;
        vertical-align: top;
    }

    .meta-label {
        color: #718096;
        font-size: 7.5px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .meta-value {
        color: #253449;
        font-size: 8.5px;
        font-weight: bold;
        margin-top: 2px;
    }

    .initiative-description {
        background: #fafbfd;
        border: 1px solid #e3e8ee;
        padding: 7px;
        margin-top: 7px;
        font-size: 8.5px;
    }

    /* =========================================================
       EMPTY
    ========================================================= */

    .empty {
        padding: 12px;
        text-align: center;
        color: #718096;
        background: #f8fafc;
        border: 1px solid #e0e6ed;
    }

    /* =========================================================
       FOOTER
    ========================================================= */

    .footer {
        margin-top: 20px;
        padding-top: 8px;
        border-top: 1px solid #dfe5ec;
        text-align: center;
        color: #718096;
        font-size: 7.5px;
    }

    .page-break {
        page-break-before: always;
    }

    .nowrap {
        white-space: nowrap;
    }

</style>

</head>

<body>

<div class="page">
{{-- =========================================================
     REPORT HEADER
========================================================== --}}

<div class="report-header">

    <div class="report-title">
        Performance Appraisal Report — FY 2025-2026
    </div>

    <div class="report-subtitle">
        Employee Performance &amp; Development Summary
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
     SCORE SUMMARY
========================================================== --}}

<table class="score-table">

    <tr>

        {{-- MANAGER --}}
        <td class="score-card score-manager">

            <div class="score-label">
                Manager Score
            </div>

            <div class="score-value">
                {{ $managerOverallRating !== null ? number_format($managerOverallRating * 20, 2) : '—' }}
            </div>

        </td>

        {{-- FEEDBACK --}}
        <td class="score-card score-virtue">

            <div class="score-label">
                Feedback Score
            </div>

            <div class="score-value">
                {{ $virtueOverall !== null ? number_format($virtueOverall, 2) : '—' }}
            </div>
@if($virtueOverall !== null)
                    <div class="score-weight">
                Weightage: 30%
            </div>
                @endif
        </td>

        {{-- HR --}}
        <td class="score-card score-hr">

            <div class="score-label">
                HR Score
            </div>

            <div class="score-value">
                {{ $hrOverallRating !== null ? number_format($hrOverallRating * 20, 2) : '—' }}
            </div>
@if($hrOverallRating !== null)
                    <div class="score-weight">
                Weightage: 70%
            </div>
                @endif
            
        </td>

        @php
$hrScore100 = $hrOverallRating !== null
    ? round($hrOverallRating * 20, 2)
    : null;

    $totalScore = null;

if (
    $hrScore100 !== null &&
    $virtueOverall !== null
) {
    $totalScore = round(
        ($hrScore100 * 0.70) +
        ($virtueOverall * 0.30),
        2
    );
}
@endphp
        {{-- TOTAL --}}
        <td class="score-card score-total">

            <div class="score-label">
                Total Score
            </div>

            <div class="score-value">
                {{ $totalScore !== null ? number_format($totalScore, 2) : '—' }}
            </div>

            @if($totalScore !== null)
                    <div class="score-weight">
                Final Score
            </div>
                @endif
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
        Consolidated view of employee self reporting and management validation
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

                <th style="width:8%;">
                    Deadline
                </th>

                <th style="width:15%;">
                    Self Status
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

                    $decision =
                        $managerReview->decision
                        ?? null;

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

                            <div style="margin-top:4px;color:#718096;">
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

                    <td class="nowrap">

                        {{ optional($goal->deadline)->format('d M Y') ?? '—' }}

                    </td>

                    <td>

                        <strong>
                            {{
                                ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $report->achievement_status ?? ''
                                    )
                                )
                            }}
                        </strong>

                    </td>

                    <td style="text-align:center;">

                        <strong class="primary">
                            {{ $report->rating ?? '—' }}
                        </strong>

                        @if($report->rating !== null)
                            / 5
                        @endif

                    </td>

                    <td style="text-align:center;">

                        <strong style="color:#b76b00;">
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
                    <strong>{{ $virtue }}</strong>
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

    <div style="margin-top:8px;font-size:10px;">

        <strong>
            Clarity of Purpose
        </strong>

        :
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
                <span class="primary">
                    Line Manager
                </span>
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

                <div class="initiative-title">

                    {{ $initiative->title }}

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

                                @if($initiative->nature_of_initiative === 'Others' && $initiative->nature_other)

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
                                {{ optional($initiative->manager)->name ?? $initiative->manager_id ? optional($initiative->manager)->name : ($user->manager_name ?? '—') }}
                            </div>

                        </td>

                    </tr>

                </table>

                @if($initiative->description)

                    <div class="initiative-description">

                        <strong class="primary">
                            Description
                        </strong>

                        <br>

                        {{ $initiative->description }}

                    </div>

                @endif

                @if($initiative->outcome)

                    <div class="initiative-description">

                        <strong class="primary">
                            Outcome
                        </strong>

                        <br>

                        {{ $initiative->outcome }}

                    </div>

                @endif

                @if($initiative->impact_reach || $initiative->impact_outcome)

                    <div class="initiative-description">

                        <strong class="primary">
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

                    <div class="initiative-description">

                        <strong style="color:#b76b00;">
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
    
    Performance Appraisal Report FY2025-2026

    <br>

    Auto Generated on {{ now()->format('d M Y, h:i A') }}

</div>

</div>

</body>
</html>
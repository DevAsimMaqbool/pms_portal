<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
    Performance Evaluation Report
</title>

<style>

/*
|--------------------------------------------------------------------------
| PAGE SETUP
|--------------------------------------------------------------------------
*/
@page {
    size: A4;
    margin: 118px 0 25px 0;
}

* {
    box-sizing: border-box;
}

html {
    width: 100%;
}

body {
    width: 100%;
    margin: 0;
    padding: 0;
    font-family: DejaVu Sans, sans-serif;
    color: #253449;
    font-size: 9px;
    line-height: 1.45;
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
   FIXED HEADER
========================================================= */

.fixed-header {
    position: fixed;
    top: -93px;
    left: 0;
    right: 0;
    height: 78px;
    padding: 0 12px;
}

/* =========================================================
   PAGE / INNER CONTENT FRAME
========================================================= */

.page {
    width: auto;
    margin: 0px 12px 12px 12px;
    padding: 0;
}

.virtue-page {
    page-break-before: always;
    page-break-after: avoid;
    page-break-inside: auto;

    width: auto;
    margin: 0px 12px 12px 12px;
    padding: 0;
}

.remarks-page {
    page-break-before: always;
    page-break-after: avoid;
    page-break-inside: avoid;

    width: auto;
    margin: 0px 12px 12px 12px;
    padding: 0;
}

.avoid-break {
    page-break-inside: avoid;
}

.keep-together {
    page-break-inside: avoid;
}

/* =========================================================
   HEADER
========================================================= */

.report-header {
    width: 100%;
    border-bottom: 3px solid #b78116;
    padding-bottom: 10px;
    margin-bottom: 0;
}

.report-header-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.report-header-table td {
    vertical-align: middle;
}

.report-title-cell {
    width: calc(100% - 100px);
}

.report-logo-cell {
    width: 100px;
    text-align: right;
    vertical-align: middle;
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

.report-logo {
    max-width: 85px;
    max-height: 65px;
}

/* =========================================================
   EMPLOYEE CARD
========================================================= */

.employee-card {
    width: 97%;
    border: 1px solid #dfe6ee;
    background: #f5f8fc;
    padding: 11px;
    margin: 0 0 15px 0;
}

.employee-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
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
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* =========================================================
   SECTION
========================================================= */

.section {
    width: 100%;
    margin-top: 10px;
    page-break-before: auto;
    page-break-after: auto;
    page-break-inside: auto;
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
   RATING CRITERIA
========================================================= */

.rating-criteria-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    margin: 0 0 10px 0;
    font-size: 7.5px;

    page-break-before: auto;
    page-break-after: auto;
    page-break-inside: auto;
}

.rating-criteria-table thead {
    display: table-header-group;
}

.rating-criteria-table tbody {
    display: table-row-group;
}

.rating-criteria-table th {
    background: #edf1f6;
    color: #1f4e79;
    border: 1px solid #d7dee8;
    padding: 6px;
    text-align: left;
    font-weight: bold;
}

.rating-criteria-table td {
    border: 1px solid #d7dee8;
    padding: 6px;
    vertical-align: middle;
    line-height: 1.4;
}

.rating-criteria-table tbody tr:nth-child(even) {
    background: #f8fafc;
}

.criteria-rating {
    text-align: center;
    font-weight: bold;
    color: #1f4e79;
    font-size: 9px;
}

/* =========================================================
   GOAL TABLE
========================================================= */

table.goal-table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    table-layout: fixed;

    /*
     * IMPORTANT:
     *
     * Header and goal data must ALWAYS stay together.
     *
     * If there is not enough room for the complete
     * table on the current page, DomPDF moves the
     * complete goal table to the next page.
     */
    margin: 0 0 8px 0;

    page-break-before: auto;
    page-break-after: auto;
    page-break-inside: avoid;
}

.goal-table tr {
    page-break-before: auto;
    page-break-after: auto;
    page-break-inside: avoid;
}

/* =========================================================
   GOAL TABLE HEADER CELLS
========================================================= */

.goal-table th {
    background: #edf4fa;
    color: #1f4e79;
    border: 1px solid #d7dee8;
    border-bottom: 2px solid #b78116;

    padding: 7px 5px;

    font-size: 7.2px;
    font-weight: bold;

    text-align: left;
    vertical-align: middle;

    line-height: 1.25;

    white-space: normal;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* =========================================================
   GOAL TABLE BODY CELLS
========================================================= */

.goal-table td {
    border: 1px solid #d7dee8;

    padding: 7px 5px;

    vertical-align: top;

    font-size: 8px;
    line-height: 1.45;

    white-space: normal;
    word-wrap: break-word;
    overflow-wrap: break-word;
    word-break: normal;

    overflow: visible;
}

/* =========================================================
   GOAL CONTENT
========================================================= */

.goal-name {
    display: inline;

    color: #173a5c;
    font-size: 8.3px;
    font-weight: bold;
    line-height: 1.45;

    white-space: normal;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.goal-number {
    display: inline-block;

    background: #1f4e79;
    color: #ffffff;

    font-size: 7px;
    font-weight: bold;

    padding: 3px 6px;
    margin-right: 4px;

    border-radius: 3px;

    vertical-align: middle;
}

.goal-objective {
    margin-top: 7px;

    padding: 5px 7px;

    background: #f5f8fc;
    border-left: 2px solid #b78116;

    color: #526174;

    font-size: 7.5px;
    line-height: 1.45;

    white-space: normal;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.target-text {
    color: #253449;

    font-size: 8px;
    font-weight: 600;

    line-height: 1.5;

    background: #f5f8fc;
    border-left: 2px solid #1f4e79;

    padding: 5px 7px;

    border-radius: 2px;

    white-space: normal;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.progress-box {
    color: #344256;

    font-size: 7px;

    line-height: 1.5;

    background: #f7fafc;
    border-left: 2px solid #b78116;

    padding: 6px 7px;

    border-radius: 2px;

    white-space: normal;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.deadline {
    margin-top: 5px;

    font-size: 7px;

    color: #718096;
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
   MANAGER REMARKS IN GOAL TABLE
========================================================= */

.manager-remarks {
    font-size: 7.8px;

    line-height: 1.5;

    white-space: normal;
    word-wrap: break-word;
    overflow-wrap: break-word;
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
   LEADERSHIP BEHAVIOURS / VIRTUES
========================================================= */

.virtue-section {
    margin-top: 0;
}

.virtue-intro {
    padding: 7px 9px;

    margin-bottom: 7px;

    background: #f5f8fc;

    border: 1px solid #dfe6ee;

    color: #526174;

    font-size: 7.7px;

    line-height: 1.35;
}

.virtue-block {
    margin-bottom: 6px;

    page-break-inside: avoid;
}

.virtue-title {
    background: #1f4e79;

    color: #ffffff;

    padding: 6px 9px;

    font-size: 8.5px;

    font-weight: bold;

    border-left: 4px solid #b78116;

    page-break-inside: avoid;

    page-break-after: avoid;
}

.virtue-item {
    width: 100%;

    border-collapse: collapse;

    table-layout: fixed;

    margin-bottom: 3px;

    page-break-inside: avoid;
}

.virtue-item td {
    border: 1px solid #dfe5ec;

    padding: 5px 7px;

    vertical-align: top;
}

.virtue-question {
    color: #344256;

    font-size: 7.5px;

    line-height: 1.35;

    font-weight: normal;
}

.virtue-options-cell {
    padding: 4px 7px !important;

    background: #f8fafc;
}

.virtue-rating-options {
    width: 100%;

    border-collapse: collapse;

    table-layout: fixed;
}

.virtue-rating-options td.rating-option {
    width: 20%;

    border: none;

    padding: 2px 1px;

    text-align: center;

    vertical-align: middle;

    color: #344256;

    font-size: 6.6px;

    line-height: 1.25;
}

.rating-checkbox {
    display: inline-block;

    width: 10px;
    height: 10px;

    border: 1px solid #718096;

    text-align: center;

    vertical-align: middle;

    font-size: 7px;

    line-height: 9px;

    color: #1f4e79;

    margin-right: 2px;
}

.rating-label {
    display: inline;

    vertical-align: middle;
}

.virtue-question-number {
    color: #1f4e79;

    font-weight: bold;

    margin-right: 3px;
}

/* =========================================================
   REMARKS PAGE
========================================================= */

.remarks-page-title {
    background: #1f4e79;

    color: #ffffff;

    padding: 8px 10px;

    font-size: 11px;

    font-weight: bold;

    border-left: 5px solid #b78116;

    margin-bottom: 10px;
}

.line-manager-remarks {
    margin-bottom: 12px;

    padding: 9px 10px 10px 10px;

    border: 1px solid #dfe6ee;

    background: #f8fafc;

    page-break-inside: avoid;
}

.line-manager-remarks-title {
    color: #1f4e79;

    font-size: 9px;

    font-weight: bold;

    padding-bottom: 6px;

    margin-bottom: 4px;

    border-bottom: 1px solid #d8e4ef;
}

.remarks-line {
    height: 35px;

    border-bottom: 1px solid #aeb9c7;
}

/* =========================================================
   SIGNATURE
========================================================= */

.signature-area {
    margin-top: 20px;

    page-break-inside: avoid;
}

.signature-table {
    width: 100%;

    border-collapse: collapse;
}

.signature-table td {
    width: 50%;

    vertical-align: bottom;

    padding: 5px 20px 0 20px;
}

.signature-line {
    height: 35px;

    border-bottom: 1px solid #253449;

    margin-bottom: 5px;
}

.signature-label {
    color: #526174;

    font-size: 7.5px;

    font-weight: bold;
}

.signature-date {
    margin-top: 4px;

    color: #718096;

    font-size: 7px;
}

/* =========================================================
   FOOTER
========================================================= */

.footer {
    margin-top: 15px;

    padding-top: 6px;

    border-top: 1px solid #dfe5ec;

    text-align: center;

    color: #718096;

    font-size: 7px;
}

/* =========================================================
   PRINT CONTROL
========================================================= */

table {
    page-break-before: auto;
    page-break-after: auto;
    page-break-inside: auto;
}

/*
|--------------------------------------------------------------------------
| GOAL TABLE OVERRIDE
|--------------------------------------------------------------------------
|
| This MUST come after the global table rule above.
|
| It prevents DomPDF from putting the goal header at
| the bottom of one page while its data starts on
| the next page.
|
|--------------------------------------------------------------------------
*/

table.goal-table {
    page-break-before: auto;
    page-break-after: auto;
    page-break-inside: avoid;
}

.goal-table tr {
    page-break-before: auto;
    page-break-after: auto;
    page-break-inside: avoid;
}

/*
|--------------------------------------------------------------------------
| IMPORTANT:
| No global:
|
| tr {
|     page-break-inside: avoid;
| }
|
|--------------------------------------------------------------------------
*/

</style>

</head>

<body>

{{-- =========================================================
FIXED HEADER — REPEATS ON EVERY PAGE
========================================================= --}}

<div class="fixed-header">

    <div class="report-header">

        <table class="report-header-table">

            <tr>

                <td class="report-title-cell">

                    <div class="report-title">
                        Performance Evaluation Report
                    </div>

                    <div class="report-subtitle">
                        Performance Goals &amp; Manager Evaluation — FY 2025-2026
                    </div>

                </td>

                <td class="report-logo-cell">

                    <img
                        src="{{ public_path('images/sup-logo.png') }}"
                        class="report-logo"
                        alt="Institution Logo"
                    >

                </td>

            </tr>

        </table>

    </div>

</div>

<div class="page">

{{-- =========================================================
EMPLOYEE INFORMATION
========================================================= --}}

<div class="employee-card">

<table class="employee-table">

    <tr>

        <td>

            <div class="employee-label">
                Employee
            </div>

            <div class="employee-value">
                {{ trim(preg_replace('/[-\s]*\d+$/', '', $user->name)) }}
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

                {{
                    isset($user->hr_department_name)
                    && str_contains($user->hr_department_name, '/')
                        ? trim(last(explode('/', $user->hr_department_name)))
                        : ($user->hr_department_name ?? '—')
                }}

            </div>

        </td>

    </tr>

    <tr>

        <td colspan="2">

            <div class="employee-label">
                Reporting Manager
            </div>

            <div class="employee-value">
                {{ trim(preg_replace('/[-\s]*\d+$/', '', $user->manager_name)) }}
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
GOALS
========================================================= --}}

<div class="section">

<div class="section-title">
    Goals &amp; Manager Evaluation
</div>

<div class="section-subtitle">
    Rating Criteria
</div>

<table class="rating-criteria-table">

    <thead>

        <tr>

            <th style="width:10%;">
                Rating
            </th>

            <th style="width:22%;">
                Level
            </th>

            <th style="width:68%;">
                Descriptor
            </th>

        </tr>

    </thead>

    <tbody>

        <tr>

            <td class="criteria-rating">
                1
            </td>

            <td>
                <strong>Unsatisfactory</strong>
            </td>

            <td>
                Less than 60% of the agreed goal achieved,
                with significant gaps in quality, completeness,
                output and/or timelines.
            </td>

        </tr>

        <tr>

            <td class="criteria-rating">
                2
            </td>

            <td>
                <strong>Needs Improvement</strong>
            </td>

            <td>
                60–69% of the agreed goal achieved, but required
                quality, completeness, output and/or timelines
                are not consistently met.
            </td>

        </tr>

        <tr>

            <td class="criteria-rating">
                3
            </td>

            <td>
                <strong>Meets Expectations</strong>
            </td>

            <td>
                70–79% of the agreed goal achieved, meeting
                the expected quality and completeness standards
                and delivered within the agreed timeline.
            </td>

        </tr>

        <tr>

            <td class="criteria-rating">
                4
            </td>

            <td>
                <strong>Exceeds Expectations</strong>
            </td>

            <td>
                80–89% of the agreed goal achieved, while
                maintaining the required quality and completeness,
                and/or delivering meaningful additional scope,
                output or value beyond the agreed goal.
            </td>

        </tr>

        <tr>

            <td class="criteria-rating">
                5
            </td>

            <td>
                <strong>Exceptional</strong>
            </td>

            <td>
                More than 90% of the agreed goal achieved,
                with consistently high quality and completeness,
                and significant additional scope, impact or value
                beyond the original goal.
            </td>

        </tr>

    </tbody>

</table>

@if($reports->count())

    @foreach($reports as $index => $goal)

        @php

            $report =
                $goal->latest_self_report;

            $managerReview =
                $goal->latest_manager_review;

            $progress =
                $report->progress_against_goal
                ?? null;

            $managerRemarks =
                $goal->manager_remarks
                ?? null;

        @endphp

        {{-- =================================================
             EACH GOAL = ONE COMPLETE INDEPENDENT TABLE
             HEADER + DATA MUST STAY TOGETHER
        ================================================== --}}

        <table class="goal-table">

            {{-- =================================================
                 HEADER FOR THIS GOAL
            ================================================== --}}

            <tr>

                <th style="width:18%;">
                    Goal
                </th>

                <th style="width:15%;">
                    Goal Target
                </th>

                <th style="width:19%;">
                    Goal Progress
                </th>

                <th style="width:8%; text-align:center;">
                    Goal Rating
                </th>

                <th style="width:18%;">
                    Manager Remarks
                </th>

                <th style="width:12%; text-align:center;">
                    Goal Weightage (%)
                </th>

                <th style="width:10%; text-align:center;">
                    Manager Rating
                </th>

            </tr>

            {{-- =================================================
                 ONLY THIS GOAL
            ================================================== --}}

            <tr>

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
                                word-wrap:break-word;
                                overflow-wrap:break-word;
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
                     GOAL TARGET
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
                     GOAL PROGRESS
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

                    @else

                        <span class="no-remark">
                            —
                        </span>

                    @endif

                </td>

                {{-- =================================================
                     GOAL WEIGHTAGE
                ================================================== --}}

                <td style="text-align:center;">

                    {{-- Keep existing data logic here if weightage
                         is available on your Goal model. --}}

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
                            —
                        </span>

                    @endif

                </td>

            </tr>

        </table>

    @endforeach

@else

    <div class="empty">
        No goals have been created for this employee.
    </div>

@endif

</div>

{{-- =========================================================
LEADERSHIP DATA
========================================================= --}}

@php

$virtues = [

    [
        'name' => '1. Responsibility & Accountability',
        'statements' => [
            'Takes clear ownership of the outcomes of their function and ensures commitments are translated into measurable results.',
            'Anticipates risks, addresses challenges proactively, and remains accountable for outcomes, including when results fall short of expectations.',
            'Ensures that strategic and operational commitments within their area are delivered with discipline, consistency and appropriate follow-through.',
        ],
    ],

    [
        'name' => '2. Honesty & Integrity',
        'statements' => [
            'Demonstrates integrity and ethical judgment in decisions, particularly when faced with pressure, competing interests or difficult choices.',
            'Promotes transparency and ensures that decisions, information and institutional matters are communicated honestly and responsibly.',
            'Consistently acts in the best interests of the institution and upholds its principles even when doing so is difficult or personally inconvenient.',
        ],
    ],

    [
        'name' => '3. Empathy & Compassion',
        'statements' => [
            'Demonstrates genuine understanding of the needs, concerns and perspective of his/her team, line manager and other stakeholders when making decisions.',
            'Creates an environment in which people feel heard, respected and appropriately supported while maintaining accountability for performance.',
            'Balances institutional priorities with compassion and fairness, particularly when dealing with people-related challenges or difficult circumstances.',
        ],
    ],

    [
        'name' => '4. Humility & Service',
        'statements' => [
            'Places institutional purpose and collective success above personal recognition, position or credit.',
            'Actively supports colleagues and other functions, promotes collaboration and contributes beyond the boundaries of their own portfolio when institutional priorities require it.',
            'Remains open to feedback, acknowledges the contributions of others and demonstrates a willingness to learn, adapt and share credit.',
        ],
    ],

    [
        'name' => '5. Courage & Drive',
        'statements' => [
            'Demonstrates the courage to make timely and well-considered decisions, even in situations involving uncertainty, complexity or resistance.',
            'Constructively challenges the status quo and initiates meaningful improvements that advance institutional priorities.',
            'Demonstrates persistence and determination in translating strategic priorities into action, particularly when implementation is difficult or requires change.',
        ],
    ],

];

$ratingOptions = [

    1 => 'Strongly Disagree',
    2 => 'Disagree',
    3 => 'Neither Agree nor Disagree',
    4 => 'Agree',
    5 => 'Strongly Agree',

];

@endphp

{{-- =========================================================
DEDICATED LEADERSHIP PAGE
========================================================= --}}

<div class="virtue-page">

<div class="section virtue-section">

    <div class="section-title">
        Leadership Behaviours &amp; Virtues Assessment
    </div>

    <div class="virtue-intro">

        Please rate the extent to which your Direct Report
        consistently demonstrates each of the following
        leadership behaviours in the discharge of his/her
        role and responsibilities.

    </div>

    @foreach($virtues as $virtueIndex => $virtue)

        <div class="virtue-block">

            <div class="virtue-title">
                {{ $virtue['name'] }}
            </div>

            @foreach($virtue['statements'] as $statementIndex => $statement)

                @php

                    $selectedRating =
                        $virtueRatings[$virtueIndex][$statementIndex]
                        ?? null;

                @endphp

                <table class="virtue-item">

                    <tr>

                        <td class="virtue-question">

                            <span class="virtue-question-number">
                                {{ $statementIndex + 1 }}.
                            </span>

                            {{ $statement }}

                        </td>

                    </tr>

                    <tr>

                        <td class="virtue-options-cell">

                            <table class="virtue-rating-options">

                                <tr>

                                    @foreach($ratingOptions as $value => $label)

                                        <td class="rating-option">

                                            <span class="rating-checkbox">

                                                @if(
                                                    (string) $selectedRating ===
                                                    (string) $value
                                                )
                                                    &#10003;
                                                @endif

                                            </span>

                                            <span class="rating-label">
                                                {{ $label }}
                                            </span>

                                        </td>

                                    @endforeach

                                </tr>

                            </table>

                        </td>

                    </tr>

                </table>

            @endforeach

        </div>

    @endforeach

</div>

</div>

{{-- =========================================================
LINE MANAGER REMARKS + SIGNATURE PAGE
========================================================= --}}

<div class="remarks-page">

<div class="remarks-page-title">
    Line Manager's Remarks &amp; Developmental Feedback
</div>

<div class="line-manager-remarks">

    <div class="line-manager-remarks-title">
        Line Manager's Overall Remarks on Performance
    </div>

    @for($line = 0; $line < 6; $line++)

        <div class="remarks-line"></div>

    @endfor

</div>

<div class="line-manager-remarks">

    <div class="line-manager-remarks-title">
        Developmental Areas Reported by Line Manager
    </div>

    @for($line = 0; $line < 6; $line++)

        <div class="remarks-line"></div>

    @endfor

</div>

<div class="signature-area">

    <table class="signature-table">

        <tr>

            <td>

                <div class="signature-line"></div>

                <div class="signature-label">
                    Line Manager's Signature
                </div>

                <div class="signature-date">
                    Date: ____________________
                </div>

            </td>

            <td>

                <div class="signature-line"></div>

                <div class="signature-label">
                    Employee's Signature
                </div>

                <div class="signature-date">
                    Date: ____________________
                </div>

            </td>

        </tr>

    </table>

</div>

<div class="footer">

    Performance Evaluation Report — FY 2025-2026

    <br>

    {{ trim(preg_replace('/[-\s]*\d+$/', '', $user->name)) }}

    &nbsp;|&nbsp;

    Auto Generated on
    {{ now()->format('d M Y, h:i A') }}

</div>

</div>

</body>

</html>
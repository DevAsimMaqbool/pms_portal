@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}

    <div class="dashboard-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="header-icon">

                    <i class="fas fa-chart-line"></i>

                </div>

                <div>

                    <h3 class="fw-bold mb-1">
                        Performance Dashboard
                    </h3>

                    <p class="mb-0 text-muted">
                        Your complete performance overview, goals, feedback and review progress.
                    </p>

                </div>

            </div>

            <div class="employee-header-badge">

                <div class="employee-header-icon">

                    <i class="fas fa-user"></i>

                </div>

                <div>

                    <small>
                        Employee
                    </small>

                    <strong>
                        {{ $user->name ?? '—' }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
        TOP PROFILE / SUMMARY
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- EMPLOYEE INFO --}}

        <div class="col-xl-4 col-lg-6">

            <div class="section-card employee-profile-card h-100">

                <div class="section-body">

                    <div class="profile-top">

                        <div class="profile-avatar">

                            <i class="fas fa-user"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">
                                {{ $user->name ?? '—' }}
                            </h5>

                            <small>
                                Employee ID: {{ $user->employee_id ?? '—' }}
                            </small>

                        </div>

                    </div>

                    <div class="profile-details">

                        <div class="profile-detail">

                            <span>
                                Department
                            </span>

                            <strong>
                                {{ $user->department ?? '—' }}
                            </strong>

                        </div>

                        <div class="profile-detail">

                            <span>
                                Line Manager
                            </span>

                            <strong>
                                {{ $user->manager_name ?? '—' }}
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- FINAL SCORE --}}

        <div class="col-xl-4 col-lg-6">

            <div class="section-card final-score-card h-100">

                <div class="final-score-content">

                    <div>

                        <small class="final-score-label">
                            OVERALL PERFORMANCE
                        </small>

                        <h5 class="fw-bold mb-1">
                            Final Score
                        </h5>

                        <p class="mb-0">
                            Based on HR and Line Manager Feedback.
                        </p>

                    </div>

                    <div class="final-score-number">

                        @if($finalScore !== null)

                            {{ number_format($finalScore, 2) }}

                            <span>/100</span>

                        @else

                            —

                        @endif

                    </div>

                </div>

                <div class="final-score-footer">

                    <span class="final-rating-badge">

                        {{ $finalRating }}

                    </span>

                    <span>
                        HR 70% + Feedback 30%
                    </span>

                </div>

            </div>

        </div>

        {{-- GOAL PROGRESS --}}

        <div class="col-xl-4 col-lg-12">

            <div class="section-card h-100">

                <div class="section-header">

                    <div class="section-title">

                        <div class="section-number">

                            <i class="fas fa-bullseye"></i>

                        </div>

                        <div>

                            <h5 class="mb-1 fw-bold">
                                Goal Progress
                            </h5>

                            <small>
                                Current performance against goals.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="section-body">

                    <div class="goal-progress-top">

                        <div>

                            <div class="goal-progress-label">
                                Completion
                            </div>

                            <strong>
                                {{ number_format($goalProgress, 0) }}%
                            </strong>

                        </div>

                        <div class="goal-count-text">

                            {{ $completedGoals }}
                            /
                            {{ $totalGoals }}

                            completed

                        </div>

                    </div>

                    <div class="progress-custom">

                        <div
                            class="progress-custom-bar"
                            style="width: {{ min($goalProgress, 100) }}%;"
                        ></div>

                    </div>

                    <div class="goal-mini-stats">

                        <div>

                            <span class="goal-stat-dot completed"></span>

                            <strong>
                                {{ $completedGoals }}
                            </strong>

                            Completed

                        </div>

                        <div>

                            <span class="goal-stat-dot progress"></span>

                            <strong>
                                {{ $inProgressGoals }}
                            </strong>

                            In Progress

                        </div>

                        <div>

                            <span class="goal-stat-dot pending"></span>

                            <strong>
                                {{ $notStartedGoals }}
                            </strong>

                            Not Started

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
        SCORE CARDS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- SELF --}}

        <div class="col-xl col-md-6">

            <div class="score-summary-card">

                <div class="score-summary-top">

                    <div class="score-summary-icon self">

                        <i class="fas fa-user"></i>

                    </div>

                    <span class="score-summary-label">
                        Self Score
                    </span>

                </div>

                <div class="score-summary-value">

                    @if($selfScore100 !== null)

                        {{ number_format($selfScore100, 2) }}

                        <span>/100</span>

                    @else
                        —
                    @endif

                </div>

                <div class="score-summary-footer">

                    <span>
                        {{ $selfRating }}
                    </span>

                </div>

            </div>

        </div>

        {{-- MANAGER --}}

        <div class="col-xl col-md-6">

            <div class="score-summary-card">

                <div class="score-summary-top">

                    <div class="score-summary-icon manager">

                        <i class="fas fa-user-tie"></i>

                    </div>

                    <span class="score-summary-label">
                        Manager Score
                    </span>

                </div>

                <div class="score-summary-value">

                    @if($managerScore100 !== null)

                        {{ number_format($managerScore100, 2) }}

                        <span>/100</span>

                    @else
                        —
                    @endif

                </div>

                <div class="score-summary-footer">

                    <span>
                        {{ $managerRating }}
                    </span>

                </div>

            </div>

        </div>

        {{-- FEEDBACK --}}

        <div class="col-xl col-md-6">

            <div class="score-summary-card">

                <div class="score-summary-top">

                    <div class="score-summary-icon feedback">

                        <i class="fas fa-comments"></i>

                    </div>

                    <span class="score-summary-label">
                        Feedback Score
                    </span>

                </div>

                <div class="score-summary-value">

                    @if($feedbackScore100 !== null)

                        {{ number_format($feedbackScore100, 2) }}

                        <span>/100</span>

                    @else
                        —
                    @endif

                </div>

                <div class="score-summary-footer">

                    <span>
                        {{ $feedbackRating }}
                    </span>

                </div>

            </div>

        </div>

        {{-- HR --}}

        <div class="col-xl col-md-6">

            <div class="score-summary-card">

                <div class="score-summary-top">

                    <div class="score-summary-icon hr">

                        <i class="fas fa-user-shield"></i>

                    </div>

                    <span class="score-summary-label">
                        HR Score
                    </span>

                </div>

                <div class="score-summary-value">

                    @if($hrScore100 !== null)

                        {{ number_format($hrScore100, 2) }}

                        <span>/100</span>

                    @else
                        —
                    @endif

                </div>

                <div class="score-summary-footer">

                    <span>
                        {{ $hrRating }}
                    </span>

                </div>

            </div>

        </div>

        {{-- FINAL --}}

        <div class="col-xl col-md-6">

            <div class="score-summary-card final">

                <div class="score-summary-top">

                    <div class="score-summary-icon final">

                        <i class="fas fa-award"></i>

                    </div>

                    <span class="score-summary-label">
                        Final Score
                    </span>

                </div>

                <div class="score-summary-value">

                    @if($finalScore !== null)

                        {{ number_format($finalScore, 2) }}

                        <span>/100</span>

                    @else
                        —
                    @endif

                </div>

                <div class="score-summary-footer">

                    <span>
                        {{ $finalRating }}
                    </span>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
        MAIN ANALYTICS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- =====================================================
            PERFORMANCE BREAKDOWN
        ====================================================== --}}

        <div class="col-lg-5">

            <div class="section-card h-100">

                <div class="section-header">

                    <div class="section-title">

                        <div class="section-number">

                            <i class="fas fa-chart-bar"></i>

                        </div>

                        <div>

                            <h5 class="mb-1 fw-bold">
                                Performance Breakdown
                            </h5>

                            <small>
                                Score comparison across assessment sources.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="section-body">

                    @php
                        $performanceBars = [
                            [
                                'title' => 'Self',
                                'score' => $selfScore100,
                                'class' => 'bar-self'
                            ],
                            [
                                'title' => 'Manager',
                                'score' => $managerScore100,
                                'class' => 'bar-manager'
                            ],
                            [
                                'title' => 'Feedback',
                                'score' => $feedbackScore100,
                                'class' => 'bar-feedback'
                            ],
                            [
                                'title' => 'HR',
                                'score' => $hrScore100,
                                'class' => 'bar-hr'
                            ],
                        ];
                    @endphp

                    @foreach($performanceBars as $bar)

                        <div class="performance-bar-row">

                            <div class="performance-bar-heading">

                                <span>
                                    {{ $bar['title'] }}
                                </span>

                                <strong>

                                    @if($bar['score'] !== null)

                                        {{ number_format($bar['score'], 2) }}

                                    @else

                                        —

                                    @endif

                                </strong>

                            </div>

                            <div class="performance-bar">

                                @if($bar['score'] !== null)

                                    <div
                                        class="performance-bar-fill {{ $bar['class'] }}"
                                        style="width: {{ min($bar['score'], 100) }}%;"
                                    ></div>

                                @endif

                            </div>

                        </div>

                    @endforeach

                    <div class="breakdown-note">

                        <i class="fas fa-info-circle"></i>

                        <span>
                            Final Score uses HR at 70% and Feedback at 30%.
                        </span>

                    </div>

                </div>

            </div>

        </div>

        {{-- =====================================================
            REVIEW STATUS
        ====================================================== --}}

        <div class="col-lg-3">

            <div class="section-card h-100">

                <div class="section-header">

                    <div class="section-title">

                        <div class="section-number">

                            <i class="fas fa-route"></i>

                        </div>

                        <div>

                            <h5 class="mb-1 fw-bold">
                                Review Journey
                            </h5>

                            <small>
                                Current appraisal stage.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="section-body">

                    <div class="timeline">

                        {{-- SELF REPORT --}}

                        <div class="timeline-item">

                            <div class="timeline-icon
                                {{ $selfReportSubmitted ? 'done' : '' }}">

                                <i class="fas
                                    {{ $selfReportSubmitted
                                        ? 'fa-check'
                                        : 'fa-file-alt'
                                    }}"></i>

                            </div>

                            <div class="timeline-content">

                                <strong>
                                    Self Report
                                </strong>

                                <small>

                                    {{ $selfReportSubmitted
                                        ? 'Submitted'
                                        : 'Pending'
                                    }}

                                </small>

                            </div>

                        </div>

                        {{-- MANAGER --}}

                        <div class="timeline-line"></div>

                        <div class="timeline-item">

                            <div class="timeline-icon
                                {{ $managerReviewCompleted ? 'done' : '' }}">

                                <i class="fas
                                    {{ $managerReviewCompleted
                                        ? 'fa-check'
                                        : 'fa-user-tie'
                                    }}"></i>

                            </div>

                            <div class="timeline-content">

                                <strong>
                                    Manager Review
                                </strong>

                                <small>

                                    {{ $managerReviewCompleted
                                        ? 'Completed'
                                        : 'Pending'
                                    }}

                                </small>

                            </div>

                        </div>

                        {{-- HR --}}

                        <div class="timeline-line"></div>

                        <div class="timeline-item">

                            <div class="timeline-icon
                                {{ $hrReviewCompleted ? 'done' : '' }}">

                                <i class="fas
                                    {{ $hrReviewCompleted
                                        ? 'fa-check'
                                        : 'fa-user-shield'
                                    }}"></i>

                            </div>

                            <div class="timeline-content">

                                <strong>
                                    HR Review
                                </strong>

                                <small>

                                    {{ $hrReviewCompleted
                                        ? 'Completed'
                                        : 'Pending'
                                    }}

                                </small>

                            </div>

                        </div>

                        {{-- FINAL --}}

                        <div class="timeline-line"></div>

                        <div class="timeline-item">

                            <div class="timeline-icon
                                {{ $finalized ? 'done' : '' }}">

                                <i class="fas
                                    {{ $finalized
                                        ? 'fa-check'
                                        : 'fa-award'
                                    }}"></i>

                            </div>

                            <div class="timeline-content">

                                <strong>
                                    Finalized
                                </strong>

                                <small>

                                    {{ $finalized
                                        ? 'Finalized'
                                        : 'In Progress'
                                    }}

                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =====================================================
            VIRTUE MIRROR
        ====================================================== --}}

        <div class="col-lg-4">

            <div class="section-card h-100">

                <div class="section-header">

                    <div class="section-title">

                        <div class="section-number">

                            <i class="fas fa-star"></i>

                        </div>

                        <div>

                            <h5 class="mb-1 fw-bold">
                                Virtue Mirror
                            </h5>

                            <small>
                                Line Manager Feedback
                            </small>

                        </div>

                    </div>

                </div>

                <div class="section-body">

                    @php
                        $virtueItems = [
                            'Honesty & Integrity' =>
                                $virtueScores['Honesty & Integrity'] ?? null,

                            'Responsibility & Accountability' =>
                                $virtueScores['Responsibility & Accountability'] ?? null,

                            'Humility & Service' =>
                                $virtueScores['Humility & Service'] ?? null,

                            'Empathy & Compassion' =>
                                $virtueScores['Empathy & Compassion'] ?? null,

                            'Courage & Drive' =>
                                $virtueScores['Courage & Drive'] ?? null,
                        ];
                    @endphp

                    <div class="virtue-dashboard-list">

                        @foreach($virtueItems as $virtue => $score)

                            <div class="virtue-dashboard-item">

                                <div class="virtue-dashboard-heading">

                                    <span>
                                        {{ $virtue }}
                                    </span>

                                    <strong>

                                        @if($score !== null)

                                            {{ number_format($score, 2) }}

                                        @else

                                            —

                                        @endif

                                    </strong>

                                </div>

                                <div class="virtue-dashboard-progress">

                                    @if($score !== null)

                                        <div
                                            class="virtue-dashboard-fill"
                                            style="width: {{ min($score, 100) }}%;"
                                        ></div>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                    <div class="virtue-overall">

                        <div>

                            <small>
                                Overall Feedback
                            </small>

                            <strong>
                                Line Manager
                            </strong>

                        </div>

                        <div class="virtue-overall-value">

                            @if($feedbackScore100 !== null)

                                {{ number_format($feedbackScore100, 2) }}

                                <span>/100</span>

                            @else

                                —

                            @endif

                        </div>

                    </div>

                    <a
                        href="{{ route('line-manager-feedback-chart') }}"
                        class="btn btn-light border w-100 mt-3"
                    >

                        <i class="fas fa-chart-pie me-2"></i>

                        View Virtue Mirror

                    </a>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
        GOAL SUMMARY
    ========================================================== --}}

    <div class="section-card mb-4">

        <div class="section-header">

            <div class="section-title">

                <div class="section-number">

                    <i class="fas fa-bullseye"></i>

                </div>

                <div>

                    <h5 class="mb-1 fw-bold">
                        Goal Performance
                    </h5>

                    <small>
                        Summary of your latest goal submissions.
                    </small>

                </div>

            </div>

            <a
                href="{{ route('newgoals.index') }}"
                class="btn btn-light border shadow-sm"
            >

                <i class="fas fa-list me-2"></i>

                View Goals

            </a>

        </div>

        <div class="section-body">

            <div class="row g-3">

                {{-- TOTAL --}}

                <div class="col-lg-3 col-md-6">

                    <div class="goal-stat-card">

                        <div class="goal-stat-icon blue">

                            <i class="fas fa-bullseye"></i>

                        </div>

                        <div>

                            <span>
                                Total Goals
                            </span>

                            <strong>
                                {{ $totalGoals }}
                            </strong>

                        </div>

                    </div>

                </div>

                {{-- APPROVED --}}

                <div class="col-lg-3 col-md-6">

                    <div class="goal-stat-card">

                        <div class="goal-stat-icon green">

                            <i class="fas fa-user-check"></i>

                        </div>

                        <div>

                            <span>
                                Manager Approved
                            </span>

                            <strong>
                                {{ $approvedGoals }}
                            </strong>

                        </div>

                    </div>

                </div>

                {{-- COMPLETED --}}

                <div class="col-lg-3 col-md-6">

                    <div class="goal-stat-card">

                        <div class="goal-stat-icon purple">

                            <i class="fas fa-check-circle"></i>

                        </div>

                        <div>

                            <span>
                                Completed
                            </span>

                            <strong>
                                {{ $completedGoals }}
                            </strong>

                        </div>

                    </div>

                </div>

                {{-- IN PROGRESS --}}

                <div class="col-lg-3 col-md-6">

                    <div class="goal-stat-card">

                        <div class="goal-stat-icon orange">

                            <i class="fas fa-spinner"></i>

                        </div>

                        <div>

                            <span>
                                In Progress
                            </span>

                            <strong>
                                {{ $inProgressGoals }}
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
        APPROVED GOALS
    ========================================================== --}}

    <div class="section-card mb-4">

        <div class="section-header">

            <div class="section-title">

                <div class="section-number">

                    <i class="fas fa-tasks"></i>

                </div>

                <div>

                    <h5 class="mb-1 fw-bold">
                        Manager Approved Goals
                    </h5>

                    <small>
                        Goals currently included in your performance assessment.
                    </small>

                </div>

            </div>

        </div>

        <div class="section-body p-0">

            @if($approvedReports->count())

                <div class="table-responsive">

                    <table class="table dashboard-table mb-0">

                        <thead>

                            <tr>

                                <th>
                                    Goal
                                </th>

                                <th>
                                    Achievement
                                </th>

                                <th>
                                    Self
                                </th>

                                <th>
                                    Manager
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($approvedReports->take(8) as $report)

                                <tr>

                                    <td>

                                        <div class="goal-table-title">

                                            {{ \Illuminate\Support\Str::limit(
                                                optional($report->goal)->goal ?? 'Goal',
                                                90
                                            ) }}

                                        </div>

                                    </td>

                                    <td>

                                        @php
                                            $achievementStatus =
                                                $report->achievement_status ?? 'not_started';

                                            $achievementLabel =
                                                match ($achievementStatus) {
                                                    'completed' => 'Completed',
                                                    'in_progress' => 'In Progress',
                                                    'partially_complete' => 'Partially Complete',
                                                    default => 'Not Started',
                                                };
                                        @endphp

                                        <span class="achievement-badge
                                            {{ $achievementStatus }}">

                                            {{ $achievementLabel }}

                                        </span>

                                    </td>

                                    <td>

                                        @if($report->rating !== null)

                                            {{ number_format(
                                                ((float) $report->rating) * 20,
                                                2
                                            ) }}

                                            <small>
                                                /100
                                            </small>

                                        @else

                                            —

                                        @endif

                                    </td>

                                    <td>

                                        @if($report->manager_rating !== null)

                                            {{ number_format(
                                                ((float) $report->manager_rating) * 20,
                                                2
                                            ) }}

                                            <small>
                                                /100
                                            </small>

                                        @else

                                            —

                                        @endif

                                    </td>

                                    <td>

                                        <span class="approved-badge">

                                            <i class="fas fa-check me-1"></i>

                                            Approved

                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty-inline">

                    <i class="fas fa-clipboard-list"></i>

                    <strong>
                        No manager-approved goals yet.
                    </strong>

                    <span>
                        Approved goals will appear here once reviewed by your manager.
                    </span>

                </div>

            @endif

        </div>

    </div>

    {{-- =========================================================
        INITIATIVES
    ========================================================== --}}

    <div class="section-card mb-4">

        <div class="section-header">

            <div class="section-title">

                <div class="section-number">

                    <i class="fas fa-lightbulb"></i>

                </div>

                <div>

                    <h5 class="mb-1 fw-bold">
                        Approved Initiatives
                    </h5>

                    <small>
                        Initiatives recognized by your Line Manager.
                    </small>

                </div>

            </div>

        </div>

        <div class="section-body">

            @if($initiatives->count())

                <div class="row g-3">

                    @foreach($initiatives->take(6) as $initiative)

                        <div class="col-lg-6">

                            <div class="initiative-card">

                                <div class="initiative-top">

                                    <div class="initiative-icon">

                                        <i class="fas fa-lightbulb"></i>

                                    </div>

                                    <span class="initiative-approved">

                                        <i class="fas fa-check me-1"></i>

                                        Approved

                                    </span>

                                </div>

                                <h6 class="fw-bold mb-2">

                                    {{ $initiative->title ?? 'Initiative' }}

                                </h6>

                                @if(!empty($initiative->description))

                                    <p>

                                        {{ \Illuminate\Support\Str::limit(
                                            $initiative->description,
                                            140
                                        ) }}

                                    </p>

                                @endif

                                <div class="initiative-meta">

                                    <span>

                                        <i class="fas fa-layer-group me-1"></i>

                                        {{ ucfirst(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $initiative->scope ?? '—'
                                            )
                                        ) }}

                                    </span>

                                    @if($initiative->nature_of_initiative)

                                        <span>

                                            <i class="fas fa-tag me-1"></i>

                                            {{ $initiative->nature_of_initiative }}

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="empty-inline">

                    <i class="fas fa-lightbulb"></i>

                    <strong>
                        No approved initiatives yet.
                    </strong>

                    <span>
                        Manager-approved initiatives will appear here.
                    </span>

                </div>

            @endif

        </div>

    </div>

    {{-- =========================================================
        FOOTER NOTE
    ========================================================== --}}

    <div class="dashboard-note">

        <div class="dashboard-note-icon">

            <i class="fas fa-info-circle"></i>

        </div>

        <div>

            <strong>
                Performance Summary
            </strong>

            <p class="mb-0">

                This dashboard provides a consolidated view of your current
                goals, assessments, Line Manager feedback and appraisal progress.

            </p>

        </div>

    </div>

</div>

<style>

/* =========================================================
   VARIABLES
========================================================= */

:root {

    --pms-primary: #1f4e79;

    --pms-primary-dark: #173a5c;

    --pms-light: #f4f7fb;

    --pms-border: #e4e9f0;

    --pms-text: #253449;

    --pms-muted: #718096;

}

/* =========================================================
   HEADER
========================================================= */

.dashboard-header {

    background: linear-gradient(
        135deg,
        #ffffff 0%,
        #f5f8fc 100%
    );

    border: 1px solid var(--pms-border);

    border-radius: 16px;

    padding: 22px 26px;

    box-shadow:
        0 4px 18px rgba(31, 78, 121, .06);
}

.header-icon {

    width: 48px;

    height: 48px;

    border-radius: 12px;

    background: var(--pms-primary);

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 20px;

    box-shadow:
        0 6px 14px rgba(31, 78, 121, .22);
}

.dashboard-header h3 {

    color: var(--pms-text);

}

.dashboard-header p {

    font-size: 12px;

}

.employee-header-badge {

    display: flex;

    align-items: center;

    gap: 10px;

    background: #eaf2f9;

    border: 1px solid #d6e3ef;

    border-radius: 12px;

    padding: 8px 13px;
}

.employee-header-icon {

    width: 34px;

    height: 34px;

    border-radius: 9px;

    background: #fff;

    color: var(--pms-primary);

    display: flex;

    align-items: center;

    justify-content: center;
}

.employee-header-badge small {

    display: block;

    color: var(--pms-muted);

    font-size: 8px;
}

.employee-header-badge strong {

    display: block;

    color: var(--pms-text);

    font-size: 11px;
}

/* =========================================================
   COMMON CARD
========================================================= */

.section-card {

    background: #fff;

    border: 1px solid var(--pms-border);

    border-radius: 16px;

    overflow: hidden;

    box-shadow:
        0 4px 18px rgba(31, 78, 121, .06);
}

.section-header {

    background: #f8fafc;

    border-bottom: 1px solid var(--pms-border);

    padding: 17px 20px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;
}

.section-title {

    display: flex;

    align-items: center;

    gap: 13px;
}

.section-title small {

    display: block;

    color: var(--pms-muted);

    font-size: 10px;
}

.section-number {

    width: 36px;

    height: 36px;

    min-width: 36px;

    border-radius: 10px;

    background: var(--pms-primary);

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;
}

.section-body {

    padding: 20px;
}

/* =========================================================
   PROFILE
========================================================= */

.profile-top {

    display: flex;

    align-items: center;

    gap: 13px;

    margin-bottom: 20px;
}

.profile-avatar {

    width: 52px;

    height: 52px;

    border-radius: 13px;

    background: #e8f1fa;

    color: var(--pms-primary);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 18px;
}

.profile-top h5 {

    color: var(--pms-text);

}

.profile-top small {

    color: var(--pms-muted);

    font-size: 10px;
}

.profile-details {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 10px;
}

.profile-detail {

    background: #fafcfe;

    border: 1px solid #edf1f5;

    border-radius: 9px;

    padding: 10px 11px;
}

.profile-detail span {

    display: block;

    color: var(--pms-muted);

    font-size: 8px;

    margin-bottom: 4px;

    text-transform: uppercase;

    font-weight: 700;
}

.profile-detail strong {

    display: block;

    color: var(--pms-text);

    font-size: 10px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;
}

/* =========================================================
   FINAL SCORE
========================================================= */

.final-score-card {

    background:
        linear-gradient(
            135deg,
            var(--pms-primary),
            var(--pms-primary-dark)
        );

    border: 0;

    color: #fff;
}

.final-score-content {

    padding: 22px;

    min-height: 132px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;
}

.final-score-label {

    font-size: 8px;

    letter-spacing: .8px;

    opacity: .72;

    font-weight: 700;
}

.final-score-content h5 {

    color: #fff;
}

.final-score-content p {

    color: rgba(255,255,255,.72);

    font-size: 10px;
}

.final-score-number {

    font-size: 32px;

    line-height: 1;

    font-weight: 800;

    white-space: nowrap;
}

.final-score-number span {

    font-size: 10px;

    font-weight: 600;

    opacity: .7;
}

.final-score-footer {

    border-top: 1px solid rgba(255,255,255,.14);

    padding: 10px 22px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;

    font-size: 9px;

    color: rgba(255,255,255,.72);
}

.final-rating-badge {

    background: rgba(255,255,255,.14);

    border: 1px solid rgba(255,255,255,.2);

    border-radius: 20px;

    padding: 4px 9px;

    color: #fff;

    font-weight: 700;
}

/* =========================================================
   GOAL PROGRESS
========================================================= */

.goal-progress-top {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 10px;

    margin-bottom: 10px;
}

.goal-progress-label {

    color: var(--pms-muted);

    font-size: 9px;

    text-transform: uppercase;

    font-weight: 700;
}

.goal-progress-top strong {

    color: var(--pms-primary);

    font-size: 22px;
}

.goal-count-text {

    color: var(--pms-muted);

    font-size: 9px;
}

.progress-custom {

    height: 9px;

    background: #edf2f6;

    border-radius: 20px;

    overflow: hidden;
}

.progress-custom-bar {

    height: 100%;

    background: linear-gradient(
        90deg,
        #1f4e79,
        #4d7ea8
    );

    border-radius: inherit;

    transition: width .3s ease;
}

.goal-mini-stats {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 8px;

    margin-top: 13px;

    color: var(--pms-muted);

    font-size: 8px;

    flex-wrap: wrap;
}

.goal-mini-stats strong {

    color: var(--pms-text);
}

.goal-stat-dot {

    width: 7px;

    height: 7px;

    border-radius: 50%;

    display: inline-block;

    margin-right: 3px;
}

.goal-stat-dot.completed {
    background: #198754;
}

.goal-stat-dot.progress {
    background: #d97706;
}

.goal-stat-dot.pending {
    background: #adb5bd;
}

/* =========================================================
   SCORE SUMMARY
========================================================= */

.score-summary-card {

    background: #fff;

    border: 1px solid var(--pms-border);

    border-radius: 14px;

    padding: 16px;

    min-height: 136px;

    box-shadow:
        0 3px 14px rgba(31,78,121,.035);

    position: relative;

    overflow: hidden;
}

.score-summary-card::after {

    content: '';

    position: absolute;

    right: -22px;

    top: -22px;

    width: 60px;

    height: 60px;

    border-radius: 50%;

    background: #f5f8fc;
}

.score-summary-card.final {

    border-color: #cbddea;

    background: linear-gradient(
        135deg,
        #f5f9fd,
        #ffffff
    );
}

.score-summary-top {

    display: flex;

    align-items: center;

    gap: 9px;

    position: relative;

    z-index: 1;
}

.score-summary-icon {

    width: 34px;

    height: 34px;

    border-radius: 9px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 11px;
}

.score-summary-icon.self {

    background: #e8f1fa;

    color: var(--pms-primary);
}

.score-summary-icon.manager {

    background: #e7f6ed;

    color: #198754;
}

.score-summary-icon.feedback {

    background: #fff4df;

    color: #d97706;
}

.score-summary-icon.hr {

    background: #f0eafa;

    color: #6f42c1;
}

.score-summary-icon.final {

    background: #e8f1fa;

    color: var(--pms-primary);
}

.score-summary-label {

    color: var(--pms-muted);

    font-size: 9px;

    font-weight: 700;

    text-transform: uppercase;
}

.score-summary-value {

    margin-top: 15px;

    color: var(--pms-text);

    font-size: 23px;

    font-weight: 800;

    line-height: 1;
}

.score-summary-value span {

    color: var(--pms-muted);

    font-size: 9px;

    font-weight: 600;
}

.score-summary-footer {

    margin-top: 11px;
}

.score-summary-footer span {

    display: inline-flex;

    align-items: center;

    padding: 4px 8px;

    background: #f4f7fb;

    border-radius: 12px;

    color: var(--pms-primary);

    font-size: 8px;

    font-weight: 800;
}

/* =========================================================
   PERFORMANCE BREAKDOWN
========================================================= */

.performance-bar-row {

    margin-bottom: 19px;
}

.performance-bar-row:last-of-type {

    margin-bottom: 0;
}

.performance-bar-heading {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 6px;
}

.performance-bar-heading span {

    color: var(--pms-text);

    font-size: 10px;

    font-weight: 700;
}

.performance-bar-heading strong {

    color: var(--pms-primary);

    font-size: 10px;
}

.performance-bar {

    height: 8px;

    background: #edf2f6;

    border-radius: 20px;

    overflow: hidden;
}

.performance-bar-fill {

    height: 100%;

    border-radius: inherit;
}

.bar-self {
    background: #1f4e79;
}

.bar-manager {
    background: #198754;
}

.bar-feedback {
    background: #d97706;
}

.bar-hr {
    background: #6f42c1;
}

.breakdown-note {

    margin-top: 20px;

    padding: 10px 11px;

    display: flex;

    align-items: flex-start;

    gap: 8px;

    background: #f4f7fb;

    border: 1px solid #e1e8f0;

    border-radius: 9px;

    color: var(--pms-muted);

    font-size: 9px;

    line-height: 1.5;
}

.breakdown-note i {

    color: var(--pms-primary);

    margin-top: 2px;
}

/* =========================================================
   TIMELINE
========================================================= */

.timeline {

    padding-top: 2px;
}

.timeline-item {

    display: flex;

    align-items: center;

    gap: 10px;
}

.timeline-icon {

    width: 32px;

    height: 32px;

    min-width: 32px;

    border-radius: 50%;

    background: #f1f4f8;

    border: 1px solid #dde4eb;

    color: #8996a4;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 10px;
}

.timeline-icon.done {

    background: #e7f6ed;

    border-color: #c9ead7;

    color: #198754;
}

.timeline-content strong {

    display: block;

    color: var(--pms-text);

    font-size: 10px;
}

.timeline-content small {

    display: block;

    color: var(--pms-muted);

    font-size: 8px;

    margin-top: 2px;
}

.timeline-line {

    width: 1px;

    height: 20px;

    background: #dce3eb;

    margin-left: 16px;
}

/* =========================================================
   VIRTUE MIRROR
========================================================= */

.virtue-dashboard-item {

    margin-bottom: 16px;
}

.virtue-dashboard-item:last-child {

    margin-bottom: 0;
}

.virtue-dashboard-heading {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;

    margin-bottom: 6px;
}

.virtue-dashboard-heading span {

    color: var(--pms-text);

    font-size: 9px;

    font-weight: 700;
}

.virtue-dashboard-heading strong {

    color: var(--pms-primary);

    font-size: 9px;
}

.virtue-dashboard-progress {

    height: 7px;

    background: #edf2f6;

    border-radius: 20px;

    overflow: hidden;
}

.virtue-dashboard-fill {

    height: 100%;

    background: var(--pms-primary);

    border-radius: inherit;
}

.virtue-overall {

    margin-top: 20px;

    padding: 12px;

    border-radius: 10px;

    background: linear-gradient(
        135deg,
        #f4f8fc,
        #edf4fa
    );

    border: 1px solid #dce6f0;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;
}

.virtue-overall small {

    display: block;

    color: var(--pms-muted);

    font-size: 8px;
}

.virtue-overall strong {

    display: block;

    color: var(--pms-text);

    font-size: 10px;

    margin-top: 2px;
}

.virtue-overall-value {

    color: var(--pms-primary);

    font-size: 18px;

    font-weight: 800;
}

.virtue-overall-value span {

    color: var(--pms-muted);

    font-size: 8px;
}

/* =========================================================
   GOAL STAT CARDS
========================================================= */

.goal-stat-card {

    display: flex;

    align-items: center;

    gap: 11px;

    background: #fafcfe;

    border: 1px solid #e7edf2;

    border-radius: 11px;

    padding: 13px 14px;
}

.goal-stat-icon {

    width: 38px;

    height: 38px;

    min-width: 38px;

    border-radius: 10px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 12px;
}

.goal-stat-icon.blue {

    background: #e8f1fa;

    color: var(--pms-primary);
}

.goal-stat-icon.green {

    background: #e7f6ed;

    color: #198754;
}

.goal-stat-icon.purple {

    background: #f0eafa;

    color: #6f42c1;
}

.goal-stat-icon.orange {

    background: #fff4df;

    color: #d97706;
}

.goal-stat-card span {

    display: block;

    color: var(--pms-muted);

    font-size: 8px;

    margin-bottom: 2px;
}

.goal-stat-card strong {

    display: block;

    color: var(--pms-text);

    font-size: 17px;

    line-height: 1;
}

/* =========================================================
   GOAL TABLE
========================================================= */

.dashboard-table {

    margin: 0;
}

.dashboard-table thead th {

    background: #f8fafc;

    border-bottom: 1px solid var(--pms-border);

    color: var(--pms-muted);

    font-size: 8px;

    text-transform: uppercase;

    letter-spacing: .3px;

    padding: 11px 14px;

    white-space: nowrap;
}

.dashboard-table tbody td {

    color: var(--pms-text);

    font-size: 10px;

    vertical-align: middle;

    padding: 13px 14px;

    border-color: #edf1f5;
}

.goal-table-title {

    max-width: 430px;

    font-weight: 600;

    line-height: 1.45;
}

.dashboard-table td small {

    color: var(--pms-muted);

    font-size: 8px;
}

.achievement-badge,
.approved-badge {

    display: inline-flex;

    align-items: center;

    padding: 5px 8px;

    border-radius: 20px;

    font-size: 8px;

    font-weight: 700;

    white-space: nowrap;
}

.achievement-badge.completed {

    background: #e7f6ed;

    color: #198754;
}

.achievement-badge.in_progress {

    background: #fff4df;

    color: #b77900;
}

.achievement-badge.partially_complete {

    background: #e8f1fa;

    color: var(--pms-primary);
}

.achievement-badge.not_started {

    background: #f1f4f8;

    color: #8996a4;
}

.approved-badge {

    background: #e7f6ed;

    color: #198754;
}

/* =========================================================
   INITIATIVES
========================================================= */

.initiative-card {

    height: 100%;

    border: 1px solid #e6ebf0;

    border-radius: 12px;

    background: #fafcfe;

    padding: 15px;
}

.initiative-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;

    margin-bottom: 10px;
}

.initiative-icon {

    width: 36px;

    height: 36px;

    border-radius: 10px;

    background: #fff4df;

    color: #d97706;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 12px;
}

.initiative-approved {

    color: #198754;

    background: #e7f6ed;

    border-radius: 20px;

    padding: 4px 8px;

    font-size: 8px;

    font-weight: 700;
}

.initiative-card h6 {

    color: var(--pms-text);

}

.initiative-card p {

    color: var(--pms-muted);

    font-size: 9px;

    line-height: 1.6;

    margin-bottom: 10px;
}

.initiative-meta {

    display: flex;

    flex-wrap: wrap;

    gap: 8px;

    color: var(--pms-muted);

    font-size: 8px;
}

/* =========================================================
   EMPTY
========================================================= */

.empty-inline {

    min-height: 150px;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    gap: 5px;

    text-align: center;

    color: var(--pms-muted);
}

.empty-inline i {

    font-size: 23px;

    margin-bottom: 4px;

    color: #c5d0da;
}

.empty-inline strong {

    color: var(--pms-text);

    font-size: 11px;
}

.empty-inline span {

    font-size: 9px;
}

/* =========================================================
   DASHBOARD NOTE
========================================================= */

.dashboard-note {

    background: linear-gradient(
        135deg,
        #f5f8fc,
        #ffffff
    );

    border: 1px solid #dce6f0;

    border-radius: 14px;

    padding: 16px 18px;

    display: flex;

    align-items: flex-start;

    gap: 12px;

    box-shadow:
        0 4px 15px rgba(31, 78, 121, .04);
}

.dashboard-note-icon {

    width: 38px;

    height: 38px;

    min-width: 38px;

    border-radius: 9px;

    background: #e8f1fa;

    color: var(--pms-primary);

    display: flex;

    align-items: center;

    justify-content: center;
}

.dashboard-note strong {

    display: block;

    color: var(--pms-text);

    font-size: 11px;

    margin-bottom: 2px;
}

.dashboard-note p {

    color: var(--pms-muted);

    font-size: 9px;

    line-height: 1.6;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1199px) {

    .final-score-number {

        font-size: 28px;
    }

}

@media (max-width: 991px) {

    .profile-details {

        grid-template-columns: 1fr 1fr;
    }

}

@media (max-width: 768px) {

    .dashboard-header {

        padding: 18px;
    }

    .employee-header-badge {

        width: 100%;
    }

    .section-header {

        padding: 15px 16px;
    }

    .section-body {

        padding: 16px;
    }

    .final-score-content {

        padding: 19px;
    }

    .profile-details {

        grid-template-columns: 1fr;
    }

    .dashboard-table {

        min-width: 720px;
    }

}

@media (max-width: 480px) {

    .dashboard-header h3 {

        font-size: 18px;
    }

    .header-icon {

        width: 42px;

        height: 42px;

        font-size: 17px;
    }

    .final-score-content {

        flex-direction: column;

        align-items: flex-start;
    }

    .final-score-number {

        font-size: 27px;
    }

}

</style>

@endsection
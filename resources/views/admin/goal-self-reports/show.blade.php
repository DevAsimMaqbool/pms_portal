@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4 goal-report-page">

        {{-- =========================================================
        PAGE HEADER
        ========================================================== --}}
        <div class="report-header mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center">

                    <div class="header-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>

                    <div class="ms-3">

                        <h3 class="mb-1">
                            Goal Self Report
                        </h3>

                        <p class="mb-0">
                            Review your goal progress, achievement and evaluation history.
                        </p>

                    </div>

                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('goal-self-reports.index') }}" class="btn btn-light back-btn">

                        <i class="fas fa-arrow-left me-2"></i>
                        Back

                    </a>

                    @if($goalSelfReport->goal)

                        <a href="{{ route('newgoals.history', $goalSelfReport->goal) }}"
                            class="btn btn-outline-light history-btn">

                            <i class="fas fa-history me-2"></i>
                            Goal History

                        </a>

                    @endif

                </div>

            </div>

        </div>

        {{-- =========================================================
        STATUS BAR
        ========================================================== --}}
        @php

            $statusConfig = match ($goalSelfReport->status) {

                'submitted' => [
                    'class' => 'status-submitted',
                    'icon' => 'fa-clock',
                    'label' => 'Pending Manager Review'
                ],

                'manager_approved' => [
                    'class' => 'status-manager',
                    'icon' => 'fa-user-check',
                    'label' => 'Manager Approved'
                ],

                'manager_rejected' => [
                    'class' => 'status-rejected',
                    'icon' => 'fa-times-circle',
                    'label' => 'Manager Rejected'
                ],

                'hr_approved' => [
                    'class' => 'status-approved',
                    'icon' => 'fa-check-double',
                    'label' => 'HR Approved'
                ],

                'hr_rejected' => [
                    'class' => 'status-rejected',
                    'icon' => 'fa-times-circle',
                    'label' => 'HR Rejected'
                ],

                default => [
                    'class' => 'status-default',
                    'icon' => 'fa-info-circle',
                    'label' => ucwords(
                        str_replace('_', ' ', $goalSelfReport->status)
                    )
                ]

            };

            $achievementConfig = match ($goalSelfReport->achievement_status) {

                'not_started' => [
                    'class' => 'achievement-not-started',
                    'icon' => 'fa-circle',
                    'label' => 'Not Started'
                ],

                'in_progress' => [
                    'class' => 'achievement-progress',
                    'icon' => 'fa-spinner',
                    'label' => 'In Progress'
                ],

                'partially_complete' => [
                    'class' => 'achievement-partial',
                    'icon' => 'fa-adjust',
                    'label' => 'Partially Complete'
                ],

                'completed' => [
                    'class' => 'achievement-complete',
                    'icon' => 'fa-check-circle',
                    'label' => 'Completed'
                ],

                default => [
                    'class' => 'achievement-default',
                    'icon' => 'fa-circle',
                    'label' => ucwords(
                        str_replace('_', ' ', $goalSelfReport->achievement_status)
                    )
                ]

            };

        @endphp

        <div class="report-status-bar mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center">

                    <div class="status-icon {{ $statusConfig['class'] }}">

                        <i class="fas {{ $statusConfig['icon'] }}"></i>

                    </div>

                    <div class="ms-3">

                        <small>
                            Report Status
                        </small>

                        <div class="status-title">
                            {{ $statusConfig['label'] }}
                        </div>

                    </div>

                </div>

                <div class="submitted-info">

                    <i class="far fa-calendar-alt me-2"></i>

                    Submitted:

                    <strong>
                        {{ optional($goalSelfReport->submitted_at)->format('d M Y, h:i A') ?? 'N/A' }}
                    </strong>

                </div>

            </div>

        </div>

        {{-- =========================================================
        GOAL INFORMATION
        ========================================================== --}}
        <div class="section-card mb-4">

            <div class="section-header">

                <div>

                    <h5 class="mb-1">
                        <i class="fas fa-bullseye me-2"></i>
                        Goal Information
                    </h5>

                    <small>
                        Details of the goal against which this report was submitted.
                    </small>

                </div>

                <span class="section-number">
                    01
                </span>

            </div>

            <div class="section-body">

                {{-- Goal --}}
                <div class="goal-highlight mb-4">

                    <div class="goal-highlight-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>

                    <div>

                        <small>
                            GOAL
                        </small>

                        <h5 class="mb-0">
                            {{ $goalSelfReport->goal->goal ?? 'N/A' }}
                        </h5>

                    </div>

                </div>

                <div class="row g-4">

                    {{-- S2R --}}
                    <div class="col-lg-6">

                        <div class="info-box">

                            <div class="info-label">

                                <i class="fas fa-link me-2"></i>

                                S2R Driver / Enabler Alignment

                            </div>

                            <div class="info-value">

                                @if($goalSelfReport->goal?->s2rDriver)

                                    <span class="s2r-badge">

                                        <i class="fas fa-bullseye me-1"></i>

                                        {{ $goalSelfReport->goal->s2rDriver->driver_name }}

                                    </span>

                                @else

                                    {{ $goalSelfReport->goal->s2r_driver_enabler_alignment ?? 'N/A' }}

                                @endif

                            </div>

                        </div>

                    </div>

                    {{-- Deadline --}}
                    <div class="col-lg-3">

                        <div class="info-box">

                            <div class="info-label">

                                <i class="far fa-calendar-alt me-2"></i>

                                Deadline

                            </div>

                            <div class="info-value fw-semibold">

                                {{ optional($goalSelfReport->goal?->deadline)->format('d M Y') ?? 'N/A' }}

                            </div>

                        </div>

                    </div>

                    {{-- Goal Status --}}
                    <div class="col-lg-3">

                        <div class="info-box">

                            <div class="info-label">

                                <i class="fas fa-flag me-2"></i>

                                Goal Status

                            </div>

                            <div class="info-value">

                                <span class="goal-status">

                                    {{ ucwords(
        str_replace(
            '_',
            ' ',
            $goalSelfReport->goal->status ?? 'N/A'
        )
    ) }}

                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- Objective --}}
                    <div class="col-lg-6">

                        <div class="info-box large-box">

                            <div class="info-label">

                                <i class="fas fa-crosshairs me-2"></i>

                                Objective(s)

                            </div>

                            <div class="info-value">

                                {{ $goalSelfReport->goal->objectives ?: 'No objectives specified.' }}

                            </div>

                        </div>

                    </div>

                    {{-- Target --}}
                    <div class="col-lg-6">

                        <div class="info-box large-box">

                            <div class="info-label">

                                <i class="fas fa-flag-checkered me-2"></i>

                                Target

                            </div>

                            <div class="info-value">

                                {{ $goalSelfReport->goal->target ?? 'N/A' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =========================================================
        SELF REPORT
        ========================================================== --}}
        <div class="section-card mb-4">

            <div class="section-header">

                <div>

                    <h5 class="mb-1">

                        <i class="fas fa-user-edit me-2"></i>

                        Self Assessment

                    </h5>

                    <small>
                        Your progress and achievement assessment.
                    </small>

                </div>

                <span class="section-number">
                    02
                </span>

            </div>

            <div class="section-body">

                <div class="row g-4">

                    {{-- Achievement --}}
                    <div class="col-lg-4">

                        <div class="assessment-box">

                            <div class="assessment-label">
                                Achievement Status
                            </div>

                            <div class="achievement-wrapper">

                                <span class="achievement-badge {{ $achievementConfig['class'] }}">

                                    <i class="fas {{ $achievementConfig['icon'] }} me-2"></i>

                                    {{ $achievementConfig['label'] }}

                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- Self Rating --}}
                    <div class="col-lg-4">

                        <div class="assessment-box rating-box self-rating">

                            <div class="assessment-label">
                                Self Rating
                            </div>

                            <div class="rating-content">

                                <div class="rating-icon">
                                    <i class="fas fa-star"></i>
                                </div>

                                <div>

                                    <span class="rating-value">
                                        {{ $goalSelfReport->rating ?? 0 }}
                                    </span>

                                    <span class="rating-max">
                                        / 5
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Submitted --}}
                    <div class="col-lg-4">

                        <div class="assessment-box">

                            <div class="assessment-label">
                                Report Submitted
                            </div>

                            <div class="submitted-value">

                                <i class="far fa-clock me-2"></i>

                                {{ optional($goalSelfReport->submitted_at)->format('d M Y, h:i A') ?? 'N/A' }}

                            </div>

                        </div>

                    </div>

                    {{-- Progress --}}
                    <div class="col-12">

                        <div class="progress-box">

                            <div class="progress-box-header">

                                <span>
                                    <i class="fas fa-chart-line me-2"></i>
                                    Progress Against Goal
                                </span>

                            </div>

                            <div class="progress-content">

                                {{ $goalSelfReport->progress_against_goal }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =========================================================
        THREE RATINGS
        ========================================================== --}}
        <div class="section-card mb-4">

            <div class="section-header">

                <div>

                    <h5 class="mb-1">

                        <i class="fas fa-star me-2"></i>

                        Evaluation Ratings

                    </h5>

                    <small>
                        Complete evaluation from Employee, Line Manager and HR.
                    </small>

                </div>

                <span class="section-number">
                    03
                </span>

            </div>

            <div class="section-body">

                <div class="row g-4">

                    {{-- SELF --}}
                    <div class="col-lg-6">

                        <div class="evaluation-card self-evaluation">

                            <div class="evaluation-top">

                                <div class="evaluation-icon">
                                    <i class="fas fa-user"></i>
                                </div>

                                <div>

                                    <div class="evaluation-role">
                                        Employee
                                    </div>

                                    <div class="evaluation-title">
                                        Self Rating
                                    </div>

                                </div>

                            </div>

                            <div class="evaluation-rating">

                                <strong>
                                    {{ $goalSelfReport->rating ?? '—' }}
                                </strong>

                                <span>/ 5</span>

                            </div>

                            <div class="evaluation-status">
                                Self Assessment
                            </div>

                        </div>

                    </div>

                    {{-- MANAGER --}}
                    <div class="col-lg-6">

                        <div class="evaluation-card manager-evaluation">

                            <div class="evaluation-top">

                                <div class="evaluation-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>

                                <div>

                                    <div class="evaluation-role">
                                        Line Manager
                                    </div>

                                    <div class="evaluation-title">
                                        Manager Rating
                                    </div>

                                </div>

                            </div>

                            <div class="evaluation-rating">

                                <strong>
                                    {{ $goalSelfReport->manager_rating ?? '—' }}
                                </strong>

                                @if($goalSelfReport->manager_rating !== null)
                                    <span>/ 5</span>
                                @endif

                            </div>

                            <div class="evaluation-status">

                                @if($goalSelfReport->manager_rating !== null)

                                    <i class="fas fa-check-circle me-1"></i>
                                    Reviewed

                                @else

                                    <i class="fas fa-clock me-1"></i>
                                    Awaiting Review

                                @endif

                            </div>

                        </div>

                    </div>

                    {{-- HR --}}
                    <!-- <div class="col-lg-4">

                            <div class="evaluation-card hr-evaluation">

                                <div class="evaluation-top">

                                    <div class="evaluation-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>

                                    <div>

                                        <div class="evaluation-role">
                                            Human Resources
                                        </div>

                                        <div class="evaluation-title">
                                            HR Final Rating
                                        </div>

                                    </div>

                                </div>

                                <div class="evaluation-rating">

                                    <strong>
                                        {{ $goalSelfReport->hr_rating ?? '—' }}
                                    </strong>

                                    @if($goalSelfReport->hr_rating !== null)
                                        <span>/ 5</span>
                                    @endif

                                </div>

                                <div class="evaluation-status">

                                    @if($goalSelfReport->hr_rating !== null)

                                        <i class="fas fa-check-circle me-1"></i>
                                        Finalized

                                    @else

                                        <i class="fas fa-clock me-1"></i>
                                        Awaiting HR

                                    @endif

                                </div>

                            </div>

                        </div> -->

                </div>

            </div>

        </div>

        {{-- =========================================================
        REVIEW HISTORY
        ========================================================== --}}
        <div class="section-card">

            <div class="section-header">

                <div>

                    <h5 class="mb-1">

                        <i class="fas fa-comments me-2"></i>

                        Review History

                    </h5>

                    <small>
                        Manager and HR review decisions, ratings and comments.
                    </small>

                </div>

                <span class="section-number">
                    04
                </span>

            </div>

            <div class="section-body">

                @forelse($goalSelfReport->reviews->sortByDesc('reviewed_at') as $review)

                    <div class="review-card mb-3">

                        <div class="review-left">

                            <div class="review-avatar">

                                @if($review->reviewer_type === 'manager')

                                    <i class="fas fa-user-tie"></i>

                                @else

                                    <i class="fas fa-user-shield"></i>

                                @endif

                            </div>

                        </div>

                        <div class="review-content">

                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">

                                <div>

                                    <h6 class="reviewer-name mb-1">

                                        {{ $review->reviewer->name ?? 'N/A' }}

                                    </h6>

                                    <span class="reviewer-role">

                                        {{ ucfirst($review->reviewer_type) }}

                                    </span>

                                </div>

                                <div class="text-end">

                                    @if($review->decision === 'approved')

                                        <span class="decision-badge approved">

                                            <i class="fas fa-check me-1"></i>
                                            Approved

                                        </span>

                                    @else

                                        <span class="decision-badge rejected">

                                            <i class="fas fa-times me-1"></i>
                                            Rejected

                                        </span>

                                    @endif

                                    <div class="review-date mt-2">

                                        {{ optional($review->reviewed_at)->format('d M Y, h:i A') }}

                                    </div>

                                </div>

                            </div>

                            {{-- Rating --}}
                            @if($review->reviewer_type === 'manager')

                                <div class="review-rating manager-review-rating">

                                    <i class="fas fa-star me-1"></i>

                                    Manager Rating:

                                    <strong>
                                        {{ $goalSelfReport->manager_rating ?? '—' }}/5
                                    </strong>

                                </div>

                            @elseif($review->reviewer_type === 'hr')

                                <div class="review-rating hr-review-rating">

                                    <i class="fas fa-star me-1"></i>

                                    HR Final Rating:

                                    <strong>
                                        {{ $goalSelfReport->hr_rating ?? '—' }}/5
                                    </strong>

                                </div>

                            @endif

                            @if($review->comments)

                                <div class="review-comments">

                                    <div class="comment-label">

                                        <i class="fas fa-comment-dots me-2"></i>
                                        Comments

                                    </div>

                                    <div class="comment-text">

                                        {{ $review->comments }}

                                    </div>

                                </div>

                            @else

                                <div class="no-comments">
                                    No comments provided.
                                </div>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="empty-reviews">

                        <div class="empty-review-icon">

                            <i class="fas fa-comments"></i>

                        </div>

                        <h6>
                            No Reviews Yet
                        </h6>

                        <p class="mb-0">
                            This report has not been reviewed by the Line Manager or HR yet.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

    {{-- =============================================================
    STYLES
    ============================================================= --}}
    <style>
        /* =========================================================
                       BASE
                    ========================================================== */

        .goal-report-page {
            color: #243447;
        }

        /* =========================================================
                       HEADER
                    ========================================================== */

        .report-header {
            background: linear-gradient(135deg,
                    #1f4e79 0%,
                    #286090 55%,
                    #337ab7 100%);

            border-radius: 16px;

            padding: 24px 28px;

            color: #fff;

            box-shadow:
                0 8px 25px rgba(31, 78, 121, .18);
        }

        .header-icon {
            width: 52px;
            height: 52px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background: rgba(255, 255, 255, .15);

            font-size: 21px;
        }

        .report-header h3 {
            color: #fff;
            font-weight: 700;
        }

        .report-header p {
            color: rgba(255, 255, 255, .75);
            font-size: 13px;
        }

        .back-btn {
            border: 0;
            color: #1f4e79;
            font-weight: 600;
        }

        .history-btn {
            border-color: rgba(255, 255, 255, .6);
            color: #fff;
            font-weight: 600;
        }

        .history-btn:hover {
            background: #fff;
            color: #1f4e79;
        }

        /* =========================================================
                       STATUS BAR
                    ========================================================== */

        .report-status-bar {
            background: #fff;

            border: 1px solid #e8edf2;

            border-radius: 14px;

            padding: 16px 20px;

            box-shadow:
                0 4px 18px rgba(31, 78, 121, .06);
        }

        .status-icon {
            width: 42px;
            height: 42px;

            border-radius: 11px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-icon.status-submitted {
            background: #fff3df;
            color: #c77700;
        }

        .status-icon.status-manager {
            background: #e8f1fb;
            color: #1f4e79;
        }

        .status-icon.status-approved {
            background: #e5f7ed;
            color: #167447;
        }

        .status-icon.status-rejected {
            background: #fdecec;
            color: #b42318;
        }

        .status-icon.status-default {
            background: #f1f3f5;
            color: #667085;
        }

        .report-status-bar small {
            color: #8a96a3;
            font-size: 11px;
        }

        .status-title {
            font-weight: 700;
            color: #26384a;
        }

        .submitted-info {
            color: #8a96a3;
            font-size: 12px;
        }

        .submitted-info strong {
            color: #34495e;
        }

        /* =========================================================
                       SECTION CARD
                    ========================================================== */

        .section-card {
            background: #fff;

            border: 1px solid #e8edf2;

            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 5px 20px rgba(31, 78, 121, .06);
        }

        .section-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 18px 22px;

            border-bottom: 1px solid #edf1f5;

            background: #fbfcfe;
        }

        .section-header h5 {
            color: #26384a;
            font-weight: 700;
        }

        .section-header h5 i {
            color: #1f4e79;
        }

        .section-header small {
            color: #8a96a3;
            font-size: 11px;
        }

        .section-number {
            width: 34px;
            height: 34px;

            border-radius: 9px;

            background: #edf5fc;

            color: #1f4e79;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 11px;

            font-weight: 700;
        }

        .section-body {
            padding: 22px;
        }

        /* =========================================================
                       GOAL HIGHLIGHT
                    ========================================================== */

        .goal-highlight {
            display: flex;

            align-items: flex-start;

            gap: 15px;

            padding: 18px;

            background: linear-gradient(135deg,
                    #f4f8fc,
                    #edf5fc);

            border: 1px solid #dce9f5;

            border-radius: 12px;
        }

        .goal-highlight-icon {
            width: 42px;
            height: 42px;

            min-width: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #1f4e79;

            color: #fff;

            border-radius: 10px;
        }

        .goal-highlight small {
            color: #7b8794;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: .5px;
        }

        .goal-highlight h5 {
            color: #26384a;

            font-weight: 700;

            line-height: 1.5;

            margin-top: 3px;
        }

        /* =========================================================
                       INFO BOX
                    ========================================================== */

        .info-box {
            height: 100%;

            padding: 16px;

            background: #fafbfd;

            border: 1px solid #e9eef3;

            border-radius: 11px;
        }

        .large-box {
            min-height: 115px;
        }

        .info-label {
            color: #7b8794;

            font-size: 11px;

            font-weight: 700;

            margin-bottom: 9px;

            text-transform: uppercase;

            letter-spacing: .25px;
        }

        .info-label i {
            color: #1f4e79;
        }

        .info-value {
            color: #354657;

            font-size: 13px;

            line-height: 1.6;
        }

        .s2r-badge {
            display: inline-flex;

            align-items: center;

            background: #e8f1fb;

            color: #1f4e79;

            padding: 7px 11px;

            border-radius: 7px;

            font-weight: 600;

            font-size: 12px;
        }

        .goal-status {
            display: inline-block;

            background: #e8f1fb;

            color: #1f4e79;

            padding: 6px 10px;

            border-radius: 7px;

            font-size: 11px;

            font-weight: 700;
        }

        /* =========================================================
                       ASSESSMENT
                    ========================================================== */

        .assessment-box {
            height: 100%;

            padding: 18px;

            border: 1px solid #e9eef3;

            background: #fff;

            border-radius: 12px;
        }

        .assessment-label {
            color: #7b8794;

            font-size: 11px;

            font-weight: 700;

            margin-bottom: 12px;

            text-transform: uppercase;
        }

        .achievement-wrapper {
            min-height: 38px;

            display: flex;

            align-items: center;
        }

        .achievement-badge {
            display: inline-flex;

            align-items: center;

            padding: 8px 12px;

            border-radius: 8px;

            font-size: 11px;

            font-weight: 700;
        }

        .achievement-not-started {
            background: #f1f3f5;
            color: #667085;
        }

        .achievement-progress {
            background: #e8f1fb;
            color: #1f4e79;
        }

        .achievement-partial {
            background: #fff4df;
            color: #b36b00;
        }

        .achievement-complete {
            background: #e5f7ed;
            color: #167447;
        }

        .achievement-default {
            background: #f1f3f5;
            color: #667085;
        }

        /* =========================================================
                       RATING
                    ========================================================== */

        .rating-content {
            display: flex;

            align-items: center;

            gap: 10px;
        }

        .rating-icon {
            width: 36px;
            height: 36px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #fff5d9;

            color: #e0a100;

            border-radius: 9px;
        }

        .rating-value {
            font-size: 26px;

            color: #1f4e79;

            font-weight: 800;
        }

        .rating-max {
            color: #8a96a3;

            font-size: 13px;
        }

        .submitted-value {
            color: #34495e;

            font-size: 12px;

            font-weight: 600;

            margin-top: 8px;
        }

        /* =========================================================
                       PROGRESS
                    ========================================================== */

        .progress-box {
            border: 1px solid #e9eef3;

            border-radius: 12px;

            overflow: hidden;
        }

        .progress-box-header {
            padding: 12px 16px;

            background: #f7f9fc;

            border-bottom: 1px solid #e9eef3;

            color: #34495e;

            font-size: 12px;

            font-weight: 700;
        }

        .progress-box-header i {
            color: #1f4e79;
        }

        .progress-content {
            padding: 17px;

            color: #475569;

            font-size: 13px;

            line-height: 1.7;

            white-space: pre-line;
        }

        /* =========================================================
                       EVALUATION CARDS
                    ========================================================== */

        .evaluation-card {
            padding: 20px;

            border-radius: 13px;

            border: 1px solid;

            height: 100%;

            position: relative;

            overflow: hidden;
        }

        .self-evaluation {
            background: #f7faff;
            border-color: #dce9f5;
        }

        .manager-evaluation {
            background: #fffaf0;
            border-color: #f4e4bd;
        }

        .hr-evaluation {
            background: #f4fbf7;
            border-color: #d5eddf;
        }

        .evaluation-top {
            display: flex;

            align-items: center;

            gap: 12px;
        }

        .evaluation-icon {
            width: 42px;
            height: 42px;

            border-radius: 10px;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .self-evaluation .evaluation-icon {
            background: #e4eef8;
            color: #1f4e79;
        }

        .manager-evaluation .evaluation-icon {
            background: #fff0ce;
            color: #b36b00;
        }

        .hr-evaluation .evaluation-icon {
            background: #dff3e7;
            color: #167447;
        }

        .evaluation-role {
            font-size: 10px;

            color: #8a96a3;

            text-transform: uppercase;

            font-weight: 700;
        }

        .evaluation-title {
            font-size: 13px;

            color: #34495e;

            font-weight: 700;

            margin-top: 2px;
        }

        .evaluation-rating {
            margin-top: 20px;
        }

        .evaluation-rating strong {
            font-size: 36px;

            color: #26384a;

            font-weight: 800;
        }

        .evaluation-rating span {
            color: #8a96a3;

            font-size: 13px;
        }

        .evaluation-status {
            margin-top: 7px;

            color: #7b8794;

            font-size: 11px;
        }

        .manager-evaluation .evaluation-status {
            color: #b36b00;
        }

        .hr-evaluation .evaluation-status {
            color: #167447;
        }

        /* =========================================================
                       REVIEW CARDS
                    ========================================================== */

        .review-card {
            display: flex;

            gap: 15px;

            padding: 18px;

            border: 1px solid #e7edf2;

            border-radius: 12px;

            background: #fff;

            transition: all .2s ease;
        }

        .review-card:hover {
            box-shadow:
                0 5px 15px rgba(31, 78, 121, .07);
        }

        .review-avatar {
            width: 44px;
            height: 44px;

            min-width: 44px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 11px;

            background: #edf5fc;

            color: #1f4e79;
        }

        .review-content {
            flex: 1;
        }

        .reviewer-name {
            color: #26384a;

            font-weight: 700;
        }

        .reviewer-role {
            color: #8a96a3;

            font-size: 11px;

            text-transform: capitalize;
        }

        .decision-badge {
            display: inline-flex;

            align-items: center;

            padding: 6px 10px;

            border-radius: 7px;

            font-size: 10px;

            font-weight: 700;
        }

        .decision-badge.approved {
            background: #e5f7ed;

            color: #167447;
        }

        .decision-badge.rejected {
            background: #fdecec;

            color: #b42318;
        }

        .review-date {
            color: #98a2b3;

            font-size: 10px;
        }

        .review-rating {
            display: inline-block;

            margin-top: 14px;

            padding: 7px 11px;

            border-radius: 7px;

            font-size: 11px;

            font-weight: 600;
        }

        .manager-review-rating {
            background: #fff4df;

            color: #a96400;
        }

        .hr-review-rating {
            background: #e5f7ed;

            color: #167447;
        }

        .review-comments {
            margin-top: 12px;

            padding: 12px 14px;

            background: #f8fafc;

            border-radius: 8px;
        }

        .comment-label {
            color: #667085;

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;

            margin-bottom: 5px;
        }

        .comment-label i {
            color: #1f4e79;
        }

        .comment-text {
            color: #475569;

            font-size: 12px;

            line-height: 1.6;
        }

        .no-comments {
            margin-top: 12px;

            color: #98a2b3;

            font-size: 11px;

            font-style: italic;
        }

        /* =========================================================
                       EMPTY REVIEWS
                    ========================================================== */

        .empty-reviews {
            text-align: center;

            padding: 45px 20px;
        }

        .empty-review-icon {
            width: 60px;
            height: 60px;

            margin: 0 auto 15px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 15px;

            background: #edf5fc;

            color: #1f4e79;

            font-size: 23px;
        }

        .empty-reviews h6 {
            color: #34495e;

            font-weight: 700;
        }

        .empty-reviews p {
            color: #8a96a3;

            font-size: 12px;
        }

        /* =========================================================
                       RESPONSIVE
                    ========================================================== */

        @media(max-width: 768px) {

            .report-header {
                padding: 20px;
            }

            .report-header .btn {
                flex: 1;
            }

            .section-body {
                padding: 16px;
            }

            .section-header {
                padding: 16px;
            }

            .review-card {
                flex-direction: column;
            }

            .review-left {
                display: flex;
            }

            .submitted-info {
                width: 100%;
            }

        }
    </style>

@endsection
@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4">

        {{-- =========================================================
            PAGE HEADER
        ========================================================== --}}
        <div class="history-page-header mb-4">

            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="header-icon">
                        <i class="fas fa-history"></i>
                    </span>

                    <h3 class="fw-bold mb-0">
                        Goal History
                    </h3>
                </div>

                <p class="text-muted mb-0 ms-1">
                    Complete goal, self-report, manager review and HR final decision history.
                </p>
            </div>

            <a href="{{ url()->previous() }}"
               class="btn btn-light border rounded-pill px-4">

                <i class="fas fa-arrow-left me-2"></i>
                Back
            </a>

        </div>

        {{-- =========================================================
            GOAL OVERVIEW
        ========================================================== --}}
        <div class="goal-overview-card mb-4">

            <div class="goal-overview-header">

                <div>
                    <span class="section-label">
                        GOAL OVERVIEW
                    </span>

                    <h4 class="fw-bold mb-0 mt-1">
                        {{ $newgoal->goal }}
                    </h4>
                </div>

                <div>
                    @php
                        $statusClass = match ($newgoal->status) {
                            'active' => 'status-active',
                            'completed' => 'status-completed',
                            'cancelled' => 'status-cancelled',
                            default => 'status-default',
                        };
                    @endphp

                    <span class="goal-status {{ $statusClass }}">
                        <span class="status-dot"></span>
                        {{ ucwords(str_replace('_', ' ', $newgoal->status)) }}
                    </span>
                </div>

            </div>

            <div class="goal-overview-body">

                <div class="row g-4">

                    {{-- Employee --}}
                    <div class="col-xl-3 col-md-6">

                        <div class="info-item">

                            <div class="info-icon employee-icon">
                                <i class="fas fa-user"></i>
                            </div>

                            <div>
                                <div class="info-label">
                                    Employee
                                </div>

                                <div class="info-value">
                                    {{ $newgoal->user->name ?? 'N/A' }}
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- S2R --}}
                    <div class="col-xl-3 col-md-6">

                        <div class="info-item">

                            <div class="info-icon s2r-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>

                            <div>

                                <div class="info-label">
                                    S2R Driver / Enabler
                                </div>

                                <div class="info-value">

                                    {{ optional($newgoal->s2rDriver)->driver_name ?? 'N/A' }}

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Deadline --}}
                    <div class="col-xl-3 col-md-6">

                        <div class="info-item">

                            <div class="info-icon deadline-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>

                            <div>

                                <div class="info-label">
                                    Deadline
                                </div>

                                <div class="info-value">

                                    {{ optional($newgoal->deadline)->format('d M Y') }}

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Created --}}
                    <div class="col-xl-3 col-md-6">

                        <div class="info-item">

                            <div class="info-icon created-icon">
                                <i class="fas fa-clock"></i>
                            </div>

                            <div>

                                <div class="info-label">
                                    Created
                                </div>

                                <div class="info-value">

                                    {{ optional($newgoal->created_at)->format('d M Y') }}

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Objective --}}
                    <div class="col-md-6">

                        <div class="detail-box">

                            <div class="detail-title">
                                <i class="fas fa-list-check me-2"></i>
                                Objective(s)
                            </div>

                            <div class="detail-content">

                                {{ $newgoal->objectives ?: 'No objectives specified.' }}

                            </div>

                        </div>

                    </div>

                    {{-- Target --}}
                    <div class="col-md-6">

                        <div class="detail-box">

                            <div class="detail-title">
                                <i class="fas fa-flag-checkered me-2"></i>
                                Target
                            </div>

                            <div class="detail-content">

                                {{ $newgoal->target }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =========================================================
            RATINGS SUMMARY
        ========================================================== --}}

        @if($newgoal->selfReports->count())

            @php
                $latestReport = $newgoal->selfReports->sortByDesc('id')->first();
            @endphp

            <div class="ratings-summary-card mb-4">

                <div class="ratings-header">

                    <div>
                        <span class="section-label">
                            PERFORMANCE RATINGS
                        </span>

                        <h5 class="fw-bold mb-0 mt-1">
                            Three-Level Rating Summary
                        </h5>
                    </div>

                    <div class="rating-scale">
                        Rating Scale: <strong>0 — 5</strong>
                    </div>

                </div>

                <div class="ratings-body">

                    <div class="row g-3">

                        {{-- Self --}}
                        <div class="col-lg-4 col-md-6">

                            <div class="rating-card self-rating">

                                <div class="rating-card-top">

                                    <div class="rating-person-icon">
                                        <i class="fas fa-user"></i>
                                    </div>

                                    <div>

                                        <div class="rating-title">
                                            Employee Self Rating
                                        </div>

                                        <div class="rating-subtitle">
                                            Employee assessment
                                        </div>

                                    </div>

                                </div>

                                <div class="rating-score">

                                    {{ $latestReport->rating ?? 0 }}

                                    <span>/5</span>

                                </div>

                            </div>

                        </div>

                        {{-- Manager --}}
                        <div class="col-lg-4 col-md-6">

                            <div class="rating-card manager-rating">

                                <div class="rating-card-top">

                                    <div class="rating-person-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>

                                    <div>

                                        <div class="rating-title">
                                            Line Manager Rating
                                        </div>

                                        <div class="rating-subtitle">
                                            Manager assessment
                                        </div>

                                    </div>

                                </div>

                                <div class="rating-score">

                                    @if($latestReport->manager_rating !== null)

                                        {{ $latestReport->manager_rating }}

                                        <span>/5</span>

                                    @else

                                        <span class="not-rated">
                                            Not Rated
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                        {{-- HR --}}
                        <div class="col-lg-4 col-md-6">

                            <div class="rating-card hr-rating">

                                <div class="rating-card-top">

                                    <div class="rating-person-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>

                                    <div>

                                        <div class="rating-title">
                                            HR Final Rating
                                        </div>

                                        <div class="rating-subtitle">
                                            Final HR decision
                                        </div>

                                    </div>

                                </div>

                                <div class="rating-score">

                                    @if($latestReport->hr_rating !== null)

                                        {{ $latestReport->hr_rating }}

                                        <span>/5</span>

                                    @else

                                        <span class="not-rated">
                                            Not Rated
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @endif

        {{-- =========================================================
            REPORT DETAILS
        ========================================================== --}}

        @foreach($newgoal->selfReports->sortByDesc('id') as $report)

                    <div class="report-card mb-4">

                        <div class="report-header">

                            <div>

                                <span class="section-label">
                                    SELF REPORT
                                </span>

                                <h5 class="fw-bold mb-0 mt-1">

                                    Report #{{ $report->id }}

                                </h5>

                            </div>

                            @php
                                $reportStatusClass = match ($report->status) {
                                    'submitted' => 'status-submitted',
                                    'manager_approved' => 'status-manager',
                                    'hr_approved' => 'status-approved',
                                    'manager_rejected',
                                    'hr_rejected' => 'status-rejected',
                                    default => 'status-default',
                                };
                            @endphp

                            <span class="report-status {{ $reportStatusClass }}">

                                {{ ucwords(str_replace('_', ' ', $report->status)) }}

                            </span>

                        </div>

                        <div class="report-body">

                            <div class="row g-4">

                                {{-- Progress --}}
                                <div class="col-lg-8">

                                    <div class="detail-box h-100">

                                        <div class="detail-title">

                                            <i class="fas fa-chart-line me-2"></i>

                                            Progress Against Goal

                                        </div>

                                        <div class="detail-content">

                                            {{ $report->progress_against_goal }}

                                        </div>

                                    </div>

                                </div>

                                {{-- Achievement --}}
                                <div class="col-lg-4">

                                    <div class="detail-box h-100">

                                        <div class="detail-title">

                                            <i class="fas fa-trophy me-2"></i>

                                            Achievement Status

                                        </div>

                                        <div class="mt-3">

                                            @php

                                                $achievementClass = match ($report->achievement_status) {

                                                    'not_started' =>
                                                    'achievement-not-started',

                                                    'in_progress' =>
                                                    'achievement-progress',

                                                    'partially_complete' =>
                                                    'achievement-partial',

                                                    'completed' =>
                                                    'achievement-completed',

                                                    default =>
                                                    'achievement-default',

                                                };

                                            @endphp

                                            <span class="achievement-badge {{ $achievementClass }}">

                                                {{ ucwords(
                str_replace(
                    '_',
                    ' ',
                    $report->achievement_status
                )
            ) }}

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            {{-- Reviews --}}
                            <div class="reviews-section mt-4">

                                <div class="reviews-title">

                                    <i class="fas fa-comments me-2"></i>

                                    Review & Approval Details

                                </div>

                                <div class="row g-3 mt-1">

                                    {{-- Manager Review --}}
                                    <div class="col-lg-6">

                                        <div class="review-box manager-review-box">

                                            <div class="review-header">

                                                <div class="review-role">

                                                    <span class="review-icon manager-review-icon">

                                                        <i class="fas fa-user-tie"></i>

                                                    </span>

                                                    <div>

                                                        <strong>
                                                            Line Manager Review
                                                        </strong>

                                                        <small>
                                                            {{ optional($report->managerReview?->reviewer)->name ?? 'Pending Review' }}
                                                        </small>

                                                    </div>

                                                </div>

                                                <div class="review-rating">

                                                    @if($report->manager_rating !== null)

                                                        <strong>
                                                            {{ $report->manager_rating }}
                                                        </strong>

                                                        <small>/5</small>

                                                    @else

                                                        <span>
                                                            Pending
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                            @if($report->managerReview)

                                                <div class="review-comment">

                                                    {{ $report->managerReview->comments ?: 'No comments provided.' }}

                                                </div>

                                                @if($report->managerReview->reviewed_at)

                                                    <small class="review-date">

                                                        <i class="far fa-clock me-1"></i>

                                                        {{ $report->managerReview->reviewed_at->format('d M Y, h:i A') }}

                                                    </small>

                                                @endif

                                            @else

                                                <div class="pending-review">

                                                    <i class="fas fa-hourglass-half me-2"></i>

                                                    Waiting for Line Manager review.

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                    {{-- HR Review --}}
                                    <div class="col-lg-6">

                                        <div class="review-box hr-review-box">

                                            <div class="review-header">

                                                <div class="review-role">

                                                    <span class="review-icon hr-review-icon">

                                                        <i class="fas fa-user-shield"></i>

                                                    </span>

                                                    <div>

                                                        <strong>
                                                            HR Final Review
                                                        </strong>

                                                        <small>
                                                            {{ optional($report->hrReview?->reviewer)->name ?? 'Pending Final Decision' }}
                                                        </small>

                                                    </div>

                                                </div>

                                                <div class="review-rating">

                                                    @if($report->hr_rating !== null)

                                                        <strong>
                                                            {{ $report->hr_rating }}
                                                        </strong>

                                                        <small>/5</small>

                                                    @else

                                                        <span>
                                                            Pending
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                            @if($report->hrReview)

                                                <div class="review-comment">

                                                    {{ $report->hrReview->comments ?: 'No comments provided.' }}

                                                </div>

                                                @if($report->hrReview->reviewed_at)

                                                    <small class="review-date">

                                                        <i class="far fa-clock me-1"></i>

                                                        {{ $report->hrReview->reviewed_at->format('d M Y, h:i A') }}

                                                    </small>

                                                @endif

                                            @else

                                                <div class="pending-review">

                                                    <i class="fas fa-hourglass-half me-2"></i>

                                                    Waiting for HR final review.

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

        @endforeach

        {{-- =========================================================
            ACTIVITY TIMELINE
        ========================================================== --}}

        <div class="timeline-card">

            <div class="timeline-header">

                <div>

                    <span class="section-label">
                        AUDIT TRAIL
                    </span>

                    <h5 class="fw-bold mb-0 mt-1">
                        Activity Timeline
                    </h5>

                </div>

                <span class="history-count">

                    {{ $histories->count() }}

                    {{ Str::plural('Activity', $histories->count()) }}

                </span>

            </div>

            <div class="timeline-body">

                @forelse($histories as $history)

                    @php
                        $metadata = is_array($history->metadata)
                            ? $history->metadata
                            : (json_decode($history->metadata ?? '{}', true) ?: []);

                        $actionLower = strtolower($history->action ?? '');

                        if (str_contains($actionLower, 'hr')) {
                            $timelineIcon = 'fa-user-shield';
                            $timelineClass = 'timeline-hr';
                        } elseif (str_contains($actionLower, 'manager')) {
                            $timelineIcon = 'fa-user-tie';
                            $timelineClass = 'timeline-manager';
                        } elseif (str_contains($actionLower, 'report')) {
                            $timelineIcon = 'fa-chart-line';
                            $timelineClass = 'timeline-report';
                        } else {
                            $timelineIcon = 'fa-bullseye';
                            $timelineClass = 'timeline-goal';
                        }
                    @endphp

                    <div class="timeline-item">

                        <div class="timeline-line"></div>

                        <div class="timeline-marker {{ $timelineClass }}">

                            <i class="fas {{ $timelineIcon }}"></i>

                        </div>

                        <div class="timeline-content">

                            <div class="timeline-content-header">

                                <div>

                                    <h6 class="fw-bold mb-1">

                                        {{ $history->action }}

                                    </h6>

                                    <div class="timeline-user">

                                        <i class="fas fa-user-circle me-1"></i>

                                        {{ $history->user->name ?? 'System' }}

                                    </div>

                                </div>

                                <div class="timeline-date">

                                    {{ $history->created_at->format('d M Y, h:i A') }}

                                </div>

                            </div>

                            {{-- Status Change --}}
                            @if($history->from_status || $history->to_status)

                                <div class="status-transition mt-3">

                                    @if($history->from_status)

                                                                    <span class="old-status">

                                                                        {{ ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $history->from_status
                                            )
                                        ) }}

                                                                    </span>

                                                                    <i class="fas fa-arrow-right mx-2"></i>

                                    @endif

                                    @if($history->to_status)

                                                                    <span class="new-status">

                                                                        {{ ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $history->to_status
                                            )
                                        ) }}

                                                                    </span>

                                    @endif

                                </div>

                            @endif

                            {{-- Comments --}}
                            @if($history->comments)

                                <div class="timeline-comment mt-3">

                                    <div class="timeline-comment-title">

                                        <i class="fas fa-comment-dots me-2"></i>

                                        Comments

                                    </div>

                                    <div class="mt-1">

                                        {{ $history->comments }}

                                    </div>

                                </div>

                            @endif

                            {{-- Ratings --}}
                            @if(
                                    isset($metadata['rating']) ||
                                    isset($metadata['manager_rating']) ||
                                    isset($metadata['hr_rating'])
                                )

                                    <div class="timeline-ratings mt-3">

                                        @if(isset($metadata['rating']))

                                            <div class="mini-rating self-mini">

                                                <i class="fas fa-user me-1"></i>

                                                Self:

                                                <strong>
                                                    {{ $metadata['rating'] }}/5
                                                </strong>

                                            </div>

                                        @endif

                                        @if(isset($metadata['manager_rating']))

                                            <div class="mini-rating manager-mini">

                                                <i class="fas fa-user-tie me-1"></i>

                                                Manager:

                                                <strong>
                                                    {{ $metadata['manager_rating'] }}/5
                                                </strong>

                                            </div>

                                        @endif

                                        @if(isset($metadata['hr_rating']))

                                            <div class="mini-rating hr-mini">

                                                <i class="fas fa-user-shield me-1"></i>

                                                HR:

                                                <strong>
                                                    {{ $metadata['hr_rating'] }}/5
                                                </strong>

                                            </div>

                                        @endif

                                    </div>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="empty-history">

                        <div class="empty-history-icon">

                            <i class="fas fa-history"></i>

                        </div>

                        <h6 class="fw-bold">
                            No History Available
                        </h6>

                        <p class="text-muted mb-0">
                            No activity has been recorded for this goal yet.
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

        .history-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1f4e79, #3478b9);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 15px rgba(31, 78, 121, .20);
        }

        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #718096;
        }

        /* Goal Overview */

        .goal-overview-card,
        .ratings-summary-card,
        .report-card,
        .timeline-card {
            background: #fff;
            border: 1px solid #edf0f5;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
            overflow: hidden;
        }

        .goal-overview-header,
        .ratings-header,
        .report-header,
        .timeline-header {
            padding: 22px 26px;
            border-bottom: 1px solid #edf0f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .goal-overview-body,
        .ratings-body,
        .report-body,
        .timeline-body {
            padding: 26px;
        }

        .goal-status,
        .report-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-active {
            background: #ecfdf3;
            color: #15803d;
        }

        .status-completed,
        .status-approved {
            background: #eaf7ef;
            color: #16803c;
        }

        .status-cancelled,
        .status-rejected {
            background: #fef2f2;
            color: #dc2626;
        }

        .status-submitted {
            background: #eff6ff;
            color: #2563eb;
        }

        .status-manager {
            background: #fff7ed;
            color: #c2410c;
        }

        .status-default {
            background: #f1f5f9;
            color: #475569;
        }

        /* Info */

        .info-item {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .info-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .employee-icon {
            background: #eef2ff;
            color: #4f46e5;
        }

        .s2r-icon {
            background: #ecfeff;
            color: #0891b2;
        }

        .deadline-icon {
            background: #fff7ed;
            color: #ea580c;
        }

        .created-icon {
            background: #f0fdf4;
            color: #16a34a;
        }

        .info-label {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .info-value {
            color: #1e293b;
            font-size: 14px;
            font-weight: 700;
            margin-top: 2px;
        }

        .detail-box {
            height: 100%;
            background: #f8fafc;
            border: 1px solid #edf0f5;
            border-radius: 14px;
            padding: 18px;
        }

        .detail-title {
            color: #334155;
            font-size: 13px;
            font-weight: 700;
        }

        .detail-content {
            color: #475569;
            font-size: 14px;
            line-height: 1.7;
            margin-top: 10px;
            white-space: pre-line;
        }

        /* Ratings */

        .rating-scale {
            color: #94a3b8;
            font-size: 12px;
        }

        .rating-card {
            position: relative;
            padding: 22px;
            border-radius: 16px;
            border: 1px solid;
            min-height: 150px;
            overflow: hidden;
        }

        .rating-card::after {
            content: '';
            position: absolute;
            width: 90px;
            height: 90px;
            right: -30px;
            bottom: -35px;
            border-radius: 50%;
            opacity: .08;
            background: currentColor;
        }

        .self-rating {
            background: #f8faff;
            border-color: #dbeafe;
            color: #2563eb;
        }

        .manager-rating {
            background: #fffbf5;
            border-color: #fed7aa;
            color: #ea580c;
        }

        .hr-rating {
            background: #f5fff8;
            border-color: #bbf7d0;
            color: #16a34a;
        }

        .rating-card-top {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .rating-person-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .rating-title {
            color: #334155;
            font-size: 13px;
            font-weight: 700;
        }

        .rating-subtitle {
            color: #94a3b8;
            font-size: 11px;
            margin-top: 2px;
        }

        .rating-score {
            font-size: 38px;
            font-weight: 800;
            line-height: 1;
            margin-top: 18px;
        }

        .rating-score span {
            font-size: 14px;
            color: #94a3b8;
            font-weight: 600;
        }

        .not-rated {
            font-size: 15px !important;
            color: #94a3b8 !important;
        }

        /* Achievement */

        .achievement-badge {
            display: inline-flex;
            padding: 9px 15px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .achievement-not-started {
            background: #f1f5f9;
            color: #64748b;
        }

        .achievement-progress {
            background: #eff6ff;
            color: #2563eb;
        }

        .achievement-partial {
            background: #fff7ed;
            color: #c2410c;
        }

        .achievement-completed {
            background: #ecfdf5;
            color: #15803d;
        }

        .achievement-default {
            background: #f1f5f9;
            color: #475569;
        }

        /* Reviews */

        .reviews-section {
            border-top: 1px solid #edf0f5;
            padding-top: 24px;
        }

        .reviews-title {
            color: #334155;
            font-size: 14px;
            font-weight: 700;
        }

        .review-box {
            border: 1px solid #edf0f5;
            border-radius: 15px;
            padding: 18px;
            background: #fff;
        }

        .manager-review-box {
            border-left: 4px solid #f59e0b;
        }

        .hr-review-box {
            border-left: 4px solid #16a34a;
        }

        .review-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .review-role {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-role strong {
            display: block;
            font-size: 13px;
            color: #334155;
        }

        .review-role small {
            display: block;
            color: #94a3b8;
            font-size: 11px;
            margin-top: 2px;
        }

        .review-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .manager-review-icon {
            background: #fff7ed;
            color: #ea580c;
        }

        .hr-review-icon {
            background: #ecfdf5;
            color: #16a34a;
        }

        .review-rating {
            text-align: right;
            color: #334155;
        }

        .review-rating strong {
            font-size: 25px;
        }

        .review-rating small {
            color: #94a3b8;
        }

        .review-comment {
            margin-top: 16px;
            padding: 13px;
            background: #f8fafc;
            border-radius: 10px;
            color: #475569;
            font-size: 13px;
            line-height: 1.6;
        }

        .review-date {
            display: block;
            margin-top: 10px;
            color: #94a3b8;
        }

        .pending-review {
            margin-top: 16px;
            padding: 12px;
            border-radius: 10px;
            background: #f8fafc;
            color: #94a3b8;
            font-size: 12px;
        }

        /* Timeline */

        .history-count {
            background: #f1f5f9;
            color: #64748b;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .timeline-body {
            position: relative;
        }

        .timeline-item {
            position: relative;
            display: flex;
            gap: 18px;
            padding-bottom: 28px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-marker {
            position: relative;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            border: 4px solid #fff;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .10);
        }

        .timeline-line {
            position: absolute;
            left: 20px;
            top: 42px;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-goal {
            background: #eef2ff;
            color: #4f46e5;
        }

        .timeline-report {
            background: #eff6ff;
            color: #2563eb;
        }

        .timeline-manager {
            background: #fff7ed;
            color: #ea580c;
        }

        .timeline-hr {
            background: #ecfdf5;
            color: #16a34a;
        }

        .timeline-content {
            flex: 1;
            min-width: 0;
            border: 1px solid #edf0f5;
            border-radius: 15px;
            padding: 18px;
            background: #fff;
        }

        .timeline-content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .timeline-user {
            color: #94a3b8;
            font-size: 11px;
        }

        .timeline-date {
            color: #94a3b8;
            font-size: 11px;
            white-space: nowrap;
        }

        .status-transition {
            display: flex;
            align-items: center;
            font-size: 11px;
            font-weight: 600;
        }

        .old-status {
            padding: 6px 10px;
            background: #f1f5f9;
            color: #64748b;
            border-radius: 7px;
        }

        .new-status {
            padding: 6px 10px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 7px;
        }

        .timeline-comment {
            padding: 13px;
            background: #f8fafc;
            border-radius: 10px;
            color: #475569;
            font-size: 13px;
        }

        .timeline-comment-title {
            font-weight: 700;
            color: #334155;
            font-size: 12px;
        }

        .timeline-ratings {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .mini-rating {
            padding: 7px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
        }

        .self-mini {
            background: #eff6ff;
            color: #2563eb;
        }

        .manager-mini {
            background: #fff7ed;
            color: #c2410c;
        }

        .hr-mini {
            background: #ecfdf5;
            color: #15803d;
        }

        .empty-history {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-history-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 25px;
        }

        @media(max-width: 768px) {

            .history-page-header,
            .goal-overview-header,
            .ratings-header,
            .report-header,
            .timeline-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .timeline-content-header {
                flex-direction: column;
            }

            .timeline-date {
                white-space: normal;
            }

        }

    </style>

@endsection
@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4 goal-page">

        {{-- =========================================================
        HEADER
        ========================================================== --}}
        <div class="goal-hero mb-4">

            <div class="hero-content">

                <div class="d-flex align-items-center gap-3">

                    <div class="goal-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>

                    <div>

                        <div class="hero-label">
                            PERFORMANCE GOAL
                        </div>

                        <h2 class="hero-title mb-1 text-white">
                            Goal Details
                        </h2>

                        <p class="hero-subtitle mb-0">
                            Complete goal, self-report and review information
                        </p>

                    </div>

                </div>

                <a href="{{ route('newgoals.history', $newgoal) }}" class="history-btn">

                    <i class="fas fa-history"></i>

                    <span>View History</span>

                </a>

            </div>

        </div>

        {{-- =========================================================
        GOAL OVERVIEW
        ========================================================== --}}
        <div class="goal-overview mb-4">

            <div class="section-header">

                <div class="section-title-wrapper">

                    <div class="section-icon blue">
                        <i class="fas fa-bullseye"></i>
                    </div>

                    <div>

                        <h5 class="section-title mb-0">
                            Goal Overview
                        </h5>

                        <small class="section-subtitle">
                            Key information about this performance goal
                        </small>

                    </div>

                </div>

                <span class="status-pill
                        {{ $newgoal->status == 'active'
        ? 'status-active'
        : 'status-complete' }}">

                    <span class="status-dot"></span>

                    {{ ucfirst($newgoal->status) }}

                </span>

            </div>

            <div class="overview-body">

                {{-- Main Goal --}}
                <div class="main-goal">

                    <div class="field-label">
                        <i class="fas fa-flag"></i>
                        Goal
                    </div>

                    <div class="goal-text">
                        {{ $newgoal->goal }}
                    </div>

                </div>

                {{-- S2R --}}
                <div class="s2r-section">

                    <div class="field-label">
                        <i class="fas fa-route"></i>
                        S2R Driver / Enabler
                    </div>

                    @if($newgoal->s2rDriver)

                        <div class="s2r-pill">

                            <span class="s2r-icon">
                                <i class="fas fa-check"></i>
                            </span>

                            <span>
                                {{ $newgoal->s2rDriver->driver_name }}
                            </span>

                        </div>

                    @else

                        <div class="empty-value">
                            Not specified
                        </div>

                    @endif

                </div>

                {{-- Objective --}}
                <div class="info-block">

                    <div class="field-label">
                        <i class="fas fa-list-check"></i>
                        Objective(s)
                    </div>

                    <div class="info-text">

                        {{ $newgoal->objectives ?: 'No objectives specified.' }}

                    </div>

                </div>

                {{-- Target --}}
                <div class="info-block">

                    <div class="field-label">
                        <i class="fas fa-crosshairs"></i>
                        Target
                    </div>

                    <div class="info-text">

                        {{ $newgoal->target }}

                    </div>

                </div>

                {{-- Deadline --}}
                <div class="deadline-block">

                    <div class="field-label">
                        <i class="fas fa-calendar-days"></i>
                        Deadline
                    </div>

                    <div class="deadline-value">

                        {{ optional($newgoal->deadline)->format('d M Y') }}

                    </div>

                    @if($newgoal->deadline)

                        @if($newgoal->deadline->isPast())

                            <span class="deadline-badge overdue">
                                <i class="fas fa-circle-exclamation"></i>
                                Deadline Passed
                            </span>

                        @else

                            <span class="deadline-badge upcoming">
                                <i class="fas fa-clock"></i>
                                Upcoming
                            </span>

                        @endif

                    @endif

                </div>

            </div>

        </div>

        {{-- =========================================================
        SELF REPORTS
        ========================================================== --}}
        @forelse($newgoal->selfReports as $report)

            <div class="report-container mb-4">

                {{-- Report Header --}}
                <div class="report-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="report-icon">
                            <i class="fas fa-file-signature"></i>
                        </div>

                        <div>

                            <h5 class="report-title mb-1">
                                Goal Self Report
                            </h5>

                            @if($report->submitted_at)

                                <div class="report-date">

                                    <i class="far fa-calendar-alt me-1"></i>

                                    Submitted
                                    {{ $report->submitted_at->format('d M Y, h:i A') }}

                                </div>

                            @endif

                        </div>

                    </div>

                    <span class="report-status">

                        <span class="status-dot"></span>

                        {{ ucwords(
                str_replace(
                    '_',
                    ' ',
                    $report->status
                )
            ) }}

                    </span>

                </div>

                {{-- =====================================================
                RATINGS
                ====================================================== --}}
                <div class="ratings-section">

                    <div class="rating-heading">

                        <div>

                            <h6 class="mb-1 fw-bold">
                                Rating Summary
                            </h6>

                            <small>
                                Evaluation from employee, line manager and HR
                            </small>

                        </div>

                        @php
                            $selfRating = $report->rating;
                            $managerRating = $report->manager_rating;
                            $hrRating = $report->hr_rating;
                        @endphp

                    </div>

                    <div class="rating-grid">

                        {{-- SELF --}}
                        <div class="rating-card self-rating">

                            <div class="rating-card-top">

                                <div class="rating-avatar">

                                    <i class="fas fa-user"></i>

                                </div>

                                <div>

                                    <div class="rating-role">
                                        Employee
                                    </div>

                                    <div class="rating-label">
                                        Self Rating
                                    </div>

                                </div>

                            </div>

                            <div class="rating-score">

                                {{ $selfRating ?? 0 }}

                                <span>/5</span>

                            </div>

                            <div class="rating-footer">

                                <i class="fas fa-user-check"></i>

                                Self Assessment

                            </div>

                        </div>

                        {{-- MANAGER --}}
                        <div class="rating-card manager-rating">

                            <div class="rating-card-top">

                                <div class="rating-avatar">

                                    <i class="fas fa-user-tie"></i>

                                </div>

                                <div>

                                    <div class="rating-role">
                                        Line Manager
                                    </div>

                                    <div class="rating-label">
                                        Manager Rating
                                    </div>

                                </div>

                            </div>

                            <div class="rating-score">

                                {{ $managerRating ?? '—' }}

                                @if($managerRating !== null)
                                    <span>/5</span>
                                @endif

                            </div>

                            <div class="rating-footer">

                                @if($managerRating !== null)

                                    <i class="fas fa-circle-check"></i>
                                    Reviewed

                                @else

                                    <i class="fas fa-clock"></i>
                                    Awaiting Review

                                @endif

                            </div>

                        </div>

                        {{-- HR --}}
                        <div class="rating-card hr-rating">

                            <div class="rating-card-top">

                                <div class="rating-avatar">

                                    <i class="fas fa-users-cog"></i>

                                </div>

                                <div>

                                    <div class="rating-role">
                                        Human Resources
                                    </div>

                                    <div class="rating-label">
                                        HR Final Rating
                                    </div>

                                </div>

                            </div>

                            <div class="rating-score">

                                {{ $hrRating ?? '—' }}

                                @if($hrRating !== null)
                                    <span>/5</span>
                                @endif

                            </div>

                            <div class="rating-footer">

                                @if($hrRating !== null)

                                    <i class="fas fa-circle-check"></i>
                                    Finalized

                                @else

                                    <i class="fas fa-clock"></i>
                                    Awaiting HR

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                {{-- =====================================================
                PROGRESS
                ====================================================== --}}
                <div class="report-content">

                    <div class="content-section">

                        <div class="content-title">

                            <span class="content-title-icon">
                                <i class="fas fa-chart-line"></i>
                            </span>

                            <span>
                                Progress Against Goal
                            </span>

                        </div>

                        <div class="progress-box">

                            {{ $report->progress_against_goal }}

                        </div>

                    </div>

                    {{-- Achievement --}}
                    <div class="achievement-section">

                        <div class="content-title">

                            <span class="content-title-icon">
                                <i class="fas fa-chart-simple"></i>
                            </span>

                            <span>
                                Achievement Status
                            </span>

                        </div>

                        @php

                            $achievementClasses = [
                                'not_started' => 'achievement-gray',
                                'in_progress' => 'achievement-blue',
                                'partially_complete' => 'achievement-orange',
                                'completed' => 'achievement-green',
                            ];

                            $achievementIcons = [
                                'not_started' => 'fa-circle',
                                'in_progress' => 'fa-spinner',
                                'partially_complete' => 'fa-chart-pie',
                                'completed' => 'fa-circle-check',
                            ];

                        @endphp

                        <div class="achievement-pill
                                            {{ $achievementClasses[$report->achievement_status] ?? 'achievement-gray' }}">

                            <i class="fas {{ $achievementIcons[$report->achievement_status] ?? 'fa-circle' }}"></i>

                            {{ ucwords(
                str_replace(
                    '_',
                    ' ',
                    $report->achievement_status
                )
            ) }}

                        </div>

                    </div>

                </div>

                {{-- =====================================================
                REVIEWS
                ====================================================== --}}
                <div class="reviews-section">

                    <div class="reviews-heading">

                        <div>

                            <h6 class="fw-bold mb-1">
                                Review & Approval
                            </h6>

                            <small>
                                Manager and HR evaluation history
                            </small>

                        </div>

                    </div>

                    <div class="review-timeline">

                        {{-- Manager Review --}}
                        <div class="review-item">

                            <div class="review-line"></div>

                            <div class="review-icon manager">

                                <i class="fas fa-user-tie"></i>

                            </div>

                            <div class="review-content">

                                <div class="review-top">

                                    <div>

                                        <strong>
                                            Line Manager Review
                                        </strong>

                                        @if($report->managerReview)

                                            <div class="review-by">

                                                Reviewed by
                                                {{ $report->managerReview->reviewer->name ?? 'Manager' }}

                                                @if($report->managerReview->reviewed_at)

                                                    ·
                                                    {{ $report->managerReview->reviewed_at->format('d M Y, h:i A') }}

                                                @endif

                                            </div>

                                        @endif

                                    </div>

                                    @if($report->managerReview)

                                                        <span class="review-decision
                                                                                                            {{ $report->managerReview->decision == 'approved'
                                        ? 'approved'
                                        : 'rejected' }}">

                                                            <i class="fas
                                                                                                                {{ $report->managerReview->decision == 'approved'
                                        ? 'fa-check'
                                        : 'fa-xmark' }}">
                                                            </i>

                                                            {{ ucfirst($report->managerReview->decision) }}

                                                        </span>

                                    @else

                                        <span class="review-pending">
                                            Pending
                                        </span>

                                    @endif

                                </div>

                                @if($report->managerReview)

                                    <div class="review-rating">

                                        <span>
                                            Manager Rating
                                        </span>

                                        <strong>
                                            {{ $report->manager_rating }}/5
                                        </strong>

                                    </div>

                                    @if($report->managerReview->comments)

                                        <div class="review-comment">

                                            <i class="fas fa-quote-left"></i>

                                            {{ $report->managerReview->comments }}

                                        </div>

                                    @endif

                                @endif

                            </div>

                        </div>

                        {{-- HR Review --}}
                        <div class="review-item">

                            <div class="review-icon hr">

                                <i class="fas fa-users-cog"></i>

                            </div>

                            <div class="review-content">

                                <div class="review-top">

                                    <div>

                                        <strong>
                                            HR Final Review
                                        </strong>

                                        @if($report->hrReview)

                                            <div class="review-by">

                                                Reviewed by
                                                {{ $report->hrReview->reviewer->name ?? 'HR' }}

                                                @if($report->hrReview->reviewed_at)

                                                    ·
                                                    {{ $report->hrReview->reviewed_at->format('d M Y, h:i A') }}

                                                @endif

                                            </div>

                                        @endif

                                    </div>

                                    @if($report->hrReview)

                                                        <span class="review-decision
                                                                                                            {{ $report->hrReview->decision == 'approved'
                                        ? 'approved'
                                        : 'rejected' }}">

                                                            <i class="fas
                                                                                                                {{ $report->hrReview->decision == 'approved'
                                        ? 'fa-check'
                                        : 'fa-xmark' }}">
                                                            </i>

                                                            {{ ucfirst($report->hrReview->decision) }}

                                                        </span>

                                    @else

                                        <span class="review-pending">
                                            Pending
                                        </span>

                                    @endif

                                </div>

                                @if($report->hrReview)

                                    <div class="review-rating">

                                        <span>
                                            HR Final Rating
                                        </span>

                                        <strong>
                                            {{ $report->hr_rating }}/5
                                        </strong>

                                    </div>

                                    @if($report->hrReview->comments)

                                        <div class="review-comment">

                                            <i class="fas fa-quote-left"></i>

                                            {{ $report->hrReview->comments }}

                                        </div>

                                    @endif

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            {{-- Empty --}}
            <div class="empty-state">

                <div class="empty-icon">

                    <i class="fas fa-file-circle-xmark"></i>

                </div>

                <h5>
                    No Self Report Yet
                </h5>

                <p>
                    A self report has not been submitted for this goal.
                </p>

            </div>

        @endforelse

    </div>

    {{-- =============================================================
    CSS
    ============================================================== --}}
    <style>
        .goal-page {
            max-width: 1500px;
            margin: auto;
        }

        /* HERO */

        .goal-hero {
            border-radius: 18px;
            padding: 26px 30px;
            color: #fff;
            background: linear-gradient(135deg,
                    #173f67 0%,
                    #1f5f99 50%,
                    #2563eb 100%);
            box-shadow: 0 12px 30px rgba(31, 78, 121, .18);
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .goal-icon {
            width: 58px;
            height: 58px;
            border-radius: 15px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .hero-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            opacity: .7;
        }

        .hero-title {
            font-size: 28px;
            font-weight: 700;
        }

        .hero-subtitle {
            font-size: 14px;
            opacity: .75;
        }

        .history-btn {
            color: #1f4e79;
            background: #fff;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: .2s;
        }

        .history-btn:hover {
            color: #173f67;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .15);
        }

        /* GOAL OVERVIEW */

        .goal-overview {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e8edf3;
            box-shadow: 0 5px 20px rgba(15, 23, 42, .05);
            overflow: hidden;
        }

        .section-header {
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #edf0f4;
        }

        .section-title-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-icon.blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .section-title {
            font-size: 17px;
        }

        .section-subtitle {
            color: #94a3b8;
        }

        .status-pill {
            padding: 7px 13px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .status-active {
            background: #ecfdf5;
            color: #047857;
        }

        .status-complete {
            background: #eff6ff;
            color: #2563eb;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        .overview-body {
            padding: 25px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .main-goal {
            grid-column: 1 / -1;
            padding-bottom: 20px;
            border-bottom: 1px solid #edf0f4;
        }

        .field-label {
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 9px;
        }

        .field-label i {
            color: #2563eb;
            margin-right: 5px;
        }

        .goal-text {
            font-size: 20px;
            line-height: 1.55;
            font-weight: 650;
            color: #172033;
        }

        .s2r-pill {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 14px;
            border-radius: 9px;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid #dbeafe;
        }

        .s2r-icon {
            width: 23px;
            height: 23px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: white;
            font-size: 10px;
        }

        .info-block {
            background: #f8fafc;
            border: 1px solid #edf0f4;
            border-radius: 11px;
            padding: 16px;
        }

        .info-text {
            color: #334155;
            font-size: 14px;
            line-height: 1.65;
        }

        .deadline-block {
            background: #fff8ed;
            border: 1px solid #fed7aa;
            border-radius: 11px;
            padding: 16px;
        }

        .deadline-value {
            font-size: 17px;
            font-weight: 700;
            color: #9a3412;
        }

        .deadline-badge {
            display: inline-flex;
            gap: 5px;
            align-items: center;
            font-size: 11px;
            margin-top: 7px;
            font-weight: 600;
        }

        .deadline-badge.upcoming {
            color: #b45309;
        }

        .deadline-badge.overdue {
            color: #dc2626;
        }

        /* REPORT */

        .report-container {
            background: #fff;
            border: 1px solid #e8edf3;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(15, 23, 42, .05);
        }

        .report-header {
            padding: 19px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafbfc;
            border-bottom: 1px solid #edf0f4;
        }

        .report-icon {
            width: 43px;
            height: 43px;
            border-radius: 11px;
            background: #eef2ff;
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .report-title {
            font-size: 16px;
            font-weight: 700;
        }

        .report-date {
            font-size: 11px;
            color: #94a3b8;
        }

        .report-status {
            background: #eff6ff;
            color: #2563eb;
            padding: 7px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .report-status .status-dot {
            background: #2563eb;
        }

        /* RATINGS */

        .ratings-section {
            padding: 25px;
            border-bottom: 1px solid #edf0f4;
        }

        .rating-heading {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .rating-heading small {
            color: #94a3b8;
        }

        .rating-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .rating-card {
            border: 1px solid #e5e7eb;
            border-radius: 13px;
            padding: 18px;
            position: relative;
            overflow: hidden;
        }

        .rating-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        .self-rating::before {
            background: #6366f1;
        }

        .manager-rating::before {
            background: #f59e0b;
        }

        .hr-rating::before {
            background: #10b981;
        }

        .rating-card-top {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .rating-avatar {
            width: 39px;
            height: 39px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .self-rating .rating-avatar {
            background: #eef2ff;
            color: #6366f1;
        }

        .manager-rating .rating-avatar {
            background: #fff7ed;
            color: #f59e0b;
        }

        .hr-rating .rating-avatar {
            background: #ecfdf5;
            color: #10b981;
        }

        .rating-role {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
        }

        .rating-label {
            font-size: 12px;
            color: #94a3b8;
        }

        .rating-score {
            font-size: 38px;
            font-weight: 800;
            color: #172033;
            margin-top: 18px;
        }

        .rating-score span {
            font-size: 13px;
            color: #94a3b8;
            font-weight: 600;
        }

        .rating-footer {
            border-top: 1px solid #edf0f4;
            padding-top: 10px;
            margin-top: 12px;
            font-size: 11px;
            color: #64748b;
        }

        /* REPORT CONTENT */

        .report-content {
            padding: 25px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            border-bottom: 1px solid #edf0f4;
        }

        .content-title {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .content-title-icon {
            color: #2563eb;
        }

        .progress-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 11px;
            padding: 16px;
            color: #334155;
            line-height: 1.7;
            min-height: 90px;
        }

        .achievement-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
        }

        .achievement-gray {
            background: #f1f5f9;
            color: #475569;
        }

        .achievement-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .achievement-orange {
            background: #fff7ed;
            color: #c2410c;
        }

        .achievement-green {
            background: #ecfdf5;
            color: #047857;
        }

        /* REVIEWS */

        .reviews-section {
            padding: 25px;
        }

        .reviews-heading {
            margin-bottom: 25px;
        }

        .reviews-heading small {
            color: #94a3b8;
        }

        .review-timeline {
            position: relative;
        }

        .review-item {
            display: flex;
            gap: 17px;
            position: relative;
            padding-bottom: 25px;
        }

        .review-item:last-child {
            padding-bottom: 0;
        }

        .review-line {
            position: absolute;
            left: 19px;
            top: 40px;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }

        .review-icon {
            min-width: 40px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
            background: white;
            border: 2px solid;
        }

        .review-icon.manager {
            color: #f59e0b;
            border-color: #fde68a;
            background: #fffbeb;
        }

        .review-icon.hr {
            color: #10b981;
            border-color: #a7f3d0;
            background: #ecfdf5;
        }

        .review-content {
            flex: 1;
            border: 1px solid #e5e7eb;
            border-radius: 11px;
            padding: 16px;
        }

        .review-top {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .review-by {
            color: #94a3b8;
            font-size: 11px;
            margin-top: 3px;
        }

        .review-decision {
            height: fit-content;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            gap: 5px;
            align-items: center;
        }

        .review-decision.approved {
            background: #ecfdf5;
            color: #047857;
        }

        .review-decision.rejected {
            background: #fef2f2;
            color: #dc2626;
        }

        .review-pending {
            background: #f8fafc;
            color: #64748b;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .review-rating {
            margin-top: 13px;
            display: flex;
            justify-content: space-between;
            background: #f8fafc;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 12px;
            color: #64748b;
        }

        .review-rating strong {
            color: #172033;
            font-size: 14px;
        }

        .review-comment {
            margin-top: 12px;
            padding: 11px 13px;
            background: #fafafa;
            border-radius: 8px;
            color: #475569;
            font-size: 13px;
            line-height: 1.6;
        }

        .review-comment i {
            color: #cbd5e1;
            margin-right: 7px;
        }

        /* EMPTY */

        .empty-state {
            text-align: center;
            background: white;
            border: 1px solid #e8edf3;
            border-radius: 16px;
            padding: 70px 20px;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            margin: auto auto 18px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .empty-state h5 {
            font-weight: 700;
        }

        .empty-state p {
            color: #94a3b8;
        }

        /* RESPONSIVE */

        @media (max-width: 992px) {

            .overview-body {
                grid-template-columns: 1fr;
            }

            .rating-grid {
                grid-template-columns: 1fr;
            }

            .report-content {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 768px) {

            .hero-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .section-header,
            .report-header {
                align-items: flex-start;
                gap: 15px;
                flex-direction: column;
            }

            .goal-text {
                font-size: 17px;
            }

        }
    </style>

@endsection
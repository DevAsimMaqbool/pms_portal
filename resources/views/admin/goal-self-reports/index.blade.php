@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4 goal-reports-page">

        {{-- ================= HEADER ================= --}}
        <div class="reports-header mb-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>
                    <div class="page-title-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>

                    <div class="d-inline-block ms-2 align-middle">
                        <h3 class="page-title mb-1">
                            My Goal Self Reports
                        </h3>

                        <p class="page-subtitle mb-0">
                            Track your submitted goal reports, ratings and review progress.
                        </p>
                    </div>
                </div>

                <a href="{{ route('goal-self-reports.create') }}" class="btn btn-primary create-report-btn">

                    <i class="fas fa-plus me-2"></i>
                    Submit Self Report

                </a>

            </div>

        </div>

        {{-- ================= ALERTS ================= --}}
        @if(session('success'))

            <div class="alert custom-alert alert-success alert-dismissible fade show mb-4" role="alert">

                <div class="d-flex align-items-center">

                    <div class="alert-icon success-icon">
                        <i class="fas fa-check"></i>
                    </div>

                    <div>
                        <strong>Success!</strong>
                        <div>{{ session('success') }}</div>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        @endif

        @if(session('error'))

            <div class="alert custom-alert alert-danger alert-dismissible fade show mb-4" role="alert">

                <div class="d-flex align-items-center">

                    <div class="alert-icon danger-icon">
                        <i class="fas fa-exclamation"></i>
                    </div>

                    <div>
                        <strong>Attention!</strong>
                        <div>{{ session('error') }}</div>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        @endif

        {{-- ================= SUMMARY ================= --}}
<div class="row g-3 mb-4">

    {{-- TOTAL --}}
    <div class="col-xl-2 col-md-6">

        <div class="summary-card">

            <div class="summary-icon blue">
                <i class="fas fa-file-alt"></i>
            </div>

            <div>
                <span class="summary-label">
                    Total Reports
                </span>

                <h4 class="summary-value">
                    {{ $reports->total() }}
                </h4>
            </div>

        </div>

    </div>

    {{-- PENDING --}}
    <div class="col-xl-2 col-md-6">

        <div class="summary-card">

            <div class="summary-icon orange">
                <i class="fas fa-clock"></i>
            </div>

            <div>
                <span class="summary-label">
                    Pending Review
                </span>

                <h4 class="summary-value">
                    {{ $reports->getCollection()->where('status', 'submitted')->count() }}
                </h4>
            </div>

        </div>

    </div>

    {{-- Self OVERALL --}}
    <div class="col-xl-2 col-md-6">

        <div class="summary-card">

            <div class="summary-icon cyan">
                <i class="fas fa-user-check"></i>
            </div>

            <div>

                <span class="summary-label">
                    Self Rating
                </span>

                <h4 class="summary-value">

                    @if($selfOverallRating !== null)

                        {{ number_format($selfOverallRating, 2)}}

                        <small class="rating-max">
                            / 5
                        </small>

                    @else

                        <span class="rating-pending-text">
                            Pending
                        </span>

                    @endif

                </h4>

            </div>

        </div>

    </div>
    
    {{-- MANAGER OVERALL --}}
    <div class="col-xl-2 col-md-6">

        <div class="summary-card">

            <div class="summary-icon cyan">
                <i class="fas fa-user-check"></i>
            </div>

            <div>

                <span class="summary-label">
                    Manager Rating
                </span>

                <h4 class="summary-value">

                    @if($overallReview && $overallReview->manager_overall_rating !== null)

                        {{ number_format($overallReview->manager_overall_rating, 2) }}

                        <small class="rating-max">
                            / 5
                        </small>

                    @else

                        <span class="rating-pending-text">
                            Pending
                        </span>

                    @endif

                </h4>

            </div>

        </div>

    </div>

    {{-- MANAGER Feedback --}}
    <div class="col-xl-2 col-md-6">

        <div class="summary-card">

            <div class="summary-icon cyan">
                <i class="fas fa-user-check"></i>
            </div>

            <div>

                <span class="summary-label">
                    Manager Feedback
                </span>

                <h4 class="summary-value">

                    @if($managerFeedbackOverall !== null)

                        {{ round(
        ($managerFeedbackOverall / 100) * 5,
        2
    ) }}

                        <small class="rating-max">
                            / 5
                        </small>

                    @else

                        <span class="rating-pending-text">
                            Pending
                        </span>

                    @endif

                </h4>

            </div>

        </div>

    </div>

    {{-- HR OVERALL --}}
    <div class="col-xl-2 col-md-6">

        <div class="summary-card">

            <div class="summary-icon green">
                <i class="fas fa-user-tie"></i>
            </div>

            <div>

                <span class="summary-label">
                    HR Rating
                </span>

                <h4 class="summary-value">

                    @if($overallReview && $overallReview->hr_overall_rating !== null)

                        {{ number_format($overallReview->hr_overall_rating, 2) }}

                        <small class="rating-max">
                            / 5
                        </small>

                    @else

                        <span class="rating-pending-text">
                            Pending
                        </span>

                    @endif

                </h4>

            </div>

        </div>

    </div>

</div>
        
        {{-- ================= MAIN CARD ================= --}}
        <div class="reports-card">

            {{-- Card Header --}}
            <div class="reports-card-header">

                <div>

                    <h5 class="mb-1 fw-bold">
                        <i class="fas fa-list-check me-2 text-primary"></i>
                        Submitted Reports
                    </h5>

                    <small class="text-muted">
                        Your complete goal self-reporting record
                    </small>

                </div>

                <div class="report-count">

                    {{ $reports->total() }}

                    <span>
                        Reports
                    </span>

                </div>

            </div>

            {{-- ================= STATUS FILTER ================= --}}
<div class="reports-filter">

    <form method="GET"
          action="{{ route('goal-self-reports.index') }}"
          class="row g-3 align-items-end">

        <div class="col-md-5 col-lg-4">

            <label class="filter-label">
                <i class="fas fa-filter me-1"></i>
                Filter by Status
            </label>

            <select name="status"
                    class="form-select filter-select">

                <option value="">
                    All Statuses
                </option>

                <option value="submitted"
                    {{ request('status') === 'submitted' ? 'selected' : '' }}>
                    Pending Manager Review
                </option>

                <option value="manager_approved"
                    {{ request('status') === 'manager_approved' ? 'selected' : '' }}>
                    Manager Approved
                </option>

                <option value="manager_rejected"
                    {{ request('status') === 'manager_rejected' ? 'selected' : '' }}>
                    Manager Rejected
                </option>

                <option value="hr_approved"
                    {{ request('status') === 'hr_approved' ? 'selected' : '' }}>
                    HR Approved
                </option>

                <option value="hr_rejected"
                    {{ request('status') === 'hr_rejected' ? 'selected' : '' }}>
                    HR Rejected
                </option>

            </select>

        </div>

        <div class="col-md-auto">

            <button type="submit"
                    class="btn btn-primary filter-btn">

                <i class="fas fa-search me-1"></i>
                Apply Filter

            </button>

        </div>

        @if(request()->filled('status'))

            <div class="col-md-auto">

                <a href="{{ route('goal-self-reports.index') }}"
                   class="btn btn-light border filter-btn">

                    <i class="fas fa-times me-1"></i>
                    Clear

                </a>

            </div>

        @endif

    </form>

</div>

            {{-- Table --}}
            <div class="table-responsive">

                <table class="table reports-table align-middle mb-0">

                    <thead>

    <tr>

        <th class="text-center" style="width: 55px;">
            #
        </th>

        <th style="min-width: 280px;">
            Goal
        </th>

        <th style="min-width: 160px;">
            Achievement
        </th>

        <th class="text-center" style="width: 120px;">
            Self Rating
        </th>

        <th class="text-center" style="width: 140px;">
            Manager Rating
        </th>

        <th class="text-center" style="width: 175px;">
            Review Status
        </th>

        <th style="min-width: 135px;">
            Submitted
        </th>

        <th class="text-center" style="width: 110px;">
            Action
        </th>

    </tr>

</thead>

                    <tbody>

                        @forelse($reports as $report)

                                            @php

                                                $statusConfig = match ($report->status) {

                                                    'submitted' => [
                                                        'class' => 'status-pending',
                                                        'icon' => 'fa-clock',
                                                        'label' => 'Pending Manager'
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
                                                            str_replace('_', ' ', $report->status)
                                                        )
                                                    ]

                                                };

                                                $achievementConfig = match ($report->achievement_status) {

                                                    'not_started' => [
                                                        'class' => 'achievement-not-started',
                                                        'icon' => 'fa-circle'
                                                    ],

                                                    'in_progress' => [
                                                        'class' => 'achievement-progress',
                                                        'icon' => 'fa-spinner'
                                                    ],

                                                    'partially_complete' => [
                                                        'class' => 'achievement-partial',
                                                        'icon' => 'fa-adjust'
                                                    ],

                                                    'completed' => [
                                                        'class' => 'achievement-complete',
                                                        'icon' => 'fa-check-circle'
                                                    ],

                                                    default => [
                                                        'class' => 'achievement-default',
                                                        'icon' => 'fa-circle'
                                                    ]

                                                };

                                            @endphp

                                            <tr>

                                                {{-- # --}}
                                                <td class="text-center">

                                                    <span class="row-number">
                                                        {{ $reports->firstItem() + $loop->index }}
                                                    </span>

                                                </td>

                                                {{-- GOAL --}}
                                                <td>

                                                    <div class="goal-cell">

                                                        <div class="goal-icon">

                                                            <i class="fas fa-bullseye"></i>

                                                        </div>

                                                        <div>

                                                            <div class="goal-title">

                                                                {{ \Illuminate\Support\Str::limit(
                                $report->goal->goal ?? 'Goal not available',
                                100
                            ) }}

                                                            </div>

                                                            @if($report->goal)

                                                                <div class="goal-deadline">

                                                                    <i class="far fa-calendar-alt me-1"></i>

                                                                    Deadline:

                                                                    {{ optional($report->goal->deadline)->format('d M Y') }}

                                                                </div>

                                                            @endif

                                                        </div>

                                                    </div>

                                                </td>

                                                {{-- ACHIEVEMENT --}}
                                                <td>

                                                    <span class="achievement-badge {{ $achievementConfig['class'] }}">

                                                        <i class="fas {{ $achievementConfig['icon'] }} me-1"></i>

                                                        {{ ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    $report->achievement_status
                                )
                            ) }}

                                                    </span>

                                                </td>

                                                {{-- SELF RATING --}}
                                                <td class="text-center">

                                                    <div class="rating-display">

                                                        <div class="rating-star">

                                                            <i class="fas fa-star"></i>

                                                        </div>

                                                        <div>

                                                            <strong>
                                                                {{ $report->rating ?? 0 }}
                                                            </strong>

                                                            <small>/ 5</small>

                                                        </div>

                                                    </div>

                                                </td>
                                                <td class="text-center">

    @if($report->manager_rating !== null)

        <div class="rating-display manager-rating">

            <div class="rating-star">
                <i class="fas fa-user-check"></i>
            </div>

            <div>

                <strong>
                    {{ number_format($report->manager_rating, 2) }}
                </strong>

                <small>/ 5</small>

            </div>

        </div>

    @else

        <span class="rating-not-given">
            <i class="fas fa-minus-circle me-1"></i>
            Not Rated
        </span>

    @endif

</td>

                                                {{-- STATUS --}}
                                                <td class="text-center">

                                                    <span class="status-badge {{ $statusConfig['class'] }}">

                                                        <i class="fas {{ $statusConfig['icon'] }} me-1"></i>

                                                        {{ $statusConfig['label'] }}

                                                    </span>

                                                </td>

                                                {{-- DATE --}}
                                                <td>

                                                    @if($report->submitted_at)

                                                        <div class="submitted-date">

                                                            <strong>
                                                                {{ $report->submitted_at->format('d M Y') }}
                                                            </strong>

                                                            <small>
                                                                {{ $report->submitted_at->format('h:i A') }}
                                                            </small>

                                                        </div>

                                                    @else

                                                        <span class="text-muted">
                                                            —
                                                        </span>

                                                    @endif

                                                </td>

                                                {{-- ACTION --}}
<td class="text-center">

    <div class="d-flex justify-content-center gap-2">

        {{-- VIEW --}}
        <a href="{{ route(
            'goal-self-reports.show',
            $report
        ) }}"
           class="view-btn">

            <i class="fas fa-eye"></i>

            <span>
                View
            </span>

        </a>

        {{-- EDIT --}}
        @if(in_array($report->status, ['submitted', 'manager_rejected']))

            <a href="{{ route(
                'goal-self-reports.edit',
                $report
            ) }}"
               class="edit-btn">

                <i class="fas fa-edit"></i>

                <span>
                    Edit
                </span>

            </a>

        @endif

    </div>

</td>

                                            </tr>

                        @empty

                            <tr>

                                <td colspan="7">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i class="fas fa-clipboard-list"></i>

                                        </div>

                                        <h5>
                                            No Self Reports Yet
                                        </h5>

                                        <p>
                                            You have not submitted any goal self reports.
                                        </p>

                                        <a href="{{ route('goal-self-reports.create') }}" class="btn btn-primary">

                                            <i class="fas fa-plus me-2"></i>

                                            Submit Your First Report

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            @if($reports->hasPages())

                <div class="reports-pagination">

                    <div class="pagination-info">

                        Showing

                        <strong>
                            {{ $reports->firstItem() }}
                        </strong>

                        to

                        <strong>
                            {{ $reports->lastItem() }}
                        </strong>

                        of

                        <strong>
                            {{ $reports->total() }}
                        </strong>

                        reports

                    </div>

                    <div>
                        {{ $reports->links() }}
                    </div>

                </div>

            @endif

        </div>

    </div>

    <style>
        /* =========================================
   EDIT BUTTON
========================================= */

.edit-btn {
    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 7px 12px;

    border-radius: 7px;

    background: #fff4df;

    color: #b36b00;

    text-decoration: none;

    font-size: 11px;

    font-weight: 700;

    transition: all .2s ease;
}

.edit-btn:hover {
    background: #b36b00;

    color: #fff;

    transform: translateY(-1px);
}
        /* =========================================
                           PAGE
                        ========================================= */

        .goal-reports-page {
            color: #243447;
        }

        /* =========================================
                           HEADER
                        ========================================= */

        .reports-header {
            background: linear-gradient(135deg,
                    #1f4e79 0%,
                    #286090 55%,
                    #337ab7 100%);

            border-radius: 16px;

            padding: 25px 30px;

            color: #fff;

            box-shadow: 0 8px 25px rgba(31, 78, 121, 0.18);
        }

        .page-title-icon {
            width: 48px;
            height: 48px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: rgba(255, 255, 255, 0.15);

            font-size: 20px;

            vertical-align: middle;
        }

        .page-title {
            color: #fff;
            font-size: 24px;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.78);
            font-size: 14px;
        }

        .create-report-btn {
            background: #fff !important;
            color: #1f4e79 !important;

            border: 0 !important;

            padding: 11px 20px;

            border-radius: 9px;

            font-weight: 600;

            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);

            transition: all .2s ease;
        }

        .create-report-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(0, 0, 0, 0.18);
        }

        /* =========================================
                           ALERTS
                        ========================================= */

        .custom-alert {
            border: 0;
            border-radius: 12px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .alert-icon {
            width: 35px;
            height: 35px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-right: 12px;
        }

        .success-icon {
            background: #d1fae5;
            color: #047857;
        }

        .danger-icon {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* =========================================
                           SUMMARY CARDS
                        ========================================= */

        .summary-card {
            background: #fff;

            border: 1px solid #edf1f5;

            border-radius: 14px;

            padding: 18px;

            display: flex;
            align-items: center;

            gap: 15px;

            box-shadow: 0 4px 16px rgba(31, 78, 121, 0.06);

            transition: all .2s ease;
        }

        .summary-card:hover {
            transform: translateY(-3px);

            box-shadow:
                0 8px 22px rgba(31, 78, 121, 0.10);
        }

        .summary-icon {
            width: 48px;
            height: 48px;

            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 19px;
        }

        .summary-icon.blue {
            background: #e8f1fb;
            color: #1f4e79;
        }

        .summary-icon.orange {
            background: #fff3df;
            color: #d97706;
        }

        .summary-icon.cyan {
            background: #e3f7fb;
            color: #087f9c;
        }

        .summary-icon.green {
            background: #e6f7ee;
            color: #16804d;
        }

        .summary-label {
            display: block;

            color: #7b8794;

            font-size: 12px;

            margin-bottom: 3px;
        }

        .summary-value {
            margin: 0;

            color: #243447;

            font-weight: 700;
        }

        /* =========================================
                           MAIN CARD
                        ========================================= */

        .reports-card {
            background: #fff;

            border: 1px solid #e9eef3;

            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 5px 22px rgba(31, 78, 121, 0.07);
        }

        .reports-card-header {
            padding: 20px 24px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            border-bottom: 1px solid #edf1f5;

            background: #fff;
        }

        .report-count {
            background: #edf5fc;

            color: #1f4e79;

            border-radius: 20px;

            padding: 7px 13px;

            font-size: 13px;

            font-weight: 700;
        }

        .report-count span {
            font-weight: 500;
            margin-left: 3px;
        }

        /* =========================================
                           TABLE
                        ========================================= */

        .reports-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .reports-table thead th {
            background: #f7f9fc;

            color: #607080;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: .35px;

            font-weight: 700;

            padding: 14px 16px;

            border-bottom: 1px solid #e8edf2;

            white-space: nowrap;
        }

        .reports-table tbody td {
            padding: 17px 16px;

            border-bottom: 1px solid #eef2f5;

            vertical-align: middle;
        }

        .reports-table tbody tr {
            transition: background .15s ease;
        }

        .reports-table tbody tr:hover {
            background: #f9fbfd;
        }

        .reports-table tbody tr:last-child td {
            border-bottom: 0;
        }

        /* =========================================
                           ROW NUMBER
                        ========================================= */

        .row-number {
            width: 30px;
            height: 30px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            background: #f0f5fa;

            color: #1f4e79;

            border-radius: 8px;

            font-size: 12px;

            font-weight: 700;
        }

        /* =========================================
                           GOAL
                        ========================================= */

        .goal-cell {
            display: flex;
            align-items: flex-start;

            gap: 12px;
        }

        .goal-icon {
            width: 38px;
            height: 38px;

            min-width: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #edf5fc;

            color: #1f4e79;

            border-radius: 9px;
        }

        .goal-title {
            color: #26384a;

            font-weight: 600;

            line-height: 1.45;

            font-size: 14px;
        }

        .goal-deadline {
            color: #8a96a3;

            font-size: 11px;

            margin-top: 5px;
        }

        /* =========================================
                           ACHIEVEMENT
                        ========================================= */

        .achievement-badge {
            display: inline-flex;

            align-items: center;

            padding: 6px 10px;

            border-radius: 7px;

            font-size: 11px;

            font-weight: 600;

            white-space: nowrap;
        }

        .achievement-not-started {
            background: #f1f3f5;
            color: #6c757d;
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
            background: #e6f7ee;
            color: #167447;
        }

        .achievement-default {
            background: #f1f3f5;
            color: #667085;
        }

        /* =========================================
                           RATING
                        ========================================= */

        .rating-display {
            display: inline-flex;

            align-items: center;

            gap: 7px;
        }

        .rating-star {
            width: 30px;
            height: 30px;

            border-radius: 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #fff5d9;

            color: #e0a100;

            font-size: 12px;
        }

        .rating-display strong {
            color: #243447;

            font-size: 16px;
        }

        .rating-display small {
            color: #8b96a3;

            font-size: 11px;
        }

        /* =========================================
                           STATUS
                        ========================================= */

        .status-badge {
            display: inline-flex;

            align-items: center;

            padding: 7px 10px;

            border-radius: 7px;

            font-size: 10px;

            font-weight: 700;

            white-space: nowrap;
        }

        .status-pending {
            background: #fff4df;
            color: #b36b00;
        }

        .status-manager {
            background: #e8f1fb;
            color: #1f4e79;
        }

        .status-approved {
            background: #e6f7ee;
            color: #167447;
        }

        .status-rejected {
            background: #fdecec;
            color: #b42318;
        }

        .status-default {
            background: #f1f3f5;
            color: #667085;
        }

        /* =========================================
                           DATE
                        ========================================= */

        .submitted-date strong {
            display: block;

            font-size: 12px;

            color: #354657;
        }

        .submitted-date small {
            display: block;

            color: #98a2b3;

            font-size: 10px;

            margin-top: 2px;
        }

        /* =========================================
                           VIEW BUTTON
                        ========================================= */

        .view-btn {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 7px 12px;

            border-radius: 7px;

            background: #edf5fc;

            color: #1f4e79;

            text-decoration: none;

            font-size: 11px;

            font-weight: 700;

            transition: all .2s ease;
        }

        .view-btn:hover {
            background: #1f4e79;

            color: #fff;

            transform: translateY(-1px);
        }

        /* =========================================
                           EMPTY STATE
                        ========================================= */

        .empty-state {
            padding: 65px 20px;

            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 18px;

            background: #edf5fc;

            color: #1f4e79;

            border-radius: 18px;

            font-size: 27px;
        }

        .empty-state h5 {
            font-weight: 700;

            color: #34495e;
        }

        .empty-state p {
            color: #8995a3;

            margin-bottom: 20px;
        }

        /* =========================================
                           PAGINATION
                        ========================================= */

        .reports-pagination {
            padding: 16px 22px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            flex-wrap: wrap;

            gap: 15px;

            border-top: 1px solid #edf1f5;

            background: #fbfcfd;
        }

        .pagination-info {
            color: #7b8794;

            font-size: 12px;
        }

        .pagination-info strong {
            color: #34495e;
        }

        .reports-pagination .pagination {
            margin: 0;
        }

        /* =========================================
                           RESPONSIVE
                        ========================================= */

        @media(max-width: 768px) {

            .reports-header {
                padding: 20px;
            }

            .page-title {
                font-size: 20px;
            }

            .create-report-btn {
                width: 100%;
            }

            .reports-card-header {
                padding: 16px;
            }

            .reports-pagination {
                justify-content: center;
            }

        }

        /* =========================================
   STATUS FILTER
========================================= */

.reports-filter {
    padding: 18px 24px;

    background: #f8fafc;

    border-bottom: 1px solid #edf1f5;
}

.filter-label {
    display: block;

    color: #607080;

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .35px;

    margin-bottom: 7px;
}

.filter-label i {
    color: #1f4e79;
}

.filter-select {
    min-height: 42px;

    border: 1px solid #dbe3eb;

    border-radius: 9px;

    color: #34495e;

    font-size: 13px;

    font-weight: 500;

    background-color: #fff;
}

.filter-select:focus {
    border-color: #1f4e79;

    box-shadow:
        0 0 0 0.2rem rgba(31, 78, 121, .10);
}

.filter-btn {
    min-height: 42px;

    border-radius: 9px;

    padding-left: 17px;
    padding-right: 17px;

    font-size: 12px;

    font-weight: 600;
}

@media(max-width: 768px) {

    .reports-filter {
        padding: 16px;
    }

    .filter-btn {
        width: 100%;
    }

}

/* =========================================
   MANAGER / HR RATINGS
========================================= */

.manager-rating .rating-star {
    background: #e8f1fb;
    color: #1f4e79;
}

.hr-rating .rating-star {
    background: #e6f7ee;
    color: #16804d;
}

.manager-rating strong {
    color: #1f4e79;
}

.hr-rating strong {
    color: #16804d;
}

.rating-not-given {
    display: inline-flex;
    align-items: center;
    padding: 6px 9px;
    border-radius: 7px;
    background: #f4f5f7;
    color: #8a96a3;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.rating-max {
    color: #8b96a3;
    font-size: 11px;
    font-weight: 500;
}

.rating-pending-text {
    color: #98a2b3;
    font-size: 14px;
    font-weight: 600;
}
    </style>

@endsection
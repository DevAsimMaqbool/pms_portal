@extends('layouts.app')

@section('content')

    <div class="container-fluid py-3">

        {{-- ========================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================================================= --}}

        <div class="hr-page-header mb-3">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="header-icon">
                        <i class="fas fa-building"></i>
                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            HR Final Review
                        </h3>

                        <p class="mb-0 text-muted">
                            Review and finalize employee goal assessments.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ========================================================= --}}

        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-3">

                <i class="fas fa-check-circle fs-5 me-3"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif

        {{-- ========================================================= --}}
        {{-- SUMMARY --}}
        {{-- ========================================================= --}}

        <div class="row g-3 mb-3">

            {{-- Total --}}
            <div class="col-md-4">

                <div class="summary-card">

                    <div class="summary-icon blue">
                        <i class="fas fa-file-alt"></i>
                    </div>

                    <div>

                        <div class="summary-label">
                            Total Reports
                        </div>

                        <div class="summary-value">
                            {{ $reports->total() }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- Current Page --}}
            <div class="col-md-4">

                <div class="summary-card">

                    <div class="summary-icon orange">
                        <i class="fas fa-clock"></i>
                    </div>

                    <div>

                        <div class="summary-label">
                            Showing
                        </div>

                        <div class="summary-value">
                            {{ $reports->count() }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- HR --}}
            <div class="col-md-4">

                <div class="summary-card">

                    <div class="summary-icon green">
                        <i class="fas fa-user-shield"></i>
                    </div>

                    <div>

                        <div class="summary-label">
                            HR Review
                        </div>

                        <div class="summary-value">
                            Final Assessment
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- TABLE CARD --}}
        {{-- ========================================================= --}}

        <div class="table-card">

            <div class="table-card-header">

                <div>

                    <h5 class="mb-1 fw-bold">
                        Goal Self Reports
                    </h5>

                    <small class="text-muted">
                        Manager-approved reports and completed HR reviews.
                    </small>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table custom-table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Employee</th>

                            <th>Goal</th>

                            <th>Employee Rating</th>

                            <th>Manager Rating</th>

                            <th>HR Rating</th>

                            <th>Status</th>

                            <th class="text-center">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($reports as $report)

                            @php

                                $hrReview = $report->hrReview;

                            @endphp

                            <tr>

                                {{-- # --}}
                                <td>

                                    <span class="serial-number">

                                        {{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}

                                    </span>

                                </td>

                                {{-- Employee --}}
                                <td>

                                    <div class="employee-info">

                                        <div class="employee-avatar">

                                            <i class="fas fa-user"></i>

                                        </div>

                                        <div>

                                            <div class="employee-name">

                                                {{ $report->user->name ?? 'N/A' }}

                                            </div>

                                            <small class="text-muted">

                                                Report #{{ $report->id }}

                                            </small>

                                        </div>

                                    </div>

                                </td>

                                {{-- Goal --}}
                                <td>

                                    <div class="goal-text">

                                        {{ $report->goal->goal ?? 'N/A' }}

                                    </div>

                                </td>

                                {{-- Employee Rating --}}
                                <td>

                                    <span class="rating-badge blue">

                                        <i class="fas fa-star"></i>

                                        {{ $report->rating ?? 0 }} / 5

                                    </span>

                                </td>

                                {{-- Manager Rating --}}
                                <td>

                                    @if($report->manager_rating !== null)

                                        <span class="rating-badge orange">

                                            <i class="fas fa-star"></i>

                                            {{ $report->manager_rating }} / 5

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>

                                {{-- HR Rating --}}
                                <td>

                                    @if($report->hr_rating !== null)

                                        <span class="rating-badge green">

                                            <i class="fas fa-star"></i>

                                            {{ $report->hr_rating }} / 5

                                        </span>

                                    @else

                                        <span class="rating-badge pending">

                                            Pending

                                        </span>

                                    @endif

                                </td>

                                {{-- Status --}}
                                <td>

                                    @if($report->status === 'manager_approved')

                                        <span class="status-pill pending">

                                            <i class="fas fa-clock"></i>

                                            Pending HR

                                        </span>

                                    @elseif($report->status === 'hr_approved')

                                        <span class="status-pill approved">

                                            <i class="fas fa-check-circle"></i>

                                            HR Approved

                                        </span>

                                    @elseif($report->status === 'hr_rejected')

                                        <span class="status-pill rejected">

                                            <i class="fas fa-times-circle"></i>

                                            HR Rejected

                                        </span>

                                    @endif

                                </td>

                                {{-- Action --}}
                                <td class="text-center">

                                    <a href="{{ route('goal-hr.show', $report) }}" class="btn action-btn">

                                        @if($report->hr_rating !== null)

                                            <i class="fas fa-eye me-1"></i>

                                            View Review

                                        @else

                                            <i class="fas fa-clipboard-check me-1"></i>

                                            Final Review

                                        @endif

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-5">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i class="fas fa-folder-open"></i>

                                        </div>

                                        <h6 class="fw-bold mt-3">
                                            No Reports Found
                                        </h6>

                                        <p class="text-muted mb-0">
                                            No manager-approved or HR-reviewed reports are available.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            @if($reports->hasPages())

                <div class="pagination-wrapper">

                    {{ $reports->links() }}

                </div>

            @endif

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- STYLES --}}
    {{-- ========================================================= --}}

    <style>
        :root {

            --pms-primary: #1f4e79;
            --pms-primary-dark: #173a5c;
            --pms-light: #f4f7fb;
            --pms-border: #e4e9f0;
            --pms-text: #253449;
            --pms-muted: #718096;

        }

        /* PAGE HEADER */

        .hr-page-header {

            background: linear-gradient(135deg,
                    #ffffff 0%,
                    #f5f8fc 100%);

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            padding: 15px 20px;

            box-shadow:
                0 3px 12px rgba(31, 78, 121, .05);

        }

        .hr-page-header h3 {

            font-size: 20px;

        }

        .header-icon {

            width: 42px;
            height: 42px;

            border-radius: 10px;

            background: var(--pms-primary);

            color: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 17px;

        }

        /* SUMMARY */

        .summary-card {

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            padding: 14px 16px;

            display: flex;

            align-items: center;

            gap: 12px;

            box-shadow:
                0 3px 12px rgba(31, 78, 121, .04);

        }

        .summary-icon {

            width: 38px;
            height: 38px;

            border-radius: 9px;

            display: flex;

            align-items: center;

            justify-content: center;

        }

        .summary-icon.blue {

            background: #e8f1fa;
            color: #1f4e79;

        }

        .summary-icon.orange {

            background: #fff5dc;
            color: #b77900;

        }

        .summary-icon.green {

            background: #e7f6ed;
            color: #198754;

        }

        .summary-label {

            font-size: 10px;

            color: var(--pms-muted);

            text-transform: uppercase;

            font-weight: 700;

            letter-spacing: .3px;

        }

        .summary-value {

            font-size: 15px;

            color: var(--pms-text);

            font-weight: 800;

        }

        /* TABLE */

        .table-card {

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 4px 16px rgba(31, 78, 121, .05);

        }

        .table-card-header {

            padding: 15px 18px;

            background: linear-gradient(135deg,
                    #f5f8fc,
                    #ffffff);

            border-bottom: 1px solid var(--pms-border);

        }

        .table-card-header h5 {

            font-size: 15px;

        }

        /* TABLE HEADER */

        .custom-table thead th {

            background: var(--pms-primary);

            color: #fff;

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: .35px;

            font-weight: 700;

            padding: 11px 12px;

            border: none;

            white-space: nowrap;

        }

        .custom-table tbody td {

            padding: 12px;

            border-color: #edf1f5;

            color: var(--pms-text);

            font-size: 12px;

        }

        .custom-table tbody tr {

            transition: all .15s ease;

        }

        .custom-table tbody tr:hover {

            background: #f8fafc;

        }

        /* SERIAL */

        .serial-number {

            display: inline-flex;

            width: 27px;
            height: 27px;

            align-items: center;
            justify-content: center;

            background: #f2f6fa;

            border-radius: 7px;

            color: var(--pms-primary);

            font-weight: 700;

            font-size: 10px;

        }

        /* EMPLOYEE */

        .employee-info {

            display: flex;

            align-items: center;

            gap: 9px;

        }

        .employee-avatar {

            width: 34px;
            height: 34px;

            border-radius: 8px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

        }

        .employee-name {

            font-weight: 700;

            font-size: 12px;

        }

        /* GOAL */

        .goal-text {

            max-width: 300px;

            line-height: 1.45;

        }

        /* RATING BADGES */

        .rating-badge {

            display: inline-flex;

            align-items: center;

            gap: 4px;

            padding: 5px 8px;

            border-radius: 6px;

            font-size: 10px;

            font-weight: 700;

        }

        .rating-badge.blue {

            background: #e8f1fa;

            color: #1f4e79;

        }

        .rating-badge.orange {

            background: #fff5dc;

            color: #b77900;

        }

        .rating-badge.green {

            background: #e7f6ed;

            color: #198754;

        }

        .rating-badge.pending {

            background: #f3f4f6;

            color: #6b7280;

        }

        /* STATUS */

        .status-pill {

            display: inline-flex;

            align-items: center;

            gap: 5px;

            border-radius: 20px;

            padding: 5px 9px;

            font-size: 10px;

            font-weight: 700;

        }

        .status-pill.pending {

            background: #fff5dc;

            color: #b77900;

        }

        .status-pill.approved {

            background: #e7f6ed;

            color: #198754;

        }

        .status-pill.rejected {

            background: #fdecec;

            color: #dc3545;

        }

        /* ACTION */

        .action-btn {

            background: #e8f1fa;

            border: 1px solid #d7e5f2;

            color: var(--pms-primary);

            font-size: 11px;

            font-weight: 700;

            border-radius: 7px;

            padding: 7px 10px;

        }

        .action-btn:hover {

            background: var(--pms-primary);

            color: #fff;

            border-color: var(--pms-primary);

        }

        /* EMPTY */

        .empty-icon {

            width: 48px;
            height: 48px;

            border-radius: 12px;

            background: #f2f6fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

            margin: auto;

        }

        /* PAGINATION */

        .pagination-wrapper {

            padding: 12px 16px;

            border-top: 1px solid var(--pms-border);

        }

        /* RESPONSIVE */

        @media(max-width: 768px) {

            .hr-page-header {

                padding: 14px;

            }

            .table-card {

                border-radius: 10px;

            }

            .goal-text {

                min-width: 220px;

            }

        }
    </style>

@endsection
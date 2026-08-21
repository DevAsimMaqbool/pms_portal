@extends('layouts.app')

@section('content')

    <div class="container-fluid py-3">

        {{-- ========================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================================================= --}}

        <div class="review-page-header mb-3">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="header-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            Goal Manager Reviews
                        </h3>

                        <p class="mb-0 text-muted">
                            Review and manage employee goal assessments.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- SUCCESS --}}
        {{-- ========================================================= --}}

        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm mb-3">

                <i class="fas fa-check-circle me-2"></i>

                {{ session('success') }}

            </div>

        @endif

        {{-- ========================================================= --}}
        {{-- ERROR --}}
        {{-- ========================================================= --}}

        @if(session('error'))

            <div class="alert alert-danger border-0 shadow-sm mb-3">

                <i class="fas fa-exclamation-circle me-2"></i>

                {{ session('error') }}

            </div>

        @endif

        {{-- ========================================================= --}}
        {{-- REPORT TABLE --}}
        {{-- ========================================================= --}}

        <div class="reports-card">

            <div class="reports-card-header">

                <div class="d-flex align-items-center gap-2">

                    <div class="section-icon">
                        <i class="fas fa-list-check"></i>
                    </div>

                    <div>

                        <h5 class="mb-0 fw-bold">
                            Employee Goal Reports
                        </h5>

                        <small>
                            Pending, approved and rejected reports
                        </small>

                    </div>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table reports-table align-middle mb-0">

                    <thead>

                        <tr>

                            <th width="60">
                                #
                            </th>

                            <th>
                                Employee
                            </th>

                            <th>
                                Goal
                            </th>

                            <th>
                                Submitted
                            </th>

                            <th>
                                Employee Rating
                            </th>

                            <th>
                                Manager Rating
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="170">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($reports as $report)

                                            @php

                                                $status = strtolower($report->status ?? 'submitted');

                                                $statusLabel = match ($status) {
                                                    'approved' => 'Approved',
                                                    'rejected' => 'Rejected',
                                                    'submitted' => 'Pending',
                                                    default => ucwords(str_replace('_', ' ', $status)),
                                                };

                                            @endphp

                                            <tr>

                                                {{-- ID --}}
                                                <td>

                                                    <span class="report-id">
                                                        #{{ $report->id }}
                                                    </span>

                                                </td>

                                                {{-- Employee --}}
                                                <td>

                                                    <div class="employee-cell">

                                                        <div class="employee-avatar">

                                                            <i class="fas fa-user"></i>

                                                        </div>

                                                        <div>

                                                            <div class="employee-name">
                                                                {{ $report->user->name ?? 'N/A' }}
                                                            </div>

                                                            <small>
                                                                Employee
                                                            </small>

                                                        </div>

                                                    </div>

                                                </td>

                                                {{-- Goal --}}
                                                <td>

                                                    <div class="goal-text">

                                                        {{ \Illuminate\Support\Str::limit(
                                $report->goal->goal ?? 'N/A',
                                70
                            ) }}

                                                    </div>

                                                </td>

                                                {{-- Submitted --}}
                                                <td>

                                                    <div class="date-text">

                                                        {{ optional($report->submitted_at)->format('d M Y') }}

                                                        <small>
                                                            {{ optional($report->submitted_at)->format('h:i A') }}
                                                        </small>

                                                    </div>

                                                </td>

                                                {{-- Employee Rating --}}
                                                <td>

                                                    <span class="employee-rating">

                                                        <i class="fas fa-star"></i>

                                                        {{ $report->rating ?? 0 }}

                                                        <small>/ 5</small>

                                                    </span>

                                                </td>

                                                {{-- Manager Rating --}}
                                                <td>

                                                    @if($report->manager_rating !== null)

                                                        <span class="manager-rating">

                                                            <i class="fas fa-star"></i>

                                                            {{ $report->manager_rating }}

                                                            <small>/ 5</small>

                                                        </span>

                                                    @else

                                                        <span class="not-rated">
                                                            Not Rated
                                                        </span>

                                                    @endif

                                                </td>

                                                {{-- Status --}}
                                                <td>

                                                    @if($status === 'approved')

                                                        <span class="status-badge status-approved">

                                                            <i class="fas fa-check-circle"></i>

                                                            Approved

                                                        </span>

                                                    @elseif($status === 'rejected')

                                                        <span class="status-badge status-rejected">

                                                            <i class="fas fa-times-circle"></i>

                                                            Rejected

                                                        </span>

                                                    @else

                                                        <span class="status-badge status-pending">

                                                            <i class="fas fa-clock"></i>

                                                            Pending

                                                        </span>

                                                    @endif

                                                </td>

                                                {{-- Action --}}
                                                <td>

                                                    @if($report->manager_rating !== null)

                                                                            <a href="{{ route(
                                                            'goal-manager.show',
                                                            $report
                                                        ) }}" class="btn btn-success btn-sm action-btn">

                                                                                <i class="fas fa-eye me-1"></i>

                                                                                View / Update

                                                                            </a>

                                                    @else

                                                                            <a href="{{ route(
                                                            'goal-manager.show',
                                                            $report
                                                        ) }}" class="btn btn-primary btn-sm action-btn">

                                                                                <i class="fas fa-star me-1"></i>

                                                                                Give Rating

                                                                            </a>

                                                    @endif

                                                </td>

                                            </tr>

                        @empty

                            <tr>

                                <td colspan="8">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i class="fas fa-folder-open"></i>

                                        </div>

                                        <h6>
                                            No Goal Reports Found
                                        </h6>

                                        <p>
                                            There are currently no employee goal reports assigned to you.
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

    <style>
        :root {

            --pms-primary: #1f4e79;
            --pms-primary-dark: #173a5c;
            --pms-border: #e4e9f0;
            --pms-text: #253449;
            --pms-muted: #718096;

        }

        .review-page-header {

            background: linear-gradient(135deg,
                    #ffffff,
                    #f5f8fc);

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            padding: 15px 20px;

            box-shadow:
                0 3px 12px rgba(31, 78, 121, .05);

        }

        .review-page-header h3 {

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

        }

        .reports-card {

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 4px 16px rgba(31, 78, 121, .05);

        }

        .reports-card-header {

            padding: 14px 18px;

            background: linear-gradient(135deg,
                    #f5f8fc,
                    #ffffff);

            border-bottom: 1px solid var(--pms-border);

        }

        .reports-card-header small {

            color: var(--pms-muted);

            font-size: 10px;

        }

        .section-icon {

            width: 34px;
            height: 34px;

            border-radius: 8px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

        }

        .reports-table {

            font-size: 12px;

        }

        .reports-table thead th {

            background: #f8fafc;

            color: var(--pms-muted);

            font-size: 10px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .3px;

            padding: 11px 12px;

            border-bottom: 1px solid var(--pms-border);

            white-space: nowrap;

        }

        .reports-table tbody td {

            padding: 12px;

            border-bottom: 1px solid #edf1f5;

            color: var(--pms-text);

        }

        .reports-table tbody tr:hover {

            background: #f9fbfd;

        }

        .report-id {

            color: var(--pms-primary);

            font-weight: 700;

        }

        .employee-cell {

            display: flex;

            align-items: center;

            gap: 9px;

        }

        .employee-avatar {

            width: 32px;
            height: 32px;

            border-radius: 8px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

        }

        .employee-name {

            font-weight: 700;

            color: var(--pms-text);

        }

        .employee-cell small {

            color: var(--pms-muted);

            font-size: 9px;

        }

        .goal-text {

            max-width: 300px;

            line-height: 1.5;

        }

        .date-text {

            font-weight: 600;

        }

        .date-text small {

            display: block;

            color: var(--pms-muted);

            font-size: 9px;

            margin-top: 2px;

        }

        .employee-rating,
        .manager-rating {

            display: inline-flex;

            align-items: center;

            gap: 3px;

            font-weight: 800;

        }

        .employee-rating {

            color: var(--pms-primary);

        }

        .manager-rating {

            color: #b77900;

        }

        .employee-rating i,
        .manager-rating i {

            font-size: 10px;

        }

        .employee-rating small,
        .manager-rating small {

            color: var(--pms-muted);

            font-size: 9px;

        }

        .not-rated {

            color: var(--pms-muted);

            font-size: 10px;

        }

        .status-badge {

            display: inline-flex;

            align-items: center;

            gap: 5px;

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: 700;

            white-space: nowrap;

        }

        .status-approved {

            color: #198754;

            background: #e7f6ed;

        }

        .status-rejected {

            color: #dc3545;

            background: #fdebec;

        }

        .status-pending {

            color: #b77900;

            background: #fff5dc;

        }

        .action-btn {

            border-radius: 7px;

            font-size: 10px;

            padding: 7px 10px;

            white-space: nowrap;

        }

        .empty-state {

            text-align: center;

            padding: 45px 20px;

        }

        .empty-icon {

            width: 50px;
            height: 50px;

            border-radius: 12px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

            margin: 0 auto 12px;

            font-size: 20px;

        }

        .empty-state h6 {

            color: var(--pms-text);

            font-weight: 700;

        }

        .empty-state p {

            color: var(--pms-muted);

            font-size: 11px;

        }

        .pagination-wrapper {

            padding: 12px 18px;

            border-top: 1px solid var(--pms-border);

        }

        @media(max-width: 768px) {

            .reports-card {

                overflow-x: auto;

            }

            .reports-table {

                min-width: 950px;

            }

        }
    </style>

@endsection
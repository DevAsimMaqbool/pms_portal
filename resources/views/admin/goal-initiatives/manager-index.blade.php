@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

```
{{-- HEADER --}}
<div class="goal-page-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div class="d-flex align-items-center gap-3">
            <div class="header-icon">
                <i class="fas fa-user-check"></i>
            </div>

            <div>
                <h3 class="mb-1">Initiative / Extra Role Validation</h3>
                <p class="mb-0">
                    Review and monitor initiatives submitted by your team members.
                </p>
            </div>
        </div>

    </div>
</div>

{{-- ALERTS --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- SUMMARY CARDS --}}
<div class="row g-3 mb-4">

    {{-- TOTAL --}}
    <div class="col-xl col-lg-4 col-md-6">
        <div class="summary-card total-card">

            <div class="summary-icon">
                <i class="fas fa-layer-group"></i>
            </div>

            <div class="summary-content">
                <span>Total Initiatives</span>
                <strong>{{ $counts['total'] }}</strong>
            </div>

        </div>
    </div>

    {{-- PENDING --}}
    <div class="col-xl col-lg-4 col-md-6">
        <div class="summary-card pending-card">

            <div class="summary-icon">
                <i class="fas fa-clock"></i>
            </div>

            <div class="summary-content">
                <span>Pending Validation</span>
                <strong>{{ $counts['submitted'] }}</strong>
            </div>

        </div>
    </div>

    {{-- APPROVED --}}
    <div class="col-xl col-lg-4 col-md-6">
        <div class="summary-card approved-card">

            <div class="summary-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <div class="summary-content">
                <span>Approved</span>
                <strong>{{ $counts['approved'] }}</strong>
            </div>

        </div>
    </div>

    {{-- APPROVED WITH AMENDMENT --}}
    <div class="col-xl col-lg-4 col-md-6">
        <div class="summary-card amendment-card">

            <div class="summary-icon">
                <i class="fas fa-edit"></i>
            </div>

            <div class="summary-content">
                <span>Approved with Amendment</span>
                <strong>{{ $counts['approved_with_amendment'] }}</strong>
            </div>

        </div>
    </div>

    {{-- REJECTED --}}
    <div class="col-xl col-lg-4 col-md-6">
        <div class="summary-card rejected-card">

            <div class="summary-icon">
                <i class="fas fa-times-circle"></i>
            </div>

            <div class="summary-content">
                <span>Rejected</span>
                <strong>{{ $counts['rejected'] }}</strong>
            </div>

        </div>
    </div>

</div>

{{-- INITIATIVES TABLE --}}
<div class="pms-card">

    <div class="card-header-custom">

        <div>
            <h5 class="mb-1">
                <i class="fas fa-tasks me-2"></i>
                All Team Initiatives
            </h5>

            <span class="text-muted small">
                All initiatives submitted by your team members
            </span>
        </div>

        <span class="total-count">
            {{ $initiatives->total() }}
            {{ Str::plural('Initiative', $initiatives->total()) }}
        </span>

    </div>

    <div class="table-responsive">

        @if($initiatives->count())

            <table class="table pms-table align-middle mb-0">

                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Initiative</th>
                        <th>Dates</th>
                        <th>Scope</th>
                        <th>Initiative Status</th>
                        <th>Manager Decision</th>
                        <th>Submitted</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($initiatives as $initiative)

                        @php

                            $scopeLabels = [
                                'individual'       => 'Individual',
                                'team_peer'        => 'Team / Peer',
                                'departmental'     => 'Departmental',
                                'faculty_wide'     => 'Faculty Wide',
                                'institution_wide' => 'Institution Wide',
                            ];

                            $statusLabels = [
                                'idea_designed_only'   => 'Idea Designed Only',
                                'approved_in_progress' => 'Approved & In Progress',
                                'completed'            => 'Completed',
                                'completed_verified'   => 'Completed & Verified',
                            ];

                        @endphp

                        <tr>

                            {{-- EMPLOYEE --}}
                            <td>

                                <div class="employee-info">

                                    <div class="employee-avatar">
                                        {{ strtoupper(substr($initiative->user->name ?? 'U', 0, 1)) }}
                                    </div>

                                    <div>

                                        <div class="employee-name">
                                            {{ $initiative->user->name ?? 'N/A' }}
                                        </div>

                                        @if($initiative->user?->employee_id)

                                            <small class="text-muted">
                                                {{ $initiative->user->employee_id }}
                                            </small>

                                        @endif

                                    </div>

                                </div>

                            </td>

                            {{-- INITIATIVE --}}
                            <td>

                                <div class="initiative-title">
                                    {{ $initiative->title }}
                                </div>

                                <small class="text-muted">

                                    {{ $initiative->nature_of_initiative }}

                                    @if(
                                        $initiative->nature_of_initiative === 'Others'
                                        && $initiative->nature_other
                                    )
                                        — {{ $initiative->nature_other }}
                                    @endif

                                </small>

                            </td>

                            {{-- DATES --}}
                            <td>

                                <div class="date-info">

                                    <strong>
                                        {{ optional($initiative->from_date)->format('d M Y') }}
                                    </strong>

                                    <span>to</span>

                                    <strong>
                                        {{ optional($initiative->to_date)->format('d M Y') }}
                                    </strong>

                                </div>

                            </td>

                            {{-- SCOPE --}}
                            <td>

                                <span class="scope-badge">
                                    {{ $scopeLabels[$initiative->scope] ?? ucfirst(str_replace('_', ' ', $initiative->scope)) }}
                                </span>

                            </td>

                            {{-- INITIATIVE STATUS --}}
                            <td>

                                <span class="status-badge">
                                    {{ $statusLabels[$initiative->status] ?? ucfirst(str_replace('_', ' ', $initiative->status)) }}
                                </span>

                            </td>

                            {{-- MANAGER DECISION --}}
                            <td>

                                @switch($initiative->manager_decision)

                                    @case('submitted')

                                        <span class="decision-badge decision-pending">
                                            <i class="fas fa-clock me-1"></i>
                                            Pending Validation
                                        </span>

                                        @break

                                    @case('approved')

                                        <span class="decision-badge decision-approved">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Approved
                                        </span>

                                        @break

                                    @case('approved_with_amendment')

                                        <span class="decision-badge decision-amended">
                                            <i class="fas fa-edit me-1"></i>
                                            Approved with Amendment
                                        </span>

                                        @break

                                    @case('rejected')

                                        <span class="decision-badge decision-rejected">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Rejected
                                        </span>

                                        @break

                                    @default

                                        <span class="decision-badge decision-pending">
                                            Unknown
                                        </span>

                                @endswitch

                            </td>

                            {{-- SUBMITTED --}}
                            <td>

                                @if($initiative->submitted_at)

                                    <div>
                                        {{ $initiative->submitted_at->format('d M Y') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $initiative->submitted_at->format('h:i A') }}
                                    </small>

                                @else

                                    —

                                @endif

                            </td>

                            {{-- ACTION --}}
                            <td class="text-end">

                                @if($initiative->manager_decision === 'submitted')

                                    <a href="{{ route('goal-initiatives.manager.show', $initiative) }}"
                                       class="btn btn-review">

                                        <i class="fas fa-clipboard-check me-1"></i>
                                        Review

                                    </a>

                                @else

                                    <a href="{{ route('goal-initiatives.manager.show', $initiative) }}"
                                       class="btn btn-view">

                                        <i class="fas fa-eye me-1"></i>
                                        View

                                    </a>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fas fa-folder-open"></i>
                </div>

                <h5>No Initiatives Found</h5>

                <p class="text-muted mb-0">
                    No initiatives have been submitted by your team members yet.
                </p>

            </div>

        @endif

    </div>

    {{-- PAGINATION --}}
    @if($initiatives->hasPages())

        <div class="pagination-wrapper">
            {{ $initiatives->links() }}
        </div>

    @endif

</div>
```

</div>

<style>

    :root {
        --pms-primary: #1f4e79;
        --pms-primary-dark: #173a5c;
        --pms-border: #e4e9f0;
        --pms-text: #253449;
        --pms-muted: #718096;
    }

    /* HEADER */

    .goal-page-header {
        background: linear-gradient(
            135deg,
            var(--pms-primary),
            var(--pms-primary-dark)
        );

        color: #fff;
        border-radius: 14px;
        padding: 22px 26px;

        box-shadow:
            0 8px 25px rgba(31, 78, 121, .12);
    }

    .header-icon {
        width: 52px;
        height: 52px;

        border-radius: 12px;

        background: rgba(255,255,255,.15);

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 22px;
    }

    .goal-page-header h3 {
        color: #fff;
        font-weight: 700;
    }

    .goal-page-header p {
        color: rgba(255,255,255,.78) !important;
    }

    /* SUMMARY CARDS */

    .summary-card {
        background: #fff;

        border: 1px solid var(--pms-border);

        border-radius: 12px;

        padding: 18px;

        display: flex;
        align-items: center;

        gap: 14px;

        min-height: 92px;

        box-shadow:
            0 4px 15px rgba(37,52,73,.04);

        transition: .2s ease;
    }

    .summary-card:hover {
        transform: translateY(-2px);

        box-shadow:
            0 7px 20px rgba(37,52,73,.08);
    }

    .summary-icon {
        width: 48px;
        height: 48px;

        min-width: 48px;

        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 20px;
    }

    .summary-content {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .summary-content span {
        color: var(--pms-muted);

        font-size: 12px;

        font-weight: 600;
    }

    .summary-content strong {
        color: var(--pms-text);

        font-size: 25px;

        line-height: 1;

        font-weight: 700;
    }

    /* CARD COLORS */

    .total-card .summary-icon {
        background: #edf4fa;
        color: var(--pms-primary);
    }

    .pending-card .summary-icon {
        background: #fff4e5;
        color: #b86b00;
    }

    .approved-card .summary-icon {
        background: #eaf7ef;
        color: #218838;
    }

    .amendment-card .summary-icon {
        background: #edf4fa;
        color: var(--pms-primary);
    }

    .rejected-card .summary-icon {
        background: #fff0f0;
        color: #c0392b;
    }

    /* MAIN CARD */

    .pms-card {
        background: #fff;

        border: 1px solid var(--pms-border);

        border-radius: 14px;

        overflow: hidden;

        box-shadow:
            0 5px 20px rgba(37,52,73,.05);
    }

    .card-header-custom {
        padding: 20px 22px;

        border-bottom: 1px solid var(--pms-border);

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;
    }

    .card-header-custom h5 {
        color: var(--pms-text);

        font-weight: 700;
    }

    .total-count {
        background: #edf4fa;

        color: var(--pms-primary);

        border: 1px solid #d7e5f1;

        padding: 7px 13px;

        border-radius: 30px;

        font-size: 13px;

        font-weight: 600;
    }

    /* TABLE */

    .pms-table {
        color: var(--pms-text);
    }

    .pms-table thead th {
        background: #f8fafc;

        color: var(--pms-muted);

        font-size: 12px;

        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: .4px;

        padding: 15px 16px;

        border-bottom: 1px solid var(--pms-border);

        white-space: nowrap;
    }

    .pms-table tbody td {
        padding: 16px;

        border-bottom: 1px solid #edf1f5;

        vertical-align: middle;
    }

    .pms-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .pms-table tbody tr:hover {
        background: #fafcff;
    }

    /* EMPLOYEE */

    .employee-info {
        display: flex;

        align-items: center;

        gap: 10px;

        min-width: 180px;
    }

    .employee-avatar {
        width: 38px;
        height: 38px;

        min-width: 38px;

        border-radius: 50%;

        background: #eaf1f8;

        color: var(--pms-primary);

        display: flex;

        align-items: center;
        justify-content: center;

        font-weight: 700;

        font-size: 15px;
    }

    .employee-name {
        font-weight: 600;

        color: var(--pms-text);
    }

    /* INITIATIVE */

    .initiative-title {
        font-weight: 700;

        color: var(--pms-primary);

        max-width: 260px;
    }

    /* DATES */

    .date-info {
        display: flex;

        flex-direction: column;

        font-size: 13px;

        line-height: 1.5;
    }

    .date-info span {
        color: var(--pms-muted);

        font-size: 11px;
    }

    /* BADGES */

    .scope-badge,
    .status-badge,
    .decision-badge {
        display: inline-block;

        padding: 6px 10px;

        border-radius: 7px;

        font-size: 12px;

        font-weight: 600;

        white-space: nowrap;
    }

    .scope-badge {
        background: #f0f5fa;

        color: var(--pms-primary);
    }

    .status-badge {
        background: #fff8e8;

        color: #a66a00;
    }

    .decision-pending {
        background: #fff4e5;

        color: #b86b00;
    }

    .decision-approved {
        background: #eaf7ef;

        color: #218838;
    }

    .decision-amended {
        background: #edf4fa;

        color: var(--pms-primary);
    }

    .decision-rejected {
        background: #fff0f0;

        color: #c0392b;
    }

    /* BUTTONS */

    .btn-review,
    .btn-view {
        border-radius: 7px;

        padding: 8px 13px;

        font-size: 13px;

        font-weight: 600;

        border: 0;
    }

    .btn-review {
        background: var(--pms-primary);

        color: #fff;
    }

    .btn-review:hover {
        background: var(--pms-primary-dark);

        color: #fff;
    }

    .btn-view {
        background: #edf4fa;

        color: var(--pms-primary);

        border: 1px solid #d7e5f1;
    }

    .btn-view:hover {
        background: #e2edf6;

        color: var(--pms-primary-dark);
    }

    /* EMPTY */

    .empty-state {
        text-align: center;

        padding: 70px 20px;
    }

    .empty-icon {
        width: 65px;
        height: 65px;

        margin: 0 auto 18px;

        border-radius: 50%;

        background: #edf4fa;

        color: var(--pms-primary);

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 25px;
    }

    .empty-state h5 {
        color: var(--pms-text);

        font-weight: 700;
    }

    /* PAGINATION */

    .pagination-wrapper {
        padding: 18px 22px;

        border-top: 1px solid var(--pms-border);
    }

    /* RESPONSIVE */

    @media (max-width: 1200px) {

        .summary-card {
            min-height: 85px;
        }

    }

    @media (max-width: 768px) {

        .goal-page-header {
            padding: 18px;
        }

        .card-header-custom {
            align-items: flex-start;

            flex-direction: column;
        }

        .pms-table {
            min-width: 1250px;
        }

    }

</style>

@endsection
@extends('layouts.app')

@section('content')

<div class="container-fluid py-3">

    {{-- HEADER --}}
    <div class="manager-header mb-3">

        <div class="d-flex align-items-center justify-content-between">

            <div class="d-flex align-items-center gap-3">

                <div class="manager-header-icon">
                    <i class="fas fa-users"></i>
                </div>

                <div>
                    <h4 class="mb-1 fw-bold">
                        Goal Manager Reviews
                    </h4>

                    <small>
                        Select an employee to review all goals.
                    </small>
                </div>

            </div>

        </div>

    </div>

    {{-- ALERTS --}}

    @if(session('success'))

        <div class="alert alert-success border-0 shadow-sm py-2 mb-3">
            <i class="fas fa-check-circle me-1"></i>
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger border-0 shadow-sm py-2 mb-3">
            <i class="fas fa-exclamation-circle me-1"></i>
            {{ session('error') }}
        </div>

    @endif

    {{-- EMPLOYEE CARD --}}

    <div class="employee-card">

        <div class="employee-card-header">

            <div>
                <h5 class="mb-1 fw-bold">
                    My Employees
                </h5>

                <small>
                    Employees with submitted goals
                </small>
            </div>

            <span class="employee-count">
                {{ $employees->total() }}
                Employees
            </span>

        </div>

        <div class="employee-list">

            @forelse($employees as $employee)

                @php

                    $totalGoals = $employee->total_goals ?? 0;

                    $reviewedGoals = $employee->reviewed_goals ?? 0;

                    $pendingGoals = $employee->pending_goals ?? 0;

                    $complete =
                        $totalGoals > 0 &&
                        $pendingGoals === 0;

                @endphp

                <div class="employee-row">

                    {{-- EMPLOYEE --}}

                    <div class="employee-main">

                        <div class="employee-avatar">
                            <i class="fas fa-user"></i>
                        </div>

                        <div>

                            <div class="employee-name">
                                {{ $employee->name }}
                            </div>

                            <small class="employee-label">
                                Employee
                            </small>

                        </div>

                    </div>

                    {{-- GOAL COUNT --}}

                    <div class="employee-stat">

                        <span>
                            Goals
                        </span>

                        <strong>
                            {{ $totalGoals }}
                        </strong>

                    </div>

                    {{-- REVIEWED --}}

                    <div class="employee-stat">

                        <span>
                            Reviewed
                        </span>

                        <strong class="text-success">
                            {{ $reviewedGoals }}
                        </strong>

                    </div>

                    {{-- PENDING --}}

                    <div class="employee-stat">

                        <span>
                            Pending
                        </span>

                        <strong class="{{ $pendingGoals > 0 ? 'text-warning' : 'text-success' }}">
                            {{ $pendingGoals }}
                        </strong>

                    </div>

                    {{-- STATUS --}}

                    <div>

                        @if($complete)

                            <span class="status-badge status-complete">
                                <i class="fas fa-check-circle"></i>
                                All Reviewed
                            </span>

                        @else

                            <span class="status-badge status-pending">
                                <i class="fas fa-clock"></i>
                                Review Pending
                            </span>

                        @endif

                    </div>

                    {{-- ACTION --}}

                    <div>

                        <a href="{{ route('goal-manager.show', $employee) }}"
                           class="btn btn-primary btn-sm view-goals-btn">

                            <i class="fas fa-arrow-right me-1"></i>

                            View Goals

                        </a>

                    </div>

                </div>

            @empty

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fas fa-users"></i>
                    </div>

                    <h6>
                        No Employees Found
                    </h6>

                    <p>
                        No employees currently have submitted goals for review.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}

        @if($employees->hasPages())

            <div class="pagination-wrapper">
                {{ $employees->links() }}
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

body {
    background: #f7f9fc;
}

/* HEADER */

.manager-header {
    background: linear-gradient(
        135deg,
        #ffffff,
        #f5f8fc
    );

    border: 1px solid var(--pms-border);
    border-radius: 11px;

    padding: 13px 17px;

    box-shadow:
        0 3px 12px rgba(31, 78, 121, .05);
}

.manager-header-icon {
    width: 40px;
    height: 40px;

    border-radius: 9px;

    background: var(--pms-primary);
    color: #fff;

    display: flex;
    align-items: center;
    justify-content: center;
}

.manager-header h4 {
    font-size: 17px;
    color: var(--pms-text);
}

.manager-header small {
    font-size: 10px;
    color: var(--pms-muted);
}

/* CARD */

.employee-card {
    background: #fff;

    border: 1px solid var(--pms-border);
    border-radius: 11px;

    overflow: hidden;

    box-shadow:
        0 3px 14px rgba(31, 78, 121, .045);
}

/* CARD HEADER */

.employee-card-header {
    padding: 13px 16px;

    background: linear-gradient(
        135deg,
        #f5f8fc,
        #ffffff
    );

    border-bottom: 1px solid var(--pms-border);

    display: flex;
    align-items: center;
    justify-content: space-between;
}

.employee-card-header h5 {
    font-size: 14px;
    color: var(--pms-text);
}

.employee-card-header small {
    font-size: 9px;
    color: var(--pms-muted);
}

.employee-count {
    background: #e8f1fa;
    color: var(--pms-primary);

    border-radius: 15px;

    padding: 5px 10px;

    font-size: 10px;
    font-weight: 700;
}

/* EMPLOYEE ROW */

.employee-row {
    min-height: 68px;

    padding: 10px 15px;

    display: grid;

    grid-template-columns:
        minmax(220px, 1fr)
        80px
        90px
        80px
        130px
        120px;

    gap: 12px;

    align-items: center;

    border-bottom: 1px solid #edf1f5;

    transition: background .15s ease;
}

.employee-row:last-child {
    border-bottom: 0;
}

.employee-row:hover {
    background: #fafcfe;
}

/* EMPLOYEE */

.employee-main {
    display: flex;
    align-items: center;
    gap: 10px;
}

.employee-avatar {
    width: 36px;
    height: 36px;

    flex-shrink: 0;

    border-radius: 9px;

    background: #e8f1fa;
    color: var(--pms-primary);

    display: flex;
    align-items: center;
    justify-content: center;
}

.employee-name {
    font-size: 12px;
    font-weight: 700;
    color: var(--pms-text);
}

.employee-label {
    font-size: 9px;
    color: var(--pms-muted);
}

/* STATS */

.employee-stat span {
    display: block;

    color: var(--pms-muted);

    font-size: 8px;

    text-transform: uppercase;

    font-weight: 700;

    margin-bottom: 2px;
}

.employee-stat strong {
    font-size: 12px;
    color: var(--pms-text);
}

/* STATUS */

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    border-radius: 20px;

    padding: 5px 9px;

    font-size: 9px;

    font-weight: 700;

    white-space: nowrap;
}

.status-complete {
    color: #198754;
    background: #e7f6ed;
}

.status-pending {
    color: #b77900;
    background: #fff5dc;
}

/* BUTTON */

.view-goals-btn {
    border-radius: 6px;

    font-size: 10px;

    padding: 6px 10px;

    background: var(--pms-primary);
    border-color: var(--pms-primary);
}

.view-goals-btn:hover {
    background: var(--pms-primary-dark);
    border-color: var(--pms-primary-dark);
}

/* EMPTY */

.empty-state {
    text-align: center;
    padding: 45px 20px;
}

.empty-icon {
    width: 50px;
    height: 50px;

    margin: 0 auto 12px;

    border-radius: 12px;

    background: #e8f1fa;
    color: var(--pms-primary);

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 20px;
}

.empty-state h6 {
    color: var(--pms-text);
    font-size: 13px;
    font-weight: 700;
}

.empty-state p {
    color: var(--pms-muted);
    font-size: 10px;
}

/* PAGINATION */

.pagination-wrapper {
    padding: 11px 15px;
    border-top: 1px solid var(--pms-border);
}

/* MOBILE */

@media(max-width: 900px) {

    .employee-row {
        grid-template-columns: 1fr 1fr 1fr;
    }

    .employee-main {
        grid-column: 1 / -1;
    }

}

@media(max-width: 600px) {

    .employee-row {
        grid-template-columns: 1fr 1fr;
    }

    .employee-main {
        grid-column: 1 / -1;
    }

    .employee-row > div:last-child {
        text-align: right;
    }

}

</style>

@endsection
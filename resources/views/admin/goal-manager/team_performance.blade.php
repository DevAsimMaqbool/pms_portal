@extends('layouts.app')

@section('content')

<div class="container-fluid py-3">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="manager-header mb-3">

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

    {{-- =========================================================
        ALERTS
    ========================================================== --}}

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

    {{-- =========================================================
        EMPLOYEE CARD
    ========================================================== --}}

    <div class="employee-card">

        {{-- CARD HEADER --}}
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

        {{-- =====================================================
            TABLE WRAPPER
        ====================================================== --}}

        <div class="table-scroll">

            <div class="employee-list">

                {{-- =================================================
                    TABLE HEADER
                ================================================== --}}

                <div class="employee-row employee-header-row">

                    {{-- EMPLOYEE --}}
                    <div class="employee-header-main">
                        Employee
                    </div>

                    {{-- SELF --}}
                    <div class="rating-group-header">

                        <div class="rating-group-title">
                            Self
                        </div>

                        <div class="rating-sub-header">
                            <span>Score</span>
                            <span>Rating</span>
                        </div>

                    </div>

                    {{-- MANAGER --}}
                    <div class="rating-group-header">

                        <div class="rating-group-title">
                            Manager
                        </div>

                        <div class="rating-sub-header">
                            <span>Score</span>
                            <span>Rating</span>
                        </div>

                    </div>

                    {{-- HR --}}
                    <div class="rating-group-header">

                        <div class="rating-group-title">
                            HR
                        </div>

                        <div class="rating-sub-header">
                            <span>Score</span>
                            <span>Rating</span>
                        </div>

                    </div>

                    {{-- FEEDBACK --}}
                    <div class="rating-group-header">

                        <div class="rating-group-title">
                            Feedback
                        </div>

                        <div class="rating-sub-header">
                            <span>Score</span>
                            <span>Rating</span>
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="action-header">
                        Action
                    </div>

                </div>

                {{-- =================================================
                    EMPLOYEES
                ================================================== --}}

                @forelse($employees as $employee)

                    @php

                        /*
                         |--------------------------------------------------------------------------
                         | Scores
                         |--------------------------------------------------------------------------
                         */

                        $selfScore =
                            $employee->self_overall_rating ?? null;

                        $managerScore =
                            $employee->manager_overall_rating ?? null;

                        $hrScore =
                            $employee->hr_overall_rating ?? null;

                        $feedbackScore =
                            $employee->manager_feedback_overall ?? null;

                        /*
                         |--------------------------------------------------------------------------
                         | Rating Helper
                         |--------------------------------------------------------------------------
                         */

                        $getRating = function ($score) {

                            if ($score === null) {
                                return 'Pending';
                            }

                            $score = (float) $score;

                            if ($score >= 90) {
                                return 'OS';
                            }

                            if ($score >= 80) {
                                return 'EE';
                            }

                            if ($score >= 70) {
                                return 'ME';
                            }

                            if ($score >= 60) {
                                return 'NI';
                            }

                            return 'BE';

                        };

                        $ratingColors = [
                            'OS' => '#6EA8FE',
                            'EE' => '#96e2b4',
                            'ME' => '#ffcb9a',
                            'NI' => '#fd7e13',
                            'BE' => '#ff4c51',
                        ];
                    
                        $selfRating =
                            $getRating($selfScore*20);

                        $managerRating =
                            $getRating($managerScore*20);

                        $hrRating =
                            $getRating($hrScore*20);

                        $feedbackRating =
                            $getRating($feedbackScore);

                        /*
                         |--------------------------------------------------------------------------
                         | Goal Status
                         |--------------------------------------------------------------------------
                         */

                        $totalGoals =
                            $employee->total_goals ?? 0;

                        $reviewedGoals =
                            $employee->reviewed_goals ?? 0;

                        $pendingGoals =
                            $employee->pending_goals ?? 0;

                        $complete =
                            $totalGoals > 0 &&
                            $pendingGoals == 0;
$selfColor = $ratingColors[$selfRating] ?? '#adb5bd';
                        $managerColor = $ratingColors[$managerRating] ?? '#adb5bd';
                        $hrColor = $ratingColors[$hrRating] ?? '#adb5bd';
                        $feedbackColor = $ratingColors[$feedbackRating] ?? '#adb5bd';
                    @endphp

                    {{-- =================================================
                        EMPLOYEE ROW
                    ================================================== --}}

                    <div class="employee-row">

                        {{-- =============================================
                            EMPLOYEE
                        ============================================== --}}

                        <div class="employee-main">

                            <div class="employee-avatar">
                                <i class="fas fa-user"></i>
                            </div>

                            <div class="employee-info">

                                <div class="employee-name">
                                    {{ $employee->name }}
                                </div>

                                <small class="employee-label">
                                    Employee
                                </small>

                            </div>

                        </div>

                        {{-- =============================================
                            SELF
                        ============================================== --}}

                        <div class="rating-group">

                            {{-- SCORE --}}
                            <div class="rating-score self-score" style="color: {{ $selfColor }}; font-weight: 700;">

                                @if($selfScore !== null)

                                    {{ number_format((float) $selfScore*20, 2) }}

                                @else

                                    —

                                @endif

                            </div>

                            {{-- RATING --}}
                            <div class="rating-value"  style="color: {{ $selfColor }}; font-weight: 700;">

                                @if($selfScore !== null)

                                    {{ $selfRating }}

                                @else

                                    <span class="pending-text">
                                        Pending
                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- =============================================
                            MANAGER
                        ============================================== --}}

                        <div class="rating-group">

                            {{-- SCORE --}}
                            <div class="rating-score manager-score" style="color: {{ $managerColor }}; font-weight: 700;">

                                @if($managerScore !== null)

                                    {{ number_format((float) $managerScore*20, 2) }}

                                @else

                                    —

                                @endif

                            </div>

                            {{-- RATING --}}
                            <div class="rating-value" style="color: {{ $managerColor }}; font-weight: 700;">

                                @if($managerScore !== null)

                                    {{ $managerRating }}

                                @else

                                    <span class="pending-text">
                                        Pending
                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- =============================================
                            HR
                        ============================================== --}}

                        <div class="rating-group">

                            {{-- SCORE --}}
                            <div class="rating-score hr-score"  style="color: {{ $hrColor }}; font-weight: 700;">

                                @if($hrScore !== null)

                                    {{ number_format((float) $hrScore*20, 2) }}

                                @else

                                    —

                                @endif

                            </div>

                            {{-- RATING --}}
                            <div class="rating-value" style="color: {{ $hrColor }}; font-weight: 700;">

                                @if($hrScore !== null)

                                    {{ $hrRating }}

                                @else

                                    <span class="pending-text">
                                        Pending
                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- =============================================
                            FEEDBACK
                        ============================================== --}}

                        <div class="rating-group">

                            {{-- SCORE --}}
                            <div class="rating-score feedback-score" style="color: {{ $feedbackColor }}; font-weight: 700;">

                                @if($feedbackScore !== null)

                                    {{ number_format((float) $feedbackScore, 2) }}

                                @else

                                    —

                                @endif

                            </div>

                            {{-- RATING --}}
                            <div class="rating-value" style="color: {{ $feedbackColor }}; font-weight: 700;">

                                @if($feedbackScore !== null)

                                    {{ $feedbackRating }}

                                @else

                                    <span class="pending-text">
                                        Pending
                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- =============================================
                            ACTION
                        ============================================== --}}

                        <div class="action-cell">

                            <a href="{{ route('goal-manager.show', $employee) }}"
                               class="btn btn-primary btn-sm view-goals-btn">

                                <i class="fas fa-eye me-1"></i>

                                View

                            </a>

                        </div>

                    </div>

                @empty

                    {{-- EMPTY STATE --}}

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

        </div>

        {{-- =========================================================
            PAGINATION
        ========================================================== --}}

        @if($employees->hasPages())

            <div class="pagination-wrapper">

                <div class="pagination-info">

                    Showing

                    <strong>
                        {{ $employees->firstItem() }}
                    </strong>

                    to

                    <strong>
                        {{ $employees->lastItem() }}
                    </strong>

                    of

                    <strong>
                        {{ $employees->total() }}
                    </strong>

                    employees

                </div>

                <div class="pagination-container">

                    {{ $employees->links() }}

                </div>

            </div>

        @endif

    </div>

</div>

<style>

/* =========================================================
   VARIABLES
========================================================= */

:root {
    --pms-primary: #1f4e79;
    --pms-primary-dark: #173a5c;
    --pms-border: #e4e9f0;
    --pms-text: #253449;
    --pms-muted: #718096;
}

/* =========================================================
   BODY
========================================================= */

body {
    background: #f7f9fc;
}

/* =========================================================
   HEADER
========================================================= */

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

/* =========================================================
   CARD
========================================================= */

.employee-card {

    background: #fff;

    border: 1px solid var(--pms-border);

    border-radius: 11px;

    overflow: hidden;

    box-shadow:
        0 3px 14px rgba(31, 78, 121, .045);
}

/* =========================================================
   CARD HEADER
========================================================= */

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

/* =========================================================
   TABLE SCROLL
========================================================= */

.table-scroll {

    width: 100%;

    overflow-x: auto;

    overflow-y: hidden;

    scrollbar-width: thin;
}

/* =========================================================
   EMPLOYEE LIST
========================================================= */

.employee-list {

    width: 100%;

    min-width: 1050px;
}

/* =========================================================
   ROW
========================================================= */

.employee-row {

    min-height: 68px;

    padding: 10px 15px;

    display: grid;

    grid-template-columns:
        minmax(220px, 1.5fr)
        180px
        180px
        180px
        180px
        90px;

    gap: 10px;

    align-items: center;

    border-bottom: 1px solid #edf1f5;

    transition: background .15s ease;
}

.employee-row:last-child {

    border-bottom: 0;

}

.employee-row:not(.employee-header-row):hover {

    background: #fafcfe;

}

/* =========================================================
   TABLE HEADER
========================================================= */

.employee-header-row {

    min-height: 54px;

    background: #f7f9fc;

    color: var(--pms-muted);

    font-size: 9px;

    font-weight: 700;

    text-transform: uppercase;

}

.employee-header-main {

    padding-left: 2px;

}

/* =========================================================
   RATING GROUP HEADER
========================================================= */

.rating-group-header {

    text-align: center;

    border-left: 1px solid #e9edf2;

    padding: 0 8px;

}

.rating-group-title {

    color: var(--pms-text);

    font-size: 10px;

    font-weight: 800;

    margin-bottom: 6px;

}

.rating-sub-header {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 5px;

    color: #9aa6b2;

    font-size: 7px;

    font-weight: 700;

    text-transform: uppercase;
}

/* =========================================================
   RATING GROUP
========================================================= */

.rating-group {

    display: grid;

    grid-template-columns: 1fr 1fr;

    align-items: center;

    text-align: center;

    gap: 5px;

    border-left: 1px solid #f0f2f5;

    min-height: 42px;
}

/* =========================================================
   SCORE
========================================================= */

.rating-score {

    font-size: 13px;

    line-height: 1.2;

    font-weight: 800;
}

.self-score {

    color: var(--pms-primary);

}

.manager-score {

    color: #198754;

}

.hr-score {

    color: #6f42c1;

}

.feedback-score {

    color: #d97706;

}

/* =========================================================
   RATING
========================================================= */

.rating-value {

    font-size: 8px;

    line-height: 1.25;

    font-weight: 600;

    color: var(--pms-muted);

}

.pending-text {

    color: #a0a8b2;

    font-size: 8px;
}

/* =========================================================
   EMPLOYEE
========================================================= */

.employee-main {

    display: flex;

    align-items: center;

    gap: 10px;

    min-width: 0;
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

.employee-info {

    min-width: 0;
}

.employee-name {

    font-size: 12px;

    font-weight: 700;

    color: var(--pms-text);

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;
}

.employee-label {

    font-size: 9px;

    color: var(--pms-muted);
}

/* =========================================================
   ACTION
========================================================= */

.action-header {

    text-align: center;
}

.action-cell {

    text-align: center;
}

.view-goals-btn {

    border-radius: 6px;

    font-size: 9px;

    padding: 6px 10px;

    background: var(--pms-primary);

    border-color: var(--pms-primary);

}

.view-goals-btn:hover {

    background: var(--pms-primary-dark);

    border-color: var(--pms-primary-dark);

}

/* =========================================================
   EMPTY
========================================================= */

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

/* =========================================================
   PAGINATION
========================================================= */

.pagination-wrapper {

    padding: 12px 15px;

    border-top: 1px solid var(--pms-border);

    background: #fff;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;
}

.pagination-info {

    color: var(--pms-muted);

    font-size: 10px;

    white-space: nowrap;
}

.pagination-info strong {

    color: var(--pms-text);

    font-weight: 700;
}

.pagination-container {

    display: flex;

    align-items: center;

    justify-content: flex-end;
}

.pagination-container nav {

    margin: 0;
}

.pagination-container .pagination {

    margin: 0;

    display: flex;

    align-items: center;

    gap: 4px;
}

.pagination-container .page-item {

    margin: 0;
}

.pagination-container .page-link {

    min-width: 30px;

    height: 30px;

    padding: 0 9px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border: 1px solid var(--pms-border);

    border-radius: 6px !important;

    background: #fff;

    color: var(--pms-text);

    font-size: 10px;

    font-weight: 600;

    line-height: 1;

    box-shadow: none;

    transition: all .15s ease;
}

.pagination-container .page-link:hover {

    background: #f0f5fa;

    color: var(--pms-primary);

    border-color: #c9d8e7;
}

.pagination-container .page-item.active .page-link {

    background: var(--pms-primary);

    border-color: var(--pms-primary);

    color: #fff;

    box-shadow:
        0 2px 6px rgba(31, 78, 121, .18);
}

.pagination-container .page-item.disabled .page-link {

    background: #f7f9fc;

    color: #b3bcc7;

    border-color: var(--pms-border);

    cursor: not-allowed;
}

.pagination-container .page-link:focus {

    box-shadow: none;

    outline: none;
}

.pagination-container .page-item:first-child .page-link,
.pagination-container .page-item:last-child .page-link {

    padding-left: 10px;

    padding-right: 10px;
}

/* =========================================================
   TABLET
========================================================= */

@media(max-width: 900px) {

    .pagination-wrapper {

        flex-direction: column;

        align-items: center;

        justify-content: center;

    }

    .pagination-info {

        text-align: center;

    }

    .pagination-container {

        justify-content: center;

    }

}

/* =========================================================
   MOBILE
========================================================= */

@media(max-width: 600px) {

    .employee-card {

        border-radius: 8px;

    }

    .employee-card-header {

        padding: 11px 12px;

    }

    .pagination-wrapper {

        padding: 10px;

    }

    .pagination-container .pagination {

        gap: 3px;

        flex-wrap: wrap;

        justify-content: center;

    }

    .pagination-container .page-link {

        min-width: 28px;

        height: 28px;

        padding: 0 7px;

        font-size: 9px;

    }

}

</style>

@endsection
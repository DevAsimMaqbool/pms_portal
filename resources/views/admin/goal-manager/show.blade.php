@extends('layouts.app')

@section('content')

<div class="container-fluid py-3">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="page-header mb-3">

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">

            <div class="d-flex align-items-center gap-3">

                <div class="header-icon">
                    <i class="fas fa-user-check"></i>
                </div>

                <div>

                    <h4 class="mb-1 fw-bold">
                        Employee Goal Review
                    </h4>

                    <div class="employee-heading">

                        <i class="fas fa-user me-1"></i>

                        {{ $user->name }}

                    </div>

                </div>

            </div>

            <a href="{{ route('goal-manager.index') }}"
               class="btn btn-light border btn-sm">

                <i class="fas fa-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- ALERTS --}}
    {{-- ========================================================= --}}

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

    @if($errors->any())

        <div class="alert alert-danger border-0 shadow-sm py-2 mb-3">

            <strong>
                Please correct the following:
            </strong>

            <ul class="mb-0 mt-1">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- ========================================================= --}}
    {{-- SUMMARY --}}
    {{-- ========================================================= --}}

    <div class="summary-card mb-3">

        <div class="summary-item">

            <span>
                Total Goals
            </span>

            <strong>
                {{ $reports->count() }}
            </strong>

        </div>

        <div class="summary-item">

            <span>
                Reviewed
            </span>

            <strong class="text-success">
                {{ $reviewedGoals }}
            </strong>

        </div>

        <div class="summary-item">

            <span>
                Pending
            </span>

            <strong class="{{ $pendingGoals > 0 ? 'text-warning' : 'text-success' }}">
                {{ $pendingGoals }}
            </strong>

        </div>

        <div class="summary-item">

            <span>
                Total Weightage
            </span>

            <strong>
                {{ number_format($totalWeightage, 2) }}%
            </strong>

        </div>

        <div class="summary-item">

            <span>
                Calculated Overall
            </span>

            <strong class="overall-rating">

                {{ $calculatedOverallRating !== null
                    ? number_format($calculatedOverallRating, 2)
                    : '-' }}

                @if($calculatedOverallRating !== null)

                    <small>/ 5</small>

                @endif

            </strong>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- SECTION --}}
    {{-- ========================================================= --}}

    <div class="section-header mb-2">

        <div>

            <h5 class="mb-1 fw-bold">
                Employee Goals
            </h5>

            <small>
                Review each goal and provide your assessment.
            </small>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- GOALS --}}
    {{-- ========================================================= --}}

    @forelse($reports as $index => $report)

        @php

            $managerReview = $report->managerReview;

            $isReviewed = $report->manager_rating !== null;

            $existingWeight = old(
                'weightage',
                $report->weightage
            );

            $existingRating = old(
                'manager_rating',
                $report->manager_rating
            );

            $existingDecision = old(
                'decision',
                optional($managerReview)->decision
            );

            $existingComments = old(
                'comments',
                optional($managerReview)->comments
            );

        @endphp

        <div class="goal-card mb-3">

            {{-- ================================================= --}}
            {{-- GOAL HEADER --}}
            {{-- ================================================= --}}

            <div class="goal-header">

                <div class="goal-number">
                    {{ $index + 1 }}
                </div>

                <div class="goal-header-content">

                    <div class="goal-header-title">
                        Goal {{ $index + 1 }}
                    </div>

                    @if($existingDecision === 'rejected')

                        <span class="goal-status rejected">

                            <i class="fas fa-times-circle"></i>

                            Rejected

                        </span>

                    @elseif($isReviewed)

                        <span class="goal-status reviewed">

                            <i class="fas fa-check-circle"></i>

                            Reviewed

                        </span>

                    @else

                        <span class="goal-status pending">

                            <i class="fas fa-clock"></i>

                            Pending

                        </span>

                    @endif

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- GOAL BODY --}}
            {{-- ================================================= --}}

            <div class="goal-body">

                {{-- ================================================= --}}
                {{-- GOAL TEXT --}}
                {{-- ================================================= --}}

                <div class="goal-main">

                    <div class="field-label">

                        <i class="fas fa-bullseye"></i>

                        Goal

                    </div>

                    <div class="goal-text">

                        {{ $report->goal->goal ?? 'N/A' }}

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- DETAILS --}}
                {{-- ================================================= --}}

                <div class="goal-details">

                    <div class="detail-box">

                        <span>

                            <i class="fas fa-link"></i>

                            S2R Driver / Enabler

                        </span>

                        <strong>

                            {{ $report->goal->s2rDriver->driver_name ?? 'N/A' }}

                        </strong>

                    </div>

                    <div class="detail-box">

                        <span>

                            <i class="fas fa-calendar"></i>

                            Deadline

                        </span>

                        <strong>

                            @if(!empty($report->goal->deadline))

                                {{ \Carbon\Carbon::parse($report->goal->deadline)->format('d M Y') }}

                            @else

                                N/A

                            @endif

                        </strong>

                    </div>

                    <div class="detail-box">

                        <span>

                            <i class="fas fa-list-check"></i>

                            Objective

                        </span>

                        <strong>

                            {{ $report->goal->objectives ?: 'N/A' }}

                        </strong>

                    </div>

                    <div class="detail-box">

                        <span>

                            <i class="fas fa-flag-checkered"></i>

                            Target

                        </span>

                        <strong>

                            {{ $report->goal->target ?? 'N/A' }}

                        </strong>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- EMPLOYEE ASSESSMENT --}}
                {{-- ================================================= --}}

                <div class="employee-assessment">

                    <div class="assessment-label">

                        Employee Assessment

                    </div>

                    <div class="assessment-grid">

                        <div>

                            <span>
                                Achievement
                            </span>

                            <strong>

                                {{ ucwords(str_replace(
                                    '_',
                                    ' ',
                                    $report->achievement_status
                                )) }}

                            </strong>

                        </div>

                        <div>

                            <span>
                                Employee Rating
                            </span>

                            <strong class="employee-rating">

                                <i class="fas fa-star"></i>

                                {{ $report->rating ?? 0 }}

                                <small>/ 5</small>

                            </strong>

                        </div>

                        <div>

                            <span>
                                Progress
                            </span>

                            <strong class="progress-text">

                                {{ $report->progress_against_goal }}

                            </strong>

                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- MANAGER REVIEW --}}
                {{-- ================================================= --}}

                <div class="manager-review-box">

                    <div class="manager-review-title">

                        <div>

                            <i class="fas fa-user-tie"></i>

                            Manager Assessment

                        </div>

                        @if($existingDecision === 'rejected')

                            <span class="reviewed-label rejected-label">

                                <i class="fas fa-times-circle me-1"></i>

                                Rejected

                            </span>

                        @elseif($isReviewed)

                            <span class="reviewed-label">

                                <i class="fas fa-check-circle me-1"></i>

                                Already Reviewed

                            </span>

                        @endif

                    </div>

                    <form method="POST"
                          action="{{ route(
                              'goal-manager.review',
                              $report
                          ) }}">

                        @csrf

                        <div class="manager-form-grid">

    {{-- ===================================== --}}
    {{-- WEIGHTAGE --}}
    {{-- ===================================== --}}

    <div>

        <label class="form-label">

            Goal Weightage (%)

            <span class="text-danger">
                *
            </span>

        </label>

        <div class="input-group input-group-sm">

            <input
                type="number"
                name="weightage"
                class="form-control weightage-input"
                value="{{ $existingWeight ?? 0 }}"
                min="0"
                max="100"
                step="0.01"
                placeholder="e.g. 20"
                required
            >

            <span class="input-group-text">
                %
            </span>

        </div>

        <small class="form-help">

            Contribution of this goal to overall performance.

        </small>

    </div>

    {{-- ===================================== --}}
    {{-- MANAGER RATING --}}
    {{-- ===================================== --}}

    <div>

        <label class="form-label">

            Manager Rating

            <span class="text-danger">
                *
            </span>

        </label>

        <div class="rating-options">

            @for($i = 0; $i <= 5; $i++)

                <label class="rating-option">

                    <input
                        type="radio"
                        name="manager_rating"
                        value="{{ $i }}"
                        {{ $existingRating !== null &&
                            (int) $existingRating === $i
                            ? 'checked'
                            : '' }}
                        required
                    >

                    <span>
                        {{ $i }}
                    </span>

                </label>

            @endfor

        </div>

        <small class="form-help">

            Rate achievement from 0 to 5.

        </small>

    </div>

    {{-- ===================================== --}}
    {{-- DECISION --}}
    {{-- ===================================== --}}

    <div>

        <label class="form-label">

            Decision

            <span class="text-danger">
                *
            </span>

        </label>

        <select
            name="decision"
            class="form-select form-select-sm decision-select"
            required
        >

            <option value="">
                Select Decision
            </option>

            <option
                value="approved"
                {{ $existingDecision === 'approved'
                    ? 'selected'
                    : '' }}
            >
                Approve
            </option>

            <option
                value="rejected"
                {{ $existingDecision === 'rejected'
                    ? 'selected'
                    : '' }}
            >
                Reject
            </option>

        </select>

    </div>

</div>

                        {{-- ================================================= --}}
                        {{-- COMMENTS --}}
                        {{-- ================================================= --}}

                        <div class="mt-3">

                            <label class="form-label">

                                Manager Remarks

                            </label>

                            <textarea
                                name="comments"
                                class="form-control form-control-sm"
                                rows="2"
                                placeholder="Enter remarks for this goal..."
                            >{{ $existingComments }}</textarea>

                        </div>

                        {{-- ================================================= --}}
                        {{-- ACTION --}}
                        {{-- ================================================= --}}

                        <div class="form-actions">

                            <button
                                type="submit"
                                class="btn btn-primary btn-sm"
                            >

                                @if($isReviewed)

                                    <i class="fas fa-save me-1"></i>

                                    Update Goal Review

                                @else

                                    <i class="fas fa-check me-1"></i>

                                    Save Goal Review

                                @endif

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @empty

        {{-- ================================================= --}}
        {{-- EMPTY --}}
        {{-- ================================================= --}}

        <div class="empty-state">

            <div class="empty-icon">

                <i class="fas fa-folder-open"></i>

            </div>

            <h6>
                No Goals Found
            </h6>

            <p>
                This employee has no submitted goals available for review.
            </p>

        </div>

    @endforelse

    {{-- ========================================================= --}}
    {{-- OVERALL MANAGER REVIEW --}}
    {{-- ========================================================= --}}

    @if($reports->count())

        <div class="overall-card mt-4">

            <div class="overall-header">

                <div>

                    <h5 class="mb-1 fw-bold text-white">

                        Overall Employee Performance

                    </h5>

                    <small>

                        Submit your final overall assessment after reviewing all goals.

                    </small>

                </div>

                <div class="overall-calculated">

                    <span>
                        Weighted Calculation
                    </span>

                    <strong>

                        {{ $calculatedOverallRating !== null
                            ? number_format($calculatedOverallRating, 2)
                            : '-' }}

                        @if($calculatedOverallRating !== null)

                            / 5

                        @endif

                    </strong>

                </div>

            </div>

            <div class="overall-body">

                @if($pendingGoals > 0)

                    <div class="overall-warning mb-3">

                        <i class="fas fa-exclamation-circle"></i>

                        Please review all

                        <strong>
                            {{ $pendingGoals }}
                        </strong>

                        pending goal(s) before submitting the overall assessment.

                    </div>

                @endif

                <form method="POST"
                      action="{{ route(
                          'goal-manager.overall-review',
                          $user
                      ) }}">

                    @csrf

                    <div class="row g-3">

                        {{-- ========================================= --}}
                        {{-- COMMENTS --}}
                        {{-- ========================================= --}}

                        <div class="col-lg-12">

                            <label class="form-label">

                                Overall Remarks

                            </label>

                            <textarea
                                name="manager_overll_comments"
                                class="form-control form-control-sm"
                                rows="2"
                                placeholder="Overall performance remarks..."
                            >{{ old(
                                'manager_overll_comments',
                                optional($overallReview)->manager_overll_comments
                            ) }}</textarea>

                        </div>

                    </div>

                    <div class="overall-actions">

                        <button
                            type="submit"
                            class="btn btn-primary btn-sm"
                            {{ $pendingGoals > 0 ? 'disabled' : '' }}
                        >

                            <i class="fas fa-paper-plane me-1"></i>

                            Save Overall Assessment

                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif

</div>

<style>

/* ========================================================= */
/* VARIABLES */
/* ========================================================= */

:root {

    --pms-primary: #1f4e79;

    --pms-primary-dark: #173a5c;

    --pms-border: #e4e9f0;

    --pms-text: #253449;

    --pms-muted: #718096;

}

/* ========================================================= */
/* BODY */
/* ========================================================= */

body {

    background: #f7f9fc;

}

/* ========================================================= */
/* HEADER */
/* ========================================================= */

.page-header {

    background: #fff;

    border: 1px solid var(--pms-border);

    border-radius: 10px;

    padding: 12px 15px;

    box-shadow:
        0 2px 9px rgba(31, 78, 121, .04);

}

.header-icon {

    width: 38px;

    height: 38px;

    border-radius: 9px;

    background: var(--pms-primary);

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

}

.page-header h4 {

    font-size: 16px;

    color: var(--pms-text);

}

.employee-heading {

    color: var(--pms-primary);

    font-size: 11px;

    font-weight: 700;

}

/* ========================================================= */
/* SUMMARY */
/* ========================================================= */

.summary-card {

    background: #fff;

    border: 1px solid var(--pms-border);

    border-radius: 10px;

    display: grid;

    grid-template-columns:
        repeat(5, 1fr);

    overflow: hidden;

    box-shadow:
        0 2px 9px rgba(31, 78, 121, .035);

}

.summary-item {

    padding: 10px 13px;

    border-right: 1px solid var(--pms-border);

}

.summary-item:last-child {

    border-right: 0;

}

.summary-item span {

    display: block;

    color: var(--pms-muted);

    font-size: 8px;

    font-weight: 700;

    text-transform: uppercase;

    margin-bottom: 2px;

}

.summary-item strong {

    color: var(--pms-text);

    font-size: 14px;

}

.overall-rating {

    color: var(--pms-primary) !important;

}

.overall-rating small {

    color: var(--pms-muted);

    font-size: 9px;

}

/* ========================================================= */
/* SECTION */
/* ========================================================= */

.section-header h5 {

    color: var(--pms-text);

    font-size: 14px;

}

.section-header small {

    color: var(--pms-muted);

    font-size: 9px;

}

/* ========================================================= */
/* GOAL CARD */
/* ========================================================= */

.goal-card {

    background: #fff;

    border: 1px solid var(--pms-border);

    border-radius: 10px;

    overflow: hidden;

    box-shadow:
        0 2px 9px rgba(31, 78, 121, .035);

}

/* ========================================================= */
/* GOAL HEADER */
/* ========================================================= */

.goal-header {

    padding: 10px 13px;

    background: linear-gradient(
        135deg,
        #f5f8fc,
        #ffffff
    );

    border-bottom: 1px solid var(--pms-border);

    display: flex;

    align-items: center;

    gap: 9px;

}

.goal-number {

    width: 29px;

    height: 29px;

    border-radius: 7px;

    background: var(--pms-primary);

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 11px;

    font-weight: 800;

}

.goal-header-content {

    display: flex;

    align-items: center;

    gap: 8px;

}

.goal-header-title {

    color: var(--pms-text);

    font-size: 12px;

    font-weight: 800;

}

.goal-status {

    padding: 3px 7px;

    border-radius: 15px;

    font-size: 8px;

    font-weight: 700;

}

.goal-status.reviewed {

    color: #198754;

    background: #e7f6ed;

}

.goal-status.pending {

    color: #b77900;

    background: #fff5dc;

}

.goal-status.rejected {

    color: #dc3545;

    background: #fdebec;

}

/* ========================================================= */
/* BODY */
/* ========================================================= */

.goal-body {

    padding: 13px;

}

/* ========================================================= */
/* MAIN GOAL */
/* ========================================================= */

.field-label {

    color: var(--pms-muted);

    font-size: 8px;

    font-weight: 800;

    text-transform: uppercase;

    margin-bottom: 4px;

}

.field-label i {

    color: var(--pms-primary);

    margin-right: 3px;

}

.goal-text {

    color: var(--pms-text);

    font-size: 13px;

    font-weight: 700;

    line-height: 1.5;

    margin-bottom: 12px;

}

/* ========================================================= */
/* DETAILS */
/* ========================================================= */

.goal-details {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 7px;

    margin-bottom: 10px;

}

.detail-box {

    background: #f8fafc;

    border: 1px solid #edf0f4;

    border-radius: 7px;

    padding: 8px 9px;

}

.detail-box span {

    display: block;

    color: var(--pms-muted);

    font-size: 8px;

    font-weight: 700;

    text-transform: uppercase;

    margin-bottom: 3px;

}

.detail-box span i {

    color: var(--pms-primary);

    margin-right: 2px;

}

.detail-box strong {

    display: block;

    color: var(--pms-text);

    font-size: 10px;

    line-height: 1.4;

}

/* ========================================================= */
/* EMPLOYEE ASSESSMENT */
/* ========================================================= */

.employee-assessment {

    border: 1px solid #e6ebf1;

    border-radius: 8px;

    overflow: hidden;

    margin-bottom: 11px;

}

.assessment-label {

    background: #f5f8fc;

    color: var(--pms-primary);

    padding: 7px 10px;

    font-size: 9px;

    font-weight: 800;

    text-transform: uppercase;

    border-bottom: 1px solid #e6ebf1;

}

.assessment-grid {

    display: grid;

    grid-template-columns:
        160px 150px 1fr;

}

.assessment-grid > div {

    padding: 8px 10px;

    border-right: 1px solid #edf0f4;

}

.assessment-grid > div:last-child {

    border-right: 0;

}

.assessment-grid span {

    display: block;

    color: var(--pms-muted);

    font-size: 8px;

    text-transform: uppercase;

    font-weight: 700;

    margin-bottom: 2px;

}

.assessment-grid strong {

    color: var(--pms-text);

    font-size: 10px;

}

.employee-rating {

    color: var(--pms-primary) !important;

}

.employee-rating i {

    font-size: 8px;

}

.employee-rating small {

    color: var(--pms-muted);

    font-size: 8px;

}

.progress-text {

    font-weight: 500 !important;

    line-height: 1.4;

}

/* ========================================================= */
/* MANAGER REVIEW */
/* ========================================================= */

.manager-review-box {

    border: 1px solid #dfe7ef;

    border-radius: 8px;

    background: #fbfcfe;

    overflow: hidden;

}

.manager-review-title {

    padding: 8px 10px;

    background: #f2f6fa;

    border-bottom: 1px solid #dfe7ef;

    display: flex;

    justify-content: space-between;

    align-items: center;

    color: var(--pms-primary);

    font-size: 10px;

    font-weight: 800;

}

.reviewed-label {

    color: #198754;

    background: #e7f6ed;

    padding: 3px 7px;

    border-radius: 12px;

    font-size: 8px;

}

.rejected-label {

    color: #dc3545;

    background: #fdebec;

}

/* ========================================================= */
/* FORM */
/* ========================================================= */

.manager-review-box form {

    padding: 11px;

}

.manager-form-grid {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 10px;
}

.form-label {

    color: var(--pms-text);

    font-size: 9px;

    font-weight: 700;

    margin-bottom: 4px;

}

.form-control,
.form-select {

    border-color: #dce2e9;

    border-radius: 6px;

    font-size: 10px;

}

.form-control:focus,
.form-select:focus {

    border-color: var(--pms-primary);

    box-shadow:
        0 0 0 .12rem rgba(31, 78, 121, .08);

}

.form-help {

    display: block;

    color: var(--pms-muted);

    font-size: 8px;

    margin-top: 3px;

}

/* ========================================================= */
/* RATING */
/* ========================================================= */

.rating-options {

    display: flex;

    gap: 4px;

}

.rating-option {

    cursor: pointer;

    margin: 0;

}

.rating-option input {

    display: none;

}

.rating-option span {

    width: 31px;

    height: 31px;

    border: 1px solid #dce2e9;

    border-radius: 6px;

    background: #fff;

    color: var(--pms-text);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 10px;

    font-weight: 800;

    transition: .15s;

}

.rating-option span:hover {

    border-color: var(--pms-primary);

}

.rating-option input:checked + span {

    background: var(--pms-primary);

    border-color: var(--pms-primary);

    color: #fff;

    box-shadow:
        0 3px 7px rgba(31, 78, 121, .16);

}

/* ========================================================= */
/* FORM ACTION */
/* ========================================================= */

.form-actions {

    display: flex;

    justify-content: flex-end;

    margin-top: 9px;

    padding-top: 9px;

    border-top: 1px solid #e7ebf0;

}

.form-actions .btn {

    font-size: 9px;

    border-radius: 6px;

    padding: 6px 10px;

}

/* ========================================================= */
/* OVERALL */
/* ========================================================= */

.overall-card {

    background: #fff;

    border: 1px solid var(--pms-border);

    border-radius: 10px;

    overflow: hidden;

    box-shadow:
        0 3px 12px rgba(31, 78, 121, .05);

}

.overall-header {

    padding: 12px 14px;

    background: linear-gradient(
        135deg,
        var(--pms-primary),
        var(--pms-primary-dark)
    );

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

}

.overall-header h5 {

    font-size: 13px;

}

.overall-header small {

    font-size: 9px;

    opacity: .8;

}

.overall-calculated {

    text-align: right;

}

.overall-calculated span {

    display: block;

    font-size: 8px;

    opacity: .75;

    text-transform: uppercase;

}

.overall-calculated strong {

    font-size: 20px;

}

.overall-body {

    padding: 13px;

}

.overall-warning {

    padding: 8px 10px;

    background: #fff5dc;

    color: #9a6700;

    border-radius: 6px;

    font-size: 9px;

}

.overall-actions {

    display: flex;

    justify-content: flex-end;

    margin-top: 10px;

    padding-top: 10px;

    border-top: 1px solid var(--pms-border);

}

.overall-actions .btn {

    font-size: 10px;

    border-radius: 6px;

}

/* ========================================================= */
/* EMPTY */
/* ========================================================= */

.empty-state {

    background: #fff;

    border: 1px solid var(--pms-border);

    border-radius: 10px;

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

    margin: 0 auto 10px;

    font-size: 19px;

}

.empty-state h6 {

    color: var(--pms-text);

    font-size: 13px;

}

.empty-state p {

    color: var(--pms-muted);

    font-size: 10px;

}

/* ========================================================= */
/* RESPONSIVE */
/* ========================================================= */

@media(max-width: 900px) {

    .summary-card {

        grid-template-columns:
            repeat(3, 1fr);

    }

    .summary-item:nth-child(3) {

        border-right: 0;

    }

    .goal-details {

        grid-template-columns:
            repeat(2, 1fr);

    }

    .assessment-grid {

        grid-template-columns:
            1fr 1fr;

    }

    .assessment-grid > div:last-child {

        grid-column: 1 / -1;

        border-top: 1px solid #edf0f4;

        border-right: 0;

    }

    .manager-form-grid {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 10px;
}

}

@media(max-width: 600px) {

    .summary-card {

        grid-template-columns:
            1fr 1fr;

    }

    .summary-item {

        border-bottom: 1px solid var(--pms-border);

    }

    .goal-details {

        grid-template-columns: 1fr;

    }

   .manager-form-grid {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 10px;
}

    .overall-header {

        align-items: flex-start;

        flex-direction: column;

    }

    .overall-calculated {

        text-align: left;

    }

}

</style>

{{-- ========================================================= --}}
{{-- REJECT HANDLER --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Handle every manager review form separately
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.manager-review-box form')
        .forEach(function (form) {

            const decisionSelect =
                form.querySelector('.decision-select');

            const weightageInput =
                form.querySelector('.weightage-input');

            const ratingInputs =
                form.querySelectorAll(
                    'input[name="manager_rating"]'
                );

            if (
                !decisionSelect ||
                !weightageInput ||
                !ratingInputs.length
            ) {

                return;

            }

            /*
            |--------------------------------------------------------------------------
            | Set Manager Rating
            |--------------------------------------------------------------------------
            */

            function setRating(value) {

                ratingInputs.forEach(function (radio) {

                    radio.checked =
                        radio.value === String(value);

                });

            }

            /*
            |--------------------------------------------------------------------------
            | Handle Decision
            |--------------------------------------------------------------------------
            */

            function handleDecision() {

                /*
                --------------------------------------------------------------
                | REJECT
                --------------------------------------------------------------
                */

                if (
                    decisionSelect.value === 'rejected'
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Automatically set Weightage = 0
                    |--------------------------------------------------------------------------
                    */

                    weightageInput.value = '0';

                    /*
                    |--------------------------------------------------------------------------
                    | Automatically set Manager Rating = 0
                    |--------------------------------------------------------------------------
                    */

                    setRating(0);

                }

            }

            /*
            |--------------------------------------------------------------------------
            | Decision Change
            |--------------------------------------------------------------------------
            */

            decisionSelect.addEventListener(
                'change',
                handleDecision
            );

            /*
            |--------------------------------------------------------------------------
            | Existing Rejected Record
            |--------------------------------------------------------------------------
            |
            | If this page is opened again and the goal is already rejected,
            | make sure the UI also shows 0.
            |
            */

            handleDecision();

        });

});

</script>

@endsection
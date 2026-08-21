@extends('layouts.app')

@section('content')

    <div class="container-fluid py-3">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="review-page-header mb-3">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="header-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            HR Final Review
                        </h3>

                        <p class="mb-0 text-muted">
                            Review the employee's goal assessment and provide the final HR decision.
                        </p>

                    </div>

                </div>

                <a href="{{ route('goal-hr.index') }}"
                   class="btn btn-light border shadow-sm px-3">

                    <i class="fas fa-arrow-left me-2"></i>

                    Back to Reports

                </a>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- ALERTS --}}
        {{-- ========================================================= --}}

        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm">

                <i class="fas fa-check-circle me-2"></i>

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger border-0 shadow-sm">

                <i class="fas fa-exclamation-circle me-2"></i>

                {{ session('error') }}

            </div>

        @endif

        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm">

                <strong>
                    Please correct the following:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- ========================================================= --}}
        {{-- REPORT SUMMARY --}}
        {{-- ========================================================= --}}

        <div class="report-summary-card mb-3">

            <div class="report-summary-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="employee-icon">

                        <i class="fas fa-user"></i>

                    </div>

                    <div>

                        <h5 class="mb-1 fw-bold">

                            {{ $goalSelfReport->user->name ?? 'N/A' }}

                        </h5>

                        <small>
                            Employee Goal Self Report
                        </small>

                    </div>

                </div>

                <span class="report-badge">

                    <i class="fas fa-file-alt me-1"></i>

                    Report #{{ $goalSelfReport->id }}

                </span>

            </div>

            <div class="report-summary-body">

                <div class="row g-3">

                    <div class="col-md-4">

                        <div class="summary-item">

                            <div class="summary-label">
                                <i class="fas fa-calendar-check"></i>
                                Submitted
                            </div>

                            <div class="summary-value">

                                {{ optional($goalSelfReport->submitted_at)->format('d M Y, h:i A') }}

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="summary-item">

                            <div class="summary-label">
                                <i class="fas fa-trophy"></i>
                                Achievement
                            </div>

                            <div class="summary-value">

                                {{ ucwords(str_replace('_', ' ', $goalSelfReport->achievement_status)) }}

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="summary-item">

                            <div class="summary-label">
                                <i class="fas fa-star"></i>
                                Employee Rating
                            </div>

                            <div class="summary-value rating-summary">

                                {{ $goalSelfReport->rating ?? 0 }}

                                <span>/ 5</span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- RATING SUMMARY --}}
        {{-- ========================================================= --}}

        <div class="section-heading mb-2">

            <div class="section-heading-icon">
                <i class="fas fa-chart-bar"></i>
            </div>

            <div>

                <h5 class="fw-bold mb-1">
                    Rating Summary
                </h5>

                <small class="text-muted">
                    Current assessment across the review process.
                </small>

            </div>

        </div>

        <div class="row g-3 mb-3">

            {{-- Employee --}}
            <div class="col-lg-4">

                <div class="rating-card rating-self h-100">

                    <div class="rating-card-icon">
                        <i class="fas fa-user-check"></i>
                    </div>

                    <div class="rating-card-title">
                        Employee Self Rating
                    </div>

                    <div class="rating-value">

                        {{ $goalSelfReport->rating ?? 0 }}

                        <small>/ 5</small>

                    </div>

                    <div class="rating-status">

                        <span class="status-pill status-blue">

                            {{ ucwords(str_replace('_', ' ', $goalSelfReport->achievement_status)) }}

                        </span>

                    </div>

                </div>

            </div>

            {{-- Manager --}}
            <div class="col-lg-4">

                <div class="rating-card rating-manager h-100">

                    <div class="rating-card-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>

                    <div class="rating-card-title">
                        Line Manager Rating
                    </div>

                    <div class="rating-value">

                        {{ $goalSelfReport->manager_rating ?? '-' }}

                        @if($goalSelfReport->manager_rating !== null)
                            <small>/ 5</small>
                        @endif

                    </div>

                    <div class="rating-status">

                        @if($goalSelfReport->manager_rating !== null)

                            <span class="status-pill status-success">
                                <i class="fas fa-check-circle me-1"></i>
                                Reviewed
                            </span>

                        @else

                            <span class="status-pill status-warning">
                                Pending
                            </span>

                        @endif

                    </div>

                </div>

            </div>

            {{-- HR --}}
            <div class="col-lg-4">

                <div class="rating-card rating-hr h-100">

                    <div class="rating-card-icon">
                        <i class="fas fa-building"></i>
                    </div>

                    <div class="rating-card-title">
                        HR Final Rating
                    </div>

                    <div class="rating-value">

                        {{ $goalSelfReport->hr_rating ?? '-' }}

                        @if($goalSelfReport->hr_rating !== null)
                            <small>/ 5</small>
                        @endif

                    </div>

                    <div class="rating-status">

                        @if($goalSelfReport->hr_rating !== null)

                            @if($goalSelfReport->status === 'hr_approved')

                                <span class="status-pill status-success">

                                    <i class="fas fa-check-circle me-1"></i>

                                    HR Approved

                                </span>

                            @elseif($goalSelfReport->status === 'hr_rejected')

                                <span class="status-pill status-danger">

                                    <i class="fas fa-times-circle me-1"></i>

                                    HR Rejected

                                </span>

                            @endif

                        @else

                            <span class="status-pill status-warning">

                                <i class="fas fa-clock me-1"></i>

                                Pending HR Review

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- GOAL INFORMATION --}}
        {{-- ========================================================= --}}

        <div class="section-heading mb-2">

            <div class="section-heading-icon">
                <i class="fas fa-bullseye"></i>
            </div>

            <div>

                <h5 class="fw-bold mb-1">
                    Goal Information
                </h5>

                <small class="text-muted">
                    Goal details submitted by the employee.
                </small>

            </div>

        </div>

        <div class="goal-information-card mb-3">

            <div class="goal-information-header">

                <i class="fas fa-bullseye me-2"></i>

                Goal Details

            </div>

            <div class="goal-information-body">

                <div class="info-block full-width">

                    <div class="info-label">
                        <i class="fas fa-bullseye"></i>
                        Goal
                    </div>

                    <div class="info-value large">

                        {{ $goalSelfReport->goal->goal ?? 'N/A' }}

                    </div>

                </div>

                <div class="row g-3">

                    <div class="col-lg-6">

                        <div class="info-block h-100">

                            <div class="info-label">
                                <i class="fas fa-link"></i>
                                S2R Driver / Enabler Alignment
                            </div>

                            <div class="info-value">

                                {{ $goalSelfReport->goal->s2r_driver_enabler_alignment ?: 'N/A' }}

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="info-block h-100">

                            <div class="info-label">
                                <i class="fas fa-list-check"></i>
                                Objective(s)
                            </div>

                            <div class="info-value">

                                {{ $goalSelfReport->goal->objectives ?: 'N/A' }}

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="info-block h-100">

                            <div class="info-label">
                                <i class="fas fa-flag-checkered"></i>
                                Target
                            </div>

                            <div class="info-value">

                                {{ $goalSelfReport->goal->target ?? 'N/A' }}

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="info-block h-100">

                            <div class="info-label">
                                <i class="fas fa-trophy"></i>
                                Achievement Status
                            </div>

                            <div class="info-value">

                                <span class="achievement-badge">

                                    {{ ucwords(str_replace('_', ' ', $goalSelfReport->achievement_status)) }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- PROGRESS --}}
        {{-- ========================================================= --}}

        <div class="section-heading mb-2">

            <div class="section-heading-icon">
                <i class="fas fa-chart-line"></i>
            </div>

            <div>

                <h5 class="fw-bold mb-1">
                    Progress Against Goal
                </h5>

                <small class="text-muted">
                    Employee's submitted progress.
                </small>

            </div>

        </div>

        <div class="progress-card mb-3">

            <div class="progress-card-header">

                <i class="fas fa-file-alt"></i>

                Employee Progress Statement

            </div>

            <div class="progress-card-body">

                {{ $goalSelfReport->progress_against_goal ?? 'N/A' }}

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- MANAGER REVIEW --}}
        {{-- ========================================================= --}}

        <div class="section-heading mb-2">

            <div class="section-heading-icon">
                <i class="fas fa-user-tie"></i>
            </div>

            <div>

                <h5 class="fw-bold mb-1">
                    Line Manager Review
                </h5>

                <small class="text-muted">
                    Manager's assessment and feedback.
                </small>

            </div>

        </div>

        <div class="review-card mb-3">

            @if($managerReview)

                <div class="review-row">

                    <div class="review-label">
                        Decision
                    </div>

                    <div>

                        @if($managerReview->decision === 'approved')

                            <span class="status-pill status-success">

                                <i class="fas fa-check-circle"></i>

                                Approved

                            </span>

                        @else

                            <span class="status-pill status-danger">

                                <i class="fas fa-times-circle"></i>

                                Rejected

                            </span>

                        @endif

                    </div>

                </div>

                <div class="review-row">

                    <div class="review-label">
                        Manager
                    </div>

                    <div class="review-value">

                        {{ $managerReview->reviewer->name ?? 'N/A' }}

                    </div>

                </div>

                <div class="review-row">

                    <div class="review-label">
                        Comments
                    </div>

                    <div class="review-value">

                        {{ $managerReview->comments ?: 'No comments provided.' }}

                    </div>

                </div>

            @else

                <div class="text-muted">

                    Manager review information is not available.

                </div>

            @endif

        </div>

        {{-- ========================================================= --}}
        {{-- HR DECISION --}}
        {{-- ========================================================= --}}

        <div class="section-heading mb-2">

            <div class="section-heading-icon">
                <i class="fas fa-gavel"></i>
            </div>

            <div>

                <h5 class="fw-bold mb-1">
                    HR Final Decision
                </h5>

                <small class="text-muted">
                    Provide or update the final HR assessment.
                </small>

            </div>

        </div>

        <div class="decision-card">

            <div class="decision-card-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="decision-icon">

                        <i class="fas fa-user-shield"></i>

                    </div>

                    <div>

                        <h5 class="mb-1 fw-bold">
                            HR Assessment
                        </h5>

                        <small>
                            Existing HR data will automatically appear below.
                        </small>

                    </div>

                </div>

            </div>

            <div class="decision-card-body">

                <form method="POST"
                      action="{{ route('goal-hr.review', $goalSelfReport) }}">

                    @csrf

                    {{-- Decision --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Decision

                            <span class="text-danger">*</span>

                        </label>

                        <select name="decision"
                                class="form-select form-select-lg"
                                required>

                            <option value="">
                                -- Select Decision --
                            </option>

                            <option value="approved"
                                {{ old('decision', $hrReview->decision ?? '') === 'approved' ? 'selected' : '' }}>

                                Final Approve

                            </option>

                            <option value="rejected"
                                {{ old('decision', $hrReview->decision ?? '') === 'rejected' ? 'selected' : '' }}>

                                Reject

                            </option>

                        </select>

                    </div>

                    {{-- HR Rating --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold mb-2">

                            HR Final Rating

                            <span class="text-danger">*</span>

                        </label>

                        <div class="manager-rating-options">

                            @for($i = 0; $i <= 5; $i++)

                                <label class="manager-rating-option">

                                    <input
                                        type="radio"
                                        name="hr_rating"
                                        value="{{ $i }}"
                                        required
                                        {{ (string) old('hr_rating', $goalSelfReport->hr_rating) === (string) $i ? 'checked' : '' }}
                                    >

                                    <div class="manager-rating-content">

                                        <span class="rating-number">
                                            {{ $i }}
                                        </span>

                                        <span class="rating-star">

                                            <i class="fas fa-star"></i>

                                        </span>

                                    </div>

                                </label>

                            @endfor

                        </div>

                        <div class="rating-help">

                            <i class="fas fa-info-circle me-1"></i>

                            Rate the employee's achievement from 0 to 5.

                        </div>

                        <div id="selectedRating"
                             class="selected-rating-message">

                            @if($goalSelfReport->hr_rating !== null)

                                <i class="fas fa-star me-1"></i>

                                Existing HR Rating:
                                {{ $goalSelfReport->hr_rating }} / 5

                            @else

                                Select a rating

                            @endif

                        </div>

                    </div>

                    {{-- Comments --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            HR Comments

                        </label>

                        <textarea
                            name="comments"
                            class="form-control comments-input"
                            rows="4"
                            placeholder="Provide final HR feedback, observations or recommendations..."
                        >{{ old('comments', $hrReview->comments ?? '') }}</textarea>

                    </div>

                    {{-- Actions --}}
                    <div class="decision-actions">

                        <a href="{{ route('goal-hr.index') }}"
                           class="btn btn-light border px-4">

                            <i class="fas fa-arrow-left me-2"></i>

                            Back

                        </a>

                        <button type="submit"
                                class="btn btn-primary px-4 shadow-sm">

                            @if($goalSelfReport->hr_rating !== null)

                                <i class="fas fa-save me-2"></i>

                                Update HR Decision

                            @else

                                <i class="fas fa-paper-plane me-2"></i>

                                Submit Final Decision

                            @endif

                        </button>

                    </div>

                </form>

            </div>

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

    .review-page-header {

        background: linear-gradient(
            135deg,
            #ffffff,
            #f5f8fc
        );

        border: 1px solid var(--pms-border);

        border-radius: 12px;

        padding: 15px 20px;

        box-shadow:
            0 3px 12px rgba(31,78,121,.05);

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

    .report-summary-card,
    .goal-information-card,
    .progress-card,
    .review-card,
    .decision-card {

        background: #fff;

        border: 1px solid var(--pms-border);

        border-radius: 12px;

        overflow: hidden;

        box-shadow:
            0 3px 14px rgba(31,78,121,.05);

    }

    .report-summary-header {

        background: linear-gradient(
            135deg,
            var(--pms-primary),
            var(--pms-primary-dark)
        );

        color: #fff;

        padding: 14px 18px;

        display: flex;

        justify-content: space-between;

        align-items: center;

    }

    .employee-icon {

        width: 38px;
        height: 38px;

        border-radius: 9px;

        background: rgba(255,255,255,.14);

        display: flex;

        align-items: center;

        justify-content: center;

    }

    .report-badge {

        padding: 6px 11px;

        border-radius: 20px;

        background: rgba(255,255,255,.12);

        border: 1px solid rgba(255,255,255,.2);

        font-size: 11px;

    }

    .report-summary-body {

        padding: 14px 18px;

    }

    .summary-item {

        background: #f8fafc;

        border: 1px solid #e7edf4;

        border-radius: 9px;

        padding: 11px 13px;

    }

    .summary-label {

        color: var(--pms-muted);

        font-size: 10px;

        font-weight: 700;

        text-transform: uppercase;

        margin-bottom: 4px;

    }

    .summary-value {

        color: var(--pms-text);

        font-size: 13px;

        font-weight: 600;

    }

    .rating-summary {

        color: var(--pms-primary);

        font-size: 17px;

        font-weight: 800;

    }

    .rating-summary span {

        color: var(--pms-muted);

        font-size: 11px;

    }

    .section-heading {

        display: flex;

        align-items: center;

        gap: 9px;

    }

    .section-heading-icon {

        width: 32px;
        height: 32px;

        border-radius: 8px;

        background: #e8f1fa;

        color: var(--pms-primary);

        display: flex;

        align-items: center;

        justify-content: center;

    }

    .section-heading h5 {

        font-size: 15px;

    }

    /* RATING */

    .rating-card {

        position: relative;

        background: #fff;

        border: 1px solid var(--pms-border);

        border-radius: 12px;

        padding: 15px;

        text-align: center;

        box-shadow:
            0 3px 12px rgba(31,78,121,.04);

    }

    .rating-card::before {

        content: "";

        position: absolute;

        top: 0;
        left: 0;
        right: 0;

        height: 3px;

        background: var(--pms-primary);

    }

    .rating-manager::before {
        background: #b77900;
    }

    .rating-hr::before {
        background: #198754;
    }

    .rating-card-icon {

        width: 34px;
        height: 34px;

        border-radius: 8px;

        background: #f2f7fc;

        color: var(--pms-primary);

        display: flex;

        align-items: center;

        justify-content: center;

        margin: auto auto 7px;

    }

    .rating-manager .rating-card-icon {

        background: #fff5dc;

        color: #b77900;

    }

    .rating-hr .rating-card-icon {

        background: #e7f6ed;

        color: #198754;

    }

    .rating-card-title {

        color: var(--pms-muted);

        font-size: 11px;

        font-weight: 700;

        margin-bottom: 5px;

    }

    .rating-value {

        color: var(--pms-primary);

        font-size: 28px;

        font-weight: 800;

    }

    .rating-manager .rating-value {
        color: #b77900;
    }

    .rating-hr .rating-value {
        color: #198754;
    }

    .rating-value small {

        color: var(--pms-muted);

        font-size: 11px;

    }

    .rating-status {

        margin-top: 8px;

    }

    /* STATUS */

    .status-pill {

        display: inline-flex;

        align-items: center;

        border-radius: 20px;

        padding: 4px 8px;

        font-size: 10px;

        font-weight: 700;

    }

    .status-success {

        color: #198754;

        background: #e7f6ed;

    }

    .status-warning {

        color: #b77900;

        background: #fff5dc;

    }

    .status-danger {

        color: #dc3545;

        background: #fdecec;

    }

    .status-blue {

        color: var(--pms-primary);

        background: #e8f1fa;

    }

    /* GOAL */

    .goal-information-header {

        background: linear-gradient(
            135deg,
            var(--pms-primary),
            var(--pms-primary-dark)
        );

        color: #fff;

        padding: 12px 18px;

        font-weight: 700;

        font-size: 13px;

    }

    .goal-information-body {

        padding: 16px;

    }

    .info-block {

        background: #f8fafc;

        border: 1px solid #e7edf4;

        border-radius: 9px;

        padding: 12px 14px;

    }

    .full-width {

        margin-bottom: 12px;

    }

    .info-label {

        color: var(--pms-muted);

        font-size: 9px;

        font-weight: 700;

        text-transform: uppercase;

        margin-bottom: 5px;

    }

    .info-label i {

        color: var(--pms-primary);

        margin-right: 4px;

    }

    .info-value {

        color: var(--pms-text);

        font-size: 12px;

        line-height: 1.5;

    }

    .info-value.large {

        font-size: 14px;

        font-weight: 700;

    }

    .achievement-badge {

        display: inline-block;

        background: #e8f1fa;

        color: var(--pms-primary);

        border-radius: 6px;

        padding: 5px 9px;

        font-size: 10px;

        font-weight: 700;

    }

    /* PROGRESS */

    .progress-card-header {

        background: #f8fafc;

        border-bottom: 1px solid var(--pms-border);

        padding: 10px 15px;

        color: var(--pms-primary);

        font-weight: 700;

        font-size: 11px;

    }

    .progress-card-body {

        padding: 14px 16px;

        color: var(--pms-text);

        font-size: 12px;

        line-height: 1.6;

        white-space: pre-line;

    }

    /* MANAGER REVIEW */

    .review-card {

        padding: 0;

    }

    .review-row {

        display: flex;

        align-items: flex-start;

        gap: 20px;

        padding: 12px 16px;

        border-bottom: 1px solid var(--pms-border);

    }

    .review-row:last-child {

        border-bottom: none;

    }

    .review-label {

        width: 110px;

        color: var(--pms-muted);

        font-size: 11px;

        font-weight: 700;

    }

    .review-value {

        color: var(--pms-text);

        font-size: 12px;

    }

    /* DECISION */

    .decision-card-header {

        padding: 14px 18px;

        border-bottom: 1px solid var(--pms-border);

        background: linear-gradient(
            135deg,
            #f5f8fc,
            #ffffff
        );

    }

    .decision-icon {

        width: 36px;
        height: 36px;

        border-radius: 9px;

        background: #e8f1fa;

        color: var(--pms-primary);

        display: flex;

        align-items: center;

        justify-content: center;

    }

    .decision-card-body {

        padding: 18px;

    }

    .form-label {

        color: var(--pms-text);

        font-size: 12px;

    }

    .form-control,
    .form-select {

        border-color: #dbe2ea;

        border-radius: 8px;

        font-size: 13px;

    }

    .comments-input {

        resize: vertical;

    }

    /* RATING OPTIONS */

    .manager-rating-options {

        display: flex;

        gap: 8px;

        flex-wrap: wrap;

    }

    .manager-rating-option {

        cursor: pointer;

    }

    .manager-rating-option input {

        display: none;

    }

    .manager-rating-content {

        width: 52px;
        height: 52px;

        border: 1px solid #dbe2ea;

        border-radius: 9px;

        background: #fff;

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;

        transition: .2s;

    }

    .manager-rating-content:hover {

        border-color: var(--pms-primary);

        transform: translateY(-1px);

    }

    .manager-rating-option input:checked + .manager-rating-content {

        background: var(--pms-primary);

        border-color: var(--pms-primary);

        color: #fff;

        transform: translateY(-2px);

        box-shadow:
            0 5px 14px rgba(31,78,121,.18);

    }

    .rating-number {

        font-size: 16px;

        font-weight: 800;

    }

    .rating-star {

        font-size: 8px;

        margin-top: 4px;

    }

    .rating-help {

        color: var(--pms-muted);

        font-size: 10px;

        margin-top: 7px;

    }

    .selected-rating-message {

        display: inline-block;

        margin-top: 7px;

        padding: 5px 9px;

        background: #f2f7fc;

        color: var(--pms-primary);

        border-radius: 6px;

        font-size: 10px;

        font-weight: 700;

    }

    /* ACTIONS */

    .decision-actions {

        display: flex;

        justify-content: flex-end;

        gap: 8px;

        padding-top: 15px;

        border-top: 1px solid var(--pms-border);

    }

    .btn-primary {

        background: var(--pms-primary);

        border-color: var(--pms-primary);

    }

    .btn-primary:hover {

        background: var(--pms-primary-dark);

        border-color: var(--pms-primary-dark);

    }

    @media(max-width:768px) {

        .report-summary-header {

            flex-direction: column;

            align-items: flex-start;

        }

        .review-row {

            flex-direction: column;

            gap: 5px;

        }

        .review-label {

            width: auto;

        }

        .decision-actions {

            flex-direction: column-reverse;

        }

        .decision-actions .btn {

            width: 100%;

        }

    }

    </style>

    {{-- ========================================================= --}}
    {{-- SCRIPT --}}
    {{-- ========================================================= --}}

    <script>

    document.addEventListener('DOMContentLoaded', function () {

        const ratingInputs = document.querySelectorAll(
            'input[name="hr_rating"]'
        );

        const selectedRating =
            document.getElementById('selectedRating');

        ratingInputs.forEach(function (input) {

            input.addEventListener('change', function () {

                selectedRating.innerHTML =
                    '<i class="fas fa-star me-1"></i>' +
                    'Selected HR Rating: ' +
                    this.value +
                    ' / 5';

            });

        });

    });

    </script>

@endsection
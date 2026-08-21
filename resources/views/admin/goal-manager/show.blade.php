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
                            Line Manager Review
                        </h3>

                        <p class="mb-0 text-muted">
                            Review the employee's progress and provide your assessment against the goal.
                        </p>

                    </div>

                </div>

                <a href="{{ route('goal-manager.index') }}" class="btn btn-light border shadow-sm px-3">

                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Reports

                </a>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- SUCCESS / ERROR ALERTS --}}
        {{-- ========================================================= --}}

        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-3">

                <i class="fas fa-check-circle fs-5 me-3"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-3">

                <i class="fas fa-exclamation-circle fs-5 me-3"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif

        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm mb-3">

                <div class="d-flex align-items-center mb-2">

                    <i class="fas fa-exclamation-triangle me-2"></i>

                    <strong>
                        Please correct the following errors:
                    </strong>

                </div>

                <ul class="mb-0 ps-4">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- ========================================================= --}}
        {{-- EMPLOYEE / REPORT SUMMARY --}}
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

                <div>

                    <span class="report-badge">

                        <i class="fas fa-file-alt me-1"></i>

                        Report #{{ $goalSelfReport->id }}

                    </span>

                </div>

            </div>

            <div class="report-summary-body">

                <div class="row g-3">

                    {{-- Submitted --}}
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

                    {{-- Achievement --}}
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

                    {{-- Employee Rating --}}
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
                    Current assessment status across the review process.
                </small>

            </div>

        </div>

        <div class="row g-3 mb-3">

            {{-- Employee Self Rating --}}
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

                            <i class="fas fa-circle me-1"></i>

                            {{ ucwords(str_replace('_', ' ', $goalSelfReport->achievement_status)) }}

                        </span>

                    </div>

                </div>

            </div>

            {{-- Manager Rating --}}
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

                                <i class="fas fa-clock me-1"></i>

                                Pending Review

                            </span>

                        @endif

                    </div>

                </div>

            </div>

            {{-- HR Rating --}}
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

                            <span class="status-pill status-success">

                                <i class="fas fa-check-circle me-1"></i>

                                Finalized

                            </span>

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
                    Review the goal details submitted by the employee.
                </small>

            </div>

        </div>

        <div class="goal-information-card mb-3">

            <div class="goal-information-header">

                <div class="d-flex align-items-center gap-2">

                    <i class="fas fa-bullseye"></i>

                    <h5 class="mb-0 fw-bold">
                        Goal
                    </h5>

                </div>

            </div>

            <div class="goal-information-body">

                {{-- Goal --}}
                <div class="info-block full-width">

                    <div class="info-label">

                        <i class="fas fa-bullseye"></i>

                        Goal

                    </div>

                    <div class="info-value large">

                        {{ $goalSelfReport->goal->goal }}

                    </div>

                </div>

                <div class="row g-3">

                    {{-- S2R --}}
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

                    {{-- Objective --}}
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

                    {{-- Target --}}
                    <div class="col-lg-6">

                        <div class="info-block h-100">

                            <div class="info-label">

                                <i class="fas fa-flag-checkered"></i>

                                Target

                            </div>

                            <div class="info-value">

                                {{ $goalSelfReport->goal->target }}

                            </div>

                        </div>

                    </div>

                    {{-- Achievement --}}
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
                    Employee's submitted progress and achievements.
                </small>

            </div>

        </div>

        <div class="progress-card mb-3">

            <div class="progress-card-header">

                <i class="fas fa-file-alt"></i>

                Employee Progress Statement

            </div>

            <div class="progress-card-body">

                {{ $goalSelfReport->progress_against_goal }}

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- MANAGER DECISION --}}
        {{-- ========================================================= --}}

        <div class="section-heading mb-2">

            <div class="section-heading-icon">

                <i class="fas fa-gavel"></i>

            </div>

            <div>

                <h5 class="fw-bold mb-1">
                    Manager Decision
                </h5>

                <small class="text-muted">
                    Provide your decision, rating and feedback.
                </small>

            </div>

        </div>

        <div class="decision-card">

            <div class="decision-card-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="decision-icon">

                        <i class="fas fa-user-tie"></i>

                    </div>

                    <div>

                        <h5 class="mb-1 fw-bold">
                            Line Manager Assessment
                        </h5>

                        <small>
                            Evaluate the employee's achievement against the submitted goal.
                        </small>

                    </div>

                </div>

            </div>

            <div class="decision-card-body">

                <form method="POST" action="{{ route('goal-manager.review', $goalSelfReport) }}">

                    @csrf

                    {{-- Decision --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Decision

                            <span class="text-danger">*</span>

                        </label>

                        <select name="decision" class="form-select form-select-lg" required>

                            <option value="">
                                -- Select Decision --
                            </option>

                            <option value="approved">
                                Approve
                            </option>

                            <option value="rejected">
                                Reject
                            </option>

                        </select>

                    </div>

                    {{-- Manager Rating --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold mb-2">

                            Manager Rating

                            <span class="text-danger">*</span>

                        </label>

                        <div class="manager-rating-options">

                            @for($i = 0; $i <= 5; $i++)

                                <label class="manager-rating-option">

                                    <input type="radio" name="manager_rating" value="{{ $i }}" required>

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

                            Rate the employee's achievement against the submitted goal from 0 to 5.

                        </div>

                        <div id="selectedRating" class="selected-rating-message">

                            Select a rating

                        </div>

                    </div>

                    {{-- Comments --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Comments

                        </label>

                        <textarea name="comments" class="form-control comments-input" rows="4"
                            placeholder="Provide constructive feedback, observations or recommendations..."></textarea>

                    </div>

                    {{-- Actions --}}
                    <div class="decision-actions">

                        <a href="{{ route('goal-manager.index') }}" class="btn btn-light border px-4">

                            <i class="fas fa-times me-2"></i>

                            Cancel

                        </a>

                        <button type="submit" class="btn btn-primary px-4 shadow-sm">

                            <i class="fas fa-paper-plane me-2"></i>

                            Submit Decision

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

        /* =========================================================
                   PAGE HEADER
                ========================================================= */

        .review-page-header {

            background: linear-gradient(135deg,
                    #ffffff 0%,
                    #f5f8fc 100%);

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            padding: 15px 20px;

            box-shadow:
                0 3px 12px rgba(31, 78, 121, 0.05);

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

            font-size: 17px;

            box-shadow:
                0 4px 10px rgba(31, 78, 121, 0.18);

        }

        /* =========================================================
                   REPORT SUMMARY
                ========================================================= */

        .report-summary-card {

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 3px 14px rgba(31, 78, 121, .05);

        }

        .report-summary-header {

            background: linear-gradient(135deg,
                    var(--pms-primary),
                    var(--pms-primary-dark));

            color: #fff;

            padding: 14px 18px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;

        }

        .employee-icon {

            width: 38px;
            height: 38px;

            border-radius: 9px;

            background: rgba(255, 255, 255, .14);

            border: 1px solid rgba(255, 255, 255, .20);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 15px;

        }

        .report-summary-header h5 {

            font-size: 15px;

        }

        .report-summary-header small {

            opacity: .78;

            font-size: 11px;

        }

        .report-badge {

            display: inline-flex;

            align-items: center;

            background: rgba(255, 255, 255, .12);

            border: 1px solid rgba(255, 255, 255, .20);

            border-radius: 20px;

            padding: 6px 11px;

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

            height: 100%;

        }

        .summary-label {

            color: var(--pms-muted);

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .35px;

            margin-bottom: 4px;

        }

        .summary-label i {

            color: var(--pms-primary);

            margin-right: 4px;

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

        /* =========================================================
                   SECTION HEADING
                ========================================================= */

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

            font-size: 13px;

        }

        .section-heading h5 {

            font-size: 15px;

        }

        .section-heading small {

            font-size: 11px;

        }

        /* =========================================================
                   RATING CARDS
                ========================================================= */

        .rating-card {

            position: relative;

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            padding: 15px 16px;

            text-align: center;

            transition: all .2s ease;

            overflow: hidden;

            box-shadow:
                0 3px 12px rgba(31, 78, 121, .04);

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

        .rating-card:hover {

            transform: translateY(-2px);

            box-shadow:
                0 7px 18px rgba(31, 78, 121, .08);

        }

        .rating-self::before {

            background: #1f4e79;

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

            margin: 0 auto 7px;

            font-size: 13px;

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

            line-height: 1;

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

            font-weight: 600;

        }

        .rating-status {

            margin-top: 8px;

        }

        .status-pill {

            display: inline-flex;

            align-items: center;

            border-radius: 20px;

            padding: 4px 8px;

            font-size: 10px;

            font-weight: 700;

        }

        .status-blue {

            color: var(--pms-primary);

            background: #e8f1fa;

        }

        .status-success {

            color: #198754;

            background: #e7f6ed;

        }

        .status-warning {

            color: #b77900;

            background: #fff5dc;

        }

        /* =========================================================
                   GOAL INFORMATION
                ========================================================= */

        .goal-information-card {

            background: #fff;

            border: 1px solid #d9e3ee;

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 4px 16px rgba(31, 78, 121, .05);

        }

        .goal-information-header {

            background: linear-gradient(135deg,
                    var(--pms-primary),
                    var(--pms-primary-dark));

            color: #fff;

            padding: 12px 18px;

        }

        .goal-information-header h5 {

            font-size: 14px;

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

            letter-spacing: .35px;

            margin-bottom: 5px;

        }

        .info-label i {

            color: var(--pms-primary);

            width: 16px;

        }

        .info-value {

            color: var(--pms-text);

            font-size: 12px;

            font-weight: 500;

            line-height: 1.5;

            white-space: pre-line;

        }

        .info-value.large {

            font-size: 14px;

            font-weight: 700;

            line-height: 1.5;

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

        /* =========================================================
                   PROGRESS
                ========================================================= */

        .progress-card {

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 3px 14px rgba(31, 78, 121, .04);

        }

        .progress-card-header {

            background: #f8fafc;

            border-bottom: 1px solid var(--pms-border);

            padding: 10px 15px;

            color: var(--pms-primary);

            font-weight: 700;

            font-size: 11px;

        }

        .progress-card-header i {

            margin-right: 6px;

        }

        .progress-card-body {

            padding: 14px 16px;

            color: var(--pms-text);

            font-size: 12px;

            line-height: 1.6;

            white-space: pre-line;

        }

        /* =========================================================
                   DECISION CARD
                ========================================================= */

        .decision-card {

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 4px 16px rgba(31, 78, 121, .05);

        }

        .decision-card-header {

            background: linear-gradient(135deg,
                    #f5f8fc,
                    #ffffff);

            border-bottom: 1px solid var(--pms-border);

            padding: 14px 18px;

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

            font-size: 14px;

        }

        .decision-card-header h5 {

            font-size: 14px;

        }

        .decision-card-header small {

            color: var(--pms-muted);

            font-size: 10px;

        }

        .decision-card-body {

            padding: 18px;

        }

        /* =========================================================
                   FORM
                ========================================================= */

        .form-label {

            color: var(--pms-text);

            font-size: 12px;

            margin-bottom: 6px;

        }

        .form-control,
        .form-select {

            border-color: #dbe2ea;

            border-radius: 8px;

            padding: 9px 12px;

            color: var(--pms-text);

            font-size: 13px;

        }

        .form-select-lg {

            font-size: 13px;

            padding: 10px 12px;

        }

        .form-control:focus,
        .form-select:focus {

            border-color: var(--pms-primary);

            box-shadow:
                0 0 0 .15rem rgba(31, 78, 121, .10);

        }

        .comments-input {

            resize: vertical;

            min-height: 105px;

        }

        /* =========================================================
                   MANAGER RATING
                ========================================================= */

        .manager-rating-options {

            display: flex;

            gap: 8px;

            flex-wrap: wrap;

            margin-top: 6px;

        }

        .manager-rating-option {

            cursor: pointer;

            margin: 0;

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

            transition: all .2s ease;

        }

        .manager-rating-content:hover {

            border-color: var(--pms-primary);

            background: #f8fafc;

            transform: translateY(-1px);

        }

        .manager-rating-option input:checked+.manager-rating-content {

            background: var(--pms-primary);

            border-color: var(--pms-primary);

            color: #fff;

            transform: translateY(-2px);

            box-shadow:
                0 5px 14px rgba(31, 78, 121, .18);

        }

        .rating-number {

            font-size: 16px;

            font-weight: 800;

            line-height: 1;

        }

        .rating-star {

            font-size: 8px;

            margin-top: 4px;

            opacity: .75;

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

        /* =========================================================
                   ACTIONS
                ========================================================= */

        .decision-actions {

            display: flex;

            justify-content: flex-end;

            gap: 8px;

            padding-top: 15px;

            border-top: 1px solid var(--pms-border);

        }

        .decision-actions .btn {

            font-size: 12px;

            padding: 8px 16px;

            border-radius: 7px;

        }

        .btn-primary {

            background-color: var(--pms-primary);

            border-color: var(--pms-primary);

        }

        .btn-primary:hover {

            background-color: var(--pms-primary-dark);

            border-color: var(--pms-primary-dark);

        }

        /* =========================================================
                   ALERTS
                ========================================================= */

        .alert {

            font-size: 12px;

        }

        /* =========================================================
                   RESPONSIVE
                ========================================================= */

        @media (max-width: 768px) {

            .container-fluid {

                padding-left: 12px;

                padding-right: 12px;

            }

            .review-page-header {

                padding: 14px;

            }

            .review-page-header h3 {

                font-size: 18px;

            }

            .report-summary-header {

                align-items: flex-start;

                flex-direction: column;

            }

            .report-summary-body,
            .goal-information-body,
            .decision-card-body {

                padding: 14px;

            }

            .rating-card {

                padding: 14px;

            }

            .manager-rating-content {

                width: 48px;

                height: 48px;

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
    {{-- RATING SELECTION SCRIPT --}}
    {{-- ========================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const ratingInputs =
                document.querySelectorAll(
                    'input[name="manager_rating"]'
                );

            const selectedRating =
                document.getElementById('selectedRating');

            ratingInputs.forEach(function (input) {

                input.addEventListener('change', function () {

                    const rating = this.value;

                    selectedRating.innerHTML =
                        '<i class="fas fa-star me-1"></i>' +
                        'Selected Rating: ' +
                        rating +
                        ' / 5';

                });

            });

        });

    </script>

@endsection
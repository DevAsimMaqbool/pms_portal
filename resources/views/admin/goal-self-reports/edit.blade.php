@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4">

        {{-- ========================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================================================= --}}

        <div class="goal-page-header mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="header-icon">
                        <i class="fas fa-edit"></i>
                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            Edit Self Report
                        </h3>

                        <p class="mb-0 text-muted">
                            Update your progress and achievement status against this goal.
                        </p>

                    </div>

                </div>

                <a href="{{ route('goal-self-reports.index') }}"
                    class="btn btn-light border shadow-sm px-4">

                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Reports

                </a>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- ALERTS --}}
        {{-- ========================================================= --}}

        @if(session('error'))

            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4">

                <i class="fas fa-exclamation-circle fs-5 me-3"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif

        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4">

                <i class="fas fa-check-circle fs-5 me-3"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif

        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm mb-4">

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
{{-- MANAGER REJECTION REMARKS --}}
{{-- ========================================================= --}}

@php
    $managerRejection = $goalSelfReport->reviews
        ->where('reviewer_type', 'manager')
        ->where('decision', 'rejected')
        ->sortByDesc('id')
        ->first();
@endphp

@if(
    $goalSelfReport->status === 'manager_rejected' &&
    $managerRejection &&
    !empty($managerRejection->comments)
)

    <div class="rejection-card mb-4">

        <div class="rejection-header">

            <div class="d-flex align-items-center gap-3">

                <div class="rejection-icon">

                    <i class="fas fa-exclamation-triangle"></i>

                </div>

                <div>

                    <h5 class="mb-1 fw-bold">
                        Self Report Rejected
                    </h5>

                    <small>
                        Please review the remarks from your Line Manager and update your report accordingly.
                    </small>

                </div>

            </div>

            <span class="rejection-badge">
                <i class="fas fa-times-circle me-1"></i>
                Rejected
            </span>

        </div>

        <div class="rejection-body">

            <div class="remark-label">

                <i class="fas fa-comment-dots me-2"></i>

                Manager Remarks

            </div>

            <div class="remark-content">

                {{ $managerRejection->comments }}

            </div>

        </div>

    </div>

@endif

        {{-- ========================================================= --}}
        {{-- EDIT FORM --}}
        {{-- ========================================================= --}}

        <form method="POST"
            action="{{ route('goal-self-reports.update', $goalSelfReport) }}">

            @csrf
            @method('PUT')

            {{-- ========================================================= --}}
            {{-- STEP 1 : SELECTED GOAL --}}
            {{-- ========================================================= --}}

            <div class="section-card mb-4">

                <div class="section-header">

                    <div class="section-title">

                        <div class="section-number">
                            1
                        </div>

                        <div>

                            <h5 class="mb-1 fw-bold">
                                Selected Goal
                            </h5>

                            <small>
                                This goal cannot be changed while editing the self report.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="section-body">

                    <label class="form-label fw-semibold">
                        Goal
                    </label>

                    <div class="selected-goal-box">

                        <div class="selected-goal-icon">

                            <i class="fas fa-bullseye"></i>

                        </div>

                        <div class="selected-goal-content">

                            <div class="selected-goal-title">
                                {{ $goalSelfReport->goal->goal ?? 'N/A' }}
                            </div>

                            <div class="selected-goal-meta">

                                <span>
                                    <i class="fas fa-link me-1"></i>

                                    {{ $goalSelfReport->goal->s2rDriver->driver_name
                                        ?? $goalSelfReport->goal->s2r_driver_enabler_alignment
                                        ?? 'N/A' }}
                                </span>

                                <span>
                                    <i class="far fa-calendar-alt me-1"></i>

                                    {{ optional($goalSelfReport->goal->deadline)->format('d M Y') ?? 'N/A' }}
                                </span>

                            </div>

                        </div>

                        <div class="locked-badge">

                            <i class="fas fa-lock me-1"></i>
                            Locked

                        </div>

                    </div>

                    <input type="hidden"
                        name="new_goal_id"
                        value="{{ $goalSelfReport->new_goal_id }}">

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- GOAL INFORMATION --}}
            {{-- ========================================================= --}}

            <div class="goal-summary-card mb-4">

                <div class="goal-summary-header">

                    <div>

                        <div class="d-flex align-items-center gap-2">

                            <i class="fas fa-bullseye"></i>

                            <h5 class="mb-0 fw-bold">
                                Goal Information
                            </h5>

                        </div>

                        <small>
                            Review the goal information before updating your progress.
                        </small>

                    </div>

                    <span class="goal-info-badge">

                        <i class="fas fa-info-circle me-1"></i>

                        Goal Information

                    </span>

                </div>

                <div class="goal-summary-body">

                    {{-- GOAL --}}

                    <div class="info-block full-width">

                        <div class="info-label">

                            <i class="fas fa-bullseye"></i>

                            Goal

                        </div>

                        <div class="info-value large">

                            {{ $goalSelfReport->goal->goal ?? 'N/A' }}

                        </div>

                    </div>

                    <div class="row g-4">

                        {{-- S2R --}}

                        <div class="col-lg-6">

                            <div class="info-block h-100">

                                <div class="info-label">

                                    <i class="fas fa-link"></i>

                                    S2R Driver / Enabler

                                </div>

                                <div class="info-value">

                                    {{ $goalSelfReport->goal->s2rDriver->driver_name
                                        ?? $goalSelfReport->goal->s2r_driver_enabler_alignment
                                        ?? 'N/A' }}

                                </div>

                            </div>

                        </div>

                        {{-- DEADLINE --}}

                        <div class="col-lg-6">

                            <div class="info-block h-100">

                                <div class="info-label">

                                    <i class="far fa-calendar-alt"></i>

                                    Deadline

                                </div>

                                <div class="info-value deadline-value">

                                    {{ optional($goalSelfReport->goal->deadline)->format('d M Y') ?? 'N/A' }}

                                </div>

                            </div>

                        </div>

                        {{-- OBJECTIVES --}}

                        <div class="col-lg-6">

                            <div class="info-block h-100">

                                <div class="info-label">

                                    <i class="fas fa-list-check"></i>

                                    Objective(s)

                                </div>

                                <div class="info-value">

                                    {{ $goalSelfReport->goal->objectives ?? 'N/A' }}

                                </div>

                            </div>

                        </div>

                        {{-- TARGET --}}

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

                    </div>

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- STEP 2 : PROGRESS --}}
            {{-- ========================================================= --}}

            <div class="section-card mb-4">

                <div class="section-header">

                    <div class="section-title">

                        <div class="section-number">
                            2
                        </div>

                        <div>

                            <h5 class="mb-1 fw-bold">
                                Progress Against Goal
                            </h5>

                            <small>
                                Update your progress, achievements and current position.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="section-body">

                    <label class="form-label fw-semibold">

                        Progress against this goal

                        <span class="text-danger">*</span>

                    </label>

                    <textarea name="progress_against_goal"
                        class="form-control progress-input @error('progress_against_goal') is-invalid @enderror"
                        rows="7"
                        maxlength="10000"
                        placeholder="Describe your progress, achievements, completed activities, challenges and current position against the target..."
                        required>{{ old('progress_against_goal', $goalSelfReport->progress_against_goal) }}</textarea>

                    <div class="d-flex justify-content-between mt-2">

                        @error('progress_against_goal')

                            <div class="text-danger small">
                                {{ $message }}
                            </div>

                        @else

                            <small class="text-muted">
                                Please provide meaningful details about your progress.
                            </small>

                        @enderror

                        <small class="text-muted">

                            Maximum 10,000 characters

                        </small>

                    </div>

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- STEP 3 : ACHIEVEMENT STATUS --}}
            {{-- ========================================================= --}}

            <div class="section-card mb-4">

                <div class="section-header">

                    <div class="section-title">

                        <div class="section-number">
                            3
                        </div>

                        <div>

                            <h5 class="mb-1 fw-bold">
                                Achievement Assessment
                            </h5>

                            <small>
                                Update the current achievement status of this goal.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="section-body">

                    <label class="form-label fw-semibold mb-3">

                        Achievement Status

                        <span class="text-danger">*</span>

                    </label>

                    <div class="status-options">

                        {{-- NOT STARTED --}}

                        <label class="status-option">

                            <input type="radio"
                                name="achievement_status"
                                value="not_started"
                                {{ old(
                                    'achievement_status',
                                    $goalSelfReport->achievement_status
                                ) === 'not_started' ? 'checked' : '' }}>

                            <div class="status-content">

                                <div class="status-icon status-gray">

                                    <i class="fas fa-circle"></i>

                                </div>

                                <div>

                                    <strong>
                                        Not Started
                                    </strong>

                                    <small>
                                        Work has not started
                                    </small>

                                </div>

                                <span class="status-rating">
                                    0 / 5
                                </span>

                            </div>

                        </label>

                        {{-- IN PROGRESS --}}

                        <label class="status-option">

                            <input type="radio"
                                name="achievement_status"
                                value="in_progress"
                                {{ old(
                                    'achievement_status',
                                    $goalSelfReport->achievement_status
                                ) === 'in_progress' ? 'checked' : '' }}>

                            <div class="status-content">

                                <div class="status-icon status-blue">

                                    <i class="fas fa-spinner"></i>

                                </div>

                                <div>

                                    <strong>
                                        In Progress
                                    </strong>

                                    <small>
                                        Work is currently ongoing
                                    </small>

                                </div>

                                <span class="status-rating">
                                    1 / 5
                                </span>

                            </div>

                        </label>

                        {{-- PARTIALLY COMPLETE --}}

                        <label class="status-option">

                            <input type="radio"
                                name="achievement_status"
                                value="partially_complete"
                                {{ old(
                                    'achievement_status',
                                    $goalSelfReport->achievement_status
                                ) === 'partially_complete' ? 'checked' : '' }}>

                            <div class="status-content">

                                <div class="status-icon status-warning">

                                    <i class="fas fa-chart-pie"></i>

                                </div>

                                <div>

                                    <strong>
                                        Partially Complete
                                    </strong>

                                    <small>
                                        Significant progress achieved
                                    </small>

                                </div>

                                <span class="status-rating">
                                    3 / 5
                                </span>

                            </div>

                        </label>

                        {{-- COMPLETED --}}

                        <label class="status-option">

                            <input type="radio"
                                name="achievement_status"
                                value="completed"
                                {{ old(
                                    'achievement_status',
                                    $goalSelfReport->achievement_status
                                ) === 'completed' ? 'checked' : '' }}>

                            <div class="status-content">

                                <div class="status-icon status-success">

                                    <i class="fas fa-check"></i>

                                </div>

                                <div>

                                    <strong>
                                        Completed
                                    </strong>

                                    <small>
                                        Goal has been fully achieved
                                    </small>

                                </div>

                                <span class="status-rating">
                                    5 / 5
                                </span>

                            </div>

                        </label>

                    </div>

                    @error('achievement_status')

                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- SELF RATING --}}
            {{-- ========================================================= --}}

            <div class="rating-card mb-4">

                <div class="rating-left">

                    <div class="rating-icon">

                        <i class="fas fa-star"></i>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Self Rating
                        </h5>

                        <p class="mb-0">

                            Your rating is automatically calculated based on the selected Achievement Status.

                        </p>

                    </div>

                </div>

                <div class="rating-result">

                    <div class="rating-value-wrapper">

                        <span id="rating_display">
                            {{ $goalSelfReport->rating ?? 0 }}
                        </span>

                        <small>
                            / 5
                        </small>

                    </div>

                    <div id="rating_status_text"
                        class="rating-status-text">

                        {{ ucwords(str_replace(
                            '_',
                            ' ',
                            $goalSelfReport->achievement_status
                        )) }}

                    </div>

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- ACTIONS --}}
            {{-- ========================================================= --}}

            <div class="form-actions">

                <a href="{{ route('goal-self-reports.index') }}"
                    class="btn btn-light border px-4">

                    <i class="fas fa-times me-2"></i>

                    Cancel

                </a>

                <button type="submit"
                    class="btn btn-primary px-4 shadow-sm">

                    <i class="fas fa-save me-2"></i>

                    Update Self Report

                </button>

            </div>

        </form>

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

        .goal-page-header {
            background: linear-gradient(
                135deg,
                #ffffff 0%,
                #f5f8fc 100%
            );

            border: 1px solid var(--pms-border);
            border-radius: 16px;

            padding: 22px 26px;

            box-shadow:
                0 4px 18px rgba(31, 78, 121, 0.06);
        }

        .header-icon {
            width: 48px;
            height: 48px;

            border-radius: 12px;

            background: var(--pms-primary);
            color: #fff;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;

            box-shadow:
                0 6px 14px rgba(31, 78, 121, 0.22);
        }

        /* SECTION */

        .section-card {
            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 4px 18px rgba(31, 78, 121, 0.06);
        }

        .section-header {
            background: #f8fafc;

            border-bottom: 1px solid var(--pms-border);

            padding: 18px 22px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .section-title small {
            color: var(--pms-muted);
        }

        .section-number {
            width: 36px;
            height: 36px;

            border-radius: 10px;

            background: var(--pms-primary);
            color: #fff;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
        }

        .section-body {
            padding: 24px;
        }

        /* FORM */

        .form-label {
            color: var(--pms-text);
        }

        .form-control {
            border-color: #dbe2ea;

            border-radius: 10px;

            padding: 11px 14px;

            color: var(--pms-text);
        }

        .form-control:focus {
            border-color: var(--pms-primary);

            box-shadow:
                0 0 0 0.2rem rgba(31, 78, 121, 0.10);
        }

        .progress-input {
            resize: vertical;

            min-height: 150px;
        }

        /* SELECTED GOAL */

        .selected-goal-box {
            display: flex;

            align-items: center;

            gap: 15px;

            background: #f4f8fc;

            border: 1px solid #d8e4ef;

            border-radius: 12px;

            padding: 16px 18px;
        }

        .selected-goal-icon {
            width: 44px;
            height: 44px;

            min-width: 44px;

            border-radius: 11px;

            background: var(--pms-primary);

            color: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 18px;
        }

        .selected-goal-content {
            flex: 1;
        }

        .selected-goal-title {
            color: var(--pms-text);

            font-size: 15px;

            font-weight: 700;

            line-height: 1.5;
        }

        .selected-goal-meta {
            display: flex;

            flex-wrap: wrap;

            gap: 15px;

            margin-top: 5px;

            color: var(--pms-muted);

            font-size: 12px;
        }

        .locked-badge {
            background: #edf1f5;

            color: #667085;

            border-radius: 20px;

            padding: 6px 10px;

            font-size: 11px;

            font-weight: 700;

            white-space: nowrap;
        }

        /* GOAL SUMMARY */

        .goal-summary-card {
            border-radius: 16px;

            overflow: hidden;

            background: #fff;

            border: 1px solid #d9e3ee;

            box-shadow:
                0 8px 25px rgba(31, 78, 121, 0.08);
        }

        .goal-summary-header {
            background: linear-gradient(
                135deg,
                var(--pms-primary),
                var(--pms-primary-dark)
            );

            color: #fff;

            padding: 20px 24px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;
        }

        .goal-summary-header small {
            display: block;

            margin-top: 5px;

            opacity: .8;
        }

        .goal-info-badge {
            background: rgba(255,255,255,.12);

            border: 1px solid rgba(255,255,255,.2);

            border-radius: 30px;

            padding: 8px 14px;

            font-size: 12px;
        }

        .goal-summary-body {
            padding: 24px;
        }

        .info-block {
            background: #f8fafc;

            border: 1px solid #e7edf4;

            border-radius: 12px;

            padding: 17px;
        }

        .full-width {
            margin-bottom: 18px;
        }

        .info-label {
            color: var(--pms-muted);

            font-size: 12px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .4px;

            margin-bottom: 8px;
        }

        .info-label i {
            color: var(--pms-primary);

            width: 18px;
        }

        .info-value {
            color: var(--pms-text);

            font-weight: 500;

            line-height: 1.6;

            white-space: pre-line;
        }

        .info-value.large {
            font-size: 16px;

            font-weight: 700;
        }

        .deadline-value {
            font-weight: 700;

            color: var(--pms-primary);
        }

        /* STATUS */

        .status-options {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 14px;
        }

        .status-option {
            cursor: pointer;

            margin: 0;
        }

        .status-option input {
            display: none;
        }

        .status-content {
            min-height: 78px;

            border: 1px solid #dfe6ee;

            border-radius: 12px;

            padding: 14px 16px;

            display: flex;

            align-items: center;

            gap: 13px;

            background: #fff;

            transition: all .2s ease;
        }

        .status-option:hover .status-content {
            border-color: var(--pms-primary);

            transform: translateY(-1px);

            box-shadow:
                0 5px 15px rgba(31, 78, 121, .08);
        }

        .status-option input:checked + .status-content {
            border: 2px solid var(--pms-primary);

            background: #f2f7fc;

            box-shadow:
                0 5px 18px rgba(31, 78, 121, .10);
        }

        .status-icon {
            width: 40px;
            height: 40px;

            min-width: 40px;

            border-radius: 10px;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .status-gray {
            background: #edf0f3;
            color: #6c757d;
        }

        .status-blue {
            background: #e8f1fa;
            color: var(--pms-primary);
        }

        .status-warning {
            background: #fff5dc;
            color: #b77900;
        }

        .status-success {
            background: #e7f6ed;
            color: #198754;
        }

        .status-content strong {
            display: block;

            color: var(--pms-text);
        }

        .status-content small {
            display: block;

            color: var(--pms-muted);

            margin-top: 2px;
        }

        .status-rating {
            margin-left: auto;

            background: #f1f4f8;

            color: var(--pms-primary);

            font-weight: 700;

            font-size: 13px;

            padding: 5px 9px;

            border-radius: 7px;

            white-space: nowrap;
        }

        /* RATING */

        .rating-card {
            background: linear-gradient(
                135deg,
                #f5f8fc,
                #ffffff
            );

            border: 1px solid #dce6f0;

            border-radius: 16px;

            padding: 22px 26px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            box-shadow:
                0 5px 20px rgba(31, 78, 121, .06);
        }

        .rating-left {
            display: flex;

            align-items: center;

            gap: 15px;
        }

        .rating-icon {
            width: 48px;
            height: 48px;

            background: #fff3cd;

            color: #b77900;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;
        }

        .rating-left p {
            color: var(--pms-muted);

            font-size: 13px;
        }

        .rating-result {
            min-width: 130px;

            text-align: center;

            color: var(--pms-primary);
        }

        .rating-value-wrapper {
            line-height: 1;
        }

        .rating-result span {
            display: inline-block;

            font-size: 42px;

            font-weight: 800;

            color: var(--pms-primary);

            transition: all .2s ease;
        }

        .rating-result small {
            color: var(--pms-muted);

            font-size: 15px;

            font-weight: 600;
        }

        .rating-status-text {
            margin-top: 8px;

            font-size: 12px;

            font-weight: 600;

            color: var(--pms-muted);
        }

        /* ANIMATION */

        .rating-pop {
            animation: ratingPop .25s ease-in-out;
        }

        @keyframes ratingPop {

            0% {
                transform: scale(.75);
                opacity: .4;
            }

            60% {
                transform: scale(1.15);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }

        }

        /* ACTIONS */

        .form-actions {
            display: flex;

            justify-content: flex-end;

            gap: 10px;

            background: #fff;

            border-top: 1px solid var(--pms-border);

            padding: 18px 0;
        }

        .btn-primary {
            background-color: var(--pms-primary);

            border-color: var(--pms-primary);
        }

        .btn-primary:hover {
            background-color: var(--pms-primary-dark);

            border-color: var(--pms-primary-dark);
        }

        /* RESPONSIVE */

        @media (max-width: 768px) {

            .goal-page-header {
                padding: 18px;
            }

            .section-body,
            .goal-summary-body {
                padding: 18px;
            }

            .status-options {
                grid-template-columns: 1fr;
            }

            .goal-summary-header {
                align-items: flex-start;

                flex-direction: column;
            }

            .selected-goal-box {
                align-items: flex-start;

                flex-wrap: wrap;
            }

            .locked-badge {
                margin-left: 59px;
            }

            .rating-card {
                align-items: flex-start;

                flex-direction: column;

                gap: 20px;
            }

            .rating-result {
                text-align: left;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .btn {
                width: 100%;
            }

        }

        /* ========================================================= */
/* REJECTION REMARKS */
/* ========================================================= */

.rejection-card {
    background: #fff;
    border: 1px solid #f1c6c6;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.07);
}

.rejection-header {
    background: #fff6f6;
    border-bottom: 1px solid #f1d3d3;
    padding: 18px 22px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.rejection-icon {
    width: 44px;
    height: 44px;
    min-width: 44px;

    border-radius: 11px;

    background: #fde8e8;
    color: #dc3545;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 18px;
}

.rejection-header h5 {
    color: #9f1d2c;
}

.rejection-header small {
    color: #8a5a5a;
}

.rejection-badge {
    background: #fde8e8;
    color: #dc3545;

    border: 1px solid #f5c2c7;

    border-radius: 20px;

    padding: 7px 12px;

    font-size: 11px;
    font-weight: 700;

    white-space: nowrap;
}

.rejection-body {
    padding: 20px 22px;
}

.remark-label {
    color: #9f1d2c;

    font-size: 12px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: .4px;

    margin-bottom: 10px;
}

.remark-content {
    background: #fffafa;

    border-left: 4px solid #dc3545;

    border-radius: 8px;

    padding: 14px 16px;

    color: #4a3030;

    font-size: 14px;

    line-height: 1.7;

    white-space: pre-line;
}

@media (max-width: 768px) {

    .rejection-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .rejection-badge {
        margin-left: 59px;
    }

}

    </style>

    {{-- ========================================================= --}}
    {{-- JAVASCRIPT --}}
    {{-- ========================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const ratingDisplay =
                document.getElementById('rating_display');

            const ratingStatusText =
                document.getElementById('rating_status_text');

            const statusInputs =
                document.querySelectorAll(
                    'input[name="achievement_status"]'
                );

            /*
            |--------------------------------------------------------------------------
            | RATING MAPPING
            |--------------------------------------------------------------------------
            */

            const ratings = {
                not_started: 0,
                in_progress: 1,
                partially_complete: 3,
                completed: 5
            };

            /*
            |--------------------------------------------------------------------------
            | STATUS LABELS
            |--------------------------------------------------------------------------
            */

            const statusLabels = {
                not_started: 'Not Started',
                in_progress: 'In Progress',
                partially_complete: 'Partially Complete',
                completed: 'Completed'
            };

            /*
            |--------------------------------------------------------------------------
            | UPDATE RATING
            |--------------------------------------------------------------------------
            */

            function updateRating(status) {

                if (
                    !status ||
                    !Object.prototype.hasOwnProperty.call(
                        ratings,
                        status
                    )
                ) {

                    ratingDisplay.textContent = '0';

                    ratingStatusText.textContent =
                        'Select status';

                    return;
                }

                const rating = ratings[status];

                /*
                |--------------------------------------------------------------------------
                | Update rating
                |--------------------------------------------------------------------------
                */

                ratingDisplay.textContent = rating;

                /*
                |--------------------------------------------------------------------------
                | Update status
                |--------------------------------------------------------------------------
                */

                ratingStatusText.textContent =
                    statusLabels[status];

                /*
                |--------------------------------------------------------------------------
                | Animation
                |--------------------------------------------------------------------------
                */

                ratingDisplay.classList.remove(
                    'rating-pop'
                );

                void ratingDisplay.offsetWidth;

                ratingDisplay.classList.add(
                    'rating-pop'
                );

            }

            /*
            |--------------------------------------------------------------------------
            | RADIO CHANGE
            |--------------------------------------------------------------------------
            */

            statusInputs.forEach(function (input) {

                input.addEventListener(
                    'change',
                    function () {

                        updateRating(input.value);

                    }
                );

            });

            /*
            |--------------------------------------------------------------------------
            | INITIAL RATING
            |--------------------------------------------------------------------------
            */

            let selectedStatus = null;

            statusInputs.forEach(function (input) {

                if (input.checked) {

                    selectedStatus = input.value;

                }

            });

            updateRating(selectedStatus);

        });

    </script>

@endsection
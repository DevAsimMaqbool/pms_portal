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
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            Self Report Against Goal
                        </h3>

                        <p class="mb-0 text-muted">
                            Provide your progress and achievement status against the selected goal.
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

        <form method="POST"
            action="{{ route('goal-self-reports.store') }}">

            @csrf

            {{-- ========================================================= --}}
            {{-- STEP 1 : SELECT GOAL --}}
            {{-- ========================================================= --}}

            <div class="section-card mb-4">

                <div class="section-header">

                    <div class="section-title">

                        <div class="section-number">
                            1
                        </div>

                        <div>

                            <h5 class="mb-1 fw-bold">
                                Select Goal
                            </h5>

                            <small>
                                Select the goal for which you want to submit your self report.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="section-body">

                    <label class="form-label fw-semibold">

                        Goal
                        <span class="text-danger">*</span>

                    </label>

                    <select name="new_goal_id"
                        id="new_goal_id"
                        class="form-select form-select-lg @error('new_goal_id') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Select Goal --
                        </option>

                        @foreach($goals as $goal)

                            <option value="{{ $goal->id }}"
                                data-goal="{{ $goal->goal }}"
                                data-s2r="{{ $goal->s2rDriver->driver_name ?? $goal->s2r_driver_enabler_alignment }}"
                                data-objectives="{{ $goal->objectives }}"
                                data-target="{{ $goal->target }}"
                                data-deadline="{{ optional($goal->deadline)->format('d M Y') }}"
                                {{ old('new_goal_id') == $goal->id ? 'selected' : '' }}>

                                {{ \Illuminate\Support\Str::limit($goal->goal, 120) }}

                            </option>

                        @endforeach

                    </select>

                    @error('new_goal_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- GOAL INFORMATION --}}
            {{-- ========================================================= --}}

            <div id="goalDetails"
                class="goal-summary-card mb-4"
                style="display:none;">

                <div class="goal-summary-header">

                    <div>

                        <div class="d-flex align-items-center gap-2">

                            <i class="fas fa-bullseye"></i>

                            <h5 class="mb-0 fw-bold">
                                Selected Goal
                            </h5>

                        </div>

                        <small>
                            Review the goal information before submitting your progress.
                        </small>

                    </div>

                    <span class="goal-info-badge">

                        <i class="fas fa-info-circle me-1"></i>

                        Goal Information

                    </span>

                </div>

                <div class="goal-summary-body">

                    <div class="info-block full-width">

                        <div class="info-label">

                            <i class="fas fa-bullseye"></i>

                            Goal

                        </div>

                        <div id="goalText"
                            class="info-value large">
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

                                <div id="s2rText"
                                    class="info-value">
                                </div>

                            </div>

                        </div>

                        {{-- Deadline --}}

                        <div class="col-lg-6">

                            <div class="info-block h-100">

                                <div class="info-label">

                                    <i class="far fa-calendar-alt"></i>

                                    Deadline

                                </div>

                                <div id="deadlineText"
                                    class="info-value deadline-value">
                                </div>

                            </div>

                        </div>

                        {{-- Objectives --}}

                        <div class="col-lg-6">

                            <div class="info-block h-100">

                                <div class="info-label">

                                    <i class="fas fa-list-check"></i>

                                    Objective(s)

                                </div>

                                <div id="objectiveText"
                                    class="info-value">
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

                                <div id="targetText"
                                    class="info-value">
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
                                Describe your progress, achievements and current position.
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
                        required>{{ old('progress_against_goal') }}</textarea>

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
                                Select the current achievement status of this goal.
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
                                {{ old('achievement_status') === 'not_started' ? 'checked' : '' }}>

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
                                {{ old('achievement_status') === 'in_progress' ? 'checked' : '' }}>

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
                                {{ old('achievement_status') === 'partially_complete' ? 'checked' : '' }}>

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
                                {{ old('achievement_status') === 'completed' ? 'checked' : '' }}>

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

                        <span id="rating_display">0</span>

                        <small>
                            / 5
                        </small>

                    </div>

                    <div id="rating_status_text"
                        class="rating-status-text">

                        Select status

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

                    <i class="fas fa-paper-plane me-2"></i>

                    Submit Self Report

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

        .form-control,
        .form-select {
            border-color: #dbe2ea;

            border-radius: 10px;

            padding: 11px 14px;

            color: var(--pms-text);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--pms-primary);

            box-shadow:
                0 0 0 0.2rem rgba(31, 78, 121, 0.10);
        }

        .progress-input {
            resize: vertical;
            min-height: 150px;
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

        /* RATING ANIMATION */

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

    </style>

    {{-- ========================================================= --}}
    {{-- JAVASCRIPT --}}
    {{-- IMPORTANT: DIRECTLY INSIDE CONTENT --}}
    {{-- ========================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | GET ELEMENTS
            |--------------------------------------------------------------------------
            */

            const goalSelect = document.getElementById('new_goal_id');

            const goalDetails = document.getElementById('goalDetails');

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
            | UPDATE SELF RATING
            |--------------------------------------------------------------------------
            */

            function updateRating(status) {

                console.log('Selected Status:', status);

                /*
                |--------------------------------------------------------------------------
                | If no status is selected
                |--------------------------------------------------------------------------
                */

                if (!status || !Object.prototype.hasOwnProperty.call(ratings, status)) {

                    ratingDisplay.textContent = '0';

                    ratingStatusText.textContent =
                        'Select status';

                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Get rating
                |--------------------------------------------------------------------------
                */

                const rating = ratings[status];

                /*
                |--------------------------------------------------------------------------
                | UPDATE RATING ON SCREEN
                |--------------------------------------------------------------------------
                */

                ratingDisplay.textContent = rating;

                /*
                |--------------------------------------------------------------------------
                | UPDATE STATUS TEXT
                |--------------------------------------------------------------------------
                */

                ratingStatusText.textContent =
                    statusLabels[status];

                /*
                |--------------------------------------------------------------------------
                | Animation
                |--------------------------------------------------------------------------
                */

                ratingDisplay.classList.remove('rating-pop');

                void ratingDisplay.offsetWidth;

                ratingDisplay.classList.add('rating-pop');

            }

            /*
            |--------------------------------------------------------------------------
            | RADIO BUTTON CHANGE EVENT
            |--------------------------------------------------------------------------
            */

            statusInputs.forEach(function (input) {

                input.addEventListener('change', function () {

                    /*
                     * THIS IS THE IMPORTANT PART
                     *
                     * Whenever user clicks:
                     *
                     * Not Started      => 0
                     * In Progress      => 1
                     * Partially        => 3
                     * Completed        => 5
                     */

                    updateRating(input.value);

                });

            });

            /*
            |--------------------------------------------------------------------------
            | LOAD OLD SELECTED STATUS
            |--------------------------------------------------------------------------
            */

            function loadInitialRating() {

                let selectedStatus = null;

                statusInputs.forEach(function (input) {

                    if (input.checked) {

                        selectedStatus = input.value;

                    }

                });

                updateRating(selectedStatus);

            }

            /*
            |--------------------------------------------------------------------------
            | LOAD GOAL INFORMATION
            |--------------------------------------------------------------------------
            */

            function loadGoalDetails() {

                if (!goalSelect || !goalDetails) {
                    return;
                }

                const selected =
                    goalSelect.options[
                        goalSelect.selectedIndex
                    ];

                if (!goalSelect.value) {

                    goalDetails.style.display = 'none';

                    return;

                }

                document.getElementById('goalText').textContent =
                    selected.dataset.goal || 'N/A';

                document.getElementById('s2rText').textContent =
                    selected.dataset.s2r || 'N/A';

                document.getElementById('objectiveText').textContent =
                    selected.dataset.objectives || 'N/A';

                document.getElementById('targetText').textContent =
                    selected.dataset.target || 'N/A';

                document.getElementById('deadlineText').textContent =
                    selected.dataset.deadline || 'N/A';

                goalDetails.style.display = 'block';

            }

            /*
            |--------------------------------------------------------------------------
            | GOAL CHANGE
            |--------------------------------------------------------------------------
            */

            if (goalSelect) {

                goalSelect.addEventListener(
                    'change',
                    loadGoalDetails
                );

            }

            /*
            |--------------------------------------------------------------------------
            | INITIAL PAGE LOAD
            |--------------------------------------------------------------------------
            */

            loadGoalDetails();

            loadInitialRating();

        });

    </script>

@endsection
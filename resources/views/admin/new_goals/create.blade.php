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
                        <i class="fas fa-bullseye"></i>
                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            Create New Goal
                        </h3>

                        <p class="mb-0 text-muted">
                            Define your goal, alignment, objectives, target and deadline.
                        </p>

                    </div>

                </div>

                <a href="{{ route('newgoals.index') }}"
                    class="btn btn-light border shadow-sm px-4">

                    <i class="fas fa-arrow-left me-2"></i>

                    Back to Goals

                </a>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- VALIDATION --}}
        {{-- ========================================================= --}}

        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm mb-4">

                <div class="d-flex align-items-center mb-2">

                    <div class="alert-icon">

                        <i class="fas fa-exclamation-triangle"></i>

                    </div>

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
            action="{{ route('newgoals.store') }}">

            @csrf

            <div class="row g-4">

                {{-- ================================================= --}}
                {{-- LEFT SIDE --}}
                {{-- ================================================= --}}

                <div class="col-lg-8">

                    <div class="section-card">

                        {{-- Section Header --}}

                        <div class="section-header">

                            <div class="section-title">

                                <div class="section-number">
                                    1
                                </div>

                                <div>

                                    <h5 class="mb-1 fw-bold">
                                        Goal Details
                                    </h5>

                                    <small>
                                        Define what you want to achieve and how it aligns with the strategic direction.
                                    </small>

                                </div>

                            </div>

                        </div>

                        {{-- Section Body --}}

                        <div class="section-body">

                            {{-- ===================================== --}}
                            {{-- GOAL --}}
                            {{-- ===================================== --}}

                            <div class="form-group mb-4">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-bullseye form-label-icon"></i>

                                    Goal

                                    <span class="text-danger">*</span>

                                </label>

                                <textarea
                                    name="goal"
                                    rows="5"
                                    maxlength="5000"
                                    class="form-control goal-textarea @error('goal') is-invalid @enderror"
                                    placeholder="Clearly describe what you want to achieve..."
                                    required>{{ old('goal') }}</textarea>

                                <div class="d-flex justify-content-between mt-2">

                                    @error('goal')

                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>

                                    @else

                                        <small class="text-muted">
                                            Clearly define the expected outcome of your goal.
                                        </small>

                                    @enderror

                                    <small class="text-muted">
                                        Maximum 5,000 characters
                                    </small>

                                </div>

                            </div>

                            {{-- ===================================== --}}
                            {{-- S2R --}}
                            {{-- ===================================== --}}

                            <div class="form-group mb-4">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-link form-label-icon"></i>

                                    S2R Driver / Enabler Alignment

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="s2r_driver_enabler_alignment"
                                    class="form-select form-select-lg @error('s2r_driver_enabler_alignment') is-invalid @enderror"
                                    required>

                                    <option value="">
                                        -- Select S2R Driver --
                                    </option>

                                    @foreach($drivers as $driver)

                                        <option
                                            value="{{ $driver->id }}"
                                            {{ old('s2r_driver_enabler_alignment') == $driver->id ? 'selected' : '' }}>

                                            {{ $driver->driver_name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('s2r_driver_enabler_alignment')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @else

                                    <small class="form-hint">

                                        <i class="fas fa-info-circle me-1"></i>

                                        Select the S2R driver or enabler that this goal supports.

                                    </small>

                                @enderror

                            </div>

                            {{-- ===================================== --}}
                            {{-- OBJECTIVES --}}
                            {{-- ===================================== --}}

                            <div class="form-group mb-4">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-list-check form-label-icon"></i>

                                    Objective(s)

                                    <span class="text-muted fw-normal">
                                        — if any
                                    </span>

                                </label>

                                <textarea
                                    name="objectives"
                                    rows="4"
                                    maxlength="5000"
                                    class="form-control @error('objectives') is-invalid @enderror"
                                    placeholder="Describe the objective(s), if applicable...">{{ old('objectives') }}</textarea>

                                @error('objectives')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @else

                                    <small class="form-hint">

                                        <i class="fas fa-lightbulb me-1"></i>

                                        Add specific objectives that will help you achieve this goal.

                                    </small>

                                @enderror

                            </div>

                            {{-- ===================================== --}}
                            {{-- TARGET --}}
                            {{-- ===================================== --}}

                            <div class="form-group">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-flag-checkered form-label-icon"></i>

                                    Target

                                    <span class="text-danger">*</span>

                                </label>

                                <textarea
                                    name="target"
                                    rows="4"
                                    maxlength="5000"
                                    class="form-control @error('target') is-invalid @enderror"
                                    placeholder="Define the measurable target..."
                                    required>{{ old('target') }}</textarea>

                                @error('target')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @else

                                    <small class="form-hint">

                                        <i class="fas fa-chart-line me-1"></i>

                                        Define a clear and measurable result that you want to achieve.

                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- RIGHT SIDE --}}
                {{-- ================================================= --}}

                <div class="col-lg-4">

                    {{-- ============================================= --}}
                    {{-- TIMELINE --}}
                    {{-- ============================================= --}}

                    <div class="section-card mb-4">

                        <div class="section-header">

                            <div class="section-title">

                                <div class="section-number">
                                    2
                                </div>

                                <div>

                                    <h5 class="mb-1 fw-bold">
                                        Goal Timeline
                                    </h5>

                                    <small>
                                        Set the expected completion date.
                                    </small>

                                </div>

                            </div>

                        </div>

                        <div class="section-body">

                            <label class="form-label fw-semibold">

                                <i class="far fa-calendar-alt form-label-icon"></i>

                                Deadline

                                <span class="text-danger">*</span>

                            </label>

                            <div class="deadline-input-wrapper">

                                <i class="far fa-calendar-alt"></i>

                                <input
                                    type="date"
                                    name="deadline"
                                    value="{{ old('deadline') }}"
                                    
                                    class="form-control deadline-input @error('deadline') is-invalid @enderror"
                                    required>

                            </div>

                            @error('deadline')

                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>

                            @else

                                <div class="form-hint mt-2">

                                    <i class="fas fa-info-circle me-1"></i>

                                    Select the date by which the target should be achieved.

                                </div>

                            @enderror

                            {{-- Deadline Visual --}}

                            <div class="timeline-info mt-4">

                                <div class="timeline-icon">

                                    <i class="fas fa-calendar-check"></i>

                                </div>

                                <div>

                                    <strong>
                                        Target Completion
                                    </strong>

                                    <small>
                                        Make sure your deadline is realistic and achievable.
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- ============================================= --}}
                    {{-- REVIEW PROCESS --}}
                    {{-- ============================================= --}}

                    <div class="process-card">

                        <div class="process-header">

                            <div class="process-icon">

                                <i class="fas fa-route"></i>

                            </div>

                            <div>

                                <h5 class="mb-1 fw-bold">
                                    Goal Review Process
                                </h5>

                                <small>
                                    What happens after creating your goal?
                                </small>

                            </div>

                        </div>

                        <div class="process-body">

                            {{-- Step 1 --}}

                            <div class="process-step">

                                <div class="process-step-icon completed">
                                    <i class="fas fa-check"></i>
                                </div>

                                <div>

                                    <strong>
                                        Create your goal
                                    </strong>

                                    <small>
                                        Define your goal and expected target.
                                    </small>

                                </div>

                            </div>

                            {{-- Connector --}}

                            <div class="process-line"></div>

                            {{-- Step 2 --}}

                            <div class="process-step">

                                <div class="process-step-icon">
                                    <i class="fas fa-file-pen"></i>
                                </div>

                                <div>

                                    <strong>
                                        Submit self report
                                    </strong>

                                    <small>
                                        Record your progress against the goal.
                                    </small>

                                </div>

                            </div>

                            <div class="process-line"></div>

                            {{-- Step 3 --}}

                            <div class="process-step">

                                <div class="process-step-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>

                                <div>

                                    <strong>
                                        Line Manager review
                                    </strong>

                                    <small>
                                        Your manager reviews the submission.
                                    </small>

                                </div>

                            </div>

                            <div class="process-line"></div>

                            {{-- Step 4 --}}

                            <div class="process-step">

                                <div class="process-step-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>

                                <div>

                                    <strong>
                                        HR final review
                                    </strong>

                                    <small>
                                        Final review and approval by HR.
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- ACTIONS --}}
            {{-- ========================================================= --}}

            <div class="form-actions mt-4">

                <a href="{{ route('newgoals.index') }}"
                    class="btn btn-light border px-4">

                    <i class="fas fa-times me-2"></i>

                    Cancel

                </a>

                <button
                    type="submit"
                    class="btn btn-primary px-4 shadow-sm">

                    <i class="fas fa-save me-2"></i>

                    Save Goal

                </button>

            </div>

        </form>

    </div>

    {{-- ============================================================= --}}
    {{-- STYLES --}}
    {{-- ============================================================= --}}

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

        /* =========================================================
           SECTION CARD
        ========================================================= */

        .section-card {

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 4px 18px rgba(31, 78, 121, 0.06);

            transition:
                box-shadow .2s ease,
                transform .2s ease;

        }

        .section-card:hover {

            box-shadow:
                0 7px 24px rgba(31, 78, 121, 0.09);

        }

        /* =========================================================
           SECTION HEADER
        ========================================================= */

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

            width: 38px;
            height: 38px;

            min-width: 38px;

            border-radius: 10px;

            background: var(--pms-primary);

            color: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: 700;

            box-shadow:
                0 5px 12px rgba(31, 78, 121, .16);

        }

        /* =========================================================
           SECTION BODY
        ========================================================= */

        .section-body {

            padding: 25px;

        }

        /* =========================================================
           FORM
        ========================================================= */

        .form-label {

            color: var(--pms-text);

            margin-bottom: 9px;

        }

        .form-label-icon {

            color: var(--pms-primary);

            width: 20px;

            margin-right: 5px;

        }

        .form-control,
        .form-select {

            border-color: #dbe2ea;

            border-radius: 10px;

            padding: 11px 14px;

            color: var(--pms-text);

            transition:
                border-color .2s ease,
                box-shadow .2s ease;

        }

        .form-select-lg {

            padding-top: 12px;

            padding-bottom: 12px;

        }

        .form-control:focus,
        .form-select:focus {

            border-color: var(--pms-primary);

            box-shadow:
                0 0 0 0.2rem rgba(31, 78, 121, 0.10);

        }

        textarea.form-control {

            resize: vertical;

            line-height: 1.6;

        }

        .goal-textarea {

            min-height: 145px;

        }

        .form-hint {

            display: block;

            color: var(--pms-muted);

            font-size: 12px;

            margin-top: 7px;

        }

        .form-hint i {

            color: var(--pms-primary);

        }

        .invalid-feedback {

            font-size: 12px;

        }

        /* =========================================================
           DEADLINE
        ========================================================= */

        .deadline-input-wrapper {

            position: relative;

        }

        .deadline-input-wrapper > i {

            position: absolute;

            left: 14px;

            top: 50%;

            transform: translateY(-50%);

            color: var(--pms-primary);

            z-index: 2;

            pointer-events: none;

        }

        .deadline-input {

            padding-left: 40px;

        }

        .timeline-info {

            display: flex;

            align-items: center;

            gap: 12px;

            background: #f4f7fb;

            border: 1px solid #e0e8f1;

            border-radius: 12px;

            padding: 14px;

        }

        .timeline-icon {

            width: 40px;
            height: 40px;

            min-width: 40px;

            border-radius: 10px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

        }

        .timeline-info strong {

            display: block;

            color: var(--pms-text);

            font-size: 13px;

        }

        .timeline-info small {

            display: block;

            color: var(--pms-muted);

            margin-top: 3px;

            line-height: 1.4;

        }

        /* =========================================================
           PROCESS CARD
        ========================================================= */

        .process-card {

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 4px 18px rgba(31, 78, 121, 0.06);

        }

        .process-header {

            padding: 20px;

            background: linear-gradient(
                135deg,
                var(--pms-primary),
                var(--pms-primary-dark)
            );

            color: #fff;

            display: flex;

            align-items: center;

            gap: 13px;

        }

        .process-header small {

            display: block;

            opacity: .8;

            margin-top: 3px;

        }

        .process-icon {

            width: 44px;
            height: 44px;

            min-width: 44px;

            border-radius: 11px;

            background: rgba(255,255,255,.12);

            border: 1px solid rgba(255,255,255,.18);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 18px;

        }

        .process-body {

            padding: 20px;

        }

        .process-step {

            display: flex;

            align-items: flex-start;

            gap: 12px;

        }

        .process-step-icon {

            width: 34px;
            height: 34px;

            min-width: 34px;

            border-radius: 9px;

            background: #edf3f8;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 13px;

        }

        .process-step-icon.completed {

            background: #e7f6ed;

            color: #198754;

        }

        .process-step strong {

            display: block;

            color: var(--pms-text);

            font-size: 13px;

            line-height: 1.4;

        }

        .process-step small {

            display: block;

            color: var(--pms-muted);

            font-size: 11px;

            line-height: 1.5;

            margin-top: 3px;

        }

        .process-line {

            height: 20px;

            width: 1px;

            background: #dce4ec;

            margin-left: 16px;

            margin-top: 3px;

            margin-bottom: 3px;

        }

        /* =========================================================
           ALERT
        ========================================================= */

        .alert-icon {

            width: 32px;
            height: 32px;

            min-width: 32px;

            border-radius: 8px;

            background: rgba(220, 53, 69, .10);

            color: #dc3545;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-right: 10px;

        }

        /* =========================================================
           ACTIONS
        ========================================================= */

        .form-actions {

            display: flex;

            justify-content: flex-end;

            gap: 10px;

            padding: 18px 0;

            border-top: 1px solid var(--pms-border);

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
           RESPONSIVE
        ========================================================= */

        @media (max-width: 991px) {

            .process-card {

                margin-top: 0;

            }

        }

        @media (max-width: 768px) {

            .container-fluid {

                padding-left: 15px;

                padding-right: 15px;

            }

            .goal-page-header {

                padding: 18px;

            }

            .goal-page-header .btn {

                width: 100%;

            }

            .section-body {

                padding: 18px;

            }

            .section-header {

                padding: 16px 18px;

            }

            .form-actions {

                flex-direction: column-reverse;

            }

            .form-actions .btn {

                width: 100%;

            }

        }

    </style>

@endsection
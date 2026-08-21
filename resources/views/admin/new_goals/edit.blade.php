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
                            Edit Goal
                        </h3>

                        <p class="mb-0 text-muted">
                            Update your goal details before submitting the self report.
                        </p>

                    </div>

                </div>

                <div class="d-flex align-items-center gap-2">

                    <span class="goal-id-badge">

                        <i class="fas fa-hashtag me-1"></i>

                        Goal {{ $newgoal->id }}

                    </span>

                    <a href="{{ route('newgoals.index') }}" class="btn btn-light border shadow-sm px-4">

                        <i class="fas fa-arrow-left me-2"></i>

                        Back to Goals

                    </a>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- VALIDATION ERRORS --}}
        {{-- ========================================================= --}}

        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm mb-4">

                <div class="d-flex align-items-center mb-2">

                    <div class="error-icon me-3">

                        <i class="fas fa-exclamation-triangle"></i>

                    </div>

                    <strong>
                        Please correct the following errors:
                    </strong>

                </div>

                <ul class="mb-0 ps-5">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- ========================================================= --}}
        {{-- FORM --}}
        {{-- ========================================================= --}}

        <form method="POST" action="{{ route('newgoals.update', $newgoal) }}">

            @csrf

            @method('PUT')

            <div class="row g-4">

                {{-- ================================================= --}}
                {{-- LEFT SIDE --}}
                {{-- ================================================= --}}

                <div class="col-lg-8">

                    {{-- ============================================= --}}
                    {{-- GOAL INFORMATION --}}
                    {{-- ============================================= --}}

                    <div class="section-card mb-4">

                        <div class="section-header">

                            <div class="section-title">

                                <div class="section-number">
                                    1
                                </div>

                                <div>

                                    <h5 class="mb-1 fw-bold">
                                        Goal Information
                                    </h5>

                                    <small>
                                        Update the goal, strategic alignment, objectives and target.
                                    </small>

                                </div>

                            </div>

                        </div>

                        <div class="section-body">

                            {{-- ===================================== --}}
                            {{-- GOAL --}}
                            {{-- ===================================== --}}

                            <div class="form-group-custom mb-4">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-bullseye field-icon me-2"></i>

                                    Goal

                                    <span class="text-danger">*</span>

                                </label>

                                <textarea name="goal" rows="5" class="form-control @error('goal') is-invalid @enderror"
                                    placeholder="Clearly describe what you want to achieve..."
                                    required>{{ old('goal', $newgoal->goal) }}</textarea>

                                @error('goal')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <small class="field-help">

                                    Clearly define the expected outcome of this goal.

                                </small>

                            </div>

                            {{-- ===================================== --}}
                            {{-- S2R --}}
                            {{-- ===================================== --}}

                            <div class="form-group-custom mb-4">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-link field-icon me-2"></i>

                                    S2R Driver / Enabler Alignment

                                    <span class="text-danger">*</span>

                                </label>

                                <select name="s2r_driver_enabler_alignment"
                                    class="form-select @error('s2r_driver_enabler_alignment') is-invalid @enderror"
                                    required>

                                    <option value="">
                                        -- Select S2R Driver --
                                    </option>

                                    @foreach($drivers as $driver)

                                                                    <option value="{{ $driver->id }}" {{ old(
                                            's2r_driver_enabler_alignment',
                                            $newgoal->s2r_driver_enabler_alignment
                                        ) == $driver->id
                                            ? 'selected'
                                            : '' }}>

                                                                        {{ $driver->driver_name }}

                                                                    </option>

                                    @endforeach

                                </select>

                                @error('s2r_driver_enabler_alignment')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <small class="field-help">

                                    Select the S2R driver or enabler aligned with this goal.

                                </small>

                            </div>

                            {{-- ===================================== --}}
                            {{-- OBJECTIVES --}}
                            {{-- ===================================== --}}

                            <div class="form-group-custom mb-4">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-list-check field-icon me-2"></i>

                                    Objective(s)

                                    <span class="text-muted fw-normal">
                                        — if any
                                    </span>

                                </label>

                                <textarea name="objectives" rows="4" class="form-control"
                                    placeholder="Describe the objective(s), if applicable...">{{ old('objectives', $newgoal->objectives) }}</textarea>

                                <small class="field-help">

                                    Add specific objectives that support the achievement of this goal.

                                </small>

                            </div>

                            {{-- ===================================== --}}
                            {{-- TARGET --}}
                            {{-- ===================================== --}}

                            <div class="form-group-custom">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-flag-checkered field-icon me-2"></i>

                                    Target

                                    <span class="text-danger">*</span>

                                </label>

                                <textarea name="target" rows="4" class="form-control @error('target') is-invalid @enderror"
                                    placeholder="Define the measurable target..."
                                    required>{{ old('target', $newgoal->target) }}</textarea>

                                @error('target')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <small class="field-help">

                                    Define a clear and measurable target for this goal.

                                </small>

                            </div>

                        </div>

                    </div>

                    {{-- ============================================= --}}
                    {{-- UPDATE NOTE --}}
                    {{-- ============================================= --}}

                    <div class="update-note-card">

                        <div class="update-note-icon">

                            <i class="fas fa-lightbulb"></i>

                        </div>

                        <div>

                            <h6 class="fw-bold mb-1">
                                Before you update
                            </h6>

                            <p class="mb-0">
                                Make sure the goal information, alignment, target and deadline
                                accurately reflect what you intend to achieve.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- RIGHT SIDE --}}
                {{-- ================================================= --}}

                <div class="col-lg-4">

                    {{-- ============================================= --}}
                    {{-- DEADLINE --}}
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

                                <i class="far fa-calendar-alt field-icon me-2"></i>

                                Deadline

                                <span class="text-danger">*</span>

                            </label>

                            <div class="deadline-input-wrapper">

                                <i class="far fa-calendar-alt"></i>

                                <input type="date" name="deadline"
                                    class="form-control @error('deadline') is-invalid @enderror" value="{{ old(
        'deadline',
        optional($newgoal->deadline)->format('Y-m-d')
    ) }}" required>

                            </div>

                            @error('deadline')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror

                            <div class="deadline-help mt-3">

                                <i class="fas fa-info-circle me-2"></i>

                                Select the date by which the target should be achieved.

                            </div>

                        </div>

                    </div>

                    {{-- ============================================= --}}
                    {{-- GOAL STATUS --}}
                    {{-- ============================================= --}}

                    <div class="status-card mb-4">

                        <div class="status-card-header">

                            <div class="status-card-icon">

                                <i class="fas fa-chart-line"></i>

                            </div>

                            <div>

                                <h6 class="fw-bold mb-1">
                                    Goal Status
                                </h6>

                                <small>
                                    Current goal information
                                </small>

                            </div>

                        </div>

                        <div class="status-card-body">

                            <div class="status-row">

                                <span class="status-label">
                                    Current Status
                                </span>

                                @php
                                    $status = strtolower($newgoal->status ?? 'pending');

                                    $statusClass = match ($status) {
                                        'active', 'approved', 'completed' => 'status-success',
                                        'pending', 'draft' => 'status-warning',
                                        'rejected', 'inactive' => 'status-danger',
                                        default => 'status-blue',
                                    };
                                @endphp

                                <span class="custom-status {{ $statusClass }}">

                                    <span class="status-dot"></span>

                                    {{ ucfirst($newgoal->status ?? 'Pending') }}

                                </span>

                            </div>

                            <div class="status-divider"></div>

                            <div class="created-info">

                                <div class="created-icon">

                                    <i class="far fa-clock"></i>

                                </div>

                                <div>

                                    <small class="d-block text-muted">
                                        Created
                                    </small>

                                    <strong>
                                        {{ $newgoal->created_at->format('d M Y, h:i A') }}
                                    </strong>

                                </div>

                            </div>

                            <div class="status-divider"></div>

                            <div class="goal-id-row">

                                <span>
                                    <i class="fas fa-hashtag me-1"></i>
                                    Goal ID
                                </span>

                                <strong>
                                    {{ $newgoal->id }}
                                </strong>

                            </div>

                        </div>

                    </div>

                    {{-- ============================================= --}}
                    {{-- REVIEW PROCESS --}}
                    {{-- ============================================= --}}

                    <div class="review-card">

                        <div class="review-header">

                            <div class="review-icon">

                                <i class="fas fa-route"></i>

                            </div>

                            <div>

                                <h6 class="fw-bold mb-1">
                                    Goal Review Process
                                </h6>

                                <small>
                                    Your goal journey
                                </small>

                            </div>

                        </div>

                        <div class="review-body">

                            <div class="review-step">

                                <div class="review-step-icon completed">
                                    <i class="fas fa-check"></i>
                                </div>

                                <div>
                                    <strong>Create / Update Goal</strong>
                                    <small>Define your goal details</small>
                                </div>

                            </div>

                            <div class="review-line"></div>

                            <div class="review-step">

                                <div class="review-step-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>

                                <div>
                                    <strong>Submit Self Report</strong>
                                    <small>Report your progress</small>
                                </div>

                            </div>

                            <div class="review-line"></div>

                            <div class="review-step">

                                <div class="review-step-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>

                                <div>
                                    <strong>Line Manager Review</strong>
                                    <small>Manager assessment</small>
                                </div>

                            </div>

                            <div class="review-line"></div>

                            <div class="review-step">

                                <div class="review-step-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>

                                <div>
                                    <strong>HR Final Review</strong>
                                    <small>Final assessment</small>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- ACTIONS --}}
            {{-- ========================================================= --}}

            <div class="form-actions">

                <a href="{{ route('newgoals.index') }}" class="btn btn-light border px-4">

                    <i class="fas fa-times me-2"></i>

                    Cancel

                </a>

                <button type="submit" class="btn btn-primary px-4 shadow-sm">

                    <i class="fas fa-save me-2"></i>

                    Update Goal

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

        /* =========================================================
                   PAGE HEADER
                ========================================================= */

        .goal-page-header {
            background: linear-gradient(135deg,
                    #ffffff 0%,
                    #f5f8fc 100%);

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

        .goal-id-badge {
            display: inline-flex;

            align-items: center;

            background: #eaf2f9;

            color: var(--pms-primary);

            border: 1px solid #d6e3ef;

            border-radius: 30px;

            padding: 8px 14px;

            font-size: 13px;

            font-weight: 700;
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

            flex-shrink: 0;
        }

        .section-body {
            padding: 24px;
        }

        /* =========================================================
                   FORM
                ========================================================= */

        .form-label {
            color: var(--pms-text);
        }

        .field-icon {
            color: var(--pms-primary);

            width: 18px;
        }

        .form-control,
        .form-select {
            border-color: #dbe2ea;

            border-radius: 10px;

            padding: 11px 14px;

            color: var(--pms-text);

            transition: all .2s ease;
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #c5d2df;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--pms-primary);

            box-shadow:
                0 0 0 0.2rem rgba(31, 78, 121, 0.10);
        }

        textarea.form-control {
            resize: vertical;
        }

        .field-help {
            display: block;

            color: var(--pms-muted);

            font-size: 12px;

            margin-top: 7px;
        }

        /* =========================================================
                   DEADLINE
                ========================================================= */

        .deadline-input-wrapper {
            position: relative;
        }

        .deadline-input-wrapper>i {
            position: absolute;

            left: 14px;

            top: 50%;

            transform: translateY(-50%);

            color: var(--pms-primary);

            z-index: 2;

            pointer-events: none;
        }

        .deadline-input-wrapper input {
            padding-left: 42px;
        }

        .deadline-help {
            background: #f4f7fb;

            border: 1px solid #e1e8f0;

            color: var(--pms-muted);

            border-radius: 10px;

            padding: 11px 13px;

            font-size: 12px;

            line-height: 1.5;
        }

        .deadline-help i {
            color: var(--pms-primary);
        }

        /* =========================================================
                   STATUS CARD
                ========================================================= */

        .status-card {
            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 4px 18px rgba(31, 78, 121, 0.06);
        }

        .status-card-header {
            background: linear-gradient(135deg,
                    var(--pms-primary),
                    var(--pms-primary-dark));

            color: #fff;

            padding: 18px 20px;

            display: flex;

            align-items: center;

            gap: 12px;
        }

        .status-card-header small {
            opacity: .78;
        }

        .status-card-icon {
            width: 40px;
            height: 40px;

            border-radius: 10px;

            background: rgba(255, 255, 255, .12);

            border: 1px solid rgba(255, 255, 255, .18);

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .status-card-body {
            padding: 20px;
        }

        .status-row {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;
        }

        .status-label {
            color: var(--pms-muted);

            font-size: 13px;

            font-weight: 600;
        }

        .custom-status {
            display: inline-flex;

            align-items: center;

            gap: 7px;

            border-radius: 30px;

            padding: 6px 11px;

            font-size: 12px;

            font-weight: 700;
        }

        .status-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: currentColor;
        }

        .status-success {
            background: #e7f6ed;

            color: #198754;
        }

        .status-warning {
            background: #fff5dc;

            color: #b77900;
        }

        .status-danger {
            background: #fdeaea;

            color: #dc3545;
        }

        .status-blue {
            background: #e8f1fa;

            color: var(--pms-primary);
        }

        .status-divider {
            height: 1px;

            background: #edf1f5;

            margin: 18px 0;
        }

        .created-info {
            display: flex;

            align-items: center;

            gap: 12px;
        }

        .created-icon {
            width: 38px;
            height: 38px;

            border-radius: 10px;

            background: #f1f5f9;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .created-info strong {
            color: var(--pms-text);

            font-size: 13px;
        }

        .goal-id-row {
            display: flex;

            justify-content: space-between;

            align-items: center;

            color: var(--pms-muted);

            font-size: 13px;
        }

        .goal-id-row strong {
            color: var(--pms-primary);

            background: #f1f5f9;

            padding: 5px 9px;

            border-radius: 7px;
        }

        /* =========================================================
                   REVIEW CARD
                ========================================================= */

        .review-card {
            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 4px 18px rgba(31, 78, 121, 0.06);
        }

        .review-header {
            background: #f8fafc;

            border-bottom: 1px solid var(--pms-border);

            padding: 18px 20px;

            display: flex;

            align-items: center;

            gap: 12px;
        }

        .review-icon {
            width: 40px;
            height: 40px;

            border-radius: 10px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .review-header small {
            color: var(--pms-muted);
        }

        .review-body {
            padding: 20px;
        }

        .review-step {
            display: flex;

            align-items: center;

            gap: 12px;
        }

        .review-step-icon {
            width: 34px;
            height: 34px;

            min-width: 34px;

            border-radius: 50%;

            background: #f1f4f8;

            color: #8a97a6;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 12px;

            border: 1px solid #e0e6ed;
        }

        .review-step-icon.completed {
            background: #e7f6ed;

            color: #198754;

            border-color: #c9ead7;
        }

        .review-step strong {
            display: block;

            color: var(--pms-text);

            font-size: 13px;
        }

        .review-step small {
            display: block;

            color: var(--pms-muted);

            font-size: 11px;

            margin-top: 2px;
        }

        .review-line {
            height: 20px;

            width: 1px;

            background: #dce3eb;

            margin-left: 17px;
        }

        /* =========================================================
                   UPDATE NOTE
                ========================================================= */

        .update-note-card {
            background: linear-gradient(135deg,
                    #f5f8fc,
                    #ffffff);

            border: 1px solid #dce6f0;

            border-radius: 14px;

            padding: 18px 20px;

            display: flex;

            align-items: flex-start;

            gap: 13px;

            box-shadow:
                0 4px 15px rgba(31, 78, 121, .04);
        }

        .update-note-icon {
            width: 40px;
            height: 40px;

            min-width: 40px;

            border-radius: 10px;

            background: #fff3cd;

            color: #b77900;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .update-note-card h6 {
            color: var(--pms-text);
        }

        .update-note-card p {
            color: var(--pms-muted);

            font-size: 12px;

            line-height: 1.6;
        }

        /* =========================================================
                   ACTIONS
                ========================================================= */

        .form-actions {
            display: flex;

            justify-content: flex-end;

            gap: 10px;

            background: #fff;

            border-top: 1px solid var(--pms-border);

            padding: 18px 0;

            margin-top: 20px;
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
                   ERROR
                ========================================================= */

        .error-icon {
            width: 36px;
            height: 36px;

            border-radius: 9px;

            background: rgba(220, 53, 69, .10);

            color: #dc3545;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        /* =========================================================
                   RESPONSIVE
                ========================================================= */

        @media (max-width: 991px) {

            .goal-id-badge {
                display: none;
            }

        }

        @media (max-width: 768px) {

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

            .status-row {
                align-items: flex-start;

                flex-direction: column;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .btn {
                width: 100%;
            }

            .update-note-card {
                padding: 16px;
            }

        }
    </style>

@endsection
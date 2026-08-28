```blade
@extends('layouts.app')

@section('content')

    <div class="container-fluid py-3">

        {{-- HEADER --}}
        <div class="compact-header mb-3">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <div class="header-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Line Manager Review</h4>
                        <small class="text-muted">
                            Review employee goal progress and provide your assessment.
                        </small>
                    </div>
                </div>
            </div>

            <a href="{{ route('goal-manager.index') }}" class="btn btn-light border btn-sm">
                <i class="fas fa-arrow-left me-1"></i>
                Back
            </a>
        </div>

        {{-- ALERTS --}}
        @if(session('success'))
            <div class="alert alert-success py-2 mb-3">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger py-2 mb-3">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger py-2 mb-3">
                <strong>Please correct the following:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- EMPLOYEE + REPORT --}}
        <div class="compact-card mb-3">

            <div class="employee-row">

                <div class="employee-info">
                    <div class="employee-avatar">
                        <i class="fas fa-user"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">
                            {{ $goalSelfReport->user->name ?? 'N/A' }}
                        </h5>

                        <small class="text-muted">
                            Employee Goal Self Report
                        </small>
                    </div>
                </div>

                <div class="text-end">
                    <span class="report-number">
                        Report #{{ $goalSelfReport->id }}
                    </span>

                    <div class="small text-muted mt-1">
                        {{ optional($goalSelfReport->submitted_at)->format('d M Y, h:i A') }}
                    </div>
                </div>

            </div>

            <div class="mini-stats">

                <div>
                    <span>Achievement</span>
                    <strong>
                        {{ ucwords(str_replace('_', ' ', $goalSelfReport->achievement_status)) }}
                    </strong>
                </div>

                <div>
                    <span>Employee Rating</span>
                    <strong class="rating-blue">
                        {{ $goalSelfReport->rating ?? 0 }} / 5
                    </strong>
                </div>

                <div>
                    <span>Manager Rating</span>
                    <strong class="rating-orange">
                        {{ $goalSelfReport->manager_rating ?? '-' }}
                        @if($goalSelfReport->manager_rating !== null)
                            / 5
                        @endif
                    </strong>
                </div>

                <!-- <div>
                        <span>HR Rating</span>
                        <strong class="rating-green">
                            {{ $goalSelfReport->hr_rating ?? '-' }}
                            @if($goalSelfReport->hr_rating !== null)
                                / 5
                            @endif
                        </strong>
                    </div> -->

            </div>

        </div>

        <div class="row g-3">

            {{-- LEFT SIDE --}}
            <div class="col-lg-7">

                {{-- GOAL --}}
                <div class="compact-card mb-3">

                    <div class="card-title-row">
                        <div>
                            <i class="fas fa-bullseye"></i>
                            Goal Details
                        </div>
                    </div>

                    <div class="card-body-compact">

                        <div class="goal-title">
                            {{ $goalSelfReport->goal->goal }}
                        </div>

                        <div class="detail-grid">

                            <div class="detail-item">
                                <span>
                                    <i class="fas fa-link"></i>
                                    S2R Driver / Enabler
                                </span>

                                <strong>
                                    {{ $goalSelfReport->goal->s2rDriver->driver_name ?? 'N/A' }}
                                </strong>
                            </div>

                            <div class="detail-item">
                                <span>
                                    <i class="fas fa-calendar"></i>
                                    Deadline
                                </span>

                                <strong>
                                    {{ optional($goalSelfReport->goal->deadline)->format('d M Y') }}
                                </strong>
                            </div>

                            <div class="detail-item full">
                                <span>
                                    <i class="fas fa-list-check"></i>
                                    Objective
                                </span>

                                <strong>
                                    {{ $goalSelfReport->goal->objectives ?: 'N/A' }}
                                </strong>
                            </div>

                            <div class="detail-item full">
                                <span>
                                    <i class="fas fa-flag-checkered"></i>
                                    Target
                                </span>

                                <strong>
                                    {{ $goalSelfReport->goal->target }}
                                </strong>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- EMPLOYEE PROGRESS --}}
                <div class="compact-card mb-3">

                    <div class="card-title-row">
                        <div>
                            <i class="fas fa-chart-line"></i>
                            Employee Progress
                        </div>
                    </div>

                    <div class="progress-content">
                        {{ $goalSelfReport->progress_against_goal }}
                    </div>

                </div>

                {{-- PREVIOUS MANAGER REMARKS --}}
                @if($managerReview)

                    <div class="compact-card mb-3">

                        <div class="card-title-row">
                            <div>
                                <i class="fas fa-comment-dots"></i>
                                Previous Manager Remarks
                            </div>

                            <span class="small text-muted">
                                {{ optional($managerReview->reviewed_at)->format('d M Y, h:i A') }}
                            </span>
                        </div>

                        <div class="remarks-content">

                            @if($managerReview->comments)
                                {{ $managerReview->comments }}
                            @else
                                <span class="text-muted">
                                    No remarks provided.
                                </span>
                            @endif

                        </div>

                    </div>

                @endif

            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-5">

                {{-- RATING SUMMARY --}}
                <div class="compact-card mb-3">

                    <div class="card-title-row">
                        <div>
                            <i class="fas fa-star"></i>
                            Rating Summary
                        </div>
                    </div>

                    <div class="rating-list">

                        <div class="rating-line">
                            <span>
                                <i class="fas fa-user text-primary"></i>
                                Employee
                            </span>

                            <strong>
                                {{ $goalSelfReport->rating ?? 0 }} / 5
                            </strong>
                        </div>

                        <div class="rating-line">
                            <span>
                                <i class="fas fa-user-tie text-warning"></i>
                                Line Manager
                            </span>

                            <strong class="rating-orange">
                                {{ $goalSelfReport->manager_rating ?? '-' }}

                                @if($goalSelfReport->manager_rating !== null)
                                    / 5
                                @endif
                            </strong>
                        </div>

                        <!-- <div class="rating-line">
                                    <span>
                                        <i class="fas fa-building text-success"></i>
                                        HR
                                    </span>

                                    <strong class="rating-green">
                                        {{ $goalSelfReport->hr_rating ?? '-' }}

                                        @if($goalSelfReport->hr_rating !== null)
                                            / 5
                                        @endif
                                    </strong>
                                </div> -->

                    </div>

                </div>

                {{-- MANAGER ASSESSMENT --}}
                <div class="compact-card">

                    <div class="assessment-header">

                        <div>
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-user-tie me-1"></i>
                                Line Manager Assessment
                            </h5>

                            <small>
                                Evaluate the employee's achievement.
                            </small>
                        </div>

                    </div>

                    <div class="assessment-body">

                        <form method="POST" action="{{ route('goal-manager.review', $goalSelfReport) }}">

                            @csrf
                            {{-- WEIGHTAGE --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Goal Weightage (%)
                                    <span class="text-danger">*</span>
                                </label>

                                @php
                                    $existingWeight = old(
                                        'weightage',
                                        $goalSelfReport->weightage
                                    );
                                @endphp

                                <div class="input-group input-group-sm">
                                    <input type="number" name="weightage" class="form-control" value="{{ $existingWeight }}"
                                        min="0" max="100" step="0.01" placeholder="e.g. 20" required>

                                    <span class="input-group-text">%</span>
                                </div>

                                <small class="text-muted">
                                    Define the contribution of this goal to the overall performance rating.
                                </small>

                            </div>

                            {{-- DECISION --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Decision <span class="text-danger">*</span>
                                </label>

                                @php
                                    $existingDecision = old(
                                        'decision',
                                        optional($managerReview)->decision
                                    );
                                @endphp

                                <select name="decision" class="form-select form-select-sm" required>

                                    <option value="">
                                        Select Decision
                                    </option>

                                    <option value="approved" {{ $existingDecision === 'approved' ? 'selected' : '' }}>
                                        Approve
                                    </option>

                                    <option value="rejected" {{ $existingDecision === 'rejected' ? 'selected' : '' }}>
                                        Reject
                                    </option>

                                </select>

                            </div>

                            {{-- RATING --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Manager Rating
                                    <span class="text-danger">*</span>
                                </label>

                                @php
                                    $existingRating = old(
                                        'manager_rating',
                                        $goalSelfReport->manager_rating
                                    );
                                @endphp

                                <div class="rating-options">

                                    @for($i = 0; $i <= 5; $i++)

                                                                <label class="rating-option">

                                                                    <input type="radio" name="manager_rating" value="{{ $i }}" {{ $existingRating !== null &&
                                        (int) $existingRating === $i
                                        ? 'checked'
                                        : '' }} required>

                                                                    <span>
                                                                        {{ $i }}
                                                                    </span>

                                                                </label>

                                    @endfor

                                </div>

                                <small class="text-muted">
                                    Rate achievement from 0 to 5.
                                </small>

                            </div>

                            {{-- COMMENTS --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Manager Remarks
                                </label>

                                <textarea name="comments" class="form-control form-control-sm" rows="4"
                                    placeholder="Enter your remarks...">{{ old(
        'comments',
        optional($managerReview)->comments
    ) }}</textarea>

                            </div>

                            {{-- ACTIONS --}}
                            <div class="assessment-actions">

                                <a href="{{ route('goal-manager.index') }}" class="btn btn-light border btn-sm">
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-primary btn-sm">

                                    @if($managerReview)
                                        <i class="fas fa-save me-1"></i>
                                        Update Review
                                    @else
                                        <i class="fas fa-paper-plane me-1"></i>
                                        Submit Review
                                    @endif

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <style>
        :root {
            --pms-primary: #1f4e79;
            --pms-primary-dark: #173a5c;
            --pms-border: #e5e9ef;
            --pms-text: #263548;
            --pms-muted: #748094;
        }

        body {
            background: #f7f9fc;
        }

        .compact-header {
            background: #fff;
            border: 1px solid var(--pms-border);
            border-radius: 10px;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--pms-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .compact-header h4 {
            font-size: 17px;
            color: var(--pms-text);
        }

        .compact-header small {
            font-size: 10px;
        }

        .compact-card {
            background: #fff;
            border: 1px solid var(--pms-border);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(31, 78, 121, .035);
        }

        .employee-row {
            padding: 13px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .employee-avatar {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: #eaf2fa;
            color: var(--pms-primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .employee-info h5 {
            font-size: 14px;
            color: var(--pms-text);
        }

        .employee-info small {
            font-size: 10px;
        }

        .report-number {
            background: #f1f5f9;
            color: var(--pms-primary);
            border-radius: 15px;
            padding: 4px 9px;
            font-size: 10px;
            font-weight: 700;
        }

        .mini-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            border-top: 1px solid var(--pms-border);
        }

        .mini-stats>div {
            padding: 9px 12px;
            border-right: 1px solid var(--pms-border);
        }

        .mini-stats>div:last-child {
            border-right: 0;
        }

        .mini-stats span {
            display: block;
            color: var(--pms-muted);
            font-size: 9px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .mini-stats strong {
            font-size: 12px;
            color: var(--pms-text);
        }

        .rating-blue {
            color: var(--pms-primary) !important;
        }

        .rating-orange {
            color: #b77900 !important;
        }

        .rating-green {
            color: #198754 !important;
        }

        .card-title-row {
            padding: 10px 13px;
            border-bottom: 1px solid var(--pms-border);
            background: #fafbfd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--pms-primary);
            font-size: 11px;
            font-weight: 700;
        }

        .card-title-row i {
            margin-right: 5px;
        }

        .card-body-compact {
            padding: 13px;
        }

        .goal-title {
            color: var(--pms-text);
            font-size: 14px;
            font-weight: 700;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .detail-item {
            background: #f8fafc;
            border: 1px solid #edf0f4;
            border-radius: 7px;
            padding: 9px 10px;
        }

        .detail-item.full {
            grid-column: 1 / -1;
        }

        .detail-item span {
            display: block;
            color: var(--pms-muted);
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .detail-item span i {
            color: var(--pms-primary);
            width: 14px;
        }

        .detail-item strong {
            display: block;
            color: var(--pms-text);
            font-size: 11px;
            line-height: 1.45;
        }

        .progress-content,
        .remarks-content {
            padding: 12px 13px;
            color: var(--pms-text);
            font-size: 11px;
            line-height: 1.6;
            white-space: pre-line;
        }

        .rating-list {
            padding: 7px 13px;
        }

        .rating-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 0;
            border-bottom: 1px solid #edf0f4;
            font-size: 11px;
        }

        .rating-line:last-child {
            border-bottom: 0;
        }

        .rating-line span {
            color: var(--pms-text);
        }

        .rating-line strong {
            font-size: 13px;
        }

        .assessment-header {
            padding: 12px 14px;
            background: linear-gradient(135deg, #f5f8fc, #fff);
            border-bottom: 1px solid var(--pms-border);
        }

        .assessment-header h5 {
            font-size: 13px;
            color: var(--pms-text);
        }

        .assessment-header small {
            font-size: 9px;
            color: var(--pms-muted);
        }

        .assessment-body {
            padding: 14px;
        }

        .form-label {
            color: var(--pms-text);
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .form-select,
        .form-control {
            border-color: #dce2e9;
            border-radius: 7px;
            font-size: 11px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--pms-primary);
            box-shadow: 0 0 0 .12rem rgba(31, 78, 121, .08);
        }

        .rating-options {
            display: flex;
            gap: 5px;
            margin-bottom: 5px;
        }

        .rating-option {
            cursor: pointer;
            margin: 0;
        }

        .rating-option input {
            display: none;
        }

        .rating-option span {
            width: 35px;
            height: 35px;
            border: 1px solid #dce2e9;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: var(--pms-text);
            font-size: 12px;
            font-weight: 800;
            transition: .15s;
        }

        .rating-option span:hover {
            border-color: var(--pms-primary);
        }

        .rating-option input:checked+span {
            background: var(--pms-primary);
            border-color: var(--pms-primary);
            color: #fff;
            box-shadow: 0 3px 8px rgba(31, 78, 121, .18);
        }

        .assessment-actions {
            display: flex;
            justify-content: flex-end;
            gap: 6px;
            padding-top: 12px;
            border-top: 1px solid var(--pms-border);
        }

        .assessment-actions .btn {
            font-size: 11px;
            border-radius: 6px;
        }

        .btn-primary {
            background: var(--pms-primary);
            border-color: var(--pms-primary);
        }

        @media(max-width: 768px) {

            .compact-header,
            .employee-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
            }

            .employee-row .text-end {
                text-align: left !important;
            }

            .mini-stats {
                grid-template-columns: 1fr 1fr;
            }

            .mini-stats>div:nth-child(2) {
                border-right: 0;
            }

            .mini-stats>div:nth-child(-n+2) {
                border-bottom: 1px solid var(--pms-border);
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-item.full {
                grid-column: auto;
            }

        }

        ```css
        /* =========================================================
        GOAL WEIGHT
        ========================================================= */

        .goal-weight-badge {
            display: inline-flex;
            align-items: center;
            background: #eaf2fa;
            color: var(--pms-primary);
            border: 1px solid #d7e5f2;
            border-radius: 15px;
            padding: 3px 9px;
            font-size: 10px;
            font-weight: 800;
        }

        .weight-detail {
            background: #fffaf0;
            border-color: #f1dfb5;
        }

        .weight-detail span i {
            color: #b77900 !important;
        }

        .weight-value {
            color: #b77900 !important;
            font-size: 13px !important;
        }

        /* =========================================================
        WEIGHT INPUT
        ========================================================= */

        .weight-input-wrapper {
            position: relative;
        }

        .weight-input {
            padding-right: 32px !important;
        }

        .weight-symbol {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--pms-muted);
            font-size: 11px;
            font-weight: 700;
            pointer-events: none;
        }
    </style>

@endsection
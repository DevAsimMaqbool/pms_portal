@extends('layouts.app')

@section('content')
 @php
        $totalGoalWeightage = $reports->sum(function ($report) {
            return (float) ($report->weightage ?? 0);
        });
    @endphp
    <div class="container-fluid py-3">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="fw-bold mb-1">
                    Overall Performance Moderation
                </h4>

                <div class="text-muted small">
                    {{ $user->name ?? 'N/A' }}
                </div>
            </div>

            <a href="{{ route('goal-hr.index') }}" class="btn btn-light border btn-sm">

                <i class="fas fa-arrow-left me-1"></i>
                Back
            </a>

        </div>

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>

        @endif

        {{-- ERROR --}}
        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm">

                <strong>Please correct the following:</strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- SUMMARY --}}
        <div class="row g-3 mb-3">

            <div class="col-md-2 col-sm-6">

                <div class="summary-card">

                    <small>Goals Reviewed</small>

                    <strong>
                        {{ $reports->count() }}
                    </strong>

                </div>

            </div>

            <div class="col-md-2 col-sm-6">
                <div class="summary-card weightage">
                    <small>Total Goal Weightage</small>
                    <strong>{{ number_format($totalGoalWeightage, 2) }}<span>%</span></strong>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">

                <div class="summary-card manager">

                    <small>Manager Overall Rating</small>

                    <strong>
                        @if($managerOverallRating !== null)
                            <strong>{{ number_format($managerOverallRating*20, 2) }}<span>%</span></strong>
                        @endif
                    </strong>

                </div>

            </div>

            <div class="col-md-2 col-sm-6">
    <div class="summary-card feedback">
        <small>Line Manager Feedback</small>
        <strong>
            {{ $lineManagerAvg !== null ? number_format($lineManagerAvg, 2) : '-' }}
            @if($lineManagerAvg !== null)
                <span>%</span>
            @endif
        </strong>
    </div>
</div>

            <div class="col-md-3 col-sm-6">

                <div class="summary-card hr">

                    <small>HR Final Rating</small>

                    <strong>
                        {{ $overallReview->hr_overall_rating ?? '-' }}

                        @if($overallReview?->hr_overall_rating !== null)
                            <span>%</span>
                        @endif
                    </strong>

                </div>

            </div>

        </div>

        {{-- GOALS --}}
        <div class="card border-0 shadow-sm mb-3">

            <div class="card-header bg-white border-bottom">

                <h6 class="fw-bold mb-0">
                    Employee Goals & Manager Assessments
                </h6>

                <small class="text-muted">
                    HR can review all goals but does not approve individual goals.
                </small>

            </div>

            <div class="card-body p-0">

                @forelse($reports as $report)

                    @php

                    $managerReview = $report->reviews
                    ->where('reviewer_type', 'manager')
                    ->sortByDesc('id')
                    ->first();
                    $goalWeightage = (float) ($report->weightage ?? 0);

                    @endphp

                    <div class="goal-row">

                        <div class="goal-number">
                            {{ $loop->iteration }}
                        </div>

                        <div class="goal-content">

                            <div class="goal-title">
                                {{ $report->goal->goal ?? 'N/A' }}
                            </div>
                            <span class="weightage-badge">
                                    <i class="fas fa-balance-scale me-1"></i>
                                    Weightage: {{ number_format($goalWeightage, 2) }}%
                                </span>

                            <div class="goal-meta">

                                <span>
                                    <i class="fas fa-link me-1"></i>

                                    Driver:

                                    <strong>
                                        {{ $report->goal->s2rDriver->driver_name ?? 'N/A' }}
                                    </strong>
                                </span>

                                <!-- <span>
                                    <i class="fas fa-calendar me-1"></i>

                                    Deadline:

                                    <strong>
                                        {{ optional($report->goal->deadline)->format('d M Y') }}
                                    </strong>
                                </span> -->

                            </div>

                            <div class="goal-progress">

                                <div class="label">
                                    Employee Progress
                                </div>

                                <div class="text">
                                    {{ $report->progress_against_goal }}
                                </div>

                            </div>

                            <div class="ratings-row">

                                <div>
                                    <small>Employee Rating</small>

                                    <strong>
                                        {{ $report->rating }} / 5
                                    </strong>
                                </div>

                                <div>
                                    <small>Manager Rating</small>

                                    <strong class="manager-rating">

                                        {{ $report->manager_rating ?? '-' }}

                                        @if($report->manager_rating !== null)
                                            / 5
                                        @endif

                                    </strong>
                                </div>

                            </div>

                            @if($managerReview && $managerReview->comments)

                                <div class="manager-remarks">

                                    <div class="remarks-title">

                                        <i class="fas fa-user-tie me-1"></i>

                                        Line Manager Remarks

                                    </div>

                                    <div class="remarks-text">

                                        {{ $managerReview->comments }}

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="text-center py-5 text-muted">

                        <i class="fas fa-inbox fa-2x mb-2"></i>

                        <div>
                            No manager-approved goals found.
                        </div>

                    </div>

                @endforelse

            </div>

        </div>

        {{-- HR OVERALL MODERATION --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom">

                <div class="d-flex align-items-center gap-2">

                    <div class="hr-icon">
                        <i class="fas fa-building"></i>
                    </div>

                    <div>

                        <h6 class="fw-bold mb-0">
                            HR Overall Moderation
                        </h6>

                        <small class="text-muted">
                            Moderate the employee's overall performance.
                        </small>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('goal-hr.review', $user) }}">

                    @csrf

                    {{-- MANAGER OVERALL --}}
                    <div class="rating-summary-box mb-3">

                        <div>

                            <small>
                                Manager Overall Rating
                            </small>

                            <div class="big-rating">
@if($managerOverallRating !== null)
                                {{ $managerOverallRating * 20 ?? '-' }}

                                    <span>%</span>
                                @endif

                            </div>

                        </div>

                        <div class="text-muted small">

                            Calculated from manager ratings
                            across approved goals.

                        </div>

                    </div>

                    {{-- HR RATING --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            HR Final Overall Rating
                            <span class="text-danger">*</span>

                        </label>

                        <div class="form-group">
    <label for="hr_overall_rating">HR Overall Rating</label>

    <input
        type="number"
        name="hr_overall_rating"
        id="hr_overall_rating"
        class="form-control"
        min="0"
        max="100"
        step="any"
        value="{{ old('hr_overall_rating', $overallReview->hr_overall_rating ?? '') }}"
        placeholder="Enter rating (0–100)"
        required
    >
</div>

                    </div>

                    {{-- DECISION --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Overall Decision
                            <span class="text-danger">*</span>

                        </label>

                        <select name="decision" class="form-select" required>

                            <option value="">
                                Select Decision
                            </option>

                            <option value="approved" {{ old(
        'decision',
        $overallReview->decision ?? null
    ) === 'approved'
        ? 'selected'
        : '' }}>

                                Approve Overall Rating

                            </option>

                            <option value="rejected" {{ old(
        'decision',
        $overallReview->decision ?? null
    ) === 'rejected'
        ? 'selected'
        : '' }}>

                                Reject / Send Back

                            </option>

                        </select>

                    </div>

                    {{-- HR COMMENTS --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            HR Moderation Remarks

                        </label>

                        <textarea name="comments" rows="4" class="form-control"
                            placeholder="Enter overall moderation remarks...">{{ old(
        'comments',
        $overallReview->comments ?? ''
    ) }}</textarea>

                    </div>

                    <div class="text-end">

                        <button type="submit" class="btn btn-primary px-4">

                            <i class="fas fa-check-circle me-1"></i>

                            Save Overall Moderation

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

<style>
    /* Main summary cards */
    .summary-card {
        position: relative;
        height: 100%;
        background: #fff;
        border: 1px solid #e7edf4;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 3px 12px rgba(31, 78, 121, .05);
        transition: all .2s ease;
        overflow: hidden;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(31, 78, 121, .09);
    }

    .summary-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #1f4e79;
    }

    .summary-card.weightage::before {
        background: #6366a5;
    }

    .summary-card.manager::before {
        background: #d39e00;
    }

    .summary-card.hr::before {
        background: #198754;
    }

    .summary-card small {
        display: block;
        color: #718096;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .35px;
        margin-bottom: 8px;
    }

    .summary-card strong {
        display: block;
        color: #1f4e79;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.3;
        overflow-wrap: anywhere;
    }

    .summary-card.weightage strong {
        color: #6366a5;
    }

    .summary-card.manager strong {
        color: #b77900;
    }

    .summary-card.hr strong {
        color: #198754;
    }

    .summary-card span {
        font-size: 12px;
        font-weight: 600;
        color: #718096;
    }

    /* Main cards */
    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        padding: 16px 20px;
    }

    .card-header h6 {
        color: #253449;
        font-size: 14px;
    }

    .card-header small {
        font-size: 11px;
    }

    .card-body {
        padding: 20px;
    }

    /* Goal list */
    .goal-row {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 20px;
        border-bottom: 1px solid #edf1f5;
        transition: background .2s ease;
    }

    .goal-row:hover {
        background: #fbfcfe;
    }

    .goal-row:last-child {
        border-bottom: 0;
    }

    .goal-number {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        border-radius: 9px;
        background: #e8f1fa;
        color: #1f4e79;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
    }

    .goal-content {
        flex: 1;
        min-width: 0;
    }

    .goal-title {
        color: #253449;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .weightage-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        margin-bottom: 10px;
        border-radius: 6px;
        background: #f0f0fa;
        color: #6366a5;
        font-size: 10px;
        font-weight: 700;
    }

    .goal-meta {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        color: #718096;
        font-size: 11px;
        margin-bottom: 4px;
    }

    .goal-meta strong {
        color: #465568;
        font-weight: 600;
    }

    /* Employee progress */
    .goal-progress {
        margin-top: 13px;
        padding: 12px 14px;
        background: #f7f9fc;
        border: 1px solid #edf1f5;
        border-radius: 8px;
    }

    .goal-progress .label {
        color: #718096;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 5px;
    }

    .goal-progress .text {
        color: #344256;
        font-size: 12px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    /* Ratings */
    .ratings-row {
        display: flex;
        gap: 14px;
        margin-top: 13px;
        flex-wrap: wrap;
    }

    .ratings-row > div {
        min-width: 125px;
        padding: 10px 13px;
        background: #f8fafc;
        border: 1px solid #edf1f5;
        border-radius: 8px;
    }

    .ratings-row small {
        display: block;
        color: #718096;
        font-size: 10px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .ratings-row strong {
        display: block;
        color: #1f4e79;
        font-size: 17px;
        font-weight: 800;
    }

    .ratings-row .manager-rating {
        color: #b77900;
    }

    /* Manager remarks */
    .manager-remarks {
        margin-top: 13px;
        padding: 13px 15px;
        background: #fffaf0;
        border: 1px solid #f5e8c6;
        border-left: 4px solid #b77900;
        border-radius: 8px;
    }

    .remarks-title {
        color: #8a6200;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .remarks-text {
        color: #4a5568;
        font-size: 12px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    /* HR moderation section */
    .hr-icon {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 10px;
        background: #e7f6ed;
        color: #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .rating-summary-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        background: #f8fafc;
        border: 1px solid #e7edf4;
        border-radius: 10px;
        padding: 16px 18px;
    }

    .rating-summary-box small {
        display: block;
        color: #718096;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .3px;
        margin-bottom: 5px;
    }

    .big-rating {
        color: #b77900;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.4;
    }

    .big-rating span {
        color: #718096;
        font-size: 12px;
        font-weight: 600;
    }

    /* Form controls */
    .form-label {
        color: #344256;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .form-control,
    .form-select {
        min-height: 42px;
        border: 1px solid #dce3eb;
        border-radius: 8px;
        color: #344256;
        font-size: 13px;
        box-shadow: none;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    textarea.form-control {
        min-height: auto;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #5b8dbb;
        box-shadow: 0 0 0 3px rgba(31, 78, 121, .09);
    }

    .btn-primary {
        background: #1f4e79;
        border-color: #1f4e79;
        border-radius: 8px;
        padding-top: 10px;
        padding-bottom: 10px;
        font-size: 12px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .btn-primary:hover {
        background: #163b60;
        border-color: #163b60;
        transform: translateY(-1px);
    }

    .btn-light {
        border-radius: 7px;
        font-weight: 600;
    }
    .summary-card.feedback::before {
    background: #6366a5;
}

.summary-card.feedback strong {
    color: #6366a5;
}

    /* Responsive */
    @media (max-width: 768px) {
        .summary-card {
            padding: 14px;
        }

        .summary-card strong {
            font-size: 21px;
        }

        .goal-row {
            padding: 14px;
            gap: 10px;
        }

        .goal-meta {
            gap: 8px;
            flex-direction: column;
        }

        .ratings-row {
            gap: 8px;
        }

        .ratings-row > div {
            flex: 1;
            min-width: 0;
        }

        .rating-summary-box {
            align-items: flex-start;
            flex-direction: column;
        }

        .card-header {
            padding: 14px;
        }

        .card-body {
            padding: 14px;
        }
    }

    @media (max-width: 480px) {
        .goal-number {
            width: 28px;
            height: 28px;
            flex-basis: 28px;
        }

        .goal-title {
            font-size: 13px;
        }

        .summary-card strong {
            font-size: 19px;
        }

        .big-rating {
            font-size: 22px;
        }
    }
</style>

@endsection
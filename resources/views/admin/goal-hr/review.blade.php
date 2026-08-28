@extends('layouts.app')

@section('content')

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

            <div class="col-md-4">

                <div class="summary-card">

                    <small>Goals Reviewed</small>

                    <strong>
                        {{ $reports->count() }}
                    </strong>

                </div>

            </div>

            <div class="col-md-4">

                <div class="summary-card manager">

                    <small>Manager Overall Rating</small>

                    <strong>
                        {{ $managerOverallRating ?? '-' }}

                        @if($managerOverallRating !== null)
                            <span>/ 5</span>
                        @endif
                    </strong>

                </div>

            </div>

            <div class="col-md-4">

                <div class="summary-card hr">

                    <small>HR Final Rating</small>

                    <strong>
                        {{ $overallReview->hr_overall_rating ?? '-' }}

                        @if($overallReview?->hr_overall_rating !== null)
                            <span>/ 5</span>
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

                    <div class="goal-row">

                        <div class="goal-number">
                            {{ $loop->iteration }}
                        </div>

                        <div class="goal-content">

                            <div class="goal-title">
                                {{ $report->goal->goal ?? 'N/A' }}
                            </div>

                            <div class="goal-meta">

                                <span>
                                    <i class="fas fa-link me-1"></i>

                                    Driver:

                                    <strong>
                                        {{ $report->goal->s2rDriver->name ?? 'N/A' }}
                                    </strong>
                                </span>

                                <span>
                                    <i class="fas fa-calendar me-1"></i>

                                    Deadline:

                                    <strong>
                                        {{ optional($report->goal->deadline)->format('d M Y') }}
                                    </strong>
                                </span>

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

                            @php

                                $managerReview = $report->reviews
                                    ->where('reviewer_type', 'manager')
                                    ->sortByDesc('id')
                                    ->first();

                            @endphp

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

                                {{ $managerOverallRating ?? '-' }}

                                @if($managerOverallRating !== null)
                                    <span>/ 5</span>
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

                        <div class="hr-rating-options">

                            @for($i = 0; $i <= 5; $i++)

                                                    <label>

                                                        <input type="radio" name="hr_overall_rating" value="{{ $i }}" {{ old(
                                    'hr_overall_rating',
                                    $overallReview->hr_overall_rating ?? null
                                ) == $i ? 'checked' : '' }} required>

                                                        <span>
                                                            {{ $i }}
                                                        </span>

                                                    </label>

                            @endfor

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
        .summary-card {
            background: #fff;
            border: 1px solid #e7edf4;
            border-radius: 10px;
            padding: 14px;
            box-shadow: 0 2px 8px rgba(31, 78, 121, .04);
        }

        .summary-card small {
            display: block;
            color: #718096;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .summary-card strong {
            color: #1f4e79;
            font-size: 24px;
        }

        .summary-card.manager strong {
            color: #b77900;
        }

        .summary-card.hr strong {
            color: #198754;
        }

        .summary-card span {
            font-size: 11px;
            color: #718096;
        }

        .goal-row {
            display: flex;
            gap: 12px;
            padding: 16px;
            border-bottom: 1px solid #edf1f5;
        }

        .goal-row:last-child {
            border-bottom: 0;
        }

        .goal-number {
            width: 30px;
            height: 30px;
            flex: 0 0 30px;
            border-radius: 8px;
            background: #e8f1fa;
            color: #1f4e79;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
        }

        .goal-content {
            flex: 1;
            min-width: 0;
        }

        .goal-title {
            color: #253449;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .goal-meta {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            color: #718096;
            font-size: 11px;
        }

        .goal-progress {
            margin-top: 10px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 7px;
        }

        .goal-progress .label {
            color: #718096;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .goal-progress .text {
            color: #253449;
            font-size: 12px;
        }

        .ratings-row {
            display: flex;
            gap: 25px;
            margin-top: 10px;
        }

        .ratings-row small {
            display: block;
            color: #718096;
            font-size: 10px;
        }

        .ratings-row strong {
            display: block;
            color: #1f4e79;
            font-size: 16px;
        }

        .ratings-row .manager-rating {
            color: #b77900;
        }

        .manager-remarks {
            margin-top: 10px;
            padding: 10px 12px;
            background: #fffaf0;
            border-left: 3px solid #b77900;
            border-radius: 6px;
        }

        .remarks-title {
            color: #8a6200;
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .remarks-text {
            color: #4a5568;
            font-size: 12px;
            line-height: 1.5;
        }

        .rating-summary-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            background: #f8fafc;
            border: 1px solid #e7edf4;
            border-radius: 8px;
            padding: 12px 15px;
        }

        .rating-summary-box small {
            display: block;
            color: #718096;
            font-size: 10px;
            font-weight: 700;
        }

        .big-rating {
            color: #b77900;
            font-size: 24px;
            font-weight: 800;
        }

        .big-rating span {
            color: #718096;
            font-size: 11px;
        }

        .hr-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #e7f6ed;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hr-rating-options {
            display: flex;
            gap: 8px;
        }

        .hr-rating-options label {
            cursor: pointer;
        }

        .hr-rating-options input {
            display: none;
        }

        .hr-rating-options span {
            width: 48px;
            height: 48px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            background: #fff;
        }

        .hr-rating-options input:checked+span {
            background: #198754;
            border-color: #198754;
            color: #fff;
        }

        @media(max-width:768px) {

            .rating-summary-box {
                align-items: flex-start;
                flex-direction: column;
            }

            .goal-row {
                padding: 12px;
            }

            .goal-meta {
                gap: 8px;
            }

        }
    </style>

@endsection
@extends('layouts.app')

@section('content')

    <div class="container-fluid py-3">

        <div class="mb-3">

            <h4 class="fw-bold mb-1">
                Overall Performance Moderation
            </h4>

            <p class="text-muted small mb-0">
                Review manager assessments and moderate employee overall ratings.
            </p>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                @forelse($employees as $employee)

                    @php

                        $reports = $employee->goalSelfReports;

                        $managerRatings = $reports
                            ->pluck('manager_rating')
                            ->filter(fn($rating) => $rating !== null);

                        $managerOverall = $managerRatings->count()
                            ? round($managerRatings->avg(), 2)
                            : null;

                        $overallReview = $employee->goalOverallReviews->first();

                    @endphp

                    <div class="employee-row">

                        <div class="employee-info">

                            <div class="employee-avatar">
                                <i class="fas fa-user"></i>
                            </div>

                            <div>

                                <div class="employee-name">
                                    {{ $employee->name }}
                                </div>

                                <small class="text-muted">
                                    {{ $reports->count() }} manager-reviewed goal(s)
                                </small>

                            </div>

                        </div>

                        <div class="rating-box">

                            <small>
                                Manager Overall
                            </small>

                            <strong>
                                {{ $managerOverall ?? '-' }}

                                @if($managerOverall !== null)
                                    / 5
                                @endif
                            </strong>

                        </div>

                        <div class="rating-box hr">

                            <small>
                                HR Overall
                            </small>

                            <strong>
                                {{ $overallReview->hr_overall_rating ?? '-' }}

                                @if($overallReview?->hr_overall_rating !== null)
                                    / 5
                                @endif
                            </strong>

                        </div>

                        <a href="{{ route('goal-hr.show', $employee) }}"
                           class="btn btn-primary btn-sm">

                            <i class="fas fa-eye me-1"></i>

                            Review Overall

                        </a>

                    </div>

                @empty

                    <div class="text-center py-5 text-muted">

                        No employees are currently ready for HR moderation.

                    </div>

                @endforelse

            </div>

        </div>

        <div class="mt-3">

            {{ $employees->links() }}

        </div>

    </div>

    <style>

    .employee-row {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 14px 16px;
        border-bottom: 1px solid #edf1f5;
    }

    .employee-row:last-child {
        border-bottom: 0;
    }

    .employee-info {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }

    .employee-avatar {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #e8f1fa;
        color: #1f4e79;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .employee-name {
        color: #253449;
        font-size: 13px;
        font-weight: 700;
    }

    .rating-box {
        min-width: 110px;
    }

    .rating-box small {
        display: block;
        color: #718096;
        font-size: 9px;
    }

    .rating-box strong {
        color: #b77900;
        font-size: 16px;
    }

    .rating-box.hr strong {
        color: #198754;
    }

    @media(max-width:768px) {

        .employee-row {
            align-items: flex-start;
            flex-direction: column;
            gap: 10px;
        }

        .rating-box {
            min-width: auto;
        }

        .employee-row .btn {
            width: 100%;
        }

    }

    </style>

@endsection
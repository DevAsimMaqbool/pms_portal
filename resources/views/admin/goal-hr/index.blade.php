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

        {{-- DEPARTMENT FILTER --}}
<div class="card border-0 shadow-sm mb-3">

    <div class="card-body py-2">

        <form method="GET"
              action="{{ route('goal-hr.index') }}"
              class="row align-items-end g-2">

            <div class="col-md-4">

                <label class="form-label mb-1">
                    Search by Department
                </label>

                <select name="department"
        id="department"
        class="form-select form-select-sm">

    <option value="">All Departments</option>

    @foreach($departments as $department)
        <option value="{{ $department }}"
            {{ request('department') == $department ? 'selected' : '' }}>
            {{ $department }}
        </option>
    @endforeach

</select>

            </div>

            @if(request('department'))

                <div class="col-md-auto">

                    <a href="{{ route('goal-hr.index') }}"
                       class="btn btn-light border btn-sm">

                        <i class="fas fa-times me-1"></i>
                        Clear

                    </a>

                </div>

            @endif

        </form>

    </div>

</div>

        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                @forelse($employees as $employee)

                    @php

    $reports = $employee->goalSelfReports;

    /*
    |--------------------------------------------------------------------------
    | Self Overall Rating
    |--------------------------------------------------------------------------
    */

    $selfRatings = $reports
        ->pluck('rating')
        ->filter(fn($rating) => $rating !== null);

    $selfOverall = $selfRatings->count()
        ? round($selfRatings->avg(), 2)
        : null;

    /*
    |--------------------------------------------------------------------------
    | Manager Overall Rating
    |--------------------------------------------------------------------------
    */

    $managerRatings = $reports
        ->pluck('manager_rating')
        ->filter(fn($rating) => $rating !== null);

    $managerOverall = $managerRatings->count()
        ? round($managerRatings->avg(), 2)
        : null;

    /*
    |--------------------------------------------------------------------------
    | HR Overall Rating
    |--------------------------------------------------------------------------
    */

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

        <div class="employee-meta">

            <span>
                <i class="fas fa-building me-1"></i>
                {{ $employee->hr_department_name ?? 'No Department' }}
            </span>

            <span>
                <i class="fas fa-user-tie me-1"></i>
                Manager:
                {{ $employee->manager_name ?? 'No Manager' }}
            </span>

        </div>

        <small class="text-muted">
            {{ $reports->count() }} manager-reviewed goal(s)
        </small>

    </div>

</div>
{{-- SELF OVERALL --}}
<div class="rating-box self">

    <small>
        Self Overall
    </small>

    <strong>
        {{ $selfOverall ?? '-' }}

        @if($selfOverall !== null)
            / 5
        @endif
    </strong>

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
.employee-meta {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 3px;
    margin-bottom: 3px;
    flex-wrap: wrap;
}

.employee-meta span {
    color: #718096;
    font-size: 10px;
    font-weight: 500;
}

.employee-meta i {
    color: #1f4e79;
    font-size: 9px;
}
.rating-box.self strong {
    color: #1f4e79;
}
    </style>

@endsection
@push('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {

        $('#department').select2({
            placeholder: 'Search Department',
            allowClear: true,
            width: '100%'
        });

        $('#department').on('change', function () {
            $(this).closest('form').submit();
        });

    });
</script>
@endpush
@extends('layouts.app')

@push('style')

<link rel="stylesheet"
      href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />

<link rel="stylesheet"
      href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />

<link rel="stylesheet"
      href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />

<link rel="stylesheet"
      href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />

<link rel="stylesheet"
      href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />

<link rel="stylesheet"
      href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

<link rel="stylesheet"
      href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />

<link rel="stylesheet"
      href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />

<style>

/* =========================================================
   TOP EMPLOYEE SELECTION
========================================================= */

.rating-form-header {
    margin-bottom: 20px;
}

.rating-form-header h5 {
    margin-bottom: 5px;
    font-weight: 600;
}

.rating-form-header p {
    margin-bottom: 0;
    color: #6f6b7d;
    font-size: 13px;
}

.employee-selection {
    padding: 18px;
    margin-bottom: 10px;
    border: 1px solid #e7e7e9;
    border-radius: 8px;
    background: #fafafa;
}

.employee-selection .form-label {
    font-weight: 600;
    margin-bottom: 7px;
}

/* =========================================================
   QUESTIONS WRAPPER
========================================================= */

.rating-questions-wrapper {
    width: 100%;
    padding: 5px;
}

.rating-questions-wrapper .row.g-3 {
    margin-bottom: 0;
}

/* =========================================================
   SECTION HEADING
========================================================= */

.rating-section-title {
    width: 100%;
    margin: 22px 0 12px !important;
    padding: 8px 12px;

    border-left: 4px solid var(--bs-primary);
    background: rgba(var(--bs-primary-rgb), 0.06);
    border-radius: 4px;

    color: #444050;
    font-size: 14px !important;
    font-weight: 700 !important;
}

/* =========================================================
   QUESTION CARD
========================================================= */

.rating-question {
    width: 100%;
    height: 100%;
    min-height: 145px;

    padding: 12px;

    border: 1px solid #e2e2e5;
    border-radius: 7px;

    background: #fff;

    display: flex;
    flex-direction: column;
    justify-content: space-between;

    transition: all 0.2s ease;
}

.rating-question:hover {
    border-color: rgba(var(--bs-primary-rgb), 0.35);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
}

/* =========================================================
   QUESTION TEXT
========================================================= */

.rating-question-text {
    display: flex;
    align-items: flex-start;

    width: 100%;
    height: 55px;
    min-height: 55px;

    margin: 0 0 10px !important;

    color: #444050;

    font-size: 11px;
    font-weight: 600;
    line-height: 1.4;
}

/* =========================================================
   RATING OPTIONS
========================================================= */

.rating-options {
    width: 100%;

    display: flex;
    align-items: stretch;

    gap: 6px;

    margin-top: auto;
}

/* =========================================================
   RATING RECTANGLE
========================================================= */

.rating-options label {
    flex: 1 1 0;
    min-width: 0;
    min-height: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin: 0 !important;
    padding: 5px 8px;

    border: 1px solid #dedee1;
    border-radius: 5px;

    background: #fff;
    color: #6f6b7d;

    font-size: 11px;
    font-weight: 500;

    line-height: 1;
    text-align: center;

    cursor: pointer;

    transition:
        background-color 0.2s ease,
        border-color 0.2s ease,
        color 0.2s ease,
        box-shadow 0.2s ease;
}

/* =========================================================
   HIDE DEFAULT RADIO
========================================================= */

.rating-options input[type="radio"] {
    display: none;
}

/* =========================================================
   HOVER
========================================================= */

.rating-options label:hover {
    border-color: var(--bs-primary);
    background: rgba(var(--bs-primary-rgb), 0.06);
    color: var(--bs-primary);
}

/* =========================================================
   SELECTED RATING
========================================================= */

.rating-options label:has(input[type="radio"]:checked) {
    background: var(--bs-primary);
    border-color: var(--bs-primary);
    color: #fff;
    font-weight: 600;

    box-shadow: 0 2px 6px rgba(var(--bs-primary-rgb), 0.25);
}

/* =========================================================
   REMARKS
========================================================= */

.rating-remarks {
    width: 100%;

    margin-top: 25px;
    margin-bottom: 20px;
}

.rating-remarks label {
    display: block;

    margin-bottom: 8px;

    color: #444050;

    font-weight: 600;
}

.rating-remarks textarea {
    width: 100%;

    min-height: 120px;

    resize: vertical;
}

/* =========================================================
   SUBMIT BUTTON
========================================================= */

.rating-submit {
    width: 100%;

    display: flex;
    justify-content: flex-end;

    margin-top: 10px;
}

.rating-submit .btn {
    min-width: 130px;
}

/* =========================================================
   LARGE DESKTOP
========================================================= */

@media (min-width: 1400px) {

    .rating-question {
        min-height: 145px;
    }

    .rating-question-text {
        font-size: 13px;
    }

    .rating-options {
        gap: 6px;
    }

    .rating-options label {
        font-size: 11px;
    }
}

/* =========================================================
   MEDIUM DESKTOP
========================================================= */

@media (max-width: 1200px) {

    .rating-question {
        min-height: 150px;
        padding: 11px;
    }

    .rating-question-text {
        height: 58px;
        min-height: 58px;
        font-size: 10px;
    }

    .rating-options {
        gap: 5px;
    }

    .rating-options label {
        min-height: 33px;
        padding: 3px 4px;
        font-size: 10px;
    }
}

/* =========================================================
   TABLET
========================================================= */

@media (max-width: 991px) {

    .rating-question {
        min-height: 145px;
    }

    .rating-question-text {
        height: auto;
        min-height: 48px;
        font-size: 10px;
    }

    .rating-options {
        gap: 5px;
    }

    .rating-options label {
        font-size: 9px;
    }
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 767px) {

    .employee-selection {
        padding: 15px;
    }

    .rating-question {
        min-height: auto;
        padding: 12px;
    }

    .rating-question-text {
        height: auto;
        min-height: auto;
        margin-bottom: 10px !important;
        font-size: 11px;
    }

    .rating-options {
        flex-wrap: wrap;
        gap: 5px;
    }

    .rating-options label {
        flex: 1 1 calc(50% - 3px);
        min-height: 34px;
        font-size: 10px;
    }

    .rating-submit {
        justify-content: stretch;
    }

    .rating-submit .btn {
        width: 100%;
    }
}

/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 480px) {

    .rating-options label {
        flex: 1 1 100%;
    }
}

</style>

@endpush

@section('content')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-datatable table-responsive card-body">

            <!-- Header -->
            <div class="rating-form-header">

                <h5>
                    Edit Team Member Rating
                </h5>

                <p>
                    Update your assessment based on the following competencies.
                </p>

            </div>

            <form id="researchForm" class="row" method="POST"
            action="{{ route('employee.goalfeedback.update', $feedback->id) }}">

                @csrf

                <!-- =====================================================
                     YEAR + FACULTY MEMBER
                ====================================================== -->

                <div class="row g-3 employee-selection">

                    <div class="col-md-6">

                        <label for="year_id"
                               class="form-label">

                            Year

                        </label>

                        <select name="year_id"
                                id="year_id"
                                class="form-select"
                                required>

                            <option value="">
                                Select year
                            </option>

                            @foreach(SelectCurrentYear(1) as $year)

                                <option value="{{ $year->id }}"
                                    {{ old('year_id', $feedback->year_id) == $year->id ? 'selected' : '' }}>

                                    {{ $year->year }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label"
                               for="select2Success">

                            Name of Faculty Member

                        </label>

                        <select name="employee_id"
                                id="select2Success"
                                class="select2 form-select"
                                required>

                            <option value="">
                                -- Select Faculty Member --
                            </option>

                            @foreach($facultyMembers as $member)

                                <option value="{{ $member->id }}"
                                        data-department="{{ $member->department }}"
                                        data-job_title="{{ $member->job_title }}"
                                    {{ old('employee_id', $feedback->employee_id) == $member->id ? 'selected' : '' }}>

                                    {{ $member->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <!-- =====================================================
                     QUESTIONS
                ====================================================== -->

                <div class="rating-questions-wrapper">

                    <!-- =================================================
                         SECTION 1
                    ================================================== -->

                    <h6 class="rating-section-title">
                        1- Responsibility & Accountability
                    </h6>

                    <div class="row g-3">

                        <!-- QUESTION 1 -->

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member delivers what they commit to, on time, and owns the result.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="responsibility_accountability_2"
                                                   value="{{ $value }}"
                                                {{ old('responsibility_accountability_2', $feedback->responsibility_accountability_2) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <!-- QUESTION 2 -->

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member meets deadlines for teaching, administrative, and committee obligations without requiring follow-up.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="responsibility_accountability_1"
                                                   value="{{ $value }}"
                                                {{ old('responsibility_accountability_1', $feedback->responsibility_accountability_1) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <!-- QUESTION 3 -->

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member takes ownership of outcomes, including when things do not go as planned.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="responsibility_accountability_3"
                                                   value="{{ $value }}"
                                                {{ old('responsibility_accountability_3', $feedback->responsibility_accountability_3) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- =================================================
                         SECTION 2
                    ================================================== -->

                    <h6 class="rating-section-title">
                        2- Honesty & Integrity
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member acts consistently according to stated principles, even under pressure.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="honesty_integrity_1"
                                                   value="{{ $value }}"
                                                {{ old('honesty_integrity_1', $feedback->honesty_integrity_1) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member can be trusted to do the right thing when no one is watching.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="honesty_integrity_2"
                                                   value="{{ $value }}"
                                                {{ old('honesty_integrity_2', $feedback->honesty_integrity_2) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member is transparent and forthcoming in professional and academic matters.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="honesty_integrity_3"
                                                   value="{{ $value }}"
                                                {{ old('honesty_integrity_3', $feedback->honesty_integrity_3) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- =================================================
                         SECTION 3
                    ================================================== -->

                    <h6 class="rating-section-title">
                        3- Empathy & Compassion
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member shows genuine concern for students' and colleagues' wellbeing.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="empathy_compassion_1"
                                                   value="{{ $value }}"
                                                {{ old('empathy_compassion_1', $feedback->empathy_compassion_1) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member is approachable and responsive to the needs of those around them.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="empathy_compassion_2"
                                                   value="{{ $value }}"
                                                {{ old('empathy_compassion_2', $feedback->empathy_compassion_2) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- =================================================
                         SECTION 4
                    ================================================== -->

                    <h6 class="rating-section-title">
                        4- Humility & Service
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member offers help to others without expecting recognition or credit.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="humility_service_1"
                                                   value="{{ $value }}"
                                                {{ old('humility_service_1', $feedback->humility_service_1) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member willingly takes on service and responsibilities beyond their formal role.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="humility_service_2"
                                                   value="{{ $value }}"
                                                {{ old('humility_service_2', $feedback->humility_service_2) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member accepts feedback constructively and shares credit generously.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="humility_service_3"
                                                   value="{{ $value }}"
                                                {{ old('humility_service_3', $feedback->humility_service_3) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- =================================================
                         SECTION 5
                    ================================================== -->

                    <h6 class="rating-section-title">
                        5- Courage & Drive
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member takes initiative on new ideas, even when the outcome is uncertain.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="inspirational_leadership_1"
                                                   value="{{ $value }}"
                                                {{ old('inspirational_leadership_1', $feedback->inspirational_leadership_1) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member raises concerns or proposes change when something needs to improve.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="inspirational_leadership_2"
                                                   value="{{ $value }}"
                                                {{ old('inspirational_leadership_2', $feedback->inspirational_leadership_2) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    This staff member pushes improvement forward even when it is uncomfortable or new.

                                </label>

                                <div class="rating-options">

                                    @foreach([20 => 1, 40 => 2, 60 => 3, 80 => 4, 100 => 5] as $value => $rating)

                                        <label>

                                            <input type="radio"
                                                   name="inspirational_leadership_3"
                                                   value="{{ $value }}"
                                                {{ old('inspirational_leadership_3', $feedback->inspirational_leadership_3) == $value ? 'checked' : '' }}>

                                            {{ $rating }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- =================================================
                         REMARKS
                    ================================================== -->

                    <div class="rating-remarks">

                        <label>
                            Remarks*
                        </label>

                        <textarea name="remarks"
                                  class="form-control"
                                  required
                                  placeholder="Please provide details of the assigned task(s) and the employee’s designated role and responsibilities during the event.">{{ old('remarks', $feedback->remarks) }}</textarea>

                    </div>

                    <!-- =================================================
                         SUBMIT
                    ================================================== -->

                    <div class="rating-submit">

                        <button type="submit"
                                class="btn btn-primary waves-effect waves-light">

                            UPDATE

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>
<!-- / Content -->

@endsection

@push('script')

<script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

<script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>

<script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js')}}"></script>

<script src="{{ asset('admin/assets/js/forms-tagify.js')}}"></script>

@endpush
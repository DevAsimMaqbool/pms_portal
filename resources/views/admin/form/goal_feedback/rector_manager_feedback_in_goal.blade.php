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
   SAME HEIGHT FOR ALL QUESTIONS
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

    /* SPACE BETWEEN EACH RATING */
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
   HIDE DEFAULT RADIO CIRCLE
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
   WHOLE RECTANGLE BECOMES SELECTED
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
                    Rate your Team Member
                </h5>

                <p>
                    Please provide your assessment based on the following competencies.
                </p>

            </div>

            <form id="researchForm"
                  enctype="multipart/form-data"
                  class="row">

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

                                <option value="{{ $year->id }}">
                                    {{ $year->year }}-2026
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label"
                               for="multicol-language">

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
                                        {{ request('employee_id') == $member->id ? 'selected' : '' }}>

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

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Takes clear ownership of the outcomes of their function and ensures commitments are translated into measurable results.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_2"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_2"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_2"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_2"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_2"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Anticipates risks, addresses challenges proactively, and remains accountable for outcomes, including when results fall short of expectations.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_1"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_1"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_1"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_1"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_1"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Ensures that strategic and operational commitments within their area are delivered with discipline, consistency and appropriate follow-through.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_3"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_3"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_3"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_3"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="responsibility_accountability_3"
                                               value="100">
                                        5
                                    </label>

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

                                    Demonstrates integrity and ethical judgment in decisions, particularly when faced with pressure, competing interests or difficult choices.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_1"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_1"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_1"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_1"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_1"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Promotes transparency and ensures that decisions, information and institutional matters are communicated honestly and responsibly.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_2"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_2"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_2"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_2"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_2"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Consistently acts in the best interests of the institution and upholds its principles even when doing so is difficult or personally inconvenient.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_3"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_3"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_3"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_3"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="honesty_integrity_3"
                                               value="100">
                                        5
                                    </label>

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

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Demonstrates genuine understanding of the needs, concerns and perspective of his/her team, line manager and other stakeholders when making decisions.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_1"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_1"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_1"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_1"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_1"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Creates an environment in which people feel heard, respected and appropriately supported while maintaining accountability for performance.
                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_2"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_2"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_2"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_2"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_2"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Balances institutional priorities with compassion and fairness, particularly when dealing with people-related challenges or difficult circumstances.
                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_3"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_3"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_3"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_3"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="empathy_compassion_3"
                                               value="100">
                                        5
                                    </label>

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

                                    Places institutional purpose and collective success above personal recognition, position or credit.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="humility_service_1"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_1"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_1"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_1"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_1"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Actively supports colleagues and other functions, promotes collaboration and contributes beyond the boundaries of their own portfolio when institutional priorities require it.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="humility_service_2"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_2"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_2"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_2"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_2"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Remains open to feedback, acknowledges the contributions of others and demonstrates a willingness to learn, adapt and share credit.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="humility_service_3"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_3"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_3"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_3"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="humility_service_3"
                                               value="100">
                                        5
                                    </label>

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

                                    Demonstrates the courage to make timely and well-considered decisions, even in situations involving uncertainty, complexity or resistance.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_1"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_1"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_1"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_1"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_1"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Constructively challenges the status quo and initiates meaningful improvements that advance institutional priorities.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_2"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_2"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_2"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_2"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_2"
                                               value="100">
                                        5
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="rating-question">

                                <label class="rating-question-text">

                                    Demonstrates persistence and determination in translating strategic priorities into action, particularly when implementation is difficult or requires change.

                                </label>

                                <div class="rating-options">

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_3"
                                               value="20">
                                        1
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_3"
                                               value="40">
                                        2
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_3"
                                               value="60">
                                        3
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_3"
                                               value="80">
                                        4
                                    </label>

                                    <label>
                                        <input type="radio"
                                               name="inspirational_leadership_3"
                                               value="100">
                                        5
                                    </label>

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
                                  placeholder="Please provide details of the assigned task(s) and the employee’s designated role and responsibilities during the event."></textarea>

                    </div>

                    <!-- =================================================
                         SUBMIT
                    ================================================== -->

                    <div class="rating-submit">

                        <button type="submit"
                                class="btn btn-primary waves-effect waves-light">

                            SUBMIT

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

@push('script')

<script>

$(document).ready(function () {

    // Submit form
    $('#researchForm').on('submit', function (e) {

        e.preventDefault();

        let form = $(this);

        let formData = new FormData(this);

        let hasError = false;

        // ======== CLIENT-SIDE VALIDATION ========

        $('.form-control, .form-select').removeClass('is-invalid');

        form.find('input[required], select[required]').each(function () {

            if (!$(this).val()) {

                $(this).addClass('is-invalid');

                hasError = true;

            }

        });

        if (hasError) {

            Swal.fire({

                icon: 'error',

                title: 'Validation Error',

                text: 'Please fill all required fields before submitting.'

            });

            return false;

        }

        // ======== AJAX REQUEST ========

        $.ajax({

            url: "{{ route('employee.goalfeedback.store') }}",

            type: "POST",

            data: formData,

            contentType: false,

            processData: false,

            beforeSend: function () {

                Swal.fire({

                    title: 'Processing...',

                    text: 'Please wait while we save your data.',

                    allowOutsideClick: false,

                    didOpen: () => Swal.showLoading()

                });

            },

            success: function (response) {

                Swal.close();

                Swal.fire({

                    icon: 'success',

                    title: 'Success',

                    text: response.message

                }).then(() => {

                    window.location.href =
                        "{{ route('employee.goalfeedback.index') }}";

                });

                form[0].reset();

                $('#extraFieldContainer').empty();

            },

            error: function (xhr) {

                Swal.close();

                if (xhr.status === 422) {

                    let errors = xhr.responseJSON.errors;

                    let errorMsg = '';

                    $.each(errors, function (key, value) {

                        errorMsg += value[0] + '\n';

                        $('[name="' + key + '"]').addClass('is-invalid');

                    });

                    Swal.fire({

                        icon: 'error',

                        title: 'Validation Failed',

                        text: errorMsg

                    });

                } else {

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'Something went wrong! Please try again later.'

                    });

                }

            }

        });

    });

});

</script>

@endpush
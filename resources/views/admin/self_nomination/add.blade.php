@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.css') }}" />

 
  <style>
    .bg-orange {
      background-color: #fd7e13 !important;
      color: #fd7e13 !important
    }

    .bg-label-orange {
      background-color: color-mix(in sRGB, var(--bs-paper-bg) var(--bs-bg-label-tint-amount), var(--bs-orange)) !important;
      color: var(--bs-orange) !important;
    }





    /* Wrapper provides positioning and responsive height */
    .flip-card {
      position: relative;
      /* required for absolutely-positioned children */
      width: 100%;
      /* Modern browsers: maintain aspect ratio. Change to suit your card shape. */
      aspect-ratio: 4 / 3;
      /* fallback used when supported */
      overflow: visible;
      perspective: 1000px;
    }

    /* Fallback for browsers that don't support aspect-ratio */
    @supports not (aspect-ratio: 1/1) {
      .flip-card {
        /* 75% gives a 4:3 box. Adjust to 100% for square (padding-top:100%) or 56.25% for 16:9 */
        padding-top: 75%;
      }

      /* Place inner absolutely to fill the padded container */
      .flip-card-inner {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
      }
    }

    /* Inner container handles the flip transform */
    .flip-card-inner {
      position: relative;
      /* relative by default, but absolute in fallback above */
      width: 100%;
      height: 100%;
      transition: transform 0.6s;
      transform-style: preserve-3d;
    }

    /* Hover flip — works on desktop; keep for keyboard focus if desired */
    .flip-card:hover .flip-card-inner,
    .flip-card:focus-within .flip-card-inner {
      transform: rotateY(180deg);
    }

    /* FRONT & BACK faces — fill parent and stack */
    .flip-card-front,
    .flip-card-back {
      position: absolute;
      inset: 0;
      /* shorthand for top:0; right:0; bottom:0; left:0 */
      backface-visibility: hidden;
      -webkit-backface-visibility: hidden;
      border-radius: .5rem;
      /* matches Bootstrap card rounding */
      overflow: hidden;
    }

    /* Ensure card visuals (bootstrap h-100 won't break) */
    .flip-card-front .card,
    .flip-card-back .card {
      height: 100%;
      border: 0;
    }

    /* Back side flipped */
    .flip-card-back {
      transform: rotateY(180deg);
    }

    /* Optional: improve mobile UX — reduce 3D motion and use a vertical flip on narrow screens */
    @media (max-width: 575.98px) {
      .flip-card {
        aspect-ratio: 3 / 2;
        /* make card a little taller on phones if you like */
      }

      
    }
  </style>
@endpush
<style>
    .form-check {
        margin-bottom: 8px;
    }

    .row-bordered>[class*="col-"] {
        border: none !important;
    }
    
</style>


@section('content')
            <div class="container-xxl flex-grow-1 container-p-y">

                <div class="card p-3">

                    {{-- Employee Info --}}
                    <div class="col-lg-12 col-md-4 col-sm-4">
                        <div class="card" style="box-shadow: none; background: none;">
                            <div class="card-header text-center">
                                <div class="card-title mb-0">
                                    <div class="rounded p-3" style="text-align: left; background-color: #f8f9fa;">
                                        <p class="mb-1"><b>Employee Code:</b> <span
                                                class="text-muted">{{ Auth::user()->barcode }}</span></p>
                                        <p class="mb-1"><b>Name:</b> <span
                                                class="text-muted">{{ trim(preg_replace('/[-\s]*\d+$/', '', Auth::user()->name)) }}</span>
                                        </p>
                                        <p class="mb-1"><b>Designation:</b> <span
                                                class="text-muted">{{ Auth::user()->job_title }}</span></p>
                                        <p class="mb-1"><b>Department:</b> <span
                                                class="text-muted">{{ Auth::user()->department }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Performance Summary --}}
                    <div class="rounded p-3 text-center mb-3">
                        <p class="mb-1">
                        <h5>Your Performance Summary FTY 2025 - 2026</h5>
                        <span style="font-size: smaller;">Your performance against mentioned areas is as follows:</span>
                        </p>
                    </div>

                    {{-- KPAs --}}
                    <div class="row">
                        @php
                         $kpaAverages = getTopIndicatorsOfEmployee(Auth::user()->employee_id);
                        @endphp

                   
                        
                    </div>
                    <div class="row gy-6">

                     
                        @foreach ($kpaAverages as $kpa)
                            @php
                                $kpaAvgWeightage = kpaAvgWeightage($kpa['kpa_id'], 21);
                                $weight = $kpaAvgWeightage['kpa_weightage'];

                                $avg = $kpa['avg'];
                                $weight_ss = ($avg * $weight) / 100;
                                $schroll_sgetRatingByPercentage = getRatingByPercentage($avg);
                                $schroll_rating_description = $schroll_sgetRatingByPercentage['description'];
                            @endphp
                            <div class="col-lg-4 col-md-4" id="">
                                <a href="" class="text-decoration-none">
                                <div class="flip-card h-100">
                                    <div class="flip-card-inner">

                                    <!-- FRONT -->
                                    <div class="flip-card-front card bg-{{ $kpa['color'] }} text-white">
                                        <div class="card-body position-relative d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                            <div class="avatar me-4">
                                                <span class="avatar-initial rounded bg-label-{{ $kpa['color'] }}">
                                                <i class="icon-base ti {{ $kpa['icon'] }} icon-28px"></i>
                                                </span>
                                            </div>
                                            </div>
                                            <p class="mb-0 fw-bold h5 text-white">{{ $kpa['performance_area'] ?? $kpa['kpa_short_code'] }}</p>
                                        </div>

                                        <div class="mt-2 d-flex flex-column align-items-end small position-absolute bottom-0 end-0 p-2">
                                            <div class="mb-1">
                                            <span class="fw-semibold">Score </span> <span
                                                class="badge bg-label-{{ $kpa['color'] }}">{{ number_format($kpa['avg'], 1) }}%</span>
                                            </div>
                                            <div class="mb-1">
                                            <span class="fw-semibold">Rating </span> <span
                                                class="badge bg-label-{{ $kpa['color'] }}">{{ $kpa['rating'] }}</span>
                                            </div>
                                            <div class="mb-1">
                                            <span class="fw-semibold">Weight </span> <span
                                                class="badge bg-label-{{ $kpa['color'] }}">{{ number_format($weight, 1) }}%</span>
                                            </div>
                                            <div>
                                            <span class="fw-semibold">Weighted Score </span> <span
                                                class="badge bg-label-{{ $kpa['color'] }}">{{ number_format($weight_ss, 1) }}%</span>
                                            </div>
                                        </div>


                                        </div>
                                    </div>

                                    <!-- BACK -->
                                    <div class="flip-card-back card bg-{{ $kpa['color'] }} text-dark h-100">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <div class="badge rounded p-2 mb-2 bg-label-{{ $kpa['color'] }}">
                                            <i class="icon-base ti tabler-chalkboard icon-lg"></i>
                                        </div>
                                        <h6 class="mb-2 text-white text-center">{{ $kpa['performance_area'] ?? $kpa['kpa_short_code'] }}</h6>
                                        <p class="text-center mb-0 text-white fs-13">
                                            {{ $schroll_rating_description ?? 'Keep performing well in this area!' }}
                                        </p>
                                        </div>
                                    </div>

                                    </div>
                                </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- File Upload Form --}}
                    <div class="card-datatable table-responsive card-body">
                        <form id="researchForm" class="row" method="POST" action="{{ route('nomination.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="employeeId" name="employee_id" value="{{ Auth::user()->employee_id }}"
                                class="form-control" />

                            <div class="row g-3" style="padding:20px; font-family:Arial;">
                                <div class="card mb-6">
                                    <div class="row row-bordered g-0">

                                        <!-- Sitara-e-Qiyadat -->
                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Sitara-e-Qiyadat - Chairman’s Leadership Excellence Award</h5>
                                            <div class="card-body">
                                                <div class="row">
                                                    @php
    $sitara = $submission->sitara_qiyadat_awards ?? [];
                                                    @endphp

                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input sitara-checkbox" type="checkbox"
                                                                name="sitara_qiyadat_awards[]" value="best_deen_of_year" {{ in_array('best_deen_of_year', $sitara) ? 'checked' : '' }}>
                                                            <label class="form-check-label">Best Deen of the Year</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input sitara-checkbox" type="checkbox"
                                                                name="sitara_qiyadat_awards[]" value="best_support_leader" {{ in_array('best_support_leader', $sitara) ? 'checked' : '' }}>
                                                            <label class="form-check-label">Best Support Leader</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input sitara-checkbox" type="checkbox"
                                                                name="sitara_qiyadat_awards[]" value="best_program_leader_ug" {{ in_array('best_program_leader_ug', $sitara) ? 'checked' : '' }}>
                                                            <label class="form-check-label">Best Program Leader-UG of the
                                                                Year</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input sitara-checkbox" type="checkbox"
                                                                name="sitara_qiyadat_awards[]" value="best_program_leader_pg" {{ in_array('best_program_leader_pg', $sitara) ? 'checked' : '' }}>
                                                            <label class="form-check-label">Best Program Leader-PG of the
                                                                Year</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input sitara-checkbox" type="checkbox"
                                                                name="sitara_qiyadat_awards[]" value="special_initiatives" {{ in_array('special_initiatives', $sitara) ? 'checked' : '' }}>
                                                            <label class="form-check-label">Special Initiatives</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input sitara-checkbox" type="checkbox"
                                                                name="sitara_qiyadat_awards[]" value="best_house_leader" {{ in_array('best_house_leader', $sitara) ? 'checked' : '' }}>
                                                            <label class="form-check-label">Best House Leader</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input sitara-checkbox" type="checkbox"
                                                                name="sitara_qiyadat_awards[]" value="best_hod_of_year" {{ in_array('best_hod_of_year', $sitara) ? 'checked' : '' }}>
                                                            <label class="form-check-label">Best HOD of Year</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Why Should This Award Be Given to You?</h5>
                                            <div class="card-body">
                                                <textarea class="form-control description-area" id="SitaraeQiyadat"
                                                    name="sitara_qiyadat_why" rows="5"
                                                    placeholder="(Please provide a clear, concise justification highlighting your contributions, achievements, initiatives, or improvements relevant to the selected award category.)">{{ $submission->sitara_qiyadat_why ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Fakhr-e-Karkardagi -->
                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Fakhr-e-Karkardagi - Rector’s Academic Excellence Awards</h5>
                                            <div class="card-body">
                                                <div class="row">
                                                    @php $fakhr = $submission->fakhr_karkardagi_awards ?? []; @endphp

                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="fakhr_karkardagi_awards[]" value="best_faculty_member" {{ in_array('best_faculty_member', $fakhr) ? 'checked' : '' }}>
                                                            <label>Best Faculty Member</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="fakhr_karkardagi_awards[]" value="best_class_attendance" {{ in_array('best_class_attendance', $fakhr) ? 'checked' : '' }}>
                                                            <label>Best Class Attendance (Recognition)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="fakhr_karkardagi_awards[]" value="best_feedback" {{ in_array('best_feedback', $fakhr) ? 'checked' : '' }}>
                                                            <label>Best Feedback (Recognition)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="fakhr_karkardagi_awards[]" value="best_fyp_manager" {{ in_array('best_fyp_manager', $fakhr) ? 'checked' : '' }}>
                                                            <label>Best FYP Manager</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="fakhr_karkardagi_awards[]" value="best_qch" {{ in_array('best_qch', $fakhr) ? 'checked' : '' }}>
                                                            <label>Best QCH</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="fakhr_karkardagi_awards[]" value="best_batch_advisor" {{ in_array('best_batch_advisor', $fakhr) ? 'checked' : '' }}>
                                                            <label>Best Batch Advisor</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Why Should This Award Be Given to You?</h5>
                                            <div class="card-body">
                                                <textarea class="form-control description-area" name="fakhr_karkardagi_why" rows="5"
                                                    placeholder="(Please provide a clear, concise justification highlighting your contributions, achievements, initiatives, or improvements relevant to the selected award category.)">{{ $submission->fakhr_karkardagi_why ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Tamgha-e-Tahqeeq -->
                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Tamgha-e-Tahqeeq - Research Excellence Awards</h5>
                                            <div class="card-body">
                                                <div class="row">
                                                    @php $tamgha = $submission->tamgha_tahqeeq_awards ?? []; @endphp

                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="tamgha_tahqeeq_awards[]"
                                                                value="outstanding_researcher_of_year" {{ in_array('outstanding_researcher_of_year', $tamgha) ? 'checked' : '' }}>
                                                            <label>Outstanding Researcher of the year Award</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="tamgha_tahqeeq_awards[]" value="young_researcher_award" {{ in_array('young_researcher_award', $tamgha) ? 'checked' : '' }}>
                                                            <label>Young Researcher Award</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="tamgha_tahqeeq_awards[]"
                                                                value="best_innovation_commercialization" {{ in_array('best_innovation_commercialization', $tamgha) ? 'checked' : '' }}>
                                                            <label>Best Innovation & Commercialization Award</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Why Should This Award Be Given to You?</h5>
                                            <div class="card-body">
                                                <textarea class="form-control description-area"
                                                    class="form-check-input sitara-checkbox" name="tamgha_tahqeeq_why" rows="5"
                                                    placeholder="(Please provide a clear, concise justification highlighting your contributions, achievements, initiatives, or improvements relevant to the selected award category.)">{{ $submission->tamgha_tahqeeq_why ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Chaudhry Muhammad Akram -->
                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Chaudhry Muhammad Akram - Entrepreneurial Award</h5>
                                            <div class="card-body">
                                                <div class="row">
                                                    @php $chaudhry = $submission->chaudhry_akram_awards ?? []; @endphp

                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="chaudhry_akram_awards[]" value="best_coach" {{ in_array('best_coach', $chaudhry) ? 'checked' : '' }}>
                                                            <label>Best Coach</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="chaudhry_akram_awards[]"
                                                                value="coach_participation_certificate" {{ in_array('coach_participation_certificate', $chaudhry) ? 'checked' : '' }}>
                                                            <label>Coach Participation Certificate</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="chaudhry_akram_awards[]" value="best_ettp_instructor" {{ in_array('best_ettp_instructor', $chaudhry) ? 'checked' : '' }}>
                                                            <label>Best ETTP Instructor</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Why Should This Award Be Given to You?</h5>
                                            <div class="card-body">
                                                <textarea class="form-control description-area" name="chaudhry_akram_why" rows="5"
                                                    placeholder="(Please provide a clear, concise justification highlighting your contributions, achievements, initiatives, or improvements relevant to the selected award category.)">{{ $submission->chaudhry_akram_why ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Service Superheroes -->
                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Service Superheroes</h5>
                                            <div class="card-body">
                                                <div class="row">
                                                    @php $service = $submission->service_superheroes_awards ?? []; @endphp

                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="service_superheroes_awards[]" value="best_office_boy" {{ in_array('best_office_boy', $service) ? 'checked' : '' }}>
                                                            <label>Best Office Boy</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="service_superheroes_awards[]" value="best_security_guard" {{ in_array('best_security_guard', $service) ? 'checked' : '' }}>
                                                            <label>Best Security Guard</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input sitara-checkbox"
                                                                name="service_superheroes_awards[]" value="best_technical_staff" {{ in_array('best_technical_staff', $service) ? 'checked' : '' }}>
                                                            <label>Best Technical Staff</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-xl-12 col-md-6">
                                            <h5 class="card-header">Why Should This Award Be Given to You?</h5>
                                            <div class="card-body">
                                                <textarea class="form-control description-area" name="service_superheroes_why"
                                                    rows="5"
                                                    placeholder="(Please provide a clear, concise justification highlighting your contributions, achievements, initiatives, or improvements relevant to the selected award category.)">{{ $submission->service_superheroes_why ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Disclaimer -->
                                        <div class="col-12 mt-4">
                                            <h5>🔒 Disclaimer</h5>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="disclaimer" value="1" {{ isset($submission->disclaimer) && $submission->disclaimer ? 'checked' : '' }}>
                                                <label class="form-check-label">I understand that my self-nomination will be
                                                    reviewed according to the University’s official award
                                                    criteria, and that the final decision rests solely with the evaluation committee
                                                    after validating my performance records and supporting documents.</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-3 text-end"> <button type="submit"
                                        class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>



                            <!-- start -->
             <!-- Examples -->
        <div class="row mt-0 g-6">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-fives.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Sitara-e-Qiyadat</h5>
                        <p class="card-text">Chairman’s Leadership Excellence Award</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#SitaraeQiyadat">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-threes.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Fakhr-e-Karkardagi</h5>
                        <p class="card-text">Rector’s Academic Excellence Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#FakhrEKarkardagi">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-twos.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Tamgha-e-Tahqeeq</h5>
                        <p class="card-text">Research Excellence Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#TamghaETahqeeq">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-one.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Chaudhry Muhammad Akram</h5>
                        <p class="card-text"> Entrepreneurial Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#ChaudhryMuhammadAkram">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-fours.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Service Superheroes</h5>
                        <p class="card-text">Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#ServiceSuperheroes">Explore</a>
                    </div>
                </div>
            </div>


        </div>
        <!-- Examples -->





            <!-- close model -->
            </div>


            <!--model -->
            <div class="modal fade" id="SitaraeQiyadat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel4">Sitara-e-Qiyadat</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center align-items-center text-white">
                                <p class="m-6">The Sitara-e-Qiyadat – Chairman’s Leadership Excellence Award has been established to honor outstanding leaders within the Superior University community whose vision, commitment, and influence have set new benchmarks of excellence. This prestigious award recognizes individuals who not only demonstrate exceptional leadership within their areas of responsibility but also embody the spirit of innovation, courage, and service that leadership demands in shaping society.</p>
                                <p class="m-6">The Sitara-e-Qiyadat award symbolizes the pioneering spirit of Superior University: a spirit that believes in leading from the front, creating new possibilities, and making meaningful contributions to society. It is a tribute to those leaders who exemplify Superior’s commitment to excellence, and whose efforts ripple far beyond the boundaries.</p>
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-fives.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                     <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Deen of the Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Support Leader</span>
                                        </td>
                                        <td>Universitry Administration</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Program Leader-UnderGrad of the Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Program Leader-PostGrad of the Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Special Initiatives</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best House Leader</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best HOD of Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="FakhrEKarkardagi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="FakhrEKarkardagiTtitle">Fakhr-e-Karkardagi</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center text-white">
                                <p class="m-6">The Fakhr-e-Karkardagi – Rector’s 
                                    Academic Excellence Awards are 
                                    established to celebrate and recognize 
                                    outstanding academic achievement 
                                    across Superior University. This 
                                    prestigious category honors faculty 
                                    members and academic contributors 
                                    who have demonstrated exceptional 
                                    commitment to teaching, curriculum 
                                    innovation, student development, and 
                                    academic leadership.
                                    At Superior University, academic 
                                    excellence is not just about 
                                    knowledge delivery; it is about 
                                    inspiring minds, shaping futures, 
                                    and driving transformation through 
                                    education.</p>
                                <p class="m-6">This award aligns directly 
                                with our vision of leading in teaching 
                                and learning, which has been boldly 
                                advanced through groundbreaking 
                                frameworks such as 3U1M, ETTP, 
                                and now the Character Mastery 
                                Framework. These models have 
                                redefined the educational experience, 
                                focusing on real-world readiness, 
                                entrepreneurship, and leadership, 
                                ensuring that our graduates and our 
                                academic practices are future-proof 
                                and globally competitive.</p>
                                <p class="m-6">The Fakhr-e-Karkardagi awards 
                                continue this pioneering spirit — 
                                acknowledging those who uphold 
                                Superior’s mission by setting 
                                new standards in academic rigor, 
                                innovation, and student engagement. 
                                By celebrating the highest standards 
                                of teaching and learning, the 
                                Fakhr-e-Karkardagi – Rector’s 
                                Academic Excellence Awards affirm 
                                our commitment to nurturing an 
                                environment where educational 
                                excellence is cultivated, recognized, 
                                and further flourished.
                                This recognition strengthens 
                                Superior’s legacy of innovation 
                                in education and encourages 
                                all educators to strive for 
                                transformational impact, both within 
                                their classrooms and beyond.</p>
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-threes.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Faculty Member</span>
                                        </td>
                                        <td>Faculty</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Class Attendance (Recognition)</span>
                                        </td>
                                        <td>Department Wise</td>
                                        <td><span class="badge bg-label-primary me-1">Monthly</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Feedback (Recognition)</span>
                                        </td>
                                        <td>Subject Wise, Department Wise</td>
                                        <td><span class="badge bg-label-primary me-1">Semester</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best FYP Manager</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best QCH</span>
                                        </td>
                                        <td>Faculty</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Batch Advisor</span>
                                        </td>
                                        <td>Faculty</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                   
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


       <div class="modal fade" id="TamghaETahqeeq" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="TamghaETahqeeqTitle">Tamgha-e-Tahqeeq</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center align-items-center text-white">
                                <p class="m-6">The Tamgha-e-Tahqeeq – Research Excellence Award has been instituted to honor the outstanding contributions of researchers who are advancing the frontiers of knowledge, innovation, and societal impact through their scholarly work. This award recognizes individuals and teams who have demonstrated excellence in producing highquality, impactful research that addresses real-world challenges and contributes to the betterment of society.</p>
                                <p class="m-6"> The Research Excellence Awards are closely aligned with Superior University’s vision which sets forth the goal of becoming the leading research university in Pakistan. Through this recognition, Superior University not only applauds individual and collaborative research achievements but also reaffirms its commitment to nurturing an environment where inquiry, exploration, and innovation are deeply valued and continuously rewarded. The Tamgha-e-Tahqeeq serves as both a celebration of past accomplishments and an inspiration for future generations of researchers who will help Superior University soar even higher and roar even louder on the global stage.</p>
                                
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-twos.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                     <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Outstanding Researcher of the year Award</span>
                                        </td>
                                        <td>Discipline (Social & Mgmt. Sciences, Engineering & Computing, Medical & Allied Health Sciences)</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Young Researcher Award</span>
                                        </td>
                                        <td>Discipline (Social & Mgmt. Sciences, Engineering & Computing, Medical & Allied Health Sciences)</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Innovation & Commercialization Award</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                   
                                    
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
       <div class="modal fade" id="ChaudhryMuhammadAkram" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ChaudhryMuhammadAkramTitle">Chaudhry Muhammad Akram</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center  text-white">
                                <p class="m-6">The Chaudhry Muhammad Akram Entrepreneurial Awards are designed to honor and celebrate the visionary efforts of faculty members who champion the university’s entrepreneurial agenda. This award recognizes those educators who actively promote innovative thinking, creativity, and practical business acumen, helping to transform students into successful entrepreneurs and intrapreneurs. Their initiatives not only foster a spirit of enterprise within the classroom but also bridge the gap between academic theory and real-world practice.</p>
                                <p class="m-6">At Superior University, our commitment to shaping future leaders extends beyond traditional academic boundaries. The Entrepreneurial Awards underscore the institution’s strategic focus on cultivating an entrepreneurial mindset across all disciplines. By integrating entrepreneurial education into the curriculum and encouraging experiential learning, our faculty members are creating dynamic pathways that empower students to identify, pursue, and nurture opportunities in both established industries and emerging sectors. This aligns directly with our broader vision of fostering innovation and preparing our community for leadership in an ever-evolving economic landscape.</p>
                                <p class="m-6">Through the Chaudhry Muhammad Akram Entrepreneurial Awards, Superior University reaffirms its dedication to nurturing a culture where academic excellence and entrepreneurial spirit converge. Recognizing and rewarding these outstanding contributions not only incentivizes further innovation but also inspires a generation of students to challenge the status quo, develop groundbreaking ideas, and ultimately contribute to the sustainable economic growth and social progress of our society.</p>
                                
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-one.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                     <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Outstanding Researcher of the year Award</span>
                                        </td>
                                        <td>Discipline (Social & Mgmt. Sciences, Engineering & Computing, Medical & Allied Health Sciences)</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Young Researcher Award</span>
                                        </td>
                                        <td>Discipline (Social & Mgmt. Sciences, Engineering & Computing, Medical & Allied Health Sciences)</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Innovation & Commercialization Award</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                   
                                    
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ServiceSuperheroes" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ServiceSuperheroesTitle">Service Superheroes</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center align-items-center text-white">
                                <p class="m-6">The Service Superheroes Awards are dedicated to recognizing the invaluable contributions of the unsung heroes of Superior University, the office boys, security guards, technical staff, and support teams, whose tireless efforts often go unseen but are absolutely essential to the success of our academic and administrative environment. These individuals work diligently behind the scenes, ensuring that we have a safe, clean, functional, and welcoming space where learning, teaching, and innovation can thrive without disruption.</p>
                                <p class="m-6">By maintaining facilities, securing our surroundings, solving technical challenges, and creating daily convenience for students, faculty, and staff, these dedicated members of our community lay the foundation upon which excellence is built. Their commitment allows the rest of the Superior Family to focus on their pursuits without worry, knowing that the environment around them is in capable and caring hands. Through the Service Superheroes Awards, Superior University proudly shines a light on the spirit of dedication, loyalty, and hard work that these individuals embody every day. This recognition is a testament to our belief that every role, no matter how visible or humble, contributes significantly to our collective success. In celebrating our service superheroes, we reaffirm our core value that every person matters and that our people are truly our pride.</p>
                                
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-fours.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                     <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        
                                        <span class="fw-medium">Best Office Boy</span>
                                        </td>
                                        <td>Campus Wise</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Security Guard</span>
                                        </td>
                                        <td>Campus Wise</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Technical Staff</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                   
                                    
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
            <!-- close model -->

@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-file-upload.js') }}"></script>
    <script>
        document.getElementById('researchForm').addEventListener('submit', function (e) {
            // At least one Sitara checkbox required
            if (!document.querySelectorAll('.sitara-checkbox:checked').length) {
                alert('Please select at least one award.');
                e.preventDefault();
                return false;
            }
            if (!document.querySelectorAll('.description-area').length ||
                !Array.from(document.querySelectorAll('.description-area')).some(t => t.value.trim() !== '')) {
                alert('Please fill out at least one justification.');
                e.preventDefault();
                return false;
            }

            // You can repeat similar validation for other checkbox groups if needed
        });
    </script>
@endpush
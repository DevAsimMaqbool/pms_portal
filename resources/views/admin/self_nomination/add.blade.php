@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.css') }}" />
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
<div class="col-lg-4 col-md-4 col-sm-4">
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
<b>Your Performance Summary FTY 2024 - 2025</b><br>
<span style="font-size: smaller;">Your performance against mentioned areas is as follows:</span>
</p>
</div>

{{-- KPAs --}}
<div class="row">
@php
$kpaAverages = getTopIndicatorsOfEmployee(Auth::user()->employee_id);
@endphp

@foreach ($kpaAverages as $kpa)
<div class="col-md-6 col-lg-4 mb-4">
<div class="card scgrool-card-h hover-card bg-{{ $kpa['color'] }} text-white">

<div class="card-body d-flex align-items-center justify-content-between">

{{-- Left: Icon + KPA Name --}}
<div class="d-flex align-items-center">
    <div class="badge bg-label-success rounded p-2 me-3">
        <i class="icon-base ti tabler-chalkboard icon-md"></i>
    </div>
    <div>
        <small class="text-white text-cut-hot">
            {{ $kpa['performance_area'] ?? $kpa['kpa_short_code'] }}
        </small>
    </div>
</div>

{{-- Right: Average + Rating --}}
<div class="d-flex align-items-center">
    <span class="text-white me-2">{{ number_format($kpa['avg'], 1) }}%</span>
    <span class="badge bg-label-success">
        {{ $kpa['rating'] }}
    </span>
</div>

</div>
</div>
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
<input type="hidden" id="employeeId" name="employee_id" value="{{ Auth::user()->employee_id }}" class="form-control" />

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
<input class="form-check-input" type="checkbox" name="sitara_qiyadat_awards[]" value="best_deen_of_year"
{{ in_array('best_deen_of_year', $sitara) ? 'checked' : '' }}>
<label class="form-check-label">Best Deen of the Year</label>
</div>
</div>

<div class="col-md-6 mb-2">
<div class="form-check">
<input class="form-check-input" type="checkbox" name="sitara_qiyadat_awards[]" value="best_support_leader"
{{ in_array('best_support_leader', $sitara) ? 'checked' : '' }}>
<label class="form-check-label">Best Support Leader</label>
</div>
</div>

<div class="col-md-6 mb-2">
<div class="form-check">
<input class="form-check-input" type="checkbox" name="sitara_qiyadat_awards[]" value="best_program_leader_ug"
{{ in_array('best_program_leader_ug', $sitara) ? 'checked' : '' }}>
<label class="form-check-label">Best Program Leader-UG of the Year</label>
</div>
</div>

<div class="col-md-6 mb-2">
<div class="form-check">
<input class="form-check-input" type="checkbox" name="sitara_qiyadat_awards[]" value="best_program_leader_pg"
{{ in_array('best_program_leader_pg', $sitara) ? 'checked' : '' }}>
<label class="form-check-label">Best Program Leader-PG of the Year</label>
</div>
</div>

<div class="col-md-6 mb-2">
<div class="form-check">
<input class="form-check-input" type="checkbox" name="sitara_qiyadat_awards[]" value="special_initiatives"
{{ in_array('special_initiatives', $sitara) ? 'checked' : '' }}>
<label class="form-check-label">Special Initiatives</label>
</div>
</div>

<div class="col-md-6 mb-2">
<div class="form-check">
<input class="form-check-input" type="checkbox" name="sitara_qiyadat_awards[]" value="best_house_leader"
{{ in_array('best_house_leader', $sitara) ? 'checked' : '' }}>
<label class="form-check-label">Best House Leader</label>
</div>
</div>

<div class="col-md-6 mb-2">
<div class="form-check">
<input class="form-check-input" type="checkbox" name="sitara_qiyadat_awards[]" value="best_hod_of_year"
{{ in_array('best_hod_of_year', $sitara) ? 'checked' : '' }}>
<label class="form-check-label">Best HOD of Year</label>
</div>
</div>
</div>
</div>
</div>

<div class="col-xxl-6 col-xl-12 col-md-6">
<h5 class="card-header">Why Should This Award Be Given to You?</h5>
<div class="card-body">
<textarea class="form-control" id="SitaraeQiyadat" name="sitara_qiyadat_why" rows="5"
placeholder="Provide justification...">{{ $submission->sitara_qiyadat_why ?? '' }}</textarea>
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
<input type="checkbox" name="fakhr_karkardagi_awards[]" value="best_faculty_member"
{{ in_array('best_faculty_member', $fakhr) ? 'checked' : '' }}>
<label>Best Faculty Member</label>
</div>
</div>
<div class="col-md-6 mb-2">
<div class="form-check">
<input type="checkbox" name="fakhr_karkardagi_awards[]" value="best_class_attendance"
{{ in_array('best_class_attendance', $fakhr) ? 'checked' : '' }}>
<label>Best Class Attendance (Recognition)</label>
</div>
</div>
<div class="col-md-6 mb-2">
<div class="form-check">
<input type="checkbox" name="fakhr_karkardagi_awards[]" value="best_feedback"
{{ in_array('best_feedback', $fakhr) ? 'checked' : '' }}>
<label>Best Feedback (Recognition)</label>
</div>
</div>
<div class="col-md-6 mb-2">
<div class="form-check">
<input type="checkbox" name="fakhr_karkardagi_awards[]" value="best_fyp_manager"
{{ in_array('best_fyp_manager', $fakhr) ? 'checked' : '' }}>
<label>Best FYP Manager</label>
</div>
</div>
<div class="col-md-6 mb-2">
<div class="form-check">
<input type="checkbox" name="fakhr_karkardagi_awards[]" value="best_qch"
{{ in_array('best_qch', $fakhr) ? 'checked' : '' }}>
<label>Best QCH</label>
</div>
</div>
<div class="col-md-6 mb-2">
<div class="form-check">
<input type="checkbox" name="fakhr_karkardagi_awards[]" value="best_batch_advisor"
{{ in_array('best_batch_advisor', $fakhr) ? 'checked' : '' }}>
<label>Best Batch Advisor</label>
</div>
</div>
</div>
</div>
</div>

<div class="col-xxl-6 col-xl-12 col-md-6">
<h5 class="card-header">Why Should This Award Be Given to You?</h5>
<div class="card-body">
<textarea class="form-control" name="fakhr_karkardagi_why" rows="5">{{ $submission->fakhr_karkardagi_why ?? '' }}</textarea>
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
<input type="checkbox" name="tamgha_tahqeeq_awards[]" value="outstanding_researcher_of_year"
{{ in_array('outstanding_researcher_of_year', $tamgha) ? 'checked' : '' }}>
<label>Outstanding Researcher of the year Award</label>
</div>
</div>

<div class="col-md-12 mb-2">
<div class="form-check">
<input type="checkbox" name="tamgha_tahqeeq_awards[]" value="young_researcher_award"
{{ in_array('young_researcher_award', $tamgha) ? 'checked' : '' }}>
<label>Young Researcher Award</label>
</div>
</div>

<div class="col-md-12 mb-2">
<div class="form-check">
<input type="checkbox" name="tamgha_tahqeeq_awards[]" value="best_innovation_commercialization"
{{ in_array('best_innovation_commercialization', $tamgha) ? 'checked' : '' }}>
<label>Best Innovation & Commercialization Award</label>
</div>
</div>
</div>
</div>
</div>

<div class="col-xxl-6 col-xl-12 col-md-6">
<h5 class="card-header">Why Should This Award Be Given to You?</h5>
<div class="card-body">
<textarea class="form-control" name="tamgha_tahqeeq_why" rows="5">{{ $submission->tamgha_tahqeeq_why ?? '' }}</textarea>
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
<input type="checkbox" name="chaudhry_akram_awards[]" value="best_coach"
{{ in_array('best_coach', $chaudhry) ? 'checked' : '' }}>
<label>Best Coach</label>
</div>
</div>

<div class="col-md-12 mb-2">
<div class="form-check">
<input type="checkbox" name="chaudhry_akram_awards[]" value="coach_participation_certificate"
{{ in_array('coach_participation_certificate', $chaudhry) ? 'checked' : '' }}>
<label>Coach Participation Certificate</label>
</div>
</div>

<div class="col-md-12 mb-2">
<div class="form-check">
<input type="checkbox" name="chaudhry_akram_awards[]" value="best_ettp_instructor"
{{ in_array('best_ettp_instructor', $chaudhry) ? 'checked' : '' }}>
<label>Best ETTP Instructor</label>
</div>
</div>
</div>
</div>
</div>

<div class="col-xxl-6 col-xl-12 col-md-6">
<h5 class="card-header">Why Should This Award Be Given to You?</h5>
<div class="card-body">
<textarea class="form-control" name="chaudhry_akram_why" rows="5">{{ $submission->chaudhry_akram_why ?? '' }}</textarea>
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
<input type="checkbox" name="service_superheroes_awards[]" value="best_office_boy"
{{ in_array('best_office_boy', $service) ? 'checked' : '' }}>
<label>Best Office Boy</label>
</div>
</div>

<div class="col-md-12 mb-2">
<div class="form-check">
<input type="checkbox" name="service_superheroes_awards[]" value="best_security_guard"
{{ in_array('best_security_guard', $service) ? 'checked' : '' }}>
<label>Best Security Guard</label>
</div>
</div>

<div class="col-md-12 mb-2">
<div class="form-check">
<input type="checkbox" name="service_superheroes_awards[]" value="best_technical_staff"
{{ in_array('best_technical_staff', $service) ? 'checked' : '' }}>
<label>Best Technical Staff</label>
</div>
</div>
</div>
</div>
</div>

<div class="col-xxl-6 col-xl-12 col-md-6">
<h5 class="card-header">Why Should This Award Be Given to You?</h5>
<div class="card-body">
<textarea class="form-control" name="service_superheroes_why" rows="5">{{ $submission->service_superheroes_why ?? '' }}</textarea>
</div>
</div>

<!-- Disclaimer -->
<div class="col-12 mt-4">
<label class="form-label mb-2"><b>🔒 Disclaimer</b></label>
<div class="form-check">
<input class="form-check-input" type="checkbox" name="disclaimer" value="1"
{{ isset($submission->disclaimer) && $submission->disclaimer ? 'checked' : '' }}>
<label class="form-check-label">I understand that my self-nomination will be reviewed according to the University’s official award
criteria, and that the final decision rests solely with the evaluation committee after validating my performance records and supporting documents.</label>
</div>
</div>

</div>
</div>
<div class="mt-3 text-end"> <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
</div>
</div>
</form>

</div>

</div>
</div>

@endsection

@push('script')
<script src="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('admin/assets/js/forms-file-upload.js') }}"></script>
@endpush
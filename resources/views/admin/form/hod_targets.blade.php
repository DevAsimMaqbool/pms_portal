@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Permission Table -->
        <div class="card mb-6">
            <h5 class="card-header">Multi Column with Form Separator</h5>
            <form class="card-body">
                <h6>1. Account Details</h6>
                <div class="row g-6">
                    <div class="col-md-4">
                        <label class="form-label" for="indicator">Select Indicator</label>
                        <select id="indicator" class="select2 form-select" data-allow-clear="true" name="indicator"
                            multiple required>
                            <option value="135"># of Grants Won</option>
                            <option value="136">Multidisciplinary Projects</option>
                            <option value="137">Commercial Consultancy/Research Income</option>
                            <option value="138">Patents/Intellectual Property (IPR)</option>
                            <option value="198">Industrial Projects</option>
                            <option value="199">Products Delivered to Industry</option>
                        </select>
                        <div class="invalid-feedback" id="indicatorError"></div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="target">Target</label>
                        <input type="number" id="target" name="target" class="form-control" placeholder="1">
                        <div class="invalid-feedback" id="targetError"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="multicol-language">Name of Faculty Member</label>
                         <select  name="faculty_member_id" id="select2Success" class="select2 form-select"  multiple required>
                                <option value="">-- Select Faculty Member --</option>
                                @foreach($facultyMembers as $member)
                                    <option 
                                        value="{{ $member->id }}" 
                                        data-department="{{ $member->department }}" 
                                        data-job_title="{{ $member->job_title }}">
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-4 waves-effect waves-light">Submit</button>
                    <button type="reset" class="btn btn-label-secondary waves-effect">Cancel</button>
                </div>
            </form>
        </div>
        <!--/ Permission Table -->
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
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>

@endpush
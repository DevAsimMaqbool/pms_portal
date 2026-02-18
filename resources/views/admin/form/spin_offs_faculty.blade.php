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

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                {{-- <h5>KPA to role</h5> --}}
                <form id="researchForm" enctype="multipart/form-data" class="row">
                    @csrf
                    <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                    <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                    <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">

                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="name_of_faculty_member" class="form-label">Name of faculty member</label>
                            <input type="text" id="name_of_faculty_member" name="name_of_faculty_member"
                                class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="spin_off_form_submission" class="form-label">Spin off form submission</label>
                            <input type="text" id="spin_off_form_submission" name="spin_off_form_submission"
                                class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="status_of_spin_off_feasibility" class="form-label">Status of Spin off
                                feasibility</label>
                            <input type="text" id="status_of_spin_off_feasibility" name="status_of_spin_off_feasibility"
                                class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="work_plan_for_the_spin_off" class="form-label">Work plan for the spin off</label>
                            <input type="text" id="work_plan_for_the_spin_off" name="work_plan_for_the_spin_off"
                                class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="name_of_pre_spin_off" class="form-label">Name of pre-spin off</label>
                            <input type="text" id="name_of_pre_spin_off" name="name_of_pre_spin_off" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="total_revenue_generated" class="form-label">Total revenue generated so far</label>
                            <input type="text" id="total_revenue_generated" name="total_revenue_generated"
                                class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="annual_revenue_generated" class="form-label">Annual revenue generated</label>
                            <input type="text" id="annual_revenue_generated" name="annual_revenue_generated"
                                class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="rev_current_financial_year" class="form-label">Revenue target for current financial
                                year</label>
                            <input type="text" id="rev_current_financial_year" name="rev_current_financial_year"
                                class="form-control">
                        </div>


                    </div>
                    <div class="col-1 text-center demo-vertical-spacing">
                        <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
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
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>
@endpush
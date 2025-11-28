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
                <form id="researchForm" enctype="multipart/form-data"class="row">
                    @csrf
                    <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                    <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                    <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                    
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="name_of_journal" class="form-label">Name of journal</label>
                            <input type="text" id="name_of_journal" name="name_of_journal" class="form-control" >
                        </div>
                       
                        <div class="col-md-6">
                            <label for="approved_frequency_of_pub" class="form-label">Approved frequency of publication</label>
                            <input type="text" id="approved_frequency_of_pub" name="approved_frequency_of_pub" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="no_of_issues_published" class="form-label">No of issues published</label>
                            <input type="text" id="no_of_issues_published" name="no_of_issues_published" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="revenue_generated_under_apc" class="form-label">Revenue generated under APC</label>
                            <input type="text" id="revenue_generated_under_apc" name="revenue_generated_under_apc" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="no_of_indexing_prior_report" class="form-label">No of indexing prior to this report</label>
                            <input type="text" id="no_of_indexing_prior_report" name="no_of_indexing_prior_report" class="form-control" >
                        </div>

                         <div class="col-md-6">
                            <label for="new_indexing_done_quarter" class="form-label">New indexing done in this quarter</label>
                            <input type="text" id="new_indexing_done_quarter" name="new_indexing_done_quarter" class="form-control" >
                        </div>

                       
                    </div>
                    <div class="col-4 text-center demo-vertical-spacing">
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

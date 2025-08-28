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
                 @if(auth()->user()->hasRole(['HOD']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Achievement of Multidiciplinary Project Target</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Research Target Setting</a>
                        </li>
                    </ul>
                 @endif

                 <!-- Tab panes -->
                <div class="tab-content">
                     @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                    <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <form id="researchForm1" enctype="multipart/form-data"class="row">
                                @csrf
                                <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                                <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                                <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER" required>
                                
                                <div class="row g-6">
                                    <div class="col-md-6">
                                        <label for="name_of_project_initiated" class="form-label">Name of project initiated during the quarter</label>
                                        <input type="text" id="name_of_project_initiated" name="name_of_project_initiated" class="form-control" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="other_disciplines_engaged" class="form-label">Other disciplines engaged</label>
                                        <input type="text" id="other_disciplines_engaged" name="other_disciplines_engaged" class="form-control" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="partner_industry" class="form-label">Target/partner industry</label>
                                        <input type="text" id="partner_industry" name="partner_industry" class="form-control" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="identified_public_sector_entity" class="form-label">Identified public sector entity</label>
                                        <input type="text" id="identified_public_sector_entity" name="identified_public_sector_entity" class="form-control" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="completion_time_of_project" class="form-label">Target completion time of the project</label>
                                        <input type="text" id="completion_time_of_project" name="completion_time_of_project" class="form-control" >
                                    </div>

                                    <div class="col-md-6">
                                            <label class="form-label d-block">Prototype/product developed</label>
                                            <div>
                                                <input type="radio" name="product_developed" id="product_developed_yes" value="YES"> 
                                                <label for="product_developed_yes">Yes</label>

                                                <input type="radio" name="product_developed" id="product_developed_no" value="NO" checked> 
                                                <label for="product_developed_no">No</label>

                                                <input type="radio" name="product_developed" id="product_developed_na" value="NA" > 
                                                <label for="product_developed_na">NA</label>
                                            </div>
                                    </div>

                                    <div class="col-md-6">
                                            <label class="form-label d-block">Third party validation of the product</label>
                                            <div>
                                                <input type="radio" name="third_party_validation" id="third_party_validation_yes" value="YES"> 
                                                <label for="third_party_validation_yes">Yes</label>

                                                <input type="radio" name="third_party_validation" id="third_party_validation_no" value="NO" checked> 
                                                <label for="third_party_validation_no">No</label>

                                                <input type="radio" name="third_party_validation" id="third_party_validation_na" value="NA" > 
                                                <label for="third_party_validation_na">NA</label>
                                            </div>
                                    </div>

                                    <div class="col-md-6">
                                            <label class="form-label d-block">IP claim?</label>
                                            <div>
                                                <input type="radio" name="ip_claim" id="ip_claim_yes" value="YES"> 
                                                <label for="ip_claim_yes">Yes</label>

                                                <input type="radio" name="ip_claim" id="ip_claim_no" value="NO" checked> 
                                                <label for="ip_claim_no">No</label>
                                            </div>
                                    </div>

                                    <div class="col-md-6" id="extra_select_container" style="display: none;">
                                            <label for="provide_details" class="form-label">In case yes, provide details</label>
                                            <input type="text" id="provide_details" name="provide_details" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-4 text-center demo-vertical-spacing">
                                    <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>
                    </div>
                    @endif
                    @if(auth()->user()->hasRole(['HOD']))
                    <div class="tab-pane fade" id="form2" role="tabpanel">
                        <form id="researchForm2" enctype="multipart/form-data"class="row">
                            @csrf
                            <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                            <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                            <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                            <input type="hidden"  id="form_status" name="form_status" value="HOD" required>
                            
                            <div class="row g-6">
                                <div class="col-md-6">
                                    <label for="target_of_projects" class="form-label">Target of projects</label>
                                    <input type="text" id="target_of_projects" name="target_of_projects" class="form-control" >
                                </div>

                                <div class="col-md-6">
                                    <label for="target_of_faculties" class="form-label">Target Faculties</label>
                                    <input type="text" id="target_of_faculties" name="target_of_faculties" class="form-control" >
                                </div>

                            
                            </div>
                            <div class="col-4 text-center demo-vertical-spacing">
                                <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                            </div>
                        </form>
                    </div>  
                    @endif       
                </div>
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
@push('script')
<script>
$(document).ready(function () {
    $('input[name="ip_claim"]').on('change', function () {
        if ($(this).val() === 'YES') {
            $('#extra_select_container').show();
        } else {
            $('#extra_select_container').hide();
            $('#provide_details').val(''); // clear selection if hidden
        }
    });

   
});
</script>
@if(auth()->user()->hasRole(['HOD','Teacher']))
    <script>
    $(document).ready(function () {
         $('input[name="ip_claim"]').on('change', function () {
                if ($(this).val() === 'YES') {
                    $('#extra_select_container').show();
                } else {
                    $('#extra_select_container').hide();
                    $('#provide_details').val(''); // clear selection if hidden
                }
            });

        // Extra fields for Form 1

        $('#researchForm1').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('achievement-ofmultidisciplinary.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.close();
                    Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                    form[0].reset();
                },
                error: function (xhr) {
                    Swal.close();
                     // Clear previous errors before showing new ones
                        form.find('.invalid-feedback').remove();
                        form.find('.is-invalid').removeClass('is-invalid');
                     if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Loop through all validation errors
                            $.each(errors, function (field, messages) {
                                let input = form.find('[name="' + field + '"]');

                                if (input.length) {
                                    input.addClass('is-invalid');

                                    // Show error message under input
                                    input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                }
                            });

                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                }
            });
        });
    });
    </script>
    @endif
    @if(auth()->user()->hasRole(['HOD']))
    <script>
    $(document).ready(function () {

        // Extra fields for Form 2
         $('#researchForm2').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('achievement-ofmultidisciplinary.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.close();
                    Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                    form[0].reset();
                },
                error: function (xhr) {
                    Swal.close();
                     // Clear previous errors before showing new ones
                    form.find('.invalid-feedback').remove();
                    form.find('.is-invalid').removeClass('is-invalid');
                     if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Loop through all validation errors
                            $.each(errors, function (field, messages) {
                                let input = form.find('[name="' + field + '"]');

                                if (input.length) {
                                    input.addClass('is-invalid');

                                    // Show error message under input
                                    input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                }
                            });

                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                }
            });
        });
    });
    </script>
    @endif
@endpush
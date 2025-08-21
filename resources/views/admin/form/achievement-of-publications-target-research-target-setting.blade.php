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
                                    <input type="radio" name="product_developed" id="product_developed_yes" value="yes"> 
                                    <label for="product_developed_yes">Yes</label>

                                    <input type="radio" name="product_developed" id="product_developed_no" value="no" checked> 
                                    <label for="product_developed_no">No</label>

                                    <input type="radio" name="product_developed" id="product_developed_na" value="na" > 
                                    <label for="product_developed_na">NA</label>
                                </div>
                        </div>

                        <div class="col-md-6">
                                <label class="form-label d-block">Third party validation of the product</label>
                                <div>
                                    <input type="radio" name="third_party_validation" id="third_party_validation_yes" value="yes"> 
                                    <label for="third_party_validation_yes">Yes</label>

                                    <input type="radio" name="third_party_validation" id="third_party_validation_no" value="no" checked> 
                                    <label for="third_party_validation_no">No</label>

                                    <input type="radio" name="third_party_validation" id="third_party_validation_na" value="na" > 
                                    <label for="third_party_validation_na">NA</label>
                                </div>
                        </div>

                        <div class="col-md-6">
                                <label class="form-label d-block">IP claim?</label>
                                <div>
                                    <input type="radio" name="capacity_building" id="capacity_yes" value="yes"> 
                                    <label for="capacity_yes">Yes</label>

                                    <input type="radio" name="capacity_building" id="capacity_no" value="no" checked> 
                                    <label for="capacity_no">No</label>
                                </div>
                        </div>

                        <div class="col-md-6" id="extra_select_container" style="display: none;">
                                <label for="extra_select" class="form-label">In case yes, provide details</label>
                                <input type="text" id="extra_select" name="extra_select" class="form-control" >
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
@push('script')
<script>
$(document).ready(function () {
    $('#faculty_member').on('change', function () {
        let selected = $(this).find(':selected');
        let department = selected.data('department');
        let job_title = selected.data('job_title');

        $('#department').val(department ?? '');
        $('#job_title').val(job_title ?? '');
    });
    $('input[name="capacity_building"]').on('change', function () {
        if ($(this).val() === 'yes') {
            $('#extra_select_container').show();
        } else {
            $('#extra_select_container').hide();
            $('#extra_select').val(''); // clear selection if hidden
        }
    });

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
            url: "{{ route('indicatorForm.store') }}",
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
                        $('[name="'+ key +'"]').addClass('is-invalid');
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
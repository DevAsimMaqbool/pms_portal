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
                            <label for="faculty_member" class="form-label">Faculty Member</label>
                            <select id="faculty_member" name="faculty_member" class="form-select">
                                <option value="">-- Select Faculty Member --</option>
                                @foreach($facultyMembers as $member)
                                    <option value="{{ $member->id }}" data-department="{{ $member->department }}"
                                        data-job_title="{{ $member->job_title }}">
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" id="department" name="department" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="job_title" class="form-label">Designation</label>
                            <input type="text" id="job_title" name="job_title" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="target_category" class="form-label">Target Category</label>
                            <select id="target_category" name="target_category" class="form-select">
                                <option value="">Select Target Category</option>
                                <option value="Scopus Indexed">Scopus Indexed</option>
                                <option value="HEC">HEC</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="target_of_publications" class="form-label">Target of Publications</label>
                            <input type="text" id="target_of_publications" class="form-control"
                                name="target_of_publications">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Capacity building need?</label>
                            <div>
                                <input type="radio" name="capacity_building" id="capacity_yes" value="yes">
                                <label for="capacity_yes">Yes</label>

                                <input type="radio" name="capacity_building" id="capacity_no" value="no" checked>
                                <label for="capacity_no">No</label>
                            </div>
                        </div>

                        <div class="col-md-6" id="extra_select_container" style="display: none;">
                            <label for="extra_select" class="form-label">Select the need</label>
                            <select id="extra_select" name="extra_select" class="form-select">
                                <option value="">-- Select Option --</option>
                                <option value="option1">Basics of research</option>
                                <option value="option2">Analytical tools</option>
                                <option value="option3">Advanced analytics</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="capacity_building" class="form-label">Any Specifics related to capacity
                                building</label>
                            <input type="text" id="capacity_building" class="form-control" name="capacity_building">
                        </div>
                        <div class="col-md-6">
                            <label for="Frequency" class="form-label">Frequency/No of trainings</label>
                            <input type="text" id="Frequency" class="form-control" name="Frequency">
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
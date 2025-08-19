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
                    <input type="hidden" id="kpa_id" name="kpa_id" value="$areaId ">
                    <input type="hidden" id="sp_category_id" name="sp_category_id" value=" $categoryId">
                    <input type="hidden" id="indicator_id" name="indicator_id" value=" $indicatorId">
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="no_of_international_coauthers" class="form-label">No of International
                                co-authers</label>
                            <input type="text" id="no_of_international_coauthers" class="form-control"
                                name="no_of_international_coauthers">
                        </div>

                        <div class="col-md-6">
                            <label for="name_of_coauthers" class="form-label">Names of co-authers</label>
                            <input type="text" id="name_of_coauthers" class="form-control" name="name_of_coauthers">
                        </div>
                        <div class="col-md-6">
                            <label for="author_rank" class="form-label">Author rank</label>
                            <input type="text" id="author_rank" class="form-control" name="author_rank">
                        </div>
                        <div class="col-md-6">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" id="designation" class="form-control" name="designation">
                        </div>

                        <div class="col-md-6">
                            <label for="name_of_university_country" class="form-label">Name of University & Country</label>
                            <input type="text" id="name_of_university_country" class="form-control"
                                name="name_of_university_country">
                        </div>
                        <div class="col-md-6" id="extraFieldContainer"></div>
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

            // Handle dynamic extra fields
            $('#progress_on_publication').on('change', function () {
                const container = $('#extraFieldContainer');
                container.empty();

                if (this.value === 'At draft stage') {
                    container.html(`<label for="draft_stage" class="form-label">Draft</label><input type="text" id="draft_stage" name="draft_stage" class="form-control" placeholder="Enter draft details" required>`);
                }
                else if (this.value === 'In Review') {
                    container.html(`<label for="email_screenshot" class="form-label">Email Screenshot</label><input type="file" id="email_screenshot" name="email_screenshot" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>`);
                }
                else if (this.value === 'Published') {
                    container.html(`<label for="scopus_link" class="form-label">Scopus link</label><input type="url" id="scopus_link" name="scopus_link" placeholder="Scopus link" class="form-control" required>`);
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
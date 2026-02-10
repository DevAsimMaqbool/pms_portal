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
<!-- Tab panes -->
<div class="tab-content">
@if(auth()->user()->hasRole(['HOD']))
<div class="tab-pane fade show active" id="form1" role="tabpanel">
<div class="d-flex justify-content-between">
    <div>
    <h5 class="mb-1">No. of students enrolled in 1M with global experience (work experience) (if applicable)</h5>
    </div>
    <a href="{{ route('indicators_crud.index', ['slug' => 'no_of_students_enrolled_in_1m_with_global_experience', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
</div> 
<form id="researchForm" enctype="multipart/form-data" class="row">
@csrf
<input type="hidden" id="form_status" name="form_status" value="HOD" required>
<input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
<div class="row g-6 mt-0">
<div id="grant-details-container">
<div class="grant-group row g-3 mb-3 p-3 border border-primary">

 
    <div class="col-md-6">
        <label class="form-label">Programs Being Offered in Faculty</label>
        <input type="text" class="form-control" placeholder="e.g. BS, MS, PhD Programs">
    </div>

    <!-- Enrolled Students -->
    <div class="col-md-6">
        <label class="form-label">
            Total Number of Enrolled Students (Last Two Semesters)
        </label>
        <input type="number" class="form-control" placeholder="Enter total enrolled students">
    </div>

    <!-- Target & Timeline -->
        <div class="col-md-6">
            <label class="form-label">Target</label>
            <input type="number" class="form-control" placeholder="Enter target value">
        </div>

        <div class="col-md-6">
            <label class="form-label">Timeline</label>
            <input type="text" class="form-control" placeholder="e.g. Jan 2025 – Dec 2025">
        </div>

    <!-- Registered Students -->
    <div class="col-md-6">
        <label class="form-label">Number of Registered Students</label>
        <input type="number" class="form-control" placeholder="Enter registered students">
    </div>

    <!-- Process Stage -->
    <div class="col-md-6">
        <label class="form-label">Process Stage</label>
        <select class="form-select">
            <option selected disabled>Select process stage</option>
            <option>Inquiry</option>
            <option>Application Submitted</option>
            <option>Admission Offered</option>
            <option>Visa Processing</option>
            <option>Enrolled</option>
        </select>
    </div>



</div>
</div>
</div>
<div class="mt-3 text-end" style="margin-left: -16px !important;">
<button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
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
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            $(document).ready(function () {

                $('#researchForm').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);
                    // Show loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('students-global-experience.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                            $('.select2').val(null).trigger('change');
                            // Remove all extra grant groups and keep only the first one
                            $('#grant-details-container .grant-group:not(:first)').remove();

                            // Reset the proof container of the first group
                            $('#grant-details-container .grant-group:first .proof-container').hide();

                            // Reset index to 1
                            grantIndex = 1;
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

                            } else if (xhr.status === 409) {
                                // 🔥 Duplicate record message
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Duplicate Entry',
                                    text: xhr.responseJSON.message
                                });

                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                            }
                        }
                    });
                });

            });
        </script>
    @endif
@endpush
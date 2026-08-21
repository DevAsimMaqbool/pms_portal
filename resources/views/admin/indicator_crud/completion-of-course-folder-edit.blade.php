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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Professor', 'Associate Professor', 'Demonstrator']))
            <!-- Multi Column with Form Separator -->
            <div class="card">
                <div class="card-datatable table-responsive card-body">

                    <!-- Tab panes -->
                    <div class="tab-content">
                        @if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Professor', 'Associate Professor', 'Demonstrator']))
                            <div class="tab-pane fade show active" id="form1" role="tabpanel">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="mb-1">Completion of Course Folder</h5>
                                    </div>
                                </div>
                                <form id="editForm" enctype="multipart/form-data" class="row">
                                    @csrf
                                    @method('PUT')
                                    @php
                                        $completionStatus = $data->completion_status ?? [];
                                    @endphp
                                    <input type="hidden" name="form_status" value="{{ $data->form_status }}">
                                    <input type="hidden" name="faculty_member_id" value="{{ $data->faculty_member_id }}">
                                    <input type="hidden" name="completion_of_Course_folder_indicator_id"
                                        value="{{ $data->completion_of_Course_folder_indicator_id }}">
                                    <input type="hidden" name="compliance_and_usage_of_lms_indicator_id"
                                        value="{{ $data->compliance_and_usage_of_lms_indicator_id }}">
                                    <input type="hidden" name="record_id" value="{{ $data->id }}">
                                    <input class="d-none" type="radio" name="completion_of_Course_folder" id="good" value="1"
                                        checked>

                                    <div class="row g-6 mt-0">

                                        <div id="grant-details-container">
                                            <div class="grant-group row g-3 m-0 p-3">

                                                <div class="col-md-6 d-none">
                                                    <label for="faculty_member" class="form-label">Name of Faculty Member</label>

                                                    <input type="hidden" id="faculty_member_id" name="faculty_member_id"
                                                        value="{{ auth()->id() }}">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="batch" class="form-label">Term</label>
                                                    <select name="term_id" class="form-select term_id" required>
                                                        <option value="">-- Select Term --</option>
                                                        @foreach(SelectCurrentTerm() as $term)
                                                            <option value="{{ $term->id }}" {{ old('term_id', $data->term_id ?? '') == $term->id ? 'selected' : '' }}> {{ $term->term }}
                                                                {{ $term->start_year }}
                                                        </option> @endforeach

                                                    </select>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="class_name" class="form-label">Class</label>
                                                    <select name="class_name[]" id="select2Success"
                                                        class="select2 form-select faculty-class" multiple required>
                                                        @if($data->class_cod)
                                                            <option value="{{ $data->class_cod }}" selected>{{ $data->class_cod }}
                                                            </option>
                                                        @endif
                                                    </select>
                                                    <small class="text-primary">Select the term first</small>
                                                </div>

                                                {{-- <div class="col-md-12 mt-3">
                                                    <label class="form-label d-block">1- Course Folder Status</label>
                                                    <div>
                                                        <input type="radio" name="completion_of_Course_folder" id="completed"
                                                            value="100" {{ $data->completion_of_Course_folder == 100 ? 'checked' :
                                                        '' }}>
                                                        <label for="completed">Completed</label>

                                                        <input type="radio" name="completion_of_Course_folder"
                                                            id="partially_completed" value="70" {{
                                                            $data->completion_of_Course_folder == 70 ? 'checked' : '' }}>
                                                        <label for="partially_completed">Partially Completed</label>

                                                        <input type="radio" name="completion_of_Course_folder" id="not_Completed"
                                                            value="25" {{ $data->completion_of_Course_folder == 25 ? 'checked' : ''
                                                        }}>
                                                        <label for="not_Completed">Not Completed</label>
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-12">
                                                    <h6 class=" d-block">Course folder status</h6>
                                                    <div class="form-check mt-4">
                                                        <input class="form-check-input" type="checkbox" name="completion_status[]"
                                                            id="module" value="Module" {{ in_array('Module', $completionStatus) ? 'checked' : '' }}>
                                                        <label for="module">Module</label>
                                                    </div>

                                                    <div class="form-check mt-4">
                                                        <input class="form-check-input" type="checkbox" name="completion_status[]"
                                                            id="lecture_log_sheet" value="lecture log sheet" {{ in_array('lecture log sheet', $completionStatus) ? 'checked' : '' }}>
                                                        <label for="lecture_log_sheet">Lecture log sheet</label>
                                                    </div>

                                                    <div class="form-check mt-4">
                                                        <input class="form-check-input" type="checkbox" name="completion_status[]"
                                                            id="cqi_docuement" value="CQI Docuement" {{ in_array('CQI Docuement', $completionStatus) ? 'checked' : '' }}>
                                                        <label for="cqi_docuement">CQI Docuement</label>
                                                    </div>

                                                    <div class="mt-4">
                                                        <label class="form-check-label" for="assessment_evidence">Assessment
                                                            evidence</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="completion_status[]" id="good" value="Good" {{ in_array('Good', $completionStatus) ? 'checked' : '' }}>
                                                            <label for="good">Good</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="completion_status[]" id="bad" value="Bad" {{ in_array('Bad', $completionStatus) ? 'checked' : '' }}>
                                                            <label for="bad">Bad</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="completion_status[]" id="any" value="Any" {{ in_array('Any', $completionStatus) ? 'checked' : '' }}>
                                                            <label for="any">Any</label>
                                                        </div>
                                                    </div>

                                                    <div class="mt-4">
                                                        <label class="form-check-label" for="result">Result</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="completion_status[]" id="grading_sheet" value="Grading Sheet"
                                                                {{ in_array('Grading Sheet', $completionStatus) ? 'checked' : '' }}>
                                                            <label for="grading_sheet">Grading Sheet</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="completion_status[]" id="marks_Sheet" value="Marks Sheet" {{ in_array('Marks Sheet', $completionStatus) ? 'checked' : '' }}>
                                                            <label for="marks_Sheet">Marks Sheet</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="completion_status[]" id="clo_plo_maping_Sheet"
                                                                value="CLO PLO Maping Sheet" {{ in_array('CLO PLO Maping Sheet', $completionStatus) ? 'checked' : '' }}>
                                                            <label for="clo_plo_maping_Sheet">CLO PLO Maping Sheet</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Please Provide Drive Link</label>
                                                    <input type="url" name="document_url" id="document_url" class="form-control"
                                                        value="{{ old('document_url', $data->document_url) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-end">
                                            <button class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                                        </div>
                                </form>

                            </div>
                        @endif
                        @if(in_array(getRoleName(activeRole()), ['HOD']))
                            <div class="tab-pane fade" id="form3" role="tabpanel">
                                @if(in_array(getRoleName(activeRole()), ['HOD']))
                                    <div class="d-flex">
                                        <select id="bulkAction" class="form-select w-auto me-2">
                                            <option value="">-- Select Action --</option>
                                            <option value="2">Verified</option>
                                            <option value="1">UnVerified</option>
                                        </select>
                                        <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                                    </div>
                                @endif
                                <table id="complaintTable3" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>#</th>
                                            <th>Created By</th>
                                            <th>Name</th>
                                            <th>Funding Agency</th>
                                            <th>Created Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @else
            <div class="misc-wrapper">
                <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">401</h1>
                <h4 class="mb-2 mx-2">You are not authorized! 🔐</h4>
                <p class="mb-6 mx-2">You don’t have permission to access this page. Go back!</p>
                <div class="mt-12">
                    <img src="{{ asset('admin/assets/img/illustrations/page-misc-you-are-not-authorized.png') }}"
                        alt="page-misc-not-authorized" width="170" class="img-fluid" />
                </div>
            </div>
        @endif
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
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
        const CURRENT_FACULTY_ID = @json(auth()->user()->faculty_id);
    </script>
@endpush

@push('script')
    <script>
        $(document).ready(function () {
               let classSelect = $('.faculty-class');

                const facultyId = {{ auth()->user()->faculty_id }};
                const selectedClassId = "{{ $data->class_cod }}";
                const selectedTermId = "{{ $data->term_id }}";

                function loadFacultyClasses(termId) {

                    classSelect.empty();

                    if (!termId) {
                        classSelect.append(
                            '<option value="">-- First select term --</option>'
                        );

                        classSelect.prop('disabled', true);
                        return;
                    }

                    classSelect.prop('disabled', false);

                    classSelect.append(
                        '<option value="">Loading...</option>'
                    );

                    $.ajax({
                        url: `/get-faculty-classes/${facultyId}/${termId}`,
                        type: 'GET',

                        success: function (data) {

                            classSelect.empty();

                            if (data.length > 0) {

                                data.forEach(function (cls) {

                                    let selected =
                                        cls.class_id == selectedClassId
                                            ? 'selected'
                                            : '';

                                    classSelect.append(`
                                        <option value="${cls.class_id}" ${selected}>
                                            ${cls.code}
                                        </option>
                                    `);
                                });

                            } else {

                                classSelect.append(
                                    '<option value="">-- No classes found --</option>'
                                );
                            }

                            // Initialize / refresh Select2
                            classSelect.select2();
                        },

                        error: function () {

                            classSelect.empty().append(
                                '<option value="">-- Error loading classes --</option>'
                            );
                        }
                    });
                }


                // When term changes
                $('.term_id').on('change', function () {

                    let termId = $(this).val();

                    // Clear old selected class when user changes term
                    if (termId != selectedTermId) {
                        classSelect.val(null).trigger('change');
                    }

                    loadFacultyClasses(termId);
                });


                // Load existing classes automatically on edit
                if (selectedTermId) {
                    loadFacultyClasses(selectedTermId);
                } else {
                    classSelect.prop('disabled', true);
                }

            
            // Handle form submission
            // SUBMIT UPDATE FORM
            $('#editForm').submit(function (e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('completion-of-course-folder.update', $data->id) }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        Swal.fire('Success', res.message, 'success')
                            .then(() => {
                                window.location.href = "{{ route('completion-of-course-folder.index') }}";
                            });
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

                                // Handle array fields like completion_status[]
                                if (!input.length) {
                                    input = form.find('[name="' + field + '[]"]');
                                }

                                if (input.length) {

                                    input.addClass('is-invalid');

                                    // Remove previous feedback
                                    input.closest('.col-md-12, .mt-4').find('.invalid-feedback').remove();

                                    // Show one error after the last checkbox
                                    input.last().closest('.mt-4, .col-md-12').append(
                                        '<div class="invalid-feedback d-block">' + messages[0] + '</div>'
                                    );
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
@endpush
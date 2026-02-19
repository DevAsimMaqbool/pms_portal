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
                    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Completion of Course Folder</h5>
                                </div>
                            </div>
                            <form id="editForm" enctype="multipart/form-data" class="row">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="form_status" value="{{ $data->form_status }}">
                                <input type="hidden" name="faculty_member_id" value="{{ $data->faculty_member_id }}">
                                <input type="hidden" name="completion_of_Course_folder_indicator_id"
                                    value="{{ $data->completion_of_Course_folder_indicator_id }}">
                                <input type="hidden" name="compliance_and_usage_of_lms_indicator_id"
                                    value="{{ $data->compliance_and_usage_of_lms_indicator_id }}">
                                <input type="hidden" name="record_id" value="{{ $data->id }}">

                                <div class="row g-6 mt-0">

                                    <div id="grant-details-container">
                                        <div class="grant-group row g-3 mb-3 p-3 border border-primary">


                                            <div class="col-md-6 d-none">
                                                <label for="faculty_member" class="form-label">Name of Faculty Member</label>

                                                <input type="hidden" id="faculty_member_id" name="faculty_member_id"
                                                    value="{{ auth()->id() }}">
                                            </div>


                                            <div class="row g-6 mt-0">
                                    <div class="col-md-6">
                                        <label for="class_name" class="form-label">Class</label>
                                        <select name="class_name[]" id="select2Success"
                                            class="select2 form-select faculty-class" multiple required>
                                            @if($data->class_cod)
                                                <option value="{{ $data->class_cod }}" selected>{{ $data->class_cod }}</option>
                                            @endif
                                        </select>
                                    </div>

                                           <div class="col-md-12 mt-3">
                                        <label class="form-label d-block">1- Course Folder Status as per QCH</label>
                                        <div>
                                            <input type="radio" name="completion_of_Course_folder" id="completed"
                                                value="100" {{ $data->completion_of_Course_folder == 100 ? 'checked' : '' }}>
                                            <label for="completed">Completed</label>

                                            <input type="radio" name="completion_of_Course_folder" id="partially_completed"
                                                value="70" {{ $data->completion_of_Course_folder == 70 ? 'checked' : '' }}>
                                            <label for="partially_completed">Partially Completed</label>

                                            <input type="radio" name="completion_of_Course_folder" id="not_Completed"
                                                value="25" {{ $data->completion_of_Course_folder == 25 ? 'checked' : '' }}>
                                            <label for="not_Completed">Not Completed</label>
                                        </div>
                                    </div>



                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-center demo-vertical-spacing">
                                    <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>

                        </div>
                    @endif
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade" id="form3" role="tabpanel">
                            @if(auth()->user()->hasRole(['HOD']))
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

            // Load the classes for faculty
            const facultyId = {{ auth()->user()->faculty_id }};
            $.ajax({
                url: `/get-faculty-classes/${facultyId}`,
                type: 'GET',
                success: function (data) {
                    classSelect.empty();
                    data.forEach(cls => {
                        let selected = cls.class_id == {{ $data->class_cod }} ? 'selected' : '';
                        classSelect.append(`<option value="${cls.class_id}" ${selected}>${cls.code}</option>`);
                    });
                    classSelect.select2();
                }
            });

            // Handle form submission
            // SUBMIT UPDATE FORM
            $('#editForm').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('completion-of-course-folder.update', $data->id) }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (res) {
                        Swal.fire('Success', res.message, 'success')
                            .then(() => {
                                window.location.href = "{{ route('completion-of-course-folder.index') }}";
                            });
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });
            });
        });
    </script>
@endpush
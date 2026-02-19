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
                                <a href="{{ route('completion-of-course-folder.index') }}"
                                    class="btn rounded-pill btn-outline-primary waves-effect" style="margin-right: 17px;">
                                    View</a>
                            </div>
                            <form id="researchForm" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                                <input type="hidden" id="indicator_id" name="completion_of_Course_folder_indicator_id"
                                    value="120">
                                <input type="hidden" id="indicator_id" name="compliance_and_usage_of_lms_indicator_id"
                                    value="121">

                                <div class="row g-6 mt-0">

                                    <div id="grant-details-container">
                                        <div class="grant-group row g-3 mb-3 p-3 border border-primary">


                                            <div class="col-md-6 d-none">
                                                <label for="faculty_member" class="form-label">Name of Faculty Member</label>

                                                <input type="hidden" id="faculty_member_id" name="faculty_member_id"
                                                    value="{{ auth()->id() }}">
                                            </div>


                                            <div class="col-md-6">
                                                <label for="faculty_member" class="form-label">Class</label>
                                                <select name="class_name[]" id="select2Success"
                                                    class="select2 form-select  faculty-class" multiple required>
                                                    <option value="">-- Select classes --</option>
                                                </select>
                                            </div>


                                            <div class="col-md-12">
                                                <label class="form-label d-block">1- Course Folder Status as per QCH</label>
                                                <div>
                                                    <input type="radio" name="completion_of_Course_folder" id="completed"
                                                        value="100">
                                                    <label for="completed">Completed</label>

                                                    <input type="radio" name="completion_of_Course_folder"
                                                        id="partially_completed" value="70" checked>
                                                    <label for="partially_completed">Partially Completed</label>

                                                    <input type="radio" name="completion_of_Course_folder" id="not_Completed"
                                                        value="25">
                                                    <label for="not_Completed">Not Completed</label>
                                                </div>
                                            </div>


                                            <!-- <div class="col-md-12">
                                                                                        <label class="form-label d-block">2- LMS Compliance Status</label>
                                                                                        <div>
                                                                                            <input type="radio" name="compliance_and_usage_of_lms" id="lms_completed"
                                                                                                value="100">
                                                                                            <label for="lms_completed">Completed</label>

                                                                                            <input type="radio" name="compliance_and_usage_of_lms"
                                                                                                id="lms_partially_completed" value="70" checked>
                                                                                            <label for="lms_partially_completed">Partially Completed</label>

                                                                                            <input type="radio" name="compliance_and_usage_of_lms"
                                                                                                id="lms_not_Completed" value="25">
                                                                                            <label for="lms_not_Completed">Not Completed</label>
                                                                                        </div>
                                                                                    </div> -->



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
    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
        <script>
            $(document).ready(function () {


                function loadFacultyClasses() {
                    // Use the current logged-in user's faculty_id
                    let facultyId = CURRENT_FACULTY_ID;

                    // Select all class dropdowns
                    let classSelect = $('.faculty-class');

                    // Show loading message
                    classSelect.empty().append('<option value="">Loading...</option>');

                    // If no faculty ID, show default and stop
                    if (!facultyId) {
                        classSelect.empty().append('<option value="">-- Select classes --</option>');
                        return;
                    }

                    // Make AJAX request to get classes
                    $.ajax({
                        url: `/get-faculty-classes/${facultyId}`,
                        type: 'GET',
                        success: function (data) {
                            // Clear and add default option
                            classSelect.empty().append('<option value="">-- Select classes --</option>');

                            // Add classes from response
                            if (data.length > 0) {
                                data.forEach(function (cls) {
                                    classSelect.append(`<option value="${cls.class_id}">${cls.code}</option>`);
                                });
                            } else {
                                classSelect.append('<option value="">-- No classes found --</option>');
                            }

                            // Initialize/refresh select2
                            classSelect.select2();
                        },
                        error: function () {
                            alert('ssp');
                            classSelect.empty().append('<option value="">-- Error loading classes --</option>');
                        }
                    });
                }

                // Call the function directly
                loadFacultyClasses();







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
                        url: "{{ route('completion-of-course-folder.store') }}",
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
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('no-Of-GrantSubmit-And-Won.index') }}",
                    method: "GET",
                    data: {
                        status: "HOD" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.name || 'N/A',
                                form.funding_agency || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Name" },
                                    { title: "Funding Agency" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#complaintTable3').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
            // ✅ Reusable function for single update
            function updateSingleStatus(id, status) {
                $.ajax({
                    url: `/no-Of-GrantSubmit-And-Won/${id}`,           // single row endpoint
                    type: 'POST',                            // POST with _method PUT
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: res.message || 'Status updated successfully!'
                        });

                        fetchIndicatorForms3();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong!'
                        });
                    }
                });
            }
            $(document).ready(function () {
                fetchIndicatorForms3();
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.currentUserRole === 'HOD') {
                        $('#approveCheckbox').prop('checked', form.status == 2);
                        $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                        // Label text for HOD
                        let statusLabel = "Pending";
                        if (form.status == 1) {
                            statusLabel = "Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        }
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    } else {
                        $('#approveCheckbox').closest('.form-check-input').hide();

                        let statusLabel = "Pending"; // default
                        if (form.status == 1) {
                            statusLabel = "Not Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Approved";
                        }

                        // update the label text
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    }
                    if (form.name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name</th><td>${form.name}</td></tr>`);
                    }

                    if (form.funding_agency) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Funding Agency</th><td>${form.funding_agency}</td></tr>`);
                    }
                    if (form.volume) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Volume</th><td>${form.volume}</td></tr>`);
                    }
                    if (form.role) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Role</th><td>${form.role}</td></tr>`);
                    }
                    if (form.grant_status) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Grant Status</th><td>${form.grant_status}</td></tr>`);
                    }




                    if (form.proof) {
                        let fileUrl = form.proof;
                        let fileExt = fileUrl.split('.').pop().toLowerCase();

                        let filePreview = '';

                        // ✅ If Image → show preview
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                            filePreview = `
                                                                                        <a href="${fileUrl}" target="_blank">
                                                                                            <img src="${fileUrl}" alt="Screenshot" 
                                                                                                style="max-width:200px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                                                                        </a>
                                                                                    `;
                        }
                        // ✅ If PDF → show download button
                        else if (fileExt === 'pdf') {
                            filePreview = `
                                                                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary">
                                                                                            Download PDF
                                                                                        </a>
                                                                                    `;
                        }
                        // ✅ Other files → show generic download link
                        else {
                            filePreview = `
                                                                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-secondary">
                                                                                            Download File
                                                                                        </a>
                                                                                    `;
                        }

                        $('#modalExtraFields').append(`
                                                                                    <tr class="optional-field">
                                                                                        <th>Supporting Document</th>
                                                                                        <td>${filePreview}</td>
                                                                                    </tr>
                                                                                `);
                    }

                    $('#viewFormModal').modal('show');
                });



                // ✅ Single checkbox status change
                $(document).on('change', '#approveCheckbox', function () {
                    const id = $(this).data('id');
                    const status = $(this).is(':checked') ? 2 : 1;
                    updateSingleStatus(id, status);
                });

                // ✅ Bulk submit button
                $('#bulkSubmit').on('click', function () {
                    const status = $('#bulkAction').val();
                    let selectedIds = [];

                    $('#complaintTable3 .rowCheckbox:checked').each(function () {
                        selectedIds.push($(this).val());
                    });

                    if (!status) {
                        Swal.fire({ icon: 'warning', title: 'Select Action', text: 'Please select a status to update.' });
                        return;
                    }
                    if (!selectedIds.length) {
                        Swal.fire({ icon: 'warning', title: 'No Selection', text: 'Please select at least one row.' });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to change status for ${selectedIds.length} item(s).`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedIds.forEach(id => updateSingleStatus(id, status));
                        }
                    });
                });

                // ✅ Select / Deselect all checkboxes
                $(document).on('change', '#selectAll', function () {
                    $('.rowCheckbox').prop('checked', $(this).is(':checked'));
                });
            });
        </script>
    @endif
    @if(auth()->user()->hasRole(['Dean']))
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('no-Of-GrantSubmit-And-Won.index') }}",
                    method: "GET",
                    data: {
                        status: "RESEARCHER" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.name || 'N/A',
                                form.funding_agency || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Name" },
                                    { title: "Funding Agency" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#complaintTable3').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
            // ✅ Reusable function for single update
            function updateSingleStatus(id, status) {
                $.ajax({
                    url: `/no-Of-GrantSubmit-And-Won/${id}`,           // single row endpoint
                    type: 'POST',                            // POST with _method PUT
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: res.message || 'Status updated successfully!'
                        });

                        fetchIndicatorForms3();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong!'
                        });
                    }
                });
            }
            $(document).ready(function () {
                fetchIndicatorForms3();
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.currentUserRole === 'Dean') {
                        $('#approveCheckbox').prop('checked', form.status == 3);
                        $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                        // Label text for Dean
                        let statusLabel = "Pending";
                        if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Verified";
                        }
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    } else {
                        $('#approveCheckbox').closest('.form-check-input').hide();

                        let statusLabel = "Pending"; // default
                        if (form.status == 1) {
                            statusLabel = "Not Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Approved";
                        }

                        // update the label text
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    }

                    if (form.name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name</th><td>${form.name}</td></tr>`);
                    }

                    if (form.funding_agency) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Funding Agency</th><td>${form.funding_agency}</td></tr>`);
                    }
                    if (form.volume) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Volume</th><td>${form.volume}</td></tr>`);
                    }
                    if (form.role) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Role</th><td>${form.role}</td></tr>`);
                    }
                    if (form.grant_status) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Grant Status</th><td>${form.grant_status}</td></tr>`);
                    }




                    if (form.proof) {
                        let fileUrl = form.proof;
                        let fileExt = fileUrl.split('.').pop().toLowerCase();

                        let filePreview = '';

                        // ✅ If Image → show preview
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                            filePreview = `
                                                                                        <a href="${fileUrl}" target="_blank">
                                                                                            <img src="${fileUrl}" alt="Screenshot" 
                                                                                                style="max-width:200px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                                                                        </a>
                                                                                    `;
                        }
                        // ✅ If PDF → show download button
                        else if (fileExt === 'pdf') {
                            filePreview = `
                                                                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary">
                                                                                            Download PDF
                                                                                        </a>
                                                                                    `;
                        }
                        // ✅ Other files → show generic download link
                        else {
                            filePreview = `
                                                                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-secondary">
                                                                                            Download File
                                                                                        </a>
                                                                                    `;
                        }

                        $('#modalExtraFields').append(`
                                                                                    <tr class="optional-field">
                                                                                        <th>Supporting Document</th>
                                                                                        <td>${filePreview}</td>
                                                                                    </tr>
                                                                                `);
                    }


                    $('#viewFormModal').modal('show');
                });



                // ✅ Single checkbox status change
                $(document).on('change', '#approveCheckbox', function () {
                    const id = $(this).data('id');
                    const status = $(this).is(':checked') ? 3 : 2;
                    updateSingleStatus(id, status);
                });

                // ✅ Bulk submit button
                $('#bulkSubmit').on('click', function () {
                    const status = $('#bulkAction').val();
                    let selectedIds = [];

                    $('#complaintTable3 .rowCheckbox:checked').each(function () {
                        selectedIds.push($(this).val());
                    });

                    if (!status) {
                        Swal.fire({ icon: 'warning', title: 'Select Action', text: 'Please select a status to update.' });
                        return;
                    }
                    if (!selectedIds.length) {
                        Swal.fire({ icon: 'warning', title: 'No Selection', text: 'Please select at least one row.' });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to change status for ${selectedIds.length} item(s).`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedIds.forEach(id => updateSingleStatus(id, status));
                        }
                    });
                });

                // ✅ Select / Deselect all checkboxes
                $(document).on('change', '#selectAll', function () {
                    $('.rowCheckbox').prop('checked', $(this).is(':checked'));
                });
            });
        </script>
    @endif
    @if(auth()->user()->hasRole(['ORIC']))
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('no-Of-GrantSubmit-And-Won.index') }}",
                    method: "GET",
                    data: {
                        status: "RESEARCHER" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.name || 'N/A',
                                form.funding_agency || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Name" },
                                    { title: "Funding Agency" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#complaintTable3').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
            // ✅ Reusable function for single update
            function updateSingleStatus(id, status) {
                $.ajax({
                    url: `/no-Of-GrantSubmit-And-Won/${id}`,           // single row endpoint
                    type: 'POST',                            // POST with _method PUT
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: res.message || 'Status updated successfully!'
                        });

                        fetchIndicatorForms3();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong!'
                        });
                    }
                });
            }
            $(document).ready(function () {
                fetchIndicatorForms3();
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.currentUserRole === 'ORIC') {
                        $('#approveCheckbox').prop('checked', form.status == 4);
                        $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                        // Label text for ORIC
                        let statusLabel = "Pending";
                        if (form.status == 3) {
                            statusLabel = "Verified";
                        } else if (form.status == 4) {
                            statusLabel = "Verified";
                        }
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    } else {
                        $('#approveCheckbox').closest('.form-check-input').hide();

                        let statusLabel = "Pending"; // default
                        if (form.status == 1) {
                            statusLabel = "Not Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Approved";
                        }

                        // update the label text
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    }


                    if (form.name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name</th><td>${form.name}</td></tr>`);
                    }

                    if (form.funding_agency) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Funding Agency</th><td>${form.funding_agency}</td></tr>`);
                    }
                    if (form.volume) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Volume</th><td>${form.volume}</td></tr>`);
                    }
                    if (form.role) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Role</th><td>${form.role}</td></tr>`);
                    }
                    if (form.grant_status) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Grant Status</th><td>${form.grant_status}</td></tr>`);
                    }




                    if (form.proof) {
                        let fileUrl = form.proof;
                        let fileExt = fileUrl.split('.').pop().toLowerCase();

                        let filePreview = '';

                        // ✅ If Image → show preview
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                            filePreview = `
                                                                                        <a href="${fileUrl}" target="_blank">
                                                                                            <img src="${fileUrl}" alt="Screenshot" 
                                                                                                style="max-width:200px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                                                                        </a>
                                                                                    `;
                        }
                        // ✅ If PDF → show download button
                        else if (fileExt === 'pdf') {
                            filePreview = `
                                                                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary">
                                                                                            Download PDF
                                                                                        </a>
                                                                                    `;
                        }
                        // ✅ Other files → show generic download link
                        else {
                            filePreview = `
                                                                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-secondary">
                                                                                            Download File
                                                                                        </a>
                                                                                    `;
                        }

                        $('#modalExtraFields').append(`
                                                                                    <tr class="optional-field">
                                                                                        <th>Supporting Document</th>
                                                                                        <td>${filePreview}</td>
                                                                                    </tr>
                                                                                `);
                    }

                    $('#viewFormModal').modal('show');
                });



                // ✅ Single checkbox status change
                $(document).on('change', '#approveCheckbox', function () {
                    const id = $(this).data('id');
                    const status = $(this).is(':checked') ? 4 : 3;
                    updateSingleStatus(id, status);
                });

                // ✅ Bulk submit button
                $('#bulkSubmit').on('click', function () {
                    const status = $('#bulkAction').val();
                    let selectedIds = [];

                    $('#complaintTable3 .rowCheckbox:checked').each(function () {
                        selectedIds.push($(this).val());
                    });

                    if (!status) {
                        Swal.fire({ icon: 'warning', title: 'Select Action', text: 'Please select a status to update.' });
                        return;
                    }
                    if (!selectedIds.length) {
                        Swal.fire({ icon: 'warning', title: 'No Selection', text: 'Please select at least one row.' });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to change status for ${selectedIds.length} item(s).`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedIds.forEach(id => updateSingleStatus(id, status));
                        }
                    });
                });

                // ✅ Select / Deselect all checkboxes
                $(document).on('change', '#selectAll', function () {
                    $('.rowCheckbox').prop('checked', $(this).is(':checked'));
                });
            });
        </script>
    @endif
@endpush
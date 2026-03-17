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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
    @if(in_array(getRoleName(activeRole()), ['International Office','QEC']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                @if(in_array(getRoleName(activeRole()), ['International Office']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Satisfaction of
                                International Students</a>
                        </li>
                        
                    </ul>
                @endif
                <div class="tab-content">
                    @if(in_array(getRoleName(activeRole()), ['International Office']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Satisfaction of International Students</h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'satisfaction_of_international_students', 'id' => $indicatorId]) }}"
                                    class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div>
                            <form id="researchForm1" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden" name="form_status" value="HOD">

                                <div id="student-satisfaction-container">
                                    <div class="student-group row g-3 m-0 border p-3 mt-3 rounded">
                                        <div class="col-md-4">
                                            <label class="form-label">Student Name</label>
                                            <input type="text" name="student_name" class="form-control"
                                                placeholder="Enter Name">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Student Roll No.</label>
                                            <input type="text" name="student_roll_no" class="form-control"
                                                placeholder="Enter Roll No">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Program / Faculty</label>
                                            <input type="text" name="student_program" class="form-control"
                                                placeholder="Program Name">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Country of Origin</label>
                                            <input type="text" name="student_country" class="form-control"
                                                placeholder="Country">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Semester / Year</label>
                                            <input type="text" name="student_semester" class="form-control"
                                                placeholder="e.g., Fall 2025">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="fw-bold mb-2 d-block">Rating</label>
                                            <div id="ratingBox" class="half-star-ratings raty" data-half="true" data-number="5">
                                            </div>

                                            <input type="hidden" name="rating" id="rating" value="">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Comments / Suggestions</label>
                                            <textarea name="student_comments" class="form-control" rows="2"
                                                placeholder="Optional"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if(in_array(getRoleName(activeRole()), ['QEC']))
                        <div class="tab-pane fade show active"
                            id="form2" role="tabpanel">
                               <div class="d-flex">
                                    <select id="bulkAction" class="form-select w-auto me-2">
                                        <option value="">-- Select Action --</option>
                                        <option value="2">Verified</option>
                                        <option value="1">UnVerified</option>
                                    </select>
                                    <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                                </div>
                            <table id="complaintTable3" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Student Name</th>
                                        <th>Status</th>
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


<!-- Modal -->
        <div class="modal fade" id="viewFormModal" tabindex="-1" aria-labelledby="viewFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewFormModalLabel">Form Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Created By</th>
                                <td id="modalCreatedBy"></td>
                            </tr>
                            <tr id="status-approval">
                                <th>Status</th>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <th>Created Date</th>
                                <td id="modalCreatedDate"></td>
                            </tr>
                            <tbody id="modalExtraFields"></tbody>
                        </table>
                        <h5 class="card-title mb-2 me-2 pt-1 mb-2 d-flex align-items-center"><i class="icon-base ti tabler-history me-3"></i>History</h5>
                        <ul class="timeline mb-0" id="modalExtraFieldsHistory">
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Permission Modal -->
        @else
             <div class="misc-wrapper">
                <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">401</h1>
                <h4 class="mb-2 mx-2">You are not authorized! 🔐</h4>
                <p class="mb-6 mx-2">You don’t have permission to access this page. Go back!</p>
                <div class="mt-12">
                    <img src="{{ asset('admin/assets/img/illustrations/page-misc-you-are-not-authorized.png') }}" alt="page-misc-not-authorized" width="170" class="img-fluid" />
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

    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
     <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
        window.activeUserRole = "{{ getRoleName(activeRole()) }}";
    </script>
@endpush
@push('script')
    @if(in_array(getRoleName(activeRole()), ['International Office']))
        <script>
            $(document).ready(function () {
                $('#researchForm1').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('international-st-satisfaction.store') }}",
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
                                    let fieldName = field.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']';
                                    fieldName = fieldName.replace('[]]', ']');
                                    let input = form.find('[name="' + fieldName + '"]');

                                    if (input.length) {
                                        input.addClass('is-invalid');

                                        // Show error message under input
                                        input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                    }
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
    @if(in_array(getRoleName(activeRole()), ['QEC']))
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('international-st-satisfaction.index') }}",
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
                            let statusText = 'N/A';
                            if (form.status == 1) statusText = 'Unverified';
                            else if (form.status == 2) statusText = 'Verified';    

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.student_name || 'N/A',
                                `<span class="badge bg-label-primary">${statusText}</span>`,
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                scrollX: true,
                                scrollCollapse: true,
                                autoWidth: false,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Student Name" },
                                    { title: "Status" },
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
                    url: `/international-st-satisfaction/${id}`,
                    type: 'POST',                            // POST with _method PUT
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status,
                        status_update: true
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
            // ✅ Reusable function for single update
            function updaterejectStatus(id, status,remarks = null) {
                $.ajax({
                    url: `/international-st-satisfaction/${id}`,
                    type: 'POST',                            // POST with _method PUT
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status,
                        reject_status_remarks: remarks,
                        status_reject_update: true
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
                // Extra fields for Form 2
               
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalExtraFieldsHistory').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.activeUserRole === 'QEC') {
                        const statusCell = $('#status-approval td');
                        statusCell.empty(); // clear old checkbox if any

                        // Create Approve radio
                        const approveRadio = $(`
                            <div class="form-check form-check-inline">
                                <input class="form-check-input status-radio" type="radio" 
                                    name="statusRadio-${form.id}" id="approveRadio-${form.id}" 
                                    data-id="${form.id}" value="approve">
                                <label class="form-check-label" for="approveRadio-${form.id}">Approve</label>
                            </div>
                        `);

                        // Create Reject radio
                        const rejectRadio = $(`
                            <div class="form-check form-check-inline">
                                <input class="form-check-input status-radio" type="radio" 
                                    name="statusRadio-${form.id}" id="rejectRadio-${form.id}" 
                                    data-id="${form.id}" value="reject">
                                <label class="form-check-label" for="rejectRadio-${form.id}">Reject</label>
                            </div>
                        `);

                        // Append to cell
                        statusCell.append(approveRadio, rejectRadio);

                        // Pre-select based on existing status
                        if (form.reject_status == 1) {
                            rejectRadio.find('input').prop('checked', true);
                        } else if (form.status == 2) {
                            approveRadio.find('input').prop('checked', true);
                        }
                    }  else {
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
                    if (form.student_name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Student Name</th><td>${form.student_name}</td></tr>`);
                    }

                    if (form.student_roll_no) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Student Roll No</th><td>${form.student_roll_no}</td></tr>`);
                    }
                    if (form.student_program) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Student Program</th><td>${form.student_program}</td></tr>`);
                    }
                    if (form.student_country) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Student Country</th><td>${form.student_country}</td></tr>`);
                    }
                    if (form.student_semester) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Student Semester</th><td>${form.student_semester}</td></tr>`);
                    }
                    if (form.student_rating) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Student Rating</th><td>${form.student_rating}</td></tr>`);
                    }
                    if (form.student_comments) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Student Comments</th><td>${form.student_comments}</td></tr>`);
                    }
                    
                    
                    
                    if (form.update_history) {
                            // Parse JSON string if it's a string
                            let history = typeof form.update_history === 'string' ? JSON.parse(form.update_history) : form.update_history;

                            if (history.length > 0) {
                                
                                let historyHtml = '';

                                history.forEach(update => {
                                    let histortText = 'N/A';

                                    // Role-based status mapping
                                    if (update.role === 'QEC') {
                                        if (update.status == '0') histortText = 'Reject';
                                        else if (update.status == '1') histortText = 'unapproved';
                                        else if (update.status == '2') histortText = 'Approved';
                                    } else {
                                        histortText = update.status; // fallback
                                    }
                                    historyHtml += `
                                        <li class="timeline-item timeline-item-transparent optional-field">
                                            <span class="timeline-point timeline-point-primary"></span>
                                            <div class="timeline-event">
                                                <div class="timeline-header mb-3">
                                                    <h6 class="mb-0">${update.user_name}</h6><small class="text-body-secondary">${new Date(update.updated_at).toLocaleString()}</small>
                                                </div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="badge bg-lighter rounded-3">
                                                     <span class="h6 mb-0 text-body">${update.role || 'N/A'}</span>
                                                    </div>
                                                    <div class="badge bg-lighter rounded-3 ms-2">
                                                     <span class="h6 mb-0 text-body">${histortText}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="badge bg-lighter rounded-3 ms-2">
                                                     <span class="h6 mb-0 text-body">${update.remarks || ''}<span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    `;
                                });

                                $('#modalExtraFieldsHistory').append(historyHtml);
                            }
                        }
                        else {
                            $('#modalExtraFieldsHistory').append(`
                                <li class="optional-field">
                                    <th>No History Avalable</th>
                                </li>
                            `);
                        }
                    $('#viewFormModal').modal('show');
                });
                
               // ✅ Handle radio button change
                $(document).on('change', '.status-radio', function () {
                    const id = $(this).data('id');
                    const value = $(this).val(); // "approve" or "reject"

                    if (value === 'reject') {
                        // Ask for rejection remarks first
                        // Hide current modal temporarily
                        const bootstrapModal = bootstrap.Modal.getInstance(document.getElementById('viewFormModal'));
                        bootstrapModal.hide();
                        Swal.fire({
                            title: 'Add Remarks for Rejection',
                            input: 'textarea',
                            inputPlaceholder: 'Enter remarks...',
                            showCancelButton: true,
                            confirmButtonText: 'Submit',
                            cancelButtonText: 'Cancel',
                            preConfirm: (remarks) => {
                                if (!remarks) {
                                    Swal.showValidationMessage('Remarks are required for rejection');
                                }
                                return remarks;
                            }
                        }).then((result) => {
                            // Show modal again
                            bootstrapModal.show();

                            if (result.isConfirmed) {
                                const remarks = result.value;
                                updaterejectStatus(id, 1, remarks); // 2 for reject
                            } else {
                                // If canceled, uncheck the radio
                                $(`input[name="statusRadio-${id}"]`).prop('checked', false);
                            }
                        });
                    } else if (value === 'approve') {
                        // Approve directly
                        updateSingleStatus(id, 2); // 2 for approve
                    }
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
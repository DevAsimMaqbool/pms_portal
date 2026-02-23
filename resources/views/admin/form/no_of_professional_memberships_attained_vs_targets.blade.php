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
@if(auth()->user()->hasRole(['Dean','HOD']) == activeRole())
<div class="tab-pane fade show active" id="form1" role="tabpanel">
<div class="d-flex justify-content-between">
    <div>
    <h5 class="mb-1">No of Professional Memberships attained vs targets</h5>
    </div>
    <a href="{{ route('indicators_crud.index', ['slug' => 'no_of_professional_memberships_attained_vs_targets', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
</div> 
<h5 class="text-primary" id="indicatorTarget">Target 0</h5>
<form id="researchForm" enctype="multipart/form-data" class="row">
@csrf
<input type="hidden" id="form_status" name="form_status" value="HOD" required>
<input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
<div class="row g-6 mt-0">
<div id="grant-details-container">
<div class="grant-group row g-3 mb-3 p-3 border border-primary">
<div class="col-md-6">
<label for="type_of_membership" class="form-label">Type of Membership</label>
<select name="type_of_membership" id="type_of_membership" class="select2 form-select faculty-member"
required>
<option value="">-- Select Type --</option>
<option value="institutional">Institutional</option>
</select>
</div>

<div class="col-md-6">
<label for="name_of_professional_body" class="form-label">Name of Professional
Body</label>
<input type="text" name="name_of_professional_body" id="name_of_professional_body" class="form-control"
required>
</div>

<div class="col-md-6">
<label for="category_of_body" class="form-label">Category of Body</label>
<select name="category_of_body" id="category_of_body" class="select2 form-select faculty-member"
required>
<option value="">-- Select Program --</option>
<option value="academic">Academic</option>
<option value="professional">Professional</option>
<option value="research">Research</option>
</select>
</div>

<div class="col-md-6">
<label for="discipline" class="form-label">Discipline / Area</label>
<select name="discipline" id="discipline" class="select2 form-select faculty-member" required>
<option value="">-- Select Level --</option>
<option value="business_management">Business & Management</option>
<option value="economics_finance">Economics & Finance</option>
<option value="accounting_auditing">Accounting & Auditing</option>
<option value="engineering">Engineering</option>
<option value="computer_science_it">Computer Science & Information
Technology</option>
<option value="ai_data_science">Artificial Intelligence & Data Science
</option>
<option value="natural_applied_sciences">Natural & Applied Sciences</option>
<option value="social_sciences">Social Sciences</option>
<option value="law_legal_studies">Law & Legal Studies</option>
<option value="education">Education</option>
<option value="health_life_sciences">Health & Life Sciences</option>
<option value="arts_humanities">Arts & Humanities</option>
<option value="islamic_studies_finance">Islamic Studies & Islamic Finance
</option>
<option value="media_communication_studies">Media & Communication Studies
</option>
<option value="environment_sustainability_studies">Environmental &
Sustainability Studies</option>
<option value="public_policy_governance">Public Policy & Governance</option>
<option value="research_development">Research & Development</option>
<option value="quality_assurance_accreditation">Quality Assurance &
Accreditation</option>
<option value="innovation_entrepreneurship">Innovation & Entrepreneurship
</option>
<option value="interdisciplinary_studies">Interdisciplinary Studies</option>
</select>
</div>

<div class="col-md-6">
<label for="level" class="form-label">Level</label>
<select name="level" id="level" class="select2 form-select faculty-member" required>
<option value="">-- Select Level--</option>
<option value="national">National</option>
<option value="international">International</option>
</select>
</div>

<div class="col-md-6">
<label for="country" class="form-label">Country (If International)</label>
<select name="country" id="country"
class="country-dropdown select2 form-select" required>
<option value="">Select Country</option>
@foreach(getAllCountries() as $con)
<option value="{{ $con['code'] }}">
{{ $con['name'] }}
</option>
@endforeach
</select>
</div>

<div class="col-md-6">
<label for="membership_status" class="form-label">Membership Status</label>
<select name="membership_status" id="membership_status" class="select2 form-select faculty-member" required>
<option value="">-- Select Scope --</option>
<option value="new">New</option>
<option value="renewed">Renewed</option>
</select>
</div>

<div class="col-md-6">
<label class="form-label">Membership Start Date</label>
<input type="date" name="membership_start_date" id="membership_start_date" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Membership Valid Until</label>
<input type="date" name="membership_valid_until" id="membership_valid_until" class="form-control" required>
</div>

<div class="col-md-6">
<label class="fw-medium d-block form-label">Evidence Type</label>
<div class="form-check form-check-inline mt-4">
<input class="form-check-input" type="checkbox" id="evidence_type" name="evidence_type[]" value="certificate" checked>
<label for="certificate">Certificate</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="checkbox" id="evidence_type" name="evidence_type[]" value="email_confirmation">
<label for="email_confirmation">Email Confirmation</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="checkbox" id="evidence_type" name="evidence_type[]" value="invoice">
<label for="invoice">Invoice</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="checkbox" id="evidence_type" name="evidence_type[]" value="mou">
<label for="mou">MOU</label>
</div>
</div>

<div class="col-md-12">
<label class="form-label d-block">Upload Supporting Document</label>
<div>
<input class="form-control" name="document_link" type="file" id="document_link">
</div>
</div>

<div class="col-12 mt-4">
<h6>Declaration</h6>
<div class="form-check">
<input class="form-check-input" type="checkbox" name="declaration"  id="declaration"  value="1">
<label class="form-check-label">I confirm that the information provided is accurate and supported by valid evidence.</label>
</div>
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
@if(auth()->user()->hasRole(['QEC']) == activeRole())
    <div class="tab-pane fade show {{ auth()->user()->hasRole(['QEC']) ? 'active' : '' }}"
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
                    <th>Deliverables</th>
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
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="approveCheckbox">
                                        <label class="form-check-label" for="approveCheckbox">Approved</label>
                                    </div>
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
        window.activeUserRole = "{{ activeRole() }}";
    </script>
@endpush
@push('script')
    @if(auth()->user()->hasRole(['Dean','HOD']) == activeRole())
        <script>
            $(document).ready(function () {
                function fetchTarget(indicatorId) {

                    if (!indicatorId) {
                        $('#indicatorTarget').text('Target: N/A');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('faculty-target.getTarget') }}",
                        type: "GET",
                        data: {
                            indicator_id: indicatorId
                        },
                        success: function(res) {
                            if (res.target) {
                                $('#indicatorTarget').text('Target: ' + res.target);
                            } else {
                                $('#indicatorTarget').text('Target: N/A');
                            }
                        },
                        error: function() {
                            $('#indicatorTarget').text('Target: N/A');
                        }
                    });
                }

                // ✅ Pass PHP variable safely
                fetchTarget({{ $indicatorId }});

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
                        url: "{{ route('professional-membership.store') }}",
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
    @if(auth()->user()->hasRole(['QEC']) == activeRole())
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('professional-membership.index') }}",
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
                                form.name_of_professional_body || 'N/A',
                                `<span class="badge bg-label-primary">${statusText}</span>`,
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
                                    { title: "Name of Professional Body" },
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
                    url: `/professional-membership/${id}`,
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
                    if (window.activeUserRole === 'qec') {
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
                    if (form.name_of_professional_body) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name of professional body</th><td>${form.name_of_professional_body}</td></tr>`);
                    }

                    if (form.type_of_membership) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Type of Membership</th><td>${form.type_of_membership}</td></tr>`);
                    }
                    if (form.category_of_body) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Category of body</th><td>${form.category_of_body}</td></tr>`);
                    }
                     if (form.level) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Level</th><td>${form.level}</td></tr>`);
                    }
                    if (form.membership_status) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Membership status</th><td>${form.membership_status}</td></tr>`);
                    }
                    if (form.membership_start_date) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Membership start date</th><td>${form.membership_start_date}</td></tr>`);
                    }
                    if (form.membership_valid_until) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Membership valid until</th><td>${form.membership_valid_until}</td></tr>`);
                    }
                    if (form.evidence_type) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Evidence Type</th><td>${form.evidence_type}</td></tr>`);
                    }
                    if (form.document_link) {
                        let fileUrl = form.document_link;
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
                    
                    
                    
                    if (form.update_history) {
                            // Parse JSON string if it's a string
                            let history = typeof form.update_history === 'string' ? JSON.parse(form.update_history) : form.update_history;

                            if (history.length > 0) {
                                
                                let historyHtml = '';

                                history.forEach(update => {
                                    let histortText = 'N/A';

                                    // Role-based status mapping
                                    if (update.role === 'qec') {
                                        if (update.status == '1') histortText = 'unapproved';
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
@endpush
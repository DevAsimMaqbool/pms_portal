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
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                <!-- Tab panes -->
                <div class="tab-content">
                     @if(auth()->user()->hasRole(['Dean']) == activeRole())
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h5 class="mb-1">No of Programs accredited or affiliated nationally/ Internationally and ranking</h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'no_of_programs_accredited_or_affiliated_nationally_internationally_and_ranking', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div> 
                            <form id="researchForm" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                <div class="row g-6 mt-0">
                                    <div id="grant-details-container">
                                        <div class="grant-group row g-3 mb-3 p-3 border border-primary">
                                            <div class="col-md-6">
                                                <label for="faculty" class="form-label">Faculty</label>
                                                <select name="faculty_id" id="faculty_id" class="select2 form-select" required>
                                                    <option value="">-- Select Faculty --</option>
                                                    @foreach(get_faculties() as $faculty)
                                                        <option value="{{ $faculty->id }}">
                                                            {{ $faculty->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="department_id" class="form-label">Department</label>
                                                <select name="department_id" id="department_id" class="select2 form-select"
                                                    required>
                                                    <option value="">-- Select Department --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="program" class="form-label">Program</label>
                                                <select name="program_id" id="program_id" class="select2 form-select program_id"
                                                    required>
                                                    <option value="">-- Select Program --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="program_level" class="form-label">Program Level</label>
                                                <select name="program_level" id="program_level"
                                                    class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Level --</option>
                                                    <option value="UG">UG</option>
                                                    <option value="PG">PG</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="recognition_type" class="form-label">Recognition Type</label>
                                                <select name="recognition_type" id="recognition_type"
                                                    class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Type --</option>
                                                    <option value="accreditation">Accreditation</option>
                                                    <option value="affiliation">Affiliation</option>
                                                    <option value="ranking">Ranking</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="ranking_body" class="form-label ">Accrediting</label>
                                                <select name="accrediting" id="accrediting"
                                                    class="select2 form-select faculty-member accrediting" required>
                                                    <option value="">-- Select Body --</option>
                                                    <option value="PBC">Pakistan Bar Council (PBC)</option>
                                                    <option value="PCATP">Pakistan Council for Architects and Town Planners
                                                        (PCATP)</option>
                                                    <option value="PMDC">Pakistan Medical & Dental Council (PMDC)</option>
                                                    <option value="PEC">Pakistan Engineering Council (PEC)</option>
                                                    <option value="PNC">Pakistan Nursing Council (PNC)</option>
                                                    <option value="PCP">Pakistan Pharmacy Council (PCP)</option>
                                                    <option value="PVMC">Pakistan Veterinary Medical Council (PVMC)</option>
                                                    <option value="NCH">National Council for Homoeopathy (NCH)</option>
                                                    <option value="NCT">National Council for Tibb (NCT)</option>
                                                    <option value="AHP">Allied Health Professionals</option>
                                                    <option value="NACTE">National Accreditation Council for Teachers Education
                                                        (NACTE)</option>
                                                    <option value="NAEAC">National Agricultural Education Accreditation Council
                                                        (NAEAC)</option>
                                                    <option value="NCEAC">National Computing Education Accreditation Council
                                                        (NCEAC)</option>
                                                    <option value="NBEAC">National Business Education Accreditation Council
                                                        (NBEAC)</option>
                                                    <option value="NTC">National Technology Council (NTC)</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                             <!-- Hidden Other Field -->
                                            <div class="col-md-6 d-none" id="other_cpd_box">
                                                <label class="form-label">Other Detail</label>
                                                <input type="text"
                                                    name="accrediting_other_detail" id="accrediting_other_detail"
                                                    class="form-control"
                                                    placeholder="Enter other detail">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Affiliated Body Name</label>
                                                <input type="text"
                                                    name="affiliated_body_name" id="affiliated_body_name"
                                                    class="form-control"
                                                    placeholder="Affiliated Body Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Affiliated for</label>
                                                <input type="text"
                                                    name="affiliated_for" id="affiliated_for"
                                                    class="form-control"
                                                    placeholder="Application for">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="scope" class="form-label">Scope (Nat./Int.)</label>
                                                <select name="scope" id="scope" class="select2 form-select faculty-member"
                                                    required>
                                                    <option value="">-- Select Scope --</option>
                                                    <option value="national">National</option>
                                                    <option value="international">International</option>
                                                </select>
                                            </div>



                                            <div class="col-md-6">
                                                <label class="form-label">Validity From</label>
                                                <input type="date" name="validity_from" id="validity_from" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Validity To</label>
                                                <input type="date" name="validity_to" id="validity_to" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="university_ranking" class="form-label">Ranking System (if
                                                    any)</label>
                                                <select class="select2 form-select faculty-member" id="university_ranking"
                                                    name="university_ranking" required>
                                                    <option value="">-- Select Ranking --</option>
                                                    <option value="qs_world">QS World University Rankings</option>
                                                    <option value="the">Times Higher Education (THE)</option>
                                                    <option value="arwu">Academic Ranking of World Universities (ARWU)
                                                    </option>
                                                    <option value="us_news">U.S. News & World Report</option>
                                                    <option value="webometrics">Webometrics Ranking of World Universities
                                                    </option>
                                                    <option value="cwts_leiden">CWTS Leiden Ranking</option>
                                                    <option value="scimago">SCImago Institutions Rankings</option>
                                                    <option value="round_university">Round University Ranking</option>
                                                    <option value="unirank">UniRank</option>
                                                    <option value="qs_asia">QS Asia University Rankings</option>
                                                    <option value="qs_arab">QS Arab Region University Rankings</option>
                                                    <option value="the_asia">THE Asia University Rankings</option>
                                                    <option value="the_emerging">THE Emerging Economies Rankings</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Ranking Position / Band</label>
                                                <input type="number" name="ranking_position" id="ranking_position"
                                                    class="form-control" min="1" step="1" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="evidence_available" class="form-label">Evidence Available
                                                    (Y/N)</label>
                                                <select name="evidence_available" id="evidence_available"
                                                    class="select2 form-select evidence_available" required>
                                                    <option value="">-- Select Evidence --</option>
                                                    <option value="yes">Y</option>
                                                    <option value="no">N</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label d-block">Document Link / Ref</label>
                                                <div>
                                                    <input class="form-control" name="document_link" type="file"
                                                        id="document_link">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label d-block">Remarks</label>
                                                <div>
                                                    <textarea class="form-control" id="remarks" name="remarks"
                                                        rows="4"></textarea>
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
                                        <th>Scope</th>
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
        window.activeUserRole = "{{ activeRole() }}";
    </script>
@endpush
@push('script')
    @if(auth()->user()->hasRole(['Dean']) == activeRole())
        <script>
            $(document).ready(function () {
            
            function toggleRecognitionFields() {

                    let type = $('#recognition_type').val();

                    // Wrap groups (closest col-md-6)
                    let rankingFields = $('#university_ranking').closest('.col-md-6')
                                        .add($('#ranking_position').closest('.col-md-6'));

                    let accreditationFields = $('#accrediting').closest('.col-md-6')
                                            .add($('#other_cpd_box'));

                    let affiliationFields = $('#affiliated_body_name').closest('.col-md-6')
                                            .add($('#affiliated_for').closest('.col-md-6'));

                    // Hide all first
                    rankingFields.add(accreditationFields).add(affiliationFields).hide();
                    $('#university_ranking, #ranking_position, #accrediting, #affiliated_body_name, #affiliated_for')
                        .prop('required', false);

                    // Show based on selection
                    if (type === 'ranking') {
                        rankingFields.show();
                        $('#university_ranking, #ranking_position').prop('required', true);
                    }

                    if (type === 'accreditation') {
                        accreditationFields.show();
                        $('#accrediting').prop('required', true);
                    }

                    if (type === 'affiliation') {
                        affiliationFields.show();
                        $('#affiliated_body_name, #affiliated_for').prop('required', true);
                    }
                }

                // Trigger on change
                $('#recognition_type').on('change', toggleRecognitionFields);

                // Run once on load
                toggleRecognitionFields();


                // ✅ Show Other textbox when accrediting = Other
                $('#accrediting').on('change', function () {
                    if ($(this).val() === 'Other') {
                        $('#other_cpd_box').removeClass('d-none');
                    } else {
                        $('#other_cpd_box').addClass('d-none');
                        $('#accrediting_other_detail').val('');
                    }
                });


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
                        url: "{{ route('no-of-programs-accredited.store') }}",
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

                $('#faculty_id').on('change', function () {

                    let facultyId = $(this).val();
                    let departmentSelect = $('#department_id');
                    let programSelect = $('#program_id');

                    departmentSelect.html('<option value="">Loading...</option>');
                    programSelect.html('<option value="">-- Select Program --</option>');


                    if (facultyId) {
                        $.ajax({
                            url: "/get-departments/" + facultyId,
                            type: "GET",
                            success: function (response) {

                                departmentSelect.empty();
                                departmentSelect.append('<option value="">-- Select Department --</option>');

                                $.each(response, function (key, department) {
                                    departmentSelect.append(
                                        `<option value="${department.id}">
                                                    ${department.name}
                                                </option>`
                                    );
                                });

                                departmentSelect.trigger('change'); // refresh select2
                            }
                        });
                    } else {
                        departmentSelect.html('<option value="">-- Select Department --</option>');
                    }
                });
                $('#department_id').on('change', function () {

                    let departmentId = $(this).val();
                    let programSelect = $('#program_id');

                    programSelect.html('<option value="">Loading...</option>');

                    if (departmentId) {
                        $.ajax({
                            url: "/get-programs/" + departmentId,
                            type: "GET",
                            success: function (response) {

                                programSelect.empty();
                                programSelect.append('<option value="">-- Select Program --</option>');

                                $.each(response, function (key, program) {
                                    programSelect.append(
                                        `<option value="${program.id}">
                                                    ${program.program_name}
                                                </option>`
                                    );
                                });

                                programSelect.trigger('change'); // refresh select2
                            },
                            error: function () {
                                programSelect.html('<option value="">Error loading programs</option>');
                            }
                        });
                    } else {
                        programSelect.html('<option value="">-- Select Program --</option>');
                    }
                });

            });
        </script>
    @endif
    @if(auth()->user()->hasRole(['QEC']) == activeRole())
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('no-of-programs-accredited.index') }}",
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
                                form.faculty ? form.faculty.name : 'N/A',
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
                                    { title: "Faculty" },
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
                    url: `/no-of-programs-accredited/${id}`,
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
                    if (form.faculty.name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Faculty</th><td>${form.faculty.name}</td></tr>`);
                    }

                    if (form.department.name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Department</th><td>${form.department.name}</td></tr>`);
                    }
                    if (form.program.program_name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Program</th><td>${form.program.program_name}</td></tr>`);
                    }
                     if (form.program_level) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Program</th><td>${form.program_level}</td></tr>`);
                    }
                    if (form.recognition_type) {
                        if (form.recognition_type === 'accreditation') {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Recognition Type</th><td>Accreditation</td></tr>`);
                        

                        }else
                        if (form.recognition_type === 'affiliation') {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Recognition Type</th><td>Affiliation</td></tr>`);
                        if (form.affiliated_body_name) {
                            $('#modalExtraFields').append(`<tr class="optional-field"><th>Affiliated Body Name</th><td>${form.affiliated_body_name}</td></tr>`);
                        }
                        if (form.affiliated_for) {
                            $('#modalExtraFields').append(`<tr class="optional-field"><th>Affiliated for</th><td>${form.affiliated_for}</td></tr>`);
                        }
                        }else
                        if (form.recognition_type === 'ranking') {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Recognition Type</th><td>Ranking</td></tr>`);
                        
                        }
                    }
                   




                    if (form.validity_from) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Validity From</th><td>${form.validity_from}</td></tr>`);
                    }
                    if (form.validity_to) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Validity To</th><td>${form.validity_to}</td></tr>`);
                    }
                    if (form.evidence_available) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Evidence Available (Y/N)</th><td>${form.evidence_available}</td></tr>`);
                    }
                    if (form.remarks) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Remarks</th><td>${form.remarks}</td></tr>`);
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
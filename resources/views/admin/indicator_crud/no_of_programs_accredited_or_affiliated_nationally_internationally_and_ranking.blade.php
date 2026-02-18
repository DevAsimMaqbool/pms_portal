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
             <h5 class="card-header">No of Programs accredited or affiliated nationally/ Internationally and ranking</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="intellectualTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Recognition Type</th>
                                                        <th>Scope</th>
                                                        <th>Validity From</th>
                                                        <th>Validity To</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                            </div>    
                        </div>
                    @endif
                   
            </div>
        </div>
        <!-- Update Intellectual Property Modal -->
           <!-- Modal -->
       <div class="modal fade" id="viewFormModal" tabindex="-1" aria-labelledby="viewFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="viewFormModalLabel">
                <i class="icon-base ti tabler-history me-3"></i>History
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered mb-3"> 
                <tr>
                    <td>
                        <div class="d-flex justify-content-left align-items-center">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-info">🙍🏻‍♂️</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-50">
                                <span class="text-truncate fw-medium text-heading" id="modalCreatedBy">Website SEO</span>
                                <small class="text-truncate" id="modalCreatedDate"></small>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <h5 class="card-title mb-2 me-2 pt-1 mb-2 d-flex align-items-center">
                <i class="icon-base ti tabler-history me-3"></i>History
            </h5>
            <ul class="timeline mb-0" id="modalExtraFieldsHistory"></ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

        <!--/ Add Permission Modal -->
 <!-- Update commercial gain Modal -->
<div class="modal fade" id="multidisciplinaryProjectFormModal" tabindex="-1" aria-labelledby="commericaGainFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commericaGainFormModalLabel">Edit No of Programs accredited or affiliated nationally/ Internationally and ranking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row g-3">  




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
                            <option value="ug">UG</option>
                            <option value="grad">Grad</option>
                            <option value="phd">PhD</option>
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
                        <div id="intellectual-img"></div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label d-block">Remarks</label>
                        <div>
                            <textarea class="form-control" id="remarks" name="remarks"
                                rows="4"></textarea>
                        </div>
                    </div>
                 
                        
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
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
    </script>
@endpush
@push('script')
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('no-of-programs-accredited.index') }}",
                    method: "GET",
                    data: {
                        status: "HOD" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            
                            let editButton = '';
                            if (parseInt(form.status) === 1) {
                                editButton = `
                                    <button class="btn rounded-pill btn-outline-primary waves-effect edit-form-btn" 
                                        data-form='${JSON.stringify(form)}'>
                                        <span class="icon-xs icon-base ti tabler-eye me-2"></span>Edit
                                    </button>`;
                            }  
                            const deleteBtn = `<button class="btn rounded-pill btn-outline-danger delete-btn" data-id="${form.id}">Delete</button>`;      

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.recognition_type || 'N/A',
                                form.scope|| 'N/A',
                                form.validity_from|| 'N/A',
                                form.validity_to|| 'N/A',
                                editButton+ ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#intellectualTable')) {
                            $('#intellectualTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Recognition Type" },
                                    { title: "Scope" },
                                    { title: "Validity From" },
                                    { title: "Validity To" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#intellectualTable').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
                
    
            $(document).ready(function () {
                
                fetchCommercialForms();
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
                $(document).on('click', '.view-form-btn', function () {
                // Clear modal
                $('#modalExtraFieldsHistory').empty();
                $('#modalCreatedBy').text('');
                $('#modalCreatedDate').text('');

                // Read data-history
                let historyData = $(this).attr('data-history'); // raw string
                let history = [];

                try {
                    // Decode HTML entities first
                    historyData = historyData.replace(/&quot;/g, '"'); // convert &quot; → "
                    // Parse JSON (sometimes it's double-encoded)
                    history = JSON.parse(historyData);
                    if (typeof history === 'string') {
                        history = JSON.parse(history); // decode inner string if needed
                    }
                } catch (e) {
                    console.error('Failed to parse history JSON:', e);
                    history = [];
                }

                // Creator and created date
                let creator = $(this).data('user') || 'N/A';
                let created = $(this).data('created') || 'N/A';
                $('#modalCreatedBy').text(creator);
                $('#modalCreatedDate').text(new Date(created).toLocaleString());

                // Build timeline
                if (Array.isArray(history) && history.length > 0) {
                    let historyHtml = '';
                    history.forEach(update => {
                        let histortText = 'N/A';
                        if (update.role === 'HOD') histortText = update.status == '1' ? 'unapproved' : (update.status == '2' ? 'Approved' : update.status);
                        else if (update.role === 'ORIC') histortText = update.status == '2' ? 'Unverified' : (update.status == '3' ? 'Verified' : update.status);
                        else histortText = update.status || 'N/A';

                        historyHtml += `
                            <li class="timeline-item timeline-item-transparent optional-field">
                                <span class="timeline-point timeline-point-primary"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-3">
                                        <h6 class="mb-0">${update.user_name || 'N/A'}</h6>
                                        <small class="text-body-secondary">${new Date(update.updated_at).toLocaleString()}</small>
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
                } else {
                    $('#modalExtraFieldsHistory').append(`<li class="optional-field"><span>No History Available</span></li>`);
                }

                $('#viewFormModal').modal('show');
            });
            function populateFacultyDepartmentProgram(form) {
                const facultySelect = $('#faculty_id');
                const departmentSelect = $('#department_id');
                const programSelect = $('#program_id');

                // Set faculty and trigger change
                facultySelect.val(form.faculty_id).trigger('change');

                if (!form.faculty_id) return;

                // Load Departments
                $.ajax({
                    url: "/get-departments/" + form.faculty_id,
                    type: "GET",
                    success: function (departments) {
                        departmentSelect.empty().append('<option value="">-- Select Department --</option>');

                        $.each(departments, function (key, department) {
                            departmentSelect.append(`<option value="${department.id}">${department.name}</option>`);
                        });

                        // Set department
                        departmentSelect.val(form.department_id).trigger('change');

                        if (!form.department_id) return;

                        // Load Programs
                        $.ajax({
                            url: "/get-programs/" + form.department_id,
                            type: "GET",
                            success: function (programs) {
                                programSelect.empty().append('<option value="">-- Select Program --</option>');

                                $.each(programs, function (key, program) {
                                    programSelect.append(`<option value="${program.id}">${program.program_name}</option>`);
                                });

                                // Set program
                                programSelect.val(form.program_id).trigger('change');
                            },
                            error: function () {
                                programSelect.html('<option value="">Error loading programs</option>');
                            }
                        });
                    },
                    error: function () {
                        departmentSelect.html('<option value="">Error loading departments</option>');
                    }
                });
            }
            $(document).on('click', '.edit-form-btn', function () {
        const form = $(this).data('form');
        
        $('#researchForm1')[0].reset();
       $('#researchForm1 #intellectual-img').html('');
   
        $('#researchForm1 #record_id').val(form.id);
        populateFacultyDepartmentProgram(form);
        $('#researchForm1 #program_level').val(form.program_level).trigger('change');
        $('#researchForm1 #validity_from').val(form.validity_from);
        $('#researchForm1 #validity_to').val(form.validity_to);
        $('#researchForm1 #remarks').val(form.remarks);
        $('#researchForm1 #evidence_available').val(form.evidence_available).trigger('change');
        $('#researchForm1 #scope').val(form.scope).trigger('change');
        $('#researchForm1 #recognition_type').val(form.recognition_type).trigger('change');
        // =============================
        // Conditional field population
        // =============================

        // ---- RANKING ----
        if (form.recognition_type === 'ranking') {

            $('#researchForm1 #university_ranking')
                .val(form.university_ranking)
                .trigger('change');

            $('#researchForm1 #ranking_position')
                .val(form.ranking_position);
        }


        // ---- ACCREDITATION ----
        if (form.recognition_type === 'accreditation') {

            $('#researchForm1 #accrediting')
                .val(form.accrediting)
                .trigger('change');

            // Show OTHER textbox
            if (form.accrediting === 'Other') {
                $('#researchForm1 #other_cpd_box').removeClass('d-none');
                $('#researchForm1 #accrediting_other_detail')
                    .val(form.accrediting_other_detail);
            }
        }


        // ---- AFFILIATION ----
        if (form.recognition_type === 'affiliation') {

            $('#researchForm1 #affiliated_body_name')
                .val(form.affiliated_body_name);

            $('#researchForm1 #affiliated_for')
                .val(form.affiliated_for);
        }

        


        // Show proof container based on status
       
        if (form.document_link) {
            let fileUrl = form.document_link;
            let fileExt = fileUrl.split('.').pop().toLowerCase();

            let filePreview = '';

            // ✅ If Image → show preview
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                filePreview = `<div class="avatar avatar-xl me-3 mt-2 bg-secondary">
                    <a href="${fileUrl}" target="_blank">
                        <img src="${fileUrl}" alt="Screenshot" class="rounded-circle">
                    </a></div>
                `;
            }
            // ✅ If PDF → show download button
            else if (fileExt === 'pdf') {
                filePreview = `
                    <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary mt-3">
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

            $("#intellectual-img").html(filePreview);
        }
        

        
        

        $('#multidisciplinaryProjectFormModal').modal('show');
    });
   
      // Submit updated data
    $('#researchForm1').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);
        const recordId = $('#record_id').val();
        Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });


        $.ajax({
            url: "{{ route('no-of-programs-accredited.update', '') }}/" + recordId,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                Swal.close();
                Swal.fire('Success', response.message, 'success');
                $('#multidisciplinaryProjectFormModal').modal('hide');
                $('#researchForm1')[0].reset();
                form.find('.invalid-feedback').remove();
                form.find('.is-invalid').removeClass('is-invalid');
                fetchCommercialForms(); // reload table
            },
            error: function (xhr) {
                Swal.close();
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        let input = $('#researchForm1').find('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            }
        });
    });
    $(document).on('click', '.delete-btn', function() {
    let id = $(this).data('id');

    if(!confirm('Are you sure you want to delete this record?')) return;

    $.ajax({
        url: `/no-of-programs-accredited/${id}`,
        type: 'DELETE',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function(res) {
            alert(res.message);
            fetchCommercialForms();
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Failed to delete record.');
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
@endpush
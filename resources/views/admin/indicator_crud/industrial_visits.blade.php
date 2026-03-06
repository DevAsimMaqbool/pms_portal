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
      @if(in_array(getRoleName(activeRole()), ['HOD','Professor','Assistant Professor','Associate Professor']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
             <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Industrial Visits</h5>
                </div>
                <div class="">
                    <a href="{{ url('kpa/2/category/8/indicator/197') }}" class="btn btn-primary">Add</a>
                </div>
            </div>
            <div class="card-datatable table-responsive card-body">
                     @if(in_array(getRoleName(activeRole()), ['HOD','Professor','Assistant Professor','Associate Professor']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="intellectualTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Created By</th>
                                                        <th>Employee Name</th>
                                                        <th>Industry Sector</th>
                                                        <th>Created Date</th>
                                                        <th>History</th>
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
<div class="modal fade" id="commercialGainFormModal" tabindex="-1" aria-labelledby="commericaGainFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commericaGainFormModalLabel">Industrial Visits</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">


                    <div class="row">
                                    <!-- First column-->
                                    <div class="col-12 col-lg-8">
                                        <!-- Product Information -->
                                        <div class="card mb-6">

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Employee Name</label>
                                                        <input type="text" name="employee_name" id="employee_name" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Employee ID</label>
                                                        <input type="text" name="employee_id" id="employee_id" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Designation</label>
                                                        <input type="text" name="designation" id="designation" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Department / Program</label>
                                                        <input type="text" name="department_program" id="department_program" class="form-control"
                                                            required>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Campus / Unit</label>
                                                        <input type="text" name="campus_unit" id="campus_unit" class="form-control">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Industry / Organization Visited</label>
                                                        <input type="text" name="industry_organization" id="industry_organization" class="form-control"
                                                            required>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="sector" class="form-label">Industry Sector</label>
                                                        <select name="industry_sector" id="industry_sector" class="select2 form-selec" required>
                                                            <option value="">Select</option>
                                                            <option value="Manufacturing">Manufacturing</option>
                                                            <option value="Services">Services</option>
                                                            <option value="Information Technology (IT)">Information Technology
                                                                (IT)</option>
                                                            <option value="Banking & Finance">Banking & Finance</option>
                                                            <option value="Insurance">Insurance</option>
                                                            <option value="FMCG & Consumer Goods">FMCG & Consumer Goods</option>
                                                            <option value="Retail & E-Commerce">Retail & E-Commerce</option>
                                                            <option value="Energy & Utilities">Energy & Utilities</option>
                                                            <option value="Oil & Gas">Oil & Gas</option>
                                                            <option value="Construction & Real Estate">Construction & Real
                                                                Estate</option>
                                                            <option value="Healthcare & Pharmaceuticals">Healthcare &
                                                                Pharmaceuticals</option>
                                                            <option value="Agriculture & Agribusiness">Agriculture &
                                                                Agribusiness</option>
                                                            <option value="Education & Training">Education & Training</option>
                                                            <option value="Media & Communications">Media & Communications
                                                            </option>
                                                            <option value="Logistics & Transportation">Logistics &
                                                                Transportation</option>
                                                            <option value="Hospitality & Tourism">Hospitality & Tourism</option>
                                                            <option value="Telecommunications">Telecommunications</option>
                                                            <option value="Engineering & Industrial Services">Engineering &
                                                                Industrial Services</option>
                                                            <option value="Government / Public Sector">Government / Public
                                                                Sector</option>
                                                            <option value="Development Sector / NGO">Development Sector / NGO
                                                            </option>
                                                            <option value="Research & Development">Research & Development
                                                            </option>
                                                            <option value="Startups & Entrepreneurship">Startups &
                                                                Entrepreneurship</option>
                                                            <option value="Environmental & Sustainability">Environmental &
                                                                Sustainability</option>
                                                            <option value="Other (Specify)">Other (Specify)</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Purpose / Learning Objective</label>
                                                        <input type="text" name="purpose_learning_objective" id="purpose_learning_objective"
                                                            class="form-control" required>
                                                    </div>


                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Course / Subject Linked</label>
                                                        <input type="text" name="course_subject" id="course_subject" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">No. of Students Involved</label>
                                                        <input type="number" name="students_involved" id="students_involved" class="form-control"
                                                            required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Employee Role</label>
                                                        <select name="employee_role" id="employee_role" class="form-control" required>
                                                            <option value="Organizer" >Organizer</option>
                                                            <option value="Coordinator" >Coordinator</option>
                                                            <option value="Faculty-in-Charge">Faculty-in-Charge</option>
                                                            <option value="Participant">Participant</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Visit Category</label>
                                                        <select name="visit_category" id="visit_category" class="form-control" required>
                                                            <option value="Local">Local</option>
                                                            <option value="National">National</option>
                                                            <option value="International">International</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Evidence Upload</label>
                                                        <input type="file" name="evidence_upload" id="evidence_upload" class="form-control" >
                                                        <div id="intellectual-img"></div>
                                                    </div>






                                                </div>
                                                <!-- Description -->

                                            </div>
                                        </div>
                                        <!-- /Product Information -->


                                    </div>
                                    <!-- /Second column -->

                                    <!-- Second column -->
                                    <div class="col-12 col-lg-4">
                                        <!-- Pricing Card -->
                                        <div class="card mb-3">

                                            <div class="card-body">


                                                <div class="mb-3">
                                                    <label class="form-label">Visit Start Date</label>
                                                    <input type="date" name="visit_start_date" id="visit_start_date" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Visit End Date</label>
                                                    <input type="date" name="visit_end_date" id="visit_end_date" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" name="location" id="location" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Visit Report Submitted</label>
                                                    <select name="visit_report_submitted" id="visit_report_submitted" class="form-control" required>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Report Submission Date</label>
                                                    <input type="date" name="report_submission_date" id="report_submission_date" class="form-control">
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Second column -->
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
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
@endpush
@push('script')
    @if(in_array(getRoleName(activeRole()), ['HOD','Professor','Assistant Professor','Associate Professor']))
        <script>
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('industrial-visit.index') }}",
                    method: "GET",
                    data: {
                        status: "Teacher" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';
                            let editButton = '';
                            if (parseInt(form.status) === 1) {
                                editButton = `
                                    <button class="btn rounded-pill btn-outline-primary waves-effect edit-form-btn" 
                                        data-form='${JSON.stringify(form)}'>
                                        <span class="icon-xs icon-base ti tabler-eye me-2"></span>Edit
                                    </button>`;
                            }       

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.employee_name || 'N/A',
                                form.industry_sector || 'N/A',
                                createdAt,
                                 `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn"
                                    data-history='${JSON.stringify(form.update_history)}'
                                    data-user='${form.creator ? form.creator.name : "N/A"}'
                                    data-created='${form.created_at}'>
                                    <span class="icon-xs icon-base ti tabler-history me-2"></span>History
                                </button>`,
                                editButton
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#intellectualTable')) {
                            $('#intellectualTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Employee Name" },
                                    { title: "Industry Sector" },
                                    { title: "Created Date" },
                                    { title: "History" },
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
            $(document).on('click', '.edit-form-btn', function () {
        const form = $(this).data('form');

        $('#researchForm1 #record_id').val(form.id);
        $('#researchForm1 #employee_name').val(form.employee_name);
        $('#researchForm1 #employee_id').val(form.employee_id);
        $('#researchForm1 #designation').val(form.designation);
        $('#researchForm1 #department_program').val(form.department_program);

        $('#researchForm1 #campus_unit').val(form.campus_unit);
        $('#researchForm1 #industry_organization').val(form.industry_organization);
        $('#researchForm1 #industry_sector').val(form.industry_sector).trigger('change');
        $('#researchForm1 #purpose_learning_objective').val(form.purpose_learning_objective);
        $('#researchForm1 #course_subject').val(form.course_subject);
        $('#researchForm1 #students_involved').val(form.students_involved);
        $('#researchForm1 #employee_role').val(form.employee_role).trigger('change');
        $('#researchForm1 #visit_category').val(form.visit_category).trigger('change');
        $('#researchForm1 #visit_start_date').val(form.visit_start_date);
        $('#researchForm1 #visit_end_date').val(form.visit_end_date);
        $('#researchForm1 #location').val(form.location);
        $('#researchForm1 #report_submission_date').val(form.report_submission_date);
        $('#researchForm1 #visit_report_submitted').val(form.visit_report_submitted).trigger('change');
        if (form.evidence_upload) {
                        let fileUrl = form.evidence_upload;
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

        $('#commercialGainFormModal').modal('show');
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
            url: "{{ route('industrial-visits.update', '') }}/" + recordId,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                Swal.close();
                Swal.fire('Success', response.message, 'success');
                $('#commercialGainFormModal').modal('hide');
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
     

});

        </script>
    @endif
@endpush
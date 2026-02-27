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
        @if(in_array(getRoleName(activeRole()), ['HOD', 'Teacher','Dean','Associate Professor','Assistant Professor','Program Leader UG','Program Leader PG','Professor']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
             <h5 class="card-header">Faculty pursuing skills and knowledge enhancement</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(in_array(getRoleName(activeRole()), ['Teacher','Associate Professor','Assistant Professor','Program Leader UG','Program Leader PG','Professor']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="intellectualTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Faculty</th>
                                                        <th>Department</th>
                                                        <th>Program Name</th>
                                                        <th>Program Level</th>
                                                        <th>CPD TYPE</th>
                                                        <th>Remarks</th>
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
<div class="modal fade" id="multidisciplinaryProjectFormModal" tabindex="-1" aria-labelledby="commericaGainFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commericaGainFormModalLabel">Edit Commercial Consultancy/Research Income 1</h5>
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
                                        <label for="department" class="form-label">Department</label>
                                        <select name="department_id" id="department_id" class="select2 form-select" required>
                                            <option value="">-- Select Department --</option>
                                        </select>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="program" class="form-label">Program</label>
                                            <select name="program_id" id="program_id" class="select2 form-select program_id" required>
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
                                    <div class="col-md-12">
                                        <label for="cpd_type" class="form-label">CPD Type</label>
                                        <select name="cpd_type" id="cpd_type" class="select2 form-select cpd_type" required>
                                            <option value="">-- Select --</option>
                                            <option value="Training"> Training</option>
                                            <option value="Certification">Certification</option>
                                            <option value="Workshop"> Workshop</option>
                                            <option value="Higher Education">Higher Education </option>
                                            <option value="Industry Exposure">Industry Exposure</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <!-- Hidden Other Field -->
                                    <div class="col-md-12 d-none" id="other_cpd_box"
                                        <label class="form-label">Other Detail</label>
                                        <input type="text"
                                            name="cpd_other_detail" id="cpd_other_detail"
                                            class="form-control"
                                            placeholder="Enter other detail">
                                    </div>
                                    
                                    <div class="col-md-12">
                        
                                        <label for="evidence_reference" class="form-label">Evidence Reference</label>
                                        <input class="form-control" type="file" id="evidence_reference" name="evidence_reference">
                                        <div id="intellectual-img"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="remarks">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
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
    @if(in_array(getRoleName(activeRole()), ['HOD', 'Teacher']))
        <script>
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('faculty-pursuing-skills.index') }}",
                    method: "GET",
                    data: {
                        status: "Teacher" // you can send more values
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
                                form.faculty ? form.faculty.name : 'N/A',
                                form.department ? form.department.name : 'N/A',
                                form.program ? form.program.program_name : 'N/A',
                                form.program_level || 'N/A',
                                form.cpd_type || 'N/A',
                                form.remarks|| 'N/A',
                                 `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn"
                                    data-history='${JSON.stringify(form.update_history)}'
                                    data-user='${form.creator ? form.creator.name : "N/A"}'
                                    data-created='${form.created_at}'>
                                    <span class="icon-xs icon-base ti tabler-history me-2"></span>History
                                </button>`,
                                editButton+ ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#intellectualTable')) {
                            $('#intellectualTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Faculty" },
                                    { title: "Department" },
                                    { title: "Program Name" },
                                    { title: "Program Level" },
                                    { title: "CPD Type" },
                                    { title: "Remarks" },
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
                $(document).on('change', '.cpd_type', function () {

                let selected = $(this).val() || [];

                if (selected.includes("Other")) {

                    $('#other_cpd_box').removeClass('d-none');

                } else {

                    $('#other_cpd_box').addClass('d-none');
                    $('input[name="cpd_other_detail"]').val('');

                }
            });
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
         let cpdValues = form.cpd_type;

    // If string coming from backend → convert to array
    if (typeof cpdValues === 'string') {
        cpdValues = cpdValues.split(',');
    }
        $('#researchForm1 #record_id').val(form.id);
        $('#researchForm1 #cpd_type').val(form.cpd_type).trigger('change');
        $('#researchForm1 #program_level').val(form.program_level).trigger('change');
        // ✅ Show/Hide Other field
    if (cpdValues && cpdValues.includes('Other')) {
        $('#other_cpd_box').show();
        $('#other_cpd_box').removeClass('d-none');
    } else {
        $('#other_cpd_box').addClass('d-none');
        $('#researchForm1 #cpd_other_detail').val('');
    }
        $('#researchForm1 #cpd_other_detail').val(form.cpd_other_detail);
        $('#researchForm1 #remarks').val(form.remarks);
        populateFacultyDepartmentProgram(form);
        // Show proof container based on status
       
        if (form.evidence_reference) {
            let fileUrl = form.evidence_reference;
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
        formData.append('status_update_data', true);
        Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });


        $.ajax({
            url: "{{ route('faculty-pursuing-skills.update', '') }}/" + recordId,
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
    $(document).on('click', '.delete-btn', function() {
    let id = $(this).data('id');

    if(!confirm('Are you sure you want to delete this record?')) return;

    $.ajax({
        url: `/faculty-pursuing-skills/${id}`,
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
     

});

        </script>
    @endif
@endpush
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
       @if(in_array(getRoleName(activeRole()), ['Human Resources']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
             <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Faculty Discipline / Punctuality</h5>
                </div>
                <div class="">
                    <a href="{{ url('kpa/7/category/17/indicator/181') }}" class="btn btn-primary">Add</a>
                </div>
            </div>
            <div class="card-datatable table-responsive card-body">
                    @if(in_array(getRoleName(activeRole()), ['Human Resources']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="employabilityTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Year</th>
                                                        <th>Faculty</th>
                                                        <th>Department</th>
                                                        <th>Program</th>
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
<div class="modal fade" id="employabilityFormModal" tabindex="-1" aria-labelledby="commericaGainFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commericaGainFormModalLabel">Edit Net Promoter Score of Faculty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row g-3">
                      <div class="col-md-4 mb-3">
                                                <label for="batch" class="form-label">Select Year</label>
                                                <select name="year" id="year" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Year --</option>
                                                     <?php
                                                        $currentYear = date('Y');

                                                        // Show range from past 2 to next 3 academic years
                                                        for ($year = $currentYear - 2; $year <= $currentYear + 3; $year++) {
                                                            $nextYear = $year + 1;
                                                            $range = $year . '-' . $nextYear;
                                                            echo "<option value='{$range}'>{$range}</option>";
                                                        }
                                                        ?>
                                                    
                                                </select>
                                            </div>
                                             <div class="col-md-4">
                                                <label class="form-label" for="start_date">Start Date</label>
                                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                                            </div>
                                             <div class="col-md-4">
                                                <label class="form-label" for="end_date">End Date</label>
                                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                                            </div>
                                            <div class="col-md-4">
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

                                            <div class="col-md-4">
                                                <label for="department_id" class="form-label">Department</label>
                                                <select name="department_id" id="department_id" class="select2 form-select"
                                                    required>
                                                    <option value="">-- Select Department --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="program" class="form-label">Program</label>
                                                <select name="program_id" id="program_id" class="select2 form-select program_id"
                                                    required>
                                                    <option value="">-- Select Program --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="program_level" class="form-label">Program Level</label>
                                                <select name="program_level" id="program_level"
                                                    class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Level --</option>
                                                    <option value="UG">UG</option>
                                                    <option value="PG">PG</option>
                                                </select>
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
@endpush
@push('script')
    @if(in_array(getRoleName(activeRole()), ['Human Resources']))
        <script>
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('punctuality.index') }}",
                    method: "GET",
                    data: {
                        status: "HOD" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';
                             
                             let editButton = '';
                            let deleteBtn = '';
                            if (parseInt(form.status) === 1) {
                                editButton = `
                                    <button class="btn rounded-pill btn-outline-primary waves-effect edit-form-btn" 
                                        data-form='${JSON.stringify(form)}'>
                                        <span class="icon-xs icon-base ti tabler-eye me-2"></span>Edit
                                    </button>`;
                                deleteBtn = `<button class="btn rounded-pill btn-outline-danger delete-btn" data-id="${form.id}">Delete</button>`;
                            }     

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.year || 'N/A',
                                form.faculty ? form.faculty.name : 'N/A',
                                form.department ? form.department.name : 'N/A',
                                form.program ? form.program.program_name : 'N/A',
                                editButton+ ' ' + deleteBtn
                            ];
                        });

 
                        if (!$.fn.DataTable.isDataTable('#employabilityTable')) {
                            $('#employabilityTable').DataTable({
                                data: rowData,
                                scrollX: true,
                                scrollCollapse: true,
                                autoWidth: false,
                                columns: [
                                    { title: "#" },
                                    { title: "Year" },
                                    { title: "Faculty" },
                                    { title: "Department" },
                                    { title: "Program" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#employabilityTable').DataTable().clear().rows.add(rowData).draw();
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
        $('#researchForm1 #start_date').val(form.start_date);
        $('#researchForm1 #end_date').val(form.end_date);
        $('#researchForm1 #year').val(form.year).trigger('change');
        $('#researchForm1 #program_level').val(form.program_level).trigger('change');

        populateFacultyDepartmentProgram(form);
        
        $('#researchForm1 #remarks').val(form.remarks);

        $('#employabilityFormModal').modal('show');
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
            url: "{{ route('punctuality.update', '') }}/" + recordId,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                Swal.close();
                Swal.fire('Success', response.message, 'success');
                $('#employabilityFormModal').modal('hide');
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
        url: `/punctuality/${id}`,
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
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
    @if(in_array(getRoleName(activeRole()), ['International Office']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
             <h5 class="card-header">Percentage of targets achieved for superior go global stream (Higher Education) (if applicable)</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(in_array(getRoleName(activeRole()), ['International Office']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="admissionTargetAchieveTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Faculty</th>
                                                        <th>Department</th>
                                                        <th>Program Name</th>
                                                        <th>Target</th>
                                                        <th>Target Achieved</th>
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
 <!-- Update commercial gain Modal -->
<div class="modal fade" id="employabilityFormModal" tabindex="-1" aria-labelledby="commericaGainFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commericaGainFormModalLabel">Edit Percentage of targets achieved for superior go global stream (Higher Education) (if applicable)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row g-3">
                       
                        
                        <div class="col-md-4">
                                                <label class="form-label">Faculty</label>
                                                <select name="faculty_id" id="faculty_id" class="select2 form-select faculty-select">
                                                    <option value="">Select Faculty</option>
                                                    @foreach(get_faculties() as $faculty)
                                                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Department</label>
                                                <select name="department_id" id="department_id" class="select2 form-select department-select">
                                                    <option value="">Select Department</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Program Name</label>
                                                <select name="program_id" id="program_id" class="select2 form-select program-select">
                                                    <option value="">Select Program</option>
                                                </select>
                                            </div>

                                
                                            
                                            <div class="col-md-4">
                                                <label class="form-label">Target</label>
                                                <input type="number" name="experience_target" id="experience_target" class="form-control" min="1"
                                                    step="1" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Target Achieved</label>
                                                <input type="number" name="achieved_target" id="achieved_target" class="form-control" min="1"
                                                    step="1" required>
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
    
    @if(in_array(getRoleName(activeRole()), ['International Office']))
        <script>
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('go-global-stream-target.index') }}",
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
                                form.experience_target || 'N/A',
                                form.achieved_target || 'N/A',
                                editButton+ ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#admissionTargetAchieveTable')) {
                            $('#admissionTargetAchieveTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Faculty" },
                                    { title: "Department" },
                                    { title: "Program Name" },
                                    { title: "Target" },
                                    { title: "Target Achieved" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#admissionTargetAchieveTable').DataTable().clear().rows.add(rowData).draw();
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
               
            $(document).on('click', '.edit-form-btn', function () {
        const form = $(this).data('form');
        $('#researchForm1 #record_id').val(form.id);
        populateFacultyDepartmentProgram(form);
        $('#researchForm1 #experience_target').val(form.experience_target)
        $('#researchForm1 #achieved_target').val(form.achieved_target);
        

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
            url: "{{ route('go-global-stream-target.update', '') }}/" + recordId,
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
                $(document).on('click', '.delete-btn', function() {
    let id = $(this).data('id');

    if(!confirm('Are you sure you want to delete this record?')) return;

    $.ajax({
        url: `/go-global-stream-target/${id}`,
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
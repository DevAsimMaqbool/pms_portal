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
    <style>
        .form-disabled {
            color: #acaab1;
            background-color: #f3f2f3;
        }
        .rank-error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 4px;
        }
    </style>
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
     @if(in_array(getRoleName(activeRole()), ['OEC']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
             <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Student Engagement Rate</h5>
                </div>
                <div>
                    
                </div>
             </div>





            <div class="card-datatable table-responsive card-body">
                    @if(in_array(getRoleName(activeRole()), ['OEC']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                                <table id="achievementTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Faculty</th>
                                            <th>Department</th>
                                            <th>Program Name</th>
                                            <th>Nature of the Event</th>
                                            <th>Title of the Event</th>
                                            <th>Date(s) of the Event</th>
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
    <!-- Update Form Modal -->
<div class="modal fade" id="updateFormModal" tabindex="-1" aria-labelledby="updateFormModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title" id="updateFormModalLabel">Edit Student Engagement Rate</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Form -->
        <form id="researchForm1" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="record_id" name="record_id">

          <!--start-->
           <div class="row">
                <!-- First column-->
                <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Engagement</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                            <label class="form-label" for="">Nature of the Event</label>
                                <select name="nature_of_event" id="nature_of_event" class="select2 form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="Sports">Sports</option>
                                    <option value="Nights">Nights</option>
                                    <option value="Welcome">Welcome</option>
                                    <option value="Tour">Tour</option>
                                    <option value="Other">Other (please specify)</option>     
                                </select>
                            </div>
                            <div class="col-md-12 mb-3" id="other_event_div" style="display:none;">
                                <label class="form-label">Specify Other Event</label>
                                <input type="text" name="other_event_detail" id="other_event_detail" class="form-control">
                            </div>

                             <div class="col-md-12 mb-3">
                             <label class="form-label" for="">Event Location</label>
                              <div>
                                   <div class="row">
                                    <div class="col-md mb-md-0 mb-5">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customCheckTemp3">
                                        <input class="form-check-input" name="event_location[]" type="radio" value="within_campus" id="customCheckTemp3" checked />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">Within Campus</span>
                                        </span>
                                        </label>
                                    </div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-5">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customCheckTemp3">
                                        <input class="form-check-input" name="event_location[]" type="radio" value="outside_campus" id="customCheckTemp3" />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">Outside Campus</span>
                                        </span>
                                        </label>
                                    </div>
                                    </div>
                                    <div class="col-md">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customCheckTemp4">
                                        <input class="form-check-input" name="event_location[]"  type="radio" value="" id="customCheckTemp4" />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">Both</span>
                                        </span>
                                        
                                        </label>
                                    </div>
                                    </div>
                                </div>
                              </div>
                            </div>

                         


                            <div class="col-md-12 mb-3">
                            <label class="form-label" for="evidence_reference">Scope of the Event</label>
                            <div>

                                        <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="radio" name="scope_of_the_event" id="inlineRadio1" value="institutional" />
                                        <label class="form-check-label" for="inlineRadio1">Institutional</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="scope_of_the_event" id="inlineRadio2" value="departmental" />
                                        <label class="form-check-label" for="inlineRadio2">Departmental</label>
                                        </div>
                                        
                            </div>
                            </div>

                               
                        </div>
                        <!-- Description -->
                        
                    </div>
                    </div>
                    <!-- /Product Information -->


                     <!-- Product Information -->
                    <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Event Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="title_of_the_event">Title of the Event</label>
                            <textarea class="form-control" id="title_of_the_event" name="title_of_the_event"rows="2"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="brief_description_of_activity">Brief Description of the Event</label>
                            <textarea class="form-control" id="BriefDescription" name="brief_description_of_activity" rows="2"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                            <label class="form-label" for="date_of_the_event">Date(s) of the Event</label>
                           
                            <div class="input-group">
                                <input type="date" name="event_start_date" class="form-control" required>
                                <span class="input-group-text">to</span>
                                <input type="date" name="event_end_date" class="form-control" required>
                            </div>
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
                    <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Program Information</h5>
                    </div>
                    <div class="card-body">
                        

                        <div class="mb-3">
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

                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select name="department_id" id="department_id" class="select2 form-select" required>
                                <option value="">-- Select Department --</option>
                            </select>
                        </div>

                         <div class="mb-3">
                            <label for="program" class="form-label">Program Name</label>
                            <select name="program_id" id="program_id" class="select2 form-select program_id" required>
                                <option value="">-- Select Program --</option>
                            </select>
                        </div>

                        
                        
                    </div>
                    </div>
                    <!-- /Pricing Card -->
                     <!-- Pricing Card -->
                    <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Participation Data</h5>
                    </div>
                    <div class="card-body">
                        
                        
                        <div class="mb-3">
                            <label class="form-label" for="total_programs_assessed">Participation Target</label>
                            <input type="number" class="form-control"
                                                name="participation_target"
                                                value="">
                        </div>

                        <div class="mb-3">
                            <label for="number_of_students_participated" class="form-label">Number of Students Participated</label>
                            <input type="number" class="form-control"
                                                name="number_of_students_participated"
                                                value="{{ $submission->number_of_students_participated ?? '' }}">
                        </div>

                         <div class="mb-3">
                            <label for="proportion_of_profitable_programs" class="form-label">Student Satisfaction Rate / Happiness of students</label>
                            <div id="employerRating" class="raty"></div>
                                        <input type="hidden" name="employer_satisfaction" id="employer_satisfaction" value="">
                        </div>
                        
                        
                    </div>
                    </div>
                    <!-- /Pricing Card -->
                
                </div>
                <!-- /Second column -->
                </div>

          <!--/end-->

          <div class="mt-3 text-end">
            <button type="submit" class="btn btn-success">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


        <!-- / model -->
 


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
<script>
    

    let employerRaty;   // GLOBAL
    let graduateRaty;

document.addEventListener("DOMContentLoaded", function () {


    const starOn = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23FFD700' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
        const starHalf = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cdefs%3E%3ClinearGradient id='halfStarGradient'%3E%3Cstop offset='50%25' style='stop-color:%23FFD700' /%3E%3Cstop offset='50%25' style='stop-color:%239e9e9e' /%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath fill='url(%23halfStarGradient)' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
        const starOff = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%239e9e9e' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";

    // Employer Rating
    employerRaty = new Raty(document.getElementById("employerRating"), {
        number: 5,
        half: true,
        starOn: starOn,
        starHalf: starHalf,
        starOff: starOff,
        click: function(score) {
            document.getElementById("employer_satisfaction").value = score;
        }
    }).init();

    // Graduate Rating
    graduateRaty = new Raty(document.getElementById("graduateRating"), {
        number: 5,
        half: true,
        starOn: starOn,
        starHalf: starHalf,
        starOff: starOff,
        click: function(score) {
            document.getElementById("graduate_satisfaction").value = score;
        }
    }).init();
});
function toggleOtherField() {
                let selected = $('#nature_of_event').val();

                if (selected === 'Other') {
                    $('#other_event_div').show();
                    $('#other_event_detail').prop('required', true);
                } else {
                    $('#other_event_div').hide();
                    $('#other_event_detail').prop('required', false).val('');
                }
            }

            // On change
            $('#nature_of_event').on('change', function () {
                toggleOtherField();
            });

            // Run on page load (important for edit forms)
            toggleOtherField();


    </script>
    @if(in_array(getRoleName(activeRole()), ['OEC']))
        <script>
            function fetchAchievementForms() {
                $.ajax({
                    url: "{{ route('student-engagement-rate.index') }}",
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
                            let editButton = '';
                            if (parseInt(form.status) === 1) {
                                editButton = `
                                    <button class="btn rounded-pill btn-outline-primary waves-effect edit-form-btn" 
                                        data-form='${JSON.stringify(form)}'>Edit
                                    </button>`;
                            }    
                             const deleteBtn = `<button class="btn rounded-pill btn-outline-danger delete-btn" data-id="${form.id}">Delete</button>`;

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.faculty ? form.faculty.name : 'N/A',
                                form.department ? form.department.name : 'N/A',
                                form.program ? form.program.program_name : 'N/A',
                                form.nature_of_event || 'N/A',
                                form.title_of_the_event || 'N/A',
                                form.event_start_date || 'N/A',
                                editButton+ ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#achievementTable')) {
                            $('#achievementTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Faculty" },
                                    { title: "Department" },
                                    { title: "Program Name" },
                                    { title: "Nature of the Event" },
                                    { title: "Title of the Event" },
                                    { title: "Date(s) of the Event" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#achievementTable').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
                
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
            $(document).ready(function () {
                fetchAchievementForms();
                let grantIndex = 0; // dynamic co-author counter


$(document).on('click', '.edit-form-btn', function () {
    let form = $(this).data('form');
    let $f = $('#researchForm1');

    // Reset form
    $f[0].reset();

    // ---------------------------
    // Hidden / Basic Fields
    // ---------------------------
    $f.find('[name="record_id"]').val(form.id);

    // ---------------------------
    // Nature of Event (Select2)
    // ---------------------------
    $f.find('[name="nature_of_event"]')
        .val(form.nature_of_event)
        .trigger('change');

    // Show other field if needed
    if (form.other_event_detail) {
        $('#other_event_div').show();
        $('#other_event_detail').val(form.other_event_detail);
    } else {
        $('#other_event_div').hide();
    }

    // ---------------------------
    // Event Location Checkboxes
    // ---------------------------
    $('input[name="event_location[]"]').prop('checked', false);

    if (form.event_location) {
        let locations = typeof form.event_location === "string"
            ? JSON.parse(form.event_location)
            : form.event_location;

        locations.forEach(function (val) {
            $('input[name="event_location[]"][value="'+val+'"]')
                .prop('checked', true);
        });
    }

    // ---------------------------
    // Scope Radio
    // ---------------------------
    $('input[name="scope_of_the_event"][value="'+form.scope_of_the_event+'"]')
        .prop('checked', true);

    // ---------------------------
    // Text Fields
    // ---------------------------
    $f.find('[name="title_of_the_event"]').val(form.title_of_the_event);
    $f.find('[name="brief_description_of_activity"]').val(form.brief_description_of_activity);

    // ---------------------------
    // Dates
    // ---------------------------
    $f.find('[name="event_start_date"]').val(form.event_start_date);
    $f.find('[name="event_end_date"]').val(form.event_start_date);

    // ---------------------------
    // Program Info (Select2)
    // ---------------------------
    populateFacultyDepartmentProgram(form);
    // ---------------------------
    // Participation
    // ---------------------------
    $f.find('[name="participation_target"]').val(form.participation_target);
    $f.find('[name="number_of_students_participated"]').val(form.number_of_students_participated);

     // ---------------------------
    // Rating (Raty)
    // ---------------------------
    if(form.employer_satisfaction){
        $('#employer_satisfaction').val(form.employer_satisfaction);

        if(employerRaty){
            employerRaty.score(form.employer_satisfaction);
        }
    }


   



    // Show modal
    $('#updateFormModal').modal('show');
});








// Submit update form
$('#researchForm1').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let form = $(this);
        const recordId = $('#record_id').val();
        formData.append('status_update_data', true);

        formData.append('_method', 'PUT'); // Laravel PUT

        Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '/student-engagement-rate/' + recordId,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.close();
                Swal.fire('Success', response.message, 'success');
                

                form.find('.invalid-feedback').remove();
                form.find('.is-invalid').removeClass('is-invalid');
                $('#updateFormModal').modal('hide');
                fetchAchievementForms(); // refresh table
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


                // SINGLE DELETE
$(document).on('click', '.delete-btn', function() {
    let id = $(this).data('id');

    if(!confirm('Are you sure you want to delete this record?')) return;

    $.ajax({
        url: `/student-engagement-rate/${id}`,
        type: 'DELETE',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function(res) {
            alert(res.message);
            fetchAchievementForms();
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
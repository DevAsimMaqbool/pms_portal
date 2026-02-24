@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.css') }}" />
    

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
    <div class="container-xxl flex-grow-1 container-p-y">  
<!-- new design -->

<div class="app-ecommerce">
    <!-- tab open-->
    <div class="nav-align-top">

       
        <!-- main tab-->
        <div class="tab-content" style="padding:0;background: none;border: none;box-shadow: none;">
             @if(in_array(getRoleName(activeRole()), ['OEC']))
            <!-- first tab-->
            <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Student Engagement Rate</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <div class="d-flex gap-4">
                <a class="btn btn-label-primary" href="{{ route('indicators_crud.index', ['slug' => 'student_engagement_rate', 'id' => $indicatorId]) }}">View</a></div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                                            <i class="bx bx-upload"></i> Import Excel / CSV</button>
            </div>
            </div>
            <form id="researchForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
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
                            <textarea class="form-control" id="title_of_the_event" name="title_of_the_event"rows="2" placeholder="Enter your message here..."></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="brief_description_of_activity">Brief Description of the Event</label>
                            <textarea class="form-control" id="BriefDescription" name="brief_description_of_activity" rows="2" placeholder="Enter your message here..."></textarea>
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
                                                value="" placeholder="Enter Participation Target...">
                        </div>

                        <div class="mb-3">
                            <label for="number_of_students_participated" class="form-label">Number of Students Participated</label>
                            <input type="number" class="form-control"
                                                name="number_of_students_participated"
                                                value="{{ $submission->number_of_students_participated ?? '' }}" placeholder="add..">
                        </div>

                         <div class="mb-3">
                            <label for="proportion_of_profitable_programs" class="form-label">Student Satisfaction Rate / Happiness of students</label>
                            <div id="employerRating" class="raty"></div>
                                        <input type="hidden" name="employer_satisfaction" id="employer_satisfaction" value="">
                        </div>
                        
                        
                    </div>
                    </div>
                    <!-- /Pricing Card -->
                    <div class="mt-3 text-end" style="margin-left: -16px !important;">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                    </div>
                
                </div>
                <!-- /Second column -->
                </div>
            </form>

            </div>
            <!-- /first tab-->
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
        <!-- /main tab-->

    </div>
    <!-- tab open-->
  </div>



<!-- / close new design -->
        <!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="importForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
            <input type="hidden" name="form_status" value="HOD">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Student Engagement Rate Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">Upload Excel / CSV</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>

                    <small class="text-muted d-block mt-2">
                        Allowed: xlsx, xls, csv
                    </small>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-file-upload.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
   

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
@endpush
@push('script')

    <script>
     document.addEventListener("DOMContentLoaded", function () {

        // SVG stars
        const starOn = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23FFD700' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
        const starHalf = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cdefs%3E%3ClinearGradient id='halfStarGradient'%3E%3Cstop offset='50%25' style='stop-color:%23FFD700' /%3E%3Cstop offset='50%25' style='stop-color:%239e9e9e' /%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath fill='url(%23halfStarGradient)' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
        const starOff = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%239e9e9e' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";

        // Employer Rating
        const employerRaty = new Raty(document.getElementById("employerRating"), {
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
        const graduateRaty = new Raty(document.getElementById("graduateRating"), {
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

    </script>
    @if(in_array(getRoleName(activeRole()), ['OEC']))
        <script>
            $(document).ready(function () {
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
                        url: "{{ route('student-engagement-rate.store') }}",
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
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
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
                $('#importForm').on('submit', function (e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    Swal.fire({
                        title: 'Importing...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('student-engagement-rate.import') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            Swal.close();
                            Swal.fire('Success', res.message, 'success');
                            $('#importModal').modal('hide');
                            $('#importForm')[0].reset();
                        },
                        error: function (xhr) {
                            Swal.close();
                            Swal.fire('Error', xhr.responseJSON.message ?? 'Import failed', 'error');
                        }
                    });
                });

            });
        </script>
    @endif
    @endpush
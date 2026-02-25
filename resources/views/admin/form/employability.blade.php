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

<!-- new design -->

<div class="app-ecommerce">
    <!-- tab open-->
    <div class="nav-align-top">

        <!-- main tab-->
        <div class="tab-content" style="padding:0;background: none;border: none;box-shadow: none;">
             @if(in_array(getRoleName(activeRole()), ['Employability Center']))
            <!-- first tab-->
            <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">% Employability</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <div class="d-flex gap-4">
                <a class="btn btn-label-primary" href="{{ route('indicators_crud.index', ['slug' => 'employability', 'id' => $indicatorId]) }}">View</a></div>
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
                        <h5 class="card-tile mb-0">Employability information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="faculty" class="form-label">Please select period</label>
                            <select name="period" id="period" class="select2 form-select faculty-member" required>
                                <option value="">-- Select Period --</option>
                                <?php $currentYear = date('Y'); 
                                 for ($year = $currentYear - 2; $year <= $currentYear + 3; $year++)
                                  { $nextYear = $year + 1; $range = $year . '-' . $nextYear; echo "<option value='{$range}'>{$range}</option>"; }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="student_name" class="form-label">Student Name</label>
                            <input type="text" name="student_name" id="student_name" class="form-control" placeholder="Student Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
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
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select name="department_id" id="department_id" class="select2 form-select" required>
                                <option value="">-- Select Department --</option>
                            </select>
                            
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="program" class="form-label">Program</label>
                                <select name="program_id" id="program_id" class="select2 form-select program_id" required>
                                    <option value="">-- Select Program --</option>
                                </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="batch" class="form-label">Batch</label>
                            <select name="batch" class="select2 form-select faculty-member" required>
                                <option value="">-- Select Batch --</option>
                                <?php
                                $currentYear = date('Y');
                                for ($year = $currentYear - 2; $year <= $currentYear + 3; $year++) {
                                    echo "<option value='Spring $year'>Spring $year</option>";
                                    echo "<option value='Fall $year'>Fall $year</option>";
                                }
                                ?>
                                
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="passing_year" class="form-label">Passing Year</label>
                            <input type="date" name="passing_year" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="passing_year" class="form-label">Date of Appointment</label>
                            <input type="date" name="date_of_appointment" id="date_of_appointment" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employer Name</label>
                            <input type="text" name="employer_name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sector" class="form-label">Sector</label>
                            <select name="sector" class="select2 form-select faculty-member" required>
                                <option value="">-- Select Sector --</option>
                                <option value="Manufacturing">Manufacturing</option>
                                <option value="Services">Services</option>
                                <option value="Information Technology (IT)">Information Technology (IT)</option>
                                <option value="Banking & Finance">Banking & Finance</option>
                                <option value="Insurance">Insurance</option>
                                <option value="FMCG & Consumer Goods">FMCG & Consumer Goods</option>
                                <option value="Retail & E-Commerce">Retail & E-Commerce</option>
                                <option value="Energy & Utilities">Energy & Utilities</option>
                                <option value="Oil & Gas">Oil & Gas</option>
                                <option value="Construction & Real Estate">Construction & Real Estate</option>
                                <option value="Healthcare & Pharmaceuticals">Healthcare & Pharmaceuticals</option>
                                <option value="Agriculture & Agribusiness">Agriculture & Agribusiness</option>
                                <option value="Education & Training">Education & Training</option>
                                <option value="Media & Communications">Media & Communications</option>
                                <option value="Logistics & Transportation">Logistics & Transportation</option>
                                <option value="Hospitality & Tourism">Hospitality & Tourism</option>
                                <option value="Telecommunications">Telecommunications</option>
                                <option value="Engineering & Industrial Services">Engineering & Industrial Services</option>
                                <option value="Government / Public Sector">Government / Public Sector</option>
                                <option value="Development Sector / NGO">Development Sector / NGO</option>
                                <option value="Research & Development">Research & Development</option>
                                <option value="Startups & Entrepreneurship">Startups & Entrepreneurship</option>
                                <option value="Environmental & Sustainability">Environmental & Sustainability</option>
                                <option value="Other">Other (Specify)</option>
                                
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary" class="form-control" min="1" step="1"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="market_competitive_salary" class="form-label">Market Competitive
                                Salary</label>
                            <select name="market_competitive_salary"
                                class="select2 form-select market_competitive_salary" required>
                                <option value="">-- Select --</option>
                                <option value="Above">Above</option>
                                <option value="At Par">At Par</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Job Relevancy</label>
                            <div>
                                <input type="radio" name="job_relevancy" id="job_relevancy" value="yes">
                                <label for="yes">Yes</label>

                                <input type="radio" name="job_relevancy" id="job_relevancy" value="no"
                                    checked>
                                <label for="job_relevancy">No</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="passing_year" class="form-label">Proof of Salary and appointment</label>
                            <input type="url" name="proof_salary_and_appointment" id="proof_salary_and_appointment" class="form-control" required>
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
                    <div class="card-header">
                        <h5 class="card-title mb-0">Rating</h5>
                    </div>
                    <div class="card-body">
                        
                        
                        <div class="mb-3">
                            <label class="form-label">Employer Satisfaction</label>
                            <div id="employerRating" class="raty"></div>
                            <input type="hidden" name="employer_satisfaction" id="employer_satisfaction" value="">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Graduate Satisfaction</label>
                            <div id="graduateRating" class="raty"></div>
                            <input type="hidden" name="graduate_satisfaction" id="graduate_satisfaction" value="">
                        </div>
                        
                        
                    </div>
                    </div>
                    <!-- /Pricing Card -->
                    <div class="">
                        <button type="submit" class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
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
                    <h5 class="modal-title">Import Employability Data</h5>
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
    @if(in_array(getRoleName(activeRole()), ['Employability Center']))
        <script>
            $(document).ready(function () {
              
              

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
                        url: "{{ route('employability.store') }}",
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

                            document.getElementById("employer_satisfaction").value = "";
                            document.getElementById("graduate_satisfaction").value = "";

                            // Reset stars
                            employerRaty.setScore(0);
                            graduateRaty.setScore(0);
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

                $('#importForm').on('submit', function (e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    Swal.fire({
                        title: 'Importing...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('employability.import') }}",
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
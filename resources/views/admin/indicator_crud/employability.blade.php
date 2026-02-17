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
             <h5 class="card-header">% Employability</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="employabilityTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Batch</th>
                                                        <th>Passing Year</th>
                                                        <th>Salary</th>
                                                        <th>Employer Name</th>
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
                <h5 class="modal-title" id="commericaGainFormModalLabel">Edit % Employability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row g-3">
                       
                        
                        <div class="col-md-6 mb-3">
                            <label for="faculty" class="form-label">Please select period</label>
                            <select name="period" id="period" class="select2 form-select faculty-member" required>
                                <option value="">-- Select Period --</option>
                                <option value="11"> 2024-2025</option>
                                <option value="171">2025-2026</option>
                                <option value="158">2026-2027</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="student_name" class="form-label">Student Name</label>
                            <select name="student_id" id="student_id" class="select2 form-select faculty-member" required>
                                <option value="">-- Select Student --</option>
                                <option value="11"> Muhammad Ahmad</option>
                                <option value="12">MalikMubasharAhmadZafar</option>
                                <option value="13"> Muhammad Umar</option>
                                
                            </select>
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
                            <select name="batch" id="batch" class="select2 form-select faculty-member" required>
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
                            <input type="date" name="passing_year" id="passing_year" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="passing_year" class="form-label">Date of Appointment</label>
                            <input type="date" name="date_of_appointment" id="date_of_appointment" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employer Name</label>
                            <input type="text" name="employer_name" id="employer_name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sector" class="form-label">Sector</label>
                            <select name="sector" id="sector"  class="select2 form-select faculty-member" required>
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
                            <input type="number" name="salary" id="salary" class="form-control" min="1" step="1"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="market_competitive_salary" class="form-label">Market Competitive
                                Salary</label>
                            <select name="market_competitive_salary" id="market_competitive_salary"
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
                                            <div class="col-md-6">
                                                <label class="fw-bold mb-2 d-block">Employer Satisfaction</label>
                                                <div id="employerRating" class="raty"></div>
                                                <input type="hidden" name="employer_satisfaction" id="employer_satisfaction" value="">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="fw-bold mb-2 d-block">Graduate Satisfaction</label>
                                                <div id="graduateRating" class="raty"></div>
                                                <input type="hidden" name="graduate_satisfaction" id="graduate_satisfaction" value="">
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
@endpush
@push('script')
    <script>
       let employerRaty;
       let graduateRaty;
 document.addEventListener("DOMContentLoaded", function () {

    // SVG stars
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




       </script>
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('employability.index') }}",
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
                                form.batch || 'N/A',
                                form.passing_year || 'N/A',
                                form.salary || 'N/A',
                                form.employer_name || 'N/A',
                                editButton+ ' ' + deleteBtn
                            ];
                        });

 
                        if (!$.fn.DataTable.isDataTable('#employabilityTable')) {
                            $('#employabilityTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Batch" },
                                    { title: "Passing Year" },
                                    { title: "Salary" },
                                    { title: "Employer Name" },
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
        $('#researchForm1 #record_id').val(form.id);
        $('#researchForm1 #student_id').val(form.student_id).trigger('change');
        populateFacultyDepartmentProgram(form);
        $('#researchForm1 #batch').val(form.batch).trigger('change');
        $('#researchForm1 #period').val(form.period).trigger('change');
        $('#researchForm1 #passing_year').val(form.passing_year);
        $('#researchForm1 #date_of_appointment').val(form.date_of_appointment);
        $('#researchForm1 #proof_salary_and_appointment').val(form.proof_salary_and_appointment);
        $('#researchForm1 #employer_name').val(form.employer_name);
        $('#researchForm1 #sector').val(form.sector).trigger('change');
        $('#researchForm1 #salary').val(form.salary);
        $('#researchForm1 #market_competitive_salary').val(form.market_competitive_salary).trigger('change');
        //$('#researchForm1 #job_relevancy').val(form.job_relevancy);
        $('#researchForm1 #employer_satisfaction').val(form.employer_satisfaction);
        $('#researchForm1 #graduate_satisfaction').val(form.graduate_satisfaction);

        // ✅ Radio: Prototype/Product Developed
        $('input[name="job_relevancy"][value="' + form.job_relevancy + '"]')
            .prop('checked', true);
            
        employerRaty.setScore(form.employer_satisfaction);
        graduateRaty.setScore(form.graduate_satisfaction);
        

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
            url: "{{ route('employability.update', '') }}/" + recordId,
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
        url: `/employability/${id}`,
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
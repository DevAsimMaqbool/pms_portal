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

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Research Publications</h5>
                </div>
                <div>

                </div>
            </div>
            <div class="card-datatable table-responsive card-body">
                @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                    <div class="tab-pane fade show" id="form2" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table id="achievementTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Indicator Category</th>
                                        <th>Classification</th>
                                        <th>Na /International</th>
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
        <!-- Update Form Modal -->
        <div class="modal fade" id="updateFormModal" tabindex="-1" aria-labelledby="updateFormModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="updateFormModalLabel">Edit Research Productivity of PG Students</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Form -->
                        <form id="researchForm1" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="indicator_id" value="">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" id="form_status" name="form_status" value="RESEARCHER" required>

                            <div class="row g-6 mt-0">
                                <div class="col-12 col-lg-12">
                                    <!-- Main Info Card -->
                                    <div class="card shadow-none bg-transparent border border-primary mb-4">
                                        <div class="card-body">
                                            <div class="row g-6">
                                                <div class="col-md-6">
                                                    <label class="form-label">Journal Category</label>
                                                    <select name="target_category" class="form-select">
                                                        <option value="">Select Target Category</option>
                                                        <option value="Scopus-Indexed">Scopus Indexed</option>
                                                        <option value="HEC">HEC</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Publications Link</label>
                                                    <input type="url" name="link_of_publications" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Journal Classification</label>
                                                    <select name="journal_clasification" class="form-select">
                                                        <option value="">Select Journal Classification</option>
                                                        <option value="Q1">Q1</option>
                                                        <option value="Q2">Q2</option>
                                                        <option value="Q3">Q3</option>
                                                        <option value="Q4">Q4</option>
                                                        <option value="W">W</option>
                                                        <option value="X">X</option>
                                                        <option value="Y">Y</option>
                                                        <option value="Medical">Medical</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card shadow-none bg-transparent border border-primary mt-6">
                                        <div class="card-body">
                                            <div class="row g-6">

                                                <div class="col-md-6">
                                                    <label class="form-label">Student Name</label>
                                                    <input type="text" name="student_name" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Student Roll No.</label>
                                                    <input type="text" name="roll_no" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Student Rank (As Author)</label>
                                                    <input type="number" name="as_author_your_rank" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Faculty</label>
                                                    <select name="faculty_id" class="select2 form-select faculty-select">
                                                        <option value="">Select Faculty</option>
                                                        @foreach(get_faculties() as $faculty)
                                                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Department</label>
                                                    <select name="department_id"
                                                        class="select2 form-select department-select">
                                                        <option value="">Select Department</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Program Name</label>
                                                    <select name="program_id" class="select2 form-select program-select">
                                                        <option value="">Select Program</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label d-block">Is there at least 1 international
                                                        co-author?</label>
                                                    <div>
                                                        <input type="radio" name="nationality" id="national"
                                                            value="National">
                                                        <label for="national">No</label>

                                                        <input type="radio" name="nationality" id="international"
                                                            value="International" checked>
                                                        <label for="international">Yes</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Co-Authors -->
                                    <div class="card shadow-none bg-transparent border border-primary mt-6">
                                        <div class="card-body" id="grant-details-container">
                                            <!-- Co-author rows will be added dynamically -->
                                        </div>
                                        <div class="card-footer bg-light">
                                            <button type="button" class="btn btn-primary mt-6" id="add-grant">
                                                </i> Add Co-Author
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                            <span class="text-truncate fw-medium text-heading" id="modalCreatedBy">Website
                                                SEO</span>
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
    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
        <script>
            function fetchAchievementForms() {
                $.ajax({
                    url: "{{ route('indicator-form-pg.index') }}",
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
                                form.target_category || 'N/A',
                                form.journal_clasification || 'N/A',
                                form.nationality || 'N/A',
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

                        if (!$.fn.DataTable.isDataTable('#achievementTable')) {
                            $('#achievementTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Indicator Category" },
                                    { title: "Classification" },
                                    { title: "Na /International" },
                                    { title: "Created Date" },
                                    { title: "History" },
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


            $(document).ready(function () {

                // Initialize Select2
                $('.select2').select2({
                    width: '100%'
                });

                // ===============================
                // FACULTY → DEPARTMENT
                // ===============================
                $(document).on('change', '.faculty-select', function () {

                    let facultyId = $(this).val();
                    let departmentSelect = $('.department-select');
                    let programSelect = $('.program-select');

                    // Reset department & program
                    departmentSelect.html('<option value="">Loading...</option>').trigger('change');
                    programSelect.html('<option value="">Select Program</option>').trigger('change');

                    if (facultyId) {

                        $.ajax({
                            url: "/get-departments/" + facultyId,
                            type: "GET",
                            success: function (departments) {

                                let options = '<option value="">Select Department</option>';

                                $.each(departments, function (i, dept) {
                                    options += `<option value="${dept.id}">${dept.name}</option>`;
                                });

                                departmentSelect.html(options).trigger('change');
                            },
                            error: function () {
                                departmentSelect.html('<option value="">Error loading departments</option>');
                            }
                        });

                    } else {

                        departmentSelect.html('<option value="">Select Department</option>').trigger('change');
                        programSelect.html('<option value="">Select Program</option>').trigger('change');
                    }
                });


                // ===============================
                // DEPARTMENT → PROGRAM
                // ===============================
                $(document).on('change', '.department-select', function () {

                    let departmentId = $(this).val();
                    let programSelect = $('.program-select');

                    programSelect.html('<option value="">Loading...</option>').trigger('change');

                    if (departmentId) {

                        $.ajax({
                            url: "/get-programs/" + departmentId,
                            type: "GET",
                            success: function (programs) {

                                let options = '<option value="">Select Program</option>';

                                $.each(programs, function (i, program) {
                                    options += `<option value="${program.id}">${program.program_name}</option>`;
                                });

                                programSelect.html(options).trigger('change');
                            },
                            error: function () {
                                programSelect.html('<option value="">Error loading programs</option>');
                            }
                        });

                    } else {

                        programSelect.html('<option value="">Select Program</option>').trigger('change');
                    }
                });
                //---------------------------- end of faculty- department- program 
                fetchAchievementForms();
                let grantIndex = 0; // dynamic co-author counter


                $(document).on('click', '.edit-form-btn', function () {

                    let form = $(this).data('form');

                    // Basic Fields
                    $('#researchForm1 [name="indicator_id"]').val(form.id);
                    $('#researchForm1 [name="target_category"]').val(form.target_category).trigger('change');
                    $('#researchForm1 [name="link_of_publications"]').val(form.link_of_publications);
                    $('#researchForm1 [name="journal_clasification"]').val(form.journal_clasification).trigger('change');
                    $('#researchForm1 [name="nationality"][value="' + form.nationality + '"]').prop('checked', true);
                    $('#researchForm1 [name="student_name"]').val(form.student_name);
                    $('#researchForm1 [name="roll_no"]').val(form.roll_no);
                    $('#researchForm1 [name="as_author_your_rank"]').val(form.as_author_your_rank);

                    $('#researchForm1 [name="scopus_q1"]').val(form.scopus_q1);
                    $('#researchForm1 [name="scopus_q2"]').val(form.scopus_q2);
                    $('#researchForm1 [name="scopus_q3"]').val(form.scopus_q3);
                    $('#researchForm1 [name="scopus_q4"]').val(form.scopus_q4);
                    $('#researchForm1 [name="hec_w"]').val(form.hec_w);
                    $('#researchForm1 [name="hec_x"]').val(form.hec_x);
                    $('#researchForm1 [name="hec_y"]').val(form.hec_y);
                    $('#researchForm1 [name="medical_recognized"]').val(form.medical_recognized);

                    // ================================
                    // Faculty → Department → Program
                    // ================================

                    // 1️⃣ Set Faculty
                    let facultySelect = $('#researchForm1 [name="faculty_id"]');
                    facultySelect.val(form.faculty_id).trigger('change');

                    // 2️⃣ Load Departments
                    $.ajax({
                        url: "/get-departments/" + form.faculty_id,
                        type: "GET",
                        success: function (departments) {

                            let departmentSelect = $('#researchForm1 [name="department_id"]');
                            departmentSelect.empty().append('<option value="">Select Department</option>');

                            departments.forEach(function (dept) {
                                departmentSelect.append(
                                    `<option value="${dept.id}">${dept.name}</option>`
                                );
                            });

                            // Set Department
                            departmentSelect.val(form.department_id).trigger('change');

                            // 3️⃣ Load Programs
                            $.ajax({
                                url: "/get-programs/" + form.department_id,
                                type: "GET",
                                success: function (programs) {

                                    let programSelect = $('#researchForm1 [name="program_id"]');
                                    programSelect.empty().append('<option value="">Select Program</option>');

                                    programs.forEach(function (program) {
                                        programSelect.append(
                                            `<option value="${program.id}">${program.program_name}</option>`
                                        );
                                    });

                                    // Set Program
                                    programSelect.val(form.program_id).trigger('change');
                                }
                            });
                        }
                    });

                    // ================================
                    // Co Authors
                    // ================================

                    $('#grant-details-container').empty();

                    if (form.co_authors && form.co_authors.length > 0) {
                        form.co_authors.forEach((author, index) => {
                            addCoAuthor(author, index);
                        });
                    } else {
                        addCoAuthor({}, 0);
                    }

                    $('#updateFormModal').modal('show');
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




                var countries = @json(getAllCountries());
                var universities = @json(getUniveristyJson());
                // Add Co-Author button click
                $(document).on('click', '#add-grant', function () {
                    addCoAuthor({}, null);
                });

                // Function to toggle student vs other role fields
                function toggleCoAuthorFieldsRow($row) {
                    let role = $row.find('input[name$="[your_role]"]:checked').val();

                    if (role === 'Student') {
                        // Show student-specific fields
                        $row.find('input[name$="[student_roll_no]"]').closest('.col-md-6').show();
                        $row.find('input[name$="[is_the_student_fitst_coauthor]"]').closest('.col-md-6').show();
                        $row.find('select[name$="[career]"]').closest('.col-md-6').show();

                        // Hide designation
                        $row.find('input[name$="[designation]"]').closest('.col-md-6').hide();
                    } else {
                        // Show designation
                        $row.find('input[name$="[designation]"]').closest('.col-md-6').show();

                        // Hide student-specific fields
                        $row.find('input[name$="[student_roll_no]"]').closest('.col-md-6').hide();
                        $row.find('input[name$="[is_the_student_fitst_coauthor]"]').closest('.col-md-6').hide();
                        $row.find('select[name$="[career]"]').closest('.col-md-6').hide();
                    }
                }

                // Function to add co-author row
                function addCoAuthor(author = {}, index = null) {
                    let i = index !== null ? index : grantIndex;
                    $('#researchForm1').find('.invalid-feedback').remove();
                    $('#researchForm1').find('.is-invalid').removeClass('is-invalid');

                    // Build country options
                    let countryOptions = '<option value="">Select Country</option>';
                    countries.forEach(function (con) {
                        let selected = author.country === con.code ? 'selected' : '';
                        countryOptions += `<option value="${con.code}" ${selected}>${con.name}</option>`;
                    });

                    // Build university options
                    let uniOptions = '<option value="">Select University</option>';
                    universities.forEach(function (uni) {
                        let selected = author.univeristy_name === uni['University Name'] ? 'selected' : '';
                        uniOptions += `<option value="${uni['University Name']}" ${selected}>${uni['University Name']}</option>`;
                    });

                    // HTML for co-author row
                    let html = `
                                                                                                                                                                                                                            <div class="row g-6 grant-group mt-4">
                                                                                                                                                                                                                                <hr>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <input type="hidden" name="co_author[${i}][id]" value="${author.id || ''}">
                                                                                                                                                                                                                                    <label class="form-label">Co-Author Name</label>
                                                                                                                                                                                                                                    <input type="text" name="co_author[${i}][name]" class="form-control" value="${author.name || ''}">
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <label class="form-label">Rank</label>
                                                                                                                                                                                                                                    <input type="number" name="co_author[${i}][rank]" class="form-control" value="${author.rank || ''}">
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <label class="form-label">University Name</label>
                                                                                                                                                                                                                                    <select name="co_author[${i}][univeristy_name]" class="univeristy-dropdown select2 form-select">
                                                                                                                                                                                                                                        ${uniOptions}
                                                                                                                                                                                                                                    </select>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <label class="form-label">Country</label>
                                                                                                                                                                                                                                    <select name="co_author[${i}][country]" class="country-dropdown select2 form-select">
                                                                                                                                                                                                                                        ${countryOptions}
                                                                                                                                                                                                                                    </select>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <label class="form-label d-block">Co-Author Role</label>
                                                                                                                                                                                                                                    <div>
                                                                                                                                                                                                                                        <input type="radio" name="co_author[${i}][your_role]" id="student_${i}" value="Student" ${author.your_role === 'Student' || !author.your_role ? 'checked' : ''}>
                                                                                                                                                                                                                                        <label for="student_${i}">Student</label>

                                                                                                                                                                                                                                        <input type="radio" name="co_author[${i}][your_role]" id="researcher_${i}" value="Researcher" ${author.your_role === 'Researcher' ? 'checked' : ''}>
                                                                                                                                                                                                                                        <label for="researcher_${i}">Researcher</label>

                                                                                                                                                                                                                                        <input type="radio" name="co_author[${i}][your_role]" id="professional_${i}" value="Professional" ${author.your_role === 'Professional' ? 'checked' : ''}>
                                                                                                                                                                                                                                        <label for="professional_${i}">Professional</label>
                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6" style="display:none">
                                                                                                                                                                                                                                    <label class="form-label">Designation</label>
                                                                                                                                                                                                                                    <input type="text" name="co_author[${i}][designation]" class="form-control" value="${author.designation || ''}">
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <label class="form-label">Student Roll Number</label>
                                                                                                                                                                                                                                    <input type="text" name="co_author[${i}][student_roll_no]" class="form-control" value="${author.student_roll_no || ''}">
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <label class="form-label">No Of Papers Co-Authored with this person in the past.</label>
                                                                                                                                                                                                                                    <input type="number" name="co_author[${i}][no_paper_past]" class="form-control" value="${author.no_paper_past || ''}">
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <label class="form-label">Co-Author Email</label>
                                                                                                                                                                                                                                    <input type="email" name="co_author[${i}][co_author_email]" class="form-control" value="${author.co_author_email || ''}">
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <label class="form-label d-block">Is the student first Co-author?</label>
                                                                                                                                                                                                                                    <div>
                                                                                                                                                                                                                                        <input type="radio" name="co_author[${i}][is_the_student_fitst_coauthor]" id="is_the_student_fitst_coauthor_yes_${i}" value="YES" ${author.is_the_student_fitst_coauthor === 'YES' ? 'checked' : ''}>
                                                                                                                                                                                                                                        <label for="is_the_student_fitst_coauthor_yes_${i}">Yes</label>

                                                                                                                                                                                                                                        <input type="radio" name="co_author[${i}][is_the_student_fitst_coauthor]" id="is_the_student_fitst_coauthor_no_${i}" value="NO" ${author.is_the_student_fitst_coauthor !== 'YES' ? 'checked' : ''}>
                                                                                                                                                                                                                                        <label for="is_the_student_fitst_coauthor_no_${i}">No</label>
                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                                    <label class="form-label">Career</label>
                                                                                                                                                                                                                                    <select name="co_author[${i}][career]" class="form-select">
                                                                                                                                                                                                                                        <option value="">Select Career</option>
                                                                                                                                                                                                                                        <option value="PG" ${author.career === 'PG' ? 'selected' : ''}>PG</option>
                                                                                                                                                                                                                                        <option value="MS" ${author.career === 'MS' ? 'selected' : ''}>MS</option>
                                                                                                                                                                                                                                    </select>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="col-md-12 mt-2">
                                                                                                                                                                                                                                    <button type="button" class="btn btn-danger remove-grant">Remove</button>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                            `;

                    $('#grant-details-container').append(html);

                    let $row = $('#grant-details-container .grant-group').last();

                    // Initialize Select2 for both selects
                    $row.find('.univeristy-dropdown.select2').select2({
                        dropdownParent: $('#updateFormModal')
                    });
                    $row.find('.country-dropdown.select2').select2({
                        dropdownParent: $('#updateFormModal')
                    });

                    toggleCoAuthorFieldsRow($row);

                    // Listen for role change
                    $row.find('input[name$="[your_role]"]').change(function () {
                        toggleCoAuthorFieldsRow($row);
                    });

                    grantIndex++;
                }

                // Remove co-author row
                $(document).on('click', '.remove-grant', function () {
                    $(this).closest('.grant-group').remove();
                });

                // Submit update form
                $('#researchForm1').submit(function (e) {
                    e.preventDefault();
                    // Clear previous errors
                    $('.rank-error').remove();
                    $('.is-invalid').removeClass('is-invalid');

                    let form = $(this);
                    let hasError = false;

                    let mainRank = form.find('[name="as_author_your_rank"]').val();

                    if (!mainRank) {
                        form.find('[name="as_author_your_rank"]')
                            .addClass('is-invalid')
                            .after('<div class="rank-error">Your author rank is required.</div>');
                        return;
                    }

                    let usedRanks = new Set();
                    usedRanks.add(mainRank); // include main author rank

                    // Loop through all co-author rank inputs
                    form.find('input[name^="co_author"][name$="[rank]"]').each(function () {
                        let rankInput = $(this);
                        let rankValue = rankInput.val();

                        if (!rankValue) return; // skip empty

                        if (usedRanks.has(rankValue)) {
                            hasError = true;

                            rankInput
                                .addClass('is-invalid')
                                .after('<div class="rank-error">This rank is already used. Please choose a unique rank.</div>');
                        } else {
                            usedRanks.add(rankValue);
                        }
                    });

                    // ❌ Stop submission if any conflict
                    if (hasError) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Rank Conflict',
                            text: 'Author and co-author ranks must all be unique.'
                        });
                        return;
                    }

                    let formData = new FormData(this);
                    let indicatorId = form.find('[name="indicator_id"]').val();

                    Swal.fire({
                        title: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });


                    $.ajax({
                        url: "{{ route('research-pg.update', '') }}/" + indicatorId,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function (res) {
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message || 'Form updated successfully'
                            });
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                            $('#updateFormModal').modal('hide');
                            fetchAchievementForms(); // refresh table
                        },
                        error: function (xhr) {

                            Swal.close();
                            // Clear previous errors
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;

                                $.each(errors, function (field, messages) {
                                    let fieldName = field;

                                    // Convert Laravel dot notation to input name format
                                    if (field.indexOf('.') !== -1) {
                                        fieldName = field.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']';
                                    }

                                    // Find all matching inputs (handles radio/select)
                                    let input = form.find('[name="' + fieldName + '"]');

                                    if (input.length) {
                                        input.addClass('is-invalid');

                                        // For radio buttons, append after the last radio in group
                                        if (input.attr('type') === 'radio') {
                                            input.last().closest('div').append('<div class="invalid-feedback d-block">' + messages[0] + '</div>');
                                        } else {
                                            input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                        }
                                    }
                                });

                                // Optional: scroll to first error
                                let firstError = form.find('.is-invalid').first();
                                if (firstError.length) {
                                    $('html, body').animate({ scrollTop: firstError.offset().top - 100 }, 500);
                                }

                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                            }
                        }

                    });
                });






            });

        </script>
    @endif
@endpush
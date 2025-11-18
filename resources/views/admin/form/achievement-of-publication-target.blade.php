@extends('layouts.app')

@push('style')
    {{-- Vendor CSS --}}
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
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-body">
                @if(auth()->user()->hasRole(['Dean', 'ORIC']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">% Achievement of
                                Publication</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Research Target Setting</a>
                        </li>
                    </ul>
                @endif
                @if(auth()->user()->hasRole(['HOD']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">% Achievement of
                                Publication</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Research Target Setting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#form3" role="tab">Table</a>
                        </li>
                    </ul>
                @endif

                <!-- Tab panes -->
                <div class="tab-content">

                    {{-- ================= FORM 1 ================= --}}
                    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <form id="researchForm1" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" name="kpa_id" value="{{ $areaId }}">
                                <input type="hidden" name="sp_category_id" value="{{ $categoryId }}">
                                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden" id="form_status" name="form_status" value="RESEARCHER" required>

                                <div class="row g-6">
                                    <div class="col-md-6">
                                        <label class="form-label">Target Category</label>
                                        <select name="target_category" class="form-select" required>
                                            <option value="">Select Target Category</option>
                                            <option value="Scopus-Indexed">Scopus Indexed</option>
                                            <option value="HEC">HEC</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Target of Publications</label>
                                        <input type="number" name="target_of_publications" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Progress on publication</label>
                                        <select id="progress_on_publication" name="progress_on_publication" class="form-select"
                                            required>
                                            <option value="">-- Select --</option>
                                            <option value="Published">Published</option>
                                            <option value="In Review">In Review</option>
                                            <option value="At draft stage">At draft stage</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6" id="extraFieldContainer"></div>
                                </div>
                                <div class="col-4 mt-3">
                                    <button class="btn btn-primary w-100">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    @endif
                    {{-- ================= FORM 2 ================= --}}
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade" id="form2" role="tabpanel">
                            <form id="researchForm2" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                                <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                                <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden" id="form_status" name="form_status" value="HOD" required>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="faculty_member" class="form-label">Name of Faculty Member</label>
                                        <select name="faculty_member_id" id="select2Success" class="select2 form-select"
                                            multiple required>
                                            <option value="">-- Select Faculty Member --</option>
                                            @foreach($facultyMembers as $member)
                                                <option value="{{ $member->id }}" data-department="{{ $member->department }}"
                                                    data-job_title="{{ $member->job_title }}">
                                                    {{ $member->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-6 mt-0">
                                    <div class="col-md-4">
                                        <small class="fw-medium d-block pt-4 mb-4">Scopus</small>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">Q1</span>
                                            <input type="number" class="form-control" name="scopus_q1" id="scopus-q1">
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">Q2</span>
                                            <input type="number" class="form-control" name="scopus_q2" id="scopus-q2">
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">Q3</span>
                                            <input type="number" class="form-control" name="scopus_q3" id="scopus-q3">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Q4</span>
                                            <input type="number" class="form-control" name="scopus_q4" id="scopus-q4">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="fw-medium d-block pt-4 mb-4">HEC</small>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">W</span>
                                            <input type="number" class="form-control" name="hec_w" id="hec-w">
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">X</span>
                                            <input type="number" class="form-control" name="hec_x" id="hec-x">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Y</span>
                                            <input type="number" class="form-control" name="hec_y" id="hec-y">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="fw-medium d-block pt-4 mb-4">Medical</small>
                                        <div class="input-group">
                                            <span class="input-group-text">Recognized</span>
                                            <input type="number" class="form-control" name="medical_recognized"
                                                id="medical-recognized">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button"
                                            class="btn btn-outline-secondary waves-effect w-100 total-target">Tota 0</button>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="frequency" class="form-label">National</label>
                                        <input type="number" id="frequency" class="form-control" name="frequency">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="frequency" class="form-label">International</label>
                                        <input type="number" id="frequency" class="form-control" name="frequency">
                                    </div>
                                </div>
                                <div class="col-4 text-center demo-vertical-spacing">
                                    <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="form3" role="tabpanel">
                            @if(auth()->user()->hasRole(['HOD']))
                                <div class="d-flex">
                                    <select id="bulkAction" class="form-select w-auto me-2">
                                        <option value="">-- Select Action --</option>
                                        <option value="2">Verified</option>
                                        <option value="1">UnVerified</option>
                                    </select>
                                    <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                                </div>
                            @endif
                            <table id="complaintTable3" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Indicator Category</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endif
                    @if(auth()->user()->hasRole(['Dean', 'ORIC']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <div class="d-flex">
                                <select id="bulkAction" class="form-select w-auto me-2">
                                    <option value="">-- Select Action --</option>
                                    <option value="3">Review</option>
                                    <option value="2">UnReview</option>
                                </select>
                                <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                            </div>
                            <table id="complaintTable1" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Indicator Category</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="form2" role="tabpanel">
                            <div class="d-flex">
                                <select id="bulkAction" class="form-select w-auto me-2">
                                    <option value="">-- Select Action --</option>
                                    <option value="2">Verified</option>
                                    <option value="1">UnVerified</option>
                                </select>
                                <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                            </div>
                            <table id="complaintTable2" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Indicator Category</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endif
                    @if(auth()->user()->hasRole(['Human Resources']))
                        <div>
                            <table id="complaintTable2" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Indicator Category</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="viewFormModal" tabindex="-1" aria-labelledby="viewFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewFormModalLabel">Form Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Created By</th>
                                <td id="modalCreatedBy"></td>
                            </tr>
                            <tr>
                                <th>Target Category</th>
                                <td id="modalTargetCategory"></td>
                            </tr>
                            <tr>
                                <th>Target Of Publications</th>
                                <td id="modalTargetOfpublications"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="approveCheckbox">
                                        <label class="form-check-label" for="approveCheckbox">Approved</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Created Date</th>
                                <td id="modalCreatedDate"></td>
                            </tr>
                            <tbody id="modalExtraFields"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Permission Modal -->
    </div>
@endsection

@push('script')
    {{-- Vendor Scripts --}}
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
    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
        <script>
            $(document).ready(function () {
                $('select[name="target_category"]').on('change', function () {
                    let category = $(this).val();
                    $.ajax({
                        url: "{{ route('indicator-form.target') }}", // route name
                        type: "GET",
                        data: { target_category: category }, // send selected category
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                // set publications input value
                                $('input[name="target_of_publications"]').val(data.target_of_publications);
                            } else {
                                $('input[name="target_of_publications"]').val(''); // clear if not found
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error:", error);
                            console.log("Status:", status);
                            console.log("Response Text:", xhr.responseText);
                        }
                    });
                });
                // Extra fields for Form 1
                $('#progress_on_publication').on('change', function () {
                    const container = $('#extraFieldContainer');
                    container.empty();

                    if (this.value === 'At draft stage') {
                        container.html(`<label class="form-label">Draft</label>
                                                <input type="text" name="draft_stage" class="form-control" required>`);
                    } else if (this.value === 'In Review') {
                        container.html(`<label class="form-label">Email Screenshot</label>
                                                <input type="file" name="email_screenshot" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required >`);
                    } else if (this.value === 'Published') {
                        container.html(`<label class="form-label">Scopus link</label>
                                                <input type="url" name="scopus_link" class="form-control" required>`);
                    }
                });

                $('#researchForm1').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('indicator-form.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
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

                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                            }
                        }
                    });
                });
            });
        </script>
    @endif
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('indicator-form.index') }}",
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

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.target_category || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Indicator Category" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#complaintTable3').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
            $(document).ready(function () {
                function updateTotal() {
                    let ids = [
                        '#scopus-q1', '#scopus-q2', '#scopus-q3', '#scopus-q4',
                        '#hec-w', '#hec-x', '#hec-y',
                        '#medical-recognized'
                    ];

                    let total = 0;
                    ids.forEach(id => {
                        total += Number($(id).val()) || 0;
                    });

                    $('.total-target').text('Total ' + total);
                }

                // Trigger on input change
                $('#scopus-q1, #scopus-q2, #scopus-q3, #scopus-q4, #hec-w, #hec-x, #hec-y, #medical-recognized')
                    .on('input', updateTotal);
                fetchIndicatorForms3();
                // Extra fields for Form 2
                $('#faculty_member').on('change', function () {
                    let selected = $(this).find(':selected');
                    let department = selected.data('department');
                    let job_title = selected.data('job_title');

                    $('#department').val(department ?? '');
                    $('#job_title').val(job_title ?? '');
                });
                $('#researchForm2').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('indicator-form.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
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

                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                            }
                        }
                    });
                });
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalTargetCategory').text(form.target_category || 'N/A');
                    $('#modalTargetOfpublications').text(form.target_of_publications || 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.currentUserRole === 'HOD') {
                        $('#approveCheckbox').prop('checked', form.status == 2);
                        $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                        // Label text for HOD
                        let statusLabel = "Pending";
                        if (form.status == 1) {
                            statusLabel = "Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        }
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    } else if (window.currentUserRole === 'ORIC') {

                        $('#approveCheckbox').prop('checked', form.status == 3);
                        $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                        let statusLabel = "Pending";
                        if (form.status == 1) {
                            statusLabel = "Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Approved";
                        } else if (form.status == 3) {
                            statusLabel = "Approved";
                        }
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    } else {
                        $('#approveCheckbox').closest('.form-check-input').hide();

                        let statusLabel = "Pending"; // default
                        if (form.status == 1) {
                            statusLabel = "Not Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Approved";
                        }

                        // update the label text
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    }
                    if (form.draft_stage) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Draft Stage</th><td>${form.draft_stage}</td></tr>`);
                    }

                    if (form.email_screenshot_url) {
                        $('#modalExtraFields').append(`
                                        <tr class="optional-field">
                                            <th>Email Screenshot</th>
                                            <td>
                                                <a href="${form.email_screenshot_url}" target="_blank">
                                                    <img src="${form.email_screenshot_url}" alt="Screenshot" style="max-width:200px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                                </a>
                                            </td>
                                        </tr>
                                    `);
                    }


                    if (form.scopus_link) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Scopus Link</th><td><a href="${form.scopus_link}" target="_blank">${form.scopus_link}</a></td></tr>`);
                    }
                    if (form.frequency) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Frequency/No of trainings</th><td>${form.frequency}</td></tr>`);
                    }
                    if (form.need) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Need</th><td>${form.need}</td></tr>`);
                    }
                    if (form.any_specifics_related_to_capacity_building) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Any Specifics related to capacity building</th><td>${form.any_specifics_related_to_capacity_building}</td></tr>`);
                    }
                    $('#viewFormModal').modal('show');
                });
                $(document).on('change', '#approveCheckbox', function () {
                    let id = $(this).data('id');
                    let table_status = $(this).data('table_status');
                    let status;
                    if (window.currentUserRole === "HOD") {
                        status = $(this).is(':checked') ? 2 : 1;
                    }

                    $.ajax({
                        url: `/indicator-form/${id}`,
                        type: 'POST',
                        data: {
                            _method: 'PUT',
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            status: status
                        },
                        success: function (response) {
                            if (response.success) {
                                alert('Status updated successfully!');
                                fetchIndicatorForms3();
                            } else {
                                alert('Failed to update status.');
                            }
                        },
                        error: function () {
                            alert('Error updating status.');
                        }
                    });
                });

            });
        </script>
    @endif
    @if(auth()->user()->hasRole(['Dean', 'ORIC', 'Human Resources']))
        <script>
            function fetchIndicatorForms() {
                $.ajax({
                    url: "{{ route('indicator-form.index') }}",
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

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.target_category || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable2')) {
                            $('#complaintTable2').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Indicator Category" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#complaintTable2').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
            function fetchIndicatorForms1() {
                $.ajax({
                    url: "{{ route('indicator-form.index') }}",
                    method: "GET",
                    data: {
                        status: "RESEARCHER" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.target_category || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable1')) {
                            $('#complaintTable1').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Indicator Category" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#complaintTable1').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
            $(document).ready(function () {
                if (window.currentUserRole === 'Dean') {
                    fetchIndicatorForms();
                    fetchIndicatorForms1();
                } if (window.currentUserRole === 'ORIC') {
                    fetchIndicatorForms();
                    fetchIndicatorForms1();
                } if (window.currentUserRole === 'Human Resources') {
                    fetchIndicatorForms();
                }

                // Handle click on View button
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalTargetCategory').text(form.target_category || 'N/A');
                    $('#modalTargetOfpublications').text(form.target_of_publications || 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.currentUserRole === 'Dean') {
                        let statusLabel = "Review";
                        if (form.form_status == 'RESEARCHER') {
                            $('#approveCheckbox').closest('.form-check-input').show();
                            $('#approveCheckbox').prop('checked', form.status == 3);
                            $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                            // Label text for HOD
                            if (form.status == 2) {
                                statusLabel = "Review";
                            } else if (form.status == 3) {
                                statusLabel = "Review";
                            }
                        } if (form.form_status == 'HOD') {
                            $('#approveCheckbox').closest('.form-check-input').show();
                            $('#approveCheckbox').prop('checked', form.status == 2);
                            $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                            // Label text for HOD
                            if (form.status == 1) {
                                statusLabel = "Verified";
                            } else if (form.status == 2) {
                                statusLabel = "Verified";
                            }
                        }

                        $('label[for="approveCheckbox"]').text(statusLabel);
                    } else if (window.currentUserRole === 'ORIC') {

                        let statusLabel = "Verify";
                        if (form.form_status == 'RESEARCHER') {
                            $('#approveCheckbox').closest('.form-check-input').show();
                            $('#approveCheckbox').prop('checked', form.status == 4);
                            $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                            // Label text for HOD
                            if (form.status == 3) {
                                statusLabel = "Verify";
                            } else if (form.status == 4) {
                                statusLabel = "Verify";
                            }
                        } if (form.form_status == 'HOD') {
                            $('#approveCheckbox').closest('.form-check-input').show();
                            $('#approveCheckbox').prop('checked', form.status == 3);
                            $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                            // Label text for HOD
                            if (form.status == 2) {
                                statusLabel = "Verify";
                            } else if (form.status == 3) {
                                statusLabel = "Verify";
                            }
                        }

                        $('label[for="approveCheckbox"]').text(statusLabel);
                    } else if (window.currentUserRole === 'Human Resources') {

                        let statusLabel = "Verify";
                        if (form.form_status == 'HOD') {
                            $('#approveCheckbox').closest('.form-check-input').show();
                            $('#approveCheckbox').prop('checked', form.status == 4);
                            $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                            // Label text for HOD
                            if (form.status == 3) {
                                statusLabel = "Verify";
                            } else if (form.status == 3) {
                                statusLabel = "Verify";
                            }
                        }

                        $('label[for="approveCheckbox"]').text(statusLabel);
                    }
                    else {
                        $('#approveCheckbox').closest('.form-check-input').hide();

                        let statusLabel = "Pending"; // default
                        if (form.status == 1) {
                            statusLabel = "Not Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Approved";
                        }

                        // update the label text
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    }
                    if (form.draft_stage) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Draft Stage</th><td>${form.draft_stage}</td></tr>`);
                    }

                    if (form.email_screenshot_url) {
                        $('#modalExtraFields').append(`
                                <tr class="optional-field">
                                    <th>Email Screenshot</th>
                                    <td>
                                        <a href="${form.email_screenshot_url}" target="_blank">
                                            <img src="${form.email_screenshot_url}" alt="Screenshot" style="max-width:200px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                        </a>
                                    </td>
                                </tr>
                            `);
                    }


                    if (form.scopus_link) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Scopus Link</th><td><a href="${form.scopus_link}" target="_blank">${form.scopus_link}</a></td></tr>`);
                    }
                    if (form.frequency) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Frequency/No of trainings</th><td>${form.frequency}</td></tr>`);
                    }
                    if (form.need) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Need</th><td>${form.need}</td></tr>`);
                    }
                    if (form.any_specifics_related_to_capacity_building) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Any Specifics related to capacity building</th><td>${form.any_specifics_related_to_capacity_building}</td></tr>`);
                    }
                    $('#viewFormModal').modal('show');
                });

                $(document).on('change', '#approveCheckbox', function () {
                    let id = $(this).data('id');
                    let table_status = $(this).data('table_status');
                    let status;
                    if (window.currentUserRole === "Dean") {
                        if (table_status == "RESEARCHER") {
                            status = $(this).is(':checked') ? 3 : 2;
                        } if (table_status == "HOD") {
                            status = $(this).is(':checked') ? 2 : 1;
                        }
                    }
                    if (window.currentUserRole === "ORIC") {
                        if (table_status == "RESEARCHER") {
                            status = $(this).is(':checked') ? 4 : 3;
                        } if (table_status == "HOD") {
                            status = $(this).is(':checked') ? 3 : 2;
                        }
                    }
                    if (window.currentUserRole === "Human Resources") {
                        if (table_status == "HOD") {
                            status = $(this).is(':checked') ? 4 : 3;
                        }
                    }

                    $.ajax({
                        url: `/indicator-form/${id}`,
                        type: 'POST',
                        data: {
                            _method: 'PUT',
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            status: status
                        },
                        success: function (response) {
                            if (response.success) {
                                alert('Status updated successfully!');
                                if (table_status === "RESEARCHER") {
                                    fetchIndicatorForms1(); // refresh only researcher table
                                }
                                if (table_status === "HOD") {
                                    fetchIndicatorForms(); // refresh only researcher table
                                }
                            } else {
                                alert('Failed to update status.');
                            }
                        },
                        error: function () {
                            alert('Error updating status.');
                        }
                    });
                });

            });
        </script>
    @endif

@endpush
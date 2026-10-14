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
@php
    $indicatorId=128;
@endphp
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="nav-align-top">

            <!-- Tab panes -->
            <div class="tab-content">
               
                {{-- ================= FORM 2 ================= --}}
                
                @if(in_array(getRoleName(activeRole()), ['ORIC']))
                    
                    <div class="" id="form2" role="tabpanel">
                       <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-5">Research Publication Target Assign</h5>
            </div>
                        <form id="researchForm2" enctype="multipart/form-data" class="row">
                            @csrf
                            <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                            <input type="hidden" id="form_status" name="form_status" value="HOD" required>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="faculty_member" class="form-label">Name of Faculty Member</label>
                                    <select name="faculty_member_id[]" id="select2Success" class="select2 form-select" multiple
                                        required>
                                        
                                        @foreach($facultyMembers as $member)
                                            <option value="{{ $member->id }}" data-department="{{ $member->department }}"
                                                data-job_title="{{ $member->job_title }}">
                                                {{ $member->name }} / 
                                                
                                                @if($member->roles->isNotEmpty())
                                                    ({{ $member->roles->first()->name === 'Teacher' ? 'Lecturer' : $member->roles->first()->name }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="year" class="form-label">Year</label>
                                    <select name="year_id" id="year_id"
                                        class="form-select" required>
                                        <option value=""> Select year</option>
                                            @foreach(SelectCurrentYear() as $year) <option value="{{ $year->id }}">{{ $year->year }}</option> @endforeach
                                        </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>

                                    <textarea
                                        class="form-control"
                                        id="description"
                                        name="description"
                                        rows="4"
                                        placeholder="Enter description"></textarea>

                                </div>







                            </div>
                            <div class="row g-6 mt-0">
                                <div class="col-md-3">
                                    <small class="fw-medium d-block pt-4 mb-4">Scopus</small>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">Scopus</span>
                                        <input type="number" min="0" class="form-control" name="scopus_q1" id="scopus-q1">
                                    </div>
                                    {{-- <div class="input-group mb-4">
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
                                    </div> --}}
                                </div>
                                <div class="col-md-3">
                                    <small class="fw-medium d-block pt-4 mb-4">HEC</small>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">HEC</span>
                                        <input type="number" min="0" class="form-control" name="hec_w" id="hec-w">
                                    </div>
                                    {{-- <div class="input-group mb-4">
                                        <span class="input-group-text">X</span>
                                        <input type="number" class="form-control" name="hec_x" id="hec-x">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text">Y</span>
                                        <input type="number" class="form-control" name="hec_y" id="hec-y">
                                    </div> --}}
                                </div>
                                <div class="col-md-3">
                                    <small class="fw-medium d-block pt-4 mb-4">Medical</small>
                                    <div class="input-group">
                                        <span class="input-group-text">Medical</span>
                                        <input type="number" min="0" class="form-control" name="medical_recognized"
                                            id="medical-recognized">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                   <small class="fw-medium d-block pt-4 mb-4">Total</small>
                                    <button type="button" class="btn btn-outline-secondary waves-effect w-100 total-target">Tota
                                        0</button>
                                    <input type="text" name="target" class="" style="display:none">
                                </div>
                                {{-- <div class="col-md-6">
                                    <label for="national" class="form-label">National</label>
                                    <input type="number" id="national" class="form-control" name="national">
                                </div>
                                <div class="col-md-6">
                                    <label for="international" class="form-label">Inter National</label>
                                    <input type="number" id="international" class="form-control" name="international">
                                </div> --}}
                            </div>
                            <div class="col-4 demo-vertical-spacing">
                                <button class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                            </div>
                        </form>
                        <hr>
                        <div class="">
                            <div class="table-responsive">
                                <table id="geTtargetTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Indicator</th>
                                            <th>Target</th>
                                            <th>Description</th>
                                            <th>Scopus</th>
                                            <th>HEC</th>
                                            <th>Medical</th>
                                            <th>Year</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="form2" role="tabpanel">

                        {{-- <table id="complaintTable2" class="table table-bordered table-striped" style="width:100%">
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
                        </table> --}}
                    </div>
                @endif
            </div>
        </div>
       

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
    @if(in_array(getRoleName(activeRole()), ['ORIC']))
        <script>
            function fetchHodTarget() {
                $.ajax({
                    url: "{{ route('faculty-target-admin.index') }}",
                    method: "GET",
                    data: {
                        status: "DEAN",
                        indicator: {{ $indicatorId }}
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
                                i + 1,
                                form.user ? form.user.name : 'N/A',
                                form.indicator ? form.indicator.indicator : 'N/A',
                                form.target ?? 'N/A',
                                form.description ?? 'N/A',
                                form.scopus_q1 ?? 'N/A',
                                form.hec_w ?? 'N/A',
                                form.medical_recognized ?? 'N/A',
                                form.year ? form.year.year : 'N/A'
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#geTtargetTable')) {
                            $('#geTtargetTable').DataTable({
                                data: rowData,
                                scrollX: false,
                                scrollCollapse: false,
                                autoWidth: false,
                                columns: [
                                    { title: "#" },
                                    { title: "User" },
                                    { title: "Indicator" },
                                    { title: "Target" },
                                    { title: "Description" },
                                    { title: "Scopus" },
                                    { title: "HEC" },
                                    { title: "Medical" },
                                    { title: "Year" }

                                ]
                            });
                        } else {
                            $('#geTtargetTable').DataTable().clear().rows.add(rowData).draw();
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
                            const formData = encodeURIComponent(
                                    JSON.stringify(form)
                                );    

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.target_category || 'N/A',
                                form.journal_clasification || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form="${formData}"><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable1')) {
                            $('#complaintTable1').DataTable({
                                data: rowData,
                                scrollX: true,
                                scrollCollapse: true,
                                autoWidth: false,
                                columns: [
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Indicator Category" },
                                    { title: "Classification" },
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
                    $('input[name="target"]').val(total);
                }

                // Trigger on input change
                $('#scopus-q1, #scopus-q2, #scopus-q3, #scopus-q4, #hec-w, #hec-x, #hec-y, #medical-recognized')
                    .on('input', updateTotal);
                fetchIndicatorForms1();
                fetchHodTarget();

                // Handle click on View button
                $(document).on('click', '.view-form-btn', function () {
                    //const form = $(this).data('form');
                    const encodedForm = $(this).attr('data-form');
                    const form = JSON.parse(
                        decodeURIComponent(encodedForm)
                    );
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalExtraFieldsHistory').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalTargetCategory').text(form.target_category || 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.activeUserRole === 'Dean') {
                        $('#status-approval').hide();
                        $('label[for="approveCheckbox"]').hide();
                        $('#approveCheckbox').closest('.form-check-input').hide();
                    } else {

                    }

                     if (form.publication_title) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Publication Title</th><td>${form.publication_title}</td></tr>`);
                    }
                    if (form.journal_name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Journal Name</th><td>${form.journal_name}</td></tr>`);
                    }
                    if (form.link_of_publications) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Link</th><td><div><a style="word-break: break-word;overflow-wrap: anywhere;"  href="${form.link_of_publications}" target="_blank">${form.link_of_publications}</a></div></td></tr>`);
                    }
                    if (form.rank) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Rank</th><td>${form.rank}</td></tr>`);
                    }
                    if (form.nationality) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>CO-Author National/Inter National</th><td>${form.nationality}</td></tr>`);
                    }
                    if (form.target_category) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target Category</th><td><span class="badge rounded-pill bg-label-primary">${form.target_category}</span></td></tr>`);
                    }
                    if (form.journal_clasification) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Selected Target</th><td><span class="badge rounded-pill bg-label-primary">${form.journal_clasification}</span></td></tr>`);
                    }
                    if (form.journal_hec) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>HEC</th><td><span class="badge rounded-pill bg-label-primary">${form.journal_hec}</span></td></tr>`);
                    }
                    if (form.journal_wos) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>WOS</th><td><span class="badge rounded-pill bg-label-primary">${form.journal_wos}</span></td></tr>`);
                    }
                    if (form.scopus_q1) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target</th><td>${form.scopus_q1}</td></tr>`);
                    }
                    if (form.scopus_q2) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target</th><td>${form.scopus_q2}</td></tr>`);
                    }
                    if (form.scopus_q3) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target</th><td>${form.scopus_q3}</td></tr>`);
                    }
                    if (form.scopus_q4) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target</th><td>${form.scopus_q4}</td></tr>`);
                    }
                    if (form.hec_w) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target</th><td>${form.hec_w}</td></tr>`);
                    }
                    if (form.hec_x) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target</th><td>${form.hec_x}</td></tr>`);
                    }
                    if (form.hec_y) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target</th><td>${form.hec_y}</td></tr>`);
                    }
                    if (form.medical_recognized) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target</th><td>${form.medical_recognized}</td></tr>`);
                    }
                    if (form.as_author_your_rank) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Your Rank (As Author)</th><td>${form.as_author_your_rank}</td></tr>`);
                    }
                    // ✅ append co Author dynamically
                    //alert(JSON.stringify(form));
                    if (form.co_authors && form.co_authors.length > 0) {

                        form.co_authors.forEach((coAuthor, index) => {
                            $('#modalExtraFields').append(`
                                                                                                                                        <tr class="optional-field">
                                                                                                                                            <th>co Author ${index + 1}</th>
                                                                                                                                            <td>
                                                                                                                                                <strong>Name:</strong> ${coAuthor.name || 'N/A'}<br>
                                                                                                                                                <strong>Rank:</strong> ${coAuthor.rank || 'N/A'}<br>
                                                                                                                                                <strong>Univeristy Name:</strong> ${coAuthor.univeristy_name || 'N/A'}<br>
                                                                                                                                                <strong>Country:</strong> ${coAuthor.country || 'N/A'}<br>
                                                                                                                                                <strong>No Paper Past:</strong> ${coAuthor.no_paper_past || 'N/A'}<br>
                                                                                                                                                ${coAuthor.student_roll_no ? `<strong>Student:</strong> ${coAuthor.student_roll_no}<br>` : ''}
                                                                                                                                                ${coAuthor.co_author_email ? `<strong>Email:</strong> ${coAuthor.co_author_email}<br>` : ''}
                                                                                                                                                ${coAuthor.your_role ? `<strong>Your Role:</strong> ${coAuthor.your_role}<br>` : ''}
                                                                                                                                                ${coAuthor.career ? `<strong>Career:</strong> ${coAuthor.career}<br>` : ''}
                                                                                                                                                ${coAuthor.designation ? `<strong>Designation:</strong> ${coAuthor.designation}<br>` : ''}
                                                                                                                                                ${coAuthor.organization ? `<strong>Organization:</strong> ${coAuthor.organization}<br>` : ''}
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    `);
                        });
                    } else {
                        $('#modalExtraFields').append(`
                                                                                                                                    <tr class="optional-field">
                                                                                                                                        <th>co Author</th>
                                                                                                                                        <td>No co Author available</td>
                                                                                                                                    </tr>
                                                                                                                                `);
                    }
                    if (form.update_history) {
                        // Parse JSON string if it's a string
                        let history = typeof form.update_history === 'string' ? JSON.parse(form.update_history) : form.update_history;

                        if (history.length > 0) {

                            let historyHtml = '';

                            history.forEach(update => {
                                let histortText = 'N/A';

                                // Role-based status mapping
                                // Role-based status mapping
                                if (update.role === 'HOD') {
                                    if (update.status == '0') histortText = 'Reject';
                                    else if (update.status == '1') histortText = 'unapproved';
                                    else if (update.status == '2') histortText = 'Approved';
                                } else if (update.role === 'ORIC') {
                                    if (update.status == '0') histortText = 'Reject';
                                    else if (update.status == '2') histortText = 'unapproved';
                                    else if (update.status == '3') histortText = 'Approved';
                                    else if (update.status == '4') histortText = 'OnHold';
                                } else {
                                    histortText = update.status; // fallback
                                }
                                historyHtml += `
                                                                                                        <li class="timeline-item timeline-item-transparent optional-field">
                                                                                                            <span class="timeline-point timeline-point-primary"></span>
                                                                                                            <div class="timeline-event">
                                                                                                                <div class="timeline-header mb-3">
                                                                                                                    <h6 class="mb-0">${update.user_name}</h6><small class="text-body-secondary">${new Date(update.updated_at).toLocaleString()}</small>
                                                                                                                </div>
                                                                                                                <div class="d-flex align-items-center mb-1">
                                                                                                                    <div class="badge bg-lighter rounded-3">
                                                                                                                     <span class="h6 mb-0 text-body">${update.role || 'N/A'}</span>
                                                                                                                    </div>
                                                                                                                    <div class="badge bg-lighter rounded-3 ms-2">
                                                                                                                     <span class="h6 mb-0 text-body">${histortText}</span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="d-flex align-items-center mb-1">
                                                                                                                    <div class="badge bg-danger rounded-3 ms-2">
                                                                                                                    <span class="h6 mb-0 text-white">${update.remarks || ''}<span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </li>
                                                                                                    `;
                            });

                            $('#modalExtraFieldsHistory').append(historyHtml);
                        }
                    }
                    else {
                        $('#modalExtraFieldsHistory').append(`
                                                                                                                                        <li class="optional-field">
                                                                                                                                            <th>No History Avalable</th>
                                                                                                                                        </li>
                                                                                                                                    `);
                    }


                    $('#viewFormModal').modal('show');
                });
                $('#researchForm2').on('submit', function (e) {
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
                        url: "{{ route('faculty-target-admin.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();

                             // Remove validation errors
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                            $('#select2Success').val(null).trigger('change');
                            fetchHodTarget();
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

@endpush
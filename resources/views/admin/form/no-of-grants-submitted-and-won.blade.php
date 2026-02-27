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
    @if(in_array(getRoleName(activeRole()), ['Dean','HOD','ORIC','Professor','Assistant Professor','Associate Professor']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                @if(in_array(getRoleName(activeRole()), ['Dean']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab"># of Grants Won</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Research Target Setting</a>
                        </li>
                    </ul>
                @endif
                @if(in_array(getRoleName(activeRole()), ['HOD']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab"># of Grants Won</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#form3" role="tab">Table</a>
                        </li>
                    </ul>
                @endif

                <!-- Tab panes -->
                <div class="tab-content">
                     @if(in_array(getRoleName(activeRole()), ['HOD','Professor','Assistant Professor','Associate Professor']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h5 class="mb-1"># of Grants Won</h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'no-of-grants-submitted-and-won', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div> 
                            <h5 class="text-primary" id="indicatorTarget">Target 0</h5>
                            <form id="researchForm" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER">

                                <div class="row g-6 mt-0">

                                    <div id="grant-details-container">
                                        <div class="grant-group row g-3 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Name Of Grant</label>
                                                <input type="text" name="grants[0][name]" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Funding Agency</label>
                                                <input type="text" name="grants[0][funding_agency]" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Grant Volume</label>
                                                <input type="text" name="grants[0][volume]" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Your Role</label>
                                                <select name="grants[0][role]" class="form-select" required>
                                                    <option value="">-- Select --</option>
                                                    <option value="PI">PI</option>
                                                    <option value="CO-PI">CO-PI</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Status</label>
                                                <select name="grants[0][grant_status]" class="form-select grant-status" required>
                                                    <option value="">-- Select --</option>
                                                    <option value="Submitted">Submitted</option>
                                                    <option value="Won">Won</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 proof-container" style="display:none;">
                                                <label class="form-label proof-label">Proof Of Submission</label>
                                                <input type="file" name="grants[0][proof]" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" id="add-grant"><i
                                                class="icon-base ti tabler-plus me-1"></i> <span
                                                class="align-middle">Add</span></button>
                                    </div>
                                </div>
                                <div class="col-12 demo-vertical-spacing">
                                    <button class="btn btn-primary waves-effect waves-light float-end" style="margin-right: 24px;">SUBMIT</button>
                                </div>
                            </form>
                            
                        </div>
                    @endif
                    @if(in_array(getRoleName(activeRole()), ['HOD']))
                        <div class="tab-pane fade" id="form3" role="tabpanel">
                            @if(in_array(getRoleName(activeRole()), ['HOD']))
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
                                        <th>Name</th>
                                        <th>Funding Agency</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endif
                    @if(in_array(getRoleName(activeRole()), ['Dean']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            
                            <table id="complaintTable3" class="table table-bordered table-striped" style="width:100%">
                                 <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Name</th>
                                        <th>Funding Agency</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="form2" role="tabpanel">
                            {{-- <div class="d-flex">
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
                                        <th>Target IP Disclosed</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table> --}}
                        </div>
                    @endif
                    @if(in_array(getRoleName(activeRole()), ['ORIC']))
                        <div>
                            <div class="d-flex">
                                <select id="bulkAction" class="form-select w-auto me-2">
                                        <option value="">-- Select Action --</option>
                                        <option value="3">Verified</option>
                                        <option value="2">UnVerified</option>
                                    </select>
                                <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                            </div>
                            <table id="complaintTable3" class="table table-bordered table-striped" style="width:100%">
                                 <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Name</th>
                                        <th>Funding Agency</th>
                                        <th>Status</th>
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
                            <tr id="status-approval">
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
                        <h5 class="card-title mb-2 me-2 pt-1 mb-2 d-flex align-items-center"><i class="icon-base ti tabler-history me-3"></i>History</h5>
                        <ul class="timeline mb-0" id="modalExtraFieldsHistory">
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Permission Modal -->
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
        window.activeUserRole = "{{ getRoleName(activeRole()) }}";
    </script>
@endpush
@push('script')
      @if(in_array(getRoleName(activeRole()), ['HOD','Professor','Assistant Professor','Associate Professor']))
        <script>
            $(document).ready(function () {
               function fetchTarget(indicatorId) {

                    if (!indicatorId) {
                        $('#indicatorTarget').text('Target: N/A');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('faculty-target.getTarget') }}",
                        type: "GET",
                        data: {
                            indicator_id: indicatorId
                        },
                        success: function(res) {
                            if (res.target) {
                                $('#indicatorTarget').text('Target: ' + res.target);
                            } else {
                                $('#indicatorTarget').text('Target: N/A');
                            }
                        },
                        error: function() {
                            $('#indicatorTarget').text('Target: N/A');
                        }
                    });
                }

                // ✅ Pass PHP variable safely
                fetchTarget({{ $indicatorId }});


                let grantIndex = 1;

                // Add new grant group
                $('#add-grant').click(function () {
                    let newGroup = `
                                                                                                                                                                                <div class="grant-group row g-3 mb-3">
                                                                                                                                                                                <hr>
                                                                                                                                                                                    <div class="col-md-4">
                                                                                                                                                                                        <label class="form-label">Name Of Grant</label>
                                                                                                                                                                                        <input type="text" name="grants[${grantIndex}][name]" class="form-control" required>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="col-md-4">
                                                                                                                                                                                        <label class="form-label">Funding Agency</label>
                                                                                                                                                                                        <input type="text" name="grants[${grantIndex}][funding_agency]" class="form-control" required>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="col-md-4">
                                                                                                                                                                                        <label class="form-label">Grant Volume</label>
                                                                                                                                                                                        <input type="text" name="grants[${grantIndex}][volume]" class="form-control" required>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="col-md-4">
                                                                                                                                                                                        <label class="form-label">Your Role</label>
                                                                                                                                                                                        <select name="grants[${grantIndex}][role]" class="form-select" required>
                                                                                                                                                                                            <option value="">-- Select --</option>
                                                                                                                                                                                            <option value="PI">PI</option>
                                                                                                                                                                                            <option value="CO-PI">CO-PI</option>
                                                                                                                                                                                        </select>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="col-md-4">
                                                                                                                                                                                        <label class="form-label">Status</label>
                                                                                                                                                                                        <select name="grants[${grantIndex}][grant_status]" class="form-select grant-status" required>
                                                                                                                                                                                            <option value="">-- Select --</option>
                                                                                                                                                                                            <option value="Submitted">Submitted</option>
                                                                                                                                                                                            <option value="Won">Won</option>
                                                                                                                                                                                        </select>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="col-md-4 proof-container" style="display:none;">
                                                                                                                                                                                        <label class="form-label proof-label">Proof Of Submission</label>
                                                                                                                                                                                        <input type="file" name="grants[${grantIndex}][proof]" class="form-control" required>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="col-md-2 d-flex align-items-end">
                                                                                                                                                                                        <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-grant">
                                                                                                                                                                                            <i class="icon-base ti tabler-x me-1"></i>
                                                                                                                                                                                            <span class="align-middle">Delete</span>
                                                                                                                                                                                        </button>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </div>`;

                    $('#grant-details-container').append(newGroup);
                    grantIndex++;
                });

                // Remove a grant group
                $(document).on('click', '.remove-grant', function () {
                    $(this).closest('.grant-group').remove();
                });

                // Show/hide proof field based on status
                $(document).on('change', '.grant-status', function () {
                    let status = $(this).val();
                    let container = $(this).closest('.grant-group').find('.proof-container');
                    let label = container.find('.proof-label');

                    if (status === 'Submitted') {
                        label.text('Provide Attachment (Approval)');
                        container.show();
                    } else if (status === 'Won') {
                        label.text('Proof (Award Letter)');
                        container.show();
                    } else {
                        container.hide();
                        container.find('input[type="file"]').val('');
                    }
                });

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
                        url: "{{ route('no-Of-GrantSubmit-And-Won.store') }}",
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
                                        let fieldName = field.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']';
                                        fieldName = fieldName.replace('[]]', ']');
                                        let input = form.find('[name="' + fieldName + '"]');

                                        if (input.length) {
                                            input.addClass('is-invalid');

                                            // Show error message under input
                                            input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                        }
                                    });

                                } else {
                                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                                }
                        }
                    });
                });

            });
        </script>
    @endif
     @if(in_array(getRoleName(activeRole()), ['HOD']))
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('no-Of-GrantSubmit-And-Won.index') }}",
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
                            let statusText = 'N/A';
                            if (form.status == 1) statusText = 'Unverified';
                            else if (form.status == 2) statusText = 'Verified';    

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.name || 'N/A',
                                form.funding_agency || 'N/A',
                                `<span class="badge bg-label-primary">${statusText}</span>`,
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
                                    { title: "Name" },
                                    { title: "Funding Agency" },
                                    { title: "Status" },
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
            // ✅ Reusable function for single update
            function updateSingleStatus(id, status) {
                $.ajax({
                    url: `/no-Of-GrantSubmit-And-Won/${id}`,           // single row endpoint
                    type: 'POST',                            // POST with _method PUT
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: res.message || 'Status updated successfully!'
                        });
                        
                        fetchIndicatorForms3();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong!'
                        });
                    }
                });
            }
            $(document).ready(function () {
                fetchIndicatorForms3();
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalExtraFieldsHistory').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.activeUserRole === 'HOD') {
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
                    if (form.name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name</th><td>${form.name}</td></tr>`);
                    }

                    if (form.funding_agency) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Funding Agency</th><td>${form.funding_agency}</td></tr>`);
                    }
                    if (form.volume) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Volume</th><td>${form.volume}</td></tr>`);
                    }
                    if (form.role) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Role</th><td>${form.role}</td></tr>`);
                    }
                    if (form.grant_status) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Grant Status</th><td>${form.grant_status}</td></tr>`);
                    }
                    
                     


                     if (form.proof) {
                        let fileUrl = form.proof;
                        let fileExt = fileUrl.split('.').pop().toLowerCase();

                        let filePreview = '';

                        // ✅ If Image → show preview
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                            filePreview = `
                                <a href="${fileUrl}" target="_blank">
                                    <img src="${fileUrl}" alt="Screenshot" 
                                        style="max-width:200px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                </a>
                            `;
                        }
                        // ✅ If PDF → show download button
                        else if (fileExt === 'pdf') {
                            filePreview = `
                                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary">
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

                        $('#modalExtraFields').append(`
                            <tr class="optional-field">
                                <th>Supporting Document</th>
                                <td>${filePreview}</td>
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
                                    if (update.role === 'HOD') {
                                        if (update.status == '1') histortText = 'unapproved';
                                        else if (update.status == '2') histortText = 'Approved';
                                    } else if (update.role === 'ORIC') {
                                        if (update.status == '2') histortText = 'Unverified';
                                        else if (update.status == '3') histortText = 'Verified';
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



                 // ✅ Single checkbox status change
                $(document).on('change', '#approveCheckbox', function () {
                    const id = $(this).data('id');
                    const status = $(this).is(':checked') ? 2 : 1;
                    updateSingleStatus(id, status);
                });

                // ✅ Bulk submit button
                $('#bulkSubmit').on('click', function () {
                    const status = $('#bulkAction').val();
                    let selectedIds = [];

                    $('#complaintTable3 .rowCheckbox:checked').each(function () {
                        selectedIds.push($(this).val());
                    });

                    if (!status) {
                        Swal.fire({ icon: 'warning', title: 'Select Action', text: 'Please select a status to update.' });
                        return;
                    }
                    if (!selectedIds.length) {
                        Swal.fire({ icon: 'warning', title: 'No Selection', text: 'Please select at least one row.' });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to change status for ${selectedIds.length} item(s).`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedIds.forEach(id => updateSingleStatus(id, status));
                        }
                    });
                });

                // ✅ Select / Deselect all checkboxes
                $(document).on('change', '#selectAll', function () {
                    $('.rowCheckbox').prop('checked', $(this).is(':checked'));
                });
            });
        </script>
    @endif
     @if(in_array(getRoleName(activeRole()), ['Dean']))
       <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('no-Of-GrantSubmit-And-Won.index') }}",
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
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.name || 'N/A',
                                form.funding_agency || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Name" },
                                    { title: "Funding Agency" },
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
                fetchIndicatorForms3();
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalExtraFieldsHistory').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.activeUserRole === 'Dean') {
                        $('#status-approval').hide();
                        $('label[for="approveCheckbox"]').hide();
                        $('#approveCheckbox').closest('.form-check-input').hide();
                    }  else {
                        
                    }
                    
                    if (form.name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name</th><td>${form.name}</td></tr>`);
                    }

                    if (form.funding_agency) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Funding Agency</th><td>${form.funding_agency}</td></tr>`);
                    }
                    if (form.volume) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Volume</th><td>${form.volume}</td></tr>`);
                    }
                    if (form.role) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Role</th><td>${form.role}</td></tr>`);
                    }
                    if (form.grant_status) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Grant Status</th><td>${form.grant_status}</td></tr>`);
                    }
                    
                     


                     if (form.proof) {
                        let fileUrl = form.proof;
                        let fileExt = fileUrl.split('.').pop().toLowerCase();

                        let filePreview = '';

                        // ✅ If Image → show preview
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                            filePreview = `
                                <a href="${fileUrl}" target="_blank">
                                    <img src="${fileUrl}" alt="Screenshot" 
                                        style="max-width:200px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                </a>
                            `;
                        }
                        // ✅ If PDF → show download button
                        else if (fileExt === 'pdf') {
                            filePreview = `
                                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary">
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

                        $('#modalExtraFields').append(`
                            <tr class="optional-field">
                                <th>Supporting Document</th>
                                <td>${filePreview}</td>
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
                                    if (update.role === 'HOD') {
                                        if (update.status == '1') histortText = 'unapproved';
                                        else if (update.status == '2') histortText = 'Approved';
                                    } else if (update.role === 'ORIC') {
                                        if (update.status == '2') histortText = 'Unverified';
                                        else if (update.status == '3') histortText = 'Verified';
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



            });
        </script>
    @endif
     @if(in_array(getRoleName(activeRole()), ['ORIC']))
       <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('no-Of-GrantSubmit-And-Won.index') }}",
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
                            let statusText = 'N/A';
                            if (form.status == 2) statusText = 'Unapprove';
                            else if (form.status == 3) statusText = 'Approve';      

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.name || 'N/A',
                                form.funding_agency || 'N/A',
                                `<span class="badge bg-label-primary">${statusText}</span>`,
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
                                    { title: "Name" },
                                    { title: "Funding Agency" },
                                    { title: "Status" },
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
            // ✅ Reusable function for single update
            function updateSingleStatus(id, status) {
                $.ajax({
                    url: `/no-Of-GrantSubmit-And-Won/${id}`,           // single row endpoint
                    type: 'POST',                            // POST with _method PUT
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: res.message || 'Status updated successfully!'
                        });
                        
                        fetchIndicatorForms3();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong!'
                        });
                    }
                });
            }
            $(document).ready(function () {
                fetchIndicatorForms3();
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalExtraFieldsHistory').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.activeUserRole === 'ORIC') {
                        $('#approveCheckbox').prop('checked', form.status == 3);
                        $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                        // Label text for ORIC
                        let statusLabel = "Pending";
                        if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Verified";
                        }
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    }  else {
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
                   
                     
                     if (form.name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name</th><td>${form.name}</td></tr>`);
                    }

                    if (form.funding_agency) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Funding Agency</th><td>${form.funding_agency}</td></tr>`);
                    }
                    if (form.volume) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Volume</th><td>${form.volume}</td></tr>`);
                    }
                    if (form.role) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Role</th><td>${form.role}</td></tr>`);
                    }
                    if (form.grant_status) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Grant Status</th><td>${form.grant_status}</td></tr>`);
                    }
                    
                     


                     if (form.proof) {
                        let fileUrl = form.proof;
                        let fileExt = fileUrl.split('.').pop().toLowerCase();

                        let filePreview = '';

                        // ✅ If Image → show preview
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                            filePreview = `
                                <a href="${fileUrl}" target="_blank">
                                    <img src="${fileUrl}" alt="Screenshot" 
                                        style="max-width:200px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                </a>
                            `;
                        }
                        // ✅ If PDF → show download button
                        else if (fileExt === 'pdf') {
                            filePreview = `
                                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary">
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

                        $('#modalExtraFields').append(`
                            <tr class="optional-field">
                                <th>Supporting Document</th>
                                <td>${filePreview}</td>
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
                                    if (update.role === 'HOD') {
                                        if (update.status == '1') histortText = 'unapproved';
                                        else if (update.status == '2') histortText = 'Approved';
                                    } else if (update.role === 'ORIC') {
                                        if (update.status == '2') histortText = 'Unverified';
                                        else if (update.status == '3') histortText = 'Verified';
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



                 // ✅ Single checkbox status change
                $(document).on('change', '#approveCheckbox', function () {
                    const id = $(this).data('id');
                    const status = $(this).is(':checked') ? 3 : 2;
                    updateSingleStatus(id, status);
                });

                // ✅ Bulk submit button
                $('#bulkSubmit').on('click', function () {
                    const status = $('#bulkAction').val();
                    let selectedIds = [];

                    $('#complaintTable3 .rowCheckbox:checked').each(function () {
                        selectedIds.push($(this).val());
                    });

                    if (!status) {
                        Swal.fire({ icon: 'warning', title: 'Select Action', text: 'Please select a status to update.' });
                        return;
                    }
                    if (!selectedIds.length) {
                        Swal.fire({ icon: 'warning', title: 'No Selection', text: 'Please select at least one row.' });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to change status for ${selectedIds.length} item(s).`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedIds.forEach(id => updateSingleStatus(id, status));
                        }
                    });
                });

                // ✅ Select / Deselect all checkboxes
                $(document).on('change', '#selectAll', function () {
                    $('.rowCheckbox').prop('checked', $(this).is(':checked'));
                });
            });
        </script>
    @endif
@endpush
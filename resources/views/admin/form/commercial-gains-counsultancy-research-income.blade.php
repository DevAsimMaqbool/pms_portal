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
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                @if(auth()->user()->hasRole(['Dean']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Commercial Gains /
                                Consultancy/Research Income</a>
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
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Commercial Gains /
                                Consultancy/Research Income</a>
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
                            <div class="d-flex justify-content-between">
                               <div>
                                <h5 class="mb-1">Commercial Consultancy/Research Income</h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'commercial-gains-counsultancy-research-income', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div>  
                            
                            <h5 class="text-primary" id="indicatorTarget">Target 0</h5>
                            <form id="researchForm1" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden" id="form_status" name="form_status" value="RESEARCHER" required>

                                <div class="row g-6 mt-0">


                                    <div class="col-md-6">
                                        <label for="title_of_consultancy" class="form-label">Title Of Consultancy</label>
                                        <input type="text" id="title_of_consultancy" name="title_of_consultancy"
                                            class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="duration_of_consultancy" class="form-label">Duration Of Consultancy</label>
                                        <input type="text" id="duration_of_consultancy" name="duration_of_consultancy"
                                            class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name_of_client_organization" class="form-label">Name Of Client
                                            Organization</label>
                                        <input type="text" id="name_of_client_organization" name="name_of_client_organization"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="consultancy_fee" class="form-label">Consultancy Fee</label>
                                        <input type="number" id="consultancy_fee" name="consultancy_fee" class="form-control" required>
                                    </div>
                                    <div class="col-md-12">

                                        <label for="formFile" class="form-label">Attachments</label>
                                        <input class="form-control" type="file" name="consultancy_file" id="formFile" required>
                                    </div>
                                </div>
                                <div class="col-4 demo-vertical-spacing">
                                    <button class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if(auth()->user()->hasRole(['HOD']))
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
                                        <th>Title Consultancy</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endif
                    @if(auth()->user()->hasRole(['Dean']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            
                            <table id="complaintTable3" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Title Consultancy</th>
                                        <th>Duration</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="form2" role="tabpanel">
                        
                        </div>
                    @endif
                   @if(auth()->user()->hasRole(['ORIC']))
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
                                        <th>Title Consultancy</th>
                                        <th>Duration</th>
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

                $('#researchForm1').on('submit', function (e) {
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
                        url: "{{ route('counsultancy.store') }}",
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
                                    let input = form.find('[name="' + fieldName + '"], [name="' + field + '"]');

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
                    url: "{{ route('counsultancy.index') }}",
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
                                form.title_of_consultancy || 'N/A',
                                form.duration_of_consultancy || 'N/A',
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
                                    { title: "Title Consultancy" },
                                    { title: "Duration" },
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
                    url: `/counsultancy/${id}`,           // single row endpoint
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

                    
                    if (form.title_of_consultancy) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Title of consultancy</th><td>${form.title_of_consultancy}</td></tr>`);
                    }
                    if (form.duration_of_consultancy) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Duration of consultancy</th><td>${form.duration_of_consultancy}</td></tr>`);
                    }
                    if (form.name_of_client_organization) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name of client organization</th><td>${form.name_of_client_organization}</td></tr>`);
                    }
                    if (form.consultancy_fee) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Consultancy Fee</th><td>${form.consultancy_fee}</td></tr>`);
                    }
                     if (form.consultancy_file) {
                        let fileUrl = form.consultancy_file;
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
                                        if (update.status == '1') histortText = 'Unverified';
                                        else if (update.status == '2') histortText = 'Verified';
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
    @if(auth()->user()->hasRole(['Dean']))
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('counsultancy.index') }}",
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
                                form.title_of_consultancy || 'N/A',
                                form.duration_of_consultancy || 'N/A',
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
                                    { title: "Title Consultancy" },
                                    { title: "Duration" },
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
                    if (window.currentUserRole === 'Dean') {
                       $('#status-approval').hide();
                        $('label[for="approveCheckbox"]').hide();
                        $('#approveCheckbox').closest('.form-check-input').hide();
                    }  else {
                        
                    }

                    
                    if (form.title_of_consultancy) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Title of consultancy</th><td>${form.title_of_consultancy}</td></tr>`);
                    }
                    if (form.duration_of_consultancy) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Duration of consultancy</th><td>${form.duration_of_consultancy}</td></tr>`);
                    }
                    if (form.name_of_client_organization) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name of client organization</th><td>${form.name_of_client_organization}</td></tr>`);
                    }
                    if (form.consultancy_fee) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Consultancy Fee</th><td>${form.consultancy_fee}</td></tr>`);
                    }
                     if (form.consultancy_file) {
                        let fileUrl = form.consultancy_file;
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
                                        if (update.status == '1') histortText = 'Unverified';
                                        else if (update.status == '2') histortText = 'Verified';
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
    @if(auth()->user()->hasRole(['ORIC']))
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('counsultancy.index') }}",
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
                                form.title_of_consultancy || 'N/A',
                                form.duration_of_consultancy || 'N/A',
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
                                    { title: "Title Consultancy" },
                                    { title: "Duration" },
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
                    url: `/counsultancy/${id}`,           // single row endpoint
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
                    if (window.currentUserRole === 'ORIC') {
                        $('#approveCheckbox').prop('checked', form.status == 3);
                        $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                        // Label text for HOD
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

                    
                    if (form.title_of_consultancy) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Title of consultancy</th><td>${form.title_of_consultancy}</td></tr>`);
                    }
                    if (form.duration_of_consultancy) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Duration of consultancy</th><td>${form.duration_of_consultancy}</td></tr>`);
                    }
                    if (form.name_of_client_organization) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name of client organization</th><td>${form.name_of_client_organization}</td></tr>`);
                    }
                    if (form.consultancy_fee) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Consultancy Fee</th><td>${form.consultancy_fee}</td></tr>`);
                    }
                     if (form.consultancy_file) {
                        let fileUrl = form.consultancy_file;
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
                                        if (update.status == '1') histortText = 'Unverified';
                                        else if (update.status == '2') histortText = 'Verified';
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
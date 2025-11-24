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
                @if(auth()->user()->hasRole(['Dean', 'ORIC']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Intellectual Properties</a>
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
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Intellectual Properties</a>
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
                    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <h5 class="mb-1">Patents/Intellectual Property (IPR)</h5>
                            <h5 class="text-primary">Target 5</h5>
                            <form id="researchForm1" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden" id="form_status" name="form_status" value="RESEARCHER" required>

                                <div class="row g-6 mt-0">
                                    <div class="col-md-6">
                                        <label for="name_of_ip_filed" class="form-label">Title Of IP/Patents</label>
                                        <input type="text" id="name_of_ip_filed" name="name_of_ip_filed" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Type</label>
                                        <select id="patents_ip_type" name="patents_ip_type" class="form-select" required="">
                                            <option value="">-- Select --</option>
                                            <option value="copyright">Copyright</option>
                                            <option value="Trademark">Trademark</option>
                                            <option value="Design">Design</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6" id="other-type-field" style="display:none;">
                                        <label class="form-label">Please Specify Other Type</label>
                                        <input type="text" name="other_detail" id="other_detail" class="form-control"
                                            placeholder="Enter details">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_of_ip_disclosed" class="form-label">Filing / Registration #</label>
                                        <input type="text" id="no_of_ip_disclosed" name="no_of_ip_disclosed"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="area_of_application" class="form-label">Area Of Application</label>
                                        <input type="text" id="area_of_application" name="area_of_application"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="date_of_filing_registration" class="form-label">Date Of Filing
                                            Registration</label>
                                        <input type="date" id="date_of_filing_registration" name="date_of_filing_registration"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="supporting_docs_as_attachment" class="form-label">Supporting Docs As
                                            Attachment</label>
                                        <input type="file" id="supporting_docs_as_attachment"
                                            name="supporting_docs_as_attachment" class="form-control" required>
                                    </div>



                                </div>
                                <div class="col-4 text-center demo-vertical-spacing">
                                    <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade" id="form2" role="tabpanel">
                            <form id="researchForm2" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                                <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                                <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden" id="form_status" name="form_status" value="HOD" required>

                                <div class="row g-6">
                                    <div class="col-md-6">
                                        <label for="target_of_ip_disclosures" class="form-label">Target of ip
                                            disclosures</label>
                                        <input type="text" id="target_of_ip_disclosures" name="target_of_ip_disclosures"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="target_of_ip_filed" class="form-label">Target of ip filled</label>
                                        <input type="text" id="target_of_ip_filed" name="target_of_ip_filed"
                                            class="form-control">
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
                                        <th>No IP Disclosed</th>
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
                                        <th>No IP Disclosed</th>
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
                                        <th>Target IP Disclosed</th>
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
                                        <th>Target IP Disclosed</th>
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
                $('#patents_ip_type').on('change', function () {
                    var selectedValue = $(this).val();
                    if (selectedValue === 'Other') {
                        $('#other-type-field').show();
                        $('#other_detail').attr('required', true);
                    } else {
                        $('#other-type-field').hide();
                        $('#other_detail').removeAttr('required').val('');
                    }
                });

                // Extra fields for Form 1

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
                        url: "{{ route('intellectual-properties.store') }}",
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
                    url: "{{ route('intellectual-properties.index') }}",
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
                                form.no_of_ip_disclosed || 'N/A',
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
                                    { title: "No IP Disclosed" },
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
                // Extra fields for Form 2
                $('#researchForm2').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('intellectual-properties.store') }}",
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
                    if (form.no_of_ip_disclosed) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>No of ip disclosed</th><td>${form.no_of_ip_disclosed}</td></tr>`);
                    }

                    if (form.no_of_ip_filed) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>No of ip filed</th><td>${form.no_of_ip_filed}</td></tr>`);
                    }
                    if (form.name_of_ip_filed) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Name of ip filed</th><td>${form.name_of_ip_filed}</td></tr>`);
                    }
                    if (form.target_of_ip_disclosures) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target of ip disclosures</th><td>${form.target_of_ip_disclosures}</td></tr>`);
                    }
                    if (form.target_of_ip_filed) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target of ip filed</th><td>${form.target_of_ip_filed}</td></tr>`);
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
                        url: `/intellectual-properties/${id}`,
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
                    url: "{{ route('intellectual-properties.index') }}",
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
                                form.target_of_ip_disclosures || 'N/A',
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
                                    { title: "Target IP Disclosed" },
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
                    url: "{{ route('intellectual-properties.index') }}",
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
                                form.no_of_ip_disclosed || 'N/A',
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
                                    { title: "No IP Disclosed" },
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
                            } else if (form.status == 4) {
                                statusLabel = "Verify";
                            }
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
                    if (form.form_status == 'HOD') {
                        if (form.target_of_ip_disclosures) {
                            $('#modalExtraFields').append(`<tr class="optional-field"><th>Target of ip disclosures</th><td>${form.target_of_ip_disclosures}</td></tr>`);
                        }
                        if (form.target_of_ip_filed) {
                            $('#modalExtraFields').append(`<tr class="optional-field"><th>Target of ip filed</th><td>${form.target_of_ip_filed}</td></tr>`);
                        }
                    }

                    if (form.form_status == 'RESEARCHER') {
                        if (form.no_of_ip_disclosed) {
                            $('#modalExtraFields').append(`<tr class="optional-field"><th>No of ip disclosed</th><td>${form.no_of_ip_disclosed}</td></tr>`);
                        }

                        if (form.no_of_ip_filed) {
                            $('#modalExtraFields').append(`<tr class="optional-field"><th>No of ip filed</th><td>${form.no_of_ip_filed}</td></tr>`);
                        }
                        if (form.name_of_ip_filed) {
                            $('#modalExtraFields').append(`<tr class="optional-field"><th>Name of ip filed</th><td>${form.name_of_ip_filed}</td></tr>`);
                        }
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
                        url: `/intellectual-properties/${id}`,
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
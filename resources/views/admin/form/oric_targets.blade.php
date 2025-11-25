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
         <div class="card mb-6">
             <div class="d-flex m-6">
                                <select id="bulkAction" class="form-select w-auto me-2">
                                    <option value="">-- Select Action --</option>
                                    <option value="3">Verified</option>
                                    <option value="2">UnVerified</option>
                                </select>
                                <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                            </div>
            <div class="table-responsive text-nowrap">
               <table id="complaintTable3" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Indicator</th>
                                        <th>Target</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
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
                                <th>Status</th>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="approveCheckbox">
                                        <label class="form-check-label" for="approveCheckbox">Approved</label>
                                    </div>
                                </td>
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
    @if(auth()->user()->hasRole(['ORIC']))
    <script>
    function fetchTarget() {
                $.ajax({
                    url: "{{ route('faculty-target.index') }}",
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
                            // Map status number to text
                            let statusText = 'N/A';
                            if (form.status == 2) {
                                statusText = 'Unverified';
                            } else if (form.status == 3) {
                                statusText = 'Verified';
                            }    

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.user ? form.user.name : 'N/A',
                                form.indicator ? form.indicator.indicator : 'N/A',
                                form.target || 'N/A',
                                `<span class="badge bg-label-primary me-1">${statusText}</span>`,
                                 `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "User" },
                                    { title: "Indicator" },
                                    { title: "Target" },
                                    { title: "Status" },
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
                    url: `/faculty-target/${id}`,           // single row endpoint
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
                        
                        fetchTarget();
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
        fetchTarget();
         $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalStatus').text(form.status || 'Pending');
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
                    if (form.assign) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Created By</th><td>${form.assign.name}</td></tr>`);
                    }
                    if (form.target) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Target</th><td>${form.target}</td></tr>`);
                    }

                    if (form.user) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>User</th><td>${form.user.name}</td></tr>`);
                    }
                    if (form.indicator) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Indicator</th><td>${form.indicator.indicator}</td></tr>`);
                    }
                    if (form.created_at) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Created Date</th><td>${form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A'}</td></tr>`);
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
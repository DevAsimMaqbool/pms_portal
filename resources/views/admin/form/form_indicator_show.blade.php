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
        <!-- Permission Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                @php
                    $role = auth()->user()->getRoleNames()->first(); // assuming you're using Spatie roles
                @endphp
                @if($role === 'Teacher')
                    {{-- Do not show bulkAction for Teachers --}}
                @elseif($role === 'HOD')
                    <div class="d-flex m-5">
                        <select id="bulkAction" class="form-select w-auto me-2">
                            <option value="">-- Select Action --</option>
                            <option value="2">Verified</option>
                            <option value="1">UnVerified</option>
                        </select>
                        <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                    </div>
                @elseif($role === 'ORIC')
                    <div class="d-flex m-5">
                        <select id="bulkAction" class="form-select w-auto me-2">
                            <option value="">-- Select Action --</option>
                            <option value="3">Approve</option>
                            <option value="2">Unapprove</option>
                        </select>
                        <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                    </div>
                @endif
                <table id="complaintTable" class="table table-bordered table-striped" style="width:100%">
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
        </div>
        <!--/ Permission Table -->

        <!-- Modal -->
        <!-- Add Permission Modal -->
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
                    <tr><th>Created By</th><td id="modalCreatedBy"></td></tr>
                    <tr><th>Target Category</th><td id="modalTargetCategory"></td></tr>
                    <tr><th>Target Of Publications</th><td id="modalTargetOfpublications"></td></tr>
                    <tr><th>Status</th><td>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="approveCheckbox">
                        <label class="form-check-label" for="approveCheckbox">Approved</label>
                    </div></td></tr>
                    <tr><th>Created Date</th><td id="modalCreatedDate"></td></tr>
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


        <!-- /Modal -->
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
@endpush
@push('script')
<script>
    window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
</script>
<script>
function fetchIndicatorForms() {
    $.ajax({
        url: "{{ route('indicatorForm.show') }}",
        method: "GET",
        dataType: "json",
        success: function (data) {
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

            if (!$.fn.DataTable.isDataTable('#complaintTable')) {
                $('#complaintTable').DataTable({
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
                $('#complaintTable').DataTable().clear().rows.add(rowData).draw();
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('Unable to load data.');
        }
    });
}

$(document).ready(function () {
    fetchIndicatorForms();

    $(document).on('change', '#selectAll', function () {
        $('.rowCheckbox').prop('checked', $(this).prop('checked'));
    });

   // Submit Bulk Action
    $('#bulkSubmit').on('click', function () {
        let action = $('#bulkAction').val();
        let selectedIds = $('.rowCheckbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (!action) {
            alert('Please select an action.');
            return;
        }
        if (selectedIds.length === 0) {
            alert('Please select at least one record.');
            return;
        }

        $.ajax({
            url: "{{ route('indicatorForm.bulkUpdateStatus') }}",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ids: selectedIds,
                status: action
            },
            success: function (response) {
                if (response.success) {
                    alert('Status updated successfully!');
                    $('#selectAll').prop('checked', false);
                    $('#bulkAction').val('');
                    fetchIndicatorForms();
                } else {
                    alert('Failed to update status.');
                }
            },
            error: function () {
                alert('Error updating status.');
            }
        });
    });




    // Handle click on View button
    $(document).on('click', '.view-form-btn', function() {
        const form = $(this).data('form');
        $('#modalExtraFields').find('.optional-field').remove();

        $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
        $('#modalTargetCategory').text(form.target_category || 'N/A');
        $('#modalTargetOfpublications').text(form.target_of_publications || 'N/A');
        $('#modalStatus').text(form.status || 'Pending');
        $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');

        if (window.currentUserRole === 'HOD') {
        $('#approveCheckbox').prop('checked', form.status == 2);
        $('#approveCheckbox').data('id', form.id);
         // Label text for HOD
            let statusLabel = "Pending"; 
            if (form.status == 1) {
                statusLabel = "Verified";
            } else if (form.status == 2) {
                statusLabel = "Verified";
            }
            $('label[for="approveCheckbox"]').text(statusLabel);
        }else if(window.currentUserRole === 'ORIC'){
            
            $('#approveCheckbox').prop('checked', form.status == 3);
            $('#approveCheckbox').data('id', form.id);
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
        $('#viewFormModal').modal('show');
    });
    $(document).on('change', '#approveCheckbox', function () {
    let id = $(this).data('id');
    let status;
     if (window.currentUserRole === "ORIC") {
        status = $(this).is(':checked') ? 3 : 2;
    } if (window.currentUserRole === "HOD"){
        status = $(this).is(':checked') ? 2 : 1;
    }

    $.ajax({
        url: `/achievement-of-research-publications-target/${id}/update-status`,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            status: status
        },
        success: function (response) {
            if (response.success) {
                alert('Status updated successfully!');
                fetchIndicatorForms();
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

@endpush
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
                @if(auth()->user()->hasRole(['Teacher']))
                <form id="researchForm" enctype="multipart/form-data"class="row">
                    @csrf
                    <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                    <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                    <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                    <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER" required>
                    
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="conference_target" class="form-label">Conference Target</label>
                            <input type="text" id="conference_target" name="conference_target" class="form-control" >
                        </div>
                       
                        <div class="col-md-6">
                            <label for="event_proposal_form_submission" class="form-label">Event proposal form submission</label>
                            <input type="text" id="event_proposal_form_submission" name="event_proposal_form_submission" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="scopus_indexed_confirmation" class="form-label">Scopus indexed confirmation attach proof</label>
                            <input type="file" id="scopus_indexed_confirmation" name="scopus_indexed_confirmation" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required >
                        </div>
                       
                    </div>
                    <div class="col-4 text-center demo-vertical-spacing">
                        <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                    </div>
                </form>
                @endif
                  @if(auth()->user()->hasRole(['Dean']))
                    <div>
                        <table id="complaintTable2" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>#</th>
                                    <th>Created By</th>
                                    <th>Co Authers</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @endif
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
                    <tr><th>Created By</th><td id="modalCreatedBy"></td></tr>
                    <tr><th>Conference Target</th><td id="modalconferenceTarget"></td></tr>
                    <tr><th>Event Proposal Form Submission</th><td id="modalEventProposal"></td></tr>
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
    @if(auth()->user()->hasRole(['Teacher']))
    <script>
    $(document).ready(function () {


        $('#researchForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('rating-onimpact-of-research.store') }}",
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
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                }
            });
        });
    });
    </script>
    @endif
    @if(auth()->user()->hasRole(['Dean']))
    <script>
function fetchIndicatorForms() {
    $.ajax({
        url: "{{ route('rating-onimpact-of-research.index') }}",
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
                    form.conference_target || 'N/A',
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
                        { title: "Conference Target" },
                        { title: "Created Date" },
                        { title: "Actions" }
                    ]
                });
            } else {
                $('#complaintTable2').DataTable().clear().rows.add(rowData).draw();
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
       // Handle click on View button
    $(document).on('click', '.view-form-btn', function() {
        const form = $(this).data('form');
        $('#modalExtraFields').find('.optional-field').remove();

        $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
        $('#modalconferenceTarget').text(form.conference_target || 'N/A');
        $('#modalEventProposal').text(form.event_proposal_form_submission || 'N/A');
        $('#modalStatus').text(form.status || 'Pending');
        $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
        
        if (window.currentUserRole === 'Dean') {
            let statusLabel = "Review"; 
             if(form.form_status=='RESEARCHER'){
                $('#approveCheckbox').closest('.form-check-input').show();
                $('#approveCheckbox').prop('checked', form.status == 2);
                $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                // Label text for HOD
                    if (form.status == 1) {
                        statusLabel = "Verify";
                    } else if (form.status == 2) {
                        statusLabel = "Verify";
                    }
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
      
        if (form.scopus_indexed_confirmation_url) {
                    $('#modalExtraFields').append(`
                        <tr class="optional-field">
                            <th>Attachment</th>
                            <td>
                                <a href="${form.scopus_indexed_confirmation_url}" target="_blank">
                                    <img src="${form.scopus_indexed_confirmation_url}" alt="Screenshot" style="max-width:200px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                </a>
                            </td>
                        </tr>
                    `);
                }
        $('#viewFormModal').modal('show');
    });

     $(document).on('change', '#approveCheckbox', function () {
                let id = $(this).data('id');
                let table_status = $(this).data('table_status');
                let status;
                if (window.currentUserRole === "Dean"){
                    if(table_status=="RESEARCHER"){
                       status = $(this).is(':checked') ? 2 : 1;
                    }
                }

                $.ajax({
                    url: `/rating-onimpact-of-research/${id}`,
                    type: 'POST',
                    data: {
                        _method: 'PUT',
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
    @endif
@endpush

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
             <h5 class="card-header">Intellectual Property</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="intellectualTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Created By</th>
                                                        <th>Filing / Registration</th>
                                                        <th>Created Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                            </div>    
                        </div>
                    @endif
                   
            </div>
        </div>
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
        <!-- Update Intellectual Property Modal -->
<div class="modal fade" id="researchFormModal" tabindex="-1" aria-labelledby="researchFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="researchFormModalLabel">Edit Intellectual Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name_of_ip_filed" class="form-label">Title Of IP/Patents</label>
                            <input type="text" id="name_of_ip_filed" name="name_of_ip_filed" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select id="patents_ip_type" name="patents_ip_type" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="copyright">Copyright</option>
                                <option value="Trademark">Trademark</option>
                                <option value="Design">Design</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="other-type-field" style="display:none;">
                            <label class="form-label">Please Specify Other Type</label>
                            <input type="text" name="other_detail" id="other_detail" class="form-control" placeholder="Enter details">
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_ip_disclosed" class="form-label">Filing / Registration #</label>
                            <input type="text" id="no_of_ip_disclosed" name="no_of_ip_disclosed" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="area_of_application" class="form-label">Area Of Application</label>
                            <input type="text" id="area_of_application" name="area_of_application" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="date_of_filing_registration" class="form-label">Date Of Filing Registration</label>
                            <input type="date" id="date_of_filing_registration" name="date_of_filing_registration" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="supporting_docs_as_attachment" class="form-label">Supporting Docs As Attachment</label>
                            <input type="file" id="supporting_docs_as_attachment" name="supporting_docs_as_attachment" class="form-control">
                            <div id="intellectual-img"></div>
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
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
@endpush
@push('script')
    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
        <script>
            function fetchIntelletualForms() {
                $.ajax({
                    url: "{{ route('intellectual-properties.index') }}",
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
                                form.creator ? form.creator.name : 'N/A',
                                form.no_of_ip_disclosed || 'N/A',
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

                        if (!$.fn.DataTable.isDataTable('#intellectualTable')) {
                            $('#intellectualTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Filing / Registration" },
                                    { title: "Created Date" },
                                    { title: "History" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#intellectualTable').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
                
    
            $(document).ready(function () {
                fetchIntelletualForms();
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
    // Open modal and populate data
    $(document).on('click', '.edit-form-btn', function () {
        const form = $(this).data('form');

        $('#researchForm1 #record_id').val(form.id);
        $('#researchForm1 #name_of_ip_filed').val(form.name_of_ip_filed);
        $('#researchForm1 #patents_ip_type').val(form.patents_ip_type).trigger('change');
        $('#researchForm1 #other_detail').val(form.other_detail);
        $('#researchForm1 #no_of_ip_disclosed').val(form.no_of_ip_disclosed);
        $('#researchForm1 #area_of_application').val(form.area_of_application);
        $('#researchForm1 #date_of_filing_registration').val(form.date_of_filing_registration);
        if (form.supporting_docs_as_attachment) {
                        let fileUrl = form.supporting_docs_as_attachment;
                        let fileExt = fileUrl.split('.').pop().toLowerCase();

                        let filePreview = '';

                        // ✅ If Image → show preview
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                            filePreview = `<div class="avatar avatar-xl me-3 mt-2 bg-secondary">
                                <a href="${fileUrl}" target="_blank">
                                    <img src="${fileUrl}" alt="Screenshot" class="rounded-circle">
                                </a></div>
                            `;
                        }
                        // ✅ If PDF → show download button
                        else if (fileExt === 'pdf') {
                            filePreview = `
                                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary mt-3">
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

                        $("#intellectual-img").html(filePreview);
                    }

        $('#researchFormModal').modal('show');
    });

    // Show/hide other type field
    $('#patents_ip_type').on('change', function () {
        if ($(this).val() === 'Other') {
            $('#other-type-field').show();
            $('#other_detail').attr('required', true);
        } else {
            $('#other-type-field').hide();
            $('#other_detail').removeAttr('required').val('');
        }
    });

    // Submit updated data
    $('#researchForm1').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        const recordId = $('#record_id').val();
        formData.append('status_update_data', true);

        formData.append('_method', 'PUT'); // Laravel PUT

        Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '/intellectual-properties/' + recordId,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.close();
                Swal.fire('Success', response.message, 'success');
                $('#researchFormModal').modal('hide');
                $('#researchForm1')[0].reset();
                fetchIntelletualForms(); // reload table
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

});

        </script>
    @endif
@endpush
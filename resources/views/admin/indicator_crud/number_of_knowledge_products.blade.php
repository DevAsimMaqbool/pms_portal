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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
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
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Number of Knowledge Products</h5>
                </div>
                <div class="">
                    <a href="{{ url('kpa/2/category/5/indicator/194') }}" class="btn btn-success">Add</a>
                </div>
            </div>
            <div class="card-datatable table-responsive card-body">
                @if(in_array(getRoleName(activeRole()), ['HOD', 'Teacher']))
                    <div class="tab-pane fade show" id="form2" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table id="achievementTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Product URL</th>
                                        <th>Product Evidence</th>
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
        <!-- Update Form Modal -->
        <div class="modal fade" id="updateFormModal" tabindex="-1" aria-labelledby="updateFormModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="updateFormModalLabel">Edit Number of Knowledge Products</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="researchForm1" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="record_id" name="record_id">

                            <div class="row g-6 mt-0">
                                <div class="col-md-4">
                                    <label class="form-label" for="product-dropdown">Type of Knowledge Product</label>
                                    <select name="product_type" id="product-dropdown" class="form-select" required>
                                        <option value="">Select Product</option>
                                        <option value="Policy Advocacy">Policy Advocacy</option>
                                        <option value="Policy Briefs">Policy Briefs</option>
                                        <option value="Popular Articles">Popular Articles</option>
                                        <option value="White Papers">White Papers</option>
                                        <option value="Case Studies">Case Studies</option>
                                    </select>
                                    @error('product_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="url" class="form-label">Link/URL</label>
                                    <input type="text" name="url" id="url" class="form-control" placeholder="Enter URL"
                                        required>
                                </div>

                                <div class="col-md-4">
                                    <label for="attach_evidence" class="form-label">Attach Evidence</label>
                                    <input type="file" name="attach_evidence" id="attach_evidence" class="form-control">
                                </div>
                            </div>

                            <div class="mt-3 text-end">
                               <button type="submit" class="btn btn-primary">Update</button>
                               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
@endpush

@push('script')
    @if(in_array(getRoleName(activeRole()), ['HOD', 'Teacher']))
        <script>
            function fetchAchievementForms() {
                $.ajax({
                    url: "{{ route('number-of-knowledge-products.index') }}",
                    method: "GET",
                    data: { status: "Teacher" },
                    dataType: "json",
                    success: function (data) {
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            // Make URL clickable
                            const urlLink = form.url
                                ? `<a href="${form.url}" target="_blank" class="text-primary">${form.url}</a>`
                                : 'N/A';

                            // Make attached evidence viewable/downloadable
                            const evidenceLink = form.attach_evidence
                                ? `<a href="/storage/${form.attach_evidence}" target="_blank" class="text-success">View/Download</a>`
                                : 'N/A';

                            let editButton = '';
                            if (parseInt(form.status) === 1) {
                                editButton = `<button class="btn rounded-pill btn-outline-primary waves-effect edit-form-btn" data-form='${JSON.stringify(form)}'>Edit</button>`;
                            }
                            const deleteBtn = `<button class="btn rounded-pill btn-outline-danger delete-btn" data-id="${form.id}">Delete</button>`;

                            return [
                                i + 1,
                                form.product_type || 'N/A',
                                urlLink,
                                evidenceLink,
                                 `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn"
                                    data-history='${JSON.stringify(form.update_history)}'
                                    data-user='${form.creator ? form.creator.name : "N/A"}'
                                    data-created='${form.created_at}'>
                                    <span class="icon-xs icon-base ti tabler-history me-2"></span>History
                                </button>`,
                                editButton + ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#achievementTable')) {
                            $('#achievementTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Product Type" },
                                    { title: "Link" },
                                    { title: "Evidence" },
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
                fetchAchievementForms();
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
                        if (update.role === 'ORIC') histortText = update.status == '1' ? 'unapproved' : (update.status == '2' ? 'Approved' : update.status);
                        else if (update.role === 'HOD') histortText = update.status == '2' ? 'Unverified' : (update.status == '3' ? 'Verified' : update.status);
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

                $(document).on('click', '.edit-form-btn', function () {
                    let form = $(this).data('form');
                    let $f = $('#researchForm1');

                    // Reset form
                    $f[0].reset();
                    $('#existingEvidence').html('');

                    // Fill hidden ID
                    $f.find('[name="record_id"]').val(form.id);

                    // Fill text fields
                    $f.find('[name="product_type"]').val(form.product_type);
                    $f.find('[name="url"]').val(form.url);

                    // Show existing evidence file if exists
                    if (form.attach_evidence) {
                        $('#existingEvidence').html(
                            `<a href="/storage/${form.attach_evidence}" target="_blank">View Current File</a>`
                        );
                    }

                    // Show modal
                    $('#updateFormModal').modal('show');
                });

                  // Submit updated data
    $('#researchForm1').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);
        const recordId = $('#record_id').val();
        formData.append('_method', 'PUT');
        formData.append('status_update_data', true);
        Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });


        $.ajax({
            url: "{{ route('number-of-knowledge-products.update', '') }}/" + recordId,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                Swal.close();
                Swal.fire('Success', response.message, 'success');
                $('#updateFormModal').modal('hide');
                $('#researchForm1')[0].reset();
                form.find('.invalid-feedback').remove();
                form.find('.is-invalid').removeClass('is-invalid');
                fetchAchievementForms(); // reload table
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

                // Delete
                $(document).on('click', '.delete-btn', function () {
                    let id = $(this).data('id');
                    if (!confirm('Are you sure you want to delete this record?')) return;

                    $.ajax({
                        url: `/number-of-knowledge-products/${id}`,
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        success: function (res) {
                            alert(res.message);
                            fetchAchievementForms();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alert('Failed to delete record.');
                        }
                    });
                });
            });
        </script>
    @endif
@endpush
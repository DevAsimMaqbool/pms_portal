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
                    <h5 class="mb-1">Satisfaction of International Students</h5>
                </div>
                <div class="">
                    <a href="{{ url('kpa/1/category/1/indicator/176') }}" class="btn btn-success">Add</a>
                </div>
            </div>
            <div class="card-datatable table-responsive card-body">
               @if(in_array(getRoleName(activeRole()), ['International Office']))
                    <div class="tab-pane fade show" id="form2" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table id="achievementTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Roll No</th>
                                        <th>Faculty / Program</th>
                                        <th>Country</th>
                                        <th>Semester / Year</th>
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
                        <h5 class="modal-title" id="updateFormModalLabel">Edit Satisfaction of International Students</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="researchForm1" enctype="multipart/form-data">
                            @csrf
                             <input type="hidden" id="record_id" name="record_id">
                              <input type="hidden" name="_method" value="PUT">

                            <div class="row g-6 mt-0">

                                <div id="student-satisfaction-container">
                                    <div class="student-group row g-3 mb-3 border p-3 mt-3 rounded">
                                        <div class="col-md-4">
                                            <label class="form-label">Student Name</label>
                                            <input type="text" name="student_name" class="form-control"
                                                placeholder="Enter Name">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Student Roll No.</label>
                                            <input type="text" name="student_roll_no" class="form-control"
                                                placeholder="Enter Roll No">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Program / Faculty</label>
                                            <input type="text" name="student_program" class="form-control"
                                                placeholder="Program Name">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Country of Origin</label>
                                            <input type="text" name="student_country" class="form-control"
                                                placeholder="Country">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Semester / Year</label>
                                            <input type="text" name="student_semester" class="form-control"
                                                placeholder="e.g., Fall 2025">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="fw-bold mb-2 d-block">Rating</label>
                                            <div id="ratingBox" class="half-star-ratings raty" data-half="true"
                                                data-score="" data-number="5">
                                            </div>

                                            <input type="hidden" name="rating" id="rating" value="">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Comments / Suggestions</label>
                                            <textarea name="student_comments" class="form-control" rows="2"
                                                placeholder="Optional"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    @if(in_array(getRoleName(activeRole()), ['International Office']))
        <script>
            function fetchAchievementForms() {
                $.ajax({
                    url: "{{ route('international-st-satisfaction.index') }}",
                    method: "GET",
                    data: { status: "HOD" },
                    dataType: "json",
                    success: function (data) {
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            let editButton = '';
                            if (parseInt(form.status) === 1) {
                                editButton = `<button class="btn rounded-pill btn-outline-primary waves-effect edit-form-btn" data-form='${JSON.stringify(form)}'>Edit</button>`;
                            }
                            const deleteBtn = `<button class="btn rounded-pill btn-outline-danger delete-btn" data-id="${form.id}">Delete</button>`;

                            return [
                                i + 1,
                                form.student_name || 'N/A',
                                form.student_roll_no,
                                form.student_program,
                                form.student_country,
                                form.student_semester,
                                editButton + ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#achievementTable')) {
                            $('#achievementTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Student Name" },
                                    { title: "Roll No" },
                                    { title: "Program / Faculty" },
                                    { title: "Country" },
                                    { title: "Semester" },
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
                        if (update.role === 'QEC') histortText = update.status == '1' ? 'unapproved' : (update.status == '2' ? 'Approved' : update.status);
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
                    $f.find('[name="student_name"]').val(form.student_name);
                    $f.find('[name="student_roll_no"]').val(form.student_roll_no);
                    $f.find('[name="student_program"]').val(form.student_program);
                    $f.find('[name="student_country"]').val(form.student_country);
                    $f.find('[name="student_semester"]').val(form.student_semester);
                    $f.find('[name="rating"]').val(form.student_rating);
                    $f.find('#ratingBox').attr('data-score', form.student_rating);
                    $f.find('[name="student_comments"]').val(form.student_comments);

                    // Show modal
                    $('#updateFormModal').modal('show');
                });

                $('#researchForm1').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);
        const recordId = $('#record_id').val();
        formData.append('status_update_data', true);
        Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });


        $.ajax({
            url: "{{ route('international-st-satisfaction.update', '') }}/" + recordId,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                Swal.close();
                Swal.fire('Success', response.message, 'success');
                $('#employabilityFormModal').modal('hide');
                $('#researchForm1')[0].reset();
                form.find('.invalid-feedback').remove();
                form.find('.is-invalid').removeClass('is-invalid');
                fetchCommercialForms(); // reload table
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
                        url: `/international-st-satisfaction/${id}`,
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
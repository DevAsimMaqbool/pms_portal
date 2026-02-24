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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
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
    @if(in_array(getRoleName(activeRole()), ['Finance']))
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Dropout Rate</h5>
                </div>
                <div class="">
                    <a href="{{ url('kpa/6/category/14/indicator/160') }}" class="btn btn-success">Add</a>
                </div>
            </div>
            <div class="card-datatable table-responsive card-body">
                @if(in_array(getRoleName(activeRole()), ['Finance']))
                    <div class="tab-pane fade show" id="form2" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table id="achievementTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Faculty</th>
                                        <th>Department</th>
                                        <th>Program</th>
                                        <th>Dropout Rate</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
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

                            <div class="row g-6 mt-0">

                                <div id="student-satisfaction-container">
                                    <div class="student-group row g-3 mb-3 border p-3 mt-3 rounded">
                                        <div class="col-md-4">
                                            <label for="faculty" class="form-label">Faculty</label>
                                            <select name="faculty_id" id="faculty_id" class="select2 form-select" required>
                                                <option value="">-- Select Faculty --</option>
                                                @foreach(get_faculties() as $faculty)
                                                    <option value="{{ $faculty->id }}">
                                                        {{ $faculty->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="department" class="form-label">Department</label>
                                            <select name="department_id" id="department_id" class="select2 form-select"
                                                required>
                                                <option value="">-- Select Department --</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="program" class="form-label">Program Name</label>
                                            <select name="program_id" id="program_id" class="select2 form-select program_id"
                                                required>
                                                <option value="">-- Select Program --</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label" for="dropout_rate">Dropout Rate (%)</label>
                                            <div class="input-group">
                                                        <span class="input-group-text" id="basic-addon11">%</span>
                                            <input type="number" class="form-control" id="dropout_rate" name="dropout_rate"
                                                required placeholder="Dropout Rate">
                                             </div>   
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
    @if(in_array(getRoleName(activeRole()), ['Finance']))
        <script>
            function fetchAchievementForms() {
                $.ajax({
                    url: "{{ route('dropout-rate.index') }}",
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
                                form.faculty.name || 'N/A',
                                form.department.name,
                                form.program.program_name,
                                form.dropout_rate + ' %',
                                editButton + ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#achievementTable')) {
                            $('#achievementTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Faculty" },
                                    { title: "Department" },
                                    { title: "Program" },
                                    { title: "Dropout Rate" },
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

                $(document).on('click', '.edit-form-btn', function () {
                    let form = $(this).data('form');
                    let $f = $('#researchForm1');

                    // Reset form
                    $f[0].reset();

                    // Fill hidden ID
                    $f.find('[name="record_id"]').val(form.id);

                    // Set Faculty first
                    $f.find('[name="faculty_id"]').val(form.faculty.id).trigger('change');

                    // Load Departments for this faculty, then set Department
                    $.ajax({
                        url: "/get-departments/" + form.faculty.id,
                        type: "GET",
                        success: function (departments) {
                            let departmentSelect = $f.find('[name="department_id"]');
                            departmentSelect.empty().append('<option value="">-- Select Department --</option>');
                            $.each(departments, function (_, d) {
                                departmentSelect.append(`<option value="${d.id}">${d.name}</option>`);
                            });

                            departmentSelect.val(form.department.id).trigger('change');

                            // Load Programs for this department, then set Program
                            $.ajax({
                                url: "/get-programs/" + form.department.id,
                                type: "GET",
                                success: function (programs) {
                                    let programSelect = $f.find('[name="program_id"]');
                                    programSelect.empty().append('<option value="">-- Select Program --</option>');
                                    $.each(programs, function (_, p) {
                                        programSelect.append(`<option value="${p.id}">${p.program_name}</option>`);
                                    });

                                    programSelect.val(form.program.id).trigger('change');
                                }
                            });
                        }
                    });

                    // Set Dropout Rate
                    $f.find('[name="dropout_rate"]').val(form.dropout_rate);

                    // Show modal
                    $('#updateFormModal').modal('show');
                });


                $('#researchForm1').on('submit', function (e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    const recordId = $('#record_id').val();
                    formData.append('_method', 'PUT');

                    Swal.fire({ title: 'Updating...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                    $.ajax({
                        url: '/dropout-rate/' + recordId,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire('Success', response.message, 'success');
                            $('#updateFormModal').modal('hide');
                            fetchAchievementForms();
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
                        url: `/dropout-rate/${id}`,
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
            $('#faculty_id').on('change', function () {

                let facultyId = $(this).val();
                let departmentSelect = $('#department_id');
                let programSelect = $('#program_id');

                departmentSelect.html('<option value="">Loading...</option>');
                programSelect.html('<option value="">-- Select Program --</option>');


                if (facultyId) {
                    $.ajax({
                        url: "/get-departments/" + facultyId,
                        type: "GET",
                        success: function (response) {

                            departmentSelect.empty();
                            departmentSelect.append('<option value="">-- Select Department --</option>');

                            $.each(response, function (key, department) {
                                departmentSelect.append(
                                    `<option value="${department.id}">
                                                                                                                                                                                                                                                                                                                                                            ${department.name}
                                                                                                                                                                                                                                                                                                                                                        </option>`
                                );
                            });

                            departmentSelect.trigger('change'); // refresh select2
                        }
                    });
                } else {
                    departmentSelect.html('<option value="">-- Select Department --</option>');
                }
            });
            $('#department_id').on('change', function () {

                let departmentId = $(this).val();
                let programSelect = $('#program_id');

                programSelect.html('<option value="">Loading...</option>');

                if (departmentId) {
                    $.ajax({
                        url: "/get-programs/" + departmentId,
                        type: "GET",
                        success: function (response) {

                            programSelect.empty();
                            programSelect.append('<option value="">-- Select Program --</option>');

                            $.each(response, function (key, program) {
                                programSelect.append(
                                    `<option value="${program.id}">
                                                                                                                                                                                                                                                                                                                                                            ${program.program_name}
                                                                                                                                                                                                                                                                                                                                                        </option>`
                                );
                            });

                            programSelect.trigger('change'); // refresh select2
                        },
                        error: function () {
                            programSelect.html('<option value="">Error loading programs</option>');
                        }
                    });
                } else {
                    programSelect.html('<option value="">-- Select Program --</option>');
                }
            });
        </script>
    @endif
@endpush
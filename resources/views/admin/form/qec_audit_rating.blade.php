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

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                @if(in_array(getRoleName(activeRole()), ['QEC']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">QEC Audit Rating</a>
                        </li>
                        <!-- <li class="nav-item">
                                                                            <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Table</a>
                                                                        </li> -->
                    </ul>
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
                <div class="tab-content">
                    @if(in_array(getRoleName(activeRole()), ['QEC']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">QEC Audit Rating</h5>
                                </div>
                                <a href="{{ route('qec-audit-rating.index') }}"
                                    class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div>
                            <form id="researchForm1" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden" id="form_status" name="form_status" value="HOD">

                                <div class="row">
                                    <div id="author-past-container">
                                        <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

                                            <div class="col-md-4">
                                                <label class="form-label">Audit Term</label>
                                                <select name="audits[0][audit_term]" class="form-select">
                                                    <option value="">Select Audit Term</option>
                                                    <?php
                                                        $currentYear = date('Y');

                                                        // Show range from past 2 to next 3 academic years
                                                        for ($year = $currentYear - 2; $year <= $currentYear + 3; $year++) {
                                                            $nextYear = $year + 1;
                                                            $range = $year . '-' . $nextYear;
                                                            echo "<option value='{$range}'>{$range}</option>";
                                                        }
                                                        ?>
                                                </select>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label">Faculty</label>
                                                <select name="audits[0][faculty_id]" class="select2 form-select faculty-select">
                                                    <option value="">Select Faculty</option>
                                                    @foreach(get_faculties() as $faculty)
                                                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Department</label>
                                                <select name="audits[0][department_id]"
                                                    class="select2 form-select department-select">
                                                    <option value="">Select Department</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Program Name</label>
                                                <select name="audits[0][program_id]" class="select2 form-select program-select">
                                                    <option value="">Select Program</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Program Level</label>
                                                <select name="audits[0][program_level]" class="form-select">
                                                    <option value="">Select Level</option>
                                                    <option value="UG">UG</option>
                                                    <option value="PG">PG</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Total QEC Audit Rating Score</label>
                                                <input type="number" name="audits[0][total_score]" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Score Obtained</label>
                                                <input type="number" name="audits[0][obtained_score]" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Strenght</label>
                                                <input type="text" name="audits[0][strenght]" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Area of Improvement</label>
                                                <input type="text" name="audits[0][area_of_improvement]" class="form-control">
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            id="add-coauthor"><i class="icon-base ti tabler-plus me-1"></i> <span
                                                class="align-middle">Add</span></button>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Remarks*</label>
                                        <textarea name="remarks" class="form-control" style="height:120px; resize:none;"
                                            required placeholder=""></textarea>
                                    </div>
                                </div>
                                <div class="mt-3 text-end" style="margin-left: -19px !important;">
                                    <button class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if(auth()->user()->hasRole(['Dean', 'HOD', 'ORIC']))
                        <div class="tab-pane fade show {{ auth()->user()->hasRole(['Dean', 'ORIC']) ? 'active' : '' }}"
                            id="form2" role="tabpanel">
                            <table id="complaintTable2" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Audit Term</th>
                                        <th>Faculty</th>
                                        <th>Department</th>
                                        <th>Program</th>
                                        <th>Program Level</th>
                                        <th>Total Score</th>
                                        <th>Obtained Score</th>
                                        <th>Strength</th>
                                        <th>Area of Improvement</th>
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
@if(in_array(getRoleName(activeRole()), ['QEC']))
    <script>
        let pastIndex = 1;
        let faculties = @json(get_faculties());

        $(document).ready(function () {

            initSelect2();

            fetchIndicatorForms();

            // ===============================
            // CREATE / UPDATE SUBMIT
            // ===============================
            $('#researchForm1').on('submit', function (e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);
                let formId = $('#form_id').val();

                let url = formId
                    ? `/qec-audit-rating/${formId}`
                    : "{{ route('qec-audit-rating.store') }}";

                if (formId) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {

                            // Redirect to index page
                            window.location.href = "{{ route('qec-audit-rating.index') }}";

                            // OR if you prefer direct URL:
                            // window.location.href = "/qec-audit-rating";
                        });

                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();

                            $.each(errors, function (field, messages) {
                                let fieldName = field.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']';
                                let input = $('[name="' + fieldName + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                            });
                        } else {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        }
                    }
                });
            });

            // ===============================
            // ADD AUDIT GROUP
            // ===============================
            $('#add-coauthor').click(function () {
                addAuditGroup();
            });

            // Remove group
            $(document).on('click', '.remove-past', function () {
                $(this).closest('.past-group').remove();
            });

            // ===============================
            // EDIT
            // ===============================
            $(document).on('click', '.edit-form-btn', function () {

                let form = $(this).data('form');

                resetForm();
                $('#form_id').val(form.id);
                $('textarea[name="remarks"]').val(form.remarks);

                $('#author-past-container').html('');
                pastIndex = 0;

                if (form.details && form.details.length) {

                    form.details.forEach(function (audit, index) {

                        addAuditGroup(audit);
                        pastIndex++;
                    });
                }

                $('.nav-tabs a[href="#form1"]').tab('show');
            });

            // ===============================
            // DELETE
            // ===============================
            $(document).on('click', '.delete-form-btn', function () {

                let id = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Yes delete it"
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: `/qec-audit-rating/${id}`,
                            type: "POST",
                            data: {
                                _method: "DELETE",
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {

                                Swal.fire('Deleted!', response.message, 'success');
                                fetchIndicatorForms();
                            }
                        });
                    }
                });
            });


            // ===============================
            // FACULTY → DEPARTMENT
            // ===============================
            $(document).on('change', '.faculty-select', function () {

                let facultyId = $(this).val();
                let parentGroup = $(this).closest('.past-group');

                let departmentSelect = parentGroup.find('.department-select');
                let programSelect = parentGroup.find('.program-select');

                // Reset dependent dropdowns
                departmentSelect.html('<option value="">Loading...</option>').trigger('change');
                programSelect.html('<option value="">Select Program</option>').trigger('change');

                if (facultyId) {
                    $.ajax({
                        url: "/get-departments/" + facultyId,
                        type: "GET",
                        success: function (departments) {

                            let options = '<option value="">Select Department</option>';

                            $.each(departments, function (i, dept) {
                                options += `<option value="${dept.id}">${dept.name}</option>`;
                            });

                            departmentSelect.html(options).trigger('change');
                        },
                        error: function () {
                            departmentSelect.html('<option value="">Error loading departments</option>');
                        }
                    });
                } else {
                    departmentSelect.html('<option value="">Select Department</option>').trigger('change');
                }
            });


            // ===============================
            // DEPARTMENT → PROGRAM
            // ===============================
            $(document).on('change', '.department-select', function () {

                let departmentId = $(this).val();
                let parentGroup = $(this).closest('.past-group');

                let programSelect = parentGroup.find('.program-select');

                programSelect.html('<option value="">Loading...</option>').trigger('change');

                if (departmentId) {
                    $.ajax({
                        url: "/get-programs/" + departmentId,
                        type: "GET",
                        success: function (programs) {

                            let options = '<option value="">Select Program</option>';

                            $.each(programs, function (i, program) {
                                options += `<option value="${program.id}">${program.program_name}</option>`;
                            });

                            programSelect.html(options).trigger('change');
                        },
                        error: function () {
                            programSelect.html('<option value="">Error loading programs</option>');
                        }
                    });
                } else {
                    programSelect.html('<option value="">Select Program</option>').trigger('change');
                }
            });


        });
    </script>

    <script>
        // ===============================
        // FETCH TABLE DATA
        // ===============================
        function fetchIndicatorForms() {

            $.ajax({
                url: "{{ route('qec-audit-rating.index') }}",
                type: "GET",
                success: function (data) {

                    const forms = data.forms || [];

                    const rowData = forms.map((form, i) => {

                        let firstDetail = form.details.length ? form.details[0] : {};

                        return [
                            i + 1,
                            form.creator ? form.creator.name : 'N/A',
                            firstDetail.audit_term ?? 'N/A',
                            firstDetail.faculty ? firstDetail.faculty.name : 'N/A',
                            firstDetail.department ? firstDetail.department.name : 'N/A',
                            firstDetail.program ? firstDetail.program.name : 'N/A',
                            firstDetail.program_level ?? 'N/A',
                            firstDetail.total_score ?? 'N/A',
                            firstDetail.obtained_score ?? 'N/A',
                            firstDetail.strenght ?? 'N/A',
                            firstDetail.area_of_improvement ?? 'N/A',
                            form.created_at ? new Date(form.created_at).toISOString().split('T')[0] : 'N/A',
                            `<div class="d-flex gap-1"><button class="btn btn-sm btn-outline-warning edit-form-btn" data-form='${encodeURIComponent(JSON.stringify(form))}'> Edit </button>
                                                                                                                                              <button class="btn btn-sm btn-outline-danger delete-form-btn" data-id="${form.id}"> Delete </button> </div>`
                        ];
                    });


                    if (!$.fn.DataTable.isDataTable('#complaintTable2')) {

                        $('#complaintTable2').DataTable({
                            data: rowData,
                            columns: [
                                { title: "#" },
                                { title: "Audit Term" },
                                { title: "Faculty" },
                                { title: "Department" },
                                { title: "Program" },
                                { title: "Program Level" },
                                { title: "Total Score" },
                                { title: "Obtained Score" },
                                { title: "Strength" },
                                { title: "Area of Improvement" },
                                { title: "Actions" }
                            ]
                        });

                    } else {

                        $('#complaintTable2').DataTable().clear().rows.add(rowData).draw();
                    }
                }
            });
        }
    </script>

    <script>
        // ===============================
        // ADD AUDIT GROUP FUNCTION
        // ===============================
        function addAuditGroup(audit = null) {

            let facultyOptions = '<option value="">Select Faculty</option>';
            faculties.forEach(function (fac) {
                facultyOptions += `<option value="${fac.id}">${fac.name}</option>`;
            });
            // 🔹 Dynamic Academic Year Logic (Same as PHP)
            let currentYear = new Date().getFullYear();
            let auditTermOptions = '<option value="">Select Audit Term</option>';

            for (let year = currentYear - 2; year <= currentYear + 3; year++) {
                let nextYear = year + 1;
                let range = `${year}-${nextYear}`;
                auditTermOptions += `<option value="${range}">${range}</option>`;
            }

            let group = `
                        <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

                        <div class="col-md-4">
                        <label class="form-label">Audit Term</label>
                        <select name="audits[${pastIndex}][audit_term]" class="form-select">
                        ${auditTermOptions}
                        </select>
                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Audit Term</label>
                                        <select name="audits[${pastIndex}][audit_term]" class="form-select">
                                        <option value="">Select</option>
                                        <option value="2021-2022">2021-2022</option>
                                        <option value="2022-2023">2022-2023</option>
                                        <option value="2023-2024">2023-2024</option>
                                        </select>
                                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Faculty</label>
                                        <select name="audits[${pastIndex}][faculty_id]" 
                                        class="select2 form-select faculty-select">
                                        ${facultyOptions}
                                        </select>
                                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Department</label>
                                        <select name="audits[${pastIndex}][department_id]" 
                                        class="select2 form-select department-select">
                                        <option value="">Select Department</option>
                                        </select>
                                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Program</label>
                                        <select name="audits[${pastIndex}][program_id]" 
                                        class="select2 form-select program-select">
                                        <option value="">Select Program</option>
                                        </select>
                                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Program Level</label>
                                        <select name="audits[${pastIndex}][program_level]" class="form-select">
                                        <option value="">Select Level</option>
                                        <option value="UG">UG</option>
                                        <option value="PG">PG</option>
                                        </select>
                                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Total QEC Audit Rating Score</label>
                                        <input type="number" name="audits[${pastIndex}][total_score]" 
                                        class="form-control" value="${audit?.total_score ?? ''}">
                                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Score Obtained</label>
                                        <input type="number" name="audits[${pastIndex}][obtained_score]" 
                                        class="form-control" value="${audit?.obtained_score ?? ''}">
                                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Strenght</label>
                                        <input type="text" name="audits[${pastIndex}][strenght]" value="${audit?.strenght ?? ''}" class="form-control">
                                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Area of Improvement</label>
                                        <input type="text" name="audits[${pastIndex}][area_of_improvement]" value="${audit?.area_of_improvement ?? ''}" class="form-control">
                                        </div>

                                        <div class="col-md-12">
                                        <button type="button" class="btn btn-danger remove-past">Remove</button>
                                        </div>
                                        </div>`;

            $('#author-past-container').append(group);

            initSelect2();

            if (audit) {

                $(`[name="audits[${pastIndex}][audit_term]"]`)
                    .val(audit.audit_term);

                $(`[name="audits[${pastIndex}][faculty_id]"]`)
                    .val(audit.faculty_id).trigger('change');

                setTimeout(function () {

                    $(`[name="audits[${pastIndex}][department_id]"]`)
                        .val(audit.department_id).trigger('change');

                    setTimeout(function () {

                        $(`[name="audits[${pastIndex}][program_id]"]`)
                            .val(audit.program_id).trigger('change');

                    }, 500);

                }, 500);
            }

            pastIndex++;
        }
    </script>

    <script>
        // ===============================
        // SELECT2 INIT
        // ===============================
        function initSelect2() {
            $('.select2').select2({
                width: '100%'
            });
        }

        // RESET FORM
        function resetForm() {
            $('#researchForm1')[0].reset();
            $('#form_id').val('');
            $('#author-past-container').html('');
            pastIndex = 0;
        }
    </script>
     @endif
@endpush
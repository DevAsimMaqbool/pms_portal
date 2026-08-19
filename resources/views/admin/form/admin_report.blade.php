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
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- new design -->

        <div class="app-ecommerce">
            <!-- tab open-->
            <div class="nav-align-top">

                <!-- main tab-->
                <div class="tab-content" style="padding:0;background: none;border: none;box-shadow: none;">

                    <!-- first tab-->
                    <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                        <form id="researchForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                            <input type="hidden" name="indicator_id" value="">
                            <div class="row">
                                <!-- First column-->
                                <div class="col-12 col-lg-12">
                                    <!-- Product Information -->
                                    <div class="card mb-6">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Generate Report</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-6 mb-3">

                                                    <input type="radio" name="role" id="role_dean" value="23">
                                                    <label for="role_dean">Dean</label>

                                                    <input type="radio" name="role" id="role_hod" value="22" checked>
                                                    <label for="role_hod">HOD</label>

                                                    <input type="radio" name="role" id="role_pl_pg" value="29">
                                                    <label for="role_pl_pg">PL-PG</label>

                                                    <input type="radio" name="role" id="role_pl_ug" value="19">
                                                    <label for="role_pl_ug">PL-UG</label>

                                                    <input type="radio" name="role" id="role_faculty" value="faculty">
                                                    <label for="role_faculty">Faculty</label>

                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="faculty" class="form-label">Faculty</label>
                                                    <select name="faculty_id" id="faculty_id" class="select2 form-select">
                                                        <option value="">-- Select Faculty --</option>
                                                        @foreach(get_faculties() as $faculty)
                                                            <option value="{{ $faculty->id }}">
                                                                {{ $faculty->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="department" class="form-label">Department</label>
                                                    <select name="department_id" id="department_id"
                                                        class="select2 form-select">
                                                        <option value="">-- Select Department --</option>
                                                    </select>

                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="program" class="form-label">Program</label>
                                                    <select name="program_id" id="program_id"
                                                        class="select2 form-select program_id">
                                                        <option value="">-- Select Program --</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-12 mt-3">
                                                <button type="button" id="generateReport" class="btn btn-primary">
                                                    Generate Report
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card mt-4" id="reportCard" style="display:none;">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Report</h5>

                            <button type="button" id="downloadPdf" class="btn btn-danger">
                                <i class="ti ti-file-type-pdf me-1"></i>
                                Download PDF
                            </button>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-striped" id="reportTable">

                                    <thead id="reportTableHead">
                                    </thead>

                                    <tbody id="reportTableBody">
                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div>
                    <!-- /first tab-->
                </div>
                <!-- /main tab-->
            </div>
            <!-- tab open-->
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    {{-- PDF --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

@endpush
@push('script')
    <script>
        $(document).ready(function () {

            /*
            |--------------------------------------------------------------------------
            | Generate Report
            |--------------------------------------------------------------------------
            */

            $('#generateReport').on('click', function () {

                let role = $('input[name="role"]:checked').val();
                let facultyId = $('#faculty_id').val();
                let departmentId = $('#department_id').val();
                let programId = $('#program_id').val();

                let button = $(this);

                button.prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm"></span> Loading...');

                $.ajax({

                    url: "{{ route('employee.report.data') }}",

                    type: "GET",

                    data: {
                        role: role,
                        faculty_id: facultyId,
                        department_id: departmentId,
                        program_id: programId
                    },

                    success: function (response) {

                        let data = response.data || [];
                        let kpas = response.kpas || [];

                        /*
                        |--------------------------------------------------------------------------
                        | No Data
                        |--------------------------------------------------------------------------
                        */

                        if (!data.length) {

                            $('#reportTableHead').html('');

                            $('#reportTableBody').html(`
                            <tr>
                                <td colspan="100%" class="text-center">
                                    No data found
                                </td>
                            </tr>
                        `);

                            $('#reportCard').show();

                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Generate Table Header
                        |--------------------------------------------------------------------------
                        */

                        let header = `
                        <tr>
                            <th>Sr#</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Faculty</th>
                            <th>Department</th>
                            <th>Program</th>
                    `;

                        /*
                        |--------------------------------------------------------------------------
                        | KPA Headers
                        |--------------------------------------------------------------------------
                        */

                        kpas.forEach(function (kpa) {

                            header += `
                            <th class="text-center">
                                ${kpa.name}
                            </th>
                        `;

                        });

                        /*
                        |--------------------------------------------------------------------------
                        | Total + Rating
                        |--------------------------------------------------------------------------
                        */

                        header += `
                            <th class="text-center">
                                Total Score
                            </th>

                            <th class="text-center">
                                Rating
                            </th>

                        </tr>
                    `;

                        $('#reportTableHead').html(header);

                        /*
                        |--------------------------------------------------------------------------
                        | Generate Rows
                        |--------------------------------------------------------------------------
                        */

                        let rows = '';

                        data.forEach(function (user, index) {

                            rows += `
                            <tr>

                                <td>${index + 1}</td>

                                <td>${user.role ?? 'N/A'}</td>

                                <td>${user.name ?? 'N/A'}</td>

                                <td>${user.job_title ?? 'N/A'}</td>

                                <td>${user.faculty ?? 'N/A'}</td>

                                <td>${user.department ?? 'N/A'}</td>

                                <td>${user.program ?? 'N/A'}</td>
                        `;

                            /*
                            |--------------------------------------------------------------------------
                            | KPA Scores
                            |--------------------------------------------------------------------------
                            |
                            | IMPORTANT:
                            |
                            | weighted_score is displayed here.
                            |
                            */

                            kpas.forEach(function (kpa) {

                                let userKpa = (user.kpas || []).find(
                                    item => Number(item.id) === Number(kpa.id)
                                );

                                let weightedScore = userKpa
                                    ? Number(userKpa.weighted_score || 0)
                                    : 0;

                                rows += `
                                <td class="text-center">
                                    ${weightedScore.toFixed(2)}
                                </td>
                            `;

                            });

                            /*
                            |--------------------------------------------------------------------------
                            | Total Score
                            |--------------------------------------------------------------------------
                            */

                            rows += `
                                <td class="text-center">
                                    <strong>
                                        ${Number(user.total_score || 0).toFixed(2)}
                                    </strong>
                                </td>

                                <td class="text-center">
                                    ${user.rating ?? 'N/A'}
                                </td>

                            </tr>
                        `;

                        });

                        /*
                        |--------------------------------------------------------------------------
                        | Insert Rows
                        |--------------------------------------------------------------------------
                        */

                        $('#reportTableBody').html(rows);

                        /*
                        |--------------------------------------------------------------------------
                        | Show Report
                        |--------------------------------------------------------------------------
                        */

                        $('#reportCard').show();

                    },

                    /*
                    |--------------------------------------------------------------------------
                    | AJAX Error
                    |--------------------------------------------------------------------------
                    */

                    error: function (xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to generate report.'
                        });

                    },

                    /*
                    |--------------------------------------------------------------------------
                    | Complete
                    |--------------------------------------------------------------------------
                    */

                    complete: function () {

                        button.prop('disabled', false)
                            .html('Generate Report');

                    }

                });

            });

            /*
            |--------------------------------------------------------------------------
            | DOWNLOAD PDF
            |--------------------------------------------------------------------------
            */

            $('#downloadPdf').on('click', function () {

                /*
                |--------------------------------------------------------------------------
                | Check Report
                |--------------------------------------------------------------------------
                */

                if (!$('#reportTableBody tr').length) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'No Report',
                        text: 'Please generate the report first.'
                    });

                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Check jsPDF
                |--------------------------------------------------------------------------
                */

                if (typeof window.jspdf === 'undefined') {

                    Swal.fire({
                        icon: 'error',
                        title: 'PDF Library Missing',
                        text: 'PDF library could not be loaded.'
                    });

                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Create PDF
                |--------------------------------------------------------------------------
                */

                const {
                    jsPDF
                } = window.jspdf;

                let pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4'
                });

                /*
                |--------------------------------------------------------------------------
                | Title
                |--------------------------------------------------------------------------
                */

                pdf.setFontSize(16);

                pdf.text(
                    'Employee Performance Report',
                    148,
                    12,
                    {
                        align: 'center'
                    }
                );

                /*
                |--------------------------------------------------------------------------
                | Selected Filters
                |--------------------------------------------------------------------------
                */

                let facultyText = $('#faculty_id option:selected').text().trim();
                let departmentText = $('#department_id option:selected').text().trim();
                let programText = $('#program_id option:selected').text().trim();

                let roleText = $('input[name="role"]:checked')
                    .next('label')
                    .text()
                    .trim();

                /*
                |--------------------------------------------------------------------------
                | Filter Information
                |--------------------------------------------------------------------------
                */

                pdf.setFontSize(9);

                let filterText =
                    'Role: ' + (roleText || 'All') +
                    '    |    Faculty: ' + (facultyText || 'All') +
                    '    |    Department: ' + (departmentText || 'All') +
                    '    |    Program: ' + (programText || 'All');

                pdf.text(
                    filterText,
                    148,
                    19,
                    {
                        align: 'center'
                    }
                );

                /*
                |--------------------------------------------------------------------------
                | Convert HTML Table to PDF
                |--------------------------------------------------------------------------
                */

                pdf.autoTable({

                    html: '#reportTable',

                    startY: 25,

                    theme: 'grid',

                    styles: {
                        fontSize: 7,
                        cellPadding: 2,
                        overflow: 'linebreak',
                        valign: 'middle'
                    },

                    headStyles: {
                        fontSize: 7,
                        halign: 'center'
                    },

                    bodyStyles: {
                        fontSize: 7
                    },

                    columnStyles: {
                        0: {
                            halign: 'center'
                        }
                    },

                    margin: {
                        top: 25,
                        right: 5,
                        bottom: 10,
                        left: 5
                    },

                    didDrawPage: function (data) {

                        /*
                        |--------------------------------------------------------------------------
                        | Footer
                        |--------------------------------------------------------------------------
                        */

                        let pageNumber =
                            pdf.internal.getNumberOfPages();

                        pdf.setFontSize(7);

                        pdf.text(
                            'Page ' + pageNumber,
                            148,
                            205,
                            {
                                align: 'center'
                            }
                        );

                    }

                });

                /*
                |--------------------------------------------------------------------------
                | File Name
                |--------------------------------------------------------------------------
                */

                let date = new Date();

                let fileDate =
                    date.getFullYear() +
                    '-' +
                    String(date.getMonth() + 1).padStart(2, '0') +
                    '-' +
                    String(date.getDate()).padStart(2, '0');

                /*
                |--------------------------------------------------------------------------
                | Download
                |--------------------------------------------------------------------------
                */

                pdf.save(
                    'Employee_Performance_Report_' + fileDate + '.pdf'
                );

            });

            /*
            |--------------------------------------------------------------------------
            | Faculty Change
            |--------------------------------------------------------------------------
            */

            $('#faculty_id').on('change', function () {

                let facultyId = $(this).val();

                let departmentSelect = $('#department_id');

                let programSelect = $('#program_id');

                departmentSelect.html(
                    '<option value="">Loading...</option>'
                );

                programSelect.html(
                    '<option value="">-- Select Program --</option>'
                );

                if (facultyId) {

                    $.ajax({

                        url: "/get-departments/" + facultyId,

                        type: "GET",

                        success: function (response) {

                            departmentSelect.empty();

                            departmentSelect.append(
                                '<option value="">-- Select Department --</option>'
                            );

                            $.each(response, function (key, department) {

                                departmentSelect.append(
                                    `<option value="${department.id}">
                                    ${department.name}
                                </option>`
                                );

                            });

                            departmentSelect.trigger('change');

                        }

                    });

                } else {

                    departmentSelect.html(
                        '<option value="">-- Select Department --</option>'
                    );

                }

            });

            /*
            |--------------------------------------------------------------------------
            | Department Change
            |--------------------------------------------------------------------------
            */

            $('#department_id').on('change', function () {

                let departmentId = $(this).val();

                let programSelect = $('#program_id');

                programSelect.html(
                    '<option value="">Loading...</option>'
                );

                if (departmentId) {

                    $.ajax({

                        url: "/get-programs/" + departmentId,

                        type: "GET",

                        success: function (response) {

                            programSelect.empty();

                            programSelect.append(
                                '<option value="">-- Select Program --</option>'
                            );

                            $.each(response, function (key, program) {

                                programSelect.append(
                                    `<option value="${program.id}">
                                    ${program.program_name}
                                </option>`
                                );

                            });

                            programSelect.trigger('change');

                        },

                        error: function () {

                            programSelect.html(
                                '<option value="">Error loading programs</option>'
                            );

                        }

                    });

                } else {

                    programSelect.html(
                        '<option value="">-- Select Program --</option>'
                    );

                }

            });

        });
    </script>

@endpush
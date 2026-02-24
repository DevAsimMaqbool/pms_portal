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
                @if(auth()->user()->hasRole(['Finance']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">% of Admission Targets Achieved</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Table</a>
                        </li>
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
                    @if(auth()->user()->hasRole(['Finance']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                                <div class="d-flex flex-column justify-content-center">
                                    <h4 class="mb-1">% of Admission Targets Achieved</h4>
                                </div>
                                <div class="d-flex align-content-center flex-wrap gap-4">
                                    <div class="d-flex gap-4">
                                    <a class="btn btn-label-primary" href="{{ route('indicators_crud.index', ['slug' => 'admission_targets_achieved', 'id' => $indicatorId]) }}">View</a></div>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                                                                <i class="bx bx-upload"></i> Import Excel / CSV</button>
                                </div>
                            </div>
                            <form id="researchForm1" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden" id="form_status" name="form_status" value="HOD">

                                <div class="row">
                                    <div id="author-past-container">
                                        <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

                                            <div class="col-md-4">
                                                <label class="form-label">Faculty</label>
                                                <select name="admission[0][faculty_id]" class="select2 form-select faculty-select">
                                                    <option value="">Select Faculty</option>
                                                    @foreach(get_faculties() as $faculty)
                                                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Department</label>
                                                <select name="admission[0][department_id]" class="select2 form-select department-select">
                                                    <option value="">Select Department</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Program Name</label>
                                                <select name="admission[0][program_id]" class="select2 form-select program-select">
                                                    <option value="">Select Program</option>
                                                </select>
                                            </div>

                                
                                            <div class="col-md-4">
                                                <label for="admissions_campaign_id" class="form-label">Admissions Campaign</label>
                                                @php
                                                    $year = now()->year;
                                                @endphp
                                                <select name="admission[0][admissions_campaign]"
                                                    class="select2 form-select admissions-campaign" required>
                                                    <option value="">-- Select Campaign --</option>
                                                     @for($i = 0; $i < 3; $i++)
                                                        <option value="Fall {{ $year + $i }}">
                                                            Fall {{ $year + $i }}
                                                        </option>
                                                        <option value="Spring {{ $year + $i + 1 }}">
                                                            Spring {{ $year + $i + 1 }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Admissions Target</label>
                                                <input type="number" name="admission[0][admissions_target]" class="form-control" min="1"
                                                    step="1" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Target Achieved</label>
                                                <input type="number" name="admission[0][achieved_target]" class="form-control" min="1"
                                                    step="1" required>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            id="add-coauthor"><i class="icon-base ti tabler-plus me-1"></i> <span
                                                class="align-middle">Add</span></button>
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
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Co Authers</th>
                                        <th>Author Rank</th>
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
    @if(auth()->user()->hasRole(['Finance']))
        <script>
            
            $(document).ready(function () {
                
                let faculties = @json(get_faculties());
                let pastIndex = 1;

                // Add new author group
                $('#add-coauthor').click(function () {
                    

                     let facultyOptions = '<option value="">Select Faculty</option>';
                        faculties.forEach(function(fac) {
                            facultyOptions += `<option value="${fac.id}">${fac.name}</option>`;
                        });
                       let currentYear = new Date().getFullYear();
                        let campaignOptions = `<option value="">-- Select Admission Campaign --</option>`;

                        for (let i = 0; i < 3; i++) {
                            campaignOptions += `
                                <option value="Fall ${currentYear + i}">
                                    Fall ${currentYear + i}
                                </option>
                                <option value="Spring ${currentYear + i + 1}">
                                    Spring ${currentYear + i + 1}
                                </option>
                            `;
                        }
                    let newGroup = `
            <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">


                <div class="col-md-4">
                    <label class="form-label">Faculty</label>
                    <select name="admission[${pastIndex}][faculty_id]" class="select2 form-select faculty-select">
                        ${facultyOptions}
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Department</label>
                     <select name="admission[${pastIndex}][department_id]" class="select2 form-select department-select">
                        <option value="">Select Department</option>
                    </select>
                </div>

                 <div class="col-md-4">
                    <label class="form-label">Program Name</label>
                    <select name="admission[${pastIndex}][program_id]" class="select2 form-select program-select">
                        <option value="">Select Program</option>
                    </select>
                </div>

               

                 <div class="col-md-4">
                    <label for="admissions_campaign_id" class="form-label">Admissions Campaign</label>
                    <select name="admission[${pastIndex}][admissions_campaign]"
                        class="select2 form-select admissions-campaign" required>
                        ${campaignOptions}
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Admissions Target</label>
                    <input type="number" name="admission[${pastIndex}][admissions_target]" class="form-control" min="1"
                        step="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Target Achieved</label>
                    <input type="number" name="admission[${pastIndex}][achieved_target]" class="form-control" min="1"
                        step="1" required>
                </div>

            <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-past"><i class="icon-base ti tabler-x me-1"></i><span class="align-middle">Delete</span></button>
            </div>
            </div>`;

                    // Convert string → jQuery object
                    let $newBlock = $(newGroup);

                    // Append
                    $('#author-past-container').append($newBlock);

                    // ⭐⭐⭐ IMPORTANT ⭐⭐⭐
                    // Initialize Select2 on ALL selects inside this block
                    $newBlock.find('select.select2').select2({
                        placeholder: 'Select an option',
                        width: '100%'
                    });
                    pastIndex++;
                });

                // Remove a past group
                $(document).on('click', '.remove-past', function () {
                    $(this).closest('.past-group').remove();
                });
                $('#researchForm1').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('admission-targets.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
                            // Remove added groups
                            $('#author-past-container .past-group').not(':first').remove();

                            // Reset Select2
                            $('#author-past-container select.select2')
                                .val(null)
                                .trigger('change');

                            // Reset dependent dropdowns
                            $('.department-select').html('<option value="">Select Department</option>');
                            $('.program-select').html('<option value="">Select Program</option>');

                            // Reset index
                            pastIndex = 1;
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
                                    let fieldName = field.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']';
                                    fieldName = fieldName.replace('[]]', ']');
                                    let input = form.find('[name="' + fieldName + '"]');

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

                // 3️⃣ Faculty → Department
                $(document).on('change', '.faculty-select', function () {
                    let facultyId = $(this).val();
                    let departmentSelect = $(this).closest('.past-group').find('.department-select');
                    let programSelect = $(this).closest('.past-group').find('.program-select');

                    // Reset dependent dropdowns
                    departmentSelect.html('<option value="">Loading...</option>');
                    programSelect.html('<option value="">Select Program</option>');

                    if (facultyId) {
                        $.ajax({
                            url: "/get-departments/" + facultyId,
                            type: "GET",
                            success: function (departments) {
                                departmentSelect.empty();
                                departmentSelect.append('<option value="">Select Department</option>');
                                $.each(departments, function (key, department) {
                                    departmentSelect.append(`<option value="${department.id}">${department.name}</option>`);
                                });
                                // Refresh Select2
                                departmentSelect.select2({ placeholder: 'Select Department', width: '100%' });
                            },
                            error: function () {
                                departmentSelect.html('<option value="">Error loading departments</option>');
                            }
                        });
                    } else {
                        departmentSelect.html('<option value="">Select Department</option>');
                    }
                });

                // 4️⃣ Department → Program
                $(document).on('change', '.department-select', function () {
                    let departmentId = $(this).val();
                    let programSelect = $(this).closest('.past-group').find('.program-select');

                    programSelect.html('<option value="">Loading...</option>');

                    if (departmentId) {
                        $.ajax({
                            url: "/get-programs/" + departmentId,
                            type: "GET",
                            success: function (programs) {
                                programSelect.empty();
                                programSelect.append('<option value="">Select Program</option>');
                                $.each(programs, function (key, program) {
                                    programSelect.append(`<option value="${program.id}">${program.program_name}</option>`);
                                });
                                // Refresh Select2
                                programSelect.select2({ placeholder: 'Select Program', width: '100%' });
                            },
                            error: function () {
                                programSelect.html('<option value="">Error loading programs</option>');
                            }
                        });
                    } else {
                        programSelect.html('<option value="">Select Program</option>');
                    }
                });


            });
        </script>
    @endif
@endpush
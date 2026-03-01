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
                
                <div class="tab-content">
                    @if(in_array(getRoleName(activeRole()), ['DOPS']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                                <div class="d-flex flex-column justify-content-center">
                                    <h4 class="mb-1">Scholar's Satisfaction (In Thesis Stage)</h4>
                                </div>
                                <div class="d-flex align-content-center flex-wrap gap-4">
                                    <div class="d-flex gap-4">
                                    <a class="btn btn-label-primary" href="{{ route('indicators_crud.index', ['slug' => 'scholars_satisfaction_in_thesis_stage', 'id' => $indicatorId]) }}">View</a></div>
                                    {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                                                                <i class="bx bx-upload"></i> Import Excel / CSV</button> --}}
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
                                                <label for="term" class="form-label">Terms</label>
                                                <select name="scholar_satisfaction[0][term]"
                                                    class="select2 form-select term" required>
                                                    <option value="">Select Term</option>

                                                    <?php
                                                    $currentYear = date('Y');
                                                    for ($year = $currentYear - 2; $year <= $currentYear + 3; $year++) {
                                                        echo "<option value='Spring $year'>Spring $year</option>";
                                                        echo "<option value='Fall $year'>Fall $year</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Faculty</label>
                                                <select name="scholar_satisfaction[0][faculty_id]" class="select2 form-select faculty-select">
                                                    <option value="">Select Faculty</option>
                                                    @foreach(get_faculties() as $faculty)
                                                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Department</label>
                                                <select name="scholar_satisfaction[0][department_id]" class="select2 form-select department-select">
                                                    <option value="">Select Department</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Program Name</label>
                                                <select name="scholar_satisfaction[0][program_id]" class="select2 form-select program-select">
                                                    <option value="">Select Program</option>
                                                </select>
                                            </div>

                                
                                            <div class="col-md-4">
                                                <label  class="form-label">Career</label>
                                                <select name="scholar_satisfaction[0][career]" class="select2 form-select career" required>
                                                    <option value="">-- Select Career --</option>
                                                    <option value="PG">PG</option>
                                                    <option value="UG">UG</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Satisfaction Score</label>
                                                <input type="number" name="scholar_satisfaction[0][satisfaction_score]" class="form-control" min="1"
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
    @if(in_array(getRoleName(activeRole()), ['DOPS']))
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
                         // Generate Spring/Fall options dynamically
                    let currentYear = new Date().getFullYear();
                    let termOptions = '<option value="">-- Select Term --</option>';

                    for (let year = currentYear - 2; year <= currentYear + 3; year++) {
                        termOptions += `<option value="Spring ${year}">Spring ${year}</option>`;
                        termOptions += `<option value="Fall ${year}">Fall ${year}</option>`;
                    }
                    let newGroup = `
            <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">


               <div class="col-md-4">
                    <label for="term" class="form-label">Terms</label>
                    <select name="scholar_satisfaction[${pastIndex}][term]"
                        class="select2 form-select term" required>
                        ${termOptions}
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Faculty</label>
                    <select name="scholar_satisfaction[${pastIndex}][faculty_id]" class="select2 form-select faculty-select">
                        ${facultyOptions}
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Department</label>
                     <select name="scholar_satisfaction[${pastIndex}][department_id]" class="select2 form-select department-select">
                        <option value="">Select Department</option>
                    </select>
                </div>

                 <div class="col-md-4">
                    <label class="form-label">Program Name</label>
                    <select name="scholar_satisfaction[${pastIndex}][program_id]" class="select2 form-select program-select">
                        <option value="">Select Program</option>
                    </select>
                </div>

               

                  <div class="col-md-4">
                    <label  class="form-label">Career</label>
                    <select name="scholar_satisfaction[${pastIndex}][career]" class="select2 form-select career" required>
                        <option value="">-- Select Career --</option>
                        <option value="PG">PG</option>
                        <option value="UG">UG</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Satisfaction Score</label>
                    <input type="number" name="scholar_satisfaction[${pastIndex}][satisfaction_score]" class="form-control" min="1"
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
                        url: "{{ route('scholars-satisfaction.store') }}",
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
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
                

                <!-- Tab panes -->
                <div class="tab-content">
                    @if(in_array(getRoleName(activeRole()), ['Human Resources']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h5 class="mb-1">Net Promoter Score of Faculty</h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'net_promoter_score_of_faculty', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div> 
                            <form id="researchForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden"  id="form_status" name="form_status" value="HOD">

                                <div class="row g-6 mt-0">
                                         
                                        <div class="row g-3 pb-3 border border-primary">
                                            <div class="col-md-4">
                                                <label for="batch" class="form-label">Select Year</label>
                                                <select name="year" id="year" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Batch --</option>
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
                                                <label for="department_id" class="form-label">Department</label>
                                                <select name="department_id" id="department_id" class="select2 form-select"
                                                    required>
                                                    <option value="">-- Select Department --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="program" class="form-label">Program</label>
                                                <select name="program_id" id="program_id" class="select2 form-select program_id"
                                                    required>
                                                    <option value="">-- Select Program --</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="program_level" class="form-label">Program Level</label>
                                                <select name="program_level" id="program_level"
                                                    class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Level --</option>
                                                    <option value="UG">UG</option>
                                                    <option value="PG">PG</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="total_faculty_surveyed">Total Faculty Surveyed</label>
                                                <input type="number" class="form-control" id="total_faculty_surveyed" placeholder="Total Faculty Surveyed" name="total_faculty_surveyed" aria-label="Total Faculty Surveyed">
                                            </div>
                                            <div class="col-md-4">
                                                 <label class="form-label" for="number_of_promoters">Number of Promoters</label>
                                                <input type="number" class="form-control" id="number_of_promoters" placeholder="Number of Promoters" name="number_of_promoters" aria-label="Number of Promoters (Score 9–10)">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label" for="remarks">Remarks</label>
                                                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                            </div>
                                            <div class="col-md-12">
                                                 <label class="form-label" for="promoters_percentage">Promoters Percentage (%)</label>
                                                <input type="text" class="form-control" id="promoters_percentage" placeholder="Number of Promoters" name="promoters_percentage" >
                                            </div>
                                        </div>
                                   
                                </div>
                                <div class="col-12 demo-vertical-spacing">
                                    <button class="btn btn-primary waves-effect waves-light float-end" style="margin-right: 0px;">SUBMIT</button>
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
   @if(in_array(getRoleName(activeRole()), ['Human Resources']))
        <script>
            $(document).ready(function () {
              
              function updatePromotersPercentage() {
        let total = parseFloat($('#total_faculty_surveyed').val()) || 0;
        let promoters = parseFloat($('#number_of_promoters').val()) || 0;

        if(total > 0){
            let percentage = (promoters / total) * 100;
            $('#promoters_percentage').val(percentage.toFixed(2));
        } else {
            $('#promoters_percentage').val('');
        }
    }

    // Trigger calculation whenever values change
    $('#total_faculty_surveyed, #number_of_promoters').on('input', function() {
        updatePromotersPercentage();
    });

                 $('#researchForm').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);
                     // Show loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                     
                    $.ajax({
                        url: "{{ route('faculty-netpromoter-score.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                            $('.select2').val(null).trigger('change');
                              // Remove all extra grant groups and keep only the first one
                            $('#grant-details-container .grant-group:not(:first)').remove();

                            // Reset the proof container of the first group
                            $('#grant-details-container .grant-group:first .proof-container').hide();

                            // Reset index to 1
                            grantIndex = 1;

                            document.getElementById("employer_satisfaction").value = "";
                            document.getElementById("graduate_satisfaction").value = "";

                            // Reset stars
                            employerRaty.setScore(0);
                            graduateRaty.setScore(0);
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

                        } else if (xhr.status === 409) {
                            // 🔥 Duplicate record message
                            Swal.fire({
                                icon: 'error',
                                title: 'Duplicate Entry',
                                text: xhr.responseJSON.message
                            });

                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                        }
                    });
                });

                $('#importForm').on('submit', function (e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    Swal.fire({
                        title: 'Importing...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('employability.import') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            Swal.close();
                            Swal.fire('Success', res.message, 'success');
                            $('#importModal').modal('hide');
                            $('#importForm')[0].reset();
                        },
                        error: function (xhr) {
                            Swal.close();
                            Swal.fire('Error', xhr.responseJSON.message ?? 'Import failed', 'error');
                        }
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


            });
        </script>
    @endif
    @endpush
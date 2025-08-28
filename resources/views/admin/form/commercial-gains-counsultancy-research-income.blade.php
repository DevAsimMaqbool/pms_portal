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

                @if(auth()->user()->hasRole(['HOD']))
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Commercial Gains / Consultancy/Research Income</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Research Target Setting</a>
                    </li>
                </ul>
                @endif

                <!-- Tab panes -->
                <div class="tab-content">
                    {{-- ================= FORM 1 ================= --}}
                    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                    <div class="tab-pane fade show active" id="form1" role="tabpanel">
                          <form id="researchForm1" enctype="multipart/form-data"class="row">
                                @csrf
                                <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                                <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                                <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER" required>
                                
                                <div class="row g-6">
                                    <div class="col-md-6">
                                        <label for="no_of_consultancies_done" class="form-label">No of consultancies done</label>
                                        <input type="text" id="no_of_consultancies_done" name="no_of_consultancies_done" class="form-control" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="title_of_consultancy" class="form-label">Title of consultancy</label>
                                        <input type="text" id="title_of_consultancy" name="title_of_consultancy" class="form-control" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="duration_of_consultancy" class="form-label">Duration of consultancy</label>
                                        <input type="text" id="duration_of_consultancy" name="duration_of_consultancy" class="form-control" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name_of_client_organization" class="form-label">Name of client organization</label>
                                        <input type="text" id="name_of_client_organization" name="name_of_client_organization" class="form-control" >
                                    </div>

                                    {{-- Industrial Projects Group --}}
                                    <div id="industrialProjectsWrapper">
                                        <div class="industrial-project-group border p-3 mt-3 rounded">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">No of industrial projects</label>
                                                    <input type="text" name="industrial_projects[0][no_of_projects]" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Name of industrial projects</label>
                                                    <input type="text" name="industrial_projects[0][name_of_project]" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Name of contracting industry</label>
                                                    <input type="text" name="industrial_projects[0][name_of_contracting_industry]" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Total duration of the project</label>
                                                    <input type="text" name="industrial_projects[0][total_duration_of_project]" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Estimated project cost</label>
                                                    <input type="text" name="industrial_projects[0][estimate_cost_project]" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Estimated completion month/year</label>
                                                    <input type="text" name="industrial_projects[0][completion_year]" class="form-control">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect removeProject"><i class="icon-base ti tabler-x me-1"></i> <span class="align-middle">Delete</span></button>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="button" id="addProject" class="btn btn-primary waves-effect waves-light"><i class="icon-base ti tabler-plus me-1"></i><span class="align-middle">Add</span></button>
                                    </div>



                                </div>
                                <div class="col-4 text-center demo-vertical-spacing">
                                    <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>
                    </div>
                    @endif
                    @if(auth()->user()->hasRole(['HOD']))
                    <div class="tab-pane fade" id="form2" role="tabpanel">
                            <form id="researchForm2" enctype="multipart/form-data"class="row">
                                @csrf
                                <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                                <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                                <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden"  id="form_status" name="form_status" value="HOD" required>
                                
                                <div class="row g-6">
                                    <div class="col-md-6">
                                        <label for="target_of_projects" class="form-label">Target of consultancy projects</label>
                                        <input type="text" id="target_of_projects" name="target_of_consultancy_projects" class="form-control" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="target_of_faculties" class="form-label">Target of industrial projects</label>
                                        <input type="text" id="target_of_faculties" name="target_of_industrial_projects" class="form-control" >
                                    </div>

                                
                                </div>
                                <div class="col-4 text-center demo-vertical-spacing">
                                    <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>
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
 @if(auth()->user()->hasRole(['HOD','Teacher']))
<script>
$(document).ready(function () {
    let projectIndex = 1;

    $('#addProject').on('click', function () {
        let newGroup = `
            <div class="industrial-project-group border p-3 mt-3 rounded">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">No of industrial projects</label>
                        <input type="text" name="industrial_projects[${projectIndex}][no_of_projects]" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Name of industrial projects</label>
                        <input type="text" name="industrial_projects[${projectIndex}][name_of_project]" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Name of contracting industry</label>
                        <input type="text" name="industrial_projects[${projectIndex}][name_of_contracting_industry]" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Total duration of the project</label>
                        <input type="text" name="industrial_projects[${projectIndex}][total_duration_of_project]" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estimated project cost</label>
                        <input type="text" name="industrial_projects[${projectIndex}][estimate_cost_project]" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estimated completion month/year</label>
                        <input type="text" name="industrial_projects[${projectIndex}][completion_year]" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect removeProject"><i class="icon-base ti tabler-x me-1"></i> <span class="align-middle">Delete</span></button>
            </div>
        `;
        $('#industrialProjectsWrapper').append(newGroup);
        projectIndex++;
    });

    $(document).on('click', '.removeProject', function () {
        $(this).closest('.industrial-project-group').remove();
    });
    $('#researchForm1').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('counsultancy.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response)
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
                                 let fieldName = field.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']';
                                fieldName = fieldName.replace('[]]', ']');
                                let input = form.find('[name="' + fieldName + '"], [name="' + field + '"]');

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
 @if(auth()->user()->hasRole(['HOD']))
    <script>
    $(document).ready(function () {

       
       
         $('#researchForm2').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('counsultancy.store') }}",
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
@endpush

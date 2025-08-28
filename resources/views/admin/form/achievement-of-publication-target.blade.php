@extends('layouts.app')

@push('style')
    {{-- Vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="card-body">
            @if(auth()->user()->hasRole(['HOD','Dean','HR','ORIC']))
            <!-- Nav tabs -->
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">% Achievement of Publication</a>
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
                    <form id="researchForm1" enctype="multipart/form-data" class="row">
                        @csrf
                        <input type="hidden" name="kpa_id" value="{{ $areaId }}">
                        <input type="hidden" name="sp_category_id" value="{{ $categoryId }}">
                        <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                        <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER" required>

                        <div class="row g-6">
                            <div class="col-md-6">
                                <label class="form-label">Target Category</label>
                                <select name="target_category" class="form-select" required>
                                    <option value="">Select Target Category</option>
                                    <option value="Scopus-Indexed">Scopus Indexed</option>
                                    <option value="HEC">HEC</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Target of Publications</label>
                                <input type="number" name="target_of_publications" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Progress on publication</label>
                                <select id="progress_on_publication" name="progress_on_publication" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="Published">Published</option>
                                    <option value="In Review">In Review</option>
                                    <option value="At draft stage">At draft stage</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="extraFieldContainer"></div>
                        </div>
                        <div class="col-4 mt-3">
                            <button class="btn btn-primary w-100">SUBMIT</button>
                        </div>
                    </form>
                </div>
                  @endif
                {{-- ================= FORM 2 ================= --}}
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
                            <label for="faculty_member" class="form-label">Name of Faculty Member</label>
                            <select id="faculty_member" name="faculty_member_id" class="form-select" required>
                                <option value="">-- Select Faculty Member --</option>
                                @foreach($facultyMembers as $member)
                                    <option 
                                        value="{{ $member->id }}" 
                                        data-department="{{ $member->department }}" 
                                        data-job_title="{{ $member->job_title }}">
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" id="department" name="department" class="form-control" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="job_title" class="form-label">Designation</label>
                            <input type="text" id="job_title" name="job_title" class="form-control" disabled>
                        </div>

                            <div class="col-md-6">
                                <label for="target_category" class="form-label">Target Category</label>
                                <select id="target_category" name="target_category" class="form-select" required>
                                    <option value="">Select Target Category</option>
                                    <option value="Scopus-Indexed">Scopus Indexed</option>
                                    <option value="HEC">HEC</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="target_of_publications" class="form-label">Target of Publications</label>
                                <input type="text" id="target_of_publications" class="form-control" name="target_of_publications" required>
                                
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">Capacity building need?</label>
                                <div>
                                    <input type="radio" name="capacity_building" id="capacity_yes" value="1"> 
                                    <label for="capacity_yes">Yes</label>

                                    <input type="radio" name="capacity_building" id="capacity_no" value="0" checked> 
                                    <label for="capacity_no">No</label>
                                </div>
                            </div>

                            <div class="col-md-6" id="extra_select_container" style="display: none;">
                                <label for="need" class="form-label">Select the need</label>
                                <select id="need" name="need" class="form-select" required>
                                    <option value="">-- Select Option --</option>
                                    <option value="Basics-of-research">Basics of research</option>
                                    <option value="Analytical-tools">Analytical tools</option>
                                    <option value="Advanced-analytics">Advanced analytics</option>
                                </select>
                                
                            </div>

                            <div class="col-md-6">
                                <label for="any_specifics_related_to_capacity_building" class="form-label">Any Specifics related to capacity building</label>
                                <input type="text" id="any_specifics_related_to_capacity_building" class="form-control" name="any_specifics_related_to_capacity_building">
                                
                            </div>
                            <div class="col-md-6">
                                <label for="frequency" class="form-label">Frequency/No of trainings</label>
                                <input type="number" id="frequency" class="form-control" name="frequency">
                            </div>
                        </div>
                        <div class="col-4 text-center demo-vertical-spacing">
                            <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                        </div>
                    </form>
                </div>
                 @endif
                 @if(auth()->user()->hasRole(['Dean','ORIC','HR']))
                 <div class="tab-pane fade show active" id="form1" role="tabpanel">
                   <table id="complaintTable1" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>#</th>
                                <th>Created By</th>
                                <th>Indicator Category</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                 </div>
                 <div class="tab-pane fade" id="form2" role="tabpanel">
                     <table id="complaintTable1" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>#</th>
                                <th>Created By</th>
                                <th>Indicator Category</th>
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
@endsection

@push('script')
    {{-- Vendor Scripts --}}
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>
    @if(auth()->user()->hasRole(['HOD','Teacher']))
    <script>
    $(document).ready(function () {

        // Extra fields for Form 1
        $('#progress_on_publication').on('change', function () {
            const container = $('#extraFieldContainer');
            container.empty();

            if (this.value === 'At draft stage') {
                container.html(`<label class="form-label">Draft</label>
                                <input type="text" name="draft_stage" class="form-control" required>`);
            } else if (this.value === 'In Review') {
                container.html(`<label class="form-label">Email Screenshot</label>
                                <input type="file" name="email_screenshot" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required >`);
            } else if (this.value === 'Published') {
                container.html(`<label class="form-label">Scopus link</label>
                                <input type="url" name="scopus_link" class="form-control" required>`);
            }
        });

        $('#researchForm1').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('indicator-form.store') }}",
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
    @if(auth()->user()->hasRole(['HOD']))
    <script>
    $(document).ready(function () {

        // Extra fields for Form 2
         $('#faculty_member').on('change', function () {
            let selected = $(this).find(':selected');
            let department = selected.data('department');
            let job_title = selected.data('job_title');

            $('#department').val(department ?? '');
            $('#job_title').val(job_title ?? '');
        });
       
        $('input[name="capacity_building"]').on('change', function () {
            if ($(this).val() === '1') {
                $('#extra_select_container').show();
            } else {
                $('#extra_select_container').hide();
                $('#need').val(''); // clear selection if hidden
            }
        });
         $('#researchForm2').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('indicator-form.store') }}",
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
@if(auth()->user()->hasRole(['Dean']))
<script>
function fetchIndicatorForms() {
    $.ajax({
        url: "{{ route('indicatorForm.show') }}",
        method: "GET",
        dataType: "json",
        success: function (data) {
            const forms = data.forms || [];
            
            const rowData = forms.map((form, i) => {
                const createdAt = form.created_at 
                    ? new Date(form.created_at).toISOString().split('T')[0] 
                    : 'N/A';

                // Pass entire form as JSON in button's data attribute
                return [
                    `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                    i + 1,
                    form.creator ? form.creator.name : 'N/A',
                    form.target_category || 'N/A',
                    createdAt,
                    `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                ];
            });

            if (!$.fn.DataTable.isDataTable('#complaintTable')) {
                $('#complaintTable').DataTable({
                    data: rowData,
                    columns: [
                        { title: "<input type='checkbox' id='selectAll'>" },
                        { title: "#" },
                        { title: "Created By" },
                        { title: "Indicator Category" },
                        { title: "Created Date" },
                        { title: "Actions" }
                    ]
                });
            } else {
                $('#complaintTable').DataTable().clear().rows.add(rowData).draw();
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('Unable to load data.');
        }
    });
}
    $(document).ready(function () {

      fetchIndicatorForms();
       
    });
    </script>
    @endif
    
@endpush

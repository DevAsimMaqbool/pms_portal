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

                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h4 class="mb-1">Enterprise Task Management & Performance Monitoring System</h4>
                                            </div>
                                            <div class="d-flex align-content-center flex-wrap gap-4">
                                                <div class="d-flex gap-4">
                                                    {{-- <a class="btn btn-label-primary"
                                                        href="{{ route('indicators_crud.index', ['slug' => 'employability', 'id' => $indicatorId]) }}">View</a> --}}
                                                </div>
                                                <a class="btn btn-primary" href={{ route('employee-tasks.index'); }}> 
                                                    <i class="bx bx-upload"></i>Back</a>
                                            </div>
                                        </div>
                                        <form id="researchForm" enctype="multipart/form-data">
                                            @csrf
                                            {{-- <input type="hidden" name="indicator_id" value="{{ $indicatorId }}"> --}}
                                            <div class="row">
                                                <!-- First column-->
                                                <div class="col-12 col-lg-8">
                                                    <!-- Product Information -->
                                                    <div class="card mb-6">
                                                        <div class="card-header">
                                                            <h5 class="card-tile mb-0">Task Details</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="task_date " class="form-label">Task Date</label>
                                                                    <input type="date" name="task_date" id="task_date" class="form-control" value="{{ $employeeTask->task_date }}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="task_title" class="form-label">Task Title</label>
                                                                    <input type="text" name="task_title" id="task_title"
                                                                        class="form-control" placeholder="Task Title" value="{{ $employeeTask->task_title }}" required>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="task_description" class="form-label">Task Description</label>
                                                                     <textarea class="form-control" id="task_description" name="task_description" rows="3">{{ $employeeTask->task_description }}</textarea>
                                                                </div>

                                                                <div class="col-md-12 mb-3">
                                                                    <label for="sector" class="form-label">Planned / Unplanned </label>
                                                                    <select name="planned_type" id="planned_type" class="form-select"
                                                                        required>
                                                                         <option value="planned" {{ $employeeTask->planned_type == 'planned' ? 'selected' : '' }}>Planned</option>
                                                                        <option value="unplanned" {{ $employeeTask->planned_type == 'unplanned' ? 'selected' : '' }}>Unplanned</option>

                                                                    </select>
                                                                 </div>
                                                                 <div id="plannedFieldsContainer"></div>   

                                                                  <div class="col-md-6 mb-3">
                                                                    <label for="actual_start_time" class="form-label">Actual Start Time</label>
                                                                    <input type="time" name="actual_start_time" id="actual_start_time" class="form-control" value="{{ $employeeTask->actual_start_time }}" required>
                                                                </div>
                                                                 <div class="col-md-6 mb-3">
                                                                    <label for="actual_end_time" class="form-label">Actual End Time</label>
                                                                    <input type="time" name="actual_end_time" id="actual_end_time" class="form-control" value="{{ $employeeTask->actual_end_time }}" required>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="hours_worked" class="form-label">Hours Worked</label>
                                                                    <input type="number" name="hours_worked" id="hours_worked" class="form-control" placeholder="Hours Worked" value="{{ $employeeTask->hours_worked }}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="estimated_hours" class="form-label">Estimated Hours</label>
                                                                    <input type="number" name="estimated_hours" id="estimated_hours" class="form-control" placeholder="Estimated Hours" value="{{ $employeeTask->estimated_hours }}" required>
                                                                </div>


                                                                 <div class="col-md-6 mb-3">
                                                                    <label for="location" class="form-label">Location</label>
                                                                    <input type="text" name="location" id="location" class="form-control" placeholder="Location" value="{{ $employeeTask->location }}" required>
                                                                </div>

                        
                                            

                                                            </div>
                                                            <!-- Description -->

                                                        </div>
                                                    </div>
                                                    <!-- /Product Information -->


                                                     <!-- Product Information -->
                                                    <div class="card mb-6">
                                                        <div class="card-header">
                                                            <h5 class="card-tile mb-0">Performance Linkage</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">

                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label">Select KPA</label>
                                                                    <select id="kpa_id" name="kpa_id" class="select2 form-select">
                                                                        <option value="">Select KPA</option>
                                                                        @foreach($kpas as $kpa)
                                                                            <option value="{{ $kpa->id }}" {{ $employeeTask->kpa_id == $kpa->id ? 'selected' : '' }}>{{ $kpa->performance_area }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>  

                                                                 <div class="col-md-12 mb-3">
                                                                        <label class="form-label">Select KPI</label>
                                                                        <select class="select2 form-select kpi-select" name="kpi_id"  id="kpi_id">
                                                                        </select>
                                                                    </div>
                                                                <div class="col-md-12 mb-3">
                                                                        <label class="form-label">Select KPI Indicator</label>
                                                                        <select class="select2 form-select indicator-select" name="indicator_id" id="indicator_id">
                                                                        </select>
                                                                </div>     

                                                                
                                                                {{-- GOALS --}}
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label">Select Goals</label>

                                                                    <select id="goal_id" class="form-select" name="goal_id">
                                                                        @foreach($goals as $goal)
                                                                            <option value="{{ $goal->id }}"  {{ $employeeTask->goal_id == $goal->id ? 'selected' : '' }}>{{ $goal->goal_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>


                        
                                            

                                                            </div>
                                                            <!-- Description -->

                                                        </div>
                                                    </div>
                                                    <!-- /Product Information -->

                                                      <!-- Product Information -->
                                                    <div class="card mb-6">
                                                        <div class="card-header">
                                                            <h5 class="card-tile mb-0">Progress & Output</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="self_completion" class="form-label">Self Completion %</label>
                                                                    <input type="number" name="self_completion" id="self_completion" class="form-control" placeholder="Estimated Hours" value="{{ $employeeTask->self_completion }}" min="0" max="100" required>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select name="status" id="status" class="form-select"
                                                                        required>
                                                                         <option value="Planned" {{ $employeeTask->status == 'Planned' ? 'selected' : '' }}>Planned</option>
                                                                        <option value="In Progress" {{ $employeeTask->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                                        <option value="Completed" {{ $employeeTask->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                                        <option value="Pending Verification" {{ $employeeTask->status == 'Pending Verification' ? 'selected' : '' }}>Pending Verification</option>
                                                                        <option value="Rejected" {{ $employeeTask->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>

                                                                    </select>
                                                                 </div>   

                                                                
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="output_deliverables" class="form-label">Output / Deliverables</label>
                                                                     <textarea class="form-control" id="output_deliverables" name="output_deliverables" rows="3">{{ $employeeTask->output_deliverables }}</textarea>
                                                                </div>

                                                                <div class="col-md-12 mb-3">

                                                                    <label for="attachment" class="form-label">
                                                                        Attachment
                                                                    </label>

                                                                    <input
                                                                        class="form-control"
                                                                        type="file"
                                                                        id="attachment"
                                                                        name="attachment">

                                                                    @if($employeeTask->attachment)

                                                                        @php

                                                                            $extension = pathinfo(
                                                                                $employeeTask->attachment,
                                                                                PATHINFO_EXTENSION
                                                                            );

                                                                            $imageExtensions = [
                                                                                'jpg',
                                                                                'jpeg',
                                                                                'png',
                                                                                'gif',
                                                                                'webp'
                                                                            ];

                                                                        @endphp

                                                                        <div class="mt-3">

                                                                            {{-- IMAGE PREVIEW --}}

                                                                            @if(in_array(strtolower($extension), $imageExtensions))

                                                                                <img src="{{ asset('storage/'.$employeeTask->attachment) }}" alt="Attachment" class="img-thumbnail previewImage" width="120" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#imagePreviewModal">

                                                                            @else

                                                                                {{-- DOWNLOAD BUTTON --}}

                                                                                <a href="{{ asset('storage/'.$employeeTask->attachment) }}"
                                                                                class="btn btn-primary"
                                                                                download>

                                                                                    Download Attachment

                                                                                </a>

                                                                            @endif

                                                                        </div>

                                                                    @endif

                                                                </div>

                        
                                            

                                                            </div>
                                                            <!-- Description -->

                                                        </div>
                                                    </div>
                                                    <!-- /Product Information -->


                                                </div>
                                                <!-- /Second column -->

                                                <!-- Second column -->
                                                <div class="col-12 col-lg-4">
                                                    <!-- Pricing Card -->
                                                    <div class="card mb-6">
                                                        <div class="card-header">
                                                            <h5 class="card-title mb-0">Employee Information</h5>
                                                        </div>
                                                        <div class="card-body">

                                                          <div class="mb-6">
                                                            <label class="form-label" for="employee_name">Employee Name</label>
                                                            <input type="text" class="form-control" id="" placeholder="Employee Name" value="{{ auth()->user()->name }}"  readonly>
                                                          </div>

                                                           <div class="mb-6">
                                                            <label class="form-label" for="employee_id">Employee ID</label>
                                                            <input type="text" class="form-control"  placeholder="Employee ID" value="{{ auth()->user()->employee_id }}"  readonly>
                                                          </div>

                                                          <div class="mb-6">
                                                            <label class="form-label" for="department">Department</label>
                                                            <input type="text" class="form-control"  placeholder="Department"   value="{{ auth()->user()->department }}"  readonly>
                                                          </div>


                                                        </div>
                                                        
                                                    </div>



                                                      <!-- Pricing Card -->
                                                    <div class="card mb-3">
                                                        <div class="card-header">
                                                            <h5 class="card-title mb-0">Classification</h5>
                                                        </div>
                                                        <div class="card-body">

                                                           <div class="mb-6">
                                                                    <label for="nature_of_task" class="form-label">Nature of Task</label>
                                                                    <select name="nature_of_task" class="select2 form-select nature_of_task"
                                                                        required>
                                                                        <option value="">-- Select Nature of Task --</option>
                                                                        <option value="Strategic" {{ $employeeTask->nature_of_task == 'Strategic' ? 'selected' : '' }}>Strategic</option>
                                                                        <option value="Managerial" {{ $employeeTask->nature_of_task == 'Managerial' ? 'selected' : '' }}>Managerial</option>
                                                                        <option value="Operational" {{ $employeeTask->nature_of_task == 'Operational' ? 'selected' : '' }}>Operational</option>
                                                                        <option value="Project-Based" {{ $employeeTask->nature_of_task == 'Project-Based' ? 'selected' : '' }}>Project-Based</option>
                                                                        <option value="Compliance" {{ $employeeTask->nature_of_task == 'Compliance' ? 'selected' : '' }}>Compliance</option>
                                                                        <option value="Analytical" {{ $employeeTask->nature_of_task == 'Analytical' ? 'selected' : '' }}>Analytical</option>
                                                                        <option value="Communication" {{ $employeeTask->nature_of_task == 'Communication' ? 'selected' : '' }}>Communication</option>
                                                                        <option value="Service Delivery" {{ $employeeTask->nature_of_task == 'Service Delivery' ? 'selected' : '' }}>Service Delivery</option>
                                                                        <option value="Improvement & Innovation" {{ $employeeTask->nature_of_task == 'Improvement & Innovation' ? 'selected' : '' }}>Improvement & Innovation</option>
                                                                        <option value="Monitoring & Control" {{ $employeeTask->nature_of_task == 'Monitoring & Control' ? 'selected' : '' }}>Learning & Development</option>
                                                                        <option value="Administrative" {{ $employeeTask->nature_of_task == 'Administrative' ? 'selected' : '' }}>Administrative</option>

                                                                    </select>
                                                                </div>

                                                            <div class="mb-6">
                                                                    <label for="priority" class="form-label">Priority</label>
                                                                    <select name="priority" class="form-select priority"
                                                                        required>
                                                                        <option value="">-- Select Priority --</option>
                                                                        <option value="Critical" {{ $employeeTask->priority == 'Critical' ? 'selected' : '' }}>Critical</option>
                                                                        <option value="High" {{ $employeeTask->priority == 'High' ? 'selected' : '' }}>High</option>
                                                                        <option value="Medium" {{ $employeeTask->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                                        <option value="Low" {{ $employeeTask->priority == 'Low' ? 'selected' : '' }}>Low</option>

                                                                    </select>
                                                                </div>

                                                          <div class="mb-6">
                                                                    <label for="ownership" class="form-label">Ownership</label>
                                                                    <select name="ownership" class="form-select ownership"
                                                                        required>
                                                                        <option value="">-- Select Ownership --</option>
                                                                        <option value="Individual" {{ $employeeTask->ownership == 'Individual' ? 'selected' : '' }}>Individual</option>
                                                                        <option value="Departmental" {{ $employeeTask->ownership == 'Departmental' ? 'selected' : '' }}>Departmental</option>
                                                                        <option value="Cross-Functional" {{ $employeeTask->ownership == 'Cross-Functional' ? 'selected' : '' }}>Cross-Functional</option>
                                                                        <option value="University-Wide" {{ $employeeTask->ownership == 'University-Wide' ? 'selected' : '' }}>University-Wide</option>

                                                                    </select>
                                                                </div>


                                                        </div>
                                                        
                                                    </div>

                                                    
                                                    <!-- /Pricing Card -->
                                                    <div class="text-end">
                                                        <button type="submit"
                                                            class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                                                    </div>

                                                </div>
                                                <!-- /Second column -->
                                            </div>
                                        </form>

                                    </div>
                                    <!-- /first tab-->
                    


                </div>
                <!-- /main tab-->

            </div>
            <!-- tab open-->
        </div>



        <!-- / close new design -->
<div class="modal fade"
     id="imagePreviewModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Attachment Preview
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <img
                    src="{{ asset('storage/'.$employeeTask->attachment) }}"
                    class="img-fluid rounded">

            </div>

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
     <script>
function loadPlannedFields(type, startDate = '', endDate = '')
{
    $('#plannedFieldsContainer').html('');

    if (type == 'planned') {

        let fields = `

            <div class="col-md-12 mb-3">

                <label class="form-label">
                    Planned Start Date
                </label>

                <input
                    type="date"
                    name="planned_start_date"
                    class="form-control"
                    value="${startDate}"
                    required>

            </div>

            <div class="col-md-12 mb-3">

                <label class="form-label">
                    Planned End Date
                </label>

                <input
                    type="date"
                    name="planned_end_date"
                    class="form-control"
                    value="${endDate}"
                    required>

            </div>
        `;

        $('#plannedFieldsContainer').append(fields);
    }
}

        $(document).ready(function () {

    $('#kpa_id, #kpi_id, #indicator_id').select2({
        width: '100%'
    });

    // =========================================
    // SELECTED VALUES FOR EDIT
    // =========================================

    let selectedKpa       = $('#kpa_id').val();

    let selectedKpi       = "{{ $employeeTask->kpi_id ?? '' }}";

    let selectedIndicator = "{{ $employeeTask->indicator_id ?? '' }}";


    // =========================================
    // LOAD KPI CATEGORIES
    // =========================================

    function loadKpis(kpaId, selectedKpi = '')
    {
        if (!kpaId) {

            $('#kpi_id').html(
                '<option value="">Select KPI</option>'
            );

            return;
        }

        $.ajax({

            url: "{{ route('indicators.categories', ':kpaId') }}"
                    .replace(':kpaId', kpaId),

            type: 'GET',

            success: function (response) {

                let options =
                    '<option value="">Select KPI</option>';

                $.each(response, function (i, item) {

                    let selected = '';

                    if (selectedKpi == item.id) {

                        selected = 'selected';
                    }

                    options += `
                        <option value="${item.id}" ${selected}>
                            ${item.indicator_category}
                        </option>
                    `;
                });

                $('#kpi_id')
                    .html(options)
                    .trigger('change');


                // AUTO LOAD INDICATORS ON EDIT
                if (selectedKpi) {

                    loadIndicators(
                        selectedKpi,
                        selectedIndicator
                    );
                }
            }
        });
    }


    // =========================================
    // LOAD INDICATORS
    // =========================================

    function loadIndicators(categoryId, selectedIndicator = '')
    {
        if (!categoryId) {

            $('#indicator_id').html(
                '<option value="">Select Indicator</option>'
            );

            return;
        }

        $.ajax({

            url: "{{ route('indicator.getIndicators') }}",

            type: 'POST',

            data: {
                _token: '{{ csrf_token() }}',
                category_ids: [categoryId]
            },

            success: function (response) {

                let options =
                    '<option value="">Select Indicator</option>';

                $.each(response, function (i, item) {

                    let selected = '';

                    if (selectedIndicator == item.id) {

                        selected = 'selected';
                    }

                    options += `
                        <option value="${item.id}" ${selected}>
                            ${item.indicator}
                        </option>
                    `;
                });

                $('#indicator_id')
                    .html(options)
                    .trigger('change');
            }
        });
    }


    // =========================================
    // KPA CHANGE EVENT
    // =========================================

    $('#kpa_id').on('change', function () {

        let kpaId = $(this).val();

        $('#indicator_id').html(
            '<option value="">Select Indicator</option>'
        );

        loadKpis(kpaId);
    });


    // =========================================
    // KPI CHANGE EVENT
    // =========================================

    $('#kpi_id').on('change', function () {

        let categoryId = $(this).val();

        loadIndicators(categoryId);
    });


    // =========================================
    // AUTO LOAD DATA ON EDIT PAGE
    // =========================================

    if (selectedKpa) {

        loadKpis(selectedKpa, selectedKpi);
    }




    let selectedType = $('#planned_type').val();

    let plannedStartDate =
        "{{ $employeeTask->planned_start_date ?? '' }}";

    let plannedEndDate =
        "{{ $employeeTask->planned_end_date ?? '' }}";

    loadPlannedFields(
        selectedType,
        plannedStartDate,
        plannedEndDate
    );
        $('#planned_type').change(function () {

        let type = $(this).val();

        loadPlannedFields(type,plannedStartDate,
        plannedEndDate);
    });

     $('#actual_start_time, #actual_end_time').on('change', function () {

        let startTime = $('#actual_start_time').val();

        let endTime = $('#actual_end_time').val();

        if (startTime && endTime) {

            let start = new Date('2000-01-01 ' + startTime);

            let end = new Date('2000-01-01 ' + endTime);

            let diff = (end - start) / 1000 / 60 / 60;

            if (diff < 0) {

                diff = 0;
            }

            $('#hours_worked').val(diff.toFixed(2));

        }
    });

            let goals = @json($goals);
            let kpiCategories = [];

            $('#goalSelector').select2({
                placeholder: "Select Goals",
                width: '100%'
            });

            
$('#researchForm').submit(function(e){

    e.preventDefault();

    let form = $('#researchForm');

    let formData = new FormData(this);

    // IMPORTANT FOR RESOURCE UPDATE

    formData.append('_method', 'PUT');

    form.find('.invalid-feedback').remove();

    form.find('.is-invalid').removeClass('is-invalid');

    $.ajax({

        url: "{{ route('employee-tasks.update',$employeeTask->id) }}",

        type: "POST",

        data: formData,

        processData: false,

        contentType: false,

        success:function(response){

            Swal.fire({

                icon:'success',

                title:response.message,

                timer:1500,

                showConfirmButton:false
            });

            setTimeout(function(){

                window.location.href =
                "{{ route('employee-tasks.index') }}";

            },1500);
        },

        error:function(xhr){

            if(xhr.status === 422){

                let errors = xhr.responseJSON.errors;

                $.each(errors, function(key, value){

                    let field = $('[name="'+key+'"]');

                    field.addClass('is-invalid');

                    field.after(
                        '<div class="invalid-feedback">'
                        + value[0] +
                        '</div>'
                    );
                });
            }
        }
    });
});

            

           

        });
    </script>
@endpush
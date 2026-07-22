@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="container-xxl py-4">

        <div class="card shadow border-0">

            <div class="card-header text-white">
                <h4 class="mb-0">Assign KPI to Dimensions</h4>
            </div>

            <div class="card-body">

                <form id="mappingForm">
                    @csrf
                    @method('PUT')

                    {{-- KPA --}}
                    <div class="mb-3">
                        <label class="form-label">Select Role</label>
                        <select id="role_id" name="role_id" class="form-select">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"{{ $assignment->role_id == $role->id ? 'selected' : '' }}> {{ $role->name }}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <div id="selectedEmployees" class="mt-2"></div>

                    <div id="employeeInputs"></div>
                    <div class="mb-3">
                        <label class="form-label">Select KPA</label>
                        <select id="kpa_id" name="kpa_id" class="form-select">
                            <option value="">Select KPA</option>
                            @foreach($kpas as $kpa)
                                <option value="{{ $kpa->id }}"{{ $assignment->kpa_id == $kpa->id ? 'selected' : '' }}>{{ $kpa->performance_area }}</option>
                            @endforeach
                        </select>
                    </div>
                      <div class="col-md-12 mb-3">
                        <label class="form-label">Select KPI</label>
                        <select class="select2 form-select kpi_id" name="kpi_id" id="kpi_id">
                        </select>
                    </div>

                    {{-- GOALS --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Goals</label>

                        <select id="goalSelector" class="form-select" name="goal_id[]" multiple>
                            @foreach($goals as $goal)
                                <option value="{{ $goal->id }}">{{ $goal->goal_name }}</option>
                            @endforeach
                        </select>

                        <small class="text-muted">Select multiple goals</small>
                    </div>

                    <hr>

                    <div id="goalContainer"></div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-5">
                            Save KPI Mapping
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <div class="modal fade" id="employeeModal" tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5>Select Employees</h5>

                        <button class="btn-close" data-bs-dismiss="modal"></button>

                    </div>

                    <div class="modal-body">

                        <input
                            type="text"
                            class="form-control mb-3"
                            id="employeeSearch"
                            placeholder="Search employee...">

                        <div id="employeeList" style="max-height:450px;overflow:auto"></div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-primary"
                            id="saveEmployees">
                            Done
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection
@push('script')

    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>

    <script>
        $(document).ready(function () {

        //==========================================
        // Existing Assignment Data
        //==========================================

        let goals = @json($goals);

        let assignment = @json($assignment);

        let kpiCategories = [];

        let selectedRole = assignment.role_id;

        let selectedKpa = assignment.kpa_id;

        let selectedCategory = assignment.kpa_cid;

        let selectedEmployees = assignment.users.map(function(item){
            return item.user_id.toString();
        });

        let selectedGoals = [];

        assignment.details.forEach(function(detail){

            if(!selectedGoals.includes(detail.goal_id.toString())){

                selectedGoals.push(detail.goal_id.toString());

            }

        });

        //==========================================
        // Select2
        //==========================================

        $('#goalSelector').select2({
            placeholder: "Select Goals",
            width: "100%"
        });

        $('#kpi_id').select2({
            placeholder: "Select KPI",
            width: "100%"
        });

        //==========================================
        // Set Existing Values
        //==========================================

        $('#role_id').val(selectedRole);

        $('#kpa_id').val(selectedKpa);

        $('#goalSelector').val(selectedGoals).trigger('change');
        loadEmployees(selectedRole);

            //==========================================
    // Load KPI Categories
    //==========================================

    $('#kpa_id').on('change', function () {

        let kpaId = $(this).val();

        $('#kpi_id').html('<option value="">Loading...</option>');

        if (!kpaId) {

            $('#kpi_id').html('<option value="">Select KPI</option>');

            return;

        }

        $.ajax({

            url: "{{ route('indicators.categories', ':id') }}"
                .replace(':id', kpaId),

            type: "GET",

            success: function (response) {

                let options = '<option value="">Select KPI</option>';

                $.each(response, function(index, item){

                    options += `
                        <option value="${item.id}">
                            ${item.indicator_category}
                        </option>
                    `;

                });

                $('#kpi_id').html(options);

                $('#kpi_id')
                    .val(selectedCategory)
                    .trigger('change');

            },

            error:function(){

                $('#kpi_id').html(
                    '<option value="">No KPI Found</option>'
                );

            }

        });

    });

            

                //==========================================
    // Load Indicators
    //==========================================

    $('#kpi_id').on('change', function () {

        let categoryId = $(this).val();

        kpiCategories = [];

        if (!categoryId) {

            $('.kpi-select').html('');

            return;

        }

        $.ajax({

            url: "{{ route('indicator.getIndicators') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                category_ids: [categoryId]

            },

            success:function(response){

                kpiCategories = response;

                let options='<option value="">Select Indicator</option>';

                $.each(response,function(i,item){

                    options += `
                        <option value="${item.id}">
                            ${item.indicator}
                        </option>
                    `;

                });

                $('.kpi-select').html(options);

                $('.kpi-select').trigger('change');

            }

        });

    });

    //==========================================
    // Auto Load Existing Data
    //==========================================

    $('#kpa_id').trigger('change');
    loadEmployees(selectedRole);
    setTimeout(function(){

    $('#goalSelector')
        .val(selectedGoals)
        .trigger('change');

},500);
    
    //==========================================
// BUILD GOALS (EDIT MODE)
//==========================================

$('#goalSelector').on('change', function () {

    let goalIds = $(this).val();

    $('#goalContainer').html('');

    if (!goalIds || goalIds.length === 0) {
        return;
    }

    goalIds.forEach(function (goalId) {

        let goal = goals.find(g => g.id == goalId);

        if (!goal) return;

        let html = `
            <div class="card shadow-sm mb-4 border-0">

                <div class="card-header bg-primary text-white">
                    <strong>${goal.goal_name}</strong>
                </div>

                <div class="card-body">
        `;

        goal.objectives.forEach(function (obj) {

            html += `
                <div class="alert alert-success py-2 mb-3">
                    <strong>Objective:</strong> ${obj.title}
                </div>
            `;

            obj.dimensions.forEach(function (dim) {

                //-------------------------------------------------
                // Existing Detail
                //-------------------------------------------------

                let detail = assignment.details.find(function (d) {

                    return (
                        d.goal_id == goal.id &&
                        d.objective_id == obj.id &&
                        d.dimension_id == dim.id
                    );

                });

                let target = '';

                let weight = '';

                let selectedIndicators = [];

                if (detail) {

                    target = detail.dimension_target  ?? '';

                    weight = detail.dimension_weight  ?? '';

                    detail.indicators.forEach(function (item) {

                        selectedIndicators.push(
                            item.indicator_id.toString()
                        );

                    });

                }

                //-------------------------------------------------
                // Indicator Options
                //-------------------------------------------------

                let options = '';

                $.each(kpiCategories, function (i, item) {

                    let selected = selectedIndicators.includes(item.id.toString())
                        ? 'selected'
                        : '';

                    options += `
                        <option value="${item.id}" ${selected}>
                            ${item.indicator}
                        </option>
                    `;

                });

                //-------------------------------------------------

                html += `

                    <div class="row border rounded p-3 mb-3">

                        <div class="col-md-12 mb-2">

                            <h6 class="text-primary">
                                ${dim.name}
                            </h6>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Target
                            </label>

                            <input
                                type="number"
                                class="form-control target"
                                value="${target}"
                                name="goals[${goal.id}][objectives][${obj.id}][dimensions][${dim.id}][target]">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Weight
                            </label>

                            <input
                                type="number"
                                class="form-control weight"
                                value="${weight}"
                                name="goals[${goal.id}][objectives][${obj.id}][dimensions][${dim.id}][weight]">

                        </div>

                        <div class="col-md-12 mt-3">

                            <label class="form-label">
                                KPI Indicators
                            </label>

                            <select
                                multiple
                                class="form-select kpi-select"
                                name="goals[${goal.id}][objectives][${obj.id}][dimensions][${dim.id}][kpis][]">

                                ${options}

                            </select>

                        </div>

                    </div>

                `;

            });

        });

        html += `</div></div>`;

        $('#goalContainer').append(html);

    });

    //----------------------------------------------------
    // Select2
    //----------------------------------------------------

    $('.kpi-select').select2({

        placeholder: 'Select Indicator',

        width: '100%'

    });

});


   function loadEmployees(roleId){

    $.ajax({

        url: "/roles/" + roleId + "/employees",

        type: "GET",

        success:function(users){

            let html='';

            users.forEach(function(user){

                let checked = selectedEmployees.includes(user.id.toString())
                    ? 'checked'
                    : '';

                html += `
                <div class="employee-item mb-2">

                    <div class="form-check">

                        <input
                            type="checkbox"
                            class="form-check-input employee-checkbox"
                            id="emp_${user.id}"
                            value="${user.id}"
                            ${checked}>

                        <label class="form-check-label" for="emp_${user.id}">
                            <strong>${user.name}</strong><br>
                            <small>${user.email}</small>
                        </label>

                    </div>

                </div>
                `;
            });

            $('#employeeList').html(html);

            renderSelectedEmployees();

        }

    });

}
//==========================================
// EMPLOYEE SECTION (EDIT MODE)
//==========================================

function renderSelectedEmployees(){

    $('#selectedEmployees').html('');

    $('#employeeInputs').html('');

    selectedEmployees = [...new Set(selectedEmployees)];

    selectedEmployees.forEach(function(id){

        let checkbox = $('#emp_'+id);

        if(checkbox.length){

            let name = checkbox.closest('.employee-item')
                               .find('strong')
                               .text();

            $('#selectedEmployees').append(`
                <span class="badge bg-success me-2 mb-2">
                    ${name}
                </span>
            `);

        }

        $('#employeeInputs').append(`
            <input type="hidden"
                   name="employee_ids[]"
                   value="${id}">
        `);

    });

}

//==========================================
// ROLE CHANGE
//==========================================

$('#role_id').on('change', function () {
     selectedEmployees = [];
     loadEmployees($(this).val());


   new bootstrap.Modal(
        document.getElementById('employeeModal')
    ).show();
    $.ajax({

        url: "/roles/" + roleId + "/employees",

        type: "GET",

        success: function (users) {

            let html = '';

            users.forEach(function (user) {

                let checked = selectedEmployees.includes(
                    user.id.toString()
                ) ? 'checked' : '';

                html += `

                    <div class="employee-item mb-2">

                        <div class="form-check">

                            <input
                                class="form-check-input employee-checkbox"
                                id="emp_${user.id}"
                                type="checkbox"
                                value="${user.id}"
                                ${checked}>

                            <label
                                class="form-check-label"
                                for="emp_${user.id}">

                                <strong>${user.name}</strong><br>

                                <small>${user.email}</small>

                            </label>

                        </div>

                    </div>

                `;

            });

            $('#employeeList').html(html);

            renderSelectedEmployees();

            new bootstrap.Modal(
                document.getElementById('employeeModal')
            ).show();

        }

    });

});

//==========================================
// SEARCH
//==========================================

$('#employeeSearch').keyup(function () {

    let value = $(this).val().toLowerCase();

    $('.employee-item').filter(function () {

        $(this).toggle(

            $(this).text()
                .toLowerCase()
                .indexOf(value) > -1

        );

    });

});

//==========================================
// SAVE EMPLOYEES
//==========================================

$('#saveEmployees').click(function () {

    selectedEmployees = [];

    $('.employee-checkbox:checked').each(function () {

        selectedEmployees.push($(this).val());

    });

    renderSelectedEmployees();

    bootstrap.Modal.getInstance(
        document.getElementById('employeeModal')
    ).hide();

});
//==========================================
// UPDATE FORM
//==========================================

$('#mappingForm').on('submit', function (e) {

    e.preventDefault();

    let isValid = true;

    $('.is-invalid').removeClass('is-invalid');

    //----------------------------------------
    // Role Validation
    //----------------------------------------

    if ($('#role_id').val() == '') {

        $('#role_id').addClass('is-invalid');

        isValid = false;

    }

    //----------------------------------------
    // KPA Validation
    //----------------------------------------

    if ($('#kpa_id').val() == '') {

        $('#kpa_id').addClass('is-invalid');

        isValid = false;

    }

    //----------------------------------------
    // KPI Category Validation
    //----------------------------------------

    if ($('#kpi_id').val() == '') {

        $('#kpi_id').addClass('is-invalid');

        isValid = false;

    }

    //----------------------------------------
    // Employee Validation
    //----------------------------------------

    if (selectedEmployees.length == 0) {

        Swal.fire({

            icon: 'warning',

            title: 'Employee Required',

            text: 'Please select at least one employee.'

        });

        return;

    }

    //----------------------------------------
    // Goal Validation
    //----------------------------------------

    if ($('#goalSelector').val() == null ||
        $('#goalSelector').val().length == 0) {

        Swal.fire({

            icon: 'warning',

            title: 'Goal Required',

            text: 'Please select at least one goal.'

        });

        return;

    }

    //----------------------------------------
    // Target Weight Indicator Validation
    //----------------------------------------

    $('.target').each(function () {

        if ($(this).val() == '') {

            $(this).addClass('is-invalid');

            isValid = false;

        }

    });

    $('.weight').each(function () {

        if ($(this).val() == '') {

            $(this).addClass('is-invalid');

            isValid = false;

        }

    });

    $('.kpi-select').each(function () {

        if ($(this).val() == null ||
            $(this).val().length == 0) {

            $(this).next('.select2')
                .find('.select2-selection')
                .css('border', '1px solid red');

            isValid = false;

        }

    });

    if (!isValid) {

        Swal.fire({

            icon: 'warning',

            title: 'Validation',

            text: 'Please fill all required fields.'

        });

        return;

    }

    //----------------------------------------
    // AJAX UPDATE
    //----------------------------------------

    $.ajax({

        url: "{{ route('goals-assign.update',$assignment->id) }}",

        type: "POST",

        data: $(this).serialize() + '&_method=PUT',

        beforeSend: function () {

            Swal.fire({

                title: 'Updating...',

                text: 'Please wait',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

        },

        success: function (response) {

            Swal.close();

            Swal.fire({

                icon: 'success',

                title: 'Success',

                text: response.message

            }).then(function () {

                window.location.href =
                    "{{ route('goals-assign.index') }}";

            });

        },

        error: function (xhr) {

            Swal.close();

            if (xhr.status == 422) {

                let errors = xhr.responseJSON.errors;

                let html = '';

                $.each(errors, function (key, value) {

                    html += value[0] + "<br>";

                });

                Swal.fire({

                    icon: 'error',

                    title: 'Validation Error',

                    html: html

                });

            } else {

                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text: xhr.responseJSON.message

                });

            }

        }

    });

});

        });
    </script>

@endpush
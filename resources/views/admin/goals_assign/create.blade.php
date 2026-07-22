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

                    {{-- KPA --}}
                    <div class="mb-3">
                        <label class="form-label">Select Role</label>
                        <select id="role_id" name="role_id" class="form-select" required>
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="selectedEmployees" class="mt-2"></div>

                    <div id="employeeInputs"></div>
                    <div class="mb-3">
                        <label class="form-label">Select KPA</label>
                        <select id="kpa_id" name="kpa_id" class="form-select" required>
                            <option value="">Select KPA</option>
                            @foreach($kpas as $kpa)
                                <option value="{{ $kpa->id }}">{{ $kpa->performance_area }}</option>
                            @endforeach
                        </select>
                    </div>
                      <div class="col-md-12 mb-3">
                        <label class="form-label">Select KPI</label>
                        <select class="select2 form-select kpi_id" name="kpi_id" id="kpi_id" required>
                        </select>
                    </div>

                    {{-- GOALS --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Goals</label>

                        <select id="goalSelector" class="form-select" multiple required>
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

            let goals = @json($goals);
            let kpiCategories = [];

            $('#goalSelector').select2({
                placeholder: "Select Goals",
                width: '100%'
            });

                // =========================
    // LOAD KPI CATEGORY BY KPA
    // =========================
    $('#kpa_id').on('change', function () {

        let kpaId = $(this).val();

        // Reset dropdowns
        $('#kpi_id').html('<option value="">Loading...</option>');
        $('#indicator_id').html('<option value="">Select Indicator</option>');

        if (!kpaId) {

            $('#kpi_id').html('<option value="">Select KPI</option>');
            return;
        }

        $.ajax({
            url: "{{ route('indicators.categories', ':kpaId') }}"
                    .replace(':kpaId', kpaId),

            type: 'GET',

            success: function (response) {

                let options = '<option value="">Select KPI</option>';

                $.each(response, function (i, item) {

                    options += `
                        <option value="${item.id}">
                            ${item.indicator_category}
                        </option>
                    `;
                });

                $('#kpi_id').html(options).trigger('change');
            },

            error: function () {

                $('#kpi_id').html('<option value="">No KPI Found</option>');
            }
        });
    });

            

            // =========================
            // LOAD INDICATORS BY CATEGORY
            // =========================
            $('#kpi_id').on('change', function () {

                let categoryId = $(this).val();
                kpiCategories = [];

                if (!categoryId) {
                    $('.kpi-select').html('');
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
                        kpiCategories = response;

                        let options = '<option value="">Select Indicator</option>';

                        $.each(response, function (i, item) {

                            options += `
                                <option value="${item.id}">
                                    ${item.indicator}
                                </option>
                            `;
                        });
                        $('.kpi-select').html(options).trigger('change');
                    },

                    error: function () {

                        $('.kpi-select').html('<option value="">No Indicator Found</option>');
                    }
                });
            });

            // =========================
            // BUILD DYNAMIC FORM
            // =========================
            $('#goalSelector').on('change', function () {

                let selectedGoals = $(this).val();
                $('#goalContainer').html('');

                if (!selectedGoals || selectedGoals.length === 0) return;

                selectedGoals.forEach(goalId => {

                    let goal = goals.find(g => g.id == goalId);
                    if (!goal) return;

                    let html = `
                                                        <div class="card shadow-sm mb-4 border-0">
                                                            <div class="card-header bg-primary text-white">
                                                                <strong>${goal.goal_name}</strong>
                                                            </div>
                                                            <div class="card-body">
                                                        `;

                    goal.objectives.forEach(obj => {

                        html += `<div class="mt-2 bg-label-success">Objective: ${obj.title}</div>`;

                        obj.dimensions.forEach(dim => {

                            let options = '';
                            $.each(kpiCategories, function (i, item) {
                                options += `<option value="${item.id}">${item.indicator}</option>`;
                            });

                            html += `
                                                                <div class="row align-items-center mb-3 border p-2">

                                                                    <div class="col-md-12">
                                                                        <strong>${dim.name}</strong>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label>Target</label>
                                                                        <input type="number"
                                                                            name="goals[${goal.id}][objectives][${obj.id}][dimensions][${dim.id}][target]"
                                                                            class="form-control target">
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label>Weight</label>
                                                                        <input type="number"
                                                                            name="goals[${goal.id}][objectives][${obj.id}][dimensions][${dim.id}][weight]"
                                                                            class="form-control weight">
                                                                    </div>

                                                                    <div class="col-md-12 mt-2">
                                                                        <select multiple
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

                $('.kpi-select').select2({
                    placeholder: "Select KPI",
                    width: '100%'
                });
            });

            // =========================
            // FORM SUBMIT + VALIDATION
            // =========================
            $('#mappingForm').on('submit', function (e) {

                e.preventDefault();

                let isValid = true;

                // reset errors
                $('.is-invalid').removeClass('is-invalid');

                // KPA validation
                if (!$('#kpa_id').val()) {
                    $('#kpa_id').addClass('is-invalid');
                    isValid = false;
                }

                if (!$('#kpi_id').val()) {
                    $('#kpi_id').addClass('is-invalid');
                    isValid = false;
                }

                // goal validation
                if (!$('#goalSelector').val() || $('#goalSelector').val().length === 0) {
                    alert("Select at least one goal");
                    isValid = false;
                }

                // dimension validation
                if ($('.kpi-select').length === 0) {
                    alert("Select goals first");
                    return false;
                }

                $('.kpi-select').each(function () {

                    let row = $(this).closest('.row');

                    let target = row.find('.target');
                    let weight = row.find('.weight');

                    if (!target.val()) {
                        target.addClass('is-invalid');
                        isValid = false;
                    }

                    if (!weight.val()) {
                        weight.addClass('is-invalid');
                        isValid = false;
                    }

                    if (!$(this).val() || $(this).val().length === 0) {
                        $(this).next().find('.select2-selection')
                            .css('border', '1px solid red');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    alert("Please fill all required fields");
                    return false;
                }

                // AJAX SUBMIT
                $.ajax({
                    url: "{{ route('goals-assign.store') }}",
                    type: "POST",
                    data: $(this).serialize(),

                    success: function (res) {
                        let msg = res.message || "Saved Successfully";

                        // handle skipped goals
                        if (res.skipped_goals && res.skipped_goals.length > 0) {
                            msg += "\n\n⚠ Skipped Goals: " + res.skipped_goals.join(', ');
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: msg
                        }).then(() => {

                            window.location.href =
                                "{{ route('goals-assign.index') }}";

                        });

                        $('#mappingForm')[0].reset();
                        $('#goalContainer').html('');
                        $('#goalSelector').val(null).trigger('change');
                    },

                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || "Error occurred");
                    }
                });

            });

            let selectedEmployees = [];

$('#role_id').on('change', function () {

    let roleId = $(this).val();

    $('#employeeInputs').html('');
    $('#selectedEmployees').html('');

    if (!roleId) {
        return;
    }

    $.ajax({
        url: "/roles/" + roleId + "/employees",
        type: "GET",

        success: function (users) {

            let html = '';

            users.forEach(function (user) {

                let checked = selectedEmployees.includes(user.id.toString()) ? 'checked' : '';

                html += `
                    <div class="form-check employee-item mb-2">

                        <input
                            class="form-check-input employee-checkbox"
                            type="checkbox"
                            value="${user.id}"
                            id="emp_${user.id}"
                            ${checked}
                        >

                        <label class="form-check-label" for="emp_${user.id}">
                            <strong>${user.name}</strong><br>
                            <small>${user.email}</small>
                        </label>

                    </div>
                `;

            });

            $('#employeeList').html(html);

            $('#employeeSearch').val('');

            // Bootstrap 5
            var modal = new bootstrap.Modal(document.getElementById('employeeModal'));
            modal.show();

        }
    });

});
$('#employeeSearch').on('keyup', function () {

    let value = $(this).val().toLowerCase();

    $('.employee-item').filter(function () {

        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);

    });

});
$('#saveEmployees').on('click', function () {

    selectedEmployees = [];

    $('#employeeInputs').html('');

    let badges = '';

    $('.employee-checkbox:checked').each(function () {

        let id = $(this).val();
        let name = $(this).siblings('label').find('strong').text();

        selectedEmployees.push(id);

        badges += `
            <span class="badge bg-primary me-1 mb-1">
                ${name}
            </span>
        `;

        $('#employeeInputs').append(`
            <input
                type="hidden"
                name="employee_ids[]"
                value="${id}">
        `);

    });

    $('#selectedEmployees').html(badges);

    bootstrap.Modal.getInstance(document.getElementById('employeeModal')).hide();

});

        });
    </script>

@endpush
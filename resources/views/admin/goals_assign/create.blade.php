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
                        <select id="role_id" name="role_id" class="form-select">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select KPA</label>
                        <select id="kpa_id" name="kpa_id" class="form-select">
                            <option value="">Select KPA</option>
                            @foreach($kpas as $kpa)
                                <option value="{{ $kpa->id }}">{{ $kpa->performance_area }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- GOALS --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Goals</label>

                        <select id="goalSelector" class="form-select" multiple>
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
            // LOAD KPI BY KPA
            // =========================
            $('#kpa_id').on('change', function () {

                let kpaId = $(this).val();
                kpiCategories = [];

                if (!kpaId) {
                    $('.kpi-select').html('');
                    return;
                }

                $.ajax({
                    url: "{{ route('indicators.categories', ':kpaId') }}".replace(':kpaId', kpaId),
                    type: 'GET',
                    success: function (response) {

                        kpiCategories = response;

                        let options = '';
                        $.each(response, function (i, item) {
                            options += `<option value="${item.id}">${item.indicator_category}</option>`;
                        });

                        $('.kpi-select').html(options).trigger('change');
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

                        html += `<div class="mt-2 badge bg-label-success">Objective: ${obj.title}</div>`;

                        obj.dimensions.forEach(dim => {

                            let options = '';
                            $.each(kpiCategories, function (i, item) {
                                options += `<option value="${item.id}">${item.indicator_category}</option>`;
                            });

                            html += `
                                                    <div class="row align-items-center mb-3 border p-2">

                                                        <div class="col-md-12">
                                                            <strong>${dim.name}</strong>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Target</label>
                                                            <input type="text"
                                                                name="goals[${goal.id}][objectives][${obj.id}][dimensions][${dim.id}][target]"
                                                                class="form-control target">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Weight</label>
                                                            <input type="text"
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

                        alert(msg);

                        $('#mappingForm')[0].reset();
                        $('#goalContainer').html('');
                        $('#goalSelector').val(null).trigger('change');
                    },

                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || "Error occurred");
                    }
                });

            });

        });
    </script>

@endpush
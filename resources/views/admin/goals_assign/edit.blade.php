@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="container-xxl py-4">

        <div class="card shadow border-0">

            <div class="card-header text-white">
                <h4 class="mb-0">Edit KPI Mapping</h4>
            </div>

            <div class="card-body">

                <form id="mappingForm">
                    @csrf

                    {{-- ROLE --}}
                    <div class="mb-3">
                        <label class="form-label">Select Role</label>
                        <select id="role_id" name="role_id" class="form-select">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- KPA --}}
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
                            Update KPI Mapping
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
            let existing = @json($mapped);

            // =========================
            // INIT SELECT2
            // =========================
            $('#goalSelector').select2({
                placeholder: "Select Goals",
                width: '100%'
            });

            // =========================
            // PREFILL ROLE + KPA
            // =========================
            $('#role_id').val("{{ $roleId }}");
            $('#kpa_id').val("{{ $kpaId }}");

            // =========================
            // PRESELECT GOALS
            // =========================
            let goalIds = Object.keys(existing);
            $('#goalSelector').val(goalIds).trigger('change');

            // =========================
            // KPI LOAD BY KPA
            // =========================
            $('#kpa_id').on('change', function () {

                let kpaId = $(this).val();
                kpiCategories = [];

                if (!kpaId) return;

                $.ajax({
                    url: "{{ route('indicators.categories', ':kpaId') }}".replace(':kpaId', kpaId),
                    type: 'GET',
                    success: function (response) {
                        kpiCategories = response;
                        rebuildUI();
                    }
                });
            });

            // =========================
            // MAIN UI BUILDER
            // =========================
            function rebuildUI() {

                let selectedGoals = $('#goalSelector').val();
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

                        html += `<div class="mt-2 badge bg-label-success">
                                                                    Objective: ${obj.title}
                                                                 </div>`;

                        obj.dimensions.forEach(dim => {

                            let t = '';
                            let w = '';
                            let k = [];

                            if (
                                existing[goal.id] &&
                                existing[goal.id][obj.id] &&
                                existing[goal.id][obj.id][dim.id]
                            ) {
                                t = existing[goal.id][obj.id][dim.id].dimension_target;
                                w = existing[goal.id][obj.id][dim.id].dimension_weight;
                                k = existing[goal.id][obj.id][dim.id].kpis;
                            }

                            let options = '';

                            $.each(kpiCategories, function (i, item) {

                                let selected = k.map(String).includes(String(item.id)) ? 'selected' : '';

                                options += `
                                                                    <option value="${item.id}" ${selected}>
                                                                        ${item.indicator_category}
                                                                    </option>
                                                                `;
                            });

                            html += `
                                                            <div class="row align-items-center mb-3 border p-2">

                                                                <div class="col-md-12">
                                                                    <strong>${dim.name}</strong>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>Target</label>
                                                                    <input type="text"
                                                                        value="${t}"
                                                                        name="goals[${goal.id}][objectives][${obj.id}][dimensions][${dim.id}][dimension_target]"
                                                                                                                class="form-control target">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>Weight</label>
                                                                    <input type="text"
                                                                        value="${w}"
                                                                        name="goals[${goal.id}][objectives][${obj.id}][dimensions][${dim.id}][dimension_weight]"
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
            }

            // =========================
            // EVENTS
            // =========================
            $('#goalSelector').on('change', function () {
                rebuildUI();
            });

            // =========================
            // INITIAL LOAD FIX
            // =========================
            let initialKpaId = "{{ $kpaId }}";

            if (initialKpaId) {
                $.ajax({
                    url: "{{ route('indicators.categories', ':kpaId') }}".replace(':kpaId', initialKpaId),
                    type: 'GET',
                    success: function (response) {

                        kpiCategories = response;

                        // now build UI AFTER KPIs loaded
                        rebuildUI();
                    }
                });
            }
            // =========================
            // SUBMIT UPDATE
            // =========================
            $('#mappingForm').on('submit', function (e) {

                e.preventDefault();

                $.ajax({
                    url: "{{ route('goals-assign.update-group') }}",
                    type: "POST",
                    data: $(this).serialize()
                        + '&old_role_id={{ $roleId }}'
                        + '&old_goal_id={{ $goalId }}'
                        + '&old_kpa_id={{ $kpaId }}',

                    success: function () {
                        alert("Updated Successfully");
                        window.location.href = "{{ route('goals-assign.index') }}";
                    },

                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || "Error occurred");
                    }
                });

            });

        });
    </script>

@endpush
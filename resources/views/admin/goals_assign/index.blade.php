@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
   
@endpush
@section('content')
<div class="container-xxl py-4">

@php
$goals = json_decode(json_encode([
    (object)[
        'id' => 1,
        'goal_name' => 'Deliver outcomes base data',
        'objectives' => [
            (object)[
                'id' => 11,
                'title' => 'Increase Revenue',
                'dimensions' => [
                    (object)[
                        'id' => 101,
                        'name' => 'Dimensions 1'
                    ],
                    (object)[
                        'id' => 102,
                        'name' => 'Dimensions 2'
                    ]
                ]
            ],
             (object)[
                'id' => 12,
                'title' => 'decriment Revenue',
                'dimensions' => [
                    (object)[
                        'id' => 103,
                        'name' => 'Dimensions 3'
                    ],
                    (object)[
                        'id' => 104,
                        'name' => 'Dimensions 4'
                    ]
                ]
            ]
        ]
    ],
    (object)[
        'id' => 2,
        'goal_name' => 'Service Improvement',
        'objectives' => [
            (object)[
                'id' => 21,
                'title' => 'Customer Support',
                'dimensions' => [
                    (object)[
                        'id' => 201,
                        'name' => 'Dimensions 5',
                    ]
                ]
            ]
        ]
    ]
]));
@endphp

<div class="card shadow border-0">

    <div class="card-header text-white">
        <h4 class="mb-0">Assign KPI to Dimensions</h4>
    </div>

    <div class="card-body">

        <form id="mappingForm">
            @csrf
            {{-- KPA --}}
            <div class="mb-3">
                <label class="form-label">Select KPA</label>
                <select id="kpa_id" class="form-select">
                    <option value="">Select KPA</option>
                    @foreach(\App\Models\KeyPerformanceArea::all() as $kpa)
                        <option value="{{ $kpa->id }}">
                            {{ $kpa->performance_area }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SELECT GOALS --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Select Goals</label>

                <select id="goalSelector" class="form-select" multiple>
                    @foreach($goals as $goal)
                        <option value="{{ $goal->id }}">
                            {{ $goal->goal_name }}
                        </option>
                    @endforeach
                </select>

                <small class="text-muted">
                    Select multiple goals (Ctrl / Cmd)
                </small>
            </div>

            <hr>

            {{-- DYNAMIC AREA --}}
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

    // INIT SELECT2 FOR GOAL
    $('#goalSelector').select2({
        placeholder: "Select Goals",
        width: '100%'
    });

    // ON GOAL CHANGE
    $('#goalSelector').on('change', function () {

        let selectedGoals = $(this).val();
        $('#goalContainer').html('');

        if (!selectedGoals || selectedGoals.length === 0) return;

        selectedGoals.forEach(goalId => {

            let goal = goals.find(g => g.id == goalId);
            if (!goal) return;

            let html = `
            <div class="card shadow-sm mb-4 border-0">

                <div class="card-header bg-primary text-white"><i class="icon-base ti tabler-list-details me-3"></i>
                    <strong>${goal.goal_name}</strong>
                </div>
                <div class="card-body">
            `;

            goal.objectives.forEach(obj => {

                html += `
                <div class="">

                    <div class="mt-2 badge bg-label-success">Object :${obj.title}</div>

                    <div class="">
                `;

                obj.dimensions.forEach(dim => {

                    html += `
                    <div class="row align-items-center mb-3">

                        <div class="col-md-12 mb-2 mt-2">
                            <strong>${dim.name}</strong>
                        </div>
                        <div class="col-md-6 mb-2">
                        <label class="form-label">TARGET</label>
                            <input type="text" class="form-control text-center" value="" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                        <label class="form-label">WEIGHT</label>
                            <input type="text" class="form-control text-center" value="" readonly>
                        </div>

                        <div class="col-md-12 mb-2">

                            <select multiple
                                class="form-select kpi-select"
                                name="goals[${goal.id}][objectives][${obj.id}][dimensions][${dim.id}][kpis][]">

                                @foreach(\App\Models\IndicatorCategory::all() as $kpi)
                                    <option value="{{ $kpi->id }}">
                                        {{ $kpi->indicator_category }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>
                    `;
                });

                html += `</div></div><hr>`;
            });

            html += `</div></div>`;

            $('#goalContainer').append(html);
        });

        // INIT SELECT2 FOR KPI (IMPORTANT)
        setTimeout(function () {
            $('.kpi-select').select2({
                placeholder: "Select KPI",
                width: '100%'
            });
        }, 200);

    });

});
</script>

@endpush
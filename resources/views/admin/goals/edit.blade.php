@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

<div class="card">

<div class="card-header">
    <h4>Edit Goal</h4>
</div>

<div class="card-body">

<form id="goalForm">

@csrf

{{-- GOAL --}}
<div class="row">

<div class="col-md-12 mb-3">
    <label>Goal Name</label>
    <input type="text" id="goal_name" class="form-control"
           value="{{ $goal->goal_name }}">
</div>

<div class="col-md-6 mb-3">
    <label>Goal Code</label>
    <input type="text" id="goal_cod" class="form-control"
           value="{{ $goal->goal_cod }}">
</div>

<div class="col-md-6 mb-3">
    <label>Driver</label>
    <select id="s2r_driver_id" class="form-select">
        @foreach($drivers as $driver)
            <option value="{{ $driver->id }}"
                {{ $goal->s2r_driver_id == $driver->id ? 'selected' : '' }}>
                {{ $driver->driver_name }}
            </option>
        @endforeach
    </select>
</div>

</div>

<div class="mb-3">
    <label>Goal Statement</label>
    <textarea id="goal_statement" class="form-control">{{ $goal->goal_statement }}</textarea>
</div>

<hr>

<div class="d-flex justify-content-between mb-3">
    <h5>Objectives</h5>

    <button type="button" class="btn btn-success btn-sm" id="addObjective">
        + Add Objective
    </button>
</div>

<div id="objectiveWrapper">

@foreach($goal->objectives as $i => $objective)

<div class="card mb-3 objective-box" data-index="{{ $i }}">

<div class="card-header d-flex justify-content-between">
    <strong>Objective</strong>
    <button type="button" class="btn btn-danger btn-sm removeObjective">X</button>
</div>

<div class="card-body">

<input type="text" class="form-control mb-2 objective-title"
       value="{{ $objective->title }}">

<input type="text" class="form-control mb-3 objective-cod"
       value="{{ $objective->objective_cod }}">

<div class="dimensions-wrapper">

@foreach($objective->dimensions as $j => $dimension)

<div class="dimension-box border p-2 mb-2">

<div class="row">

<div class="col-md-5">
<input type="text" class="form-control dimension-name"
       value="{{ $dimension->name }}">
</div>

<div class="col-md-5">
<input type="text" class="form-control dimension-cod"
       value="{{ $dimension->dimension_cod }}">
</div>

<div class="col-md-2">
<button type="button" class="btn btn-danger removeDimension">X</button>
</div>

</div>

</div>

@endforeach

</div>

<button type="button" class="btn btn-primary btn-sm addDimension">
    + Add Dimension
</button>

</div>

</div>

@endforeach

</div>

<div class="text-end">
<button type="submit" class="btn btn-primary">
    Update Goal
</button>
</div>

</form>

</div>

</div>

</div>

@endsection

@push('script')
<script>

$(document).ready(function () {

let objIndex = $('.objective-box').length;

// ➕ ADD OBJECTIVE
$('#addObjective').click(function () {

let html = `
<div class="card mb-3 objective-box" data-index="${objIndex}">

<div class="card-header d-flex justify-content-between">
<strong>Objective</strong>
<button type="button" class="btn btn-danger btn-sm removeObjective">X</button>
</div>

<div class="card-body">

<input type="text" class="form-control mb-2 objective-title" placeholder="Title">

<input type="text" class="form-control mb-3 objective-cod" placeholder="Code">

<div class="dimensions-wrapper"></div>

<button type="button" class="btn btn-primary btn-sm addDimension">
+ Add Dimension
</button>

</div>

</div>`;

$('#objectiveWrapper').append(html);
objIndex++;

});

// ➕ ADD DIMENSION
$(document).on('click', '.addDimension', function () {

let parent = $(this).closest('.objective-box');

let html = `
<div class="dimension-box border p-2 mb-2">

<div class="row">

<div class="col-md-5">
<input type="text" class="form-control dimension-name">
</div>

<div class="col-md-5">
<input type="text" class="form-control dimension-cod">
</div>

<div class="col-md-2">
<button type="button" class="btn btn-danger removeDimension">X</button>
</div>

</div>

</div>`;

parent.find('.dimensions-wrapper').append(html);

});

// REMOVE
$(document).on('click', '.removeObjective', function () {
$(this).closest('.objective-box').remove();
});

$(document).on('click', '.removeDimension', function () {
$(this).closest('.dimension-box').remove();
});

// SUBMIT
$('#goalForm').submit(function (e) {

    e.preventDefault();

    let errors = [];

    // ======================
    // GOAL VALIDATION
    // ======================
    if ($.trim($('#goal_name').val()) === '') {
        errors.push('Goal Name is required.');
    }

    if ($.trim($('#goal_cod').val()) === '') {
        errors.push('Goal Code is required.');
    }

    if ($('#s2r_driver_id').val() === '') {
        errors.push('S2R Driver is required.');
    }

    if ($.trim($('#goal_statement').val()) === '') {
        errors.push('Goal Statement is required.');
    }

    // ======================
    // OBJECTIVE CHECK
    // ======================
    if ($('.objective-box').length === 0) {
        errors.push('At least one Objective is required.');
    }

    let objectiveTitles = [];
    let objectiveCodes = [];

    // ======================
    // OBJECTIVE LOOP
    // ======================
    $('.objective-box').each(function (index) {

        let title = $(this).find('.objective-title').val();
        let objectiveCod = $(this).find('.objective-cod').val();

        // Required validation
        if ($.trim(title) === '') {
            errors.push('Objective #' + (index + 1) + ' Title is required.');
        }

        if ($.trim(objectiveCod) === '') {
            errors.push('Objective #' + (index + 1) + ' Code is required.');
        }

        // Duplicate validation
        if (title) {
            if (objectiveTitles.includes(title.trim())) {
                errors.push('Duplicate Objective Title: ' + title);
            } else {
                objectiveTitles.push(title.trim());
            }
        }

        if (objectiveCod) {
            if (objectiveCodes.includes(objectiveCod.trim())) {
                errors.push('Duplicate Objective Code: ' + objectiveCod);
            } else {
                objectiveCodes.push(objectiveCod.trim());
            }
        }

        // ======================
        // DIMENSION VALIDATION (FIXED)
        // ======================
        let dimensionCount = $(this).find('.dimension-box').length;

        // 🚨 MUST HAVE AT LEAST 1 DIMENSION
        if (dimensionCount === 0) {
            errors.push(
                'Objective #' + (index + 1) +
                ' must have at least ONE Dimension (Name & Code).'
            );
        }

        // Validate each dimension
        $(this).find('.dimension-box').each(function (dimIndex) {

            let dimensionName = $(this).find('.dimension-name').val();
            let dimensionCod = $(this).find('.dimension-cod').val();

            if ($.trim(dimensionName) === '') {
                errors.push(
                    'Objective #' + (index + 1) +
                    ' - Dimension #' + (dimIndex + 1) +
                    ' Name is required.'
                );
            }

            if ($.trim(dimensionCod) === '') {
                errors.push(
                    'Objective #' + (index + 1) +
                    ' - Dimension #' + (dimIndex + 1) +
                    ' Code is required.'
                );
            }

        });

    });

    // ======================
    // SHOW ERRORS
    // ======================
    if (errors.length > 0) {

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errors.join('<br>')
        });

        return false;
    }

    // ======================
    // UPDATE AJAX REQUEST
    // ======================
    $.ajax({

        url: "{{ route('goals.update', $goal->id) }}",
        type: "PUT",

        data: {
            _token: "{{ csrf_token() }}",

            goal_name: $('#goal_name').val(),
            goal_cod: $('#goal_cod').val(),
            s2r_driver_id: $('#s2r_driver_id').val(),
            goal_statement: $('#goal_statement').val(),

            objectives: getObjectivesData()
        },

        success: function () {

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Goal updated successfully'
            }).then(() => {
                window.location.href = "{{ route('goals.index') }}";
            });

        },

        error: function (xhr) {

            let msg = 'Something went wrong';

            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: msg
            });

        }

    });

});

// GET DATA
function getObjectivesData() {

let data = [];

$('.objective-box').each(function () {

let obj = {
title: $(this).find('.objective-title').val(),
objective_cod: $(this).find('.objective-cod').val(),
dimensions: []
};

$(this).find('.dimension-box').each(function () {

obj.dimensions.push({
name: $(this).find('.dimension-name').val(),
dimension_cod: $(this).find('.dimension-cod').val()
});

});

data.push(obj);

});

return data;
}

});

</script>
@endpush
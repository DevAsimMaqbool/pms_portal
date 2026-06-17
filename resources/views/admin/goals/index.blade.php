@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow border-0">

                <div class="card-header text-white">
                    <h4 class="mb-0">Create Goal</h4>
                </div>

                <div class="card-body">

                    <form id="goalForm">

                        @csrf

                        <div class="row">

                            {{-- GOAL NAME --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Goal Name</label>
                                <input type="text" id="goal_name" class="form-control" placeholder="Enter goal name">
                            </div>

                            {{-- S2R DRIVER --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">S2R Driver</label>
                                <select id="s2r_driver_id" class="form-select">
                                    <option value="">Select Driver</option>
                                    @foreach(\App\Models\S2RDriver::all() as $driver)
                                        <option value="{{ $driver->id }}">
                                            {{ $driver->driver_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        {{-- GOAL STATEMENT --}}
                        <div class="mb-3">
                            <label class="form-label">Goal Statement</label>
                            <textarea id="goal_statement" class="form-control" rows="3"
                                placeholder="Write goal description..."></textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Objectives</h5>

                            <button type="button" class="btn btn-success btn-sm" id="addObjective">
                                + Add Objective
                            </button>
                        </div>

                        <div id="objectiveWrapper"></div>

                        <hr>

                        <div class="text-end">
                            <button type="" class="btn btn-primary px-5">
                                Save Goal
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>
@endsection

@push('script')
<script>
$(document).ready(function () {

    let objIndex = 0;

    // ➕ ADD OBJECTIVE
    $('#addObjective').click(function () {

        let objHtml = `
        <div class="card mb-3 shadow-sm objective-box" data-index="${objIndex}">

            <div class="card-header d-flex justify-content-between">
                <strong>Objective</strong>
                <button type="button" class="btn btn-sm btn-danger removeObjective">Remove</button>
            </div>

            <div class="card-body">

                <input type="text"
                    name="objectives[${objIndex}][title]"
                    class="form-control mb-3"
                    placeholder="Enter objective">

                <div class="dimensions-wrapper mb-2"></div>

                <button type="button" class="btn btn-sm btn-outline-primary addDimension">
                    + Add Dimension
                </button>

            </div>

        </div>`;

        $('#objectiveWrapper').append(objHtml);
        objIndex++;
    });

    // ➕ ADD DIMENSION
    $(document).on('click', '.addDimension', function () {

        let parent = $(this).closest('.objective-box');
        let index = parent.data('index');

        let dimCount = parent.find('.dimension-box').length;

        let dimHtml = `
        <div class="border rounded p-3 mt-2 dimension-box bg-light">

            <div class="row">

                <div class="col-md-10">
                    <input type="text"
                        name="objectives[${index}][dimensions][${dimCount}][name]"
                        class="form-control"
                        placeholder="Dimension Name">
                </div>


                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger removeDimension">
                        X
                    </button>
                </div>

            </div>

        </div>`;

        parent.find('.dimensions-wrapper').append(dimHtml);
    });

    // ❌ REMOVE OBJECTIVE
    $(document).on('click', '.removeObjective', function () {
        $(this).closest('.objective-box').remove();
    });

    // ❌ REMOVE DIMENSION
    $(document).on('click', '.removeDimension', function () {
        $(this).closest('.dimension-box').remove();
    });

    // 💾 SUBMIT FORM
    $('#goalForm').submit(function (e) {

        e.preventDefault();

        $.ajax({
            url: "{{ route('goals.store') }}",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                goal_name: $('#goal_name').val(),
                s2r_driver_id: $('#s2r_driver_id').val(),
                goal_statement: $('#goal_statement').val(),
                objectives: getObjectivesData()
            },

            success: function (res) {
                alert('Goal saved successfully!');

                $('#goalForm')[0].reset();
                $('#objectiveWrapper').html('');
            },

            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Error saving goal');
            }
        });

    });

    // 🔥 CONVERT FORM TO JSON STRUCTURE
    function getObjectivesData() {

        let data = [];

        $('.objective-box').each(function () {

            let objIndex = $(this).data('index');

            let obj = {
                title: $(this).find(`input[name="objectives[${objIndex}][title]"]`).val(),
                dimensions: []
            };

            $(this).find('.dimension-box').each(function () {

                obj.dimensions.push({
                    name: $(this).find('input[name*="[name]"]').val(),
                    weight: $(this).find('input[name*="[weight]"]').val()
                });

            });

            data.push(obj);
        });

        return data;
    }

});
</script>
@endpush
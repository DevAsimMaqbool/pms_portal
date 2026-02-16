@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">

            <h5>Edit Role KPA Assignment</h5>

            <form action="{{ route('assignments.update') }}" method="POST">
                @csrf

                <div class="row g-4">

                    {{-- ROLE --}}
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select id="roleMultiple" name="user_role" class="form-select">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- KPA --}}
                    <div class="col-md-6">
                        <label class="form-label">Key Performance Area</label>
                        <select id="apkMultiple" name="key_performance_area_id[]" class="form-select select2" multiple>
                            @foreach($kfarea as $kfa)
                                <option value="{{ $kfa->id }}">
                                    {{ $kfa->performance_area }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- CATEGORY --}}
                    <div class="col-md-6">
                        <label class="form-label">Indicator Category</label>
                        <select id="indiatorCategoryMultiple" name="indicator_category_id[]" class="form-select select2" multiple>
                        </select>
                    </div>

                    {{-- INDICATOR --}}
                    <div class="col-md-6">
                        <label class="form-label">Indicator</label>
                        <select id="indiatorMultiple" name="indicators[]" class="form-select select2" multiple>
                        </select>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        UPDATE ASSIGNMENT
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
$(document).ready(function() {

    $('.select2').select2({
        placeholder: 'Select option(s)',
        allowClear: true
    });

    /* -----------------------------------------------------
       1️⃣ Load Categories when KPA changes
    ----------------------------------------------------- */
    $('#apkMultiple').on('change', function () {

        let kpaIds = $(this).val();

        $('#indiatorCategoryMultiple').empty().trigger('change');
        $('#indiatorMultiple').empty().trigger('change');

        if (!kpaIds || kpaIds.length === 0) return;

        $.ajax({
            url: "{{ route('indicatorCategory.getIndicatorCategories') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                kpa_ids: kpaIds
            },
            success: function (response) {

                let $category = $('#indiatorCategoryMultiple');
                $category.empty();

                response.forEach(function (item) {
                    $category.append(
                        new Option(item.indicator_category, item.id, false, false)
                    );
                });

                $category.trigger('change');
            }
        });
    });


    /* -----------------------------------------------------
       2️⃣ Load Indicators when Category changes
    ----------------------------------------------------- */
    $('#indiatorCategoryMultiple').on('change', function () {

        let categoryIds = $(this).val();

        $('#indiatorMultiple').empty().trigger('change');

        if (!categoryIds || categoryIds.length === 0) return;

        $.ajax({
            url: "{{ route('indicator.getIndicators') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                category_ids: categoryIds
            },
            success: function (response) {

                let $indicator = $('#indiatorMultiple');
                $indicator.empty();

                response.forEach(function (item) {
                    $indicator.append(
                        new Option(item.indicator, item.id, false, false)
                    );
                });

                $indicator.trigger('change');
            }
        });
    });


    /* -----------------------------------------------------
       3️⃣ Load Assigned Data when Role changes
    ----------------------------------------------------- */
    $('#roleMultiple').on('change', function () {

        let roleId = $(this).val();

        if (!roleId) return;

        $.ajax({
            url: "{{ route('assignments.getAssigned') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                role_id: roleId
            },
            success: function (data) {

                // 1️⃣ Set KPAs first
                $('#apkMultiple').val(data.kpas).trigger('change');

                // 2️⃣ After categories load
                setTimeout(function () {

                    $('#indiatorCategoryMultiple')
                        .val(data.categories)
                        .trigger('change');

                }, 400);

                // 3️⃣ After indicators load
                setTimeout(function () {

                    $('#indiatorMultiple')
                        .val(data.indicators)
                        .trigger('change');

                }, 800);
            }
        });

    });

});
</script>
@endpush

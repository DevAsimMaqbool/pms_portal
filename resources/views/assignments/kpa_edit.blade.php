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
                                    <option value="{{ $kfa->id }}">{{ $kfa->performance_area }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- CATEGORY --}}
                        <div class="col-md-6">
                            <label class="form-label">Indicator Category</label>
                            <select id="indiatorCategoryMultiple" name="indicator_category_id[]" class="form-select select2"
                                multiple>
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
                        <button type="submit" class="btn btn-primary">UPDATE ASSIGNMENT</button>
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

            $('.select2').select2({
                placeholder: 'Select option(s)',
                allowClear: true
            });

            // Track hierarchy
            let hierarchy = {
                categoriesByKpa: {},
                indicatorsByCategory: {}
            };

            // ----------------------
            // Load categories when KPA changes
            // ----------------------
            $('#apkMultiple').on('change', function () {
                let selectedKpas = $(this).val() || [];

                // Remove categories & indicators of unselected KPAs
                let selectedCategories = $('#indiatorCategoryMultiple').val() || [];
                let selectedIndicators = $('#indiatorMultiple').val() || [];

                for (let kpa in hierarchy.categoriesByKpa) {
                    if (!selectedKpas.includes(kpa)) {
                        let cats = hierarchy.categoriesByKpa[kpa] || [];
                        selectedCategories = selectedCategories.filter(c => !cats.includes(c));
                        cats.forEach(catId => {
                            let inds = hierarchy.indicatorsByCategory[catId] || [];
                            selectedIndicators = selectedIndicators.filter(i => !inds.includes(i));
                        });
                    }
                }

                $('#indiatorCategoryMultiple').val(selectedCategories).trigger('change');
                $('#indiatorMultiple').val(selectedIndicators).trigger('change');

                if (selectedKpas.length === 0) return;

                $.ajax({
                    url: "{{ route('indicatorCategory.getIndicatorCategories') }}",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}", kpa_ids: selectedKpas },
                    success: function (response) {
                        let $category = $('#indiatorCategoryMultiple');

                        response.forEach(item => {
                            // Append only if not exists
                            if ($category.find('option[value="' + item.id + '"]').length === 0) {
                                $category.append(new Option(item.indicator_category, item.id, false, false));
                            }

                            // Build hierarchy
                            if (!hierarchy.categoriesByKpa[item.key_performance_area_id]) {
                                hierarchy.categoriesByKpa[item.key_performance_area_id] = [];
                            }
                            if (!hierarchy.categoriesByKpa[item.key_performance_area_id].includes(String(item.id))) {
                                hierarchy.categoriesByKpa[item.key_performance_area_id].push(String(item.id));
                            }
                        });

                        $category.trigger('change');
                    }
                });
            });

            // ----------------------
            // Load indicators when Category changes
            // ----------------------
            $('#indiatorCategoryMultiple').on('change', function () {
                let selectedCategories = $(this).val() || [];

                // Remove indicators of unselected categories
                let selectedIndicators = $('#indiatorMultiple').val() || [];
                for (let cat in hierarchy.indicatorsByCategory) {
                    if (!selectedCategories.includes(cat)) {
                        let inds = hierarchy.indicatorsByCategory[cat] || [];
                        selectedIndicators = selectedIndicators.filter(i => !inds.includes(i));
                    }
                }
                $('#indiatorMultiple').val(selectedIndicators).trigger('change');

                if (selectedCategories.length === 0) return;

                $.ajax({
                    url: "{{ route('indicator.getIndicators') }}",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}", category_ids: selectedCategories },
                    success: function (response) {
                        let $indicator = $('#indiatorMultiple');

                        response.forEach(item => {
                            if ($indicator.find('option[value="' + item.id + '"]').length === 0) {
                                $indicator.append(new Option(item.indicator, item.id, false, false));
                            }

                            if (!hierarchy.indicatorsByCategory[item.indicator_category_id]) {
                                hierarchy.indicatorsByCategory[item.indicator_category_id] = [];
                            }
                            if (!hierarchy.indicatorsByCategory[item.indicator_category_id].includes(String(item.id))) {
                                hierarchy.indicatorsByCategory[item.indicator_category_id].push(String(item.id));
                            }
                        });

                        $indicator.trigger('change');
                    }
                });
            });

            // ----------------------
            // Load assigned data when Role changes
            // ----------------------
            $('#roleMultiple').on('change', function () {
                let roleId = $(this).val();
                if (!roleId) return;

                $.ajax({
                    url: "{{ route('assignments.getAssigned') }}",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}", role_id: roleId },
                    success: function (data) {
                        // Set KPAs
                        $('#apkMultiple').val(data.kpas).trigger('change');

                        // Set categories after KPAs load
                        setTimeout(function () {
                            $('#indiatorCategoryMultiple').val(data.categories).trigger('change');
                        }, 400);

                        // Set indicators after categories load
                        setTimeout(function () {
                            $('#indiatorMultiple').val(data.indicators).trigger('change');
                        }, 800);
                    }
                });
            });

        });
    </script>
@endpush
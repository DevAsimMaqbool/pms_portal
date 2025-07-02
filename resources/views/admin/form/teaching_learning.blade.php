@extends('layouts.app')
@push('style')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
@endpush
@section('content')
   <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
                
                  <!-- Multi Column with Form Separator -->
                    <div class="card mb-6">
                        <h5 class="card-header">Multi Column with Form Separator</h5>
                        <form class="card-body">
                        <h6>1. Account Details</h6>
                        <div class="row g-6">
                            <div class="col-md-6">
                            <label for="roleMultiple" class="form-label">Role</label>
                            <select id="roleMultiple" name="user_role" class="select2 form-select" multiple>
                            @foreach($kfarea as $kfa)
                              <option value="{{ $kfa->id }}">{{ $kfa->performance_area }}</option>
                            @endforeach
                            </select>
                            </div>
                             <div class="col-md-6">
                            <label for="userMultiple" class="form-label">User </label>
                            <select id="userMultiple" name="user" class="select2 form-select" multiple>
                            </select>
                            </div>
                            <div class="col-md-6">
                            <label for="apkMultiple" class="form-label">Key Performance Area </label>
                            <select id="apkMultiple" name="key_performance_area" class="select2 form-select" multiple>
                            @foreach($kfarea as $kfa)
                              <option value="{{ $kfa->id }}">{{ $kfa->performance_area }}</option>
                            @endforeach
                            </select>
                            </div>
                            <div class="col-md-6">
                            <label for="indiatorCategoryMultiple" class="form-label">Indicator Category </label>
                            <select id="indiatorCategoryMultiple" name="indicator_category" class="select2 form-select" multiple>
                            </select>
                            </div>
                            <div class="col-md-6">
                            <label for="indiatorMultiple" class="form-label">Indicator </label>
                            <select id="indiatorMultiple" name="indicator" class="select2 form-select" multiple>
                            </select>
                            </div>
                        </div>
                        <div class="pt-6">
                            <button type="submit" class="btn btn-primary me-4">Submit</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                        </form>
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
    $(document).ready(function () {
        // Initialize all
        $('#userMultiple, #roleMultiple, #apkMultiple, #indiatorCategoryMultiple, #indiatorMultiple').select2({
            placeholder: 'Select option(s)',
            allowClear: true
        });

        // On KeyPerformanceArea change
        $('#apkMultiple').on('change', function () {
            let kpaIds = $(this).val();

            $.ajax({
                url: "{{ route('indicatorCategory.getIndicatorCategories') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    kpa_ids: kpaIds
                },
                success: function (data) {
                    let $categorySelect = $('#indiatorCategoryMultiple');
                    $categorySelect.empty();

                    data.forEach(function (item) {
                        $categorySelect.append(
                            new Option(item.indicator_category, item.id, false, false)
                        );
                    });

                    $categorySelect.trigger('change');
                }
            });
        });

        // On IndicatorCategory change
        $('#indiatorCategoryMultiple').on('change', function () {
            let categoryIds = $(this).val();

            $.ajax({
                url: "{{ route('indicator.getIndicators') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    category_ids: categoryIds
                },
                success: function (data) {
                    let $indicatorSelect = $('#indiatorMultiple');
                    $indicatorSelect.empty();

                    data.forEach(function (item) {
                        $indicatorSelect.append(
                            new Option(item.indicator, item.id, false, false)
                        );
                    });

                    $indicatorSelect.trigger('change');
                }
            });
        });
    });
</script>
@endpush


@extends('layouts.app')
@push('style')

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
            <div class="row mb-6 g-6">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-datatable table-responsive card-body">
                            <h5>Comparitive Analysis</h5>
                            <div class="row g-6">
                                <div class="col-md-6">
                                    <label for="apkMultiple" class="form-label">Key Performance Area </label>
                                    <select id="apkMultiple" name="key_performance_area_id[]" class="select2 form-select">
                                        <option value="#">Select KPA</option>
                                        @foreach($kfarea as $kfa)
                                            <option value="{{ $kfa->id }}">{{ $kfa->performance_area }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="indiatorCategoryMultiple" class="form-label">Indicator Category </label>
                                    <select id="indiatorCategoryMultiple" name="indicator_category_id[]"
                                        class="select2 form-select">
                                        <option value="#">Select Category</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-6 g-6">
                <div class="col-12 col-xl-7">
                    <div class="card">
                        <div class="card-header header-elements">
                            <h5 class="card-title mb-0">My Virtue Scorecard</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart" class="chartjs" data-height="400"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-5 col-md-6">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Organization-wide Averages</h5>
                            </div>
                            <div class="badge rounded me-4 p-2" style="background-color: #FFD700;"><i
                                    class="icon-base fas fa-chart-bar fa-3x icon-lg"></i></div>

                        </div>
                        <div class="px-5 py-4 border border-start-0 border-end-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-uppercase">Virtue</p>
                                <p class="mb-0 text-uppercase">Avg.</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded me-4 p-2" style="background-color: #4169E1 !important;">
                                        <i class="icon-base fa-solid fa-balance-scale icon-lg"></i>
                                    </div>
                                    <div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Responsibility & Accountability</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0">83%</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded me-4 p-2" style="background-color: #FFD700 !important;">
                                        <i class="icon-base fa-solid fa-shield-alt icon-lg"></i>
                                    </div>
                                    <div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Honesty & Integrity</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0">85%</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded me-4 p-2" style="background-color: #B497BD !important;">
                                        <i class="icon-base fas fa-hand-holding-heart icon-lg"></i>
                                    </div>
                                    <div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Empathy and Compassion</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0">90%</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded me-4 p-2" style="background-color: #A0522D !important;">
                                        <i class="icon-base fa-solid fa-users-between-lines icon-lg"></i>
                                    </div>
                                    <div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Humility and Service</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0">89%</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded me-4 p-2" style="background-color: #556B2Fa !important;">
                                        <i class="icon-base fa-solid fa-mosque icon-lg"></i>
                                    </div>
                                    <div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">Patience and Gratitude</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0">89%</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--  Topic and Instructors  End-->
        <!-- / Content -->
@endsection
    @push('script')
        <script>
            const chartLabels = @json($labels);
            const dataset1 = @json($dataset1);
            const dataset2 = @json($dataset2);
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
                        url: "{{ route('Category.IndicatorCategories') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            kpa_ids: kpaIds
                        },
                        success: function (data) {
                            let $categorySelect = $('#indiatorCategoryMultiple');
                            $categorySelect.empty();
                            $categorySelect.append('<option value="#">Select Category</option>');
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

                });
            });
        </script>
        <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
        <script src="{{ asset('admin/assets/js/app-user-view-account.js') }}"></script>
        <!-- Vendors JS -->
        <script src="{{ asset('admin/assets/vendor/libs/moment/moment.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
        <!-- Page JS -->
        <script src="{{ asset('admin/assets/js/app-academy-dashboard.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
        <script src="{{ asset('admin/assets/js/charts-chartjs-legend.js') }}"></script>
        <script src="{{ asset('admin/assets/js/charts-chartjs.js') }}"></script>

    @endpush
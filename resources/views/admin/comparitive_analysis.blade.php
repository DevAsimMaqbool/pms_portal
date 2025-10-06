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
                                    <label for="apkMultiple" class="form-label">Key Performance Area</label>
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
                <div class="col-12 col-xl-5 col-md-6">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Indicator Averages</h5>
                            </div>
                            <div class="badge rounded me-4 p-2" style="background-color: #FFD700;"><i
                                    class="icon-base fas fa-chart-bar fa-3x icon-lg"></i></div>

                        </div>
                        <div class="px-5 py-4 border border-start-0 border-end-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-uppercase">Indicator</p>
                                <p class="mb-0 text-uppercase">Avg.</p>
                            </div>
                        </div>
                        <div class="card-body" id="indicatorList">
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-7">
                    <div class="card">
                        <div class="card-header header-elements">
                            <h5 class="card-title mb-0">Scorecard</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart" class="chartjs" data-height="400"></canvas>
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
            let barChart;
            function getColor(avg) {
                if (avg < 60) return '#FF4C4C';      // red
                if (avg < 70) return '#FFA500';      // orange
                if (avg < 80) return '#FFD700';      // yellow
                if (avg < 90) return '#4CAF50';      // green
                return '#4169E1';                    // blue
            }
            function generateFullRangeAverages(count) {
                const ranges = [
                    { min: 40, max: 59 },  // red
                    { min: 60, max: 69 },  // orange
                    { min: 70, max: 79 },  // yellow
                    { min: 80, max: 89 },  // green
                    { min: 90, max: 100 }  // blue
                ];
                const avgs = [];
                // Ensure each range appears once
                ranges.forEach(range => {
                    avgs.push(Math.floor(Math.random() * (range.max - range.min + 1)) + range.min);
                });

                // If more indicators exist, fill with random values between 55–95
                while (avgs.length < count) {
                    avgs.push(Math.floor(Math.random() * 41) + 55);
                }

                // Shuffle so colors are spread out
                return avgs.sort(() => Math.random() - 0.5);
            }
            // const chartLabels = @json($labels);
            // const dataset1 = @json($dataset1);
            // const dataset2 = @json($dataset2);
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

                            // $categorySelect.trigger('change');
                        }
                    });
                });

                // On IndicatorCategory change
                // On IndicatorCategory change
                $('#indiatorCategoryMultiple').on('change', function () {
                    let categoryIds = $(this).val();

                    $.ajax({
                        url: "{{ route('indicator.getIndicatorsForComp') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            category_ids: categoryIds
                        },
                        success: function (data) {
                            let $indicatorList = $('#indicatorList');
                            $indicatorList.empty();

                            let indicatorData = [];
                            let fullRangeAvgs = generateFullRangeAverages(data.length);

                            data.forEach(function (item, index) {
                                let avg = fullRangeAvgs[index] || Math.floor(Math.random() * 41) + 55;
                                let color = getColor(avg);

                                indicatorData.push({
                                    name: item.name,
                                    job_title: item.job_title,
                                    avg: avg,
                                    color: color
                                });
                            });

                            // 🔹 Sort descending by average (highest first)
                            indicatorData.sort((a, b) => b.avg - a.avg);

                            let indicatorNames = [];
                            let avgValues = [];
                            let colors = [];

                            indicatorData.forEach(indicator => {
                                indicatorNames.push(indicator.name);
                                avgValues.push(indicator.avg);
                                colors.push(indicator.color);

                                // Build Indicator Average list
                                $indicatorList.append(`
                <div class="d-flex justify-content-between align-items-center mb-6">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar me-4">
                            <img src="{{ asset('admin/assets/img/avatars/1.png')}}" alt="Avatar"
                                class="rounded-circle" />
                        </div>
                        <div>
                            <div>
                                <h6 class="mb-0 text-truncate">${indicator.name}</h6>
                                <small class="text-truncate text-body">${indicator.job_title}</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-0" style="color:${indicator.color}">${indicator.avg}%</h6>
                    </div>
                </div>`);
                            });

                            updateBarChart(indicatorNames, avgValues, colors);

                        }
                    });
                });


                function updateBarChart(labels, values, colors) {
                    const ctx = document.getElementById('barChart').getContext('2d');

                    if (barChart) barChart.destroy();

                    barChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Average (%)',
                                data: values,
                                backgroundColor: colors,
                                borderRadius: 10,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    grid: {
                                        drawBorder: false
                                    },
                                    ticks: {
                                        stepSize: 10,
                                        font: { size: 13 }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Average (%)'
                                    }
                                },
                                x: {
                                    ticks: {
                                        font: { size: 12 },
                                        color: '#333'
                                    },
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#111',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    callbacks: {
                                        label: ctx => `${ctx.parsed.y}%`
                                    }
                                }
                            },
                            animation: {
                                duration: 900,
                                easing: 'easeOutQuart'
                            }
                        }
                    });
                }

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
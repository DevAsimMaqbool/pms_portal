@extends('layouts.app')
@push('style')

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <style>
    .card-h{
      min-height: 90px;
     }
     </style>
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="">
            <div class="row mb-3">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-datatable table-responsive card-body">
                            <h5>Comparitive Analysis</h5>
                            <div class="row g-6">
                                <div class="col-md-6">
                                    <label for="apkMultiple" class="form-label">Key Performance Area</label>
                                    <select id="apkMultiple" name="key_performance_area_id[]" class="select2 form-select">
                                        <option value="#">Select KPA</option>
                                        @foreach($kfarea as $index => $kfa)
                                            <option value="{{ $kfa->id }}" {{ $index === 0 ? 'selected' : '' }}>{{ $kfa->performance_area }}</option>
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
            <div class="row g-6">
                {{-- <div class="col-12 col-xl-5">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Indicator Averages</h5>
                            </div>
                            <button type="button" class="btn rounded-pill btn-outline-primary waves-effect"><i class="icon-base ti tabler-buildings icon-xs me-2"></i>Org</button>

                        </div>
                        <div class="px-5 py-4 border border-start-0 border-end-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-uppercase">Employee Name</p>
                                <p class="mb-0 text-uppercase">Avg.</p>
                            </div>
                        </div>
                        <div class="card-body" id="indicatorList">
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-12 col-xl-7">
                    <div class="card h-100">
                        <div class="card-header header-elements">
                            <h5 class="card-title mb-0">Scorecard</h5>
                        </div>
                        <div class="card-body">
                            
                            <div id="barChart"></div>
                        </div>
                    </div>
                </div> --}}
      <!-- Website Analytics -->
      <div class="col-xl-6">
         <div class="card card-border-shadow-success h-100">
             <div class="card-body d-flex">
            <div class="d-flex w-70 align-items-center me-4">
              <div class="badge bg-label-success rounded p-1_5 me-4"><i class="icon-base ti tabler-arrow-up-to-arc icon-md"></i>
              </div>
              <div>
                <h6 class="mb-0 text-cut">Highest Score</h6>
                <small class="text-dark fs-10 text-cut">Department of Software Engineering</small>
              </div>
            </div>
            <div class="d-flex flex-grow-1 align-items-center justify-content-end">

              <span class="badge bg-label-success ms-1">82</span>
              <span class="badge bg-label-success ms-1">EE</span>
            </div>
          </div>
         </div>
      </div>
      <!--/ Website Analytics -->
       <!-- Website Analytics -->
      <div class="col-xl-6">
         <div class="card card-border-shadow-danger h-100">
             <div class="card-body d-flex">
            <div class="d-flex w-70 align-items-center me-4">
              <div class="badge bg-label-danger rounded p-1_5 me-4"><i class="icon-base ti tabler-arrow-up-from-arc icon-md"></i>
              </div>
              <div>
                <h6 class="mb-0 text-cut">Low Score</h6>
                <small class="text-dark fs-10 text-cut">Department of Software Engineering</small>
              </div>
            </div>
            <div class="d-flex flex-grow-1 align-items-center justify-content-end">

              <span class="badge bg-label-danger ms-1">50</span>
              <span class="badge bg-label-danger ms-1">BE</span>
            </div>
          </div>
         </div>
      </div>
      <!--/ Website Analytics -->
               <!-- Average Daily Sales -->
      <div class="col-xl-6">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h5 class="m-0 me-2">Self vs Self</h5>
            </div>
          </div>
          <div id="chart-legend" class="d-flex justify-content-center align-items-center mt-2"></div>
          <div class="card-body pt-2">
            <div id="carrierPerformance1"></div>
          </div>

        </div>
      </div>
      <!--/ Average Daily Sales -->

             <!-- Website Analytics -->
      <div class="col-xl-6 col">

        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Self vs Other</h5>

          </div>
          <div class="card-body">
            <div id="carrierPerformance"></div>
            <div id="carrierCustomLegend" class="d-flex justify-content-center flex-wrap mt-3"></div>
          </div>
        </div>
      </div>
      <!--/ Website Analytics -->
     
     
      
          <!-- Popular Instructors -->
    <div class="col-md-6 col-xxl-4 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Top Performers</h5>
          </div>
        </div>
        <div class="px-5 py-4 border border-start-0 border-end-0">
          <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0 text-uppercase">Instructors</p>
            <p class="mb-0 text-uppercase">Rating</p>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-6">
            <div class="d-flex align-items-center">
              <div class="avatar avatar me-4">
                <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
              </div>
              <div>
                <div>
                  <h6 class="mb-0 text-truncate">Haider Ali</h6>
                  <small class="text-truncate text-body">Department of Software Engineering</small>
                </div>
              </div>
            </div>
            <div class="text-end">
              <h6 class="mb-0">83</h6>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-6">
            <div class="d-flex align-items-center">
              <div class="avatar avatar me-4">
                <img src="{{ asset('admin//assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle" />
              </div>
              <div>
                <div>
                  <h6 class="mb-0 text-truncate">Sadia Ashraf</h6>
                  <small class="text-truncate text-body">Superior University Franchise</small>
                </div>
              </div>
            </div>
            <div class="text-end">
              <h6 class="mb-0">91</h6>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-6">
            <div class="d-flex align-items-center">
              <div class="avatar avatar me-4">
                <img src="{{ asset('admin/assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle" />
              </div>
              <div>
                <div>
                  <h6 class="mb-0 text-truncate">Amna Ilyas</h6>
                  <small class="text-truncate text-body">Superior University Franchise</small>
                </div>
              </div>
            </div>
            <div class="text-end">
              <h6 class="mb-0">70</h6>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-6">
            <div class="d-flex align-items-center">
              <div class="avatar avatar me-4">
                <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
              </div>
              <div>
                <div>
                  <h6 class="mb-0 text-truncate">Muhammad Ashraf</h6>
                  <small class="text-truncate text-body">Teaching</small>
                </div>
              </div>
            </div>
            <div class="text-end">
              <h6 class="mb-0">50</h6>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <div class="avatar avatar me-4">
                <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
              </div>
              <div>
                <div>
                  <h6 class="mb-0 text-truncate">Rashid Hussain</h6>
                  <small class="text-truncate text-body">Faisalabad - Uni Campus</small>
                </div>
              </div>
            </div>
            <div class="text-end">
              <h6 class="mb-0">70</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Popular Instructors -->
    <!-- Vehicles Condition -->
    <div class="col-md-6 col-xxl-4 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Top Departments</h5>
          </div>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
            <li class="d-flex mb-6">
              <div class="chart-progress me-3" data-color="success" data-series="82" data-progress_variant="true"></div>
              <div class="row w-100 align-items-center">
                <div class="col-8">
                  <div class="me-2">
                    <small>Department of Software Engineering</small>
                  </div>
                </div>
                <div class="col-4 d-flex justify-content-end">
                  <div class="badge bg-label-success">EE</div>
                </div>
              </div>
            </li>
            <li class="d-flex mb-6">
              <div class="chart-progress me-3" data-color="primary" data-series="91" data-progress_variant="true"></div>
              <div class="row w-100 align-items-center">
                <div class="col-8">
                  <div class="me-2">
                    <small>Superior University Franchise</small>
                  </div>
                </div>
                <div class="col-4 d-flex justify-content-end">
                  <div class="badge bg-label-primary">OS</div>
                </div>
              </div>
            </li>
            <li class="d-flex mb-6">
              <div class="chart-progress me-3" data-color="warning" data-series="70" data-progress_variant="true"></div>
              <div class="row w-100 align-items-center">
                <div class="col-8">
                  <div class="me-2">
                    <small class="14 Vehicles">Superior University Franchise</small>
                  </div>
                </div>
                <div class="col-4 d-flex justify-content-end">
                  <div class="badge bg-label-warning">ME</div>
                </div>
              </div>
            </li>
            <li class="d-flex mb-6">
              <div class="chart-progress me-3" data-color="danger" data-series="50" data-progress_variant="true"></div>
              <div class="row w-100 align-items-center">
                <div class="col-8">
                  <div class="me-2">
                    <small>Teaching</small>
                  </div>
                </div>
                <div class="col-4 d-flex justify-content-end">
                  <div class="badge bg-label-danger">BE</div>
                </div>
              </div>
            </li>
            <li class="d-flex">
              <div class="chart-progress me-4" data-color="warning" data-series="70" data-progress_variant="true"></div>
              <div class="row w-100 align-items-center">
                <div class="col-8">
                  <div class="me-2">
                    <small>Faisalabad - Uni Campus</small>
                  </div>
                </div>
                <div class="col-4 d-flex justify-content-end">
                  <div class="badge bg-label-warning">ME</div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--/ Vehicles Condition -->
    <!-- Active Projects -->
    <div class="col-xxl-4 col-md-6 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1">Top Faculties</h5>
          </div>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
            <li class="mb-4 d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-success rounded p-1_5 me-4"><i class="icon-base ti tabler-trophy icon-md"></i>
                 </div>
                <div>
                  <small class="text-body">Faculty of Business and Management Sciences</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">82%</span>
              </div>
            </li>
            <li class="mb-4 d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-primary rounded p-1_5 me-4"><i class="icon-base ti tabler-trophy icon-md"></i>
              </div>
                <div>
                  <small class="text-body">Faculty Of Economics and Commerce</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-primary" role="progressbar" style="width: 91%" aria-valuenow="91" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">91%</span>
              </div>
            </li>
            <li class="mb-4 d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-warning rounded p-1_5 me-4"><i class="icon-base ti tabler-award  icon-md"></i>
              </div>
                <div>
                  <small class="text-body">Faculty of Computer Science and Information Technology</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">70%</span>
              </div>
            </li>
            <li class="mb-4 d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-danger rounded p-1_5 me-4"><i class="icon-base ti tabler-trophy-off icon-md"></i>
              </div>
                <div>
                  <small class="text-body">Faculty of Social Sciences
</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">50%</span>
              </div>
            </li>
            <li class="d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-warning rounded p-1_5 me-4"><i class="icon-base ti tabler-award icon-md"></i>
              </div>
                <div>
                  <small class="text-body">Faculty of Allied Health Sciences</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">70%</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--/ Active Projects -->


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
                            data.forEach(function (item, index) {
                                // Select the first item automatically
                                let isSelected = index === 0;
                                $categorySelect.append(
                                    new Option(item.indicator_category, item.id, false, isSelected)
                                );
                            });
                            // ✅ Trigger Select2 refresh and fire change for first-time load
                            $categorySelect.trigger('change.select2').trigger('change');

                            
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
                 let $apk = $('#apkMultiple');
                let firstValue = $apk.find('option:not([value="#"])').first().val();

                if (firstValue) {
                    $apk.val(firstValue).trigger('change.select2').trigger('change');
                }

                function updateBarChart1(labels, values, colors) {
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
                function updateBarChart(labels, values, colors) {
                    // Get chart element
                    let chartEl = document.querySelector("#barChart");
                    if (!chartEl) {
                        console.error("Element #barChart not found");
                        return;
                    }

                    // Destroy previous chart if exists
                    if (barChart) {
                        barChart.destroy();
                        chartEl.innerHTML = ""; // Clear previous chart content
                    }

                    // Define ApexCharts options
                    let options = {
                        chart: {
                            height: 400,
                            type: "bar",
                            toolbar: { show: false }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                distributed: true,
                                borderRadius: 7,
                                barHeight: "60%",
                                startingShape: "rounded"
                            }
                        },
                        grid: {
                            strokeDashArray: 10,
                            borderColor: "#e9ecef",
                            xaxis: { lines: { show: true } },
                            yaxis: { lines: { show: false } },
                            padding: { top: 0, bottom: 0 }
                        },
                        colors: colors,
                        series: [
                            {
                                name: "Average (%)",
                                data: values
                            }
                        ],
                     
                        dataLabels: {
                            enabled: true,
                            style: {
                                colors: ["#fff"],
                                fontSize: "13px",
                                fontWeight: 400,
                                fontFamily: "Arial, sans-serif"
                            },
                            formatter: function (val, opts) {
                                return labels[opts.dataPointIndex];
                            },
                            offsetX: 0,
                            dropShadow: { enabled: false }
                        },
                        tooltip: {
                            enabled: true,
                            style: { fontSize: "12px" },
                            onDatasetHover: { highlightDataSeries: false },
                            custom: function ({ series, seriesIndex, dataPointIndex }) {
                                return `<div class="px-3 py-2"><span>${series[seriesIndex][dataPointIndex]}%</span></div>`;
                            }
                        },
                        legend: { show: false },
                        fill: { opacity: 1 },
                        animation: {
                            enabled: true,
                            easing: "easeout",
                            speed: 800
                        }
                    };

                    // Render the new Apex chart
                    barChart = new ApexCharts(chartEl, options);
                    barChart.render();
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
        <script>
      
    document.addEventListener("DOMContentLoaded", function () {
      const c = document.querySelector("#carrierPerformance2");
      const categories = [
        "Abdullah Tanveer",
        "Sadia Ashraf",
        "Amna Ilyas",
        "Muhammad Ashraf",
        "Rashid Hussain"
      ];
      // Distinct color for each category
      const colors = [
        "#1F77B4", // Publication
        "#9467BD", // Projects
        "#9467BD", // Commercial Gains
        "#9467BD", // Intellectual Properties
        "#9467BD"  // Spin Off
      ];
      // Lighter versions for "Achieved"
      const lightColors = [
        "#6BAED6", // lighter blue
        "#FFBB78", // lighter orange
        "#98DF8A", // lighter green
        "#C5B0D5", // lighter purple
        "#FF9896"  // lighter red
      ];
      const a = {
        chart: {
          height: 330,
          type: "bar",
          parentHeightOffset: 0,
          stacked: false,
          toolbar: { show: false },
          zoom: { enabled: false }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: "50%",
            borderRadius: 6
          }
        },
        dataLabels: { enabled: false },
        // Two series: Target & Achieved
        series: [
          {
            name: "Performance",
            data: [
              { x: "", y: 5, fillColor: colors[0] },
              { x: "", y: 7, fillColor: colors[1] },
              { x: "", y: 3, fillColor: colors[2] },
              { x: "", y: 6, fillColor: colors[3] },
              { x: "", y: 5, fillColor: colors[4] }
            ]
          }
        ],
        xaxis: {
          labels: {
            style: {
              colors: "#6E6B7B",
              fontSize: "13px",
              fontFamily: "Inter, sans-serif",
              fontWeight: 400
            }
          },
          axisBorder: { show: false },
          axisTicks: { show: false }
        },
        yaxis: {
          tickAmount: 4,
          min: 0,
          labels: {
            style: {
              colors: "#6E6B7B",
              fontSize: "13px",
              fontFamily: "Inter, sans-serif",
              fontWeight: 400
            }
          }
        },
        grid: {
          strokeDashArray: 6,
          padding: { bottom: 5 }
        },
        legend: { show: false }, // We'll make a custom legend below
        fill: { opacity: 1 },
        responsive: [
          {
            breakpoint: 1400,
            options: { chart: { height: 275 } }
          },
          {
            breakpoint: 576,
            options: { chart: { height: 300 } }
          }
        ]
      };
      if (c) {
        const chart = new ApexCharts(c, a);
        chart.render();
        // Custom category legends
        const legendContainer = document.getElementById("carrierCustomLegend2");
        categories.forEach((label, i) => {
          const item = document.createElement("div");
          item.classList.add("d-flex", "align-items-center", "mx-2", "my-1");
          item.innerHTML = `
                                                                <span style="width:14px;height:14px;background:${colors[i]};border-radius:50%;display:inline-block;margin-right:6px;"></span>
                                                                <span style="font-size:13px;color:#6e6b7b;">${label}</span>
                                                              `;
          legendContainer.appendChild(item);
        });
      }
    });
    document.addEventListener("DOMContentLoaded", function () {
      const c = document.querySelector("#carrierPerformance1");

      const options = {
        chart: {
          type: 'area',
          height: 400,
          toolbar: { show: false },
        },
        series: [
          {
            name: 'Performance',
            data: [80, 90]
          }
        ],
        xaxis: {
          categories: ['Spring 25', 'Fall 25']
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth',
          width: 2,
          dashArray: 0 // keep solid line, dotted markers only
        },
        colors: ['#008FFB'],
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.1,
            stops: [0, 90, 100]
          }
        },
        tooltip: {
          theme: 'dark'
        },
        markers: {
          size: 5,                 // size of the point
          colors: ['#008FFB'],     // fill color
          strokeColors: '#fff',    // border color
          strokeWidth: 2,          // thickness of border
          shape: 'circle',
          hover: {
            size: 7,
            sizeOffset: 2
          },
          discrete: [] // allows customization if needed later
        }
      };

      const chart = new ApexCharts(c, options);
      chart.render();
    });
    document.addEventListener("DOMContentLoaded", function () {
  const c = document.querySelector("#carrierPerformance");

  // Names (X-axis)
  const categories = [
    "Abdullah Tanveer",
    "Sadia Ashraf",
    "Amna Ilyas",
    "Muhammad Ashraf",
    "Rashid Hussain"
  ];

  // Bar colors — make Abdullah special (highlighted)
  const colors = [
    "#FF5733", // 🔥 Highlight for Abdullah
    "#1F77B4",
    "#2CA02C",
    "#9467BD",
    "#D62728"
  ];

  // Self performance data (with colors per point)
  const selfPerformance = categories.map((name, index) => {
    return {
      x: name,
      y: [5, 7, 3, 6, 5][index],
      fillColor: name === "Abdullah Tanveer" ? "#FF5733" : colors[index]
    };
  });

  const a = {
    chart: {
      height: 350,
      type: "line",
      toolbar: { show: false },
      zoom: { enabled: false }
    },
    stroke: {
      width: [0, 3],
      curve: "smooth"
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "50%",
        borderRadius: 6
      }
    },
    dataLabels: {
      enabled: true,
      enabledOnSeries: [1],
      formatter: function (val, opts) {
        const name = opts.w.config.series[0].data[opts.dataPointIndex].x;
        return name === "Abdullah Tanveer" ? `🧑🏻` : ``;
      },
      offsetY: -8,
      style: {
        fontSize: "18px",
        colors: ["#111"]
      }
    },
    series: [
      {
        name: "Self Performance",
        type: "bar",
        data: selfPerformance
      },
      {
        name: "Trend Line",
        type: "line",
        data: selfPerformance
      }
    ],
    xaxis: {
      categories: categories,
      labels: {
        rotate: -15,
        style: {
          colors: "#6E6B7B",
          fontSize: "13px",
          fontFamily: "Inter, sans-serif",
          fontWeight: 400
        }
      },
      axisBorder: { show: false },
      axisTicks: { show: false }
    },
    yaxis: {
      tickAmount: 4,
      min: 0,
      labels: {
        style: {
          colors: "#6E6B7B",
          fontSize: "13px",
          fontFamily: "Inter, sans-serif",
          fontWeight: 400
        }
      }
    },
    grid: {
      strokeDashArray: 6,
      padding: { bottom: 5 }
    },
    fill: { opacity: 1 },
    legend: { show: false },
    annotations: {
      points: [
        {
          x: "Abdullah Tanveer",
          y: 5,
          marker: {
            size: 0,
            customSVG: {
              SVG: `
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22">
                  <circle cx="11" cy="11" r="7" fill="#FF5733" stroke="#fff" stroke-width="2"/>
                  <text x="11" y="15" text-anchor="middle" font-size="10" fill="#fff">👤</text>
                </svg>
              `,
              offsetX: -10,
              offsetY: -28
            }
          }
        }
      ]
    },
    responsive: [
      {
        breakpoint: 576,
        options: { chart: { height: 300 } }
      }
    ]
  };

  // Render chart
  if (c) {
    const chart = new ApexCharts(c, a);
    chart.render();

    // Custom legend
    const legendContainer = document.getElementById("carrierCustomLegend");
    categories.forEach((label, i) => {
      const item = document.createElement("div");
      item.classList.add("d-flex", "align-items-center", "mx-2", "my-1");
      item.innerHTML = `
        <span style="width:14px;height:14px;background:${colors[i]};border-radius:50%;display:inline-block;margin-right:6px;"></span>
        <span style="font-size:13px;color:#6e6b7b;">${label}</span>
      `;
      legendContainer.appendChild(item);
    });
  }
});
        </script>
       
    @endpush
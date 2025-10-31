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
                <div class="col-12 col-xl-5">
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
                </div>

                <div class="col-12 col-xl-7">
                    <div class="card h-100">
                        <div class="card-header header-elements">
                            <h5 class="card-title mb-0">Scorecard</h5>
                        </div>
                        <div class="card-body">
                            {{-- <canvas id="barChart" class="chartjs" data-height="400"></canvas> --}}
                            <div id="barChart"></div>
                        </div>
                    </div>
                </div>

               <!-- Average Daily Sales -->
      <div class="col-xl-4 col-sm-6">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h5 class="m-0 me-2">Self vs Self</h5>
            </div>
          </div>
          <div id="chart-legend" class="d-flex justify-content-center align-items-center mt-2"></div>
          <div class="card-body pt-2">
            <canvas class="chartjs" id="virtueChart" data-height="355"></canvas>
          </div>

        </div>
      </div>
      <!--/ Average Daily Sales -->

             <!-- Website Analytics -->
      <div class="col-xl-4 col">

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

                <div class="col-4">
                    <div class="card h-100">
                        <div class="card-header header-elements">
                            <h5 class="card-title mb-0">Highest</h5>
                        </div>
                        <div class="card-body">
                            <h1>h1</h1>
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
      const chartLabels = [
        "Responsibility and Accountability",
        "Honesty and Integrity",
        "Empathy and Compassion",
        "Humility and Service",
        "Patience and Gratitude",
        "Courage and Drive"
      ];
      const dataset1 = [85, 90, 95, 85, 95, 100];
      const dataset2 = [80, 90, 75, 80, 80, 80];
      const canvas = document.getElementById("virtueChart");
      if (!canvas) return;
      const ctx = canvas.getContext("2d");

      // Create gradients for fills
      const gradientBlue = ctx.createLinearGradient(0, 0, 0, 150);
      gradientBlue.addColorStop(0, "rgba(85, 85, 255, 0.9)");
      gradientBlue.addColorStop(1, "rgba(151, 135, 255, 0.8)");
      const gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
      gradientPink.addColorStop(0, "rgba(255, 85, 184, 0.9)");
      gradientPink.addColorStop(1, "rgba(255, 135, 135, 0.8)");

      // Chart configuration
      const config = {
        type: "radar",
        data: {
          labels: chartLabels,
          datasets: [
            {
              label: "Inside Mirror",
              data: dataset1,
              fill: true,
              borderColor: "rgba(255, 85, 184, 1)",
              borderWidth: 2,
              pointBorderColor: "#FF55B8",
              pointBackgroundColor: "rgba(255, 85, 184, 1)",
              pointRadius: 5,
              pointHoverRadius: 7,
              pointStyle: 'circle'
            },
            {
              label: "Social Mirror",
              data: dataset2,
              fill: true,
              borderColor: "rgba(85, 85, 255, 1)",
              borderWidth: 2,
              pointBorderColor: "#5555FF",
              pointBackgroundColor: "rgba(85, 85, 255, 1)",
              pointRadius: 5,
              pointHoverRadius: 7,
              pointStyle: 'circle'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: { duration: 500 },
          scales: {
            r: {
              beginAtZero: true,
              suggestedMax: 100,
              ticks: { display: false },
              grid: { color: "rgba(0, 0, 0, 0.2)" },
              angleLines: { color: "rgba(200, 200, 200, 0.2)" },
              pointLabels: { color: "#9CA3AF", font: { size: 10 } }
            }
          },
          plugins: {
            legend: { display: false }, // Disable default legend
            tooltip: {
              backgroundColor: "#fff",
              titleColor: "#111827",
              bodyColor: "#111827",
              borderWidth: 1,
              borderColor: "#ddd",
              titleFont: { weight: "bold" },
              bodyFont: { size: 13 },
              padding: 10
            }
          }
        }
      };

      const myChart = new Chart(ctx, config);

      // === Custom Legend with Checkboxes ===
      const legendContainer = document.getElementById("chart-legend");
      const checkboxColors = ["#FF55B8", "#5555FF"]; // Inside Mirror, Social Mirror

      myChart.data.datasets.forEach((dataset, index) => {
        const wrapper = document.createElement("div");
        wrapper.style.display = "inline-flex";
        wrapper.style.alignItems = "center";
        wrapper.style.marginRight = "20px";
        wrapper.style.cursor = "pointer";

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.id = `dataset-${index}`;
        checkbox.checked = true;
        checkbox.style.marginRight = "6px";

        const label = document.createElement("label");
        label.setAttribute("for", `dataset-${index}`);
        label.style.color = checkboxColors[index];
        label.style.fontWeight = "500";
        label.style.fontSize = "14px";
        label.textContent = dataset.label;

        wrapper.appendChild(checkbox);
        wrapper.appendChild(label);
        legendContainer.appendChild(wrapper);

        checkbox.addEventListener("change", (e) => {
          const datasetIndex = index;
          if (e.target.checked) {
            myChart.show(datasetIndex);
          } else {
            myChart.hide(datasetIndex);
          }
        });
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      const c = document.querySelector("#carrierPerformance");
      const categories = [
        "Journal Publication",
        "Multidisciplinary Projects",
        "Commercial Gains",
        "Intellectual Properties",
        "Spin Off"
      ];
      // Distinct color for each category
      const colors = [
        "#1F77B4", // Publication
        "#FF7F0E", // Projects
        "#2CA02C", // Commercial Gains
        "#9467BD", // Intellectual Properties
        "#D62728"  // Spin Off
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
            name: "Target",
            data: [
              { x: "JP", y: 5, fillColor: colors[0] },
              { x: "MP", y: 7, fillColor: colors[1] },
              { x: "CG", y: 3, fillColor: colors[2] },
              { x: "IP", y: 6, fillColor: colors[3] },
              { x: "SO", y: 5, fillColor: colors[4] }
            ]
          },
          {
            name: "Achieved",
            data: [
              { x: "JP", y: 4, fillColor: lightColors[0] },
              { x: "MP", y: 3.5, fillColor: lightColors[1] },
              { x: "CG", y: 2, fillColor: lightColors[2] },
              { x: "IP", y: 4, fillColor: lightColors[3] },
              { x: "SO", y: 2, fillColor: lightColors[4] }
            ]
          }
        ],
        xaxis: {
          categories: ["JP", "MP", "CG", "IP", "SO"],
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
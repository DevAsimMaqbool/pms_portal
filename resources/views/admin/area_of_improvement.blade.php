@extends('layouts.app')
@push('style')

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
       <div class="row g-6">
            <!-- Statistics -->
          <div class="col-md-12 col-xxl-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Progress Stats</h5>
                        <small class="text-body-secondary"></small>
                    </div>
                    <div class="card-body d-flex align-items-end">
                        <div class="w-100">
                            <div class="row gy-3">
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-primary me-4 p-2"><i
                                                class="icon-base ti tabler-book icon-lg"></i></div>
                                        <div class="card-info">
                                            <h5 class="mb-0"> 100%</h5>
                                            <small>Teaching</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-primary me-4 p-2"><i
                                                class="icon-base ti tabler-bulb icon-lg"></i></div>
                                        <div class="card-info">
                                            <h5 class="mb-0"> 95%</h5>
                                            <small>Research</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-primary me-4 p-2"><i
                                                class="icon-base ti tabler-network icon-lg"></i></div>
                                        <div class="card-info">
                                            <h5 class="mb-0"> 90%</h5>
                                            <small>Engagement</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-primary me-4 p-2"><i
                                                class="icon-base ti tabler-shield-check icon-lg"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0"> 85%</h5>
                                            <small>Character Virtue</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Instructors -->
            <div class="col-md-6 col-xxl-6">
              <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <div class="card-title mb-0">
                    <h5 class="m-0 me-2">Need to Improve</h5>
                  </div>
                </div>
                <div class="px-5 py-4 border border-start-0 border-end-0">
                  <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0 text-uppercase">Indicator</p>
                    <p class="mb-0 text-uppercase">AVG</p>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-6">
                    <div class="d-flex align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                          <span class="avatar-initial rounded bg-label-success"><i class="icon-base ti tabler-phone-done icon-lg"></i></span>
                      </div>
                      <div>
                        <div>
                          <h6 class="mb-0 text-truncate">Compliance and Usage of CMS</h6>
                        </div>
                      </div>
                    </div>
                    <div class="text-end">
                      <div class="badge bg-label-secondary">33%</div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mb-6">
                    <div class="d-flex align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                          <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-award icon-lg"></i></span>
                      </div>
                      <div>
                        <div>
                          <h6 class="mb-0 text-truncate">Submission of Exam Results as per Timeline</h6>
                        </div>
                      </div>
                    </div>
                    <div class="text-end">
                      <div class="badge bg-label-secondary">22%</div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mb-6">
                    <div class="d-flex align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                          <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-percentage-40 icon-lg"></i></span>
                      </div>
                      <div>
                        <div>
                          <h6 class="mb-0 text-truncate">Student Pass Percentage</h6>
                        </div>
                      </div>
                    </div>
                    <div class="text-end">
                      <div class="badge bg-label-secondary">30%</div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mb-6">
                    <div class="d-flex align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                          <span class="avatar-initial rounded bg-label-success"><i class="icon-base ti tabler-brand-superhuman icon-lg"></i></span>
                      </div>
                      <div>
                        <div>
                          <h6 class="mb-0 text-truncate">Research productivity of PG students</h6>
                        </div>
                      </div>
                    </div>
                    <div class="text-end">
                      <div class="badge bg-label-secondary">20%</div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                          <span class="avatar-initial rounded bg-label-success"><i class="icon-base ti tabler-chart-bar-popular icon-lg"></i></span>
                      </div>
                      <div>
                        <div>
                          <h6 class="mb-0 text-truncate">Line Manager Satisfaction Rating</h6>
                        </div>
                      </div>
                    </div>
                    <div class="text-end">
                      <div class="badge bg-label-secondary">60%</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Popular Instructors -->
            <div class="col-12 col-xl-6 col-md-6">
                <!-- Bar Charts -->

                <div class="card">
                    <div class="card-header header-elements">
                        <h5 class="card-title mb-0">Current Year</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">
                          <canvas id="radarChartcurrent" class="chartjs" data-height="400"></canvas>
                          </div>

                          <div class="col-12 mt-2">
                            <ul id="customLegend" class="d-flex justify-content-center flex-wrap p-0 m-0" style="list-style:none;">
                            </ul>
                          </div>
                        </div>
                    </div>
                </div>

                <!-- /Bar Charts -->
            </div>

            <div class="col-12 col-xl-6 col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Last Year</h5>
                        </div>
                    </div>

                    <!-- Radar Chart -->

                    <div class="card-body pt-2">
                        <div class="row">
                          <div class="col-md-12">
                          <canvas id="radarChartlast" class="chartjs" data-height="400"></canvas>
                          </div>

                          <div class="col-12 mt-2">
                            <ul id="customLegendlast" class="d-flex justify-content-center flex-wrap p-0 m-0" style="list-style:none;">
                            </ul>
                          </div>
                        </div>
                    </div>


                    <!-- /Radar Chart -->
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
    </script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app-user-view-account.js') }}"></script>
    <!-- Vendors JS -->
    <script src="{{ asset('admin/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('admin/assets/js/app-academy-dashboard.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script src="{{ asset('admin/assets/js/charts-chartjs-legend.js') }}"></script>
    <script src="{{ asset('admin/assets/js/charts-chartjs.js') }}"></script>
    <script>
       document.addEventListener("DOMContentLoaded", function () {
            try {

                var chartLabels = [
                  "Teaching and Learning",
                  "Research, Innovation and Commercialisation",
                  "Institutional Engagement",
                  "Character Virtue"
                ];
                var shortLabels = ["T&L", "RIC", "IE", "CV"];
                var dataset1 = [60, 69, 90, 90];
                var labelColors = ["#e74c3c", "#3498db", "#27ae60", "#f39c12"];


                const g = document.getElementById("radarChartcurrent");
                if (!g || !chartLabels.length) return;

                const ctx = g.getContext("2d");
                

                const gradient = ctx.createLinearGradient(0, 0, 0, 150);
                gradient.addColorStop(0, "rgba(115,103,240,0.9)");
                gradient.addColorStop(1, "rgba(85,85,255,0.8)");

                const radarChart = new Chart(ctx, {
                    type: "radar",
                    data: {
                        labels: shortLabels,
                        datasets: [
                            {
                                label: "Achievements",
                                data: dataset1,
                                fill: true,
                                backgroundColor: gradient,
                                borderColor: "rgba(85,85,255,1)",
                                pointBorderColor: labelColors.slice(0, shortLabels.length),
                                pointBackgroundColor: labelColors.slice(0, shortLabels.length),
                                pointRadius: 5,
                                pointHoverRadius: 8,
                                pointStyle: "circle"
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 600 },
                        scales: {
                            r: {
                                min: 50, // ✅ Show full scale
                                max: 100,
                                ticks: {
                                    display: true, // ✅ Show 60,70,80,90,100
                                    stepSize: 10,
                                    color: "#666",
                                    backdropColor: "transparent",
                                    font: { size: 10 }
                                },
                                grid: { color: "#ddd" },
                                angleLines: { color: "#ddd" },
                                pointLabels: {
                                    font: { size: 11 },
                                    color: (ctx) => labelColors[ctx.index % labelColors.length],
                                    callback: (label, i) => shortLabels[i] || label
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: "#fff",
                                titleColor: "#000",
                                bodyColor: "#333",
                                borderWidth: 1,
                                borderColor: "#ddd",
                                callbacks: {
                                    title: (context) => chartLabels[context[0].dataIndex]
                                }
                            }
                        }
                    }
                });

                // ✅ Custom Legend
                const legendDiv = document.getElementById("customLegend");
                if (legendDiv) {
                    legendDiv.innerHTML = ""; // Clear old legend if any
                    chartLabels.forEach((label, i) => {
                        let li = document.createElement("li");
                        li.className = "mx-3";
                        li.style.fontSize = "9px";
                        li.style.cursor = "pointer";
                        li.innerHTML = `
                    <span style="display:inline-block;width:10px;height:10px;background:${labelColors[i]};
                    border-radius:50%;margin-right:5px;"></span>
                    ${label} (${shortLabels[i]})
                    `;

                        li.addEventListener("mouseenter", () => {
                        radarChart.setActiveElements([{ datasetIndex: 0, index: i }]);
                        radarChart.update();
                        });
                        li.addEventListener("mouseleave", () => {
                        radarChart.setActiveElements([]);
                        radarChart.update();
                        });

                        legendDiv.appendChild(li);
                    });
                }
            } catch (error) {
                console.error("Radar chart initialization error:", error);
            }

        });
        document.addEventListener("DOMContentLoaded", function () {
            try {

                var chartLabels1 = [
                  "Teaching and Learning",
                  "Research, Innovation and Commercialisation",
                  "Institutional Engagement",
                  "Character Virtue"
                ];
                var shortLabels = ["T&L", "RIC", "IE", "CV"];
                var dataset1 = [90, 90, 60, 60];
                var labelColors = ["#e74c3c", "#3498db", "#27ae60", "#f39c12"];


                const g = document.getElementById("radarChartlast");
                if (!g || !chartLabels1.length) return;

                const ctx = g.getContext("2d");
                

                const gradient = ctx.createLinearGradient(0, 0, 0, 150);
                gradient.addColorStop(0, "rgba(115,103,240,0.9)");
                gradient.addColorStop(1, "rgba(85,85,255,0.8)");

                const radarChart = new Chart(ctx, {
                    type: "radar",
                    data: {
                        labels: shortLabels,
                        datasets: [
                            {
                                label: "Achievements",
                                data: dataset1,
                                fill: true,
                                backgroundColor: gradient,
                                borderColor: "rgba(85,85,255,1)",
                                pointBorderColor: labelColors.slice(0, shortLabels.length),
                                pointBackgroundColor: labelColors.slice(0, shortLabels.length),
                                pointRadius: 5,
                                pointHoverRadius: 8,
                                pointStyle: "circle"
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 600 },
                        scales: {
                            r: {
                                min: 50, // ✅ Show full scale
                                max: 100,
                                ticks: {
                                    display: true, // ✅ Show 60,70,80,90,100
                                    stepSize: 10,
                                    color: "#666",
                                    backdropColor: "transparent",
                                    font: { size: 10 }
                                },
                                grid: { color: "#ddd" },
                                angleLines: { color: "#ddd" },
                                pointLabels: {
                                    font: { size: 11 },
                                    color: (ctx) => labelColors[ctx.index % labelColors.length],
                                    callback: (label, i) => shortLabels[i] || label
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: "#fff",
                                titleColor: "#000",
                                bodyColor: "#333",
                                borderWidth: 1,
                                borderColor: "#ddd",
                                callbacks: {
                                    title: (context) => chartLabels1[context[0].dataIndex]
                                }
                            }
                        }
                    }
                });

                // ✅ Custom Legend
                const legendDiv = document.getElementById("customLegendlast");
                if (legendDiv) {
                    legendDiv.innerHTML = ""; // Clear old legend if any
                    chartLabels1.forEach((label, i) => {
                        let li = document.createElement("li");
                        li.className = "mx-3";
                        li.style.fontSize = "9px";
                        li.style.cursor = "pointer";
                        li.innerHTML = `
                    <span style="display:inline-block;width:10px;height:10px;background:${labelColors[i]};
                    border-radius:50%;margin-right:5px;"></span>
                    ${label} (${shortLabels[i]})
                    `;

                        li.addEventListener("mouseenter", () => {
                        radarChart.setActiveElements([{ datasetIndex: 0, index: i }]);
                        radarChart.update();
                        });
                        li.addEventListener("mouseleave", () => {
                        radarChart.setActiveElements([]);
                        radarChart.update();
                        });

                        legendDiv.appendChild(li);
                    });
                }
            } catch (error) {
                console.error("Radar chart initialization error:", error);
            }

        });
    </script>
@endpush
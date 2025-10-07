@extends('layouts.app')
@push('style')

  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
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
            <small class="text-body-secondary">Updated 1 month ago</small>
          </div>
          <div class="card-body d-flex align-items-end">
            <div class="w-100">
              <div class="row gy-3">
                <div class="col-md-3 col-6">
                  <div class="d-flex align-items-center">
                    <div class="badge rounded bg-label-primary me-4 p-2"><i
                        class="icon-base ti tabler-chart-infographic icon-lg"></i></div>
                    <div class="card-info">
                      <h5 class="mb-0"> 100%</h5>
                      <small>Teaching and Learning</small>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-6">
                  <div class="d-flex align-items-center">
                    <div class="badge rounded bg-label-primary me-4 p-2"><i
                        class="icon-base ti tabler-chart-infographic icon-lg"></i></div>
                    <div class="card-info">
                      <h5 class="mb-0"> 85%</h5>
                      <small>Research Innovation and Commercialisation</small>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-6">
                  <div class="d-flex align-items-center">
                    <div class="badge rounded bg-label-primary me-4 p-2"><i
                        class="icon-base ti tabler-chart-infographic icon-lg"></i></div>
                    <div class="card-info">
                      <h5 class="mb-0"> 90%</h5>
                      <small>Institutional Engagement</small>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-6">
                  <div class="d-flex align-items-center">
                    <div class="badge rounded bg-label-primary me-4 p-2"><i
                        class="icon-base ti tabler-chart-infographic icon-lg"></i>
                    </div>
                    <div class="card-info">
                      <h5 class="mb-0"> 901%</h5>
                      <small>Institutional Engagement Operational</small>
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
                  <span class="avatar-initial rounded bg-label-success"><i
                      class="icon-base ti tabler-phone-done icon-lg"></i></span>
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
                  <span class="avatar-initial rounded bg-label-danger"><i
                      class="icon-base ti tabler-award icon-lg"></i></span>
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
                  <span class="avatar-initial rounded bg-label-warning"><i
                      class="icon-base ti tabler-percentage-40 icon-lg"></i></span>
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
                  <span class="avatar-initial rounded bg-label-success"><i
                      class="icon-base ti tabler-brand-superhuman icon-lg"></i></span>
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
                  <span class="avatar-initial rounded bg-label-success"><i
                      class="icon-base ti tabler-chart-bar-popular icon-lg"></i></span>
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
            <canvas id="lastYear" class="chartjs" data-height="400"></canvas>
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
            <canvas class="chartjs" id="radarCharts" data-height="355"></canvas>
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
      // ✅ Static labels and datasets
      var chartLabels = ["Teaching and Learning", "Research Innovation and Commercialisation", "Institutional Engagement", "Institutional Engagement Operational"];
      var dataset1 = [70, 90, 85, 80];


      var g = document.getElementById("radarCharts");
      if (g) {
        var ctx = g.getContext("2d");

        // ✅ Gradients
        var gradientBlue = ctx.createLinearGradient(0, 0, 0, 150);
        gradientBlue.addColorStop(0, "rgba(255, 85, 184, 0.9)");
        gradientBlue.addColorStop(1, "rgba(255, 135, 135, 0.8)");

        var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
        gradientPink.addColorStop(0, "rgba(85, 85, 255, 0.9)");
        gradientPink.addColorStop(1, "rgba(151, 135, 255, 0.8)");

        // ✅ Radar Chart
        new Chart(ctx, {
          type: "radar",
          data: {
            labels: chartLabels,
            datasets: [
              {
                label: "Last Year",
                data: dataset1,
                fill: true,
                backgroundColor: gradientPink,
                borderColor: "rgba(85, 85, 255, 1)",
                pointBorderColor: "#5555ff",
                pointBackgroundColor: "#fff",
                pointRadius: 5,
                pointHoverRadius: 7,
                pointStyle: "circle"
              }
            ]
          },
          options: {
            responsive: !0,
            maintainAspectRatio: !1,
            animation: {
              duration: 500
            },
            scales: {
              r: {
                ticks: {
                  maxTicksLimit: 1,
                  display: !1,
                  color: "#666"
                },
                grid: { color: "#ddd" },
                angleLines: { color: "#ddd" },
                pointLabels: {
                  color: "#666",
                  font: {
                    size: 12, // label text size
                  },
                  callback: function (label) {
                    // Show only first 10 characters
                    return label.length > 20 ? label.substring(0, 20) + "..." : label;
                  }
                }
              }
            },
            plugins: {
              legend: {
                position: "top",
                labels: {
                  padding: 25,
                  color: "#333"
                }
              },
              tooltip: {
                backgroundColor: "#fff",
                titleColor: "#000",
                bodyColor: "#333",
                borderWidth: 1,
                borderColor: "#ddd"
              }
            }
          },

        });
      }
    });

    document.addEventListener("DOMContentLoaded", function () {
      // ✅ Static labels and datasets
      //var chartLabels = ["Teaching and Learning","Research Innovation and Commercialisation","Institutional Engagement","Institutional Engagement Operational"];
      // var dataset1 = [70, 90, 85, 80];

      var chartLabels = ["Teaching and Learning", "Research Innovation and Commercialisation", "Institutional Engagement", "Institutional Engagement Operational"];
      var dataset1 = [100, 85, 90, 90]; // Inside Mirror

      var g = document.getElementById("lastYear");
      if (g) {
        var ctx = g.getContext("2d");

        // ✅ Gradients
        var gradientBlue = ctx.createLinearGradient(0, 0, 0, 150);
        gradientBlue.addColorStop(0, "rgba(255, 85, 184, 0.9)");
        gradientBlue.addColorStop(1, "rgba(255, 135, 135, 0.8)");

        var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
        gradientPink.addColorStop(0, "rgba(85, 85, 255, 0.9)");
        gradientPink.addColorStop(1, "rgba(151, 135, 255, 0.8)");

        // ✅ Radar Chart
        new Chart(ctx, {
          type: "radar",
          data: {
            labels: chartLabels,
            datasets: [
              {
                label: "Current Year",
                data: dataset1,
                fill: true,
                backgroundColor: gradientBlue,
                borderColor: "rgba(255, 85, 184, 1)",
                pointBorderColor: "#ff55b8",
                pointBackgroundColor: "#fff",
                pointRadius: 5,
                pointHoverRadius: 7,
                pointStyle: "circle"
              }
            ]
          },
          options: {
            responsive: !0,
            maintainAspectRatio: !1,
            animation: {
              duration: 500
            },
            scales: {
              r: {
                ticks: {
                  maxTicksLimit: 1,
                  display: !1,
                  color: "666"
                },
                grid: { color: "#ddd" },
                angleLines: { color: "#ddd" },
                pointLabels: {
                  color: "#666",
                  font: {
                    size: 12, // label text size
                  },
                  callback: function (label) {
                    // Show only first 10 characters
                    return label.length > 20 ? label.substring(0, 20) + "..." : label;
                  }
                }
              }
            },
            plugins: {
              legend: {
                position: "top",
                labels: {
                  padding: 25,
                  color: "#333"
                }
              },
              tooltip: {
                backgroundColor: "#fff",
                titleColor: "#000",
                bodyColor: "#333",
                borderWidth: 1,
                borderColor: "#ddd"
              }
            }
          },

        });
      }
    });
  </script>
@endpush
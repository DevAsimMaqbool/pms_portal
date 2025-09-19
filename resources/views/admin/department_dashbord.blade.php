@extends('layouts.app')
@push('style')
  <style>
    .avatar-xl {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      object-fit: cover;
    }

    .metric {
      font-size: .9rem;
      color: #6c757d;
    }

    .mini-tile {
      border: 1px solid var(--bs-border-color);
      border-radius: .75rem;
      padding: 1rem;
      background: #fff;
      height: 100%;
    }

    .mini-tile .label {
      color: #6e6b7b;
      font-size: .8rem;
    }

    .mini-tile .value {
      font-weight: 700;
      font-size: 1.1rem;
    }

    .spark-holder {
      height: 120px;
    }

    .kpa-card h6 {
      margin-bottom: .25rem;
    }

    .indicator-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: .5rem 0;
      border-bottom: 1px dashed var(--bs-border-color);
    }

    .indicator-row:last-child {
      border-bottom: none;
    }

    .status-badge {
      padding: .35rem .5rem;
    }

    .filter-row .form-select {
      min-width: 220px;
    }
  </style>
@endpush
@php use Illuminate\Support\Str; @endphp
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card-header border-bottom">
      {{-- Department Filter --}}
      <div class="mb-3">
        <label for="departmentFilter">Filter by Department:</label>
        <select id="departmentFilter" class="form-select w-auto d-inline-block ms-2">
          <option value="">Select Department</option>
          <option value="department_of_computer_sciences" {{ $department == 'department_of_computer_sciences' ? 'selected' : '' }}>Department of Computer Sciences</option>
          <option value="department_of_information_technology" {{ $department == 'department_of_information_technology' ? 'selected' : '' }}>
            Department of Information Technology</option>
          <option value="department_of_software_engineering" {{ $department == 'department_of_software_engineering' ? 'selected' : '' }}>
            Department of Software Engineering</option>
          <!-- <option value="department_of_computer_sciences_and_information_technology">Faculty of Computer Sciences and Information Technology</option> -->
        </select>
        <button id="checkReportBtn" class="btn btn-primary ms-2">Check Report</button>
      </div>
    </div>
    <div class="row g-6">
      <div class="col-12 col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <!-- <img class="avatar-xl me-3" src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="avatar" /> -->
              <div>
                <h4 class="mb-1" id="empName">{{ ucfirst(str_replace('_', ' ', $department)) }}</h4>
                <div class="fw-semibold text-primary" id="serviceYears"></div>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-6">
                <div class="mini-tile text-center">
                  <div class="label">Classes</div>
                  <div class="value">30</div>
                </div>
              </div>
              <div class="col-6">
                <div class="mini-tile text-center">
                  <div class="label">Courses</div>
                  <div class="value">35</div>
                </div>
              </div>
              <div class="col-6">
                <div class="mini-tile text-center">
                  <div class="label">Programs</div>
                  <div class="value">4</div>
                </div>
              </div>
              <div class="col-6">
                <div class="mini-tile text-center">
                  <div class="label">Faculty</div>
                  <div class="value">60</div>
                </div>
              </div>
              <div class="col-12">
                <div class="mini-tile">
                  <div class="d-flex justify-content-between"><span class="label">Awards</span>
                    <span style="font-size: large;">🏆</span>
                  </div>
                  <div class="mt-2 d-flex justify-content-between">
                    <span class="badge bg-label-primary">Best Teacher: 10</span>
                    <span class="badge bg-label-success">Research Grant: 3</span>
                    <span class="badge bg-label-info">Mentor: 5</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- course -->
      <!-- Vehicles overview -->
      <div class="col-12 col-md-6">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Radar Chart</h5>
          </div>
          <div class="card-body pt-2">
            <canvas class="chartjs" id="radarChart" data-height="355"></canvas>
          </div>
        </div>
      </div>
      <!--/ Sales Overview -->
      <!-- Total Profit -->
      <div class="col-xxl-2 col-md-3 col-6">
        <a href="{{ route('kpa.report', ['id' => 1]) }}" class="text-decoration-none">
          <div class="card h-100">
            <div class="card-body">
              <div class="badge p-2 bg-label-danger mb-3 rounded"></div>
              <h6 class="card-title mb-1">Teaching and Learning</h6>
              <div>
                <span class="badge bg-label-danger">80%</span>
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Total Profit -->
      <div class="col-xxl-2 col-md-3 col-6">
        <a href="{{ route('kpa.report', ['id' => 1]) }}" class="text-decoration-none">
          <div class="card h-100">
            <div class="card-body">
              <div class="badge p-2 bg-label-danger mb-3 rounded"></div>
              <h6 class="card-title mb-1">Research, Innovation and Commercialisation</h6>
              <div>
                <span class="badge bg-label-danger">85%</span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <!-- Total Profit -->
      <div class="col-xxl-2 col-md-3 col-6">
        <a href="{{ route('kpa.report', ['id' => 1]) }}" class="text-decoration-none">
          <div class="card h-100">
            <div class="card-body">
              <div class="badge p-2 bg-label-danger mb-3 rounded"></i></div>
              <h6 class="card-title mb-1">Institutional Engagement (Core only)</h6>
              <div>
                <span class="badge bg-label-danger">90%</span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <!-- Total Profit -->
      <div class="col-xxl-2 col-md-3 col-6">
        <a href="{{ route('kpa.report', ['id' => 1]) }}" class="text-decoration-none">
          <div class="card h-100">
            <div class="card-body">
              <div class="badge p-2 bg-label-danger mb-3 rounded"></i></div>
              <h6 class="card-title mb-1">Institutional Engagement (Operational+ Character Strengths)</h6>
              <div>
                <span class="badge bg-label-danger">95%</span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <!-- Support Tracker -->
      <div class="col-12 col-md-6">
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h5 class="mb-0">Semester Performance Trend</h5>
              <span class="text-muted small">Semesters</span>
            </div>
            <div id="performance_semester"></div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h5 class="mb-0">Year Performance Trend</h5>
              <span class="text-muted small">Years</span>
            </div>
            <div id="performance_year"></div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- / Content -->
@endsection
@push('script')
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var trendScores = [90, 95]; // ✅ your scores
      var trendSemesters = ["Spring 2025", "Fall 2025"]; // ✅ your categories

      var options = {
        chart: {
          type: 'area',
          height: 290,
          toolbar: { show: false }
        },
        series: [{
          name: 'Overall %',
          data: trendScores
        }],
        xaxis: {
          categories: trendSemesters
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#7367f0'],
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 0.5,
            opacityFrom: 0.4,
            opacityTo: 0.05
          }
        }
      };

      var chart = new ApexCharts(document.querySelector("#performance_semester"), options);
      chart.render();
    });
    document.addEventListener("DOMContentLoaded", function () {
      var trendScores = [80, 85, 90]; // ✅ your scores
      var trendSemesters = ["2023", "2024", "2025"]; // ✅ your categories

      var options = {
        chart: {
          type: 'area',
          height: 290,
          toolbar: { show: false }
        },
        series: [{
          name: 'Overall %',
          data: trendScores
        }],
        xaxis: {
          categories: trendSemesters
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#7367f0'],
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 0.5,
            opacityFrom: 0.4,
            opacityTo: 0.05
          }
        }
      };

      var chart = new ApexCharts(document.querySelector("#performance_year"), options);
      chart.render();
    });

    document.addEventListener("DOMContentLoaded", function () {
      // :white_tick: Static labels and datasets
      var chartLabels = ["Teaching and Learning", "Research", "Institutional Engagement", "Institutional Engagement"];
      var dataset1 = [65, 59, 90, 81]; // Inside Mirror
      var g = document.getElementById("radarChart");
      if (g) {
        var ctx = g.getContext("2d");
        // :white_tick: Gradients
        var gradientBlue = ctx.createLinearGradient(0, 0, 0, 150);
        gradientBlue.addColorStop(0, "rgba(85, 85, 255, 0.9)");
        gradientBlue.addColorStop(1, "rgba(151, 135, 255, 0.8)");
        var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
        gradientPink.addColorStop(0, "rgba(115, 103, 240, 1)");
        gradientPink.addColorStop(1, "rgba(115, 103, 240, 1)");
        // :white_tick: Radar Chart
        new Chart(ctx, {
          type: "radar",
          data: {
            labels: chartLabels,
            datasets: [
              {
                label: "Achievements",
                data: dataset1,
                fill: true,
                backgroundColor: gradientPink,
                borderColor: "rgba(112, 25, 115, 1)",
                pointBorderColor: "#FF55B8",
                pointBackgroundColor: "#fff",
                pointRadius: 5,
                pointHoverRadius: 7,
                pointStyle: "circle"
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 500 },
            scales: {
              r: {
                ticks: { display: true, color: "#666" },
                grid: { color: "#ddd" },
                angleLines: { color: "#ddd" },
                pointLabels: { color: "#666" }
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
          }
        });
      }
    });

    document.getElementById('checkReportBtn').addEventListener('click', function () {
      const selectedValue = document.getElementById('departmentFilter').value;
      if (selectedValue) {
        // Redirect to department report page
        window.location.href = `/departments/${selectedValue}/report`;
      } else {
        alert('Please select a department first.');
      }
    });
  </script>

@endpush
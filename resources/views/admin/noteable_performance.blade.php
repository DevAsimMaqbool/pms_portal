@extends('layouts.app')
@push('style')

  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
  <style>
    .custom-tabs .nav-link {
      border-radius: 25px;
      margin: 0 5px;
      font-weight: 600;
      transition: 0.3s;
      background: #e1dcdc85;
    }

    .custom-tabs .nav-link.active {
      background: linear-gradient(45deg, #007bff, #00c6ff);
      color: white !important;
      box-shadow: 0px 4px 12px rgba(0, 123, 255, 0.4);
    }
  </style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card p-0 mb-6">
      <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-6">
        <div class="app-academy-md-25 card-body py-0 pt-6 ps-12">
          <img src="../../assets/img/illustrations/bulb-light.png" class="img-fluid app-academy-img-height scaleX-n1-rtl"
            alt="Bulb in hand" data-app-light-img="illustrations/bulb-light.png"
            data-app-dark-img="illustrations/bulb-dark.png" height="90" />
        </div>
        <div class="app-academy-md-50 card-body d-flex align-items-md-center flex-column text-md-center mb-6 py-6">
          <span class="card-title mb-4 lh-lg px-md-12 h4 text-heading">
            Acheivements <span class="text-primary text-nowrap">All in one place</span>.
          </span>
          <p class="mb-4">
            Recognizes outstanding accomplishments, contributions, and awards received for exceptional performance,
            innovation, and commitment to organizational goals.
          </p>

        </div>
        <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
          <img src="{{ asset('admin/assets/img/illustrations/pencil-rocket.png') }}" alt="pencil rocket" height="188"
            class="scaleX-n1-rtl" />
        </div>
      </div>
    </div>
    <!-- Header -->
    <div class="row">
      <div class="col-12">

        <!-- Basic Bootstrap Table -->
        <div class="card">
          <h5 class="card-header border-bottom">Acheivements History</h5>
          <div class="card-datatable table-responsive pt-0">
            <table class="table table-bordered" id="example">
              <thead>
                <tr>
                  <th>category</th>
                  <th>Score</th>
                  <th>Rating</th>
                  <th>Badges</th>
                  <th>Comment</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @php
                  $indicators = getIndicatorsByScore('>=', 80, Auth::user()->employee_id, null, 1);
                @endphp
                @foreach($indicators as $ind)
                  @php
                    $color = $ind->score >= 90 ? 'primary' : ($ind->score >= 80 ? 'success' : ($ind->score >= 70 ? 'warning' : ($ind->score >=
                      60 ? '#fd7e13' : '#ff4c51'))); 
                  @endphp
                  <tr>
                    <td class="sorting_1">
                      <div class="d-flex justify-content-start align-items-center product-name">
                        <div class="avatar flex-shrink-0 me-4">
                          <span class="avatar-initial rounded bg-label-primary"><i
                              class="icon-base ti tabler-percentage icon-26px"></i></span>
                        </div>
                        <div class="d-flex flex-column">
                          <h6 class="text-nowrap mb-0">Teaching and Learning</h6>
                          <small class="text-truncate d-none d-sm-block">{{ $ind->indicator->indicator }}</small>
                        </div>
                      </div>
                    </td>

                    <td>
                      <p class="text-primary fw-medium mb-0 d-flex align-items-center gap-1">
                        {{ number_format($ind->score, 1) }}%
                      </p>
                    </td>
                    <td><span class="badge bg-label-{{ $color }} me-1">{{ $ind->rating }}</span></td>
                    <td>
                      <div class="avatar avatar-xl">
                        <img src="{{ asset('admin/assets/img/avatars/' . $ind->badge_name . '-badge.png') }}" alt="Avatar"
                          class="rounded-circle">
                      </div>
                    </td>
                    <td> <small class="text-break">
                        You’re achieving excellence with distinction.You set the pace for others to follow.
                      </small>
                    </td>
                    <td>08/07/2021</td>
                  </tr>
                @endforeach


              </tbody>
            </table>
          </div>
        </div>
        <!--/ Basic Bootstrap Table -->
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
      const c = document.querySelector("#carrierPerformance");
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
            startingShape: "rounded",
            endingShape: "flat",
            borderRadius: 6
          }
        },
        dataLabels: { enabled: false },
        series: [
          {
            name: "Fall 2025",
            type: "column",
            data: [5, 2.5, 4, 3]
          },
          {
            name: "Fall 2026",
            type: "column",
            data: [6, 3.5, 3, 2.5]
          }
        ],
        xaxis: {
          tickAmount: 10,
          categories: ["C&UOL", "StS", "QEC", "CH"],
          labels: {
            style: {
              colors: "#6e6b7b",
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
          min: 1,
          labels: {
            style: {
              colors: "#6e6b7b",
              fontSize: "13px",
              fontFamily: "Inter, sans-serif",
              fontWeight: 400
            },
            formatter: function (o) {
              return o;
            }
          }
        },
        legend: {
          show: true,
          position: "bottom",
          markers: { size: 5, shape: "circle" },
          height: 40,
          offsetY: 0,
          itemMargin: { horizontal: 8, vertical: 0 },
          fontSize: "13px",
          fontFamily: "Inter, sans-serif",
          fontWeight: 400,
          labels: {
            colors: "#6e6b7b",
            useSeriesColors: false
          },
          offsetY: -5
        },
        grid: {
          strokeDashArray: 6,
          padding: { bottom: 5 }
        },
        colors: ["#655ae9", "#701f73"],
        fill: { opacity: 1 },
        responsive: [
          {
            breakpoint: 1400,
            options: {
              chart: { height: 275 },
              legend: { fontSize: "13px", offsetY: 10 }
            }
          },
          {
            breakpoint: 576,
            options: {
              chart: { height: 300 },
              legend: {
                itemMargin: { vertical: 5, horizontal: 10 },
                offsetY: 7
              }
            }
          }
        ]
      };

      if (c !== null) {
        new ApexCharts(c, a).render();
      }
    });

  </script>
  <script>
    new DataTable('#example', {
      order: [] // disables automatic sorting
    });
  </script>
@endpush
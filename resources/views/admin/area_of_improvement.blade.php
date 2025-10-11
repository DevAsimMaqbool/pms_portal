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
                  <div class="card-body d-flex align-items-end">
                    <div class="w-100">

                      <div class="row gy-3">

                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded bg-label-primary me-4 p-2"><i class="icon-base ti tabler-book icon-lg"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">90%</h5>
                              <small>Teaching</small>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded bg-label-info me-4 p-2"><i class="icon-base ti tabler-bulb icon-lg"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">85%</h5>
                              <small>Research</small>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded bg-label-danger me-4 p-2"><i
                                class="icon-base ti tabler-network icon-lg"></i></div>
                            <div class="card-info">
                              <h5 class="mb-0">80%</h5>
                              <small>Engagement</small>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded bg-label-success me-4 p-2"><i
                                class="icon-base ti tabler-shield-check icon-lg"></i></div>
                            <div class="card-info">
                              <h5 class="mb-0">75%</h5>
                              <small>Character Virtue</small>
                            </div>
                          </div>
                        </div>

                      </div>

                    </div>
                  </div>
                </div>
            </div>
            
             <!-- Last Transaction -->
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 me-2">Need to Improve</h5>
                    <button type="button" class="btn rounded-pill btn-outline-primary waves-effect"><i class="icon-base ti tabler-calendar icon-xs me-2"></i>Fall 2025</button>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-borderless border-top">
                      <thead class="border-bottom">
                        <tr>
                          <th>Indicator</th>
                          <th>Rating</th>
                          <th>TREND</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="pt-5">
                            <div class="d-flex justify-content-start align-items-center">
                              <div class="avatar flex-shrink-0 me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-package icon-26px"></i></span>
                              </div>
                              <div class="d-flex flex-column">
                                <small class="text-body">Compliance and Usage of CMS</small>
                              </div>
                            </div>
                          </td>
                          
                          <td class="pt-5"><span class="badge bg-label-primary">OS</span></td>
                          <td class="pt-5">
                            <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                              <i class="icon-base ti tabler-chevron-up"></i>
                              92%
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex justify-content-start align-items-center">
                              <div class="avatar flex-shrink-0 me-4">
                                <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-truck icon-26px"></i></span>
                              </div>
                              <div class="d-flex flex-column">
                                <small class="text-body">Submission of Exam Results as per Timeline</small>
                              </div>
                            </div>
                          </td>
                          
                          <td><span class="badge bg-label-primary">OS</span></td>
                          <td>
                            <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                              <i class="icon-base ti tabler-chevron-up"></i>
                              91%
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex justify-content-start align-items-center">
                              <div class="avatar flex-shrink-0 me-4">
                                <span class="avatar-initial rounded bg-label-success"><i class="icon-base ti tabler-circle-check icon-26px"></i></span>
                              </div>
                              <div class="d-flex flex-column">
                                <small class="text-body">Student Pass Percentage</small>
                              </div>
                            </div>
                          </td>
                         
                          <td><span class="badge bg-label-warning">ME</span></td>
                          <td>
                            <p class="text-danger fw-medium mb-0 d-flex align-items-center gap-1">
                              <i class="icon-base ti tabler-chevron-down"></i>
                              90%
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex justify-content-start align-items-center">
                              <div class="avatar flex-shrink-0 me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-percentage icon-26px"></i></span>
                              </div>
                              <div class="d-flex flex-column">
                                <small class="text-body">Research productivity of PG students</small>
                              </div>
                            </div>
                          </td>
                          
                          <td><span class="badge bg-label-primary">OS</span></td>
                          <td>
                            <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                              <i class="icon-base ti tabler-chevron-up"></i>
                              85%
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex justify-content-start align-items-center">
                              <div class="avatar flex-shrink-0 me-4">
                                <span class="avatar-initial rounded bg-label-secondary"><i class="icon-base ti tabler-clock icon-26px"></i></span>
                              </div>
                              <div class="d-flex flex-column">
                                <small class="text-body">Line Manager Satisfaction Rating</small>
                              </div>
                            </div>
                          </td>
                          
                          <td><span class="badge bg-label-warning">ME</span></td>
                          <td>
                            <p class="text-danger fw-medium mb-0 d-flex align-items-center gap-1">
                              <i class="icon-base ti tabler-chevron-down"></i>
                              80%
                            </p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--/ Last Transaction -->
              <!-- Carrier Performance -->
              <div class="col-12 col-lg-6">
                <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Carrier Comparison</h5>
                    
                  </div>
                  <div class="card-body">
                    <div id="carrierPerformance"></div>
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
                data: [5, 4.5, 4, 3]
            },
            {
                name: "Fall 2026",
                type: "column",
                data: [4, 3.5, 3, 2.5]
            }
        ],
        xaxis: {
            tickAmount: 10,
            categories: ["C&UOL", "SOERAPT", "SPP", "LM"],
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
            max: 5,
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
@endpush
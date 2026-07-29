@extends('layouts.app')
@push('style')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/swiper/swiper.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/cards-advance.css') }}" />
  {{-- <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/ui-carousel.css') }}" /> --}}
   <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />

  </style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Content types -->
    <div class="row mb-6 g-6">
    <!--/ Sales Overview -->

      <div class="col-md-3 col-lg-3">
    
       <div class="card h-100">
        <div class="card-header">
            <h5 class="mb-0">Overall Performance Score</h5>
        </div>

        <div class="card-body text-center">

            <div class="chart-progres"
                data-series="72"
                data-color="#696cff"
                data-label="Good">
            </div>

        </div>

        <div class="card-footer text-center">
            Record / Update This Month
        </div>
      </div>
      
      </div>



      <!-- Goals -->

      <div class="col-md-3 col-lg-3">

          <div class="card h-100">

          <div class="card-header">
            <h5 class="card-title">
            Goals Process (This Month)
            </h5>
          </div>

          <div class="card-body">

            <div class="d-flex justify-content-between">
              <span>Completed</span>
              <strong>18 / 25</strong>
            </div>

              <div class="progress my-3">
                <div class="progress-bar bg-success"
                style="width:72%">
                </div>
              </div>

              <h2 class="text-success">72%</h2>
              <p class="small-text">7 Goals Remaining</p>

              </div>
              <div class="card-footer text-center">View Goals</div>

          </div>

      </div>
      <!--close goals -->


      <!-- Productivity -->

      <div class="col-md-3 col-lg-3">

      <div class="card h-100">

      <div class="card-header text-center">
           <h5 class="card-title">Daily Productivity</h5>
      </div>

      <div class="card-body">

      <div class="d-flex mb-3">

      <div class="icon-box bg-soft-primary">
          <i class="bx bx-line-chart"></i>
      </div>

      <div class="ms-3">
        <h2 class="mb-0">91%</h2>
        <p class="small-text">Average Productivity</p>
      </div>

      </div>

      <div id="productivityChart" class="chart-box"></div>

      </div>
      <div class="card-footer text-center">View Daily Log</div>

      </div>

      </div>

      <!-- /close daily productivity -->

      <!-- Feedback -->

      <div class="col-md-3 col-lg-3">

      <div class="card h-100">

      <div class="card-header"><h5 class="card-title">Feedback Rating</h5></div>
      <div class="card-body">
        <h1 class="fw-bold">4.8</h1>
        <div class="mb-3">
        <div class="basic-ratings raty" data-score="3" data-number="5"></div>
        </div>
        <p class="small-text">Based on<strong>124 Reviews</strong></p>
      </div>
        <div class="card-footer text-center">View Feedback</div>

      </div>

      </div>

    </div>

    <div class="row mb-6 g-6">
         <div class="col-md-6 col-lg-6">
    
       <div class="card h-100">
         <div class="card-header pb-0 d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1"> Daily Productivity</h5>
          </div>
          <div class="dropdown">
            <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1 waves-effect" type="button" id="earningReportsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId" style="">
              <input type="date" class="form-control">
            </div>
          </div>
        </div>

          <div class="card-body text-center">

              <div id="weeklyEarningReportsuser">
              </div>

          </div>

          <div class="card-footer">
              <div class="d-flex justify-content-between">

                <span>Weekly Avg %</span>

                <span>Record Daily Productivity</span>

                </div>
          </div>
      </div>
      
      </div>



         <!-- Last Transaction -->
    <div class="col-md-6 col-lg-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title m-0 me-2">My Goals (2026)</h5>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless border-top">
            <thead class="border-bottom">
              <tr>
                <th>GOAL</th>
                <th>WEIGHT</th>
                <th>PROCESS</th>
              </tr>
            </thead>
            <tbody>
            @foreach($assignments as $assignment)
              <tr>
                <td class="pt-5">
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="d-flex flex-column">
                      <small class="text-body">{{ $assignment->goal->goal_name }}</small>
                    </div>
                  </div>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading">{{ $assignment->avg_weight }}%</p>
                </td>
                <td class="pt-5">
                   <div class="d-flex flex-grow-1 align-items-center">
                    <div class="progress w-100 me-4" style="height:8px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="text-body-secondary">65%</span>
                  </div>
                </td>
               
              </tr>

               

             
              @endforeach

             
             
            </tbody>
          </table>
        </div>
        <div class="card-footer">Total Progress 72%</div>
      </div>
    </div>
    <!--/ Last Transaction -->
    </div>


     <div class="row mb-6 g-6">


         <!-- Last Transaction -->
    <div class="col-md-6 col-lg-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title m-0 me-2">KEY  DEPARTMENTAL INDICATOR</h5>
           <p class="card-title m-0 me-2">This Month</p>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless border-top">
            <thead class="border-bottom">
              <tr>
                <th>KPI</th>
                <th>Actual</th>
                <th>Target</th>
                <th>Achievement</th>
                <th>Trend</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="pt-5">
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="d-flex flex-column">
                      <small class="text-body">Douument Process</small>
                    </div>
                  </div>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading">245</p>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading">250</p>
                </td>
                <td class="pt-5">
                   <div class="d-flex flex-grow-1 align-items-center">
                    <div class="progress w-100 me-4" style="height:8px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 98%" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="text-body-secondary">98%</span>
                  </div>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading"><button type="button" class="btn btn-sm btn-icon btn-label-secondary waves-effect">
                    <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                  </button></p>
                </td>
               
              </tr>

               <tr>
                <td class="pt-5">
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="d-flex flex-column">
                      <small class="text-body">Requesting Time</small>
                    </div>
                  </div>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading">14</p>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading">18</p>
                </td>
                <td class="pt-5">
                   <div class="d-flex flex-grow-1 align-items-center">
                    <div class="progress w-100 me-4" style="height:8px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="text-body-secondary">78%</span>
                  </div>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading"><button type="button" class="btn btn-sm btn-icon btn-label-secondary waves-effect">
                    <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                  </button></p>
                </td>
               
              </tr>

               <tr>
                <td class="pt-5">
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="d-flex flex-column">
                      <small class="text-body">Office Expense</small>
                    </div>
                  </div>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading">85</p>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading">100</p>
                </td>
                <td class="pt-5">
                   <div class="d-flex flex-grow-1 align-items-center">
                    <div class="progress w-100 me-4" style="height:8px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="text-body-secondary">85%</span>
                  </div>
                </td>
                <td class="pt-5">
                   <p class="mb-0 text-heading"><button type="button" class="btn btn-sm btn-icon btn-label-secondary waves-effect">
                    <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                  </button></p>
                </td>
               
              </tr>


             
             
            </tbody>
          </table>
        </div>
        <div class="card-footer">View All KPIS ></div>
      </div>
    </div>
    <!--/ Last Transaction -->


    <!-- Support Tracker -->
    <div class="col-12 col-md-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1">Performance (Monthly)</h5>
          </div>
          <p>View History </p>
        </div>
        <div class="card-body row">
          <div class="col-12 col-sm-4">
            <div class="mt-lg-4 mt-lg-2 mb-lg-6 mb-2">
              <p class="mb-0"> May 2026</p>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                <div class="badge rounded bg-label-primary p-1_5"><i class="icon-base ti tabler-ticket icon-md"></i></div>
                <div>
                  <h6 class="mb-0 text-nowrap">Goals Achievement</h6>
                  <small class="text-body-secondary">72%</small>
                </div>
              </li>
              <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                <div class="badge rounded bg-label-info p-1_5"><i class="icon-base ti tabler-circle-check icon-md"></i></div>
                <div>
                  <h6 class="mb-0 text-nowrap">KPI Achievement</h6>
                  <small class="text-body-secondary">75</small>
                </div>
              </li>
              <li class="d-flex gap-4 align-items-center pb-1">
                <div class="badge rounded bg-label-warning p-1_5"><i class="icon-base ti tabler-clock icon-md"></i></div>
                <div>
                  <h6 class="mb-0 text-nowrap">Competencies</h6>
                  <small class="text-body-secondary">68%</small>
                </div>
              </li>
            </ul>
          </div>
          <div class="col-12 col-md-8">
            <div id="supportTracker"></div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Support Tracker -->
    </div>






    

    <!--/ Content types -->
  </div>
  <!-- / Content -->
@endsection
@push('script')
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}
    "></script>
  <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/swiper/swiper.js') }}
      "></script>
  <!-- <script src="{{ asset('admin/assets/js/cards-statistics.js') }}"></script> -->
  <script src="{{ asset('admin/assets/js/dashboards-analytics.js') }}"></script>

  <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app-academy-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>

    <!-- Main JS -->
     <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script>

document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".chart-progres").forEach(function (el) {

        let value = Number(el.dataset.series);
        let color = el.dataset.color;
        let label = el.dataset.label;

        let options = {

            series: [value],

            chart: {
                height: 260,
                type: "radialBar",
                toolbar: {
                    show: false
                }
            },

            plotOptions: {

                radialBar: {

                    startAngle: -135,
                    endAngle: 135,

                    hollow: {
                        size: "72%"
                    },

                    track: {
                        background: "#ececec",
                        strokeWidth: "100%"
                    },

                    dataLabels: {

                        name: {
                            show: true,
                            offsetY: 45,
                            color: "#666",
                            fontSize: "16px"
                        },

                        value: {
                            offsetY: -5,
                            fontSize: "38px",
                            fontWeight: 700,
                            formatter: function (val) {
                                return val + "%";
                            }
                        }

                    }

                }

            },

            fill: {
                colors: [color]
            },

            stroke: {
                lineCap: "round"
            },

            labels: [label]

        };

        new ApexCharts(el, options).render();

    });


    var options = {

        series: [{
            name: "Productivity",
            data: [20, 81, 76, 90, 88, 95, 91]
        }],

        chart: {
            type: "area",
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },

        colors: ["#696cff"],

        stroke: {
            curve: "smooth",
            width: 4
        },

        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },

        dataLabels: {
            enabled: false
        },

        markers: {
            size: 5,
            colors: ["#696cff"],
            strokeColors: "#fff",
            strokeWidth: 2,
            hover: {
                size: 7
            }
        },

        xaxis: {
            categories: [
                "Mon",
                "Tue",
                "Wed",
                "Thu",
                "Fri",
                "Sat",
                "Sun"
            ],

            axisBorder: {
                show: false
            },

            axisTicks: {
                show: false
            },

            labels: {
                style: {
                    colors: "#8592a3",
                    fontSize: "13px"
                }
            }
        },

        yaxis: {

            min: 0,
            max: 100,

            show: false,

            labels: {
                show: false
            },

            axisBorder: {
                show: false
            },

            axisTicks: {
                show: false
            }

        },

        grid: {
            show: false
        },

        tooltip: {
            theme: "light",
            y: {
                formatter: function (value) {
                    return value + "%";
                }
            }
        },

        legend: {
            show: false
        }

    };

    var productivityChart = new ApexCharts(
        document.querySelector("#productivityChart"),
        options
    );

    productivityChart.render();



    var options = {

        series: [{
            name: "Productivity",
            data: [72, 85, 68, 90, 78, 95, 82]
        }],

        chart: {
            height: 161,
            type: "bar",
            parentHeightOffset: 0,
            toolbar: {
                show: false
            }
        },

        colors: ["#696cff"],

        plotOptions: {
            bar: {
                borderRadius: 6,
                columnWidth: "45%",
                distributed: false
            }
        },

        dataLabels: {
            enabled: false
        },

        legend: {
            show: false
        },

        grid: {
            show: false
        },

        xaxis: {
            categories: [
                "Mon",
                "Tue",
                "Wed",
                "Thu",
                "Fri",
                "Sat",
                "Sun"
            ],

            axisBorder: {
                show: false
            },

            axisTicks: {
                show: false
            },

            labels: {
                style: {
                    fontSize: "12px",
                    colors: "#8592a3"
                }
            }
        },

        yaxis: {
            show: false
        },

        tooltip: {
            y: {
                formatter: function (val) {
                    return val + "%";
                }
            }
        }

    };

    var chartdaily = new ApexCharts(
        document.querySelector("#weeklyEarningReportsuser"),
        options
    );

    chartdaily.render();

});
    </script>
@endpush
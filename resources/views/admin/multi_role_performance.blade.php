@extends('layouts.app')
@push('style')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/swiper/swiper.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/cards-advance.css') }}" />
  {{--
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/ui-carousel.css') }}" /> --}}
  <style>
    .animated-card-x:hover {
      animation: rotate3DX 5s ease-in-out infinite;
      transform-style: preserve-3d;
      box-shadow: 0 20px 35px rgba(0, 0, 0, 0.15);
    }

    @keyframes rotate3DX {
      0% {
        transform: rotateX(0deg);
      }

      100% {
        transform: rotateX(360deg);
      }
    }

    .animated-card-y:hover {
      animation: rotate3DY 6s linear infinite;
    }

    @keyframes rotate3DY {
      0% {
        transform: rotateY(0deg);
      }

      100% {
        transform: rotateY(360deg);
      }
    }

    .card-wrapper-x {
      perspective: 1200px;
      display: inline-block;
    }

    /* Animate smoothly */
    .animated-card-z {
      transition: transform 0.8s ease, box-shadow 0.8s ease;
      transform-style: preserve-3d;
      will-change: transform;
    }

    /* Hover effect: 3D tile rotate on X-axis */
    .animated-card-z:hover {
      transform: rotateX(20deg) translateY(-5px);
      box-shadow: 0 20px 35px rgba(0, 0, 0, 0.15);
    }

    /* Optional subtle animation while idle */
    @keyframes softTilt {
      0% {
        transform: rotateX(0deg);
      }

      50% {
        transform: rotateX(6deg);
      }

      100% {
        transform: rotateX(0deg);
      }
    }

    .animated-card-zoom {
      transition: transform 0.6s ease, box-shadow 0.6s ease;
      transform-style: preserve-3d;
      perspective: 1000px;
      cursor: pointer;
    }

    /* Zoom-out 3D effect on hover */
    .animated-card-zoom:hover {
      transform: scale(0.95) translateZ(-30px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Optional continuous zoom-in/out animation */
    @keyframes zoomOut3D {

      0%,
      100% {
        transform: scale(1) translateZ(0);
      }

      50% {
        transform: scale(0.93) translateZ(-25px);
      }
    }

    .animated-card-zoom-in {
      transition: transform 0.6s ease, box-shadow 0.6s ease;
      transform-style: preserve-3d;
      perspective: 1000px;
      cursor: pointer;
    }

    /* Zoom-in 3D effect on hover */
    .animated-card-zoom-in:hover {
      transform: scale(1.08) translateZ(20px);
      box-shadow: 0 25px 40px rgba(0, 0, 0, 0.15);
    }

    /* Optional: subtle breathing zoom effect (auto animation) */
    @keyframes zoomIn3D {

      0%,
      100% {
        transform: scale(1) translateZ(0);
      }

      50% {
        transform: scale(1.08) translateZ(20px);
      }
    }

    .flip-card {
      perspective: 1000px;
      width: 100%;
      height: 100%;
    }

    /* Inner wrapper for flipping */
    .flip-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.8s ease-in-out;
      transform-style: preserve-3d;
    }

    /* Flip on hover */
    .flip-card:hover .flip-card-inner {
      transform: rotateY(180deg);
    }

    /* Card sides */
    .flip-card-front,
    .flip-card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      border-radius: 0.375rem;
      /* Bootstrap card border radius */
    }

    /* Back side */
    .flip-card-back {
      transform: rotateY(180deg);
    }

    /* Make it responsive */
    @media (max-width: 767.98px) {
      .flip-card-inner {
        transition: transform 0.6s ease-in-out;
      }
    }

    .hover-card {
      transition: all 0.3s ease;
    }

    .hover-card:hover {
      background-color: #ffeaea;
      /* light red background */
      transform: translateY(-4px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    /* Optional: change progress bar or badge color on hover */
    .hover-card:hover .progress-bar {
      background-color: #ff4d4d !important;
    }

    .hover-card:hover .badge {
      background-color: #ff4d4d !important;
      color: white;
    }
  </style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- <div class="row g-6">
       @php
          $colors_cards = ['warning', 'info', 'info', 'primary', 'danger'];
          $icon_cards = ['user', 'school', 'info', 'primary', 'danger'];
      @endphp
      @foreach($scores as $index => $data)
      @php
        $color_res = $colors_cards[$index % count($colors_cards)];
        $icon_res = $icon_cards[$index % count($icon_cards)];
       @endphp
        <div class="col-12 col-md-4">
          <div class="card h-100 text-bg-{{ $color_res }}">
            <div class="card-header">
              <h5 class="mb-1 text-white">{{ $data['role_name'] }}</h5>
            </div>
            <div class="card-body row">
              <div class="col-12 col-sm-4">
                <div class="avatar flex-shrink-0 me-4">
                  <span class="avatar-initial rounded bg-label-{{ $color_res }}"><i class="icon-base ti tabler-{{ $icon_res }} icon-26px"></i></span>
                </div>
              </div>
              <div class="col-12 col-md-8">
                <div id="{{ $data['chart_id'] }}"></div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      <div class="col-12 col-md-4">
        <div class="card h-100 text-bg-success">
          <div class="card-header">
            <h5 class="mb-1 text-white">Combined Score</h5>
          </div>
          <div class="card-body row">
            <div class="col-12 col-sm-4">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-success"><i class="icon-base ti tabler-blend-mode icon-26px"></i></span>
              </div>
            </div>
            <div class="col-12 col-md-8">
              <div id="combinedScoreChart"></div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}

    <div class="row g-6">
       @php
          $colors_cards = ['warning', 'info', 'info', 'primary', 'danger'];
          $icon_cards = ['user', 'school', 'info', 'primary', 'danger'];
      @endphp
      @foreach($scores as $index => $data)
      @php
        $scorerating = $data['percentage_score'] ?? 0;
        $meta_avg = getRatingMeta($scorerating);
        $color_res = $colors_cards[$index % count($colors_cards)];
        $icon_res = $icon_cards[$index % count($icon_cards)];
      @endphp

        <div class="col-md-6 col-xxl-4 mb-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title m-0 me-2">
              <h5 class="mb-1 text-{{ $color_res }}">As {{ $data['role_name'] }}</h5>
            </div>
          </div>
          <div class="card-body">
            <ul class="p-0 m-0">
              <li class="d-flex mb-3 pb-1 align-items-center">
                <div class="badge bg-label-{{ $color_res }} me-4 rounded p-1_5">
                  <i class="icon-base ti tabler-receipt icon-md"></i>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Total Score</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0 text-{{ $color_res }}">{{ $data['weight'] }}%</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-3 pb-1 align-items-center">
                <div class="badge bg-label-{{ $color_res }} me-4 rounded p-1_5">
                  <i class="icon-base ti tabler-scoreboard icon-md"></i>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Your Obtained</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0 text-{{ $color_res }}">{{ $data['score'] }}%</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-3 pb-1 align-items-center">
                <div class="badge bg-label-{{ $color_res }} me-4 rounded p-1_5">
                  <i class="icon-base ti tabler-percentage-40 icon-md"></i>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Percentage Obtained</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0 text-{{ $color_res }}"> {{ number_format($data['percentage_score'], 1) }}%</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-3 pb-1 align-items-center">
                <div class="badge bg-label-{{ $color_res }} me-4 rounded p-1_5">
                  <i class="icon-base ti tabler-star-half-filled icon-md"></i>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Rating</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <span class="badge" style="background-color: {{ $meta_avg->color }}">  {{ $meta_avg->rating }} </span>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      @endforeach 
       @php
        $totalWeight = collect($scores)->sum('weight');
        $totalscore = collect($scores)->sum('score');
        $overallpercentage=($combinedScore /$totalWeight) *100;
        $totalweighted_score = collect($scores)->sum('percentage_score');

        $meta_avg_combine = getRatingMeta($overallpercentage);
      @endphp
       <div class="col-md-6 col-xxl-4 mb-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title m-0 me-2">
              <h5 class="mb-1 text-success">Overall</h5>
            </div>
          </div>
          <div class="card-body">
            <ul class="p-0 m-0">
              <li class="d-flex mb-3 pb-1 align-items-center">
                <div class="badge bg-label-success me-4 rounded p-1_5">
                  <i class="icon-base ti tabler-receipt icon-md"></i>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Total Score</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0 text-success">{{ $totalWeight }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-3 pb-1 align-items-center">
                <div class="badge bg-label-success me-4 rounded p-1_5">
                  <i class="icon-base ti tabler-scoreboard icon-md"></i>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Your Obtained</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0 text-success">{{ $combinedScore }}%</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-3 pb-1 align-items-center">
                <div class="badge bg-label-success me-4 rounded p-1_5">
                  <i class="icon-base ti tabler-percentage-40 icon-md"></i>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Percentage Obtained</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0 text-success">{{ number_format($overallpercentage, 1) }}%</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-3 pb-1 align-items-center">
                <div class="badge bg-label-success me-4 rounded p-1_5">
                  <i class="icon-base ti tabler-star-half-filled icon-md"></i>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Rating</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <span class="badge" style="background-color: {{ $meta_avg_combine->color }}">  {{ $meta_avg_combine->rating }} </span>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      </div>


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

  <script>
    $(document).ready(function () {

      function renderChart(selector, value, label) {
        var options = {
          series: [value],
          labels: [label],
          chart: { height: 335, type: "radialBar" },
          plotOptions: {
            radialBar: {
              offsetY: 10,
              startAngle: -140,
              endAngle: 130,
              hollow: { size: "65%" },
              track: { background: "#f2f2f2", strokeWidth: "100%" },
              dataLabels: {
                name: { offsetY: -20, color: "#ffffff", fontSize: "13px" },
                value: { offsetY: 10, color: "#ffffff", fontSize: "38px" }
              }
            }
          },
          colors: ["#000000"],
          fill: {
            type: "gradient",
            gradient: {
              shade: "dark",
              shadeIntensity: 0.5,
              gradientToColors: ["#000000"],
              inverseColors: true,
              opacityFrom: 1,
              opacityTo: 0.6,
              stops: [30, 70, 100]
            }
          },
          stroke: { dashArray: 10 },
          grid: { padding: { top: -20, bottom: 5 } }
        };

        var chart = new ApexCharts(document.querySelector(selector), options);
        chart.render();
      }

      // Individual role charts
      @foreach($scores as $data)
        renderChart("#{{ $data['chart_id'] }}", {{ $data['score'] }}, "{{ $data['role_name'] }}");
      @endforeach

      // Combined score chart
      renderChart("#combinedScoreChart", {{ $combinedScore }}, "Combined Score");

    });
  </script>
@endpush
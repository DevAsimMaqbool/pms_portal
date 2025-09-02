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
@endpush
@php use Illuminate\Support\Str; @endphp
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
    <!-- Website Analytics -->
    <div class="col-xl-6 col">
      <div class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg"
      id="swiper-with-pagination-cards">
      <div class="swiper-wrapper">
        @foreach($grouped as $kpa)
      <div class="swiper-slide">
      <div class="row">
        <div class="col-12">
        <h5 class="text-white mb-0">{{ $kpa['kpa_name'] }}</h5>
        <small>Weight of the KPA - Core 95%</small>
        </div>
        <div class="row">
        <div class="col-lg-7 col-md-10 col-12 order-2 order-md-1 pt-md-9">
        <h6 class="text-white mt-0 mt-md-3 mb-4">
        <div class="row">
          @foreach($kpa['categories'] as $category)
        <div class="col-6 mb-3 d-flex align-items-center">
        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">88%</p>
        <p class="mb-0">{{ Str::limit($category['category_name'], 15, '...') }}</p>
        </div>
      @endforeach
        </div>
        </h6>
        </div>

        <div class="col-lg-5 col-md-2 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
        <img src="{{ asset('admin/assets/img/illustrations/card-website-analytics-1.png') }}"
        alt="Website Analytics" height="150" class="card-website-analytics-img" />
        </div>
        </div>
      </div>
      </div>
      @endforeach
      </div>
      <div class="swiper-pagination"></div>
      </div>
    </div>

    <!--/ Website Analytics -->

    <!-- Average Daily Sales -->
    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
      <div class="card-header pb-0">
        <h5 class="mb-3 card-title">Average Daily Sales</h5>
        <p class="mb-0 text-body">Total Sales This Month</p>
        <h4 class="mb-0">$28,450</h4>
      </div>
      <div class="card-body px-0">
        <div id="averageDailySales"></div>
      </div>
      </div>
    </div>
    <!--/ Average Daily Sales -->

    <!-- Sales Overview -->
    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
      <div class="card-header">
        <div class="d-flex justify-content-between">
        <p class="mb-0 text-body">Sales Overview</p>
        <p class="card-text fw-medium text-success">+18.2%</p>
        </div>
        <h4 class="card-title mb-1">$42.5k</h4>
      </div>
      <div class="card-body">
        <div class="row">
        <div class="col-4">
          <div class="d-flex gap-2 align-items-center mb-2">
          <span class="badge bg-label-info p-1 rounded"><i
            class="icon-base ti tabler-shopping-cart icon-sm"></i></span>
          <p class="mb-0">Order</p>
          </div>
          <h5 class="mb-0 pt-1">62.2%</h5>
          <small class="text-body-secondary">6,440</small>
        </div>
        <div class="col-4">
          <div class="divider divider-vertical">
          <div class="divider-text">
            <span class="badge-divider-bg bg-label-secondary">VS</span>
          </div>
          </div>
        </div>
        <div class="col-4 text-end">
          <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
          <p class="mb-0">Visits</p>
          <span class="badge bg-label-primary p-1 rounded"><i class="icon-base ti tabler-link icon-sm"></i></span>
          </div>
          <h5 class="mb-0 pt-1">25.5%</h5>
          <small class="text-body-secondary">12,749</small>
        </div>
        </div>
        <div class="d-flex align-items-center mt-6">
        <div class="progress w-100" style="height: 10px;">
          <div class="progress-bar bg-info" style="width: 70%" role="progressbar" aria-valuenow="70"
          aria-valuemin="0" aria-valuemax="100"></div>
          <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30"
          aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        </div>
      </div>
      </div>
    </div>
    <!--/ Sales Overview -->


    <!-- Earning Reports -->
    <div class="col-md-6">
      <div class="card h-100">
      <div class="card-header pb-0 d-flex justify-content-between">
        <div class="card-title mb-0">
        <h5 class="mb-1">Earning Reports</h5>
        <p class="card-subtitle">Weekly Earnings Overview</p>
        </div>
        <div class="dropdown">
        <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1" type="button"
          id="earningReportsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId">
          <a class="dropdown-item" href="javascript:void(0);">View More</a>
          <a class="dropdown-item" href="javascript:void(0);">Delete</a>
        </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row align-items-center g-md-8">
        <div class="col-12 col-md-5 d-flex flex-column">
          <div class="d-flex gap-2 align-items-center mb-3 flex-wrap">
          <h2 class="mb-0">$468</h2>
          <div class="badge rounded bg-label-success">+4.2%</div>
          </div>
          <small class="text-body">You informed of this week compared to last week</small>
        </div>
        <div class="col-12 col-md-7 ps-xl-8">
          <div id="weeklyEarningReports"></div>
        </div>
        </div>
        <div class="border rounded p-5 mt-5">
        <div class="row gap-4 gap-sm-0">
          <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <div class="badge rounded bg-label-primary p-1"><i
              class="icon-base ti tabler-currency-dollar icon-18px"></i></div>
            <h6 class="mb-0 fw-normal">Earnings</h6>
          </div>
          <h4 class="my-2">$545.69</h4>
          <div class="progress w-75" style="height:4px">
            <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0"
            aria-valuemax="100"></div>
          </div>
          </div>
          <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <div class="badge rounded bg-label-info p-1"><i class="icon-base ti tabler-chart-pie-2 icon-18px"></i>
            </div>
            <h6 class="mb-0 fw-normal">Profit</h6>
          </div>
          <h4 class="my-2">$256.34</h4>
          <div class="progress w-75" style="height:4px">
            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
            aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          </div>
          <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <div class="badge rounded bg-label-danger p-1"><i
              class="icon-base ti tabler-brand-paypal icon-18px"></i></div>
            <h6 class="mb-0 fw-normal">Expense</h6>
          </div>
          <h4 class="my-2">$74.19</h4>
          <div class="progress w-75" style="height:4px">
            <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65"
            aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    <!--/ Earning Reports -->

    <!-- Support Tracker -->
    <div class="col-12 col-md-6">
      <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
        <h5 class="mb-1">Teaching and Learning</h5>
        <p class="card-subtitle">Fall 2024</p>
        </div>
        <div class="dropdown">
        <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1" type="button"
          id="supportTrackerMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="supportTrackerMenu">
          <a class="dropdown-item" href="javascript:void(0);">View More</a>
          <a class="dropdown-item" href="javascript:void(0);">Delete</a>
        </div>
        </div>
      </div>
      <div class="card-body row">
        <div class="col-12 col-sm-4">
        <div class="mt-lg-4 mt-lg-2 mb-lg-6 mb-2">
          <!-- <h2 class="mb-0">100</h2> <p class="mb-0">Total</p> -->
        </div>
        <ul class="p-0 m-0">
          <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
          <div class="badge rounded bg-label-primary p-1_5"><i class="icon-base ti tabler-ticket icon-md"></i>
          </div>
          <div>
            <h6 class="mb-0 text-nowrap">Teaching Delivery</h6>
            <small class="text-body-secondary">25%</small>
          </div>
          </li>
          <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
          <div class="badge rounded bg-label-info p-1_5"><i class="icon-base ti tabler-circle-check icon-md"></i>
          </div>
          <div>
            <h6 class="mb-0 text-nowrap">Teaching Management</h6>
            <small class="text-body-secondary">15%</small>
          </div>
          </li>
          <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
          <div class="badge rounded bg-label-warning p-1_5"><i class="icon-base ti tabler-clock icon-md"></i>
          </div>
          <div>
            <h6 class="mb-0 text-nowrap">Teaching Innovation</h6>
            <small class="text-body-secondary">10%</small>
          </div>
          </li>
          <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
          <div class="badge rounded bg-label-warning p-1_5"><i class="icon-base ti tabler-clock icon-md"></i>
          </div>
          <div>
            <h6 class="mb-0 text-nowrap">Teaching Output</h6>
            <small class="text-body-secondary">30%</small>
          </div>
          </li>
          <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
          <div class="badge rounded bg-label-warning p-1_5"><i class="icon-base ti tabler-clock icon-md"></i>
          </div>
          <div>
            <h6 class="mb-0 text-nowrap">Teaching Outcomes-student</h6>
            <small class="text-body-secondary">20%</small>
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

    <!-- Orders last week -->
    <!-- <div class="col-xxl-4 col-md-6">
      <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
      <div class="card-title mb-0">
      <h4 class="mb-0">2.84k</h4>
      <small class="text-body">Avg Daily Traffic</small>
      </div>
      <div class="badge bg-label-success">+15%</div>
      </div>
      <div class="card-body">
      <div id="averageDailyTraffic"></div>
      </div>
      </div>
    </div> -->
    <!-- Orders last week -->

    <!-- Monthly Campaign State -->
    @foreach ($grouped as $kpa)
      @foreach ($kpa['categories'] as $category)
      <div class="col-xxl-4 col-md-6">
      <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
      <div class="card-title mb-0">
      <h5 class="mb-1">{{ $category['category_name'] }}</h5>
      <p class="card-subtitle">
        KPA: {{ $kpa['kpa_name'] }} | Weight: {{ $kpa['kpa_weight'] }}
      </p>
      </div>
      <div class="dropdown">
      <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1" type="button"
        id="MonthlyCampaign" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="MonthlyCampaign">
        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
        <a class="dropdown-item" href="javascript:void(0);">Download</a>
        <a class="dropdown-item" href="javascript:void(0);">View All</a>
      </div>
      </div>
      </div>

      <div class="card-body">
      <ul class="p-0 m-0">
      @foreach ($category['indicators'] as $indicator)
      <li class="mb-6 d-flex justify-content-between align-items-center">
      <div class="badge bg-label-success rounded p-1_5">
      <i class="icon-base ti tabler-mail icon-md"></i>
      </div>
      <div class="d-flex justify-content-between w-100 flex-wrap">
      <h6 class="mb-0 ms-4">{{ $indicator['indicator_name'] }}</h6>
      <div class="d-flex">
      <p class="ms-4 text-success mb-0">
      {{ $indicator['indicator_score'] ?? 'N/A' }}
      </p>
      </div>
      </div>
      </li>
      @endforeach
      </ul>
      </div>
      </div>
      </div>
      @endforeach
    @endforeach

    <!--/ Monthly Campaign State -->

    <!-- Monthly Campaign State -->
    <!-- <div class="col-xxl-4 col-md-6">

    </div> -->
    <!--/ Monthly Campaign State -->

    <!-- Source Visit -->
    <div class="col-xxl-4 col-md-6 col-12">
      <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
        <h5 class="mb-1">Source Visits</h5>
        <p class="card-subtitle">38.4k Visitors</p>
        </div>
        <div class="dropdown">
        <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1" type="button"
          id="sourceVisits" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sourceVisits">
          <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
          <a class="dropdown-item" href="javascript:void(0);">Download</a>
          <a class="dropdown-item" href="javascript:void(0);">View All</a>
        </div>
        </div>
      </div>
      <div class="card-body">
        <ul class="list-unstyled mb-0">
        <li class="mb-6">
          <div class="d-flex align-items-center">
          <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
            class="icon-base ti tabler-shadow icon-md"></i></div>
          <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
            <div class="me-2">
            <h6 class="mb-0">Direct Source</h6>
            <small class="text-body">Direct link click</small>
            </div>
            <div class="d-flex align-items-center">
            <p class="mb-0">1.2k</p>
            <div class="ms-4 badge bg-label-success">+4.2%</div>
            </div>
          </div>
          </div>
        </li>
        <li class="mb-6">
          <div class="d-flex align-items-center">
          <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
            class="icon-base ti tabler-globe icon-md"></i></div>
          <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
            <div class="me-2">
            <h6 class="mb-0">Social Network</h6>
            <small class="text-body">Social Channels</small>
            </div>
            <div class="d-flex align-items-center">
            <p class="mb-0">31.5k</p>
            <div class="ms-4 badge bg-label-success">+8.2%</div>
            </div>
          </div>
          </div>
        </li>
        <li class="mb-6">
          <div class="d-flex align-items-center">
          <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
            class="icon-base ti tabler-mail icon-md"></i></div>
          <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
            <div class="me-2">
            <h6 class="mb-0">Email Newsletter</h6>
            <small class="text-body">Mail Campaigns</small>
            </div>
            <div class="d-flex align-items-center">
            <p class="mb-0">893</p>
            <div class="ms-4 badge bg-label-success">+2.4%</div>
            </div>
          </div>
          </div>
        </li>
        <li class="mb-6">
          <div class="d-flex align-items-center">
          <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
            class="icon-base ti tabler-external-link icon-md"></i></div>
          <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
            <div class="me-2">
            <h6 class="mb-0">Referrals</h6>
            <small class="text-body">Impact Radius Visits</small>
            </div>
            <div class="d-flex align-items-center">
            <p class="mb-0">342</p>
            <div class="ms-4 badge bg-label-danger">-0.4%</div>
            </div>
          </div>
          </div>
        </li>
        <li class="mb-6">
          <div class="d-flex align-items-center">
          <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
            class="icon-base ti tabler-ad icon-md"></i></div>
          <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
            <div class="me-2">
            <h6 class="mb-0">ADVT</h6>
            <small class="text-body">Google ADVT</small>
            </div>
            <div class="d-flex align-items-center">
            <p class="mb-0">2.15k</p>
            <div class="ms-4 badge bg-label-success">+9.1%</div>
            </div>
          </div>
          </div>
        </li>
        <li>
          <div class="d-flex align-items-center">
          <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
            class="icon-base ti tabler-star icon-md"></i></div>
          <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
            <div class="me-2">
            <h6 class="mb-0">Other</h6>
            <small class="text-body">Many Sources</small>
            </div>
            <div class="d-flex align-items-center">
            <p class="mb-0">12.5k</p>
            <div class="ms-4 badge bg-label-success">+6.2%</div>
            </div>
          </div>
          </div>
        </li>
        </ul>
      </div>
      </div>
    </div>
    <!--/ Source Visit -->

    <!-- Projects table -->
    <div class="col-xxl-8">
      <div class="card">
      <div class="table-responsive mb-4">
        <table class="table datatable-project table-sm">
        <thead class="border-top">
          <tr>
          <th></th>
          <th></th>
          <th>Project</th>
          <th>Leader</th>
          <th>Team</th>
          <th class="w-px-200">Progress</th>
          <th>Action</th>
          </tr>
        </thead>
        </table>
      </div>
      </div>
    </div>
    <!--/ Projects table -->
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

  <script>
    document.addEventListener("DOMContentLoaded", function () {
    var options = {
      chart: {
      height: 145,
      type: "bar",
      parentHeightOffset: 0,
      toolbar: { show: false }
      },
      plotOptions: {
      bar: {
        barHeight: "100%",
        columnWidth: "11px",
        startingShape: "rounded",
        endingShape: "rounded",
        borderRadius: 5
      }
      },
      colors: ["#FFB300"],
      grid: {
      show: false,
      padding: { top: -30, left: -18, bottom: -13, right: -18 }
      },
      dataLabels: { enabled: false },
      tooltip: { enabled: true },
      series: [{
      name: "Traffic",
      data: @json($data)  // ✅ Laravel array to JS
      }],
      legend: { show: false },
      xaxis: {
      categories: @json($categories), // ✅ Laravel array to JS
      axisBorder: { show: false },
      axisTicks: { show: false },
      labels: {
        style: { fontSize: "13px", fontFamily: "Arial" },
        show: true
      }
      },
      yaxis: {
      labels: { show: false }
      }
    };

    var chart = new ApexCharts(document.querySelector("#averageDailyTraffic"), options);
    chart.render();
    });
  </script>

@endpush
@extends('layouts.app')
@push('style')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/swiper/swiper.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/cards-advance.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
  <style>
  


    .fs-13 {
      font-size: 13px !important;
    }

    .bg-orange {
      background-color: #fd7e13 !important;
      color: #fd7e13 !important
    }

    .bg-label-orange {
      background-color: color-mix(in sRGB, var(--bs-paper-bg) var(--bs-bg-label-tint-amount), var(--bs-orange)) !important;
      color: var(--bs-orange) !important;
    }

    .card-border-shadow-orange {
      --bs-card-border-bottom-color: #FFF200 !important
    }

    .h-50vh {
      height: 50vh;
    }

    @media (min-width: 992px) {
      .h-lg-100vh {
        height: 400px;
      }
    }

    @media (min-width: 1401px) {
      .h-md-70vh {
        height: 460px;
      }
    }

    /* Wrapper provides positioning and responsive height */
    .flip-card {
      position: relative;
      /* required for absolutely-positioned children */
      width: 100%;
      /* Modern browsers: maintain aspect ratio. Change to suit your card shape. */
      aspect-ratio: 4 / 3;
      /* fallback used when supported */
      overflow: visible;
      perspective: 1000px;
    }

    /* Fallback for browsers that don't support aspect-ratio */
    @supports not (aspect-ratio: 1/1) {
      .flip-card {
        /* 75% gives a 4:3 box. Adjust to 100% for square (padding-top:100%) or 56.25% for 16:9 */
        padding-top: 75%;
      }

      /* Place inner absolutely to fill the padded container */
      .flip-card-inner {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
      }
    }

    /* Inner container handles the flip transform */
    .flip-card-inner {
      position: relative;
      /* relative by default, but absolute in fallback above */
      width: 100%;
      height: 100%;
      transition: transform 0.6s;
      transform-style: preserve-3d;
    }

    /* Hover flip — works on desktop; keep for keyboard focus if desired */
    .flip-card:hover .flip-card-inner,
    .flip-card:focus-within .flip-card-inner {
      transform: rotateY(180deg);
    }

    /* FRONT & BACK faces — fill parent and stack */
    .flip-card-front,
    .flip-card-back {
      position: absolute;
      inset: 0;
      /* shorthand for top:0; right:0; bottom:0; left:0 */
      backface-visibility: hidden;
      -webkit-backface-visibility: hidden;
      border-radius: .5rem;
      /* matches Bootstrap card rounding */
      overflow: hidden;
    }

    /* Ensure card visuals (bootstrap h-100 won't break) */
    .flip-card-front .card,
    .flip-card-back .card {
      height: 100%;
      border: 0;
    }

    /* Back side flipped */
    .flip-card-back {
      transform: rotateY(180deg);
    }

    /* Optional: improve mobile UX — reduce 3D motion and use a vertical flip on narrow screens */
    @media (max-width: 575.98px) {
      .flip-card {
        aspect-ratio: 3 / 2;
        /* make card a little taller on phones if you like */
      }

      /* If you want to disable 3D flip on small screens (touch devices), you can stack back below front */
      /* Uncomment these lines if you prefer a simple reveal instead of 3D on mobile */
      /*
                    .flip-card-inner {
                    transition: none;
                    }
                    .flip-card-front,
                    .flip-card-back {
                    position: relative;
                    transform: none;
                    backface-visibility: visible;
                    }
                    .flip-card-back { display: none; } 
                    */
    }

   

 

 

    

    

   



    

    /* 1. Eye Rolling Animation */

   

   
  </style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Accordion1 -->
    <!-- Hour chart  -->
    @if($departments->isNotEmpty())
    @php
        $scores = $departments->flatMap(function ($department) {
            return $department->user->pluck('as_hod_score');
        });

        $teamscore = round($scores->sum() ?? 0, 2);
        $teamAverage = round($scores->avg() ?? 0, 2);
        $teamcount = round($scores->count() ?? 0, 2);
    @endphp
  <div class="card bg-transparent shadow-none my-6 border-0">
    <div class="card-body row p-0 pb-6 g-6">
      <div class="col-12 col-lg-12 card-separator">
        <h5 class="mb-2">Welcome,<span class="h4"> {{ Auth::user()->name }} 👋🏻</span></h5>
        <div class="d-flex justify-content-between flex-wrap gap-4 me-12">
          <div class="d-flex align-items-center gap-4 me-6 me-sm-0">
            <div class="avatar avatar-lg">
              <div class="avatar-initial bg-label-primary rounded">
                <div class="text-primary">
                 <i class="icon-base ti tabler-scoreboard icon-xl"></i>
                </div>
              </div>
            </div>
            <div class="content-right">
              <p class="mb-0 fw-medium">Total Score</p>
              <h4 class="text-primary mb-0">{{ $teamAverage }}%</h4>
            </div>
          </div>
          <div class="d-flex align-items-center gap-4">
            <div class="avatar avatar-lg">
              <div class="avatar-initial bg-label-info rounded">
                <div class="text-info">
                  <i class="icon-base ti tabler-users icon-xl"></i>
                </div>
              </div>
            </div>
            <div class="content-right">
              <p class="mb-0 fw-medium">Teame Score</p>
              <h4 class="text-info mb-0">{{ $teamscore }}</h4>
            </div>
          </div>
          <div class="d-flex align-items-center gap-4">
            <div class="avatar avatar-lg">
              <div class="avatar-initial bg-label-warning rounded">
                <div class="text-warning">
                 <i class="icon-base ti tabler-number-123 icon-xl"></i>
                </div>
              </div>
            </div>
            <div class="content-right">
              <p class="mb-0 fw-medium">Team Members</p>
              <h4 class="text-warning mb-0">{{ $teamcount }}</h4>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Hour chart End  -->
      <!-- Website Analytics -->

      @foreach($departments as $department)
      <div class="row gy-6 mb-5">
        <div class="col-12">
          {{-- Department Header --}}
        <div class="card border-0 shadow-sm">

            <div class="card-body py-4">

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                    <div class="d-flex align-items-center gap-3">

                        <div class="avatar avatar-xl">
                            <span class="avatar-initial rounded-3 bg-label-primary">
                                <i class="icon-base ti tabler-building icon-lg"></i>
                            </span>
                        </div>

                        <div>
                            <span class="text-muted small fw-medium text-uppercase">
                                Department
                            </span>

                            <h4 class="mb-1 mt-1 fw-bold">
                                {{ $department->name }}
                            </h4>

                            <p class="mb-0 text-muted">
                                <i class="ti tabler-users me-1"></i>
                                Department HODs and performance overview
                            </p>
                        </div>

                    </div>

                    <span class="badge bg-label-primary rounded-pill px-3 py-2">
                        <i class="ti tabler-building me-1"></i>
                        Department ID: {{ $department->id }}
                    </span>

                </div>

            </div>
        </div>
        </div>
       
      @foreach($department->user as $hod)
            <div class="col-12">
           {{-- HOD Profile Header --}}
            <div class="card border-0 shadow-sm">

                <div class="card-body py-3">

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                        <div class="d-flex align-items-center gap-3">

                            <div class="avatar avatar-lg">
                                <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="icon-base ti tabler-user icon-lg"></i>
                                </span>
                            </div>

                            <div>
                                <h5 class="mb-1 fw-bold">
                                    {{ $hod->name }}
                                </h5>

                                <div class="d-flex align-items-center flex-wrap gap-2">

                                    <span class="badge bg-label-success rounded-pill">
                                        <i class="me-1 icon-base ti tabler-shield"></i>
                                        Head of Department
                                    </span>
                                     <span class="badge bg-label-secondary rounded-pill">
                                        <i class="me-1 icon-base ti tabler-scoreboard"></i>
                                       Score: {{ $hod->as_hod_score }}
                                    </span>

                                    <span class="text-muted small">
                                        <i class="ti tabler-id me-1"></i>
                                        Employee ID: {{ $hod->employee_id }}
                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="text-end">
                            <span class="text-muted small d-block">
                                Performance Overview
                            </span>

                            <span class="fw-semibold">
                                <i class="ti tabler-chart-bar text-primary me-1"></i>
                                KPA Performance
                            </span>
                        </div>

                    </div>

                </div>

            </div>
       </div>
       
      @php
        $activeRoleId = getRoleIdByName('HOD');
        $result = getRoleAssignments('HOD');
        $countResult = count($result);
        $icon1 = ['tabler-book', 'tabler-bulb', 'tabler-network', 'tabler-shield-check', 'tabler-star'];
        $static_color = ['primary', 'success', 'warning', 'orange', 'danger'];
        $index2 = 0;
        $totalWeightSS = 0;
      @endphp
      @if($countResult > 3)
        @foreach($result as $kpakey => $kpa)
          @php
            $targetId = strtolower(str_replace(' ', '-', $kpa['performance_area']));
            $iconClass = $icon1[$index2 % count($icon1)];
            $iconClasscolor = $static_color[$index2 % count($static_color)];
            $index2++;

            // Get dynamic average, rating, and color
            $kpaResult = kpaAvgScore($kpa['id'], $hod->employee_id);
            $weight = $kpaResult['weight'];
            $avg = $kpaResult['avg'];
            $weight_ss = $kpaResult['weighted_score'];
            $totalWeightSS += $weight_ss;
            $rating = $kpaResult['rating'];
            $color = $kpaResult['color']; // this will be used for bg and bg-label

            $schroll_sgetRatingByPercentage = getRatingByPercentage($avg);
            $schroll_rating_description = $schroll_sgetRatingByPercentage['description'];

          @endphp

          <div class="{{ getRoleIdByName(activeRole()) == 33 ? 'col-lg-4' : 'col-lg-3' }} col-md-4" id="{{ $targetId }}">
            <a href="" class="text-decoration-none">
              <div class="flip-card h-100">
                <div class="flip-card-inner">

                  <!-- FRONT -->
                  <div class="flip-card-front card bg-{{ $iconClasscolor }} text-white">
                    <div class="card-body position-relative d-flex flex-column justify-content-between">
                      <div>
                        <div class="d-flex align-items-center mb-1">
                          <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-{{ $iconClasscolor }}">
                              <i class="icon-base ti {{ $iconClass }} icon-28px"></i>
                            </span>
                          </div>
                        </div>
                        <p class="mb-0 fw-bold h5 text-white">{{ $kpa['performance_area'] }}</p>
                      </div>
                      <div class="mt-2 d-flex flex-column align-items-end small position-absolute bottom-0 end-0 p-2">
                        <div class="mb-1">
                          <span class="fw-semibold">Score </span> <span
                            class="badge bg-label-{{ $color }}">{{ number_format($avg, 1) }}%</span>
                        </div>
                        <div class="mb-1">
                          <span class="fw-semibold">Rating </span> <span
                            class="badge bg-label-{{ $color }}">{{ $rating }}</span>
                        </div>
                        <div class="mb-1">
                          <span class="fw-semibold">Weight </span> <span
                            class="badge bg-label-{{ $color }}">{{ number_format($weight, 1) }}%</span>
                        </div>
                        <div>
                          <span class="fw-semibold">Weighted Score </span> <span
                            class="badge bg-label-{{ $color }}">{{ number_format($weight_ss, 1) }}%</span>
                        </div>
                      </div>

                    </div>
                  </div>

                  <!-- BACK -->
                  <div class="flip-card-back card bg-{{ $iconClasscolor }} text-dark h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                      <div class="badge rounded p-2 mb-2 bg-label-{{ $iconClasscolor }}">
                        <i class="icon-base ti {{ $iconClass }} icon-lg"></i>
                      </div>
                      <h6 class="mb-2 text-white text-center">{{ $kpa['performance_area'] }}</h6>
                      <p class="text-center mb-0 text-white fs-13">
                        {{ $schroll_rating_description ?? 'Keep performing well in this area!' }}
                      </p>
                    </div>
                  </div>

                </div>
              </div>
            </a>
          </div>
        @endforeach
      @endif
      </div>
      @endforeach
      @endforeach

      <!--/ Website Analytics -->
      @else
           <div class="misc-wrapper">
                <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">401</h1>
                <h4 class="mb-2 mx-2">You are not authorized! 🔐</h4>
                <p class="mb-6 mx-2">You don’t have permission to access this page. Go back!</p>
                <div class="mt-12">
                    <img src="{{ asset('admin/assets/img/illustrations/page-misc-you-are-not-authorized.png') }}" alt="page-misc-not-authorized" width="170" class="img-fluid" />
                </div>
            </div>
      @endif
  
      
  </div>
  <!-- / Content -->
@endsection
@push('script')
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
  <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app-ecommerce-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/js/extended-ui-perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/js/cards-advance.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/swiper/swiper.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/nouislider/nouislider.js') }}"></script>
  <script src="{{ asset('admin/assets/js/front-page-landing.js') }}"></script>
  <script src="{{ asset('admin/assets/js/charts-apex.js') }}"></script>
   
@endpush
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
  <style>
    .avatar-xxl {
      --bs-avatar-size: 6rem;
      --bs-avatar-initial: 1.875rem;
      --bs-avatar-initial-inline: 5px;
    }

    .fs-10 {
      font-size: 10px !important;
    }

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
                                                                                                                                                                                                                                                                                                                                                                                                                                                          .flip-card-back { display: none; } /* or display block on click via JS if needed */
      */
    }

    .caed-wave-bg1 {
      /* background-image: radial-gradient(at left bottom, rgb(252, 247, 234) 65%, rgba(255, 95, 2, 0.52) 100%);
                                                                                                                                                                                                                                                                                                                                                                                                                                                          background-image: radial-gradient(at left bottom, rgba(255, 255, 255, 1) 65%, rgba(74, 2, 255, 0.52) 100%);
                                                                                                                                                                                                                                                                                                                                                                                                                                                          background-image:
                                                                                                                                                                                                                                                                                                                                                                                                                                                          radial-gradient(at top left, rgba(255, 204, 128, 0.8), transparent 60%),
                                                                                                                                                                                                                                                                                                                                                                                                                                                          radial-gradient(at bottom right, rgba(23, 2, 255, 0.6), transparent 60%);

                                                                                                                                                                                                                                                                                                                                                                                                                                                        background-image:
                                                                                                                                                                                                                                                                                                                                                                                                                                                          radial-gradient(at 20% 30%, rgba(255, 200, 150, 0.6), transparent 70%),
                                                                                                                                                                                                                                                                                                                                                                                                                                                          radial-gradient(at 80% 70%, rgba(100, 177, 255, 0.4), transparent 80%),
                                                                                                                                                                                                                                                                                                                                                                                                                                                          radial-gradient(at 50% 50%, rgb(252, 247, 234), transparent 100%);

                                                                                                                                                                                                                                                                                                                                                                                                                                                          background-image: radial-gradient(circle at 30% 70%, #ffebee 0%, #ff8a65 40%, #ff5722 100%);

                                                                                                                                                                                                                                                                                                                                                                                                                                                          */

      background-image:
        radial-gradient(at top left, rgba(255, 204, 128, 0.8), transparent 60%),
        radial-gradient(at bottom right, rgba(23, 2, 255, 0.6), transparent 60%);



      background-size: 200% 200%;
      /* make it larger to allow smooth movement */
      animation: waveMove 5s ease-in-out infinite alternate;
    }

    @keyframes waveMove {
      0% {
        background-position: left bottom;
      }

      50% {
        background-position: right top;
      }

      100% {
        background-position: left top;
      }
    }

    .card-metrics {
      text-align: end;
    }

    .metric-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 70px;
      height: 40px;
      font-size: 14px;
      border-radius: 12px;
      /* square with slightly rounded corners */
      box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
    }
     .heading-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 70px;
      height: 30px;
      font-size: 14px;
      border-radius: 12px;
      /* square with slightly rounded corners */
      box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
    }

    .scgrool-card-h {
      min-height: 91px;
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
    .blink-card {
      animation: blink 1.5s infinite;
    }

    @keyframes blink {

      0%,
      100% {
        opacity: 1;
        transform: scale(1);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
      }

      50% {
        opacity: 0.6;
        transform: scale(1.05);
        box-shadow: 0 0 25px rgba(255, 255, 255, 1);
      }
    }

    .text-cut-hot {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      /* ✅ Limit to 3 lines */
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: normal;
      line-height: 1.2;
    }

    .text-cut-department {
      display: -webkit-box;
      -webkit-line-clamp: 1;
      /* ✅ Limit to 1 lines */
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: normal;
      line-height: 1.2;
      font-size: 0.8667em;
    }
  </style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Accordion1 -->
    <div class="row gy-6">


      <!-- Sales Overview -->
      <div class="col-lg-3 col-md-12 d-flex flex-column">
        <div class="row flex-fill">

          <!-- Generated Leads -->
          <div class="col-lg-12 col-md-6 col-sm-12">
            <div class="card" style="box-shadow: none;background: none;">
              <div class="card-header text-center">
                <div class="card-title mb-0">
                  <h5 class="mb-1">Hi, {{ trim(preg_replace('/[-\s]*\d+$/', '', $employee->name)) }} 🎉</h5>
                  <div class="mb-2 rounded bg-label-success p-1" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-custom-class="tooltip-success" data-bs-original-title="{{ Auth::user()->department }}">
                    <span class=" bg-label-success text-cut-department">
                      {{ Auth::user()->department }}
                    </span>
                  </div>
                  <p class="card-subtitle">Welcome to your Performance Hub</p>

                </div>
              </div>
            </div>
          </div>
          <!--/ Generated Leads -->
          <!-- Profit last month -->
          <div class="col-lg-4 col-md-3 col-sm-6">
            <div class="card h-100" style="background-color: #ac7cad;">
              <div class="card-body d-flex justify-content-center align-items-center ">
                <h6 class="mb-0 text-center text-white">As {{$employee->job_title}}</h6>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-3 col-sm-6">
            <div class="card h-100 {{overallAvgScore(Auth::user()->employee_id)['color']}}">
              <div class="card-body d-flex justify-content-center align-items-center">
                <h5 class="mb-0 text-center" id="avg-teachervalue">0%</h5>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-3 col-sm-6">
            <div class="card h-100" id="rating-teachercolor"data-bs-toggle="tooltip"
              data-bs-placement="top"
              data-bs-custom-class="tooltip-"
              data-bs-original-title="You’re going beyond what’s asked of you.">
              <div class="card-body d-flex justify-content-center align-items-center">
                <h4 class="mb-0 text-center text-white" id="rating-teachervalue"></h4>
              </div>
            </div>
          </div>
          <!--/ Expenses -->
        </div>
      </div>
      <!--/ Sales Overview -->

      <!-- Website Analytics -->
      @php
        $result = getRoleAssignments($employee->roles->first()->name);
        $icon1 = ['tabler-book', 'tabler-bulb', 'tabler-network', 'tabler-shield-check', 'tabler-star'];
        $static_color = ['primary', 'success', 'warning', 'orange', 'danger'];
        $index2 = 0;
        $totalWeightSS = 0;
      @endphp

      @foreach($result as $kpakey => $kpa)
        @php
          $targetId = strtolower(str_replace(' ', '-', $kpa['performance_area']));
          $iconClass = $icon1[$index2 % count($icon1)];
          $iconClasscolor = $static_color[$index2 % count($static_color)];
          $index2++;

          // Get dynamic average, rating, and color
          $kpaResult = kpaAvgScore($kpa['id'], Auth::user()->employee_id);
          $kpaAvgWeightage = kpaAvgWeightage($kpa['id'], 21);
          $weight=$kpaAvgWeightage['kpa_weightage'];
          
          $avg = $kpaResult['avg'];
          $weight_ss=($avg*$weight)/100;
           $totalWeightSS += $weight_ss;
          $rating = $kpaResult['rating'];
          $color = $kpaResult['color']; // this will be used for bg and bg-label

          $schroll_sgetRatingByPercentage = getRatingByPercentage($avg);
          $schroll_rating_description = $schroll_sgetRatingByPercentage['description'];

        @endphp

        <div class="col-lg-3 col-md-4" id="{{ $targetId }}">
          <a href="{{ route('kpa.report', ['id' => $kpa['id']]) }}" class="text-decoration-none">
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

                    <!-- Metrics bottom right -->
                    {{-- <div class="card-metrics mt-2 text-end position-absolute bottom-0 end-0 p-2">
                      <span class="metric-badge bg-label-{{ $color }} fw-bold">{{ $avg }}</span>
                      <span class="metric-badge bg-label-{{ $color }} fw-bold">{{ $rating }}</span>
                      <span class="metric-badge bg-label-{{ $color }} fw-bold" style="width: 80px;">{{ $weight_ss }}/{{ $weight }}</span>
                     
                    </div> --}}
                    {{-- <div class="position-absolute bottom-0 end-0 p-2">

                        <div class="row gx-2 m-0">
                          <div class="col-4 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                              <span class="heading-badge bg-label-{{ $color }}">Score</span>
                            </div>
                            <span class="metric-badge bg-label-{{ $color }} mt-2">{{ $avg }}</span>
                          </div>
                        <div class="col-4 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                              <span class="heading-badge bg-label-{{ $color }}">Rating</span>
                            </div>
                            <span class="metric-badge bg-label-{{ $color }} mt-2">{{ $rating }}</span>
                          </div>
                          <div class="col-4 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                              <span class="heading-badge bg-label-{{ $color }}">Weight</span>
                            </div>
                            <span class="metric-badge bg-label-{{ $color }} mt-2">{{ $weight_ss }}</span>
                          </div>
                          </div>
                    </div> --}}
                    {{-- <div class="mt-2">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-white fw-semibold">Score:</span>
                                <span class="badge bg-label-{{ $color }}">{{ $avg }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-white fw-semibold">Rating:</span>
                                <span class="badge bg-label-{{ $color }}">{{ $rating }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-white fw-semibold">Weight:</span>
                                <span class="badge bg-label-{{ $color }}">{{ $weight_ss }}</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-white fw-semibold">Weighted Score:</span>
                                <span class="badge bg-label-{{ $color }}">{{ $weight_ss }}</span>
                            </div>
                        </div> --}}
                       <div class="mt-2 d-flex flex-column align-items-end small position-absolute bottom-0 end-0 p-2">
                          <div class="mb-1">
                            <span class="fw-semibold">Score </span> <span class="badge bg-label-{{ $color }}">{{ number_format($avg, 1) }}%</span>
                          </div>
                          <div class="mb-1">
                            <span class="fw-semibold">Rating </span> <span class="badge bg-label-{{ $color }}">{{ $rating }}</span>
                          </div>
                          <div class="mb-1">
                            <span class="fw-semibold">Weight </span> <span class="badge bg-label-{{ $color }}">{{ number_format($weight, 1) }}%</span>
                          </div>
                          <div>
                            <span class="fw-semibold">Weighted Score </span> <span class="badge bg-label-{{ $color }}">{{ number_format($weight_ss, 1) }}%</span>
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

      <!--/ Website Analytics -->

    </div>
    <div class="row gy-6 mt-2">

      <div class="col-md-6 col-lg-4">
        <div class="d-flex justify-content-between">
          <h5 class="fw-bold">Key Indicators</h5>
        </div>
        <!--/ Statistics -->
        <div class="scrollableCol" style="height:409px; overflow:auto; scrollbar-width: none;">
          @php

            $st_sgetRatingByPercentage = getRatingByPercentage(-1);
            $st_srating_description = $st_sgetRatingByPercentage['description'];

          @endphp
          <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-warning" data-bs-original-title="{{ $st_srating_description }}">
            <div class="card-body d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-secondary rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-mood-smile icon-md"></i>
                </div>
                <div>
                  <small class="text-dark text-cut-hot">Student Satisfaction</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-orange" role="progressbar" style="width: 0%" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">0%</span>
                <span class="badge bg-label-secondary ms-1">N/A</span>
              </div>
            </div>
          </div>
          @php
            // Get dynamic average, rating, and color
            $kpaResult = indicatorAvgScore(117, Auth::user()->employee_id);
            $avg = $kpaResult['avg'] ?? 0;
            $rating = $kpaResult['rating'] ?? 0;
            $color = $kpaResult['color'] ?? 'secondary'; // this will be used for bg and bg-label
            $getRatingByPercentage = getRatingByPercentage($avg);
            $rating_description = $getRatingByPercentage['description'];

          @endphp
          <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-{{$color}}" data-bs-original-title="{{ $rating_description }}">
            <div class="card-body d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-{{$color}} rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-chalkboard icon-md"></i></div>
                <div>
                  <small class="text-dark text-cut-hot">Classes Held</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-{{$color}}" role="progressbar" style="width: {{$avg}}%"
                    aria-valuenow="{{$avg}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">{{$avg}}%</span>
                <span class="badge bg-label-{{$color}} ms-1">{{$rating}}</span>
              </div>
            </div>
          </div>

          <!-- <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
                                                                                                                                                                                            data-bs-custom-class="tooltip-warning"
                                                                                                                                                                                            data-bs-original-title="You’re doing well and meeting your goals.Keep your consistency — it’s your strength.">
                                                                                                                                                                                            <div class="card-body d-flex">
                                                                                                                                                                                              <div class="d-flex w-50 align-items-center me-4">
                                                                                                                                                                                                <div class="badge bg-label-warning rounded p-1_5 me-4"><i
                                                                                                                                                                                                    class="icon-base ti tabler-user-check icon-md"></i></div>
                                                                                                                                                                                                <div>
                                                                                                                                                                                                  <small class="text-dark text-cut-hot">Student Attendance</small>
                                                                                                                                                                                                </div>
                                                                                                                                                                                              </div>
                                                                                                                                                                                              <div class="d-flex flex-grow-1 align-items-center">
                                                                                                                                                                                                <div class="progress w-100 me-4" style="height:8px;">
                                                                                                                                                                                                  <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65"
                                                                                                                                                                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                <span class="text-body-secondary">70%</span>
                                                                                                                                                                                                <span class="badge bg-label-warning ms-1">ME</span>
                                                                                                                                                                                              </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                          </div> -->
          @php
            // Get dynamic average, rating, and color
            $kpaResult = indicatorAvgScore(128, Auth::user()->employee_id);
            $avg = $kpaResult['avg'] ?? 0;
            $rating = $kpaResult['rating'] ?? 0;
            $color = $kpaResult['color'] ?? 'secondary'; // this will be used for bg and bg-label
            $re_getRatingByPercentage = getRatingByPercentage($avg);
            $re_rating_description = $re_getRatingByPercentage['description'];

            $kpaResultManager = indicatorAvgScore(188, Auth::user()->employee_id);
            $avgManager = $kpaResultManager['avg'] ?? 0;
            $ratingManager = $kpaResultManager['rating'] ?? 0;
            $colorManager = $kpaResultManager['color'] ?? 'secondary';
            $ms_getRatingByPercentage = getRatingByPercentage($avgManager);
            $ms_rating_description = $ms_getRatingByPercentage['description'];

          @endphp
          <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-{{$color}}" data-bs-original-title="{{ $re_rating_description }}">
            <div class="card-body d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-{{$color}} rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-book-2 icon-md"></i>
                </div>
                <div>
                  <small class="text-dark text-cut-hot">Research Publications</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-{{$color}}" role="progressbar" style="width: {{$avg}}%"
                    aria-valuenow="{{$avg}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">{{$avg}}%</span>
                <span class="badge bg-label-{{$color}} ms-1">{{$rating}}</span>
              </div>
            </div>
          </div>

          <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-{{$colorManager}}" data-bs-original-title="{{ $ms_rating_description }}">
            <div class="card-body d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-{{$colorManager}} rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-stars icon-md"></i>
                </div>
                <div>
                  <small class="text-dark text-cut-hot">Manager Satisfaction</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-{{$colorManager}}" role="progressbar" style="width: {{$avgManager}}%"
                    aria-valuenow="{{$avgManager}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">{{$avgManager}}%</span>
                <span class="badge bg-label-{{$colorManager}} ms-1">{{$ratingManager}}</span>
              </div>
            </div>
          </div>
          @php
            // Get dynamic average, rating, and color
            $courseloadkpaResult = indicatorAvgScore(122, Auth::user()->employee_id);
            $courseloadavg = $courseloadkpaResult['avg'] ?? 0;
            $courseloadrating = $courseloadkpaResult['rating'] ?? 0;
            $courseloadcolor = $courseloadkpaResult['color'] ?? 'secondary'; // this will be used for bg and bg-label
            $courseloadgetRatingByPercentage = getRatingByPercentage($courseloadavg);
            $courseload_description = $courseloadgetRatingByPercentage['description'];

          @endphp
          <div class="card scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-{{$courseloadcolor}}" data-bs-original-title="{{ $courseload_description }}">
            <div class="card-body d-flex">
              <div class="d-flex w-50 align-items-center me-4">
                <div class="badge bg-label-{{$courseloadcolor}} rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-stars icon-md"></i>
                </div>
                <div>
                  <small class="text-dark text-cut-hot">Course Load</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center">
                <div class="progress w-100 me-4" style="height:8px;">
                  <div class="progress-bar bg-{{$courseloadcolor}}" role="progressbar" style="width: {{$courseloadavg}}%"
                    aria-valuenow="{{$courseloadavg}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-body-secondary">{{$courseloadavg}}%</span>
                <span class="badge bg-label-{{$courseloadcolor}} ms-1">{{$courseloadrating}}</span>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-md-6 col-lg-4">

        <div class=" d-flex justify-content-between">
          <h5 class="fw-bold">Top Performers</h5>
        </div>
        <div class="scrollableCol" style="height:409px; overflow:auto; scrollbar-width: none;">


          <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-secondary" data-bs-original-title="Yet there is no top performer !">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-secondary rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-mood-empty icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-cut">Yet there is no top performer !</h6>
                  <small class="text-dark fs-10 text-cut">...</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

              </div>
            </div>
          </div>

          <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-secondary" data-bs-original-title="Yet there is no top performer !">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-secondary rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-mood-empty icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-cut">Yet there is no top performer !</h6>
                  <small class="text-dark fs-10 text-cut">...</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

              </div>
            </div>
          </div>

          <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-secondary" data-bs-original-title="Yet there is no top performer !">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-secondary rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-mood-empty icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-cut">Yet there is no top performer !</h6>
                  <small class="text-dark fs-10 text-cut">...</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

              </div>
            </div>
          </div>


          <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-secondary" data-bs-original-title="Yet there is no top performer !">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-secondary rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-mood-empty icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-cut">Yet there is no top performer !</h6>
                  <small class="text-dark fs-10 text-cut">...</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

              </div>
            </div>
          </div>


          <div class="card" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="tooltip-secondary"
            data-bs-original-title="Yet there is no top performer !">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-secondary rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-mood-empty icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-cut">Yet there is no top performer !</h6>
                  <small class="text-dark fs-10 text-cut">...</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

              </div>
            </div>
          </div>




          {{-- <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-custom-class="tooltip-success" data-bs-original-title="(Lecturer) Department of Software Engineering">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-success rounded p-1_5 me-4"><i class="icon-base ti tabler-trophy icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-cut">Haider Ali</h6>
                  <small class="text-dark fs-10 text-cut">Department of Software Engineering</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

                <span class="badge bg-label-success ms-1">82</span>
                <span class="badge bg-label-success ms-1">EE</span>
              </div>
            </div>
          </div>



          <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="tooltip-primary"
            data-bs-original-title="(Lecturer) Superior University Franchise.">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-primary rounded p-1_5 me-4"><i class="icon-base ti tabler-trophy icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-cut">Sadia Ashraf</h6>
                  <small class="text-dark fs-10 text-cut">Superior University Franchise</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

                <span class="badge bg-label-primary ms-1">91</span>
                <span class="badge bg-label-primary ms-1">OS</span>
              </div>
            </div>
          </div>

          <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="tooltip-warning"
            data-bs-original-title="(Lecturer) Superior University Franchise">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-warning rounded p-1_5 me-4"><i class="icon-base ti tabler-award icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-cut">Amna Ilyas</h6>
                  <small class="text-dark fs-10 text-cut">Superior University Franchise</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

                <span class="badge bg-label-warning ms-1">70</span>
                <span class="badge bg-label-warning ms-1">ME</span>
              </div>
            </div>
          </div>


          <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="tooltip-danger"
            data-bs-original-title="(Lecturer) Teaching">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-danger rounded p-1_5 me-4"><i
                    class="icon-base ti tabler-trophy-off icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-cut">Muhammad Ashraf</h6>

                  <small class="text-dark fs-10 text-cut">Teaching</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

                <span class="badge bg-label-danger ms-1">50</span>
                <span class="badge bg-label-danger ms-1">BE</span>
              </div>
            </div>
          </div>



          <div class="card" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="tooltip-warning"
            data-bs-original-title="(Lecturer) Faisalabad - Uni Campus">
            <div class="card-body d-flex">
              <div class="d-flex w-70 align-items-center me-4">
                <div class="badge bg-label-warning rounded p-1_5 me-4"><i class="icon-base ti tabler-award icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0">Rashid Hussain</h6>
                  <small class="text-dark fs-10">Faisalabad - Uni Campus</small>
                </div>
              </div>
              <div class="d-flex flex-grow-1 align-items-center justify-content-end">

                <span class="badge bg-label-warning ms-1">70</span>
                <span class="badge bg-label-warning ms-1">ME</span>
              </div>
            </div>
          </div> --}}
        </div>

      </div>

      <div class="col-md-6 col-lg-4">
        <div class=" d-flex justify-content-between">
          <h5 class="fw-bold">Overall KPA Performance</h5>
        </div>
        <div class="row g-6">
          <!-- Profit last month -->
          <!-- Generated Leads -->
          <div class="col-xl-12">
            <div class="card caed-wave-bg ">
              <div class="card-header d-flex justify-content-between">
                <div class="card-title mb-0">
                  <button type="button" class="btn rounded-pill btn-outline-primary waves-effect"><span
                      class="icon-xs icon-base ti tabler-chart-pie me-2"></span>Overall </button>
                </div>
                <div class="dropdown" data-bs-toggle="tooltip" data-bs-placement="top"
                  data-bs-original-title="View large">
                  <button class="btn  rounded-pill text-body-secondary border-0 p-2 me-n1 waves-effect" type="button"
                    data-bs-toggle="modal" data-bs-target="#fullscreenModal">
                    <i class="icon-base ti tabler-arrows-maximize"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chartjs" id="radarChart1"></canvas>
              </div>
            </div>

          </div>

          <!--/ Generated Leads -->


          <!--/ Expenses -->
        </div>





      </div>





      <!-- Website Analytics -->
      <div class="col-xl-4 col">

        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Research Innovation & Commercialization</h5>

          </div>
          <div class="card-body">
            <div id="carrierPerformance"></div>
            <div id="carrierCustomLegend" class="d-flex justify-content-center flex-wrap mt-3"></div>
          </div>
        </div>
      </div>
      <!--/ Website Analytics -->

      <!-- Average Daily Sales -->
      <div class="col-xl-4 col-sm-6">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h5 class="m-0 me-2">Virtue Mirror</h5>
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
            <div class="card-title mb-0">
              <h5 class="m-0 me-2">Milestones Unlocked</h5>
              <p class="card-subtitle">Each badge tells your success story.</p>
            </div>
          </div>
          <div class="px-5 py-4 border border-start-0 border-end-0">
            <div class="d-flex justify-content-between align-items-center">
              <p class="mb-0 text-uppercase">Achievements</p>
              <p class="mb-0 text-uppercase">Scores</p>
            </div>
          </div>
          <div id="scrollableCol">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-6">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar me-4">
                    <img src="{{ asset('admin/assets/img/avatars/gold-badge.png') }}" alt="Avatar"
                      class="rounded-circle" />
                  </div>
                  <div>
                    <div>
                      <h6 class="mb-0 text-truncate">Research Publications</h6>
                    </div>
                  </div>
                </div>
                <div class="text-end">
                  <h6 class="mb-0">150</h6>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-6">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar me-4">
                    <img src="{{ asset('admin/assets/img/avatars/gold-badge.png') }}" alt="Avatar"
                      class="rounded-circle" />
                  </div>
                  <div>
                    <div>
                      <h6 class="mb-0 text-truncate">Course Load</h6>
                    </div>
                  </div>
                </div>
                <div class="text-end">
                  <h6 class="mb-0">100</h6>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-6">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar me-4">
                    <img src="{{ asset('admin/assets/img/avatars/silver-badge.png') }}" alt="Avatar"
                      class="rounded-circle" />
                  </div>
                  <div>
                    <div>
                      <h6 class="mb-0 text-truncate">Manager Satisfaction</h6>
                    </div>
                  </div>
                </div>
                <div class="text-end">
                  <h6 class="mb-0">90</h6>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-6">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar me-4">
                    <img src="{{ asset('admin/assets/img/avatars/bronze-badge.png') }}" alt="Avatar"
                      class="rounded-circle" />
                  </div>
                  <div>
                    <div>
                      <h6 class="mb-0 text-truncate">Classes Held</h6>
                    </div>
                  </div>
                </div>
                <div class="text-end">
                  <h6 class="mb-0">59.05</h6>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-6">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar me-4">
                    <img src="{{ asset('admin/assets/img/avatars/bronze-badge.png') }}" alt="Avatar"
                      class="rounded-circle" />
                  </div>
                  <div>
                    <div>
                      <h6 class="mb-0 text-truncate">Completion of Course Folder</h6>
                    </div>
                  </div>
                </div>
                <div class="text-end">
                  <h6 class="mb-0">60</h6>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-6">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar me-4">
                    <img src="{{ asset('admin/assets/img/avatars/silver-badge.png') }}" alt="Avatar"
                      class="rounded-circle" />
                  </div>
                  <div>
                    <div>
                      <h6 class="mb-0 text-truncate">Event Performance Feedback</h6>
                    </div>
                  </div>
                </div>
                <div class="text-end">
                  <h6 class="mb-0">80</h6>
                </div>
              </div>
            </div>


          </div>

        </div>
      </div>
    </div>
    <!--/ Website Analytics -->


  </div>
  <!--/ Accordion1 -->





  <!-- Modal -->
  <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFullTitle">Overall KPA Performance</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">



          <div class="row g-6 pt-2">
            <div class="col-12 col-12" id="targetDivchart">
              <div class="card caed-wave-bg">

                <div class="card-header d-flex justify-content-between">
                  <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                    <input type="radio" class="btn-check" name="termRadio" id="overall" checked>
                    <label class="btn btn-outline-primary waves-effect" for="overall">📆 Overall</label>

                    <input type="radio" class="btn-check" name="termRadio" id="spring25">
                    <label class="btn btn-outline-primary waves-effect" for="spring25">📆 Spring 2025</label>

                    <input type="radio" class="btn-check" name="termRadio" id="fall25">
                    <label class="btn btn-outline-primary waves-effect" for="fall25">📆 Fall 2025</label>
                  </div>
                </div>

                <div class="card-body pt-0">
                  <div class="row justify-content-center text-center">
                    <div class="col-md-8 d-flex justify-content-center">
                      <canvas class="chartjs" id="radarChart"></canvas>
                    </div>

                    <div class="col-12 mt-2">
                      <ul id="customLegend" class="d-flex justify-content-center flex-wrap p-0 m-0"
                        style="list-style:none;">
                      </ul>
                    </div>
                  </div>
                </div>


              </div>
            </div>
          </div>







        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
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
  <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
  <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app-ecommerce-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/js/extended-ui-perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/js/cards-advance.js') }}"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      let total = {{ $totalWeightSS }};
      total = parseFloat(total.toFixed(1));
     
      const elements = document.querySelectorAll('.text-cut');
      function getRatingAndColor(percentage) {
        let rating = '';
        let color = '';

        if (percentage >= 90) {
            rating = 'OS';
            color = '#6EA8FE';
        } else if (percentage >= 80) {
            rating = 'EE';
            color = '#96e2b4';
        } else if (percentage >= 70) {
            rating = 'ME';
            color = '#ffcb9a';
        } else if (percentage >= 60) {
            rating = 'NI';
            color = '#fd7e13';
        } else if (percentage > 0) {
            rating = 'BE';
            color = '#ff4c51';
        } else {
            rating = 'NA';
            color = '#000000';
        }

        return { rating, color };
    }

      let result = getRatingAndColor(total);
      let avgElement = document.getElementById('avg-teachervalue');
      let ratingElement = document.getElementById('rating-teachervalue');
      let ratingColor = document.getElementById('rating-teachercolor');
      
      if (avgElement) {
        
          avgElement.innerText = total.toFixed(1) + '%';
      }
      if (ratingElement) {
          ratingElement.innerText = result.rating;
      }
      if (ratingColor) {
          ratingColor.style.backgroundColor = result.color;
      }

      function fitToOneLine(el) {
        const originalText = el.dataset.originalText || el.textContent.trim();
        el.dataset.originalText = originalText;

        // Create hidden clone to measure one-line height
        const clone = el.cloneNode(true);
        clone.style.whiteSpace = "nowrap";
        clone.style.visibility = "hidden";
        clone.style.position = "absolute";
        clone.style.width = el.offsetWidth + "px";
        document.body.appendChild(clone);
        const singleLineHeight = clone.scrollHeight;
        document.body.removeChild(clone);

        const actualHeight = el.scrollHeight;

        // ✅ If text has wrapped
        if (actualHeight > singleLineHeight) {
          let text = originalText;
          let low = 0;
          let high = text.length;
          let fitText = text;

          // Binary search for the perfect cutoff point
          while (low <= high) {
            const mid = Math.floor((low + high) / 2);
            el.textContent = text.slice(0, mid) + '...';

            if (el.scrollHeight > singleLineHeight) {
              high = mid - 1;
            } else {
              fitText = text.slice(0, mid);
              low = mid + 1;
            }
          }

          el.textContent = fitText.trim() + '...';
        } else {
          el.textContent = originalText;
        }
      }

      // ✅ Wait for fonts and layout to finish loading
      window.addEventListener('load', function () {
        elements.forEach(el => fitToOneLine(el));
      });

      // ✅ Handle window resize dynamically
      window.addEventListener('resize', function () {
        elements.forEach(el => fitToOneLine(el));
      });
    });
    document.addEventListener("DOMContentLoaded", function () {
      const scrollableDiv = document.getElementById("scrollableCol");
      const maxHeight = 331;

      scrollableDiv.style.maxHeight = `${maxHeight}px`;
      scrollableDiv.style.overflowY = "auto";
      scrollableDiv.style.overflowX = "hidden";

      // Show scrollbar normally
      const style = document.createElement("style");
      style.innerHTML = `#scrollableCol::-webkit-scrollbar { width: 8px; }`;
      document.head.appendChild(style);

      // Adjust height on resize (static for now)
      window.addEventListener("resize", () => {
        scrollableDiv.style.maxHeight = `${maxHeight}px`;
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      const scrollableDivs = document.querySelectorAll(".scrollableCol");
      let isSyncingScroll = false;

      scrollableDivs.forEach(div => {
        div.addEventListener("scroll", () => {
          if (isSyncingScroll) return;
          isSyncingScroll = true;

          const scrollTop = div.scrollTop;

          scrollableDivs.forEach(otherDiv => {
            if (otherDiv !== div) {
              otherDiv.scrollTop = scrollTop; // instant sync
            }
          });

          isSyncingScroll = false;
        });
      });
    });



    document.addEventListener("DOMContentLoaded", function () {
      const scrollableDiv = document.getElementById("scrollableCol1");
      const windowHeight = window.innerHeight;

      // Set scroll height dynamically based on window height
      const maxHeight = 409;
      scrollableDiv.style.maxHeight = `${maxHeight}px`;

      // Enable vertical scroll
      scrollableDiv.style.overflowY = "auto";
      scrollableDiv.style.scrollBehavior = "smooth";

      // Optional: hide scrollbar (still scrolls)
      scrollableDiv.style.msOverflowStyle = "none"; // IE/Edge
      scrollableDiv.style.scrollbarWidth = "none";  // Firefox
      scrollableDiv.style.overflowX = "hidden";

      // For Chrome/Safari — hide scrollbar visually
      const style = document.createElement("style");
      style.innerHTML = `
                                                                                                                                                                                                                                                                                                                                                                                                                                                          #scrollableCol1::-webkit-scrollbar { width: 0; background: transparent; }
                                                                                                                                                                                                                                                                                                                                                                                                                                                        `;
      document.head.appendChild(style);

      // Auto adjust on window resize
      window.addEventListener("resize", () => {
        scrollableDiv.style.maxHeight = `${newHeight}px`;
      });
    });
    document.addEventListener("DOMContentLoaded", function () {
      // Backend data
      var chartLabels = [
        "Teaching and Learning",
        "Research, Innovation and Commercialisation",
        "Institutional Engagement"
      ];
      var shortLabels = ["T&L", "RIC", "IE"];
      var dataset1 = @json($dataset1) || []; // dataset from backend
      var labelColors = ["#e74c3c", "#3498db", "#27ae60"];

      // Combine all arrays into one array of objects to maintain relationships
      var radarData = dataset1.map((score, index) => ({
        score: score,
        label: chartLabels[index],
        shortLabel: shortLabels[index],
        color: labelColors[index]
      }));

      // Sort by score descending (highest to lowest)
      radarData.sort((a, b) => b.score - a.score);

      // Separate back into individual arrays
      chartLabels = radarData.map(item => item.label);
      shortLabels = radarData.map(item => item.shortLabel);
      dataset1 = radarData.map(item => item.score);
      labelColors = radarData.map(item => item.color);

      // Create chart
      var ctx = document.getElementById("radarChart").getContext("2d");

      var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
      gradientPink.addColorStop(0, "rgba(115, 103, 240, 0.3)");
      gradientPink.addColorStop(1, "rgba(115, 103, 240, 0.5)");

      var radarChart = new Chart(ctx, {
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
              pointBackgroundColor: labelColors,
              pointBorderColor: labelColors,
              pointRadius: 5,
              pointHoverRadius: 8,
              pointStyle: "circle"
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            r: {
              ticks: { display: true, color: "#666" },
              grid: { color: "#ddd" },
              angleLines: { color: "#ddd" },
              pointLabels: {
                font: { size: 9 },
                color: (context) => labelColors[context.index],
                callback: (label, index) => shortLabels[index]
              }
            }
          },
          plugins: { legend: { display: false } }
        }
      });

      // ✅ Custom Legend
      var legendDiv = document.getElementById("customLegend");
      legendDiv.innerHTML = ""; // clear previous legend
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
        legendDiv.appendChild(li);
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      // Backend data
      var chartLabels = [
        "Teaching and Learning",
        "Research, Innovation and Commercialisation",
        "Institutional Engagement"
      ];
      var shortLabels = ["T&L", "RIC", "IE"];
      var dataset1 = @json($dataset1) || []; // dataset from backend
      var labelColors = ["#e74c3c", "#3498db", "#27ae60"];

      // Combine all arrays to maintain the relationships
      var radarData = dataset1.map((score, index) => ({
        score: score,
        label: chartLabels[index],
        shortLabel: shortLabels[index],
        color: labelColors[index]
      }));

      // Sort by score descending (highest to lowest)
      radarData.sort((a, b) => b.score - a.score);

      // Separate back into individual arrays
      chartLabels = radarData.map(item => item.label);
      shortLabels = radarData.map(item => item.shortLabel);
      dataset1 = radarData.map(item => item.score);
      labelColors = radarData.map(item => item.color);

      // Chart setup
      var ctx = document.getElementById("radarChart1").getContext("2d");

      var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
      gradientPink.addColorStop(0, "rgba(115, 103, 240, 0.3)");
      gradientPink.addColorStop(1, "rgba(115, 103, 240, 0.5)");

      var radarChart = new Chart(ctx, {
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
              pointBackgroundColor: labelColors,
              pointBorderColor: labelColors,
              pointRadius: 5,
              pointHoverRadius: 8,
              pointStyle: "circle"
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            r: {
              ticks: { display: true, color: "#666" },
              grid: { color: "#ddd" },
              angleLines: { color: "#ddd" },
              pointLabels: {
                font: { size: 9 },
                color: (context) => labelColors[context.index],
                callback: (label, index) => shortLabels[index]
              }
            }
          },
          plugins: { legend: { display: false } }
        },
        plugins: [
          {
            id: "pointLabelClick",
            afterEvent(chart, args) {
              const { event } = args;
              if (!event) return;

              const rScale = chart.scales.r;
              let hovering = false;

              chart.data.labels.forEach((label, i) => {
                const point = rScale.getPointPositionForValue(i, rScale.max);
                const padding = 30;

                if (
                  event.x >= point.x - padding &&
                  event.x <= point.x + padding &&
                  event.y >= point.y - padding &&
                  event.y <= point.y + padding
                ) {
                  hovering = true;

                  if (event.type === "click") {
                    const targetId = label.replace(/\s+/g, "-").toLowerCase();
                    const targetDiv = document.getElementById(targetId);

                    if (targetDiv) {
                      targetDiv.scrollIntoView({ behavior: "smooth", block: "center" });
                      const collapseEl = targetDiv.querySelector(".accordion-collapse");
                      if (collapseEl && !collapseEl.classList.contains("show")) {
                        new bootstrap.Collapse(collapseEl, { toggle: true });
                      }
                      document.querySelectorAll(".accordion-item").forEach((item) =>
                        item.classList.remove("active")
                      );
                      targetDiv.classList.add("active");
                    }
                  }
                }
              });

              chart.canvas.style.cursor = hovering ? "pointer" : "default";
            }
          }
        ]
      });

      // ✅ Custom Legend
      var legendDiv = document.getElementById("customLegend1");
      legendDiv.innerHTML = ""; // clear existing legend
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
        legendDiv.appendChild(li);
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      const c = document.querySelector("#carrierPerformance");
      const researchData = @json($researchData);
      const categories = Object.values(researchData).map(item => item.title);
      const cod = Object.values(researchData).map(item => item.cod);
      // Distinct color for each category
      const colors = [
        "#1F77B4", // Publication
        "#FF7F0E", // Projects
        "#2CA02C"
      ];
      // Lighter versions for "Achieved"
      const lightColors = [
        "#6BAED6", // lighter blue
        "#FFBB78", // lighter orange
        "#98DF8A"
      ];
      // Build series dynamically
      const targetSeries = Object.values(researchData).map((item, i) => ({
        x: item.cod,
        y: item.target,
        fillColor: colors[i] // use your colors array
      }));

      const achievedSeries = Object.values(researchData).map((item, i) => ({
        x: item.cod,
        y: item.achieved,
        fillColor: lightColors[i] // use lighter colors array
      }));
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
          { name: "Target", data: targetSeries },
          { name: "Achieved", data: achievedSeries }
        ],
        xaxis: {
          categories: cod,
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
          item.innerHTML = `<span style="width:14px;height:14px;background:${colors[i]};border-radius:50%;display:inline-block;margin-right:6px;"></span><span style="font-size:13px;color:#6e6b7b;">${label}</span>`;
          legendContainer.appendChild(item);
        });
      }
    });

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
      const dataset3 = [70, 70, 90, 70, 90, 90];
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
            },
            {
              label: "Student",
              data: dataset3,
              fill: true,
              borderColor: "rgba(85, 255, 0, 1)",
              borderWidth: 2,
              pointBorderColor: "#00ff26ff",
              pointBackgroundColor: "rgba(30, 255, 0, 1)",
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
      const checkboxColors = ["#FF55B8", "#5555FF", "#00ff0dff"]; // Inside Mirror, Social Mirror

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

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  </script>

@endpush
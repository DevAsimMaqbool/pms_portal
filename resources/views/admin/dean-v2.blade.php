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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/front-page-landing.css') }}" />
    <style>
        .fs-10 {
            font-size: 10px !important;
        }

        .fs-13 {
            font-size: 13px !important;
        }

        .bg-orange,
        .bg-label-orange {

            background-color: color-mix(in sRGB, var(--bs-paper-bg) var(--bs-bg-label-tint-amount), var(--bs-orange)) !important;
            color: #fd7e14 !important
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
            width: 50px;
            height: 50px;
            font-size: 14px;
            margin-left: 6px;
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
        .fs-637 {
            font-size: 0.6500rem !important;
        }

        .fs-6000 {
            font-size: 0.6000rem !important;
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
                                    <h5 class="mb-1">Hi, {{ trim(preg_replace('/[-\s]*\d+$/', '', Auth::user()->name)) }} 🎉
                                    </h5>
                                    <span class="mb-2 badge rounded bg-label-success"
                                        style="display: inline-block; vertical-align: middle; margin-right: 134px;">
                                        {{ Auth::user()->department }}
                                    </span>
                                    <p class="card-subtitle">Welcome to your Performance Hub</p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Generated Leads -->
                    <!-- Profit last month -->
                    <div class="col-lg-6 col-md-3 col-sm-6">
                        <div class="card h-100">

                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h4 class="mb-0 text-center">82%</h4>


                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-3 col-sm-6">
                        <div class="card bg-success h-100" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="tooltip-success"
                            data-bs-original-title="You’re going beyond what’s asked of you.">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h4 class="mb-0 text-center text-white">EE</h4>


                            </div>
                        </div>
                    </div>
                    <!--/ Expenses -->
                </div>
            </div>
            <!--/ Sales Overview -->

            <!-- Website Analytics -->
            <div class="col-lg-9 col-md-12">
                <div class="swiper-reviews-carousel overflow-hidden">
                    <div class="swiper" id="swiper-reviews">
                        <div class="swiper-wrapper">
                            @php
                                $result = getRoleAssignments(Auth::user()->getRoleNames()->first());
                                $icon1 = ['tabler-book ', 'tabler-bulb', 'tabler-network', 'tabler-shield-check', 'tabler-star'];
                                $colors1 = ['primary', 'success', 'warning', 'orange', 'danger'];
                                //$colors2 = ['#0d6efd', '#198754', '#dc3545', '#ffc107', '#0dcaf0'];
                                $colors2 = ['#0d6efd', '#198754', '#FFA500', '#FFF200', '#dc3545'];
                                $series1 = [90, 85, 70, 65, 50];
                                $index1 = 0;
                                $index2 = 0;
                              @endphp
                            @foreach($result as $kpakey => $kpa)
                                @php
                                    $targetId = strtolower(str_replace(' ', '-', $kpa['performance_area']));
                                    $iconClass = $icon1[$index2 % count($icon1)];
                                    $color1 = $colors1[$index2 % count($colors1)];
                                    $index2++;
                                @endphp
                                {{-- <div class="col-xl-3 col-md-6 col-sm-12" id="{{ $targetId }}">

                                    <!-- FRONT SIDE -->
                                    <div class="card bg-{{ $color1 }} text-white h-100">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="card-title mb-0 text-white">
                                                <p class="mb-0">{{ $kpa['performance_area'] }}</p>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-{{ $color1 }} rounded p-2">
                                                    <i class="icon-base ti {{ $iconClass }} icon-26px"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div> --}}
                                <div class="swiper-slide" id="{{ $targetId }}">
                                    <a href="{{ route('kpa.report', ['id' => $kpa['id']]) }}" class="text-decoration-none">
                                        <div class="flip-card h-100">
                                            <div class="flip-card-inner">

                                                <!-- FRONT -->
                                                <div class="flip-card-front card bg-{{ $color1 }} text-white">

                                                    <div
                                                        class="card-body position-relative d-flex flex-column justify-content-between">
                                                        <div>
                                                            <div class="d-flex align-items-center mb-1">
                                                                <div class="avatar me-4">
                                                                    <span class="avatar-initial rounded bg-label-{{ $color1 }}">
                                                                        <i class="icon-base ti {{ $iconClass }} icon-28px"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <p class="mb-0 fw-bold h5 text-white">{{ $kpa['performance_area'] }}
                                                            </p>
                                                        </div>
                                                        <!-- Metrics bottom right -->
                                                        <div
                                                            class="card-metrics mt-2 text-end position-absolute bottom-0 end-0 p-2">
                                                            @if ($kpa['id'] == 1)
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">90%</span>
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">OS</span>
                                                            @elseif ($kpa['id'] == 2)
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">80%</span>
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">EE</span>
                                                            @elseif ($kpa['id'] == 3)
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">70%</span>
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">ME</span>
                                                            @elseif ($kpa['id'] == 4)
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">60%</span>
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">N1</span>
                                                            @elseif ($kpa['id'] == 5)
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">90%</span>
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">OS</span>
                                                            @elseif ($kpa['id'] == 6)
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">80%</span>
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">EE</span>
                                                            @elseif ($kpa['id'] == 7)
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">70%</span>
                                                                <span class="metric-badge bg-label-{{ $color1 }} fw-bold">ME</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <!-- BACK -->
                                                <div class="flip-card-back card bg-info text-dark h-100">
                                                    <div
                                                        class="card-body d-flex flex-column justify-content-center align-items-center">
                                                        <div class="badge rounded p-2 bg-label-info mb-2"><i
                                                                class="icon-base ti {{ $iconClass }} icon-lg"></i>
                                                        </div>
                                                        <h6 class="mb-2 text-white text-center ">{{ $kpa['performance_area'] }}
                                                        </h6>
                                                        @if ($kpa['id'] == 1)
                                                            <p class=" text-center mb-0 text-white fs-13">
                                                                Focuses on teaching quality, classroom management, and continuous
                                                                improvement to enhance
                                                                student learning outcomes.
                                                            </p>
                                                        @elseif ($kpa['id'] == 2)
                                                            <p class="text-center mb-0 text-white fs-13">
                                                                Measures research output, quality, and supervision, emphasizing
                                                                innovation and practical
                                                                application of research for societal and industry impact.
                                                            </p>
                                                        @elseif ($kpa['id'] == 3)
                                                            <p class="text-center mb-0 text-white fs-13">
                                                                Ensures financial health through diversified revenue, cost
                                                                efficiency, strategic growth, and
                                                                reinvestment in institutional excellence.
                                                            </p>
                                                        @elseif ($kpa['id'] == 4)
                                                            <p class="text-center mb-0 text-white fs-13">
                                                                Tracks institutional success in achieving global engagement targets
                                                                and providing students
                                                                with international exposure opportunities.
                                                            </p>
                                                        @elseif ($kpa['id'] == 5)
                                                            <p class="text-center mb-0 text-white fs-13">
                                                                Advances social and environmental impact through service,
                                                                sustainability, civic engagement,
                                                                and community development initiatives.
                                                            </p>
                                                        @elseif ($kpa['id'] == 6)
                                                            <p class="text-center mb-0 text-white fs-13">
                                                                Builds institutional reputation and distinctiveness through
                                                                excellence, stakeholder trust,
                                                                global linkages, and consistent quality.
                                                            </p>
                                                        @elseif ($kpa['id'] == 7)
                                                            <p class="text-center mb-0 text-white fs-13">
                                                                Promotes transparent, accountable, participative leadership ensuring
                                                                alignment, trust,
                                                                compliance, and mission-driven institutional effectiveness.
                                                            </p>
                                                        @elseif ($kpa['id'] == 13)
                                                            <p class="text-center mb-0 text-white fs-13">
                                                                Focuses on active involvement in departmental and institutional
                                                                activities to promote
                                                                collaboration, visibility, and shared success.
                                                            </p>
                                                        @elseif ($kpa['id'] == 14)
                                                            <p class="text-center mb-0 text-white fs-13">
                                                                Represents ethical conduct and leadership grounded in integrity,
                                                                empathy, humility, and
                                                                accountability.
                                                            </p>
                                                        @else
                                                            <p class="text-center mb-0 text-white fs-13">Other text</p>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </a>
                                </div>

                            @endforeach

                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>

            <!--/ Website Analytics -->

        </div>
        <div class="row gy-6 mt-2">

            <div class="col-md-6 col-lg-4" id="scrollableCol">
                <div class=" d-flex justify-content-between">
                    <h5 class="fw-bold">Hot Indicators</h5>
                </div>
                <!--/ Statistics -->

                <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-warning"
                    data-bs-original-title="You’re on your way — just refine and push forward.Every effort moves you closer to success.">
                    <div class="card-body d-flex">
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-orange rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-mood-smile icon-md"></i>
                            </div>
                            <div>
                                <small class="text-dark">% Employability</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                                <div class="progress-bar bg-orange" role="progressbar" style="width: 65%" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">65%</span>
                            <span class="badge bg-label-orange ms-1">NI</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-primary"
                    data-bs-original-title="You’re achieving excellence with distinction.You set the pace for others to follow.">
                    <div class="card-body d-flex">
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-primary rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-chalkboard icon-md"></i></div>
                            <div>
                                <small class="text-dark">% Achievement of Research Publications</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 65%"
                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">90%</span>
                            <span class="badge bg-label-primary ms-1">OS</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-warning"
                    data-bs-original-title="You’re doing well and meeting your goals.Keep your consistency — it’s your strength.">
                    <div class="card-body d-flex">
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-warning rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-user-check icon-md"></i></div>
                            <div>
                                <small class="text-dark">% of Admission Targets Achieved</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 65%"
                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">70%</span>
                            <span class="badge bg-label-warning ms-1">ME</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-danger"
                    data-bs-original-title="Not quite there yet — but growth starts here.Reflect. Refocus. Rise higher.">
                    <div class="card-body d-flex">
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-danger rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-book-2 icon-md"></i>
                            </div>
                            <div>
                                <small class="text-dark">% of Recovery</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">50%</span>
                            <span class="badge bg-label-danger ms-1">BE</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-success"
                    data-bs-original-title="You’re going beyond what’s asked of you.Keep shining — your impact inspires others.">
                    <div class="card-body d-flex">
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-success rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-stars icon-md"></i>
                            </div>
                            <div>
                                <small class="text-dark">Profitability of the Programs</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%"
                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">86%</span>
                            <span class="badge bg-label-success ms-1">EE</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-success"
                    data-bs-original-title="You’re going beyond what’s asked of you.Keep shining — your impact inspires others.">
                    <div class="card-body d-flex">
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-success rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-stars icon-md"></i>
                            </div>
                            <div>
                                <small class="text-dark">Faculty Satisfaction Score</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%"
                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">86%</span>
                            <span class="badge bg-label-success ms-1">EE</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-6 scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-success"
                    data-bs-original-title="You’re going beyond what’s asked of you.Keep shining — your impact inspires others.">
                    <div class="card-body d-flex">
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-success rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-stars icon-md"></i>
                            </div>
                            <div>
                                <small class="text-dark">Student Feedback Score</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%"
                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">86%</span>
                            <span class="badge bg-label-success ms-1">EE</span>
                        </div>
                    </div>
                </div>

                <div class="card scgrool-card-h hover-card" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-success"
                    data-bs-original-title="You’re going beyond what’s asked of you.Keep shining — your impact inspires others.">
                    <div class="card-body d-flex">
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-success rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-stars icon-md"></i>
                            </div>
                            <div>
                                <small class="text-dark">Faculty Discipline / Punctuality</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%"
                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">86%</span>
                            <span class="badge bg-label-success ms-1">EE</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" id="scrollableCol1">


                <div class=" d-flex justify-content-between">
                    <h5 class="fw-bold">Top Performers</h5>
                </div>

                <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-success"
                    data-bs-original-title="(Lecturer) Department of Software Engineering">
                    <div class="card-body d-flex">
                        <div class="d-flex w-70 align-items-center me-4">
                            <div class="badge bg-label-success rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-trophy icon-md"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-cut">Haider Ali / Lecturer</h6>
                                <small class="text-dark fs-10 text-cut">Department of Software Engineering</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center justify-content-end">

                            <span class="badge bg-label-success ms-1">82</span>
                            <span class="badge bg-label-success ms-1">EE</span>
                        </div>
                    </div>
                </div>



                <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-primary"
                    data-bs-original-title="(Lecturer) Superior University Franchise.">
                    <div class="card-body d-flex">
                        <div class="d-flex w-70 align-items-center me-4">
                            <div class="badge bg-label-primary rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-trophy icon-md"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-cut">Sadia Ashraf / Lecturer</h6>
                                <small class="text-dark fs-10 text-cut">Superior University Franchise</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center justify-content-end">

                            <span class="badge bg-label-primary ms-1">91</span>
                            <span class="badge bg-label-primary ms-1">OS</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-warning"
                    data-bs-original-title="(Lecturer) Superior University Franchise">
                    <div class="card-body d-flex">
                        <div class="d-flex w-70 align-items-center me-4">
                            <div class="badge bg-label-warning rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-award icon-md"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-cut">Amna Ilyas / Lecturer</h6>
                                <small class="text-dark fs-10 text-cut">Superior University Franchise</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center justify-content-end">

                            <span class="badge bg-label-warning ms-1">70</span>
                            <span class="badge bg-label-warning ms-1">ME</span>
                        </div>
                    </div>
                </div>


                <div class="card mb-6" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-custom-class="tooltip-danger" data-bs-original-title="(Lecturer) Teaching">
                    <div class="card-body d-flex">
                        <div class="d-flex w-70 align-items-center me-4">
                            <div class="badge bg-label-danger rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-trophy-off icon-md"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-cut">Muhammad Ashraf / Lecturer</h6>

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
                            <div class="badge bg-label-warning rounded p-1_5 me-4"><i
                                    class="icon-base ti tabler-award icon-md"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Rashid Hussain / Lecturer</h6>
                                <small class="text-dark fs-10">Faisalabad - Uni Campus</small>
                            </div>
                        </div>
                        <div class="d-flex flex-grow-1 align-items-center justify-content-end">

                            <span class="badge bg-label-warning ms-1">70</span>
                            <span class="badge bg-label-warning ms-1">ME</span>
                        </div>
                    </div>
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
                                    <button class="btn  rounded-pill text-body-secondary border-0 p-2 me-n1 waves-effect"
                                        type="button" data-bs-toggle="modal" data-bs-target="#fullscreenModal">
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
                        <h5 class="card-title m-0 me-2">Semester-wise Overall Performance</h5>

                    </div>
                    <div class="card-body">
                        <div id="carrierPerformance1"></div>
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
                                        <div class="btn-group d-none d-sm-flex" role="group"
                                            aria-label="radio toggle button group">
                                            <input type="radio" class="btn-check" name="termRadio" id="overall" checked>
                                            <label class="btn btn-outline-primary waves-effect" for="overall">📆
                                                Overall</label>

                                            <input type="radio" class="btn-check" name="termRadio" id="spring25">
                                            <label class="btn btn-outline-primary waves-effect" for="spring25">📆 Spring
                                                2025</label>

                                            <input type="radio" class="btn-check" name="termRadio" id="fall25">
                                            <label class="btn btn-outline-primary waves-effect" for="fall25">📆 Fall
                                                2025</label>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <div class="row justify-content-center text-center">
                                            <div class="col-md-8 d-flex justify-content-center">
                                                <canvas class="chartjs" id="radarChart"></canvas>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <ul id="customLegend"
                                                    class="d-flex justify-content-center flex-wrap p-0 m-0"
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
    <script src="{{ asset('admin/assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/nouislider/nouislider.js') }}"></script>
    <script src="{{ asset('admin/assets/js/front-page-landing.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const elements = document.querySelectorAll('.text-cut');

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
            const windowHeight = window.innerHeight;

            // Set scroll height dynamically based on window height
            const maxHeight = 454;
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
                                                                                                                                                                                                                                                    #scrollableCol::-webkit-scrollbar { width: 0; background: transparent; }
                                                                                                                                                                                                                                                  `;
            document.head.appendChild(style);

            // Auto adjust on window resize
            window.addEventListener("resize", () => {
                scrollableDiv.style.maxHeight = `${newHeight}px`;
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const scrollableDiv = document.getElementById("scrollableCol1");
            const windowHeight = window.innerHeight;

            // Set scroll height dynamically based on window height
            const maxHeight = 454;
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
            // ✅ Updated full labels and short labels
            var chartLabels = [
                "Teaching and Learning",
                "Research, Innovation and Commercialisation",
                "Financial Sustainability",
                "Internationalization",
                "Social Responsibility",
                "Brand Identity",
                "Leadership and Governance",
            ];

            var shortLabels = ["T&L", "RIC", "FS", "INT", "SR", "BI", "L&G"];

            // ✅ Example dataset (7 values)
            var dataset1 = [90, 85, 80, 70, 75, 65, 70];
            var labelColors = [
                "#e74c3c",
                "#3498db",
                "#27ae60",
                "#f39c12",
                "#9b59b6",
                "#1abc9c",
                "#2c3e50",
            ];

            var ctx = document.getElementById("radarChart").getContext("2d");

            var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
            gradientPink.addColorStop(0, "rgba(115, 103, 240, 0.3)");
            gradientPink.addColorStop(1, "rgba(115, 103, 240, 0.5)");

            // ✅ Create radar chart
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
                            pointStyle: "circle",
                        },
                    ],
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
                                callback: (label, index) => shortLabels[index], // ✅ show short labels around chart
                            },
                        },
                    },
                    plugins: { legend: { display: false } },
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
                                const padding = 30; // clickable area around label

                                if (
                                    event.x >= point.x - padding &&
                                    event.x <= point.x + padding &&
                                    event.y >= point.y - padding &&
                                    event.y <= point.y + padding
                                ) {
                                    hovering = true;

                                    // 👉 Handle click
                                    if (event.type === "click") {
                                        const targetId = label.replace(/\s+/g, "-").toLowerCase();
                                        const targetDiv = document.getElementById(targetId);

                                        if (targetDiv) {
                                            // Scroll into view
                                            targetDiv.scrollIntoView({ behavior: "smooth", block: "center" });

                                            // Expand accordion if collapsed
                                            const collapseEl = targetDiv.querySelector(".accordion-collapse");
                                            if (collapseEl && !collapseEl.classList.contains("show")) {
                                                new bootstrap.Collapse(collapseEl, { toggle: true });
                                            }

                                            // Highlight active section
                                            document.querySelectorAll(".accordion-item").forEach((item) =>
                                                item.classList.remove("active")
                                            );
                                            targetDiv.classList.add("active");
                                        }
                                    }
                                }
                            });

                            chart.canvas.style.cursor = hovering ? "pointer" : "default";
                        },
                    },
                ],
            });

            // ✅ Dataset switching (for Overall / Spring / Fall)
            document.getElementById("overall").addEventListener("change", function () {
                if (this.checked) {
                    radarChart.data.datasets[0].data = [90, 85, 80, 70, 75, 65, 70];
                    radarChart.update();
                }
            });

            document.getElementById("spring25").addEventListener("change", function () {
                if (this.checked) {
                    radarChart.data.datasets[0].data = [88, 80, 85, 72, 70, 68, 73];
                    radarChart.update();
                }
            });

            document.getElementById("fall25").addEventListener("change", function () {
                if (this.checked) {
                    radarChart.data.datasets[0].data = [70, 90, 85, 75, 80, 60, 78];
                    radarChart.update();
                }
            });

            // ✅ Custom Legend
            var legendDiv = document.getElementById("customLegend");
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
        });

        document.addEventListener("DOMContentLoaded", function () {
            // ✅ Full labels
            var chartLabels = [
                "Teaching and Learning",
                "Research, Innovation and Commercialisation",
                "Financial Sustainability",
                "Internationalization",
                "Social Responsibility",
                "Brand Identity",
                "Leadership and Governance",
            ];

            // ✅ Matching short labels (7 total)
            var shortLabels = ["T&L", "RIC", "FS", "INT", "SR", "BI", "L&G"];

            // ✅ Sample dataset
            var dataset1 = [90, 85, 80, 70, 75, 65, 70];
            var labelColors = ["#e74c3c", "#3498db", "#27ae60", "#f39c12", "#9b59b6", "#1abc9c", "#2c3e50"];

            var ctx = document.getElementById("radarChart1").getContext("2d");

            var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
            gradientPink.addColorStop(0, "rgba(115, 103, 240, 0.3)");
            gradientPink.addColorStop(1, "rgba(115, 103, 240, 0.5)");

            // ✅ Create the radar chart
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
                            pointStyle: "circle",
                        },
                    ],
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
                                callback: (label, index) => shortLabels[index],
                            },
                        },
                    },
                    plugins: { legend: { display: false } },
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

                                            document.querySelectorAll(".accordion-item").forEach((item) => item.classList.remove("active"));
                                            targetDiv.classList.add("active");
                                        }
                                    }
                                }
                            });

                            chart.canvas.style.cursor = hovering ? "pointer" : "default";
                        },
                    },
                ],
            });

            // ✅ Dataset switching
            document.getElementById("overall").addEventListener("change", function () {
                if (this.checked) {
                    radarChart.data.datasets[0].data = [90, 85, 80, 70, 75, 65, 70];
                    radarChart.update();
                }
            });
            document.getElementById("spring25").addEventListener("change", function () {
                if (this.checked) {
                    radarChart.data.datasets[0].data = [80, 88, 84, 75, 70, 60, 65];
                    radarChart.update();
                }
            });
            document.getElementById("fall25").addEventListener("change", function () {
                if (this.checked) {
                    radarChart.data.datasets[0].data = [70, 90, 85, 80, 78, 66, 72];
                    radarChart.update();
                }
            });

            // ✅ Custom legend
            var legendDiv = document.getElementById("customLegend1");
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
        });

        document.addEventListener("DOMContentLoaded", function () {
            const c = document.querySelector("#carrierPerformance");
            const categories = [
                "Journal Publication",
                "Multidisciplinary Projects",
                "Commercial Gains",
                "Intellectual Properties",
                "Spin Off"
            ];
            // Distinct color for each category
            const colors = [
                "#1F77B4", // Publication
                "#FF7F0E", // Projects
                "#2CA02C", // Commercial Gains
                "#9467BD", // Intellectual Properties
                "#D62728"  // Spin Off
            ];
            // Lighter versions for "Achieved"
            const lightColors = [
                "#6BAED6", // lighter blue
                "#FFBB78", // lighter orange
                "#98DF8A", // lighter green
                "#C5B0D5", // lighter purple
                "#FF9896"  // lighter red
            ];
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
                    {
                        name: "Target",
                        data: [
                            { x: "JP", y: 5, fillColor: colors[0] },
                            { x: "MP", y: 7, fillColor: colors[1] },
                            { x: "CG", y: 3, fillColor: colors[2] },
                            { x: "IP", y: 6, fillColor: colors[3] },
                            { x: "SO", y: 5, fillColor: colors[4] }
                        ]
                    },
                    {
                        name: "Achieved",
                        data: [
                            { x: "JP", y: 4, fillColor: lightColors[0] },
                            { x: "MP", y: 3.5, fillColor: lightColors[1] },
                            { x: "CG", y: 2, fillColor: lightColors[2] },
                            { x: "IP", y: 4, fillColor: lightColors[3] },
                            { x: "SO", y: 2, fillColor: lightColors[4] }
                        ]
                    }
                ],
                xaxis: {
                    categories: ["JP", "MP", "CG", "IP", "SO"],
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
                    item.innerHTML = `
                                                                                                                                                                                                                                                                <span style="width:14px;height:14px;background:${colors[i]};border-radius:50%;display:inline-block;margin-right:6px;"></span>
                                                                                                                                                                                                                                                                <span style="font-size:13px;color:#6e6b7b;">${label}</span>
                                                                                                                                                                                                                                                              `;
                    legendContainer.appendChild(item);
                });
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            const c = document.querySelector("#carrierPerformance1");

            const options = {
                chart: {
                    type: 'area',
                    height: 400,
                    toolbar: { show: false },
                },
                series: [
                    {
                        name: 'Performance',
                        data: [20, 40, 60, 70, 80, 90]
                    }
                ],
                xaxis: {
                    categories: ['Fall 22', 'Spring 23', 'Fall 23', 'Spring 24', 'Fall 24', 'Spring 25']
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                    dashArray: 0 // keep solid line, dotted markers only
                },
                colors: ['#008FFB'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: {
                    theme: 'dark'
                },
                markers: {
                    size: 5,                 // size of the point
                    colors: ['#008FFB'],     // fill color
                    strokeColors: '#fff',    // border color
                    strokeWidth: 2,          // thickness of border
                    shape: 'circle',
                    hover: {
                        size: 7,
                        sizeOffset: 2
                    },
                    discrete: [] // allows customization if needed later
                }
            };

            const chart = new ApexCharts(c, options);
            chart.render();
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
            const checkboxColors = ["#FF55B8", "#5555FF"]; // Inside Mirror, Social Mirror

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
    </script>

@endpush
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
        <div class="row">
            <!-- View sales -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-7">
                            <div class="card-body text-nowrap">
                                <h5 class="card-title mb-0">Welcome {{ Auth::user()->name }}</h5>
                                <p class="mb-2">Director</p>
                                <p class="mb-2">{{ Auth::user()->department }}</p>
                                <!--<h4 class="text-primary mb-1">81.00%</h4>-->
                                <a href="javascript:;" class="btn btn-primary">View Report</a>
                            </div>
                        </div>
                        <div class="col-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('admin/assets/img/illustrations/card-advance-sale.png') }}" height="140"
                                    alt="view sales" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View sales -->

            <!-- Statistics -->
            <div class="col-xl-8 col-md-12">
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
                                            <h5 class="mb-0"> 80%</h5>
                                            <small>Assessment Score (Latest)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-primary me-4 p-2"><i
                                                class="icon-base ti tabler-arrows-transfer-up-down icon-lg"></i></div>
                                        <div class="card-info">
                                            <h5 class="mb-0">2/15</h5>
                                            <small>Vertical Stakeholder Submission Status</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-primary me-4 p-2"><i
                                                class="icon-base ti tabler-switch-horizontal icon-lg"></i></div>
                                        <div class="card-info">
                                            <h5 class="mb-0">3/5</h5>
                                            <small>Horizontal Stakeholder Submission Status</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-primary me-4 p-2"><i
                                                class="icon-base ti tabler-checkbox icon-lg"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">Done</h5>
                                            <small>Self Assessment Status</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row mb-6 g-6">
            <div class="col-12 col-xl-7">
                <!-- Bar Charts -->

                <div class="card">
                    <div class="card-header header-elements">
                        <h5 class="card-title mb-0">My Virtue Scorecard</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" class="chartjs" data-height="400"></canvas>
                    </div>
                </div>

                <!-- /Bar Charts -->
            </div>

            <div class="col-12 col-xl-5 col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Virtue Mirror</h5>
                        </div>
                    </div>

                    <!-- Radar Chart -->

                    <div class="card-body pt-2">
                        <canvas class="chartjs" id="radarChart" data-height="355"></canvas>
                    </div>


                    <!-- /Radar Chart -->
                </div>
            </div>

        </div>
        <div class="row mb-6 g-6">
            <div class="col-12 col-xl-6 col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">

                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Virtue Champions</h5>
                        </div>
                        <div class="badge rounded me-4 p-2" style="background-color: #FFD700;"><i
                                class="icon-base fas fa-trophy trophy-icon icon-lg"></i></div>

                    </div>
                    <div class="px-5 py-4 border border-start-0 border-end-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 text-uppercase">Champions</p>
                            <p class="mb-0 text-uppercase">Virtue</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar me-4">
                                    <img src="{{ asset('admin/assets/img/avatars/1.png')}}" alt="Avatar"
                                        class="rounded-circle" />
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Asim</h6>
                                        <small class="text-truncate text-body">Software Engineer</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">Responsibility and Accountability</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar me-4">
                                    <img src="{{ asset('admin/assets/img/avatars/3.png')}}" alt="Avatar"
                                        class="rounded-circle" />
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Ahmad</h6>
                                        <small class="text-truncate text-body">Software Engineer</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">Honesty and Integrity</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar me-4">
                                    <img src="{{ asset('admin/assets/img/avatars/3.png')}}" alt="Avatar"
                                        class="rounded-circle" />
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Abdul Wahab</h6>
                                        <small class="text-truncate text-body">Designer</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">Empathy and Compassion</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar me-4">
                                    <img src="{{ asset('admin/assets/img/avatars/4.png')}}" alt="Avatar"
                                        class="rounded-circle" />
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Dania Khan</h6>
                                        <small class="text-truncate text-body">React Js Developer</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">Humility and Service</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar me-4">
                                    <img src="{{ asset('admin/assets/img/avatars/3.png')}}" alt="Avatar"
                                        class="rounded-circle" />
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Shazib Shehzad</h6>
                                        <small class="text-truncate text-body">Flutter Developer</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">Patience and Gratitude</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6 col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Organization-wide Averages</h5>
                        </div>
                        <div class="badge rounded me-4 p-2" style="background-color: #FFD700;"><i
                                class="icon-base fas fa-chart-bar fa-3x icon-lg"></i></div>

                    </div>
                    <div class="px-5 py-4 border border-start-0 border-end-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 text-uppercase">Virtue</p>
                            <p class="mb-0 text-uppercase">Avg.</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded me-4 p-2" style="background-color: #4169E1 !important;">
                                    <i class="icon-base fa-solid fa-balance-scale icon-lg"></i>
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Responsibility & Accountability</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">83%</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded me-4 p-2" style="background-color: #FFD700 !important;">
                                    <i class="icon-base fa-solid fa-shield-alt icon-lg"></i>
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Honesty & Integrity</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">85%</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded me-4 p-2" style="background-color: #B497BD !important;">
                                    <i class="icon-base fas fa-hand-holding-heart icon-lg"></i>
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Empathy and Compassion</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">90%</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded me-4 p-2" style="background-color: #A0522D !important;">
                                    <i class="icon-base fa-solid fa-users-between-lines icon-lg"></i>
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Humility and Service</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">89%</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded me-4 p-2" style="background-color: #556B2Fa !important;">
                                    <i class="icon-base fa-solid fa-mosque icon-lg"></i>
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Patience and Gratitude</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0">89%</h6>
                            </div>
                        </div>
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

@endpush
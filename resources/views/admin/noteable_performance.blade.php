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
      <div class="col-4">
        <div class="card mb-4 bg-gradient-warning">
          <div class="card-body">
            <div class="row justify-content-between mb-4">
              <div
                class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-center text-lg-start text-xl-center text-xxl-start order-1  order-lg-0 order-xl-1 order-xxl-0">
                <h5 class="card-title text-white text-nowrap mb-4">Meet Expectation (ME)</h5>
                <p class="card-text text-white" style="font-size: 14px;">You’re doing well and meeting your goals.
                  Keep your consistency — it’s your strength.</p>
              </div>
              <span class="col-md-12 col-lg-5 col-xl-12 col-xxl-5 text-center mx-auto mx-md-0 mb-2"><img
                  src="{{ asset('admin/assets/img/avatars/award1.png') }}" class="w-px-75 m-2" alt="3dRocket"></span>
            </div>
            <button class="btn btn-white text-warning w-100 fw-medium shadow-xs waves-effect waves-light"
              data-bs-target="#upgradePlanModal" data-bs-toggle="modal">ME</button>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card mb-4 bg-gradient-success">
          <div class="card-body">
            <div class="row justify-content-between mb-4">
              <div
                class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-center text-lg-start text-xl-center text-xxl-start order-1  order-lg-0 order-xl-1 order-xxl-0">
                <h5 class="card-title text-white text-nowrap mb-4">Exceed Expectation (EE)</h5>
                <p class="card-text text-white">You’re going beyond what’s asked of you.
                  Keep shining — your impact inspires others.</p>
              </div>
              <span class="col-md-12 col-lg-5 col-xl-12 col-xxl-5 text-center mx-auto mx-md-0 mb-2"><img
                  src="{{ asset('admin/assets/img/avatars/award3.png') }}" class="w-px-75 m-2" alt="3dRocket"></span>
            </div>
            <button class="btn btn-white text-success w-100 fw-medium shadow-xs waves-effect waves-light"
              data-bs-target="#upgradePlanModal" data-bs-toggle="modal">EE</button>
          </div>
        </div>
      </div>

      <div class="col-4">
        <div class="card mb-4 bg-gradient-primary">
          <div class="card-body">
            <div class="row justify-content-between mb-4">
              <div
                class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-center text-lg-start text-xl-center text-xxl-start order-1  order-lg-0 order-xl-1 order-xxl-0">
                <h5 class="card-title text-white text-nowrap mb-4">Outstanding (OS)</h5>
                <p class="card-text text-white">You’re achieving excellence with distinction.
                  You set the pace for others to follow.</p>
              </div>
              <span class="col-md-12 col-lg-5 col-xl-12 col-xxl-5 text-center mx-auto mx-md-0 mb-2"><img
                  src="{{ asset('admin/assets/img/avatars/award2.png') }}" class="w-px-75 m-2" alt="3dRocket"></span>
            </div>
            <button class="btn btn-white text-primary w-100 fw-medium shadow-xs waves-effect waves-light"
              data-bs-target="#upgradePlanModal" data-bs-toggle="modal">OS</button>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card mb-6">
          <div class="card-header d-flex flex-wrap justify-content-between gap-4">
            <div class="card-title mb-0 me-1">
              <h5 class="mb-0">Acheivements</h5>
              <p class="mb-0">Total 5 Acheivements</p>
            </div>
            <div class="d-flex justify-content-md-end align-items-center column-gap-6 flex-sm-row flex-column row-gap-4">


              <ul class="nav custom-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#spring"
                    aria-selected="true">
                    🌸 Spring 2025
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#fall"
                    aria-selected="false">
                    🍂 Fall 2025
                  </button>
                </li>
              </ul>

            </div>
          </div>
          <div class="card-body">

            <div class="tab-content p-0">
              <div class="tab-pane fade show active" id="spring" role="tabpanel">
                <div class="row gy-6 mb-6">

                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-warning rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award1.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-warning">ME</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            70 <span class="text-warning"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="" class="h5">Teaching and Learning</a>
                        <p class="mt-1">QEC - Observation / Peer review</p>
                        <p class="d-flex align-items-center mb-1">70<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-warning" style="width: 70%" role="progressbar" aria-valuenow="70"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re doing well and meeting your goals.Keep your consistency — it’s your strength.
                        </small>

                      </div>
                    </div>
                  </div>


                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-success rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award3.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-success">EE</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            82 <span class="text-success"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="" class="h5">Teaching and Learning</a>
                        <p class="mt-1">Completion of Course Folder in Hard</p>
                        <p class="d-flex align-items-center mb-1">82<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-success" style="width: 82%" role="progressbar" aria-valuenow="82"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re going beyond what’s asked of you. Keep shining — your impact inspires others.
                        </small>

                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-success rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award3.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-success">EE</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            81 <span class="text-success"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="app-academy-course-details.html" class="h5">Research, Innovation and
                          Commercialisation</a>
                        <p class="mt-1">Research productivity of PG students</p>
                        <p class="d-flex align-items-center mb-1">81<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-success" style="width: 81%" role="progressbar" aria-valuenow="81"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re going beyond what’s asked of you. Keep shining — your impact inspires others.
                        </small>

                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-primary rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award2.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-primary">OS</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            92 <span class="text-primary"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="" class="h5">Teaching and Learning</a>
                        <p class="mt-1">Student Teaching Satisfaction (feedback)</p>
                        <p class="d-flex align-items-center mb-1">92<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-primary" style="width: 89%" role="progressbar" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re going beyond what’s asked of you.Keep shining — your impact inspires others.
                        </small>

                      </div>
                    </div>
                  </div>



                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-primary rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award2.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-primary">OS</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            90 <span class="text-primary"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="" class="h5">Teaching and Learning</a>
                        <p class="mt-1">Classes Held</p>
                        <p class="d-flex align-items-center mb-1">90<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-primary" style="width: 90%" role="progressbar" aria-valuenow="90"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re achieving excellence with distinction.You set the pace for others to follow.
                        </small>

                      </div>
                    </div>
                  </div>


                </div>
              </div>





              <div class="tab-pane fade" id="fall" role="tabpanel">
                <div class="row gy-6 mb-6">

                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-warning rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award1.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-warning">ME</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            70 <span class="text-warning"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="" class="h5">Teaching and Learning</a>
                        <p class="mt-1">QEC - Observation / Peer review</p>
                        <p class="d-flex align-items-center mb-1">70<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-warning" style="width: 70%" role="progressbar" aria-valuenow="70"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re doing well and meeting your goals.Keep your consistency — it’s your strength.
                        </small>

                      </div>
                    </div>
                  </div>


                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-success rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award3.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-success">EE</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            82 <span class="text-success"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="" class="h5">Teaching and Learning</a>
                        <p class="mt-1">Completion of Course Folder in Hard</p>
                        <p class="d-flex align-items-center mb-1">82<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-success" style="width: 82%" role="progressbar" aria-valuenow="82"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re going beyond what’s asked of you. Keep shining — your impact inspires others.
                        </small>

                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-success rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award3.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-success">EE</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            81 <span class="text-success"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="app-academy-course-details.html" class="h5">Research, Innovation and
                          Commercialisation</a>
                        <p class="mt-1">Research productivity of PG students</p>
                        <p class="d-flex align-items-center mb-1">81<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-success" style="width: 81%" role="progressbar" aria-valuenow="81"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re going beyond what’s asked of you. Keep shining — your impact inspires others.
                        </small>

                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-primary rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award2.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-primary">OS</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            92 <span class="text-primary"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="" class="h5">Teaching and Learning</a>
                        <p class="mt-1">Student Teaching Satisfaction (feedback)</p>
                        <p class="d-flex align-items-center mb-1">92<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-primary" style="width: 89%" role="progressbar" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re going beyond what’s asked of you.Keep shining — your impact inspires others.
                        </small>

                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border">
                      <div class="bg-label-primary rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/award2.png') }}"
                          alt="Card girl image" width="140">
                      </div>
                      <div class="card-body p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <span class="badge bg-label-primary">OS</span>
                          <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                            90 <span class="text-primary"><i
                                class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span>
                          </p>
                        </div>
                        <a href="" class="h5">Teaching and Learning</a>
                        <p class="mt-1">Classes Held</p>
                        <p class="d-flex align-items-center mb-1">90<i class="icon-base ti tabler-percentage me-1"></i>
                        </p>
                        <div class="progress mb-4" style="height: 8px">
                          <div class="progress-bar bg-primary" style="width: 90%" role="progressbar" aria-valuenow="90"
                            aria-valuemin="0" aria-valuemax="100"></div>

                        </div>
                        <small class="text-break">
                          You’re achieving excellence with distinction.You set the pace for others to follow.
                        </small>

                      </div>
                    </div>
                  </div>


                </div>
              </div>


            </div>

          </div>
        </div>
      </div>











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
                <tr>
                  <td class="sorting_1">
                    <div class="d-flex justify-content-start align-items-center product-name">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-warning"><i
                            class="icon-base ti tabler-truck icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column">
                        <h6 class="text-nowrap mb-0">Teaching and Learning</h6>
                        <small class="text-truncate d-none d-sm-block">QEC - Observation / Peer review</small>
                      </div>
                    </div>
                  </td>

                  <td>
                    <p class="text-warning fw-medium mb-0 d-flex align-items-center gap-1">
                      70%
                    </p>
                  </td>
                  <td><span class="badge bg-label-warning me-1">ME</span></td>
                  <td>
                    <div class="avatar avatar-xl">
                      <img src="{{ asset('admin/assets/img/avatars/award1.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                  </td>
                  <td> <small class="text-break">
                      You’re doing well and meeting your goals.Keep your consistency — it’s your strength.
                    </small>
                  </td>
                  <td>08/07/2021</td>
                </tr>

                <tr>
                  <td class="sorting_1">
                    <div class="d-flex justify-content-start align-items-center product-name">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-success"><i
                            class="icon-base ti tabler-circle-check icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column">
                        <h6 class="text-nowrap mb-0">Teaching and Learning</h6>
                        <small class="text-truncate d-none d-sm-block">Completion of Course Folder in Hard</small>
                      </div>
                    </div>
                  </td>

                  <td>
                    <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                      82%
                    </p>
                  </td>
                  <td><span class="badge bg-label-success me-1">EE</span></td>
                  <td>
                    <div class="avatar avatar-xl">
                      <img src="{{ asset('admin/assets/img/avatars/award3.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                  </td>
                  <td> <small class="text-break">
                      You’re going beyond what’s asked of you.
                      Keep shining — your impact inspires others.
                    </small>
                  </td>
                  <td>08/07/2021</td>
                </tr>
                <tr>
                  <td class="sorting_1">
                    <div class="d-flex justify-content-start align-items-center product-name">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-success"><i
                            class="icon-base ti tabler-clock  icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column">
                        <h6 class="text-nowrap mb-0">Research, Innovation and Commercialisation</h6>
                        <small class="text-truncate d-none d-sm-block">Research productivity of PG students</small>
                      </div>
                    </div>
                  </td>

                  <td>
                    <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                      81%
                    </p>
                  </td>
                  <td><span class="badge bg-label-success me-1">EE</span></td>
                  <td>
                    <div class="avatar avatar-xl">
                      <img src="{{ asset('admin/assets/img/avatars/award3.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                  </td>
                  <td> <small class="text-break">
                      You’re going beyond what’s asked of you.
                      Keep shining — your impact inspires others.

                    </small>
                  </td>
                  <td>08/07/2021</td>
                </tr>

                <tr>
                  <td class="sorting_1">
                    <div class="d-flex justify-content-start align-items-center product-name">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-package icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column">
                        <h6 class="text-nowrap mb-0">Teaching and Learning</h6>
                        <small class="text-truncate d-none d-sm-block">Student Teaching Satisfaction (feedback)</small>
                      </div>
                    </div>
                  </td>

                  <td>
                    <p class="text-primary fw-medium mb-0 d-flex align-items-center gap-1">
                      92%
                    </p>
                  </td>
                  <td><span class="badge bg-label-primary me-1">OS</span></td>
                  <td>
                    <div class="avatar avatar-xl">
                      <img src="{{ asset('admin/assets/img/avatars/award2.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                  </td>
                  <td> <small class="text-break">
                      You’re achieving excellence with distinction.You set the pace for others to follow.
                    </small>
                  </td>
                  <td>08/07/2021</td>
                </tr>

                <tr>
                  <td class="sorting_1">
                    <div class="d-flex justify-content-start align-items-center product-name">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-percentage icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column">
                        <h6 class="text-nowrap mb-0">Teaching and Learning</h6>
                        <small class="text-truncate d-none d-sm-block">Classes Held</small>
                      </div>
                    </div>
                  </td>

                  <td>
                    <p class="text-primary fw-medium mb-0 d-flex align-items-center gap-1">
                      90%
                    </p>
                  </td>
                  <td><span class="badge bg-label-primary me-1">OS</span></td>
                  <td>
                    <div class="avatar avatar-xl">
                      <img src="{{ asset('admin/assets/img/avatars/award2.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                  </td>
                  <td> <small class="text-break">
                      You’re achieving excellence with distinction.You set the pace for others to follow.
                    </small>
                  </td>
                  <td>08/07/2021</td>
                </tr>


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
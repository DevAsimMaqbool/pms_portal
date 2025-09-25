@extends('layouts.app')
@push('style')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/app-logistics-dashboard.css') }}" />



  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/swiper/swiper.css') }}" />
  <link rel="stylesheet"  href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
         <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/cards-advance.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
   <style>
  .h-50vh { height: 50vh; }
  
  @media (min-width: 992px) {
    .h-lg-100vh { height: 400px; }
  }
  @media (min-width: 1401px) {
    .h-md-70vh { height: 460px; }
  }
</style>
@endpush
@section('content')
   <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">



          <!-- Accordion1 -->
      <div class="row gy-6">
         <!-- Vertical Scrollbar -->
          <div class="col-lg-4 col-sm-12">
            <div class="card overflow-hidden h-50vh h-md-70vh h-lg-100vh">
              <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0 me-2 pt-1 mb-2 d-flex align-items-center"><i class="icon-base ti tabler-list-details me-3"></i>Indicator</h5>
              </div>
              <div class="card-body" id="vertical-example">
                  <ul class="p-0 m-0">
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="primary" data-series="72" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">% Employability </h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="success" data-series="48" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">% Employer Satisfaction </h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="danger" data-series="15" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">Student Satisfaction (Learning)</h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="info" data-series="24" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">Student Teacher Ratio</h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="info" data-series="29" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">% achievement of Research Publications target (Scopus Indexed)</h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>

                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="primary" data-series="72" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">No. of Solutions developed per PhD Students / Impact of research  (1PhD 1 Solution)</h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="success" data-series="48" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">Research Grantsand funding  submitted and won </h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="danger" data-series="15" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">Commercial Gains / Consultancy/Research Income</h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="info" data-series="24" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">Publication of HEC/Scoupus  recognized journals </h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="info" data-series="29" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">% of Admission Targets Achieved</h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods2">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
              
                  </ul>
              </div>
            </div>
          </div>
          <!--/ Vertical Scrollbar -->
          <!-- chart overview -->
          <div class="col-12 col-12 col-lg-8">
            <div class="card h-50vh h-md-70vh h-lg-100vh">
              <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0 me-2 pt-1 mb-2 d-flex align-items-center"><i class="icon-base ti tabler-chart-pie me-3"></i>Overall KPA Performance</h5>
              </div>
              <div class="card-body pt-0">
              <div style="width: 100%;">
                <canvas class="chartjs" id="radarChart" ></canvas>
              </div>
              <!-- if schrool -->
              {{-- <div style="overflow-x: auto; overflow-y: hidden; width: 100%;">
                <div id="carrierPerformances"></div>
              </div> --}}
               
              </div>
            </div>
          </div>
          <!--/ chart Overview -->
      </div>
      <!--/ Accordion1 -->
      <!-- Accordion -->
      <div class="row g-6">
        <div class="col-md">
          <div class="accordion mt-4" id="accordionExample">
            <div class="accordion-item" id="teaching-and-learning">
              <h2 class="accordion-header" id="headingOne">
                <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                <i class="icon-base ti tabler-star me-2"></i>
                Teaching and Learning</button>
              </h2>

              <div id="accordionOne" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body">
                
                
                 <!-- Accordion1 -->
                    <div class="row g-6 pt-2">
                      <!-- Card Border Shadow -->
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-primary h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-truck icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Teaching and Learning Outcome</p>
                            <!--<div id="supportTracker"></div>-->
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-warning h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods1">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Teaching Quality</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Teaching Management</p>
                            <div class="rating-stars"><i class="bi bi-star-fill text-warning"></i></div>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-info h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-clock icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">13%</h4>
                            </div>
                            <p class="mb-1">Student Engagement</p>
                            <!--<div id="expensesChart"></div>-->
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Program/Department Portfolio</p>
                            <div class="rating-stars"><i class="bi bi-star-fill text-warning"></i></div>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Faculty</p>
                            <div class="rating-stars"><i class="bi bi-star-fill text-warning"></i></div>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Research Productivity & Quality</p>
                            <div class="rating-stars"><i class="bi bi-star-fill text-warning"></i></div>
                            
                          </div>
                        </div>
                      </div>
                      <!--/ Card Border Shadow -->
                    </div>
                    <!--/ Accordion1 -->
                
                
                </div>
              </div>
            </div>
            <div class="accordion-item" id="research-innovation-and-commercialisation">
              <h2 class="accordion-header" id="headingTwo">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                <i class="icon-base ti tabler-sun me-2"></i>
                Research, Innovation and Commercialisation</button>
              </h2>
              <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake dragée ice cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly beans candy canes carrot cake. Fruitcake chocolate chupa chups.</div>
              </div>
            </div>
            <div class="accordion-item" id="financial-sustainability">
              <h2 class="accordion-header" id="headingThree">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="false" aria-controls="accordionThree">
                <i class="icon-base ti tabler-moon me-2"></i>Financial Sustainability</button>
              </h2>
              <div id="accordionThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">Oat cake toffee chocolate bar jujubes. Marshmallow brownie lemon drops cheesecake. Bonbon gingerbread marshmallow sweet jelly beans muffin. Sweet roll bear claw candy canes oat cake dragée caramels. Ice cream wafer danish cookie caramels muffin.</div>
              </div>
            </div>
             <div class="accordion-item" id="Internationalisation">
              <h2 class="accordion-header" id="headingfour">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionTwo">
                <i class="icon-base ti tabler-sun me-2"></i>
                Internationalisation</button>
              </h2>
              <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
                <div class="accordion-body">Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake dragée ice cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly beans candy canes carrot cake. Fruitcake chocolate chupa chups.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Accordion -->
           <div class="row g-6 mb-6 mt-6">
    <!-- Card Border Shadow -->
    @foreach($KeyPerformanceArea as $kfa)
            <div class="col-lg-2 col-6">
            <div class="card card-border-shadow-primary h-100 kfa-card" data-id="{{ $kfa->id }}">
                <div class="card-body text-center">
                <div class="badge rounded p-2 bg-label-primary mb-2">
                    <i class="icon-base ti tabler-chart-pie-2 icon-lg"></i>
                </div>
                {{-- <h5 class="card-title mb-1">{{ $kfa->id }}</h5> --}}
                <p class="mb-0">{{ $kfa->performance_area }}</p>
                </div>
            </div>
            </div>
         @endforeach
    </div>
    <h5 class="pb-1" id="indicator-category-cards-title"></h5>
    <div class="row g-6 mb-4" id="indicator-category-cards"></div>
    <h5 class="pb-1" id="indicator-cards-title"></h5>
    <div class="row g-6 mb-4" id="indicator-results"></div>
    <div class="row g-6">
    <!--/ Card Border Shadow -->
    <!-- Vehicles overview -->
    <div class="col-xxl-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Vehicles Overview</h5>
          </div>
          <div class="dropdown">
            <button class="btn btn-text-secondary rounded-pill p-2 border-0 me-n1" type="button" id="vehiclesOverview" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="vehiclesOverview">
              <a class="dropdown-item" href="javascript:void(0);">Select All</a>
              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
              <a class="dropdown-item" href="javascript:void(0);">Share</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="d-none d-lg-flex vehicles-progress-labels mb-6">
            <div class="vehicles-progress-label on-the-way-text" style="width: 39.7%;">On the way</div>
            <div class="vehicles-progress-label unloading-text" style="width: 28.3%;">Unloading</div>
            <div class="vehicles-progress-label loading-text" style="width: 17.4%;">Loading</div>
            <div class="vehicles-progress-label waiting-text text-nowrap" style="width: 14.6%;">Waiting</div>
          </div>
          <div class="vehicles-overview-progress progress rounded-3 mb-3 bg-transparent overflow-hidden" style="height: 46px;">
            <div class="progress-bar fw-medium text-start shadow-none bg-lighter text-heading px-4 rounded-0" role="progressbar" style="width: 39.7%" aria-valuenow="39.7" aria-valuemin="0" aria-valuemax="100">39.7%</div>
            <div class="progress-bar fw-medium text-start shadow-none bg-primary px-4" role="progressbar" style="width: 28.3%" aria-valuenow="28.3" aria-valuemin="0" aria-valuemax="100">28.3%</div>
            <div class="progress-bar fw-medium text-start shadow-none text-bg-info px-2 px-sm-4" role="progressbar" style="width: 17.4%" aria-valuenow="17.4" aria-valuemin="0" aria-valuemax="100">17.4%</div>
            <div class="progress-bar fw-medium text-start shadow-none snackbar text-paper px-1 px-sm-3 rounded-0 px-lg-4" role="progressbar" style="width: 14.6%" aria-valuenow="14.6" aria-valuemin="0" aria-valuemax="100">14.6%</div>
          </div>
          <div class="table-responsive">
            <table class="table card-table table-border-top-0 table-border-bottom-0">
              <tbody>
                <tr>
                  <td class="w-50 ps-0">
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="me-2">
                        <i class="icon-base ti tabler-car icon-lg text-heading"></i>
                      </div>
                      <h6 class="mb-0 fw-normal">On the way</h6>
                    </div>
                  </td>
                  <td class="text-end pe-0 text-nowrap">
                    <h6 class="mb-0">2hr 10min</h6>
                  </td>
                  <td class="text-end pe-0">
                    <span>39.7%</span>
                  </td>
                </tr>
                <tr>
                  <td class="w-50 ps-0">
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="me-2">
                        <i class="icon-base ti tabler-circle-arrow-down icon-lg text-heading"></i>
                      </div>
                      <h6 class="mb-0 fw-normal">Unloading</h6>
                    </div>
                  </td>
                  <td class="text-end pe-0 text-nowrap">
                    <h6 class="mb-0">3hr 15min</h6>
                  </td>
                  <td class="text-end pe-0">
                    <span>28.3%</span>
                  </td>
                </tr>
                <tr>
                  <td class="w-50 ps-0">
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="me-2">
                        <i class="icon-base ti tabler-circle-arrow-up icon-lg text-heading"></i>
                      </div>
                      <h6 class="mb-0 fw-normal">Loading</h6>
                    </div>
                  </td>
                  <td class="text-end pe-0 text-nowrap">
                    <h6 class="mb-0">1hr 24min</h6>
                  </td>
                  <td class="text-end pe-0">
                    <span>17.4%</span>
                  </td>
                </tr>
                <tr>
                  <td class="w-50 ps-0">
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="me-2">
                        <i class="icon-base ti tabler-clock icon-lg text-heading"></i>
                      </div>
                      <h6 class="mb-0 fw-normal">Waiting</h6>
                    </div>
                  </td>
                  <td class="text-end pe-0 text-nowrap">
                    <h6 class="mb-0">5hr 19min</h6>
                  </td>
                  <td class="text-end pe-0">
                    <span>14.6%</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!--/ Vehicles overview -->

    <!-- Shipment statistics-->
    <div class="col-xxl-6 col-lg-7">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1">Shipment statistics</h5>
            <p class="card-subtitle">Total number of deliveries 23.8k</p>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-label-primary">January</button>
            <button type="button" class="btn btn-label-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="javascript:void(0);">January</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">February</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">March</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">April</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">May</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">June</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">July</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">August</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">September</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">October</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">November</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">December</a></li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <div id="shipmentStatisticsChart"></div>
        </div>
      </div>
    </div>
    <!--/ Shipment statistics -->

    <!-- Delivery Performance -->
    <div class="col-xxl-4 col-lg-5">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1 me-2">Delivery Performance</h5>
            <p class="card-subtitle">12% increase in this month</p>
          </div>
          <div class="dropdown">
            <button class="btn btn-text-secondary rounded-pill p-2 me-n1" type="button" id="deliveryPerformance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-base ti tabler-dots-vertical icon-md"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">
              <a class="dropdown-item" href="javascript:void(0);">Select All</a>
              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
              <a class="dropdown-item" href="javascript:void(0);">Share</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
            <li class="d-flex mb-6 align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-package icon-26px"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1 fw-normal">Packages in transit</h6>
                  <small class="text-success mb-0">
                    <i class="icon-base ti tabler-chevron-up me-1"></i>
                    25.8%
                  </small>
                </div>
                <div class="user-progress">
                  <h6 class="text-body mb-0">10k</h6>
                </div>
              </div>
            </li>
            <li class="d-flex mb-6 align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-truck icon-28px"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1 fw-normal">Packages out for delivery</h6>
                  <small class="text-success mb-0">
                    <i class="icon-base ti tabler-chevron-up me-1"></i>
                    4.3%
                  </small>
                </div>
                <div class="user-progress">
                  <h6 class="text-body mb-0">5k</h6>
                </div>
              </div>
            </li>
            <li class="d-flex mb-6 align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-success"><i class="icon-base ti tabler-circle-check icon-26px"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1 fw-normal">Packages delivered</h6>
                  <small class="text-danger mb-0">
                    <i class="icon-base ti tabler-chevron-down me-1"></i>
                    12.5
                  </small>
                </div>
                <div class="user-progress">
                  <h6 class="text-body mb-0">15k</h6>
                </div>
              </div>
            </li>
            <li class="d-flex mb-6 align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-percentage icon-26px"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1 fw-normal">Delivery success rate</h6>
                  <small class="text-success mb-0">
                    <i class="icon-base ti tabler-chevron-up me-1"></i>
                    35.6%
                  </small>
                </div>
                <div class="user-progress">
                  <h6 class="text-body mb-0">95%</h6>
                </div>
              </div>
            </li>
            <li class="d-flex mb-6 align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-secondary"><i class="icon-base ti tabler-clock icon-26px"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1 fw-normal">Average delivery time</h6>
                  <small class="text-danger mb-0">
                    <i class="icon-base ti tabler-chevron-down me-1"></i>
                    2.15
                  </small>
                </div>
                <div class="user-progress">
                  <h6 class="text-body mb-0">2.5 Days</h6>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-users icon-26px"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1 fw-normal">Customer satisfaction</h6>
                  <small class="text-success mb-0">
                    <i class="icon-base ti tabler-chevron-up me-1"></i>
                    5.7%
                  </small>
                </div>
                <div class="user-progress">
                  <h6 class="text-body mb-0">4.5/5</h6>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--/ Delivery Performance -->

    <!-- Reasons for delivery exceptions -->
    <div class="col-xxl-4 col-lg-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Reasons for delivery exceptions</h5>
          </div>
          <div class="dropdown">
            <button class="btn btn-text-secondary rounded-pill  p-2 me-n1" type="button" id="deliveryExceptions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptions">
              <a class="dropdown-item" href="javascript:void(0);">Select All</a>
              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
              <a class="dropdown-item" href="javascript:void(0);">Share</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div id="deliveryExceptionsChart"></div>
        </div>
      </div>
    </div>
    <!--/ Reasons for delivery exceptions -->

    <!-- Orders by Countries -->
    <div class="col-xxl-4 col-lg-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1">Orders by Countries</h5>
            <p class="card-subtitle">62 deliveries in progress</p>
          </div>
          <div class="dropdown">
            <button class="btn btn-text-secondary rounded-pill  p-2 me-n1" type="button" id="ordersCountries" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-base ti tabler-dots-vertical icon-md"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountryTabs">
              <a class="dropdown-item" href="javascript:void(0);">Select All</a>
              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
              <a class="dropdown-item" href="javascript:void(0);">Share</a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="nav-align-top">
            <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-new" aria-controls="navs-justified-new" aria-selected="true">New</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-link-preparing" aria-controls="navs-justified-link-preparing" aria-selected="false">Preparing</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-link-shipping" aria-controls="navs-justified-link-shipping" aria-selected="false">Shipping</button>
              </li>
            </ul>
            <div class="tab-content border-0  mx-1">
              <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                <ul class="timeline mb-0">
                  <li class="timeline-item ps-6 border-dashed">
                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                      <i class="icon-base ti tabler-circle-check"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-success text-uppercase">sender</small>
                      </div>
                      <h6 class="my-50">Myrtle Ullrich</h6>
                      <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                    </div>
                  </li>
                  <li class="timeline-item ps-6 border-transparent">
                    <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                      <i class="icon-base ti tabler-map-pin"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-primary text-uppercase">Receiver</small>
                      </div>
                      <h6 class="my-50">Barry Schowalter</h6>
                      <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                    </div>
                  </li>
                </ul>
                <div class="border-1 border-light border-dashed my-4"></div>
                <ul class="timeline mb-0">
                  <li class="timeline-item ps-6 border-dashed">
                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                      <i class="icon-base ti tabler-circle-check"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-success text-uppercase">sender</small>
                      </div>
                      <h6 class="my-50">Veronica Herman</h6>
                      <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                    </div>
                  </li>
                  <li class="timeline-item ps-6 border-transparent">
                    <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                      <i class="icon-base ti tabler-map-pin"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-primary text-uppercase">Receiver</small>
                      </div>
                      <h6 class="my-50">Helen Jacobs</h6>
                      <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                <ul class="timeline mb-0">
                  <li class="timeline-item ps-6 border-dashed">
                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                      <i class="icon-base ti tabler-circle-check"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-success text-uppercase">sender</small>
                      </div>
                      <h6 class="my-50">Barry Schowalter</h6>
                      <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                    </div>
                  </li>
                  <li class="timeline-item ps-6 border-transparent border-dashed">
                    <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                      <i class="icon-base ti tabler-map-pin"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-primary text-uppercase">Receiver</small>
                      </div>
                      <h6 class="my-50">Myrtle Ullrich</h6>
                      <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                    </div>
                  </li>
                </ul>
                <div class="border-1 border-light border-dashed my-4"></div>
                <ul class="timeline mb-0">
                  <li class="timeline-item ps-6 border-dashed">
                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                      <i class="icon-base ti tabler-circle-check"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-success text-uppercase">sender</small>
                      </div>
                      <h6 class="my-50">Veronica Herman</h6>
                      <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                    </div>
                  </li>
                  <li class="timeline-item ps-6 border-transparent">
                    <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                      <i class="icon-base ti tabler-map-pin"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-primary text-uppercase">Receiver</small>
                      </div>
                      <h6 class="my-50">Helen Jacobs</h6>
                      <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
                <ul class="timeline mb-0">
                  <li class="timeline-item ps-6 border-dashed">
                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                      <i class="icon-base ti tabler-circle-check"></i>
                    </span> 
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-success text-uppercase">sender</small>
                      </div>
                      <h6 class="my-50">Veronica Herman</h6>
                      <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                    </div>
                  </li>
                  <li class="timeline-item ps-6 border-transparent">
                    <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                      <i class="icon-base ti tabler-map-pin"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-primary text-uppercase">Receiver</small>
                      </div>
                      <h6 class="my-50">Barry Schowalter</h6>
                      <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                    </div>
                  </li>
                </ul>
                <div class="border-1 border-light border-dashed my-4"></div>
                <ul class="timeline mb-0">
                  <li class="timeline-item ps-6 border-dashed">
                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                      <i class="icon-base ti tabler-circle-check"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-success text-uppercase">sender</small>
                      </div>
                      <h6 class="my-50">Myrtle Ullrich</h6>
                      <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                    </div>
                  </li>
                  <li class="timeline-item ps-6 border-transparent">
                    <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                      <i class="icon-base ti tabler-map-pin"></i>
                    </span>
                    <div class="timeline-event ps-1">
                      <div class="timeline-header">
                        <small class="text-primary text-uppercase">Receiver</small>
                      </div>
                      <h6 class="my-50">Helen Jacobs</h6>
                      <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Orders by Countries -->

    
  </div>


   <!-- Payment Methods modal -->
<div class="modal fade" id="paymentMethods" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="mb-2">Departments</h4>
        </div>
        

        <!-- Source Visit -->
     
          <ul class="list-unstyled mb-0">
            <li class="mb-4">
              <div class="d-flex align-items-center">
                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Computer Science</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <p class="mb-0">1.2k</p>
                    <div class="ms-4 badge bg-label-success">+4.2%</div>
                  </div>
                </div>
              </div>
            </li>
            <li class="mb-4">
              <div class="d-flex align-items-center">
                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-globe icon-md"></i></div>
                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Information Technology</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <p class="mb-0">31.5k</p>
                    <div class="ms-4 badge bg-label-success">+8.2%</div>
                  </div>
                </div>
              </div>
            </li>
            <li class="mb-4">
              <div class="d-flex align-items-center">
                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-mail icon-md"></i></div>
                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Software Engineering</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <p class="mb-0">893</p>
                    <div class="ms-4 badge bg-label-success">+2.4%</div>
                  </div>
                </div>
              </div>
            </li>
            <li class="mb-4">
              <div class="d-flex align-items-center">
                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-external-link icon-md"></i></div>
                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Data Science</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <p class="mb-0">342</p>
                    <div class="ms-4 badge bg-label-danger">-0.4%</div>
                  </div>
                </div>
              </div>
            </li>
            <li class="mb-4">
              <div class="d-flex align-items-center">
                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-ad icon-md"></i></div>
                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Artificial Intelligence</h6>
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
                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-star icon-md"></i></div>
                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Cyber Security</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <p class="mb-0">12.5k</p>
                    <div class="ms-4 badge bg-label-success">+6.2%</div>
                  </div>
                </div>
              </div>
            </li>
          </ul>

    <!--/ Source Visit -->
        
      </div>
    </div>
  </div>
</div>
<!-- / Payment Methods modal -->
 <!-- Payment Methods modal -->
<div class="modal fade" id="paymentMethods1" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="mb-2">KPA</h4>
          <p>Supported payment methods</p>
        </div>
          <div style="height: 50vh; width: 100%;">
            <canvas class="chartjs" id="radarChart" ></canvas>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- / Payment Methods modal -->
<!--  Payment Methods modal -->


<!-- / Payment Methods modal -->
 <!-- Payment Methods modal -->
<div class="modal fade" id="paymentMethods2" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle"><i class="icon-base ti tabler-list-details me-3"></i>Faculties</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <!-- Accordion1 -->
                    <div class="row g-6 pt-2">
                      <!-- Card Border Shadow -->
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-primary h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-truck icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Business and Management Sciences</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-warning h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods1">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty Of Economics and Commerce</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Faculty of Computer Science and Information Technology</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-info h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-clock icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">13%</h4>
                            </div>
                            <p class="mb-1">Faculty of Social Sciences</p>
                          </div>
                        </div>
                      </div>
                      <!--/ Card Border Shadow -->
                      <!-- Card Border Shadow -->
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-primary h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-truck icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Allied Health Sciences</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-warning h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods1">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Art and Design</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Faculty of Pharmacy</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-info h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-clock icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">13%</h4>
                            </div>
                            <p class="mb-1">Faculty of Medical Sciences</p>
                          </div>
                        </div>
                      </div>
                      <!--/ Card Border Shadow -->
                      <!-- Card Border Shadow -->
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-primary h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-truck icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Engineering and Technology</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-warning h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods1">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Sciences</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Faculty of Arts and Humanities</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-info h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-clock icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">13%</h4>
                            </div>
                            <p class="mb-1">Faculty of Law</p>
                          </div>
                        </div>
                      </div>
                      <!--/ Card Border Shadow -->
                      <!-- Card Border Shadow -->
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-primary h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-truck icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Agriculture and Veterinary Sciences</p>
                            
                          </div>
                        </div>
                      </div>
                
                      <!--/ Card Border Shadow -->
                     
                      
                    </div>
                    <!--/ Accordion1 -->
        
      </div>
    </div>
  </div>
</div>
<!-- / Payment Methods modal -->

<!-- Payment Methods modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle"><i class="icon-base ti tabler-list-details me-3"></i>Faculties</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="categoryModalBody">
          <!-- Accordion1 -->
                    <div class="row g-6 pt-2">
                      <!-- Card Border Shadow -->
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-primary h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-truck icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Business and Management Sciences</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-warning h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods1">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty Of Economics and Commerce</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Faculty of Computer Science and Information Technology</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-info h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-clock icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">13%</h4>
                            </div>
                            <p class="mb-1">Faculty of Social Sciences</p>
                          </div>
                        </div>
                      </div>
                      <!--/ Card Border Shadow -->
                      <!-- Card Border Shadow -->
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-primary h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-truck icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Allied Health Sciences</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-warning h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods1">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Art and Design</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Faculty of Pharmacy</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-info h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-clock icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">13%</h4>
                            </div>
                            <p class="mb-1">Faculty of Medical Sciences</p>
                          </div>
                        </div>
                      </div>
                      <!--/ Card Border Shadow -->
                      <!-- Card Border Shadow -->
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-primary h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-truck icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Engineering and Technology</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-warning h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods1">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Sciences</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base ti tabler-git-fork icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">27%</h4>
                            </div>
                            <p class="mb-1">Faculty of Arts and Humanities</p>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-info h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-clock icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">13%</h4>
                            </div>
                            <p class="mb-1">Faculty of Law</p>
                          </div>
                        </div>
                      </div>
                      <!--/ Card Border Shadow -->
                      <!-- Card Border Shadow -->
                      <div class="col-lg-3 col-sm-6">
                        <div class="card card-border-shadow-primary h-100" role="button"
                          data-bs-toggle="modal"
                          data-bs-target="#paymentMethods">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                              <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-truck icon-28px"></i></span>
                              </div>
                              <h4 class="mb-0">8%</h4>
                            </div>
                            <p class="mb-1">Faculty of Agriculture and Veterinary Sciences</p>
                            
                          </div>
                        </div>
                      </div>
                
                      <!--/ Card Border Shadow -->
                     
                      
                    </div>
                    <!--/ Accordion1 -->
        
      </div>
    </div>
  </div>
</div>
<!-- / Payment Methods modal -->
        </div>
   <!-- / Content -->
@endsection
@push('script')
<script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>


 <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
  <script src="{{ asset('admin/assets/js/cards-analytics.js')}}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
  <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app-ecommerce-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/js/extended-ui-perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/js/cards-advance.js') }}"></script>
@endpush
@push('script')
<script>
$(document).ready(function () {

    // On KPA card click, fetch related indicator categories
    $('.kfa-card').on('click', function () {
        var kfaId = $(this).data('id');

        $.ajax({
            url: '{{ route("indicatorCategory.getIndicatorCategories") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                kpa_ids: [kfaId]
            },
            success: function (data) {
                let html = '';
                if (data.length > 0) {
                    data.forEach(function (category) {
                        html += `
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input indicatir-data" type="checkbox" value="${category.id}" id="category_${category.id}">
                                            <label class="form-check-label" for="category_${category.id}">
                                                ${category.indicator_category}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                    });
                } else {
                    html = `<div class="col-12"><p>No Indicator Categories found.</p></div>`;
                }
                $('#indicator-category-cards-title').html('Indicator Category');
                $('#indicator-category-cards').html(html);

                // Clear indicators when new KPA is selected
                $('#indicator-cards-title').html('');
                $('#indicator-results').html('');
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Something went wrong!');
            }
        });
    });

    // On change of category checkbox, fetch related indicators
    $(document).on('change', '.indicatir-data', function () {
        let selectedCategoryIds = [];

        $('.indicatir-data:checked').each(function () {
            selectedCategoryIds.push($(this).val());
        });

        if (selectedCategoryIds.length > 0) {
            $.ajax({
                url: '{{ route("indicator.getIndicators") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    category_ids: selectedCategoryIds
                },
                success: function (indicators) {
                    let output = '';
                    if (indicators.length > 0) {
                        indicators.forEach(function (indicator) {
                            const chartId = `deliveryExceptionsChart_${indicator.id}`;
                            const chartType = (indicator.id % 2 === 0) ? 'radialBar' : 'area';
                            output += `
                              <div class="col-xl-3 col-md-4 col-6">
                              <div class="card h-100">
                                <div class="card-header pb-2">
                                    <p class="card-subtitle">${indicator.indicator}</p>
                                </div>
                                <div class="card-body">
                                  <div id="${chartId}" class="chart-container"></div>
                                </div>
                              </div>
                            </div>`;
                            indicator.chart_id = chartId;
                            indicator.chart_type = chartType;

                            // Add random data if not provided remove
                            if (chartType === 'radialBar') {
                                indicator.value = Math.floor(Math.random() * 100); // 0 to 100
                            } else {
                                indicator.data = Array.from({ length: 7 }, () => Math.floor(Math.random() * 100));
                            }
                            // Add random data if not provided remove
                        });
                    } else {
                        output = `<div class="col-12"><p>No Indicators found.</p></div>`;
                    }
                    $('#indicator-cards-title').html('Indicator');
                    $('#indicator-results').html(output);

                     // Render charts based on type remove
                    indicators.forEach(function (indicator) {
                        if (indicator.chart_type === 'radialBar') {
                            initRadialChart(indicator.chart_id, indicator.value);
                        } else if (indicator.chart_type === 'area') {
                            initAreaChart(indicator.chart_id, indicator.data);
                        }
                    });
                   // Render charts based on type remove
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Error loading indicators.');
                }
            });
        } else {
            $('#indicator-results').html('');
        }
    });

});
function initRadialChart(chartId) {
    const options = {
        chart: {
            height:150,
            sparkline: {
                enabled: !0
            },
            parentHeightOffset: 0,
            type: 'radialBar'
        },
        series: [Math.floor(Math.random() * 100)], // Replace with dynamic value if needed
        labels: ['indicator'], // You can customize this
        plotOptions: {
            radialBar: {
                hollow: {
                    size: '60%'
                },
                dataLabels: {
                    name: {
                        show: true
                    },
                    value: {
                        show: true
                    }
                }
            }
        },
        colors: ['#ff9f43'] // Optional: Theme color
    };

    const chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
    chart.render();
}
function initAreaChart(chartId, data) {
    const options = {
        chart: {
            height:  150,
            type: 'area'
        },
        series: [{
            name: 'Performance',
            data: data
        }],
        xaxis: {
            categories: data.map((_, i) => `Day ${i + 1}`)
        },
        colors: ['#7367F0'],
        stroke: { curve: 'smooth' },
        dataLabels: { enabled: false }
    };

    new ApexCharts(document.querySelector(`#${chartId}`), options).render();
}
document.addEventListener("DOMContentLoaded", function () {
      // ✅ Static labels and datasets
      var chartLabels = ["Teaching and Learning","Research Innovation and Commercialisation","Financial Sustainability","Internationalisation","Social Responsibility","Institutional Identity", "Leadership and Governance"];
      var dataset1 = [95, 90, 85, 80,95, 75, 80]; // Inside Mirror

      var g = document.getElementById("radarChart");
      if (g) {
        var ctx = g.getContext("2d");

        // ✅ Gradients
        var gradientBlue = ctx.createLinearGradient(0, 0, 0, 150);
        gradientBlue.addColorStop(0, "rgba(85, 85, 255, 0.9)");
        gradientBlue.addColorStop(1, "rgba(151, 135, 255, 0.8)");

        var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
        gradientPink.addColorStop(0, "rgba(115, 103, 240, 1)");
        gradientPink.addColorStop(1, "rgba(115, 103, 240, 1)");

        // ✅ Radar Chart
        new Chart(ctx, {
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
                pointBorderColor: "#ff55b8",
                pointBackgroundColor: "#fff",
                pointRadius: 5,
                pointHoverRadius: 7,
                pointStyle: "circle"
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 500 },
            scales: {
              r: {
                ticks: { display: true, color: "#666" },
                grid: { color: "#ddd" },
                angleLines: { color: "#ddd" },
                pointLabels: {
                   color: "#666",
                   font: {
                      size: 12, // label text size
                    },
                   callback: function (label) {
                      // Show only first 10 characters
                      return label.length > 20 ? label.substring(0, 20) + "..." : label;
                    }
                  }
              }
            },
            plugins: {
              legend: {
                position: "top",
                labels: {
                  padding: 25,
                  color: "#333"
                }
              },
              tooltip: {
                backgroundColor: "#fff",
                titleColor: "#000",
                bodyColor: "#333",
                borderWidth: 1,
                borderColor: "#ddd"
              }
            }
          },
          plugins: [
              {
                id: "pointLabelClick",
                afterEvent(chart, args) {
                  const { event } = args;
                  if (!event) return;

                  const { scales } = chart;
                  const rScale = scales.r;
                  let hovering = false;

                  chart.data.labels.forEach((label, i) => {
                    const angle = rScale.getIndexAngle(i);
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
                          // 1️⃣ Scroll into view
                          targetDiv.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                          });

                          // 2️⃣ Open accordion (if collapsed)
                          const collapseEl = targetDiv.querySelector(".accordion-collapse");
                          if (collapseEl && !collapseEl.classList.contains("show")) {
                            const bsCollapse = new bootstrap.Collapse(collapseEl, {
                              toggle: true
                            });
                          }

                          // 3️⃣ Optionally mark as active
                          document
                            .querySelectorAll(".accordion-item")
                            .forEach((item) => item.classList.remove("active"));
                          targetDiv.classList.add("active");
                        }
                      }
                    }
                  });

                  // 👉 Change cursor style on hover
                  chart.canvas.style.cursor = hovering ? "pointer" : "default";
                }
              }
            ]

        });
      }
    });
   document.addEventListener("DOMContentLoaded", function () {
  const childModalEl = document.getElementById("paymentMethods");

  // Prevent parent from closing when child opens
  childModalEl.addEventListener("show.bs.modal", function () {
    document.body.classList.add("modal-open"); // keep body locked
  });

  // When child closes, parent stays open
  childModalEl.addEventListener("hidden.bs.modal", function () {
    if (document.getElementById("paymentMethods2").classList.contains("show")) {
      document.body.classList.add("modal-open"); // restore scroll lock
    }
  });
});


document.addEventListener("DOMContentLoaded", function () {
  // element check
  var c = document.getElementById("carrierPerformances");
  if (!c) {
    console.error("Element #carrierPerformances not found");
    return;
  }


  var n = "#6c757d";                              // label color
  var l = "Arial, sans-serif";                    // font-family
  var s = "#6c757d";                              // legend label color
  var r = { bar: { series1: "#4e73df", series2: "#f6c23e" } };


  var categories = ["Teaching and Learning","Research Innovation and Commercialisation","Financial Sustainability","Internationalisation ","Social Responsibility","Institutional Identity", "Leadership and Governance"];
  var deliveryRates = [10,20,30,40,50,60,70];
  var deliveryExceptions = [70,60,50,40,30,20,10];

  
  var options = {
    chart: {
      height: 330,
      type: "bar",
      events: {
        mounted: function () {
          // after chart renders, attach click events to x-axis labels
          document.querySelectorAll("#carrierPerformances .apexcharts-xaxis text").forEach((el, index) => {
            el.style.cursor = "pointer"; // make it look clickable
            el.addEventListener("click", function () {
              var myModal = new bootstrap.Modal(document.getElementById("categoryModal"));
              myModal.show();
            });
          });
        }
      },
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
      { name: "Delivery rate", data: deliveryRates },
      { name: "Delivery exceptions", data: deliveryExceptions }
    ],
    xaxis: {
      categories: categories,
      tickAmount: 10,
      labels: {
        formatter: function (value) {
          return value.length > 10 ? value.substring(0, 10) + "..." : value;
        },
        style: { colors: n, fontSize: "13px", fontFamily: l, fontWeight: 400 }
      },
      axisBorder: { show: false },
      axisTicks: { show: false }
    },
    yaxis: {
      tickAmount: 9,
      min: 1,
      max: 100,
      labels: {
        style: { colors: n, fontSize: "13px", fontFamily: l, fontWeight: 400 },
        formatter: function (val) { return val; }
      }
    },
    tooltip: {
      x: {
        formatter: function (val, opts) {
          // Always return the full category name here
          return categories[opts.dataPointIndex];
        }
      }
    },
    legend: {
      show: true,
      position: "bottom",
      markers: { size: 5, shape: "circle" },
      height: 40,
      itemMargin: { horizontal: 8, vertical: 0 },
      fontSize: "13px",
      fontFamily: l,
      fontWeight: 400,
      labels: { colors: s, useSeriesColors: false },
      offsetY: -5
    },
    grid: { strokeDashArray: 6, padding: { bottom: 5 } },
    colors: [r.bar.series1, r.bar.series2],
    fill: { opacity: 1 },
    responsive: [
      { breakpoint: 1400, options: { chart: { height: 275 }, legend: { fontSize: "13px", offsetY: 10 } } },
      { breakpoint: 576,  options: { chart: { height: 300 }, legend: { itemMargin: { vertical: 5, horizontal: 10 }, offsetY: 7 } } }
    ]
  };

  new ApexCharts(c, options).render();
});
</script>
@endpush


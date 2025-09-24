@extends('layouts.app')
@push('style')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/swiper/swiper.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />
  <link rel="stylesheet"  href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />

  <!-- Page CSS -->
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
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" >
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
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
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
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
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
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
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
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
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
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
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
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
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
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
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
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
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
                <h5 class="card-title m-0 me-2 pt-1 mb-2 d-flex align-items-center"><i class="icon-base ti tabler-chart-pie me-3"></i>Department Performance</h5>
              </div>
              <div class="card-body pt-2">
               <div id="carrierPerformance"></div>
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
            <div class="accordion-item">
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
                              <div class="half-star-ratings raty" data-half="true" data-score="4.2" data-number="5"></div>
                            </div>
                            <p class="mb-1">Teaching and Learning</p>
                            <div id="supportTracker"></div>
                            
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
                            <p class="mb-1">Research, Innovation and Commercialisation</p>
                            
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
                            <p class="mb-1">Institutional Engagement (Operational+ Character Strengths)</p>
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
                            <p class="mb-1">Institutional Engagement (Core only)</p>
                            <div id="expensesChart"></div>
                          </div>
                        </div>
                      </div>
                      <!--/ Card Border Shadow -->
                    </div>
                    <!--/ Accordion1 -->
                
                
                </div>
              </div>
            </div>
            <div class="accordion-item active">
              <h2 class="accordion-header" id="headingTwo">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                <i class="icon-base ti tabler-sun me-2"></i>
                Research, Innovation and Commercialisation</button>
              </h2>
              <div id="accordionTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake dragée ice cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly beans candy canes carrot cake. Fruitcake chocolate chupa chups.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="false" aria-controls="accordionThree">
                <i class="icon-base ti tabler-moon me-2"></i>Institutional Engagement (Operational+ Character Strengths)</button>
              </h2>
              <div id="accordionThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">Oat cake toffee chocolate bar jujubes. Marshmallow brownie lemon drops cheesecake. Bonbon gingerbread marshmallow sweet jelly beans muffin. Sweet roll bear claw candy canes oat cake dragée caramels. Ice cream wafer danish cookie caramels muffin.</div>
              </div>
            </div>
             <div class="accordion-item">
              <h2 class="accordion-header" id="headingfour">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionTwo">
                <i class="icon-base ti tabler-sun me-2"></i>
                Institutional Engagement (Core only)</button>
              </h2>
              <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
                <div class="accordion-body">Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake dragée ice cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly beans candy canes carrot cake. Fruitcake chocolate chupa chups.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Accordion -->
     
      <!-- Payment Methods modal -->
<div class="modal fade" id="paymentMethods" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="mb-2">Select payment methods</h4>
          <p>Supported payment methods</p>
        </div>

        <div class="d-flex justify-content-between align-items-center border-bottom py-4 mb-4">
          <div class="d-flex gap-4 align-items-center">
          <img src="../../assets/img/icons/payments/ae-light.png" class="img-fluid w-px-50 h-px-30" alt="american-express-card" data-app-light-img="icons/payments/ae-light.png" data-app-dark-img="icons/payments/ae-dark.png" />
            <h6 class="m-0">Visa</h6>
          </div>
          <p class="m-0 d-none d-sm-block">Credit Card</p>
        </div>
        <div class="d-flex justify-content-sm-between align-items-center border-bottom pb-4 mb-4">
          <div class="d-flex gap-4 align-items-center">
            <img src="../../assets/img/icons/payments/ae-light.png" class="img-fluid w-px-50 h-px-30" alt="american-express-card" data-app-light-img="icons/payments/ae-light.png" data-app-dark-img="icons/payments/ae-dark.png" />

            <h6 class="m-0">American Express</h6>
          </div>
          <p class="m-0 d-none d-sm-block">Credit Card</p>
        </div>
        <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4">
          <div class="d-flex gap-4 align-items-center">
            <img src="../../assets/img/icons/payments/master-light.png" class="img-fluid w-px-50 h-px-30" alt="master-card" data-app-light-img="icons/payments/master-light.png" data-app-dark-img="icons/payments/master-dark.png" />

            <h6 class="m-0">Mastercard</h6>
          </div>
          <p class="m-0 d-none d-sm-block">Credit Card</p>
        </div>
        <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4">
          <div class="d-flex gap-4 align-items-center">
            <img src="../../assets/img/icons/payments/jcb-light.png" class="img-fluid w-px-50 h-px-30" alt="jcb-card" data-app-light-img="icons/payments/jcb-light.png" data-app-dark-img="icons/payments/jcb-dark.png" />
            <h6 class="m-0">JCB</h6>
          </div>
          <p class="m-0 d-none d-sm-block">Credit Card</p>
        </div>
        <div class="d-flex justify-content-between align-items-center pb-4">
          <div class="d-flex gap-4 align-items-center">
            <img src="../../assets/img/icons/payments/dc-light.png" class="img-fluid w-px-50 h-px-30" alt="diners-club-card" data-app-light-img="icons/payments/dc-light.png" data-app-dark-img="icons/payments/dc-dark.png" />
            <h6 class="m-0">Diners Club</h6>
          </div>
          <p class="m-0 d-none d-sm-block">Credit Card</p>
        </div>
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
  </div>
  <!-- / Content -->
@endsection
@push('script')
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

  <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
  <script src="{{ asset('admin/assets/js/cards-analytics.js')}}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
  <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app-ecommerce-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/js/extended-ui-perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/js/cards-advance.js') }}"></script>
  <script>
  document.addEventListener("DOMContentLoaded", function () {
      // ✅ Static labels and datasets
      var chartLabels = ["Teaching and Learning", "Research", "Institutional Engagement", "Institutional Engagement"];
      var dataset1 = [65, 59, 90, 81]; // Inside Mirror

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
                pointLabels: { color: "#666" }
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
          }
        });
      }
    });</script>

@endpush
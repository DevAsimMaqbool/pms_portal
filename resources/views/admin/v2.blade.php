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
.scrollable-card-container {
  max-height: 400px; /* Adjust height as needed */
  overflow-y: auto;
  padding-right: 8px;
  scroll-behavior: smooth;
}

/* Optional: custom scrollbar styling */
.scrollable-card-container::-webkit-scrollbar {
  width: 0px;
  background: transparent;
}
.scrollable-card-container {
  -ms-overflow-style: none;  /* Hide scrollbar for IE and Edge */
  scrollbar-width: none;     /* Hide scrollbar for Firefox */
}
.animated-card-x:hover {
      animation: rotate3DX 5s ease-in-out infinite;
       transform-style: preserve-3d;
       box-shadow: 0 20px 35px rgba(0, 0, 0, 0.15);
    }

    @keyframes rotate3DX {
      0% { transform: rotateX(0deg); }
      100% { transform: rotateX(360deg); }
    }
    .animated-card-y:hover {
      animation: rotate3DY 6s linear infinite;
    }

    @keyframes rotate3DY {
      0% { transform: rotateY(0deg); }
      100% { transform: rotateY(360deg); }
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
  0% { transform: rotateX(0deg); }
  50% { transform: rotateX(6deg); }
  100% { transform: rotateX(0deg); }
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
  0%, 100% { transform: scale(1) translateZ(0); }
  50% { transform: scale(0.93) translateZ(-25px); }
}

/* Optional: subtle breathing zoom effect (auto animation) */
@keyframes zoomIn3D {
  0%, 100% { transform: scale(1) translateZ(0); }
  50% { transform: scale(1.08) translateZ(20px); }
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
  border-radius: 0.375rem; /* Bootstrap card border radius */
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
</style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
       <!-- Accordion1 -->
      <div class="row gy-6">


         <div class="col-md-6 col-lg-4">
          <div class=" d-flex justify-content-between">
          <h5 class="mt-2 text-body-secondary">Body</h5>
          <h6 class="mt-2 text-body-secondary">See all</h6>
          </div>
          <div class="scrollable-card-container mt-3">
                 
                <!-- example -->

        <div class="card mb-6">
          <div class="card-body">                  
            <div class="d-flex align-items-center">
              <div class="badge bg-label-danger p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
              <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Direct Source</h6>
                  <small class="text-body">Direct link click</small>
                </div>  
                <div class="d-flex flex-grow-1 align-items-center">
                  <div class="progress w-100 me-4" style="height:8px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="text-body-secondary">65%</span>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- animation -->
        <div class="card mb-6 animated-card-y">
          <div class="card-body">                  
            <div class="d-flex align-items-center">
              <div class="badge bg-label-success p-2 me-4 rounded">
                <i class="icon-base ti tabler-shadow icon-md"></i>
              </div>
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
          </div>
        </div>




        <div class="card-wrapper-x">
        <div class="card mb-6 animated-card-z">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-primary">
                  <i class="icon-base ti tabler-video icon-lg"></i>
                </span>
              </div>
              <div class="row w-100 align-items-center">
                <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                  <h6 class="mb-0">Videography Basic Design Course</h6>
                </div>
                <div class="col-sm-4 col-lg-12 col-xxl-4 d-flex justify-content-xxl-end">
                  <div class="badge bg-label-secondary">1.2k Views</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="card mb-6 animated-card-zoom">
          <div class="card-body">                  
            <div class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-primary">
                  <i class="icon-base ti tabler-video icon-lg"></i>
                </span>
              </div>
              <div class="row w-100 align-items-center">
                <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                  <h6 class="mb-0">example Basic Design Course</h6>
                </div>
                <div class="col-sm-4 col-lg-12 col-xxl-4 d-flex justify-content-xxl-end">
                  <div class="badge bg-label-secondary">1.2k Views</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- / animation -->

        <div class="card mb-6 animated-card-x">
          <div class="card-body">                  
            

              <div class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-video icon-lg"></i></span>
              </div>
              <div class="row w-100 align-items-center">
                <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                  <h6 class="mb-0">Videography Basic Design Course</h6>
                </div>
                <div class="col-sm-4 col-lg-12 col-xxl-4 d-flex justify-content-xxl-end">
                  <div class="badge bg-label-secondary">1.2k Views</div>
                </div>
              </div>
            </div>


          </div>
        </div>
        
                <!-- /example -->


          </div>
        </div>
        <div class="col-md-6 col-lg-4">
        <div class=" d-flex justify-content-between">
        <h5 class="mt-2 text-body-secondary">Department Performance</h5>
        </div>
        

      <div class="row g-6">
        <!-- Profit last month -->
        {{-- <div class="col-xl-6 col-sm-6">
          <div class="card h-100">
            

            <div class="card-body">
          <div class="badge p-2 bg-label-danger mb-3 rounded"><i class="icon-base ti tabler-credit-card icon-28px"></i></div>
          <h5 class="card-title mb-1">Total Profit</h5>
          <p class="card-subtitle ">Last week</p>
          <p class="text-heading mb-3 mt-1">1.28k</p>
          <div>
            <span class="badge bg-label-danger">-12.2%</span>
          </div>
        </div>
            
          </div>
        </div>
        
        <div class="col-xl-6 col-sm-6">
          <div class="card h-100">
            
            <div class="card-body">
          <div class="badge p-2 bg-label-success mb-3 rounded"><i class="icon-base ti tabler-credit-card icon-28px"></i></div>
          <h5 class="card-title mb-1">Total Sales</h5>
          <p class="card-subtitle ">Last week</p>
          <p class="text-heading mb-3 mt-1">$4,673</p>
          <div>
            <span class="badge bg-label-success">+25.2%</span>
          </div>
        </div>


          </div>
        </div> --}}
        <!--/ Expenses -->

        <!-- Generated Leads -->
        <div class="col-xl-12">
          <div class="card">
              <div class="card-header d-flex justify-content-between">
                  <div class="card-title mb-0">
                    <h5 class="mb-1">Support Tracker</h5>
                    <p class="card-subtitle">Last 7 Days</p>
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1 waves-effect" type="button" id="supportTrackerMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="supportTrackerMenu">
                      <a class="dropdown-item waves-effect" href="javascript:void(0);">View More</a>
                      <a class="dropdown-item waves-effect" href="javascript:void(0);">Delete</a>
                    </div>
                  </div>
                </div>
              <div class="card-body">
                 <div id="monthelyPerformance"></div>
              </div>
          </div>
        </div>
        <!--/ Generated Leads -->
        <!-- Profit last month -->
       <div class="col-xl-6 col-sm-6">
          <div class="flip-card">
            <div class="flip-card-inner">
              
              <!-- FRONT SIDE -->
              <div class="card bg-danger text-white flip-card-front">
                <div class="card-header text-white">Drag me!</div>
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div class="card-title mb-0 text-white">
                    <h5 class="mb-1 me-2 text-white">0.2%</h5>
                    <p class="mb-0">Downtime Ratio</p>
                  </div>
                  <div class="card-icon">
                    <span class="badge bg-label-danger rounded p-2">
                      <i class="icon-base ti tabler-chart-pie-2 icon-26px"></i>
                    </span>
                  </div>
                </div>
              </div>
              
              <!-- BACK SIDE -->
              <div class="card bg-info text-white flip-card-back">
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                  <h5 class="mb-2 text-white">System Info</h5>
                  <p class="mb-0">Downtime decreased by 2% this week 🎯</p>
                </div>
              </div>

            </div>
          </div>
        </div>
        
        <div class="col-xl-6 col-sm-6">
          <div class="card bg-info text-white">
              <div class="card-header text-white">Drag me!</div>
              <div class="card-body d-flex justify-content-between align-items-center">
                <div class="card-title mb-0 text-white">
                  <h5 class="mb-1 me-2 text-white">0.2%</h5>
                  <p class="mb-0">Downtime Ratio</p>
                </div>
                <div class="card-icon">
                  <span class="badge bg-label-danger rounded p-2">
                    <i class="icon-base ti tabler-chart-pie-2 icon-26px"></i>
                  </span>
                </div>
              </div>
            </div>
        </div>
        <!--/ Expenses -->
      </div>





      </div>
      <div class="col-md-6 col-lg-4">
        

        <div class=" d-flex justify-content-between">
        <h5 class="mt-2 text-body-secondary">Body</h5>
        <h6 class="mt-2 text-body-secondary">See all</h6>
        </div>

        <div class="card mb-6">
          <div class="card-body">                  
            <div class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <i class="fis fi fi-us rounded-circle fs-2"></i>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <div class="d-flex align-items-center">
                    <h6 class="mb-0 me-1">$8,567k</h6>
                  </div>
                  <small class="text-body">United states</small>
                </div>
                <div class="user-progress">
                   <div class="badge bg-label-secondary">1.2k Views</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-6">
          <div class="card-body">                  
            <div class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <i class="fis fi fi-br rounded-circle fs-2"></i>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <div class="d-flex align-items-center">
                    <h6 class="mb-0 me-1">$8,567k</h6>
                  </div>
                  <small class="text-body">Brazil</small>
                </div>
                <div class="user-progress">
                   <div class="badge bg-label-secondary">1.2k Views</div>
                </div>
              </div>
            </div>
          </div>
        </div>

         <div class="card mb-6">
          <div class="card-body">                  
            <div class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <i class="fis fi fi-au rounded-circle fs-2"></i>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <div class="d-flex align-items-center">
                    <h6 class="mb-0 me-1">$8,567k</h6>
                  </div>
                  <small class="text-body">Australia</small>
                </div>
                <div class="user-progress">
                   <div class="badge bg-label-secondary">1.2k Views</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">                  
            <div class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-4">
                <i class="fis fi fi-cn rounded-circle fs-2"></i>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <div class="d-flex align-items-center">
                    <h6 class="mb-0 me-1">$8,567k</h6>
                  </div>
                  <small class="text-body">China</small>
                </div>
                <div class="user-progress">
                   <div class="badge bg-label-secondary">1.2k Views</div>
                </div>
              </div>
            </div>
          </div>
        </div>



        
       
      </div>
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
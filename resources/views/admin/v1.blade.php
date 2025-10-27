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
  {{-- <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/ui-carousel.css') }}" /> --}}
  <style>
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
    <!-- Content types -->
    <div class="row mb-12 g-6 align-items-stretch">

      <!-- Website Analytics -->
    <div class="col-xl-9 col">
      <div class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg" id="swiper-with-pagination-cards">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="row">
              <div class="col-12">
                <h5 class="text-white mb-0">Welcome, Abdullah Tanweer 🎉</h5>
                <small>Total 28.5% Conversion Rate</small>
              </div>
              <div class="row">
                <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1 pt-md-9">
                  <h6 class="text-white mt-0 mt-md-3 mb-4">Traffic</h6>
                  <div class="row">
                    <div class="col-6">
                      <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-4 align-items-center">
                          <p class="mb-0 fw-medium me-2 website-analytics-text-bg">28%</p>
                          <p class="mb-0">Teaching</p>
                        </li>
                        <li class="d-flex align-items-center">
                          <p class="mb-0 fw-medium me-2 website-analytics-text-bg">1.2k</p>
                          <p class="mb-0">Research</p>
                        </li>
                      </ul>
                    </div>
                    <div class="col-6">
                      <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-4 align-items-center">
                          <p class="mb-0 fw-medium me-2 website-analytics-text-bg">3.1k</p>
                          <p class="mb-0">Engagement</p>
                        </li>
                        <li class="d-flex align-items-center">
                          <p class="mb-0 fw-medium me-2 website-analytics-text-bg">12%</p>
                          <p class="mb-0">Character Virtue</p>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                  <img src="{{ asset('admin/assets/img/illustrations/card-website-analytics-1.png') }}" alt="Website Analytics" height="150" class="card-website-analytics-img" />
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="row">
              <div class="col-12">
                <h5 class="text-white mb-0">Welcome, Abdullah Tanweer 🎉</h5>
                <small>Total 28.5% Conversion Rate</small>
              </div>
              <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1 pt-md-9">
                <h6 class="text-white mt-0 mt-md-3 mb-4">Spending</h6>
                <div class="row">
                  <div class="col-6">
                    <ul class="list-unstyled mb-0">
                      <li class="d-flex mb-4 align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">12h</p>
                        <p class="mb-0">Teaching</p>
                      </li>
                      <li class="d-flex align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">127</p>
                        <p class="mb-0">Research</p>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <ul class="list-unstyled mb-0">
                      <li class="d-flex mb-4 align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">18</p>
                        <p class="mb-0">Engagement</p>
                      </li>
                      <li class="d-flex align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">2.3k</p>
                        <p class="mb-0">Character Virtue</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                <img src="{{ asset('admin/assets/img/illustrations/card-website-analytics-2.png') }}" alt="Website Analytics" height="150" class="card-website-analytics-img" />
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="row">
              <div class="col-12">
                <h5 class="text-white mb-0">Welcome, Abdullah Tanweer 🎉</h5>
                <small>Total 28.5% Conversion Rate</small>
              </div>
              <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1 pt-md-9">
                <h6 class="text-white mt-0 mt-md-3 mb-4">Revenue Sources</h6>
                <div class="row">
                  <div class="col-6">
                    <ul class="list-unstyled mb-0">
                      <li class="d-flex mb-4 align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">268</p>
                        <p class="mb-0">Teaching</p>
                      </li>
                      <li class="d-flex align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">62</p>
                        <p class="mb-0">Research</p>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <ul class="list-unstyled mb-0">
                      <li class="d-flex mb-4 align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">890</p>
                        <p class="mb-0">Engagement</p>
                      </li>
                      <li class="d-flex align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">1.2k</p>
                        <p class="mb-0">Character Virtue</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                <img src="{{ asset('admin/assets/img/illustrations/card-website-analytics-3.png') }}" alt="Website Analytics" height="150" class="card-website-analytics-img" />
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
    <!--/ Website Analytics -->


    <!-- Sales Overview -->
    {{-- <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <p class="mb-0 text-body">Welcome, Abdullah Tanweer 🎉</p>
          </div>
          <h4 class="card-title mb-1">62.2%</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-4">
              <div class="d-flex gap-2 align-items-center mb-2">
                <span class="badge bg-label-info p-1 rounded"><i class="icon-base ti tabler-shopping-cart icon-sm"></i></span>
                <p class="mb-0">New</p>
              </div>
              <h5 class="mb-0 pt-1">62.2%</h5>
              <small class="text-body-secondary">2026</small>
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
                <p class="mb-0">Old</p>
                <span class="badge bg-label-primary p-1 rounded"><i class="icon-base ti tabler-link icon-sm"></i></span>
              </div>
              <h5 class="mb-0 pt-1">25.5%</h5>
              <small class="text-body-secondary">2025</small>
            </div>
          </div>
          <div class="d-flex align-items-center mt-6">
            <div class="progress w-100" style="height: 10px;">
              <div class="progress-bar bg-info" style="width: 70%" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
              <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
    <!--/ Sales Overview -->
    <!-- Sales Overview -->
    <div class="col-xl-3 col-sm-6 d-flex flex-column">
       <div class="row g-6 flex-fill">
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
          <div class="card h-100" style="box-shadow: none;">
              <div class="card-header text-center">
                  <div class="card-title mb-0">
                    <h5 class="mb-1">Welcome, Abdullah Tanweer 🎉</h5>
                    <p class="card-subtitle">Your current performance is</p>
                    
                  </div>
                </div>
          </div>
        </div>
        <!--/ Generated Leads -->
        <!-- Profit last month -->
        <div class="col-xl-6 col-sm-6">
            <div class="card h-100">
              
              <div class="card-body d-flex justify-content-center align-items-center">
                  <h5 class="mb-1 me-2 text-center">82%</h5>
                
                
              </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-sm-6">
          <div class="card h-100">
              <div class="card-body d-flex justify-content-center align-items-center">
                  <h5 class="mb-1 me-2 text-center">81%</h5>
                
               
              </div>
            </div>
        </div>
        <!--/ Expenses -->
      </div>
    </div>
    <!--/ Sales Overview -->

      <div class="col-md-6 col-lg-4">
        <div class=" d-flex justify-content-between">
        <h5 class="mt-2 text-body-secondary">Body</h5>
        <h6 class="mt-2 text-body-secondary">See all</h6>
        </div>

        <div class="card mb-6 animated-card-zoom-in">
        <div class="card-body">                  
          <div class="d-flex align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="icon-base ti tabler-video icon-lg"></i>
              </span>
            </div>
            <div class="row w-100 align-items-center">
              <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                <h6 class="mb-0">example two Basic Design Course</h6>
              </div>
              <div class="col-sm-4 col-lg-12 col-xxl-4 d-flex justify-content-xxl-end">
                <div class="badge bg-label-secondary">1.2k Views</div>
              </div>
            </div>
          </div>
        </div>
      </div>


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

      <!-- Website Analytics -->
    <div class="col-xl-4 col">
       <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Carrier Comparison</h5>
                    
                  </div>
                  <div class="card-body">
                    <div id="carrierPerformance"></div>
                  </div>
                </div>
    </div>
    <!--/ Website Analytics -->

    <!-- Average Daily Sales -->
    <div class="col-xl-4 col-sm-6">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h5 class="mb-3 card-title">Average Daily Sales</h5>
        </div>
        <div class="card-body px-0">
          <div id="deliveryExceptionsChart"></div>
        </div>
      </div>
    </div>
    <!--/ Average Daily Sales -->
    <!-- Website Analytics -->
    <div class="col-xl-4 col">
       <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Carrier Comparison</h5>
                    
                  </div>
                  <div class="card-body">
                    <div id="carrierPerformance1"></div>
                  </div>
                </div>
    </div>
    <!--/ Website Analytics -->
    <!-- 3D cube effect -->
    {{-- <div class="col-md-6">
      <h6 class="text-body-secondary mt-4">3D cube effect</h6>
      <div class="swiper" id="swiper-3d-cube-effect">
        <div class="swiper-wrapper">
          <div class="swiper-slide" style="background-image:url(https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/elements/47.png">Teaching and Learning (T&L)</div>
          <div class="swiper-slide" style="background-image:url(https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/elements/47.png)">Research, Innovation and Commercialisation (RIC)</div>
          <div class="swiper-slide" style="background-image:url(https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/elements/48.png)">Institutional Engagement (IE)</div>
          <div class="swiper-slide" style="background-color:red">Character Virtue (CV)</div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div> --}}





    </div>
    <!--/ Content types -->
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
  {{-- <script src="{{ asset('admin/assets/js/ui-carousel.js') }}"></script> --}}
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
document.addEventListener("DOMContentLoaded", function () {
            try {

               var chartLabels = [
        "Teaching and Learning",
        "Research, Innovation and Commercialisation",
        "Institutional Engagement",
        "Character Virtue"
      ];
      var shortLabels = ["T&L", "RIC", "IE", "CV"];

                // ✅ Static dataset values (adjusts automatically to match labels)
                const staticValues = [70, 90, 85, 80];
                const dataset1 = shortLabels.map((_, i) => staticValues[i % staticValues.length]);

                const g = document.getElementById("radarChart");
                if (!g || !chartLabels.length) return;

                const ctx = g.getContext("2d");

                // 🎨 Dynamic label colors
                const labelColors = [
                    "#e74c3c", "#3498db", "#27ae60", "#f39c12",
                    "#9b59b6", "#16a085", "#d35400", "#2c3e50"
                ];

                const gradient = ctx.createLinearGradient(0, 0, 0, 150);
                gradient.addColorStop(0, "rgba(115,103,240,0.9)");
                gradient.addColorStop(1, "rgba(85,85,255,0.8)");

                const radarChart = new Chart(ctx, {
                    type: "radar",
                    data: {
                        labels: shortLabels,
                        datasets: [
                            {
                                label: "Achievements",
                                data: dataset1,
                                fill: true,
                                backgroundColor: gradient,
                                borderColor: "rgba(85,85,255,1)",
                                pointBorderColor: labelColors.slice(0, shortLabels.length),
                                pointBackgroundColor: labelColors.slice(0, shortLabels.length),
                                pointRadius: 5,
                                pointHoverRadius: 8,
                                pointStyle: "circle"
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 600 },
                        scales: {
                            r: {
                                min: 50, // ✅ Show full scale
                                max: 100,
                                ticks: {
                                    display: true, // ✅ Show 60,70,80,90,100
                                    stepSize: 10,
                                    color: "#666",
                                    backdropColor: "transparent",
                                    font: { size: 10 }
                                },
                                grid: { color: "#ddd" },
                                angleLines: { color: "#ddd" },
                                pointLabels: {
                                    font: { size: 11 },
                                    color: (ctx) => labelColors[ctx.index % labelColors.length],
                                    callback: (label, i) => shortLabels[i] || label
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: "#fff",
                                titleColor: "#000",
                                bodyColor: "#333",
                                borderWidth: 1,
                                borderColor: "#ddd",
                                callbacks: {
                                    title: (context) => chartLabels[context[0].dataIndex]
                                }
                            }
                        }
                    }
                });

                // ✅ Custom Legend
                const legendDiv = document.getElementById("customLegend");
                if (legendDiv) {
                    legendDiv.innerHTML = ""; // Clear old legend if any
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
                }
            } catch (error) {
                console.error("Radar chart initialization error:", error);
            }

        });
        document.addEventListener("DOMContentLoaded", function () {
      const c = document.querySelector("#monthelyPerformance");

      const options = {
        chart: {
          type: 'area',
          height: 130,
          toolbar: { show: false },
        },
        series: [
          {
            name: 'Performance',
            data: [10, 15, 20, 25, 30, 35, 40]
          }
        ],
        xaxis: {
          categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
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
        }
      };

      const chart = new ApexCharts(c, options);
      chart.render();
    });
   document.addEventListener("DOMContentLoaded", function () {
  const c = document.querySelector("#carrierPerformance1");

  const options = {
    chart: {
      type: 'area',
      toolbar: { show: false },
    },
    series: [
      {
        name: 'Performance',
        data: [10, 15, 20, 25, 30, 35, 40]
      }
    ],
    xaxis: {
      categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
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
    </script>
@endpush
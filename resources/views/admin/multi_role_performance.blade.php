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
.hover-card {
  transition: all 0.3s ease;
}

.hover-card:hover {
  background-color: #ffeaea; /* light red background */
  transform: translateY(-4px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

/* Optional: change progress bar or badge color on hover */
.hover-card:hover .progress-bar {
  background-color: #ff4d4d !important;
}

.hover-card:hover .badge {
  background-color: #ff4d4d !important;
  color: white;
}
  </style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
       <!-- Support Tracker -->
    <div class="col-12 col-md-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1">AS Hod</h5>
          </div>

        </div>
        <div class="card-body row">
          <div class="col-12 col-sm-4">
            <div class="mt-lg-4 mt-lg-2 mb-lg-6 mb-2">
              <h2 class="mb-0">161</h2>
              <p class="mb-0">Score</p>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                <div class="badge rounded bg-label-primary p-1_5"><i class="icon-base ti tabler-ticket icon-md"></i></div>
                <div>
                  <h6 class="mb-0 text-nowrap">New Tickets</h6>
                  <small class="text-body-secondary">142</small>
                </div>
              </li>
              <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                <div class="badge rounded bg-label-info p-1_5"><i class="icon-base ti tabler-circle-check icon-md"></i></div>
                <div>
                  <h6 class="mb-0 text-nowrap">Open Tickets</h6>
                  <small class="text-body-secondary">28</small>
                </div>
              </li>
              <li class="d-flex gap-4 align-items-center pb-1">
                <div class="badge rounded bg-label-warning p-1_5"><i class="icon-base ti tabler-clock icon-md"></i></div>
                <div>
                  <h6 class="mb-0 text-nowrap">Response Time</h6>
                  <small class="text-body-secondary">1 Day</small>
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
     <!-- Support Tracker -->
    <div class="col-12 col-md-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1">AS Teacher</h5>
          </div>

        </div>
        <div class="card-body row">
          <div class="col-12 col-sm-4">
            <div class="mt-lg-4 mt-lg-2 mb-lg-6 mb-2">
              <h2 class="mb-0">120</h2>
              <p class="mb-0">Score</p>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                <div class="badge rounded bg-label-primary p-1_5"><i class="icon-base ti tabler-ticket icon-md"></i></div>
                <div>
                  <h6 class="mb-0 text-nowrap">New Tickets</h6>
                  <small class="text-body-secondary">142</small>
                </div>
              </li>
              <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                <div class="badge rounded bg-label-info p-1_5"><i class="icon-base ti tabler-circle-check icon-md"></i></div>
                <div>
                  <h6 class="mb-0 text-nowrap">Open Tickets</h6>
                  <small class="text-body-secondary">28</small>
                </div>
              </li>
              <li class="d-flex gap-4 align-items-center pb-1">
                <div class="badge rounded bg-label-warning p-1_5"><i class="icon-base ti tabler-clock icon-md"></i></div>
                <div>
                  <h6 class="mb-0 text-nowrap">Response Time</h6>
                  <small class="text-body-secondary">1 Day</small>
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

  <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
@endpush
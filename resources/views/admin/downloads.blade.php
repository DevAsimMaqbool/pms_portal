@extends('layouts.app')

@push('style')
  <style>
    /* Flip Card Base */
    .flip-card {
      position: relative;
      width: 100%;
      aspect-ratio: 4 / 3;
      perspective: 1000px;
    }

    .flip-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.6s;
      transform-style: preserve-3d;
    }

    .flip-card:hover .flip-card-inner {
      transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
      position: absolute;
      inset: 0;
      backface-visibility: hidden;
      border-radius: 0.75rem;
      overflow: hidden;
    }

    .flip-card-front .card,
    .flip-card-back .card {
      height: 100%;
      border: none;
    }

    .flip-card-back {
      transform: rotateY(180deg);
    }

    .icon-base {
      font-size: 2rem;
    }

    .flip-card-front .card-body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .flip-card-back .card-body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
  </style>
@endpush

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-4">
      <div class="col-lg-2 col-md-4">
        <a href="#" class="text-decoration-none">
          <div class="flip-card">
            <div class="flip-card-inner">

              <!-- FRONT -->
              <div class="flip-card-front">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <div class="avatar mb-3">
                      <span class="avatar-initial rounded bg-white text-primary">
                        <i class="ti tabler-download icon-base"></i>
                      </span>
                    </div>
                    <h5 class="fw-bold mb-0 text-white">SOPs</h5>
                  </div>
                </div>
              </div>

              <!-- BACK -->
              <div class="flip-card-back">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <div class="badge rounded p-2 mb-2 bg-white text-primary">
                      <i class="ti tabler-download icon-base"></i>
                    </div>
                    <h6 class="text-center mb-2 text-white">Click to Download</h6>
                    <p class="text-center fs-13 mb-0">PMS SOPs.
                    </p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-2 col-md-4">
        <a href="#" class="text-decoration-none">
          <div class="flip-card">
            <div class="flip-card-inner">

              <!-- FRONT -->
              <div class="flip-card-front">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <div class="avatar mb-3">
                      <span class="avatar-initial rounded bg-white text-primary">
                        <i class="ti tabler-download icon-base"></i>
                      </span>
                    </div>
                    <h5 class="fw-bold mb-0 text-white">Privacy Policy</h5>
                  </div>
                </div>
              </div>

              <!-- BACK -->
              <div class="flip-card-back">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <div class="badge rounded p-2 mb-2 bg-white text-primary">
                      <i class="ti tabler-download icon-base"></i>
                    </div>
                    <h6 class="text-center mb-2 text-white">Click to Download</h6>
                    <p class="text-center fs-13 mb-0">PMS Privacy Policy.
                    </p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
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

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  </script>

@endpush
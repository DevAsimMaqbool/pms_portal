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
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Accordion1 -->
    <div class="row gy-6 fade-section">

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
                    <span class="bg-label-success text-cut-department">
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
          <!--/ Expenses -->
        </div>
      </div>
      <!--/ Sales Overview -->

      <!-- Website Analytics -->
      <div class="col-lg-9 col-md-12">

      </div>

      <!--/ Website Analytics -->

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
  <script src="{{ asset('admin/assets/js/charts-apex.js') }}"></script>

@endpush
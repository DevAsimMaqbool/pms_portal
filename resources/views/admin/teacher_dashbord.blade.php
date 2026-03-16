@extends('layouts.app')
@push('style')
  <style>
    .bg-orange,
    .bg-label-orange {
      background-color: #fd7e1459 !important;
      color: #fd7e14 !important
    }

    .card-border-shadow-orange {
      --bs-card-border-bottom-color: #FFF200 !important
    }

    .h-50vh {
      height: 100vh;
    }

    @media (min-width: 992px) {
      .h-lg-100vh {
        height: 500px;
      }
    }

    @media (min-width: 1401px) {
      .h-md-70vh {
        height: 500px;
      }
    }

    #customLegend {
      text-align: center;
      margin-top: 8px;
      padding: 0;
    }

    #customLegend ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: inline-flex;
      gap: 12px;
      /* ✅ reduce spacing */
    }

    #customLegend li {
      font-size: 12px;
      /* ✅ small font */
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    #customLegend .legend-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      display: inline-block;
    }
  </style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Accordion1 -->
    <div class="row gy-6">
      <!-- View sales -->
      <div class="col-xl-4">

      </div>
    </div>
    <!-- / include indicator modal -->
  </div>
  <!-- / Content -->
@endsection
@push('script')
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
  <script src="{{ asset('admin/assets/js/extended-ui-perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/js/cards-advance.js') }}"></script>
@endpush
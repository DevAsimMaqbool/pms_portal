@extends('layouts.app')
@push('style')
     <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl container-p-y">
        
        <div class="misc-wrapper">
      <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">404</h1>
      <h4 class="mb-2 mx-2">Form Not Found️ ⚠️</h4>
      <p class="mb-6 mx-2">we couldn't find the form you are looking for</p>
      <div class="mt-4">
        <img src="{{ asset('admin/assets/img/illustrations/page-misc-error.png') }}" alt="page-misc-error-light" width="225" class="img-fluid" />
      </div>
    </div>
    </div>
    <!-- / Content -->
@endsection

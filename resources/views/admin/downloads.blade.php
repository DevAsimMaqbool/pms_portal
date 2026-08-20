@extends('layouts.app')

@push('style')
 
@endpush

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
        <div class="col-lg-12">
              <div class="card">
                <h5 class="card-header">Policies & SOPs (Download) </h5>
                   <div class="card-body">
                        

                    <div class="row">
                        <!-- Basic List group -->
                          <div class="col-lg-6 mb-6 mb-xl-0">
                            <small class="fw-medium">PMS SOPs</small>
                            <div class="demo-inline-spacing mt-4">
                              <div class="list-group">
                                @foreach($policies->where('sop_name', 'SOP') as $policy)
                                    <a href="{{ Storage::url($policy->sop_file) }}"
                                      target="_blank"
                                      class="list-group-item d-flex justify-content-between align-items-center text-primary">
                                        {{ $policy->description }}
                                        <i class="icon-base ti tabler-cloud-download"></i>

                                    </a>
                                @endforeach
                              </div>
                            </div>
                          </div>

                          <!-- Basic List group -->
                          <div class="col-lg-6 mb-6 mb-xl-0">
                            <small class="fw-medium">PMS Policy</small>
                            <div class="demo-inline-spacing mt-4">
                              <div class="list-group">
                                 @foreach($policies->where('sop_name', 'POLICY') as $policy)
                                    <a href="{{ Storage::url($policy->sop_file) }}"
                                      target="_blank"
                                      class="list-group-item d-flex justify-content-between align-items-center text-primary">
                                        {{ $policy->description }}
                                         <i class="icon-base ti tabler-cloud-download"></i>

                                    </a>
                                @endforeach
                              </div>
                            </div>
                          </div>
                    
                    </div>


                   </div>
              </div>  
           
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
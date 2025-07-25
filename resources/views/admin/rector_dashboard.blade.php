@extends('layouts.app')
@push('style')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/app-logistics-dashboard.css') }}" />
@endpush
@section('content')
   <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
           <div class="row g-6 mb-6">
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
        </div>
   <!-- / Content -->
@endsection
@push('script')
<script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
<script src="{{ asset('admin/assets/js/cards-statistics.js') }}"></script>
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

</script>
@endpush


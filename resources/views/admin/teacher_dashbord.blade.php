@extends('layouts.app')
@push('style')
  <style>
    .h-50vh {
      height: 100vh;
    }

    @media (min-width: 992px) {
      .h-lg-100vh {
        height: 400px;
      }
    }

    @media (min-width: 1401px) {
      .h-md-70vh {
        height: 460px;
      }
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
            <h5 class="card-title m-0 me-2 pt-1 mb-2 d-flex align-items-center"><i
                class="icon-base ti tabler-list-details me-3"></i>Indicator</h5>
          </div>
          <div class="card-body" id="vertical-example">
            <ul class="p-0 m-0">
              @php
                $result = getRoleAssignments(Auth::user()->getRoleNames()->first());
                $colors = ['primary', 'success', 'danger', 'warning', 'info'];
                $series = [20, 90, 40, 80, 30];
                $index = 0;
              @endphp
              @foreach($result as $kpa)
                @foreach($kpa['category'] as $category)
                  @foreach(array_slice($category['indicator']->toArray(), 0, 10) as $indicator)
                      @php
                         $color = $colors[$index % count($colors)];
                         $seriesValue = $series[$index % count($series)];
                      @endphp
                    <li class="d-flex mb-6">
                      <div class="chart-progress me-4" data-color="{{ $color }}" data-series="{{ $seriesValue }}" data-progress_variant="true"></div>
                      <div class="row w-100 align-items-center">
                        <div class="col-9">
                          <div class="me-2">
                            <h6 class="mb-1_5">{{ $indicator['indicator'] }}</h6>
                          </div>
                        </div>
                        <div class="col-3 text-end">
                          <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button"
                            data-bs-toggle="modal" data-bs-target="#{{ str_replace(' ', '', $indicator['indicator']) }}">
                            <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    @php $index++; @endphp
                  @endforeach
                @endforeach
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <!--/ Vertical Scrollbar -->
      <!-- chart overview -->
      <div class="col-12 col-12 col-lg-8" id="targetDivchart">
        <div class="card h-50vh h-md-70vh h-lg-100vh">
          <div class="card-header d-flex justify-content-between">
            <h5 class="card-title m-0 me-2 pt-1 mb-2 d-flex align-items-center"><i
                class="icon-base ti tabler-chart-pie me-3"></i>Overall KPA Performance</h5>
            <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio2" id="dailyRadio2" checked>
            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio2">Fall 2025</label>

            <input type="radio" class="btn-check" name="btnradio2" id="monthlyRadio2">
            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio2">Fall 2026</label>
          </div>
          </div>
          <div class="card-body pt-0">
            <div class="row">
              <div class="col-md-8">
                <canvas class="chartjs" id="radarChart"></canvas>
              </div>
              <div class="col-md-4">
                <ul id="fullLabelsList" class="list-unstyled mt-3" style="font-size:12px"></ul>
              </div>
            </div>
            {{-- <div><span>Teaching and Learning</span></div> --}}
            <!-- if schrool -->
            {{-- <div style="overflow-x: auto; overflow-y: hidden; width: 100%;">
              <div id="carrierPerformances"></div>
            </div> --}}

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
          @php
            $result = getRoleAssignments(Auth::user()->getRoleNames()->first());
            $colors1 = ['primary', 'success', 'danger', 'warning', 'info'];
            $colors2 = ['#0d6efd', '#198754', '#dc3545', '#ffc107', '#0dcaf0'];
            $series1 = [20, 90, 40, 80, 30];
            $index1 = 0;
          @endphp
            @foreach($result as $kpakey => $kpa)
                @php
                    $targetId = strtolower(str_replace(' ', '-', $kpa['performance_area']));
                @endphp
              <div class="accordion-item" id="{{ $targetId }}">
                <h2 class="accordion-header" id="heading-{{ $kpa['id'] }}">
                  <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                    data-bs-target="#accordion-{{ $kpa['id'] }}" aria-expanded="false"
                    aria-controls="accordion-{{ $kpa['id'] }}">
                    <i class="icon-base ti tabler-star me-2"></i>
                    {{ $kpa['performance_area'] }} {{-- ✅ KPA Name --}}
                  </button>
                </h2>

                <div id="accordion-{{ $kpa['id'] }}" class="accordion-collapse collapse"
                  aria-labelledby="heading-{{ $kpa['id'] }}" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <!-- Loop through Categories -->
                    <div class="row g-6 pt-2">
                      @foreach($kpa['category'] as $category)
                        @php
                              $color1 = $colors1[$index1 % count($colors1)];
                              $color2 = $colors2[$index1 % count($colors2)];
                              $seriesValue1 = $series1[$index1 % count($series1)];
                          @endphp
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xl-3 col-xxl-2">
                          <a href="{{ route('kpa.report', ['id' => $kpa['id']]) }}" class="text-decoration-none">
                            <div class="card card-border-shadow-{{ $color1 }} h-100">
                              <div class="card-header pb-2">
                                <h5 class="card-title mb-1">82.5k</h5>
                                <p class="card-subtitle">Expenses</p>
                              </div>
                              <div class="card-body">
                                <div class="expensesChart" data-color="{{ $color2 }}" data-series="{{ $seriesValue1 }}"></div>
                                <div class="mt-3 text-center">
                                  <small class="text-body-secondary mt-3">
                                    {{ $category['indicator_category'] }} {{-- ✅ Category Name --}}
                                  </small>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
                        @php $index1++; @endphp
                      @endforeach
                    </div>

                    <!-- ✅ Scroll Button -->
                    <div class="text-end mt-3">
                      <button class="btn rounded-pill btn-icon btn-outline-primary waves-effect scrollBtn"
                        title="move to top chart">
                        <span class="icon-base ti tabler-arrow-up icon-22px"></span>
                      </button>
                    </div>

                  </div>
                </div>
              </div>
            @endforeach


        </div>
      </div>
    </div>
    <!--/ Accordion -->
    <!-- <div class="row g-6 mb-6 mt-6">-->
    <!-- Card Border Shadow -->
    {{-- @foreach($KeyPerformanceArea as $kfa) --}}
    {{-- <div class="col-lg-2 col-6">
      <div class="card card-border-shadow-primary h-100 kfa-card" data-id="{{ $kfa->id }}">
        <div class="card-body text-center">
          <div class="badge rounded p-2 bg-label-primary mb-2">
            <i class="icon-base ti tabler-chart-pie-2 icon-lg"></i>
          </div>
          <p class="mb-0">{{ $kfa->performance_area }}</p>
        </div>
      </div>
    </div> --}}
    {{-- @endforeach --}}
    <!-- </div>-->
    {{-- <h5 class="pb-1" id="indicator-category-cards-title"></h5>
    <div class="row g-6 mb-4" id="indicator-category-cards"></div>
    <h5 class="pb-1" id="indicator-cards-title"></h5>
    <div class="row g-6 mb-4" id="indicator-results"></div> --}}
    <div class="row g-6">
      <!--/ Card Border Shadow -->
      <!-- Vehicles overview -->
      {{-- <div class="col-xxl-6">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h5 class="m-0 me-2">Vehicles Overview</h5>
            </div>
            <div class="dropdown">
              <button class="btn btn-text-secondary rounded-pill p-2 border-0 me-n1" type="button" id="vehiclesOverview"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <div class="vehicles-overview-progress progress rounded-3 mb-3 bg-transparent overflow-hidden"
              style="height: 46px;">
              <div class="progress-bar fw-medium text-start shadow-none bg-lighter text-heading px-4 rounded-0"
                role="progressbar" style="width: 39.7%" aria-valuenow="39.7" aria-valuemin="0" aria-valuemax="100">39.7%
              </div>
              <div class="progress-bar fw-medium text-start shadow-none bg-primary px-4" role="progressbar"
                style="width: 28.3%" aria-valuenow="28.3" aria-valuemin="0" aria-valuemax="100">28.3%</div>
              <div class="progress-bar fw-medium text-start shadow-none text-bg-info px-2 px-sm-4" role="progressbar"
                style="width: 17.4%" aria-valuenow="17.4" aria-valuemin="0" aria-valuemax="100">17.4%</div>
              <div
                class="progress-bar fw-medium text-start shadow-none snackbar text-paper px-1 px-sm-3 rounded-0 px-lg-4"
                role="progressbar" style="width: 14.6%" aria-valuenow="14.6" aria-valuemin="0" aria-valuemax="100">14.6%
              </div>
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
      </div> --}}
      <!--/ Vehicles overview -->

      <!-- Shipment statistics-->
      {{-- <div class="col-xxl-6 col-lg-7">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h5 class="mb-1">Shipment statistics</h5>
              <p class="card-subtitle">Total number of deliveries 23.8k</p>
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-label-primary">January</button>
              <button type="button" class="btn btn-label-primary dropdown-toggle dropdown-toggle-split"
                data-bs-toggle="dropdown" aria-expanded="false">
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
      </div> --}}
      <!--/ Shipment statistics -->

      <!-- Delivery Performance -->
      {{-- <div class="col-xxl-4 col-lg-5">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
              <h5 class="mb-1 me-2">Delivery Performance</h5>
              <p class="card-subtitle">12% increase in this month</p>
            </div>
            <div class="dropdown">
              <button class="btn btn-text-secondary rounded-pill p-2 me-n1" type="button" id="deliveryPerformance"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                  <span class="avatar-initial rounded bg-label-primary"><i
                      class="icon-base ti tabler-package icon-26px"></i></span>
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
                  <span class="avatar-initial rounded bg-label-info"><i
                      class="icon-base ti tabler-truck icon-28px"></i></span>
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
                  <span class="avatar-initial rounded bg-label-success"><i
                      class="icon-base ti tabler-circle-check icon-26px"></i></span>
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
                  <span class="avatar-initial rounded bg-label-warning"><i
                      class="icon-base ti tabler-percentage icon-26px"></i></span>
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
                  <span class="avatar-initial rounded bg-label-secondary"><i
                      class="icon-base ti tabler-clock icon-26px"></i></span>
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
                  <span class="avatar-initial rounded bg-label-danger"><i
                      class="icon-base ti tabler-users icon-26px"></i></span>
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
      </div> --}}
      <!--/ Delivery Performance -->

      <!-- Reasons for delivery exceptions -->
      {{-- <div class="col-xxl-4 col-lg-6">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h5 class="m-0 me-2">Reasons for delivery exceptions</h5>
            </div>
            <div class="dropdown">
              <button class="btn btn-text-secondary rounded-pill  p-2 me-n1" type="button" id="deliveryExceptions"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
      </div> --}}
      <!--/ Reasons for delivery exceptions -->

      <!-- Orders by Countries -->
      {{-- <div class="col-xxl-4 col-lg-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
              <h5 class="mb-1">Orders by Countries</h5>
              <p class="card-subtitle">62 deliveries in progress</p>
            </div>
            <div class="dropdown">
              <button class="btn btn-text-secondary rounded-pill  p-2 me-n1" type="button" id="ordersCountries"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                    aria-selected="true">New</button>
                </li>
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-justified-link-preparing" aria-controls="navs-justified-link-preparing"
                    aria-selected="false">Preparing</button>
                </li>
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-justified-link-shipping" aria-controls="navs-justified-link-shipping"
                    aria-selected="false">Shipping</button>
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
      </div> --}}
      <!--/ Orders by Countries -->


    </div>


    <!-- Payment Methods modal -->
    <div class="modal fade" id="paymentMethods" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-6">
              <h4 class="mb-2">Departments</h4>
            </div>


            <!-- Source Visit -->

            <ul class="list-unstyled mb-0">
              <li class="mb-4">
                <div class="d-flex align-items-center">
                  <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
                      class="icon-base ti tabler-shadow icon-md"></i></div>
                  <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Computer Science</h6>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="ms-4 badge bg-label-success">4%</div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="mb-4">
                <div class="d-flex align-items-center">
                  <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
                      class="icon-base ti tabler-globe icon-md"></i></div>
                  <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Information Technology</h6>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="ms-4 badge bg-label-success">3%</div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="mb-4">
                <div class="d-flex align-items-center">
                  <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
                      class="icon-base ti tabler-mail icon-md"></i></div>
                  <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Software Engineering</h6>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="ms-4 badge bg-label-success">3%</div>
                    </div>
                  </div>
                </div>
              </li>


            </ul>

            <!--/ Source Visit -->

          </div>
        </div>
      </div>
    </div>
    <!-- / Payment Methods modal -->
    <!-- Payment Methods modal -->
    <div class="modal fade" id="paymentMethodsFD" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-6">
              <h4 class="mb-2">Departments Wise Performance</h4>
            </div>


            <!-- Source Visit -->

            <ul class="list-unstyled mb-0">

              <li class="mb-4 d-flex">
                <div class="d-flex w-50 align-items-center me-4">
                  <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
                      class="icon-base ti tabler-list-check icon-md"></i></div>
                  <div>
                    <h6 class="mb-0">Computer Science</h6>
                  </div>
                </div>
                <div class="d-flex flex-grow-1 align-items-center">
                  <div class="progress w-100 me-4" style="height:8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 4%" aria-valuenow="4"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="text-body-secondary">4%</span>
                </div>
              </li>
              <li class="mb-4 d-flex">
                <div class="d-flex w-50 align-items-center me-4">
                  <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
                      class="icon-base ti tabler-list-check icon-md"></i></div>
                  <div>
                    <h6 class="mb-0">Information Technology</h6>
                  </div>
                </div>
                <div class="d-flex flex-grow-1 align-items-center">
                  <div class="progress w-100 me-4" style="height:8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 3%" aria-valuenow="86"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="text-body-secondary">3%</span>
                </div>
              </li>
              <li class="mb-4 d-flex">
                <div class="d-flex w-50 align-items-center me-4">
                  <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i
                      class="icon-base ti tabler-list-check icon-md"></i></div>
                  <div>
                    <h6 class="mb-0">Software Engineering</h6>
                  </div>
                </div>
                <div class="d-flex flex-grow-1 align-items-center">
                  <div class="progress w-100 me-4" style="height:8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 3%" aria-valuenow="3"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="text-body-secondary">3%</span>
                </div>
              </li>


            </ul>

            <!--/ Source Visit -->

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
              <h4 class="mb-2">Faculty-Wise Employability</h4>
            </div>
            <!-- ffffff-->
            <div class="card h-100">

              <div class="card-body row g-3">
                <div class="col-md-8">
                  <div id="horizontalBarCharts"></div>
                </div>
                <div class="col-md-4 d-flex justify-content-around align-items-center">
                  <div>
                    <div class="d-flex align-items-baseline">
                      <span class="text-primary me-2"><i class="icon-base ti tabler-circle-filled icon-12px"></i></span>
                      <div>
                        <p class="mb-0" role="button" data-bs-toggle="modal" data-bs-target="#paymentMethodsFD">FASH</p>
                        <h5>45%</h5>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline my-6">
                      <span class="text-info me-2"><i class="icon-base ti tabler-circle-filled icon-12px"></i></span>
                      <div>
                        <p class="mb-0" role="button" data-bs-toggle="modal" data-bs-target="#paymentMethodsFD">FAD</p>
                        <h5>40%</h5>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <span class="text-success me-2"><i class="icon-base ti tabler-circle-filled icon-12px"></i></span>
                      <div>
                        <p class="mb-0" role="button" data-bs-toggle="modal" data-bs-target="#paymentMethodsFD">FBMS</p>
                        <h5>35%</h5>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline my-6">
                      <span class="text-primary me-2"><i class="icon-base ti tabler-circle-filled icon-12px"></i></span>
                      <div>
                        <p class="mb-0" role="button" data-bs-toggle="modal" data-bs-target="#paymentMethodsFD">FPH</p>
                        <h5>15%</h5>
                      </div>
                    </div>
                  </div>

                  <div>
                    <div class="d-flex align-items-baseline">
                      <span class="text-secondary me-2"><i class="icon-base ti tabler-circle-filled icon-12px"></i></span>
                      <div>
                        <p class="mb-0" role="button" data-bs-toggle="modal" data-bs-target="#paymentMethodsFD">FET</p>
                        <h5>30%</h5>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline my-6">
                      <span class="text-danger me-2"><i class="icon-base ti tabler-circle-filled icon-12px"></i></span>
                      <div>
                        <p class="mb-0" role="button" data-bs-toggle="modal" data-bs-target="#paymentMethodsFD">FSS</p>
                        <h5>25%</h5>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <span class="text-warning me-2"><i class="icon-base ti tabler-circle-filled icon-12px"></i></span>
                      <div>
                        <p class="mb-0" role="button" data-bs-toggle="modal" data-bs-target="#paymentMethodsFD">FEC</p>
                        <h5>20%</h5>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline my-6">
                      <span class="text-info me-2"><i class="icon-base ti tabler-circle-filled icon-12px"></i></span>
                      <div>
                        <p class="mb-0" role="button" data-bs-toggle="modal" data-bs-target="#paymentMethodsFD">FCSIT</p>
                        <h5>10%</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/fffff-->
          </div>
        </div>
      </div>
    </div>
    <!-- / Payment Methods modal -->
    <!-- Payment Methods modal -->
    <div class="modal fade" id="paymentMethodsDepartment" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-6">
              <h4 class="mb-2">Departments</h4>
            </div>

            <div style="overflow-x: auto; overflow-y: hidden; width: 100%;">
              <div id="carrierPerformances"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / Payment Methods modal -->
    <!--  Payment Methods modal -->
    <!--table model-->
    <!-- Payment Methods modal -->
    <div class="modal fade" id="tableModel" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <!-- ffffff-->
            <div class="nav-align-top nav-tabs-shadow">
              <div class="d-flex overflow-auto">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                      data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                      House Ranking
                    </button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                      data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                      aria-selected="false">
                      Best Department Ranking
                    </button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                      data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                      aria-selected="false">
                      Best Faculty Member
                    </button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                      data-bs-target="#navs-justified-messages1" aria-controls="navs-justified-messages1"
                      aria-selected="false">
                      Virtues wise ranking
                    </button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                      data-bs-target="#navs-justified-messages2" aria-controls="navs-justified-messages2"
                      aria-selected="false">
                      Suggestions and area of improvements identified by students
                    </button>
                  </li>

                </ul>
              </div>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                  <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Houses</th>
                          <th>Max. Score</th>
                          <th>Obtained Score</th>
                          <th>Feedback</th>
                          <th>Response Rate</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        <tr>
                          <td><span class="fw-medium">Bravo</span></td>
                          <td>1931960</td>
                          <td>1680264</td>
                          <td><span class="badge bg-label-primary me-1">86.97%</span></td>
                          <td><span class="badge bg-label-primary me-1">81%</span></td>
                        </tr>

                        <tr>
                          <td><span class="fw-medium">Charlie</span></td>
                          <td>641575</td>
                          <td>552386</td>
                          <td><span class="badge bg-label-primary me-1">86.10%</span></td>
                          <td><span class="badge bg-label-primary me-1">79%</span></td>
                        </tr>

                        <tr>
                          <td><span class="fw-medium">Alpha</span></td>
                          <td>1313950</td>
                          <td>1093346</td>
                          <td><span class="badge bg-label-primary me-1">83.21%</span></td>
                          <td><span class="badge bg-label-primary me-1">76%</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                </div>
                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                  <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Houses</th>
                          <th>Department</th>
                          <th>Max. Score</th>
                          <th>Obtained Score</th>
                          <th>Feedback</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        <tr>
                          <td><span class="fw-medium">Alpha</span></td>
                          <td>Department of Civil Engineering - UNI-FET</td>
                          <td>11065</td>
                          <td>9856</td>
                          <td><span class="badge bg-label-primary me-1">89.07%</span></td>
                        </tr>

                        <tr>
                          <td><span class="fw-medium">Bravo</span></td>
                          <td>Department of Pharmacy - UNI-FPH</td>
                          <td>158340</td>
                          <td>143844</td>
                          <td><span class="badge bg-label-primary me-1">90.85%</span></td>
                        </tr>

                        <tr>
                          <td><span class="fw-medium">Charlie</span></td>
                          <td>Department of Mass Communication - UNI-FSS</td>
                          <td>32190</td>
                          <td>28771</td>
                          <td><span class="badge bg-label-primary me-1">89.38%</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                  <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Houses</th>
                          <th>Faculty Member</th>
                          <th>Max. Score</th>
                          <th>Obtained Score</th>
                          <th>Feedback</th>
                          <th>Ranking</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        <tr>
                          <td><span class="fw-medium">Bravo</span></td>
                          <td>Sheikh Manzoor Saeed</td>
                          <td>8600</td>
                          <td>8177</td>
                          <td><span class="badge bg-label-primary me-1">95.08%</span></td>
                          <td><span class="badge bg-label-primary me-1">1st</span></td>
                        </tr>

                        <tr>
                          <td><span class="fw-medium">Alpha</span></td>
                          <td>Dr. Hamayun Khan</td>
                          <td>4185</td>
                          <td>3924</td>
                          <td><span class="badge bg-label-primary me-1">93.76%</span></td>
                          <td><span class="badge bg-label-primary me-1">2nd</span></td>
                        </tr>

                        <tr>
                          <td><span class="fw-medium">Charlie</span></td>
                          <td>Saad Salman</td>
                          <td>9240</td>
                          <td>8592</td>
                          <td><span class="badge bg-label-primary me-1">92.99%</span></td>
                          <td><span class="badge bg-label-primary me-1">3rd</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="navs-justified-messages1" role="tabpanel">
                  <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Houses</th>
                          <th>Virtue</th>
                          <th>Faculty Member</th>
                          <th>Max.Score</th>
                          <th>Obtained Score</th>
                          <th>Feedback</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Alpha -->
                        <tr>
                          <td rowspan="4"><span class="fw-bold">Alpha</span></td>
                          <td>Empathy and Compassion</td>
                          <td>Dr. Hamayun Khan</td>
                          <td><span class="badge bg-primary">1000</span></td>
                          <td><span class="badge bg-success">945</span></td>
                          <td><span class="text-success fw-semibold">94.50%</span></td>
                        </tr>
                        <tr>
                          <td>Honesty and Integrity</td>
                          <td>Dr. Hamayun Khan</td>
                          <td><span class="badge bg-primary">455</span></td>
                          <td><span class="badge bg-success">426</span></td>
                          <td><span class="text-success fw-semibold">93.63%</span></td>
                        </tr>
                        <tr>
                          <td>Inspirational Leadership</td>
                          <td>Dr. Hamayun Khan</td>
                          <td><span class="badge bg-primary">910</span></td>
                          <td><span class="badge bg-success">852</span></td>
                          <td><span class="text-success fw-semibold">93.63%</span></td>
                        </tr>
                        <tr>
                          <td>Responsibility and Accountability</td>
                          <td>Dr. Hamayun Khan</td>
                          <td><span class="badge bg-primary">1820</span></td>
                          <td><span class="badge bg-success">1701</span></td>
                          <td><span class="text-success fw-semibold">93.46%</span></td>
                        </tr>

                        <!-- Bravo -->
                        <tr>
                          <td rowspan="4"><span class="fw-bold">Bravo</span></td>
                          <td>Empathy and Compassion</td>
                          <td>Abdul Raouf</td>
                          <td><span class="badge bg-primary">1280</span></td>
                          <td><span class="badge bg-success">1221</span></td>
                          <td><span class="text-success fw-semibold">95.39%</span></td>
                        </tr>
                        <tr>
                          <td>Honesty and Integrity</td>
                          <td>Sheikh Manzoor Saeed</td>
                          <td><span class="badge bg-primary">930</span></td>
                          <td><span class="badge bg-success">884</span></td>
                          <td><span class="text-success fw-semibold">95.05%</span></td>
                        </tr>
                        <tr>
                          <td>Inspirational Leadership</td>
                          <td>Sheikh Manzoor Saeed</td>
                          <td><span class="badge bg-primary">1860</span></td>
                          <td><span class="badge bg-success">1773</span></td>
                          <td><span class="text-success fw-semibold">95.32%</span></td>
                        </tr>
                        <tr>
                          <td>Responsibility and Accountability</td>
                          <td>Sheikh Manzoor Saeed</td>
                          <td><span class="badge bg-primary">3780</span></td>
                          <td><span class="badge bg-success">3584</span></td>
                          <td><span class="text-success fw-semibold">94.81%</span></td>
                        </tr>

                        <!-- Charlie -->
                        <tr>
                          <td rowspan="4"><span class="fw-bold">Charlie</span></td>
                          <td>Empathy and Compassion</td>
                          <td>Saad Salman</td>
                          <td><span class="badge bg-primary">2240</span></td>
                          <td><span class="badge bg-success">2097</span></td>
                          <td><span class="text-success fw-semibold">93.62%</span></td>
                        </tr>
                        <tr>
                          <td>Honesty and Integrity</td>
                          <td>Junaid Arshad</td>
                          <td><span class="badge bg-primary">510</span></td>
                          <td><span class="badge bg-success">478</span></td>
                          <td><span class="text-success fw-semibold">93.73%</span></td>
                        </tr>
                        <tr>
                          <td>Inspirational Leadership</td>
                          <td>Aisha Siddiqa Siddique</td>
                          <td><span class="badge bg-primary">1000</span></td>
                          <td><span class="badge bg-success">928</span></td>
                          <td><span class="text-warning fw-semibold">92.80%</span></td>
                        </tr>
                        <tr>
                          <td>Responsibility and Accountability</td>
                          <td>Junaid Arshad</td>
                          <td><span class="badge bg-primary">2040</span></td>
                          <td><span class="badge bg-success">1904</span></td>
                          <td><span class="text-success fw-semibold">93.33%</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="navs-justified-messages2" role="tabpanel">
                  <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Theme</th>
                          <th>Mentions</th>
                          <th>Areas Highlighted</th>
                          <th>Responsible Person</th>
                          <th>Timeline</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Alpha -->
                        <tr>
                          <td>Teaching Style / Methodology </td>
                          <td>950</td>
                          <td>Lecture delivery, pace,clarity, teaching methods</td>
                          <td>Dean/HOD/PL</td>
                          <td rowspan="6"><span class="fw-bold">2 weeks</span></td>
                        </tr>
                        <tr>
                          <td>Class Management / Discipline </td>
                          <td>502</td>
                          <td>Lecture delivery, pace,clarity, teaching methods</td>
                          <td>Dean/HOD/PL</td>
                        </tr>
                        <tr>
                          <td>Teaching Style / Methodology </td>
                          <td>950</td>
                          <td>Lecture delivery, pace,clarity, teaching methods</td>
                          <td>Dean/HOD/PL</td>
                        </tr>
                        <tr>
                          <td>Teaching Style / Methodology </td>
                          <td>950</td>
                          <td>Lecture delivery, pace,clarity, teaching methods</td>
                          <td>Dean/HOD/PL</td>
                        </tr>
                        <tr>
                          <td>Teaching Style / Methodology </td>
                          <td>950</td>
                          <td>Lecture delivery, pace,clarity, teaching methods</td>
                          <td>Dean/HOD/PL</td>
                        </tr>
                        <tr>
                          <td>Teaching Style / Methodology </td>
                          <td>950</td>
                          <td>Lecture delivery, pace,clarity, teaching methods</td>
                          <td>Dean/HOD/PL</td>
                        </tr>
                        <tr>
                          <td>Infrastructures</td>
                          <td>110</td>
                          <td>Sitting Spaces in campus,Internet speed, Mosque space for Friday prayer,Café
                            air-conditioning, labs lack modern facilities</td>
                          <td>Registrar Office</td>
                          <td>Immediately(Labs upgradation is on going)</td>
                        </tr>
                        <tr>
                          <td>Support offices</td>
                          <td>95</td>
                          <td>Staff behavior, guards are rude, </td>
                          <td>Registrar Office</td>
                          <td>Immediately(Two trainings in two weeks)</td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>
            <!--/fffff-->
          </div>
        </div>
      </div>
    </div>
    <!-- / Payment Methods modal -->
    <!-- /table model -->

    <!-- / Payment Methods modal -->
    <!-- Payment Methods modal -->
    <div class="modal fade" id="paymentMethods2" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalScrollableTitle"><i
                class="icon-base ti tabler-list-details me-3"></i>Faculties</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Accordion1 -->
            <div class="row g-6 pt-2">
              <!-- Card Border Shadow -->
              <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-git-fork icon-28px"></i></span>
                      </div>
                      <h4 class="mb-0">8%</h4>
                    </div>
                    <p class="mb-1">Faculty of Business and Management Sciences</p>

                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods1">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-warning"><i
                            class="icon-base ti tabler-load-balancer icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-danger"><i
                            class="icon-base ti tabler-adjustments icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-info"><i
                            class="icon-base ti tabler-clock icon-28px"></i></span>
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
                <div class="card card-border-shadow-primary h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-brand-asana icon-28px"></i></span>
                      </div>
                      <h4 class="mb-0">8%</h4>
                    </div>
                    <p class="mb-1">Faculty of Allied Health Sciences</p>

                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods1">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-warning"><i
                            class="icon-base ti tabler-cherry icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-danger"><i
                            class="icon-base ti tabler-feather icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-info"><i
                            class="icon-base ti tabler-clock icon-28px"></i></span>
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
                <div class="card card-border-shadow-primary h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-truck icon-28px"></i></span>
                      </div>
                      <h4 class="mb-0">8%</h4>
                    </div>
                    <p class="mb-1">Faculty of Engineering and Technology</p>

                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods1">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-warning"><i
                            class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-danger"><i
                            class="icon-base ti tabler-git-fork icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-info"><i
                            class="icon-base ti tabler-clock icon-28px"></i></span>
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
                <div class="card card-border-shadow-primary h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-truck icon-28px"></i></span>
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

    <!-- Payment Methods modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalScrollableTitle"><i
                class="icon-base ti tabler-list-details me-3"></i>Faculties</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="categoryModalBody">
            <!-- Accordion1 -->
            <div class="row g-6 pt-2">
              <!-- Card Border Shadow -->
              <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-truck icon-28px"></i></span>
                      </div>
                      <h4 class="mb-0">8%</h4>
                    </div>
                    <p class="mb-1">Faculty of Business and Management Sciences</p>

                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods1">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-warning"><i
                            class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-danger"><i
                            class="icon-base ti tabler-git-fork icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-info"><i
                            class="icon-base ti tabler-clock icon-28px"></i></span>
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
                <div class="card card-border-shadow-primary h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-truck icon-28px"></i></span>
                      </div>
                      <h4 class="mb-0">8%</h4>
                    </div>
                    <p class="mb-1">Faculty of Allied Health Sciences</p>

                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods1">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-warning"><i
                            class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-danger"><i
                            class="icon-base ti tabler-git-fork icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-info"><i
                            class="icon-base ti tabler-clock icon-28px"></i></span>
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
                <div class="card card-border-shadow-primary h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-truck icon-28px"></i></span>
                      </div>
                      <h4 class="mb-0">8%</h4>
                    </div>
                    <p class="mb-1">Faculty of Engineering and Technology</p>

                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods1">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-warning"><i
                            class="icon-base ti tabler-alert-triangle icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-danger"><i
                            class="icon-base ti tabler-git-fork icon-28px"></i></span>
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
                        <span class="avatar-initial rounded bg-label-info"><i
                            class="icon-base ti tabler-clock icon-28px"></i></span>
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
                <div class="card card-border-shadow-primary h-100" role="button" data-bs-toggle="modal"
                  data-bs-target="#paymentMethods">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="icon-base ti tabler-truck icon-28px"></i></span>
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
    <!-- / include indicator modal -->
    @include('admin.modal.indicator_modal')
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
          height: 150,
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
          height: 150,
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
    document.addEventListener("DOMContentLoaded", function () {
      // ✅ Static labels and datasets
      var chartLabels = ["Teaching and Learning", "Research, Innovation and Commercialisation", "Institutional Engagement (Core only)", "Institutional Engagement (Operational+ Character Strengths)"];
      var shortLabels = ["T&L", "RIC", "IE (Core)", "IE(Character)"];
      var dataset1 = [70, 90, 85, 80]; // Inside Mirror

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
                pointLabels: {
                  color: "#666",
                  font: {
                    size: 12, // label text size
                  },
                  callback: function (label, index) {
                    return shortLabels[index];
                  }
                }
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
                borderColor: "#ddd",
                callbacks: {
                  // 👇 Tooltip shows full label
                  title: function (context) {
                    return chartLabels[context[0].dataIndex];
                  }
                }
              }
            }
          },
          plugins: [
            {
              id: "pointLabelClick",
              afterEvent(chart, args) {
                const { event } = args;
                if (!event) return;

                const { scales } = chart;
                const rScale = scales.r;
                let hovering = false;

                chart.data.labels.forEach((label, i) => {
                  const angle = rScale.getIndexAngle(i);
                  const point = rScale.getPointPositionForValue(i, rScale.max);

                  const padding = 30; // clickable area around label
                  if (
                    event.x >= point.x - padding &&
                    event.x <= point.x + padding &&
                    event.y >= point.y - padding &&
                    event.y <= point.y + padding
                  ) {
                    hovering = true;

                    // 👉 Handle click
                    if (event.type === "click") {
                      const targetId = label.replace(/\s+/g, "-").toLowerCase();
                      const targetDiv = document.getElementById(targetId);

                      if (targetDiv) {
                        // 1️⃣ Scroll into view
                        targetDiv.scrollIntoView({
                          behavior: "smooth",
                          block: "center"
                        });

                        // 2️⃣ Open accordion (if collapsed)
                        const collapseEl = targetDiv.querySelector(".accordion-collapse");
                        if (collapseEl && !collapseEl.classList.contains("show")) {
                          const bsCollapse = new bootstrap.Collapse(collapseEl, {
                            toggle: true
                          });
                        }

                        // 3️⃣ Optionally mark as active
                        document
                          .querySelectorAll(".accordion-item")
                          .forEach((item) => item.classList.remove("active"));
                        targetDiv.classList.add("active");
                      }
                    }
                  }
                });

                // 👉 Change cursor style on hover
                chart.canvas.style.cursor = hovering ? "pointer" : "default";
              }
            }
          ]

        });

        var listEl = document.getElementById("fullLabelsList");
        chartLabels.forEach((label, i) => {
          let li = document.createElement("li");
          li.innerHTML = `<strong>${shortLabels[i]}</strong> = ${label}`;
          listEl.appendChild(li);
        });
      }
    });
    document.addEventListener("DOMContentLoaded", function () {
      var childModal = document.getElementById('paymentMethods');
      var parentModal = new bootstrap.Modal(document.getElementById('paymentMethods2'));

      childModal.addEventListener('hidden.bs.modal', function () {
        parentModal.show(); // reopen parent after child closed
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      var childModal = document.getElementById('paymentMethodsFD');
      var parentModal = new bootstrap.Modal(document.getElementById('paymentMethods1'));

      childModal.addEventListener('hidden.bs.modal', function () {
        parentModal.show(); // reopen parent after child closed
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      // element check
      var c = document.getElementById("carrierPerformances");
      if (!c) {
        console.error("Element #carrierPerformances not found");
        return;
      }


      var n = "#6c757d";                              // label color
      var l = "Arial, sans-serif";                    // font-family
      var s = "#6c757d";                              // legend label color
      var r = { bar: { series1: "#4e73df", series2: "#f6c23e" } };


      var categories = ["Business and Management Sciences", "Economics and Commerce", "Computer Science and Information Technology", "Social Sciences ", "Allied Health Sciences", "Art and Design", "Pharmacy", "Medical Sciences", "Engineering and Technology", "Sciences", "Arts and Humanities", "Law", "Agriculture and Veterinary Sciences"];
      var deliveryRates = [60, 80, 90, 70, 50, 60, 70, 60, 80, 90, 70, 50, 60];
      var deliveryExceptions = [70, 60, 80, 70, 60, 50, 900, 70, 60, 70, 40, 80, 90];


      var options = {
        chart: {
          height: 330,
          type: "bar",
          events: {
            mounted: function () {
              // after chart renders, attach click events to x-axis labels
              document.querySelectorAll("#carrierPerformances .apexcharts-xaxis text").forEach((el, index) => {
                el.style.cursor = "pointer"; // make it look clickable
                el.addEventListener("click", function () {
                  var myModal = new bootstrap.Modal(document.getElementById("categoryModal"));
                  myModal.show();
                });
              });
            }
          },
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
          { name: "Delivery rate", data: deliveryRates },
          { name: "Delivery exceptions", data: deliveryExceptions }
        ],
        xaxis: {
          categories: categories,
          tickAmount: 10,
          labels: {
            formatter: function (value) {
              return value.length > 6 ? value.substring(0, 6) + "..." : value;
            },
            style: { colors: n, fontSize: "13px", fontFamily: l, fontWeight: 400 }
          },
          axisBorder: { show: false },
          axisTicks: { show: false }
        },
        yaxis: {
          tickAmount: 9,
          min: 1,
          max: 100,
          labels: {
            style: { colors: n, fontSize: "13px", fontFamily: l, fontWeight: 400 },
            formatter: function (val) { return val; }
          }
        },
        tooltip: {
          x: {
            formatter: function (val, opts) {
              // Always return the full category name here
              return categories[opts.dataPointIndex];
            }
          }
        },
        legend: {
          show: true,
          position: "bottom",
          markers: { size: 5, shape: "circle" },
          height: 40,
          itemMargin: { horizontal: 8, vertical: 0 },
          fontSize: "13px",
          fontFamily: l,
          fontWeight: 400,
          labels: { colors: s, useSeriesColors: false },
          offsetY: -5
        },
        grid: { strokeDashArray: 6, padding: { bottom: 5 } },
        colors: [r.bar.series1, r.bar.series2],
        fill: { opacity: 1 },
        responsive: [
          { breakpoint: 1400, options: { chart: { height: 275 }, legend: { fontSize: "13px", offsetY: 10 } } },
          { breakpoint: 576, options: { chart: { height: 300 }, legend: { itemMargin: { vertical: 5, horizontal: 10 }, offsetY: 7 } } }
        ]
      };

      new ApexCharts(c, options).render();
    });
    document.addEventListener("DOMContentLoaded", function () {
      var chartEl = document.querySelector("#horizontalBarCharts");
      if (!chartEl) {
        console.error("Element #horizontalBarChart not found");
        return;
      }


      var chartLabels = ["FASH", "FAD", "FBMS", "FET", "FSS", "FEC", "FPH", "FCSIT"];
      var chartData = [45, 40, 35, 30, 25, 20, 15, 10];
      var categories = ["8", "7", "6", "5", "4", "3", "2", "1"];

      var options = {
        chart: {
          height: 300,
          type: "bar",
          toolbar: { show: false }
        },
        plotOptions: {
          bar: {
            horizontal: true,
            barHeight: "60%",
            distributed: true,
            startingShape: "rounded",
            borderRadiusApplication: "end",
            borderRadius: 7
          }
        },
        grid: {
          strokeDashArray: 10,
          borderColor: "#e9ecef",
          xaxis: { lines: { show: true } },
          yaxis: { lines: { show: false } },
          padding: { top: -35, bottom: -12 }
        },
        colors: ["#696cff", "#03c3ec", "#71dd37", "#8592a3", "#ff3e1d", "#ffab00"],
        fill: { opacity: [1, 1, 1, 1, 1, 1] },
        dataLabels: {
          enabled: true,
          style: {
            colors: ["#fff"],
            fontWeight: 400,
            fontSize: "13px",
            fontFamily: "Arial, sans-serif"
          },
          formatter: function (val, opts) {
            // show label text inside the bar
            return chartLabels[opts.dataPointIndex];
          },
          offsetX: 0,
          dropShadow: { enabled: false }
        },
        labels: chartLabels,
        series: [{ data: chartData }],
        xaxis: {
          categories: categories,
          axisBorder: { show: false },
          axisTicks: { show: false },
          labels: {
            style: { colors: "#666", fontFamily: "Arial, sans-serif", fontSize: "13px" },
            formatter: function (val) { return val + "%"; }
          }
        },
        yaxis: {
          max: 35,
          labels: {
            style: { colors: "#666", fontFamily: "Arial, sans-serif", fontSize: "13px" }
          }
        },
        tooltip: {
          enabled: true,
          style: { fontSize: "12px" },
          onDatasetHover: { highlightDataSeries: false },
          custom: function ({ series, seriesIndex, dataPointIndex }) {
            return '<div class="px-3 py-2"><span>' + series[seriesIndex][dataPointIndex] + "%</span></div>";
          }
        },
        legend: { show: false }
      };

      new ApexCharts(chartEl, options).render();
    });

    document.addEventListener("DOMContentLoaded", function () {
      var i = document.querySelector("#expensesChart2"),
        l = {
          chart: {
            height: 170,
            sparkline: {
              enabled: true
            },
            parentHeightOffset: 0,
            type: "radialBar"
          },
          colors: [config.colors.warning], // Make sure config is defined in your app
          series: [77], // ✅ Laravel variable here
          plotOptions: {
            radialBar: {
              offsetY: 0,
              startAngle: -90,
              endAngle: 90,
              hollow: {
                size: "65%"
              },
              track: {
                strokeWidth: "45%",
                background: '#f0f0f0'
              },
              dataLabels: {
                name: {
                  show: false
                },
                value: {
                  fontSize: "24px",
                  color: "#333",
                  fontWeight: 500,
                  offsetY: -5
                }
              }
            }
          },
          grid: {
            show: false,
            padding: {
              bottom: 5
            }
          },
          stroke: {
            lineCap: "round"
          },
          labels: ["Progress"],
          responsive: [
            {
              breakpoint: 1442,
              options: {
                chart: { height: 120 },
                plotOptions: {
                  radialBar: {
                    dataLabels: { value: { fontSize: "18px" } },
                    hollow: { size: "60%" }
                  }
                }
              }
            },
            {
              breakpoint: 1025,
              options: {
                chart: { height: 136 },
                plotOptions: {
                  radialBar: {
                    hollow: { size: "65%" },
                    dataLabels: { value: { fontSize: "18px" } }
                  }
                }
              }
            },
            {
              breakpoint: 769,
              options: {
                chart: { height: 120 },
                plotOptions: {
                  radialBar: { hollow: { size: "55%" } }
                }
              }
            },
            {
              breakpoint: 426,
              options: {
                chart: { height: 145 },
                plotOptions: {
                  radialBar: { hollow: { size: "65%" } }
                },
                dataLabels: {
                  value: { offsetY: 0 }
                }
              }
            },
            {
              breakpoint: 376,
              options: {
                chart: { height: 105 },
                plotOptions: {
                  radialBar: { hollow: { size: "60%" } }
                }
              }
            }
          ]
        };

      if (i !== null) {
        new ApexCharts(i, l).render();
      }
    });

    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".expensesChart").forEach(function (el) {
        var color = el.dataset.color || "#7367f0"; // fallback if missing
        var series = parseInt(el.dataset.series) || 0;

        var options = {
          chart: {
            height: 170,
            sparkline: { enabled: true },
            parentHeightOffset: 0,
            type: "radialBar"
          },
          colors: [color],
          series: [series],
          plotOptions: {
            radialBar: {
              offsetY: 0,
              startAngle: -90,
              endAngle: 90,
              hollow: { size: "65%" },
              track: { strokeWidth: "45%", background: "#f0f0f0" },
              dataLabels: {
                name: { show: false },
                value: {
                  fontSize: "20px",
                  color: "#333",
                  fontWeight: 500,
                  offsetY: -5
                }
              }
            }
          },
          grid: { show: false },
          stroke: { lineCap: "round" },
          labels: ["Progress"]
        };

        new ApexCharts(el, options).render();
      });
    });
    document.addEventListener("DOMContentLoaded", function () {
      // get all buttons
      document.querySelectorAll(".scrollBtn").forEach(function (btn) {
        btn.addEventListener("click", function () {
          document.getElementById("targetDivchart").scrollIntoView({
            behavior: "smooth"
          });
        });
      });
    });
  </script>
@endpush
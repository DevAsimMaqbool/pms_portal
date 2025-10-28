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
  .bg-orange,
    .bg-label-orange {
      background-color: #fd7e1459 !important;
      color: #fd7e14 !important
    }

    .card-border-shadow-orange {
      --bs-card-border-bottom-color: #FFF200 !important
    }
  .h-50vh { height: 50vh; }
  
  @media (min-width: 992px) {
    .h-lg-100vh { height: 400px; }
  }
  @media (min-width: 1401px) {
    .h-md-70vh { height: 460px; }
  }


/* Wrapper provides positioning and responsive height */
.flip-card {
  position: relative;        /* required for absolutely-positioned children */
  width: 100%;
  /* Modern browsers: maintain aspect ratio. Change to suit your card shape. */
  aspect-ratio: 4 / 3;      /* fallback used when supported */
  overflow: visible;
  perspective: 1000px;
}

/* Fallback for browsers that don't support aspect-ratio */
@supports not (aspect-ratio: 1/1) {
  .flip-card {
    /* 75% gives a 4:3 box. Adjust to 100% for square (padding-top:100%) or 56.25% for 16:9 */
    padding-top: 75%;
  }
  /* Place inner absolutely to fill the padded container */
  .flip-card-inner {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
  }
}

/* Inner container handles the flip transform */
.flip-card-inner {
  position: relative;        /* relative by default, but absolute in fallback above */
  width: 100%;
  height: 100%;
  transition: transform 0.6s;
  transform-style: preserve-3d;
}

/* Hover flip — works on desktop; keep for keyboard focus if desired */
.flip-card:hover .flip-card-inner,
.flip-card:focus-within .flip-card-inner {
  transform: rotateY(180deg);
}

/* FRONT & BACK faces — fill parent and stack */
.flip-card-front,
.flip-card-back {
  position: absolute;
  inset: 0;                  /* shorthand for top:0; right:0; bottom:0; left:0 */
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
  border-radius: .5rem;      /* matches Bootstrap card rounding */
  overflow: hidden;
}

/* Ensure card visuals (bootstrap h-100 won't break) */
.flip-card-front .card,
.flip-card-back .card {
  height: 100%;
  border: 0;
}

/* Back side flipped */
.flip-card-back {
  transform: rotateY(180deg);
}

/* Optional: improve mobile UX — reduce 3D motion and use a vertical flip on narrow screens */
@media (max-width: 575.98px) {
  .flip-card {
    aspect-ratio: 3 / 2;      /* make card a little taller on phones if you like */
  }
  /* If you want to disable 3D flip on small screens (touch devices), you can stack back below front */
  /* Uncomment these lines if you prefer a simple reveal instead of 3D on mobile */
  /*
  .flip-card-inner {
    transition: none;
  }
  .flip-card-front,
  .flip-card-back {
    position: relative;
    transform: none;
    backface-visibility: visible;
  }
  .flip-card-back { display: none; } /* or display block on click via JS if needed */
  */
}
.caed-wave-bg {
  background-image: radial-gradient(at left bottom, rgb(252, 247, 234) 65%, rgba(255, 95, 2, 0.52) 100%);
  background-size: 200% 200%; /* make it larger to allow smooth movement */
  animation: waveMove 5s ease-in-out infinite alternate;
}
@keyframes waveMove {
  0% {
    background-position: left bottom;
  }
  50% {
    background-position: right top;
  }
  100% {
    background-position: left top;
  }
}
</style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
       <!-- Accordion1 -->
      <div class="row gy-6">

    
    <!-- Sales Overview -->
    <div class="col-lg-3 col-md-12 d-flex flex-column">
       <div class="row g-6 flex-fill">

        <!-- Generated Leads -->
        <div class="col-lg-12 col-md-6 col-sm-12">
          <div class="card h-100" style="box-shadow: none;">
              <div class="card-header text-center">
                  <div class="card-title mb-0">
                    <h5 class="mb-1">HI, {{ trim(preg_replace('/[-\s]*\d+$/', '', Auth::user()->name)) }} 🎉</h5>
                    <p class="card-subtitle">Your current performance is</p>
                    
                  </div>
                </div>
          </div>
        </div>
        <!--/ Generated Leads -->
        <!-- Profit last month -->
        <div class="col-lg-6 col-md-3 col-sm-6">
            <div class="card h-100">
              
              <div class="card-body d-flex justify-content-center align-items-center">
                  <h4 class="mb-1 me-2 text-center">82%</h4>
                
                
              </div>
            </div>
        </div>
        
        <div class="col-lg-6 col-md-3 col-sm-6">
          <div class="card h-100 bg-info">
              <div class="card-body d-flex justify-content-center align-items-center">
                  <h4 class="mb-1 me-2 text-center text-white">ME</h4>
                
               
              </div>
            </div>
        </div>
        <!--/ Expenses -->
      </div>
    </div>
    <!--/ Sales Overview -->

    <!-- Website Analytics -->
          @php
            $result = getRoleAssignments(Auth::user()->getRoleNames()->first());
            $icon1 = ['tabler-book ', 'tabler-bulb', 'tabler-network', 'tabler-shield-check', 'tabler-star'];
            $colors1 = ['primary', 'success', 'warning', 'orange', 'danger'];
            //$colors2 = ['#0d6efd', '#198754', '#dc3545', '#ffc107', '#0dcaf0'];
            $colors2 = ['#0d6efd', '#198754', '#FFA500', '#FFF200', '#dc3545'];
            $series1 = [90, 85, 70, 65, 50];
            $index1 = 0;
            $index2 = 0;
          @endphp
          @foreach($result as $kpakey => $kpa)
            @php
              $targetId = strtolower(str_replace(' ', '-', $kpa['performance_area']));
              $iconClass = $icon1[$index2 % count($icon1)];
              $color1 = $colors1[$index2 % count($colors1)];
              $index2++;
            @endphp
               {{-- <div class="col-xl-3 col-md-6 col-sm-12" id="{{ $targetId }}">
                      
                      <!-- FRONT SIDE -->
                      <div class="card bg-{{ $color1 }} text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                          <div class="card-title mb-0 text-white">
                            <p class="mb-0">{{ $kpa['performance_area'] }}</p>
                          </div>
                          <div class="card-icon">
                            <span class="badge bg-label-{{ $color1 }} rounded p-2">
                              <i class="icon-base ti {{ $iconClass }} icon-26px"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      
              </div> --}}
               <div class="col-lg-3 col-md-4" id="{{ $targetId }}">
  <div class="flip-card">
    <div class="flip-card-inner">

      <!-- FRONT -->
      <div class="flip-card-front card bg-{{ $color1 }} text-white h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="card-title mb-0 text-white">
            <p class="mb-0">{{ $kpa['performance_area'] }}</p>
          </div>
          <div class="card-icon">
            <span class="badge bg-label-{{ $color1 }} rounded p-2">
              <i class="icon-base ti {{ $iconClass }} icon-26px"></i>
            </span>
          </div>
        </div>
      </div>

      <!-- BACK -->
      <div class="flip-card-back card bg-info text-dark h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <h6 class="mb-2 text-white"">Details</h6>
          <p class="text-center mb-0 text-white"">More information about this performance area.</p>
        </div>
      </div>

    </div>
  </div>
</div>

          @endforeach
    <!--/ Website Analytics -->

</div>
       <div class="row gy-6">

         <div class="col-md-6 col-lg-4" id="scrollableCol1">
            <div class=" d-flex justify-content-between">
            <h5 class="mt-2 text-body-secondary">Hot Indicator</h5>
            </div>
           <!--/ Statistics -->
                    
                <div class="card mb-6">
                    <div class="card-body d-flex">                  
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-orange rounded p-1_5 me-4"><i
                                class="icon-base ti tabler-mood-smile icon-md"></i></div>
                            <div>
                              <small class="text-dark">Student Satisfaction</small>
                            </div>
                          </div>
                          <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                              <div class="progress-bar bg-orange" role="progressbar" style="width: 65%" aria-valuenow="65"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">65%</span>
                          </div>
                    </div>
                  </div>

                  <div class="card mb-6">
                    <div class="card-body d-flex">                  
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-primary rounded p-1_5 me-4"><i
                                class="icon-base ti tabler-chalkboard icon-md"></i></div>
                            <div>
                              <small class="text-dark">Classes Held</small>
                            </div>
                          </div>
                          <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="65"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">90%</span>
                          </div>
                    </div>
                  </div>

                  <div class="card mb-6">
                    <div class="card-body d-flex">                  
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-warning rounded p-1_5 me-4"><i
                                class="icon-base ti tabler-user-check icon-md"></i></div>
                            <div>
                              <small class="text-dark">Student Attendance</small>
                            </div>
                          </div>
                          <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">70%</span>
                          </div>
                    </div>
                  </div>

                  <div class="card mb-6">
                    <div class="card-body d-flex">                  
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-danger rounded p-1_5 me-4"><i
                                class="icon-base ti tabler-book-2 icon-md"></i></div>
                            <div>
                              <small class="text-dark">Research Publications</small>
                            </div>
                          </div>
                          <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">50%</span>
                          </div>
                    </div>
                  </div>

                  <div class="card mb-6">
                    <div class="card-body d-flex">                  
                        <div class="d-flex w-50 align-items-center me-4">
                            <div class="badge bg-label-success rounded p-1_5 me-4"><i
                                class="icon-base ti tabler-stars icon-md"></i></div>
                            <div>
                              <small class="text-dark">Manager Satisfaction</small>
                            </div>
                          </div>
                          <div class="d-flex flex-grow-1 align-items-center">
                            <div class="progress w-100 me-4" style="height:8px;">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-body-secondary">86%</span>
                          </div>
                    </div>
                  </div>



        </div>
        <div class="col-md-6 col-lg-4">
        <div class=" d-flex justify-content-between">
        <h5 class="mt-2 text-body-secondary">Overall KPA Performance</h5>
        </div>
        

      <div class="row g-6">
        <!-- Profit last month -->
       

        <!-- Generated Leads -->
        <div class="col-xl-12">
          <div class="card caed-wave-bg ">
              <div class="card-header d-flex justify-content-between">
                  <div class="card-title mb-0">
                     <i class="icon-base ti tabler-chart-pie"></i>
                  </div>
                  <div class="dropdown">
                    <button class="btn  rounded-pill text-body-secondary border-0 p-2 me-n1 waves-effect" type="button" data-bs-toggle="modal" data-bs-target="#fullscreenModal">
                      <i class="icon-base ti tabler-arrows-maximize"></i>
                    </button>
                  </div>
                </div>
              <div class="card-body">
                 <canvas class="chartjs" id="radarChart1"></canvas>
              </div>
          </div>
           
           <div class="card mt-6">
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
        </div>
        <!--/ Generated Leads -->
       
  
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
        
         
      </div>
      <!--/ Accordion1 -->
    




 <!-- Modal -->
                <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalFullTitle">Overall KPA Performance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                          

                      <div class="row g-6 pt-2">
                        <div class="col-12 col-12" id="targetDivchart">
                          <div class="card caed-wave-bg">

                            <div class="card-header d-flex justify-content-between">
                              <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                                <input type="radio" class="btn-check" name="termRadio" id="overall" checked>
                                <label class="btn btn-outline-primary waves-effect" for="overall">📆 Overall</label>

                                <input type="radio" class="btn-check" name="termRadio" id="spring25">
                                <label class="btn btn-outline-primary waves-effect" for="spring25">📆 Spring 2025</label>

                                <input type="radio" class="btn-check" name="termRadio" id="fall25">
                                <label class="btn btn-outline-primary waves-effect" for="fall25">📆 Fall 2025</label>
                              </div>
                            </div>

                            <div class="card-body pt-0">
                              <div class="row justify-content-center text-center">
                                <div class="col-md-8 d-flex justify-content-center">
                                  <canvas class="chartjs" id="radarChart"></canvas>
                                </div>

                                <div class="col-12 mt-2">
                                  <ul id="customLegend" class="d-flex justify-content-center flex-wrap p-0 m-0" style="list-style:none;">
                                  </ul>
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                    </div>







                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>   
 
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
    const scrollableDiv = document.getElementById("scrollableCol");

    // Set scroll height dynamically based on window height
    const maxHeight = 535;
    scrollableDiv.style.maxHeight = `${maxHeight}px`;

    // Enable vertical scroll
    scrollableDiv.style.overflowY = "auto";
    scrollableDiv.style.scrollBehavior = "smooth";

    // Optional: hide scrollbar (still scrolls)
    scrollableDiv.style.msOverflowStyle = "none"; // IE/Edge
    scrollableDiv.style.scrollbarWidth = "none";  // Firefox
    scrollableDiv.style.overflowX = "hidden";

    // For Chrome/Safari — hide scrollbar visually
    const style = document.createElement("style");
    style.innerHTML = `
      #scrollableCol::-webkit-scrollbar { width: 0; background: transparent; }
    `;
    document.head.appendChild(style);

    // Auto adjust on window resize
    window.addEventListener("resize", () => {
        scrollableDiv.style.maxHeight = `${newHeight}px`;
    });
});
document.addEventListener("DOMContentLoaded", function () {
      var chartLabels = [
        "Teaching and Learning",
        "Research, Innovation and Commercialisation",
        "Institutional Engagement",
      ];
      var shortLabels = ["T&L", "RIC", "IE"];
      var dataset1 = [90, 85, 80];
      var labelColors = ["#e74c3c", "#3498db", "#27ae60"];

      var ctx = document.getElementById("radarChart").getContext("2d");

      var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
      gradientPink.addColorStop(0, "rgba(115, 103, 240, 0.3)");
      gradientPink.addColorStop(1, "rgba(115, 103, 240, 0.5)");

      // ✅ Create the chart first
      var radarChart = new Chart(ctx, {
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
              pointBackgroundColor: labelColors,
              pointBorderColor: labelColors,
              pointRadius: 5,
              pointHoverRadius: 8,
              pointStyle: "circle"
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            r: {
              ticks: { display: true, color: "#666" },
              grid: { color: "#ddd" },
              angleLines: { color: "#ddd" },
              pointLabels: {
                font: { size: 9 },
                color: (context) => labelColors[context.index],
                callback: (label, index) => shortLabels[index]
              }
            }
          },
          plugins: { legend: { display: false } }
        },
        plugins: [
          {
            id: "pointLabelClick",
            afterEvent(chart, args) {
              const { event } = args;
              if (!event) return;

              const rScale = chart.scales.r;
              let hovering = false;

              chart.data.labels.forEach((label, i) => {
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
                        new bootstrap.Collapse(collapseEl, { toggle: true });
                      }

                      // 3️⃣ Mark active
                      document
                        .querySelectorAll(".accordion-item")
                        .forEach((item) => item.classList.remove("active"));
                      targetDiv.classList.add("active");
                    }
                  }
                }
              });

              chart.canvas.style.cursor = hovering ? "pointer" : "default";
            }
          }
        ]
      });

      // ✅ Handle dataset switching *after* chart is initialized
      document.getElementById("overall").addEventListener("change", function () {
        if (this.checked) {
          radarChart.data.datasets[0].data = [90, 85, 80];
          radarChart.update();
        }
      });
      document.getElementById("spring25").addEventListener("change", function () {
        if (this.checked) {
          radarChart.data.datasets[0].data = [80, 85, 90];
          radarChart.update();
        }
      });

      document.getElementById("fall25").addEventListener("change", function () {
        if (this.checked) {
          radarChart.data.datasets[0].data = [70, 90, 80];
          radarChart.update();
        }
      });

      // ✅ Custom Legend
      var legendDiv = document.getElementById("customLegend");
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
    });
    document.addEventListener("DOMContentLoaded", function () {
      var chartLabels = [
        "Teaching and Learning",
        "Research, Innovation and Commercialisation",
        "Institutional Engagement",
      ];
      var shortLabels = ["T&L", "RIC", "IE"];
      var dataset1 = [90, 85, 80];
      var labelColors = ["#e74c3c", "#3498db", "#27ae60"];

      var ctx = document.getElementById("radarChart1").getContext("2d");

      var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
      gradientPink.addColorStop(0, "rgba(115, 103, 240, 0.3)");
      gradientPink.addColorStop(1, "rgba(115, 103, 240, 0.5)");

      // ✅ Create the chart first
      var radarChart = new Chart(ctx, {
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
              pointBackgroundColor: labelColors,
              pointBorderColor: labelColors,
              pointRadius: 5,
              pointHoverRadius: 8,
              pointStyle: "circle"
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            r: {
              ticks: { display: true, color: "#666" },
              grid: { color: "#ddd" },
              angleLines: { color: "#ddd" },
              pointLabels: {
                font: { size: 9 },
                color: (context) => labelColors[context.index],
                callback: (label, index) => shortLabels[index]
              }
            }
          },
          plugins: { legend: { display: false } }
        },
        plugins: [
          {
            id: "pointLabelClick",
            afterEvent(chart, args) {
              const { event } = args;
              if (!event) return;

              const rScale = chart.scales.r;
              let hovering = false;

              chart.data.labels.forEach((label, i) => {
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
                        new bootstrap.Collapse(collapseEl, { toggle: true });
                      }

                      // 3️⃣ Mark active
                      document
                        .querySelectorAll(".accordion-item")
                        .forEach((item) => item.classList.remove("active"));
                      targetDiv.classList.add("active");
                    }
                  }
                }
              });

              chart.canvas.style.cursor = hovering ? "pointer" : "default";
            }
          }
        ]
      });

      // ✅ Handle dataset switching *after* chart is initialized
      document.getElementById("overall").addEventListener("change", function () {
        if (this.checked) {
          radarChart.data.datasets[0].data = [90, 85, 80];
          radarChart.update();
        }
      });
      document.getElementById("spring25").addEventListener("change", function () {
        if (this.checked) {
          radarChart.data.datasets[0].data = [80, 85, 90];
          radarChart.update();
        }
      });

      document.getElementById("fall25").addEventListener("change", function () {
        if (this.checked) {
          radarChart.data.datasets[0].data = [70, 90, 80];
          radarChart.update();
        }
      });

      // ✅ Custom Legend
      var legendDiv = document.getElementById("customLegend");
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
    });
</script>

@endpush
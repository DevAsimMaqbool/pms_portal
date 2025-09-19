@extends('layouts.app')
@push('style')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
   <style>
        .avatar-xl{ width:72px; height:72px; border-radius:50%; object-fit:cover; }
        .metric{ font-size:.9rem; color:#6c757d; }
        .mini-tile{ border:1px solid var(--bs-border-color); border-radius:.75rem; padding:1rem; background:#fff; height:100%; }
        .mini-tile .label{ color:#6e6b7b; font-size:.8rem; }
        .mini-tile .value{ font-weight:700; font-size:1.1rem; }
        .spark-holder{ height:120px; }
        .kpa-card h6{ margin-bottom:.25rem; }
        .indicator-row{ display:flex; align-items:center; justify-content:space-between; padding:.5rem 0; border-bottom:1px dashed var(--bs-border-color); }
        .indicator-row:last-child{ border-bottom:none; }
        .status-badge{ padding:.35rem .5rem; }
        .filter-row .form-select{ min-width:220px; }
    </style>
@endpush
@php use Illuminate\Support\Str; @endphp
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
        <div class="col-12 col-md-6">
          <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-7">
            <div class="card-body text-nowrap">
              <h5 class="card-title mb-0">Congratulations John! 🎉</h5>
              <p class="mb-2">Best seller of the month</p>
              <h4 class="text-primary mb-1">$48.9k</h4>
              <a href="javascript:;" class="btn btn-primary waves-effect waves-light">View Sales</a>
            </div>
          </div>
          <div class="col-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="{{ asset('admin/assets/img/illustrations/card-advance-sale.png') }}" height="140" alt="view sales">
            </div>
          </div>
        </div>
      </div>
        </div>
    <!-- course --> 
    <!-- Vehicles overview -->
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Radar Chart</h5>
        </div>
        <div class="card-body pt-2">
          <canvas class="chartjs" id="radarChart" data-height="355"></canvas>
        </div>
      </div>
    </div>
    <!--/ Sales Overview -->
   <!-- Total Profit -->
   @foreach ($area->indicatorCategories as $category)
    <div class="col-xxl-2 col-md-3 col-6">
            <div class="card h-100 kpa-category" data-id="{{ $category->id }}" style="cursor: pointer;">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-3 rounded"></div>
                    <h6 class="card-title mb-1">{{ $category->indicator_category }}</h6>
                </div>
            </div>
    </div>
    @endforeach
        <!-- Assignment Progress -->
    <div class="col-md-6 col-xxl-4 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Assignment Progress</h5>
        </div>
        <div class="card-body">
            <ul class="list-unstyled mb-0" id="indicatorList"></ul>
        </div>
      </div>
    </div>
    <!--/ Assignment Progress -->
    <div class="col-12 col-md-12" id="indicator-results"></div>
    <!-- Support Tracker -->

    </div>
  </div>
  <!-- / Content -->
@endsection
@push('script')
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
  <script src="{{ asset('admin/assets/js/cards-advance.js') }}"></script>
  <script>
document.addEventListener("DOMContentLoaded", function () {
    var trendScores = [90, 95]; // ✅ your scores
    var trendSemesters = ["Spring 2025", "Fall 2025"]; // ✅ your categories

    var options = {
        chart: { 
            type: 'area', 
            height: 290, 
            toolbar: { show: false } 
        },
        series: [{ 
            name: 'Overall %', 
            data: trendScores 
        }],
        xaxis: { 
            categories: trendSemesters
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#7367f0'],
        fill: { 
            type: 'gradient', 
            gradient: { 
                shadeIntensity: 0.5, 
                opacityFrom: 0.4, 
                opacityTo: 0.05 
            } 
        }
    };

    var chart = new ApexCharts(document.querySelector("#performance_semester"), options);
    chart.render();
});
document.addEventListener("DOMContentLoaded", function () {
    var trendScores = [80, 85, 90]; // ✅ your scores
    var trendSemesters = ["2023", "2024", "2025"]; // ✅ your categories

    var options = {
        chart: { 
            type: 'area', 
            height: 290, 
            toolbar: { show: false } 
        },
        series: [{ 
            name: 'Overall %', 
            data: trendScores 
        }],
        xaxis: { 
            categories: trendSemesters
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#7367f0'],
        fill: { 
            type: 'gradient', 
            gradient: { 
                shadeIntensity: 0.5, 
                opacityFrom: 0.4, 
                opacityTo: 0.05 
            } 
        }
    };

    var chart = new ApexCharts(document.querySelector("#performance_year"), options);
    chart.render();
});
document.addEventListener("DOMContentLoaded", function () {
    // ✅ Static labels and datasets
    var chartLabels = ["Teaching and Learning", "Research", "Institutional Engagement", "Institutional Engagement"];
    var dataset1 = [65, 59, 90, 81]; // Inside Mirror
    var dataset2 = [28, 48, 40, 19]; // Social Mirror

    var g = document.getElementById("radarChart");
    if (g) {
        var ctx = g.getContext("2d");

        // ✅ Gradients
        var gradientBlue = ctx.createLinearGradient(0, 0, 0, 150);
        gradientBlue.addColorStop(0, "rgba(85, 85, 255, 0.9)");
        gradientBlue.addColorStop(1, "rgba(151, 135, 255, 0.8)");

        var gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
        gradientPink.addColorStop(0, "rgba(255, 85, 184, 0.9)");
        gradientPink.addColorStop(1, "rgba(255, 135, 135, 0.8)");

        // ✅ Radar Chart
        new Chart(ctx, {
            type: "radar",
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: "Inside Mirror",
                        data: dataset1,
                        fill: true,
                        backgroundColor: gradientPink,
                        borderColor: "rgba(255, 85, 184, 1)",
                        pointBorderColor: "#ff55b8",
                        pointBackgroundColor: "#fff",
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointStyle: "circle"
                    },
                    {
                        label: "Social Mirror",
                        data: dataset2,
                        fill: true,
                        backgroundColor: gradientBlue,
                        borderColor: "rgba(85, 85, 255, 1)",
                        pointBorderColor: "#5555ff",
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
                        ticks: { maxTicksLimit: 1, display: false, color: "#666" },
                        grid: { color: "#ddd" },
                        angleLines: { color: "#ddd" },
                        pointLabels: { color: "#666" }
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
                        borderColor: "#ddd"
                    }
                }
            }
        });
    }
});

$(document).on('click', '.kpa-category', function () {
    let categoryId = $(this).data('id');
  
    $.ajax({
        url: '{{ route("indicator.getIndicator") }}',
        type: 'POST',
        data: { 
            _token: '{{ csrf_token() }}',
            id: categoryId 
            },
        success: function (response) {
            let $list = $('#indicatorList');
            $list.empty();

            if (response.indicators && response.indicators.length > 0) {
                $.each(response.indicators, function (index, indicator) {
                    $list.append(`
                        <li class="mb-4">
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">${indicator.indicator}</h6>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">1.2k</p>
                                    <div class="ms-4 badge bg-label-success">+4.2%</div>
                                </div>
                                </div>
                            </div>
                            </li>
                    `);
                });
                
            } else {
                $list.append('<li>No indicators found</li>');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
});

</script>

@endpush
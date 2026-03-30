@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <style>
        .avatar-xl {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
        }

        .metric {
            font-size: .9rem;
            color: #6c757d;
        }

        .mini-tile {
            border: 1px solid var(--bs-border-color);
            border-radius: .75rem;
            padding: 1rem;
            background: #fff;
            height: 100%;
        }

        .mini-tile .label {
            color: #6e6b7b;
            font-size: .8rem;
        }

        .mini-tile .value {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .spark-holder {
            height: 120px;
        }

        .kpa-card h6 {
            margin-bottom: .25rem;
        }

        .indicator-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .5rem 0;
            border-bottom: 1px dashed var(--bs-border-color);
        }

        .indicator-row:last-child {
            border-bottom: none;
        }

        .status-badge {
            padding: .35rem .5rem;
        }

        .filter-row .form-select {
            min-width: 220px;
        }
    </style>
@endpush
@php use Illuminate\Support\Str; @endphp
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Left card -->
            <div class="col-12 col-md-4">
                <div class="card mb-6 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-0">{{ $area['performance_area'] }} 🎉</h5>
                        <p class="mb-2">Overall KPA Performance</p>
                        <h4 class="text-primary mb-1">
                            {{ min(number_format(avgKpaScore(Auth::user()->id, request()->segment(2)), 1), 100) }}%
                        </h4>
                        <span class="badge bg-label-primary mb-1">Out of {{ $area['kpa_weightage'] ?? 'NULL' }} %
                            weight</span>
                        @if(!empty($area['small_description']))
                            <p class="card-text">{{ $area['small_description'] }}</p>
                        @else
                            <p class="card-text">No description available</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right chart -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row w-100 align-items-center">

                            <!-- Left side -->
                            <div class="col-md-5">
                                <h5 class="card-title mb-0">
                                    {{ $area['performance_area'] }} Performance
                                </h5>
                            </div>

                            <!-- Right side -->
                            <div class="col-md-7 text-md-end text-start p-0">
                                <div class="btn-group" role="group" aria-label="radio toggle button group">
                                    <input type="radio" class="btn-check" name="termRadio" id="overall" checked>
                                    <label class="btn btn-outline-primary waves-effect" for="overall">📆 Overall for
                                        2024-2025</label>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-body pt-2">
                        {{-- <canvas class="chartjs" id="radarChart" data-height="355"></canvas> --}}
                        <div class="row justify-content-center text-center">
                            <div class="col-md-8 d-flex justify-content-center">
                                <canvas class="chartjs" id="radarChart" style="max-width:100%; height:350px;"></canvas>
                            </div>

                            <div class="col-12 mt-3">
                                <ul id="customLegend" class="d-flex justify-content-center flex-wrap p-0 m-0"
                                    style="list-style:none;"></ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row g-6 pt-5">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <h5 class="card-header">Table Header &amp; Footer</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>KPA Category</th>
                                    <th>Total Score</th>
                                    <th>Total Weight</th>
                                    <th>Formula</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
$sumTotalScore = 0;
                                @endphp
                                @foreach ($area['category'] as $key => $category)
                                    @php
    $sumTotalScore += $category['total_score'] ?? 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <i
                                                class="icon-base {{ $category['cat_icon'] ?? 'ti tabler-check' }} icon-md text-danger me-4"></i>
                                            <span class="fw-medium">{{ $category['indicator_category'] }}</span>
                                        </td>
                                        <td>{{ $category['total_score'] }}</td>
                                        <td>
                                            {{ $category['total_weight'] }}
                                        </td>
                                        <td>
                                            ({{ $category['total_score'] }} / {{ $category['total_weight']}}) x 100 =
                                        </td>
                                        <td>{{ $category['score'] }}</td>
                                    </tr>
                                @endforeach



                            </tbody>
                            <tfoot style="background-color: #7367F0;">
                                <tr>
                                    <th class="text-white">Total</th>
                                    <th class="text-white">{{ $sumTotalScore }}</th>
                                    <th> <i class="icon-base ti tabler-barbell icon-md text-white me-4"></i></th>
                                    <th> <i class="icon-base ti tabler-calculator icon-md text-white me-4"></th>
                                    <th> <i class="icon-base ti tabler-scoreboard icon-md text-white me-4"></i></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Categories + Indicators -->
        <div class="row g-6 pt-5">
            <!-- Navigation -->
            <div class="col-12 col-lg-4">
                <div class="d-flex justify-content-between flex-column mb-4 mb-md-0">
                    <h5 class="mb-4">Sub Categories</h5>
                    <ul class="nav nav-align-left nav-pills flex-column">

                        @foreach ($area['category'] as $key => $category)
                            <li class="nav-item mb-1 kpa-category" data-id="{{ $category['id'] }}" style="cursor: pointer;">
                                <a class="nav-link" href="javascript:void(0);" title="{{ $category['indicator_category'] }}">
                                    <i class="icon-base {{ $category['cat_icon'] }} icon-sm me-1_5"></i>
                                    <span class="align-middle">{{ $category['indicator_category'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- /Navigation -->

            <!-- Indicators -->
            <div class="col-12 col-lg-8 pt-6 pt-lg-0">
                <div class="tab-content p-0">
                    <!-- Store Details Tab -->
                    <div class="tab-pane fade show active" id="store_details" role="tabpanel">
                        <div class="card h-100">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h5 class="card-title m-0 me-2">Progress (Weighted Score)</h5>
                            </div>
                            <div class="card-body">
                                <ul class="p-0 m-0">
                                    <ul class="p-0 m-0" id="indicatorList"></ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Indicators -->
        </div>
    </div>


    {{-- Lazy-load indicator modals to speed up initial KPA page render --}}
    <div id="indicator-modal-dynamic"></div>
    </div>
    <!-- / Content -->
@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script src="{{ asset('admin/assets/js/cards-advance.js') }}"></script>
    <script>
        // Lazy load indicator modal HTML when user clicks an indicator button.
        // This avoids running heavy PHP calculations during initial page load.
        (function () {
            let loaded = false;
            const $container = $('#indicator-modal-dynamic');
            // simple loader
            const loader = `
                                                                        <div id="loader" style="
                                                                            position:fixed;
                                                                            top:0;left:0;
                                                                            width:100%;height:100%;
                                                                            background:#00000080;
                                                                            display:none;
                                                                            z-index:9999;
                                                                            text-align:center;
                                                                            padding-top:20%;
                                                                            color:#fff;
                                                                            font-size:20px;">
                                                                            Loading...
                                                                        </div>
                                                                    `;
            $('body').append(loader);

            $(document).on('click', '#indicatorList [data-bs-target]', function (e) {
                const target = $(this).attr('data-bs-target');
                if (!target || !target.startsWith('#')) return;

                const modalId = target.slice(1);
                if (document.getElementById(modalId)) return; // already present

                if (loaded) return; // HTML fetch failed or not found

                e.preventDefault();
                // show loader
                $('#loader').show();

                $.get('{{ route("indicator.modal.html") }}', function (html) {
                    $container.html(html);
                    loaded = true;

                    const el = document.getElementById(modalId);
                    if (el && window.bootstrap?.Modal) {
                        const modal = window.bootstrap.Modal.getOrCreateInstance(el);
                        modal.show();
                    }
                }).always(function () {
                    // hide loader
                    $('#loader').hide();
                });
            });
        })();

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
            try {
                const chartLabels = @json(collect($area['category'])->pluck('indicator_category')) || [];
                const shortLabels = @json(collect($area['category'])->pluck('cat_short_code')) || [];
                const dataset1 = @json(collect($area['category'])->pluck('score')) || [];

                // ✅ NEW: Convert any value > 100 into 100
                const fixedDataset1 = dataset1.map(v => (v > 100 ? 100 : v));

                const g = document.getElementById("radarChart");
                if (!g || !chartLabels.length) return;

                const ctx = g.getContext("2d");

                const labelColors = [
                    "#e74c3c", "#3498db", "#27ae60", "#f39c12",
                    "#9b59b6", "#16a085", "#d35400", "#2c3e50"
                ];

                const gradient = ctx.createLinearGradient(0, 0, 0, 150);
                gradient.addColorStop(0, "rgba(115,103,240,0.9)");
                gradient.addColorStop(1, "rgba(85,85,255,0.8)");

                const radarChart = new Chart(ctx, {
                    type: "radar",
                    data: {
                        labels: shortLabels,
                        datasets: [
                            {
                                label: "Achievements",
                                // ⬇️ Use fixed values here
                                data: fixedDataset1,
                                fill: true,
                                backgroundColor: gradient,
                                borderColor: "rgba(85,85,255,1)",
                                pointBorderColor: labelColors.slice(0, shortLabels.length),
                                pointBackgroundColor: labelColors.slice(0, shortLabels.length),
                                pointRadius: 5,
                                pointHoverRadius: 8,
                                pointStyle: "circle"
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 600 },
                        scales: {
                            r: {
                                min: 0,
                                max: 100,
                                ticks: {
                                    display: true,
                                    stepSize: 10,
                                    color: "#666",
                                    backdropColor: "transparent",
                                    font: { size: 10 }
                                },
                                grid: { color: "#ddd" },
                                angleLines: { color: "#ddd" },
                                pointLabels: {
                                    font: { size: 11 },
                                    color: (ctx) => labelColors[ctx.index % labelColors.length],
                                    callback: (label, i) => shortLabels[i] || label
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: "#fff",
                                titleColor: "#000",
                                bodyColor: "#333",
                                borderWidth: 1,
                                borderColor: "#ddd",
                                callbacks: {
                                    title: (context) => chartLabels[context[0].dataIndex]
                                }
                            }
                        }
                    }
                });

                const legendDiv = document.getElementById("customLegend");
                if (legendDiv) {
                    legendDiv.innerHTML = "";
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
                }
            } catch (error) {
                console.error("Radar chart initialization error:", error);
            }
        });



        function initChartProgress() {
            var elements = document.querySelectorAll(".chart-progress");
            elements.forEach(function (el) {
                var color = config.colors[el.dataset.color];
                var series = el.dataset.series;
                var variant = el.dataset.progress_variant || "false";

                // your ApexChart / chart code here...
                new ApexCharts(el, {
                    chart: {
                        height: variant === "true" ? 60 : 48,
                        width: variant === "true" ? 58 : 38,
                        type: "radialBar"
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: variant == "true" ? "50%" : "25%"
                            },
                            dataLabels: {
                                show: variant == "true",
                                value: {
                                    offsetY: -10,
                                    fontSize: "15px",
                                    fontWeight: 500,
                                }
                            }
                        }
                    },
                    series: [series],
                    labels: variant == "true" ? [""] : ["Progress"],
                    stroke: {
                        lineCap: "round"
                    },
                    colors: [color],
                    grid: {
                        padding: {
                            top: variant == "true" ? -12 : -15,
                            bottom: variant == "true" ? -17 : -15,
                            left: variant == "true" ? -17 : -5,
                            right: -15
                        }
                    },
                }).render();
            });
        }
        function getColorByPercentage(percentage) {
                if (percentage >= 90) return '#7367f0'; // primary
                if (percentage >= 80) return '#28c76f'; // success
                if (percentage >= 70) return '#ff9f43'; // warning
                if (percentage >= 60) return '#fd7e14'; // orange
                return '#ea5455'; // danger
            }
            function getColorByPercentageForGraph(percentage) {
                    if (percentage >= 90) return 'primary'; // primary
                    if (percentage >= 80) return 'success'; // success
                    if (percentage >= 70) return 'warning'; // warning
                    if (percentage >= 60) return 'orange'; // orange
                    return 'danger'; // danger
                }

        function initProgressTooltips() {
                document.querySelectorAll('.chart-progress').forEach(function (el) {

                    let score = el.getAttribute('data-value');
                    let series = el.getAttribute('data-series');
                    let weightage = el.getAttribute('data-weightage') || 3;
                    let color = getColorByPercentage(series);

                    // Bootstrap tooltip attributes
                    el.setAttribute('data-bs-toggle', 'tooltip');
                    el.setAttribute('data-bs-placement', 'top');
                    el.setAttribute('data-bs-title', `${score}% out of ${weightage}%`);

                    // IMPORTANT: destroy old instance (prevents duplicate/ghost tooltips)
                    let existing = bootstrap.Tooltip.getInstance(el);
                    if (existing) existing.dispose();

                    // create tooltip
                    new bootstrap.Tooltip(el, {
                        trigger: 'hover'
                    });

                    // apply color AFTER tooltip shows
                    el.addEventListener('shown.bs.tooltip', function () {

                        const tooltipEl = document.querySelector('.tooltip.show');
                        if (!tooltipEl) return;

                        const inner = tooltipEl.querySelector('.tooltip-inner');
                        if (inner) {
                            inner.style.backgroundColor = color;
                            inner.style.color = '#fff';
                            inner.style.borderRadius = '6px';
                            inner.style.padding = '6px 10px';
                        }

                        const arrow = tooltipEl.querySelector('.tooltip-arrow');
                        if (arrow) {
                            arrow.style.setProperty('--bs-tooltip-bg', color);
                        }
                    });

                });
            }

        $(document).ready(function () {
            // ✅ By default select first category
            let $firstCategory = $('.kpa-category').first();
            if ($firstCategory.length) {
                $firstCategory.find('.nav-link').addClass('active'); // set active
                fetchIndicators($firstCategory.data('id')); // auto load indicators
            }

            // ✅ On category click
            $(document).on('click', '.kpa-category', function () {
                // remove active from all
                $('.kpa-category .nav-link').removeClass('active');
                // add active to current
                $(this).find('.nav-link').addClass('active');

                let categoryId = $(this).data('id');
                fetchIndicators(categoryId);
            });

            const userRole = "{{ activeRole() }}";
            const disabledRoles = [
                "hod",
                "dean",
                "program leader ug",
                "program leader pg"
            ];

            // ✅ Fetch indicators (reusable function)
            function fetchIndicators(categoryId) {
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
                            let colors = ["primary", "success", "warning", "secondary-color", "danger"];

                            $.each(response.indicators, function (index, indicator) {
                                let color = getColorByPercentageForGraph(indicator.percentage); //indicator.color || 'primary';
                                let formattedIndicator = indicator.indicator.replace(/[\s#']+/g, '');
                                let percentage = indicator.percentage || 0;
                                let indicatorScore = indicator.score || 0;
                                let indicatorWeightage = indicator.weightage || 0; 
                                let isDisabled = disabledRoles.includes(userRole);

                                $list.append(`
                                                                                <li class="d-flex mb-6">
                                                                                <div class="chart-progress me-4"
                                                                                                     data-color="${color}"
                                                                                                     data-series="${percentage}"
                                                                                                     data-progress_variant="true"  data-value="${indicatorScore}" title="" data-weightage="${indicatorWeightage}"></div>


                                                                                <div class="row w-100 align-items-center">
                                                                                <div class="col-9">
                                                                                <div class="me-2">
                                                                                <h6 class="mb-1_5">${indicator.indicator}</h6>
                                                                                </div>
                                                                                </div>

                                                                                <div class="col-3 text-end">
                                                                                <button type="button"
                                                                                class="btn btn-sm btn-icon btn-label-primary"
                                                                                role="button"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#${formattedIndicator}"
                                                                                ${isDisabled ? 'disabled' : ''}>

                                                                                <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                                                                                </button>
                                                                                </div>
                                                                                </div>
                                                                                </li>
                                                                                `);
                            });

                            initChartProgress(); // re-init charts after AJAX load
                            initProgressTooltips();
                        } else {
                            $list.append('<li>No indicators found</li>');
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const items = document.querySelectorAll(".kpa-category .align-middle");

            function adjustText() {
                let screenWidth = window.innerWidth;

                items.forEach(span => {
                    let fullText = span.getAttribute("data-full") || span.innerText;
                    span.setAttribute("data-full", fullText); // save original text

                    let maxLength;
                    if (screenWidth <= 610) { // mobile
                        maxLength = 25;
                    }
                    else if (screenWidth > 610 && screenWidth <= 991) { // tablet
                        maxLength = 60;
                    } else if (screenWidth > 991 && screenWidth <= 1200) { // tablet
                        maxLength = 25;
                    }
                    else if (screenWidth > 1200 && screenWidth <= 1700) { // tablet
                        maxLength = 25;
                    }
                    else if (screenWidth => 1700) { // tablet
                        maxLength = 50;
                    } else { // desktop
                        maxLength = 50;
                    }


                    span.innerText = fullText.length > maxLength ? fullText.substring(0, maxLength) + "..." : fullText;
                });
            }

            adjustText();
            window.addEventListener("resize", adjustText);
        });

    </script>

@endpush
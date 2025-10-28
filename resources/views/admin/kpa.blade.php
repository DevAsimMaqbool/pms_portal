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
                        <h4 class="text-primary mb-1">72%</h4>

                        @if ($area['id'] == 1)
                            <p class="card-text">
                                This KPA focuses on effective teaching delivery at undergraduate and postgraduate levels, efficient course and classroom management, and continuous enhancement of teaching outputs to ensure quality education. Excellence in teaching and learning is the foundation of student success. It shapes competent graduates, strengthens institutional reputation, and promotes lifelong learning.
                            </p>
                        @elseif ($area['id'] == 2)
                            <p class="card-text">
                                This KPA measures research productivity, quality, and supervision at the postgraduate level. It also covers the development of knowledge products and the translation of research into practical innovations and commercial outcomes. Advancing research and innovation builds intellectual capital, drives societal progress, and connects academic insights with industry applications for sustainable growth.
                            </p>
                        @elseif ($area['id'] == 13)
                            <p class="card-text">
                                This KPA emphasizes proactive participation in departmental tasks, institutional initiatives, and events that enhance collaboration, visibility, and collective achievement. Institutional engagement fosters teamwork, ownership, and a shared sense of purpose, strengthening the institution’s culture and external partnerships.
                            </p>
                        @elseif ($area['id'] == 14)
                            <p class="card-text">
                                This KPA embodies responsibility, accountability, empathy, humility, honesty, and inspirational leadership as guiding principles for personal and professional conduct.
Character virtues create the moral compass for excellence. They nurture ethical leaders who act with integrity, compassion, and service to others.
                            </p>
                        @else
                            <p class="card-text">Other text</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right chart -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"">
                                                                                    <h5 class=" card-title mb-0">
                        {{ $area['performance_area'] }}
                        Performance
                        </h5>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio2" id="dailyRadio2" checked>
                            <label class="btn btn-outline-primary waves-effect" for="dailyRadio2"> 📆 Spring 2025</label>

                            <input type="radio" class="btn-check" name="btnradio2" id="monthlyRadio2">
                            <label class="btn btn-outline-primary waves-effect" for="monthlyRadio2"> 📆 Fall 2025</label>
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
                                <h5 class="card-title m-0 me-2">Progress</h5>
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


    @include('admin.modal.indicator_modal')
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
            try {
                const chartLabels = @json(collect($area['category'])->pluck('indicator_category')) || [];
                const shortLabels = @json(collect($area['category'])->pluck('cat_short_code')) || [];

                // ✅ Static dataset values (adjusts automatically to match labels)
                const staticValues = [70, 90, 85, 80];
                const dataset1 = shortLabels.map((_, i) => staticValues[i % staticValues.length]);

                const g = document.getElementById("radarChart");
                if (!g || !chartLabels.length) return;

                const ctx = g.getContext("2d");

                // 🎨 Dynamic label colors
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
                                data: dataset1,
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
                                min: 50, // ✅ Show full scale
                                max: 100,
                                ticks: {
                                    display: true, // ✅ Show 60,70,80,90,100
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

                // ✅ Custom Legend
                const legendDiv = document.getElementById("customLegend");
                if (legendDiv) {
                    legendDiv.innerHTML = ""; // Clear old legend if any
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
                            let fixedValues = [90, 85, 70, 65, 50];
                            $.each(response.indicators, function (index, indicator) {
                                let color = colors[index % colors.length];
                                let randomValue = fixedValues[index % fixedValues.length];
                                let formattedIndicator = indicator.indicator.replace(/[\s#']+/g, '');
                                $list.append(`
                                                                                                    <li class="d-flex mb-6">
                                                                                                        <div class="chart-progress me-4" data-color="${color}" data-series="${randomValue}" data-progress_variant="true"></div>
                                                                                                        <div class="row w-100 align-items-center">
                                                                                                            <div class="col-9">
                                                                                                                <div class="me-2">
                                                                                                                    <h6 class="mb-1_5">${indicator.indicator}</h6>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-3 text-end">
                                                                                                                <button type="button" class="btn btn-sm btn-icon btn-label-primary" role="button" data-bs-toggle="modal" data-bs-target="#${formattedIndicator}">
                                                                                                                    <i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-20px"></i>
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                `);
                            });

                            // ✅ Re-init charts after AJAX load
                            initChartProgress();
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
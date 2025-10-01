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
                            <h4 class="text-primary mb-1">80%</h4>

                            @if ($area['id'] == 1)
                                <p class="card-text">
                                    Teaching performance is evaluated through student success rates,
                                    feedback, teaching compliance, and the adoption of innovative
                                    practices that engage and motivate students effectively.
                                </p>
                            @elseif ($area['id'] == 2)
                                <p class="card-text">
                                    Research performance is assessed through a combination of publication
                                    quantity and quality, funding success, research impact (citations),
                                    and collaboration with external organizations, including industry.
                                </p>
                            @elseif ($area['id'] == 13)
                                <p class="card-text">
                                    Institutional engagement is evaluated based on contributions to academic
                                    governance, curriculum design, strategic decision-making, and maintaining
                                    relationships with industry and academic partners.
                                </p>
                            @elseif ($area['id'] == 14)
                                <p class="card-text">
                                    Character traits performance focuses on evaluating an individual's
                                    ethical conduct, emotional intelligence, sense of responsibility,
                                    and effective use of resources, fostering a positive and productive
                                    professional environment.
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
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ $area['performance_area'] }} Performance</h5>
                        </div>
                        <div class="card-body pt-2">
                            {{-- <canvas class="chartjs" id="radarChart" data-height="355"></canvas> --}}
                            <div class="row">
                            <div class="col-md-8">
                                <canvas class="chartjs" id="radarChart"></canvas>
                            </div>
                            <div class="col-md-4">
                                <ul id="fullLabelsList" class="list-unstyled mt-3" style="font-size:12px"></ul>
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
            // ✅ Static labels and datasets
            //var chartLabels = ["Teaching and Learning", "Research, Innovation and Commercialisation", "Institutional Engagement (Core only)", "Institutional Engagement (Operational+ Character Strengths)"];
            //var shortLabels = ["T&L", "RIC", "IE (Core)", "IE(Character)"];
           // var dataset1 = [70, 90, 85, 80]; // Inside Mirror 

            var chartLabels = @json(collect($area['category'])->pluck('indicator_category'));
            var shortLabels = @json(collect($area['category'])->pluck('cat_short_code'));
            var dataset1 = @json(
                collect($area['category'])->map(function () {
                    return rand(50, 100);
                })
            );

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
                            let colors = ["primary", "success", "danger", "warning", "info"];
                            $.each(response.indicators, function (index, indicator) {
                                let color = colors[index % colors.length];
                                let randomValue = Math.floor(Math.random() * 100) + 1;
                                let formattedIndicator = indicator.indicator.replace(/\s+/g, '');
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
                                                        <button type="button" class="btn btn-sm btn-icon btn-label-secondary" role="button" data-bs-toggle="modal" data-bs-target="#${formattedIndicator}">
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
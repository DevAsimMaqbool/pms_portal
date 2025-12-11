<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Insight Report 2024-2025</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        :root {
            --gray-900: #2f2f2f;
            --gray-800: #4b4b4b;
            --gray-700: #6a6a6a;
            --gray-100: #f0f0f0;
            --page-bg: #e5e5e5;
            --header-bg: #5a5a5a;
            --accent-dark: #3f3f3f;
            --white: #ffffff;
            --yellow: #fbefb2;
            --teal: #c9ece6;
            --pill-green: #72d572;
            --pill-blue: #6db9ff;
            --pill-amber: #fdd37a;
            --pill-orange: #ffb36b;
            --pill-red: #ff8a80;
            --purple: #7c2ae8;
            --green: #2bd47d;
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%
        }

        body {
            margin: 0;
            background: var(--page-bg);
            font-family: "Roboto", system-ui, -apple-system, Segoe UI, Helvetica, Arial, sans-serif;
            color: #222;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact
        }

        .A4 {
            width: 794px;
            /* ~ A4 @ 96dpi */
            min-height: auto;
            margin: 16px auto;
            background: var(--white);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
            position: relative;
            overflow: hidden;
            padding-bottom: 35px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 16px 24px 10px;
            background: linear-gradient(180deg, #666, #555 40%, #4d4d4d);
            color: var(--white);
            border-bottom: 6px solid #bfbfbf;
        }

        .identity .name {
            font-family: "Montserrat", sans-serif;
            font-weight: 900;
            margin: 0;
            letter-spacing: .2px;
            font-size: 22px;
        }

        .identity .role,
        .identity .dept {
            opacity: .9;
            font-size: 11px;
        }

        .identity .role {
            margin-top: 2px
        }

        .report-title {
            text-align: right;
        }

        .report-center {
            text-align: center;
        }

        .report-title .title {
            font-family: "Montserrat", sans-serif;
            font-weight: 500;
            font-size: 16px;
            text-shadow: 0 2px 0 rgba(0, 0, 0, .25);
        }

        .report-title .year {
            font-family: "Montserrat", sans-serif;
            font-weight: 500;
            font-size: 16px;
            line-height: 1;
            color: #111;
            text-shadow: 0 1px 0 #fff, 0 -1px 0 #fff, 1px 0 0 #fff, -1px 0 0 #fff, 0 2px 6px rgba(0, 0, 0, .25);
        }

        .report-title .issued {
            font-size: 11px;
            opacity: .85
        }

        .intro {
            padding: 12px 20px 6px
        }

        .intro p {
            margin: 0 0 12px;
            line-height: 1.55;
            font-size: 12px;
        }

        .grid-two {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            align-items: start
        }

        .overall-heading {
            margin: 0 0 6px
        }

        .overall-heading .overall {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            letter-spacing: .5px;
            font-size: 24px;
            background: linear-gradient(180deg, #00e676, #00bfa5);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent
        }

        .overall-heading .performance {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            letter-spacing: .5px;
            font-size: 24px;
            margin-top: -6px;
            background: linear-gradient(180deg, #8e2de2, #7a35ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent
        }

        .overall-block p {
            margin: 6px 0 0;
            font-size: 11px;
            color: #444
        }

        .radar-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .radar {
            width: 100%;
            max-width: 320px;
            height: auto
        }

        .radar .ring {
            fill: none;
            stroke: #e3e3e3;
            stroke-width: 1
        }

        .radar .target {
            fill: url(#grad-target);
            stroke: #bdbdbd;
            stroke-width: 1
        }

        .radar .achieved {
            fill: #ffd9dc;
            stroke: #ff6e7b;
            opacity: .95;
            stroke-width: 1.5
        }

        .kpi {
            padding: 8px 18px 6px
        }

        .kpi-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            box-shadow: 0 0 0 1px #c8c8c8 inset;
            table-layout: fixed
        }

        .kpi-table th,
        .kpi-table td {
            border: 0.5px solid #bdbdbd;
            padding: 6px 8px;
            font-size: 11px;
            background: #fff
        }

        .kpi-table thead th {
            background: #e9e9e9;
            font-weight: 700
        }

        .kpi-table td:nth-child(2) {
            width: 48px;
            /* background: #efefef */
        }

        .kpi-table .achieved-cell {
            font-weight: 700;
            text-align: center
        }

        .kpi-table .achieved-cell.yellow {
            background: var(--yellow)
        }

        .kpi-table .achieved-cell.teal {
            background: var(--teal)
        }

        .kpi-table .achieved-cell.green {
            background: #c6efc6
        }

        .kpi-table .achieved-cell.pink {
            background: #ffd3d8
        }

        .kpi-table .achieved-cell.blue {
            background: #bfe3f2
        }

        .kpi-table .achieved-cell.amber {
            background: #ffe4b0
        }

        .kpi-table .achieved-cell.orange {
            background: #ffd9b3
        }

        .legend {
            display: flex;
            gap: 8px;
            padding: 10px 0 0;
            flex-wrap: wrap
        }

        .pill {
            padding: 4px 8px;
            border-radius: 18px;
            font-size: 10px;
            font-weight: 600;
            color: #1f1f1f
        }

        .pill-green {
            background: var(--pill-green)
        }

        .pill-blue {
            background: var(--pill-blue)
        }

        .pill-amber {
            background: var(--pill-amber)
        }

        .pill-orange {
            background: var(--pill-orange)
        }

        .pill-red {
            background: var(--pill-red)
        }

        .achievements {
            padding: 6px 18px 8px;
        }

        .achievements h3 {
            margin: 8px 0;
            font-family: "Montserrat";
            font-weight: 800;
            font-size: 16px;
        }

        .cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px
        }

        .card {
            background: #efefef;
            padding: 10px;
            border-radius: 14px
        }

        .card-title {
            font-weight: 800;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .subcard {
            background: #fff;
            border-radius: 14px;
            padding: 8px;
            box-shadow: 0 0 0 2px #e0e0e0 inset;
            margin-bottom: 8px
        }

        .sub-title {
            font-weight: 700;
            margin-bottom: 4px;
            font-size: 12px;
        }

        .subcard ol {
            margin: 0;
            padding-left: 16px
        }

        .subcard li {
            margin: 2px 0;
            font-size: 11px;
        }

        .achievement-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            background: #efefef;
            padding: 10px;
        }

        .tag-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 999px;
            font-size: 11px;
            line-height: 1.3;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .06);
        }

        .tag-pill-remarks {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 15px !important;
            font-size: 11px;
            line-height: 1.3;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .06);
        }

        /* Download button */
        .download-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 9999;
            background: #222;
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            cursor: pointer
        }

        .download-btn:hover {
            background: #000
        }

        /* Teaching Performance page */
        .tp-section {
            padding: 12px 20px 6px
        }

        .tp-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            align-items: start
        }

        .tp-heading {
            margin: 0 0 8px
        }

        .tp-heading .t-red {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #ff2d2d;
            font-size: 24px
        }

        .tp-heading .t-blue {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #2f86ff;
            font-size: 24px;
            margin-top: -6px
        }

        .tp-heading .t-green {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #00c853;
            font-size: 24px
        }

        .tp-left p {
            margin: 6px 0 0;
            font-size: 11px;
            color: #444
        }

        .triangle {
            width: 100%;
            max-width: 360px;
            height: auto
        }

        .tri-grid {
            fill: none;
            stroke: #e7e7e7
        }

        .tri-target {
            fill: none;
            stroke: #cfd8dc
        }

        .tri-achieved {
            fill: none;
            stroke: #32b6e6;
            stroke-width: 3
        }

        .tri-legend {
            text-align: center;
            color: #666;
            font-size: 10px;
            margin-top: 6px
        }

        .tri-legend .key {
            display: inline-block;
            width: 24px;
            height: 3px;
            margin: 0 6px;
            vertical-align: middle
        }

        .tri-legend .key.target {
            background: #cfd8dc
        }

        .tri-legend .key.achieved {
            background: #32b6e6
        }

        /* Development Suggestions page (refined) */
        .dev-suggest {
            padding: 16px 20px 24px
        }

        .dev-heading {
            font-family: "Montserrat";
            font-weight: 900;
            font-size: 24px;
            line-height: 1
        }

        .dev-heading .dev {
            display: block;
            color: #ff2c2c;
            letter-spacing: .6px
        }

        .dev-heading .sugg {
            display: block;
            color: #1787ff;
            margin-top: -6px;
            letter-spacing: .6px
        }

        .dev-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 12px
        }

        .dev-card {
            background: transparent;
            padding: 0
        }

        .dev-pill {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 9999px;
            font-weight: 800;
            font-family: "Montserrat";
            margin-bottom: 8px;
            color: #0d0d0d;
            box-shadow: 0 1px 0 rgba(0, 0, 0, .05) inset;
            font-size: 11px;
        }

        .dev-pill.green {
            background: #34d399;
            color: #0d3b2e
        }

        .dev-pill.blue {
            background: #1ea7ff;
            color: #fff
        }

        .dev-pill.magenta {
            background: #e25bce;
            color: #222
        }

        .dev-pill.orange {
            background: #f59e0b;
            color: #fff
        }

        .dev-card p {
            margin: 0;
            line-height: 1.65;
            font-size: 12px;
            color: #222;
            max-width: 330px
        }

        /* Research Performance */
        .research-intro {
            padding: 12px 20px 6px
        }

        .research-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            align-items: start
        }

        .research-heading {
            margin: 0 0 8px
        }

        .research-heading .research {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            font-size: 24px;
            color: #2a7cff
        }

        .research-heading .perf {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            font-size: 24px;
            color: #7a35ff;
            margin-top: -6px
        }

        .radar .achieved-blue {
            fill: #cfe8ff;
            stroke: #2a7cff;
            opacity: .95;
            stroke-width: 1.5
        }

        .two-col-table {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            margin: 12px 18px 12px;
            border: 0.5px solid #bdbdbd
        }

        .two-col-table .t-header {
            background: #e1e1e1;
            font-weight: 800;
            padding: 6px 10px;
            border-bottom: 0.5px solid #bdbdbd;
            font-size: 12px;
        }

        .two-col-table .t-row {
            padding: 5px 10px;
            border-top: 0.5px solid #d0d0d0;
            font-size: 11px;
        }

        .two-col-table .t-row:nth-child(odd) {
            background: #fff
        }

        .page-footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            font-size: 10px;
            color: #3d3d3d;
            padding: 3px 0;
            background: #e9e9e9;
            border-top: 1px solid #d1d1d1
        }

        /* Character Mastery */
        .char-intro {
            padding: 12px 20px 6px
        }

        .char-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            align-items: start
        }

        .char-heading {
            margin: 0 0 8px
        }

        .char-heading .char-red {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #ff2d2d;
            font-size: 24px
        }

        .char-heading .char-blue {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #2f86ff;
            font-size: 24px;
            margin-top: -6px
        }

        .char-left p {
            margin: 6px 0 0;
            font-size: 11px;
            color: #444
        }

        .diamond {
            width: 100%;
            max-width: 360px;
            height: auto
        }

        .dia-grid {
            fill: none;
            stroke: #e7e7e7
        }

        .dia-target {
            fill: none;
            stroke: #cfd8dc
        }

        .dia-achieved {
            fill: none;
            stroke: #6cc04a;
            stroke-width: 3
        }

        /* Column width control */
        .kpi-table th:nth-child(1),
        .kpi-table td:nth-child(1) {
            width: 50%;
            /* First column 50% */
        }

        .kpi-table th:nth-child(n+2),
        .kpi-table td:nth-child(n+2) {
            width: 16.66%;
            /* Remaining 3 columns share 50% equally */
        }

        /* Print adjustments to prevent overlap */
        @page {
            size: A4;
            margin: 8mm
        }

        @media print {
            body {
                background: #fff
            }

            .A4 {
                margin: 0 auto;
                box-shadow: none;
                width: 210mm;
                height: auto;
                min-height: auto;
                break-after: page;
                page-break-after: always;
                break-inside: avoid-page;
                page-break-inside: avoid;
                padding-bottom: 35px;
            }

            .A4:last-child {
                break-after: auto;
                page-break-after: auto;
                min-height: auto;
            }

            .page-footer {
                position: static
            }

            .download-btn {
                display: none
            }
        }
    </style>
</head>

<body>
    <!-- <button class="download-btn" onclick="window.print()" title="Download PDF">Download PDF</button> -->
    <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ trim(preg_replace('/[-\s]*\d+$/', '', Auth::user()->name)) }}</h5>
                <div class="role">{{ $user->barcode }}</div>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="title">2024-2025</div>
                <div class="issued">Issued on {{ now()->format('F d, Y') }}</div>
            </div>
        </header>

        <section class="intro">
            <p>
                This Performance Insight Report provides a comprehensive review of your performance as
                <em>{{ $user->job_title }}</em> for the period of 2024-2025. The report covers key areas essential to
                your
                role including: Teaching and Learning, Research, Innovation and Commercialisation and Institutional
                Engagement. By analyzing achievements, and
                pinpoints areas for improvement to ensure sustained professional development and optimized
                contributions to the university's mission.
            </p>
            <div class="grid-two">
                <aside class="overall-block">
                    <h2 class="overall-heading">
                        <span class="overall">OVERALL</span>
                        <span class="performance">PERFORMANCE</span>
                    </h2>
                    <p>
                        Overall performance is a blend of academic, professional, and personal qualities, and it
                        reflects an individual's ability to contribute meaningfully to teaching, research, institutional
                        development, and organizational culture. High overall performance is characterized by a
                        balance of strong professional skills, ethical conduct, and a commitment to continuous
                        improvement.
                    </p>
                </aside>
                <div class="radar-wrap">
                    <div class="card-body pt-2">
                        <canvas class="chartjs" id="radarChart" data-height="355"></canvas>
                    </div>
                </div>

            </div>
        </section>

        <section class="kpi">
            <table class="kpi-table">
                <thead>
                    <tr>
                        <th>KPA</th>
                        <th>Target</th>
                        <th>Achieved</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @php
                            $kpaResult = kpaAvgScore(1, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Teaching and Learning</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                    <tr>
                        @php
                            $kpaResult = kpaAvgScore(2, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Research, Innovation and Commercialisation</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                    <tr>
                        @php
                            $kpaResult = kpaAvgScore(13, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Institutional Engagement</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                </tbody>
            </table>

            <!-- <div class="legend">
                <div class="pill pill-green">91% and Above OS</div>
                <div class="pill pill-blue">81% - 90% EE</div>
                <div class="pill pill-amber">71% - 80% ME</div>
                <div class="pill pill-orange">61% - 70% NI</div>
                <div class="pill pill-red">60% and Below BE</div>
            </div> -->
        </section>
        <section class="achievements">
            <h3>Notable Performance Achievements</h3>
            <div class="achievement-tags">
                @foreach ($noteable as $tag)
                    <span class="tag-pill">
                        {{ $tag->indicator->indicator }} ({{ $tag->kpa->short_code }})
                    </span>
                @endforeach
            </div>
        </section>
        <section class="achievements">
            <h3>Development Areas</h3>
            <div class="achievement-tags">
                @foreach ($areaOfDevelopment as $devAera)
                    <span class="tag-pill">
                        {{ $devAera->indicator->indicator }} ({{ $devAera->kpa->short_code }})
                    </span>
                @endforeach
            </div>
        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>
    <!-- Page 2: TEACHING PERFORMANCE -->
    <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ trim(preg_replace('/[-\s]*\d+$/', '', Auth::user()->name)) }}</h5>
                <div class="role">{{ $user->barcode }}</div>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="title">2024-2025</div>
                <div class="issued">Issued on {{ now()->format('F d, Y') }}</div>
            </div>
        </header>

        <section class="tp-section">
            <div class="tp-grid">
                <aside class="tp-left">
                    <h2 class="tp-heading">
                        <span class="t-red">Teaching and</span>
                        <span class="t-blue">Learning</span>
                    </h2>
                    <p>
                        Teaching and Learning refer to the quality and effectiveness of academic delivery, curriculum
                        design, student
                        engagement, learning outcomes, and ongoing improvements in pedagogy. It focuses on providing a
                        high-quality,
                        student-centered educational experience. Performance is measured against the following sub-KPAs.
                    </p>
                </aside>
                <div class="triangle-wrap">
                    <div class="card-body pt-2">
                        <canvas class="chartjs" id="triangle" data-height="355"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <section class="kpi">
            <table class="kpi-table">
                <thead>
                    <tr>
                        <th>Sub KPA</th>
                        <th>Target</th>
                        <th>Achieved</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @php
                            $kpaResult = indicatorCategoryAvgScore(23, 1, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Teaching Delivery  (PG/UG)</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                    <tr>
                        @php
                            $kpaResult = indicatorCategoryAvgScore(3, 1, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Teaching Management</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                    <tr>
                        @php
                            $kpaResult = indicatorCategoryAvgScore(25, 1, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Teaching Output</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                </tbody>
            </table>

            <!-- <div class="legend">
                <div class="pill pill-green">91% and Above OS</div>
                <div class="pill pill-blue">81% - 90% EE</div>
                <div class="pill pill-amber">71% - 80% ME</div>
                <div class="pill pill-orange">61% - 70% NI</div>
                <div class="pill pill-red">60% and Below BE</div>
            </div> -->
        </section>
        @php
            $noteable = getIndicatorsByScore('>=', 80, Auth::user()->employee_id, 1);
            $areaOfDevelopment = getIndicatorsByScore('<', 70, Auth::user()->employee_id, 1);
        @endphp

        <section class="achievements">
            <h3>Notable Performance Achievements</h3>
            <div class="achievement-tags">
                @foreach ($noteable as $tag)
                    <span class="tag-pill">
                        {{ $tag->indicator->indicator }} ({{ $tag->category->cat_short_code }})
                    </span>
                @endforeach
            </div>
        </section>

        <section class="achievements">
            <h3>Development Areas</h3>
            <div class="achievement-tags">
                @foreach ($areaOfDevelopment as $devArea)
                    <span class="tag-pill">
                        {{ $devArea->indicator->indicator }} ({{ $devArea->category->cat_short_code }})
                    </span>
                @endforeach
            </div>
        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>

    <!-- Page 3: Research Performance -->
    <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ trim(preg_replace('/[-\s]*\d+$/', '', Auth::user()->name)) }}</h5>
                <div class="role">{{ $user->barcode }}</div>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="title">2024-2025</div>
                <div class="issued">Issued on {{ now()->format('F d, Y') }}</div>
            </div>
        </header>

        <section class="research-intro">
            <div class="research-grid">
                <aside class="tp-left">
                    <h2 class="tp-heading">
                        <span class="t-red">Research, Innovation</span>
                        <span class="t-blue">and Commercialization</span>
                    </h2>
                    <p>
                        Research, Innovation and Commercialisation refer to the university’s efforts to produce
                        impactful
                        research, foster innovation, and translate knowledge into commercial or societal value. It
                        includes research productivity, innovation culture, applied research, and development of
                        commercially beneficial outcomes. Performance is measured against the following sub-KPAs.
                    </p>
                </aside>
                <div class="radar-wrap">
                    <div class="card-body pt-2">
                        <canvas class="chartjs" id="researchRadarChart" data-height="355"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <section class="kpi">
            <table class="kpi-table">
                <thead>
                    <tr>
                        <th>Sub KPA</th>
                        <th>Target</th>
                        <th>Achieved</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @php
                            $kpaResult = indicatorCategoryAvgScore(5, 2, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Research Productivity & Quality</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                    <tr>
                        @php
                            $kpaResult = indicatorCategoryAvgScore(32, 2, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Other Knowledge Products</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                    <tr>
                        @php
                            $kpaResult = indicatorCategoryAvgScore(6, 2, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Research Supervision at PG Level</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                    <tr>
                        @php
                            $kpaResult = indicatorCategoryAvgScore(8, 2, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Innovation & Commercialization</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                </tbody>
            </table>

            <!-- <div class="legend">
                <div class="pill pill-green">91% and Above OS</div>
                <div class="pill pill-blue">81% - 90% EE</div>
                <div class="pill pill-amber">71% - 80% ME</div>
                <div class="pill pill-orange">61% - 70% NI</div>
                <div class="pill pill-red">60% and Below BE</div>
            </div> -->
        </section>

        @php
            $noteable = getIndicatorsByScore('>=', 80, Auth::user()->employee_id, 2);
            $areaOfDevelopment = getIndicatorsByScore('<', 70, Auth::user()->employee_id, 2);
        @endphp

        <section class="achievements">
            <h3>Notable Performance Achievements</h3>
            <div class="achievement-tags">
                @foreach ($noteable as $tag)
                    <span class="tag-pill">
                        {{ $tag->indicator->indicator }} ({{ $tag->category->cat_short_code }})
                    </span>
                @endforeach
            </div>
        </section>

        <section class="achievements">
            <h3>Development Areas</h3>
            <div class="achievement-tags">
                @foreach ($areaOfDevelopment as $devArea)
                    <span class="tag-pill">
                        {{ $devArea->indicator->indicator }} ({{ $devArea->category->cat_short_code }})
                    </span>
                @endforeach
            </div>
        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>
    <!-- Page 4: INSTITUTIONAL ENGAGEMENT -->
    <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ trim(preg_replace('/[-\s]*\d+$/', '', Auth::user()->name)) }}</h5>
                <div class="role">{{ $user->barcode }}</div>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="title">2024-2025</div>
                <div class="issued">Issued on {{ now()->format('F d, Y') }}</div>
            </div>
        </header>

        <section class="tp-section">
            <div class="tp-grid">
                <aside class="tp-left">
                    <h2 class="tp-heading">
                        <span class="t-green">Institutional</span>
                        <span class="t-blue">Engagement</span>
                    </h2>
                    <p>
                        This KPA emphasizes proactive participation in departmental tasks, institutional initiatives,
                        and events that enhance
                        collaboration, visibility, and collective achievement. Institutional engagement fosters
                        teamwork, ownership, and a
                        shared sense of purpose, strengthening the institution’s culture and external partnerships.
                        Performance is measured
                        against the following sub-KPAs.
                    </p>
                </aside>
                <div class="triangle-wrap">

                    <div class="card-body pt-2">
                        <canvas class="chartjs" id="researchTriangle" data-height="355"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <section class="kpi">
            <table class="kpi-table">
                <thead>
                    <tr>
                        <th>Sub KPA</th>
                        <th>Target</th>
                        <th>Achieved</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @php
                            $kpaResult = indicatorCategoryAvgScore(27, 13, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Performance in Departmental Tasks</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                    <tr>
                        @php
                            $kpaResult = indicatorCategoryAvgScore(28, 13, Auth::user()->employee_id);
                            $avg = $kpaResult['avg'];
                            $rating = $kpaResult['rating'];
                            $color = $avg >= 90 ? '#6EA8FE' : ($avg >= 80 ? '#96e2b4' : ($avg >= 70 ? '#ffcb9a' : ($avg >=
                                60 ? '#fd7e13' : '#ff4c51'))); // this will be used for bg and bg-label
                        @endphp
                        <td>Performance in Events</td>
                        <td class="report-center">100%</td>
                        <td class="report-center">{{ $avg }}%</td>
                        <td class="achieved-cell" style="color:{{ $color }}">{{$rating}}</td>
                    </tr>
                </tbody>
            </table>

            <!-- <div class="legend">
                <div class="pill pill-green">91% and Above OS</div>
                <div class="pill pill-blue">81% - 90% EE</div>
                <div class="pill pill-amber">71% - 80% ME</div>
                <div class="pill pill-orange">61% - 70% NI</div>
                <div class="pill pill-red">60% and Below BE</div>
            </div> -->
        </section>

        @php
            $noteable = getIndicatorsByScore('>=', 80, Auth::user()->employee_id, 13);
            $areaOfDevelopment = getIndicatorsByScore('<', 70, Auth::user()->employee_id, 13);
        @endphp

        <section class="achievements">
            <h3>Notable Performance Achievements</h3>
            <div class="achievement-tags">
                @foreach ($noteable as $tag)
                    <span class="tag-pill">
                        {{ $tag->indicator->indicator }} ({{ $tag->category->cat_short_code }})
                    </span>
                @endforeach
            </div>
        </section>

        <section class="achievements">
            <h3>Development Areas</h3>
            <div class="achievement-tags">
                @foreach ($areaOfDevelopment as $devArea)
                    <span class="tag-pill">
                        {{ $devArea->indicator->indicator }} ({{ $devArea->category->cat_short_code }})
                    </span>
                @endforeach
            </div>
        </section>


        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>

    <!-- Page 6: DEVELOPMENT SUGGESTIONS -->
    <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ trim(preg_replace('/[-\s]*\d+$/', '', Auth::user()->name)) }}</h5>
                <div class="role">{{ $user->barcode }}</div>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="title">2024-2025</div>
                <div class="issued">Issued on {{ now()->format('F d, Y') }}</div>
            </div>
        </header>

        <section class="dev-suggest">
            <h2 class="tp-heading">
                <span class="t-red">Line Manager</span>
                <span class="t-blue">Remarks</span>
            </h2>

            <section class="achievements">
                <div class="achievement-tags">
                    @php
                        $remarks = lineManagerRemarksOnTasks(Auth::user()->employee_id);
                    @endphp

                    <span class="tag-pill-remarks">
                        {{ $remarks ?? 'No remarks yet' }}
                    </span>
                </div>
            </section>

        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>

    <!-- Chart.js and init -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            const chartLabels = [
                "Teaching and Learning",
                "Research, Innovation and Commercialisation",
                "Institutional Engagement"
            ];

            const shortLabels = ["T&L", "RIC", "IE"];

            var dataset1 = @json($dataset1) || [];

            // FIX: labelColors length must match labels length (3)
            const labelColors = ['#6EA8FE', '#96e2b4', '#ffcb9a', '#ffcb9a', '#ff4c51'];

            const ctx = document.getElementById("radarChart").getContext("2d");
            const gradientPink = ctx.createLinearGradient(0, 0, 0, 150);
            gradientPink.addColorStop(0, "rgba(115, 103, 240, 0.3)");
            gradientPink.addColorStop(1, "rgba(115, 103, 240, 0.5)");

            new Chart(ctx, {
                type: "radar",
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: "Achievements",
                        data: dataset1,
                        fill: true,
                        backgroundColor: gradientPink,
                        borderColor: "rgba(112, 25, 115, 1)",
                        pointBackgroundColor: labelColors,
                        pointBorderColor: labelColors,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
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
                                color: (ctx) => labelColors[ctx.index],
                                callback: (label, index) => shortLabels[index]
                            }
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });


            // --- Teaching Triangle ---
            const triCanvas = document.getElementById('triangle');
            if (triCanvas) {
                const tctx = triCanvas.getContext('2d');

                // --- Data ---
                const labels = ['TD (PG/UG)', 'TM', 'TO'];
                const dataValues = @json($datasetTeaching) || [];

                // --- Function to get color based on avg ---
                const getColor = (avg) => {
                    if (avg < 60) return '#ff4c51';      // red
                    if (avg < 70) return '#fd7e13';      // orange
                    if (avg < 80) return '#ffcb9a';      // yellow
                    if (avg < 90) return '#96e2b4';      // green
                    return '#6EA8FE';                    // blue
                };

                // --- Colors for each point ---
                const pointColors = dataValues.map(getColor);

                // --- Chart ---
                new Chart(tctx, {
                    type: 'radar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Achievements',
                            data: dataValues,
                            fill: true,
                            backgroundColor: 'rgba(115, 103, 240, 0.3)',
                            borderColor: 'rgba(112, 25, 115, 1)',
                            pointBackgroundColor: pointColors,
                            pointBorderColor: pointColors,
                            pointRadius: 5,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            r: {
                                beginAtZero: true,
                                suggestedMax: 100,
                                ticks: { display: true, color: "#666" },
                                grid: { color: "#ddd" },
                                angleLines: { color: "#ddd" },
                                pointLabels: {
                                    color: (ctx) => pointColors[ctx.index],
                                    font: { size: 10 }
                                }
                            }
                        }
                    }
                });
            }


            // --- Research Radar ---
            const researchCanvas = document.getElementById('researchRadarChart');
            if (researchCanvas) {
                const rctx = researchCanvas.getContext('2d');

                // --- Data ---
                const labels = ['RP&Q', 'KP', 'RS PG Level', 'RI&C'];
                const dataValues = @json($datasetResearch) || [];

                // --- Function to get color based on avg ---
                const getColor = (avg) => {
                    if (avg < 60) return '#ff4c51';      // red
                    if (avg < 70) return '#FFD580';      // orange
                    if (avg < 80) return '#FFF799';      // yellow
                    if (avg < 90) return '#96e2b4';      // green
                    return '#6EA8FE';                    // blue
                };

                // --- Colors for each point ---
                const pointColors = dataValues.map(getColor);

                // --- Chart ---
                new Chart(rctx, {
                    type: 'radar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Achievements',
                            data: dataValues,
                            fill: true,
                            backgroundColor: 'rgba(115, 103, 240, 0.3)',
                            borderColor: 'rgba(112, 25, 115, 1)',
                            pointBackgroundColor: pointColors,
                            pointBorderColor: pointColors,
                            pointRadius: 5,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            r: {
                                beginAtZero: true,
                                suggestedMax: 100,
                                ticks: { display: true, color: "#666" },
                                grid: { color: "#ddd" },
                                angleLines: { color: "#ddd" },
                                pointLabels: {
                                    color: (ctx) => pointColors[ctx.index],
                                    font: { size: 10 }
                                }
                            }
                        }
                    }
                });
            }

            // --- Research Triangle ---
            const researchTriangle = document.getElementById('researchTriangle');
            if (researchTriangle) {
                const tctx = researchTriangle.getContext('2d');

                // --- Data ---
                const labels = ['PID T', 'PIE'];
                const dataValues = @json($datasetInstitutional) || [];

                // --- Function to get color based on avg ---
                const getColor = (avg) => {
                    if (avg < 60) return '#ff4c51';      // red
                    if (avg < 70) return '#fd7e13';      // orange
                    if (avg < 80) return '#ffcb9a';      // yellow
                    if (avg < 90) return '#96e2b4';      // green
                    return '#6EA8FE';                    // blue
                };

                // --- Colors for each point ---
                const pointColors = dataValues.map(getColor);

                // --- Chart ---
                new Chart(tctx, {
                    type: 'radar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Achievements',
                            data: dataValues,
                            fill: true,
                            backgroundColor: 'rgba(115, 103, 240, 0.3)',
                            borderColor: 'rgba(112, 25, 115, 1)',
                            pointBackgroundColor: pointColors,
                            pointBorderColor: pointColors,
                            pointRadius: 5,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            r: {
                                beginAtZero: true,
                                suggestedMax: 100,
                                ticks: { display: true, color: "#666" },
                                grid: { color: "#ddd" },
                                angleLines: { color: "#ddd" },
                                pointLabels: {
                                    color: (ctx) => pointColors[ctx.index],
                                    font: { size: 10 }
                                }
                            }
                        }
                    }
                });
            }


            // --- Character Virtue Radar ---
            const radarCharacter = document.getElementById('radarCharacter');
            if (radarCharacter) {
                const cctx = radarCharacter.getContext('2d');

                // Function to get color based on value
                function getColor(avg) {
                    if (avg < 60) return '#ff4c51';   // red
                    if (avg < 70) return '#fd7e13';   // orange
                    if (avg < 80) return '#ffcb9a';   // yellow
                    if (avg < 90) return '#96e2b4';   // green
                    return '#6EA8FE';                 // blue
                }

                const achievedData = [88, 67, 91, 59];
                const pointColors = achievedData.map(value => getColor(value));

                new Chart(cctx, {
                    type: 'radar',
                    data: {
                        labels: ['Integrity', 'Empathy', 'Responsibility', 'Humility'],
                        datasets: [
                            {
                                label: 'Target',
                                data: [100, 100, 100, 100],
                                borderColor: '#cfd8dc',
                                backgroundColor: 'rgba(207,216,220,0.20)',
                                pointRadius: 0
                            },
                            {
                                label: 'Achieved',
                                data: achievedData,
                                borderColor: '#96e2b4',
                                backgroundColor: 'rgba(150,226,180,0.15)',
                                pointRadius: 5,
                                pointBackgroundColor: pointColors,
                                pointBorderColor: pointColors
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: true, position: 'bottom' }
                        },
                        scales: {
                            r: {
                                beginAtZero: true,
                                suggestedMax: 100,
                                ticks: { display: false },
                                grid: { color: '#e7e7e7' },
                                angleLines: { color: '#e7e7e7' },
                                pointLabels: { color: '#666', font: { size: 10 } }
                            }
                        }
                    }
                });
            }

        })();
    </script>
</body>

</html>
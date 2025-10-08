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
            min-height: 1123px;
            margin: 24px auto;
            background: var(--white);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
            position: relative;
            overflow: hidden
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 24px 30px 14px;
            background: linear-gradient(180deg, #666, #555 40%, #4d4d4d);
            color: var(--white);
            border-bottom: 6px solid #bfbfbf;
        }

        .identity .name {
            font-family: "Montserrat", sans-serif;
            font-weight: 900;
            margin: 0;
            letter-spacing: .2px;
            font-size: 28px;
        }

        .identity .role,
        .identity .dept {
            opacity: .9
        }

        .identity .role {
            margin-top: 2px
        }

        .report-title {
            text-align: right;
        }

        .report-title .title {
            font-family: "Montserrat", sans-serif;
            font-weight: 500;
            font-size: 20px;
            text-shadow: 0 2px 0 rgba(0, 0, 0, .25);
        }

        .report-title .year {
            font-family: "Montserrat", sans-serif;
            font-weight: 500;
            font-size: 20px;
            line-height: 1;
            color: #111;
            text-shadow: 0 1px 0 #fff, 0 -1px 0 #fff, 1px 0 0 #fff, -1px 0 0 #fff, 0 2px 6px rgba(0, 0, 0, .25);
        }

        .report-title .issued {
            font-size: 14px;
            opacity: .85
        }

        .intro {
            padding: 18px 28px
        }

        .intro p {
            margin: 0 0 18px;
            line-height: 1.55
        }

        .grid-two {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            align-items: start
        }

        .overall-heading {
            margin: 0 0 8px
        }

        .overall-heading .overall {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            letter-spacing: .5px;
            font-size: 30px;
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
            font-size: 30px;
            margin-top: -6px;
            background: linear-gradient(180deg, #8e2de2, #7a35ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent
        }

        .overall-block p {
            margin: 8px 0 0;
            font-size: 13px;
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
            padding: 10px 18px 0
        }

        .kpi-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 0 0 2px #c8c8c8 inset;
            table-layout: fixed
        }

        .kpi-table th,
        .kpi-table td {
            border: 1px solid #bdbdbd;
            padding: 12px 12px;
            font-size: 13px;
            background: #fff
        }

        .kpi-table thead th {
            background: #e9e9e9;
            font-weight: 700
        }

        .kpi-table td:nth-child(2) {
            width: 48px;
            background: #efefef
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
            padding: 6px 10px;
            border-radius: 18px;
            font-size: 12px;
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
            padding: 8px 18px 24px
        }

        .achievements h3 {
            margin: 12px 0;
            font-family: "Montserrat";
            font-weight: 800
        }

        .cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .card {
            background: #efefef;
            padding: 14px;
            border-radius: 14px
        }

        .card-title {
            font-weight: 800;
            margin-bottom: 8px
        }

        .subcard {
            background: #fff;
            border-radius: 14px;
            padding: 12px;
            box-shadow: 0 0 0 2px #e0e0e0 inset;
            margin-bottom: 10px
        }

        .sub-title {
            font-weight: 700;
            margin-bottom: 6px
        }

        .subcard ol {
            margin: 0;
            padding-left: 18px
        }

        .subcard li {
            margin: 4px 0
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
            padding: 18px 28px
        }

        .tp-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            align-items: start
        }

        .tp-heading {
            margin: 0 0 10px
        }

        .tp-heading .t-red {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #ff2d2d;
            font-size: 30px
        }

        .tp-heading .t-blue {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #2f86ff;
            font-size: 30px;
            margin-top: -6px
        }

        .tp-heading .t-green {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #00c853;
            font-size: 30px
        }

        .tp-left p {
            margin: 8px 0 0;
            font-size: 13px;
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
            font-size: 12px;
            margin-top: 8px
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
            padding: 22px 28px 34px
        }

        .dev-heading {
            font-family: "Montserrat";
            font-weight: 900;
            font-size: 30px;
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
            gap: 24px;
            margin-top: 18px
        }

        .dev-card {
            background: transparent;
            padding: 0
        }

        .dev-pill {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 9999px;
            font-weight: 800;
            font-family: "Montserrat";
            margin-bottom: 10px;
            color: #0d0d0d;
            box-shadow: 0 1px 0 rgba(0, 0, 0, .05) inset
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
            font-size: 14px;
            color: #222;
            max-width: 330px
        }

        /* Research Performance */
        .research-intro {
            padding: 18px 28px
        }

        .research-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            align-items: start
        }

        .research-heading {
            margin: 0 0 10px
        }

        .research-heading .research {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            font-size: 30px;
            color: #2a7cff
        }

        .research-heading .perf {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            font-size: 30px;
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
            margin: 16px 18px 80px;
            border: 1px solid #bdbdbd
        }

        .two-col-table .t-header {
            background: #e1e1e1;
            font-weight: 800;
            padding: 10px 12px;
            border-bottom: 1px solid #bdbdbd
        }

        .two-col-table .t-row {
            padding: 8px 12px;
            border-top: 1px solid #d0d0d0
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
            font-size: 12px;
            color: #3d3d3d;
            padding: 8px 0;
            background: #e9e9e9;
            border-top: 1px solid #d1d1d1
        }

        /* Character Mastery */
        .char-intro {
            padding: 18px 28px
        }

        .char-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            align-items: start
        }

        .char-heading {
            margin: 0 0 10px
        }

        .char-heading .char-red {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #ff2d2d;
            font-size: 30px
        }

        .char-heading .char-blue {
            display: block;
            font-family: "Montserrat";
            font-weight: 900;
            color: #2f86ff;
            font-size: 30px;
            margin-top: -6px
        }

        .char-left p {
            margin: 8px 0 0;
            font-size: 13px;
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
                page-break-inside: avoid
            }

            .A4:last-child {
                break-after: auto;
                page-break-after: auto
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
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="year">2024-2025</div>
                <div class="issued">Issued on October 07, 2025</div>
            </div>
        </header>

        <section class="intro">
            <p>
                This Performance Insight Report provides a comprehensive review of your performance as
                <em>Associate Professor</em> for the period of 2024-2025. The report covers key areas essential to your
                role including: Teaching, Research and Institutional Engagement. By analyzing achievements, and
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
                        <td>Teaching and Learning</td>
                        <td>100%</td>
                        <td>90%</td>
                        <td class="achieved-cell" style="background-color:#6EA8FE">OS</td>
                    </tr>
                    <tr>
                        <td>Research, Innovation and Commercialisation</td>
                        <td>100%</td>
                        <td>85%</td>
                        <td class=" achieved-cell" style="background-color:#71C497">EE</td>
                    </tr>
                    <tr>
                        <td>Institutional Engagement</td>
                        <td>100%</td>
                        <td>80%</td>
                        <td class="achieved-cell" style="background-color:#71C497">EE</td>
                    </tr>
                    <tr>
                        <td>Character Virtue</td>
                        <td>100%</td>
                        <td>75%</td>
                        <td class="achieved-cell" style="background-color:#FFF799">ME</td>
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
            <div class="cards">
                <div class="card">
                    <div class="subcard">
                        <div class="sub-title">Teaching</div>
                        <ol>
                            <li>Student Satisfaction.</li>
                            <li>Classes Held.</li>
                            <li>Student Attendance.</li>
                        </ol>
                    </div>
                    <div class="subcard">
                        <div class="sub-title">Engagement</div>
                        <ol>
                            <li>Line Manager Satisfaction.</li>
                            <li>Achievement Of Tasks.</li>
                            <li>Event Performance Feedback.</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="subcard">
                        <div class="sub-title">Research</div>
                        <ol>
                            <li>Research Publications.</li>
                            <li>Scholar's Satisfaction.</li>
                            <li>Research Productivity of PG Students.</li>
                        </ol>
                    </div>
                    <div class="subcard">
                        <div class="sub-title">Character Virtue</div>
                        <ol>
                            <li>Honesty & Integrity.</li>
                            <li>Responsibility & Accountability.</li>
                            <li>Empathy & Compassion.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>
    <!-- Page 2: TEACHING PERFORMANCE -->
    <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ Str::before($user->name, '-') }}</h5>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="year">2024-2025</div>
                <div class="issued">Issued on October 07, 2025</div>
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
                        Teaching performance is evaluated through student success rates, feedback, teaching compliance,
                        and the adoption of innovative practices that engage and motivate students effectively.
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
                        <td>Teaching Delivery</td>
                        <td>100%</td>
                        <td>91%</td>
                        <td class="achieved-cell" style="background-color:#6EA8FE">OS</td>
                    </tr>
                    <tr>
                        <td>Teaching Management</td>
                        <td>100%</td>
                        <td>78%</td>
                        <td class="achieved-cell" style="background-color:#FFF799">ME</td>
                    </tr>
                    <tr>
                        <td>Teaching Output</td>
                        <td>100%</td>
                        <td>56%</td>
                        <td class="achieved-cell " style="background-color:#F28B94">BE</td>
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

        <section class="two-col-table">
            <div class="t-header">Key Strengths</div>
            <div class="t-header">Development Areas</div>
            <div class="t-row">Student Teaching Satisfaction</div>
            <div class="t-row">Student Attendance</div>
            <div class="t-row">Classes Held</div>
            <div class="t-row">Submission of Exam Results</div>
            <div class="t-row">Student Pass Percentage</div>
            <div class="t-row">Improvement in Student Performance</div>
        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>

    <!-- Page 3: Research Performance -->
    <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ Str::before($user->name, '-') }}</h5>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="year">2024-2025</div>
                <div class="issued">Issued on October 07, 2025</div>
            </div>
        </header>

        <section class="research-intro">
            <div class="research-grid">
                <aside class="research-left">
                    <h2 class="research-heading">
                        <span class="research">Research</span>
                        <span class="perf"></span>
                    </h2>
                    <p>
                        Research performance is assessed through a combination of publication quantity and quality,
                        funding success, research impact (citations), and collaboration with external organizations,
                        including industry.
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
                        <td>Research Productivity & Quality</td>
                        <td>100%</td>
                        <td>95%</td>
                        <td class="achieved-cell" style="background-color:#6EA8FE">OS</td>
                    </tr>
                    <tr>
                        <td>Knowledge Products</td>
                        <td>100%</td>
                        <td>85%</td>
                        <td class="achieved-cell" style="background-color:#71C497">EE</td>
                    </tr>
                    <tr>
                        <td>Research Supervision at PG Level</td>
                        <td>100%</td>
                        <td>83%</td>
                        <td class="achieved-cell" style="background-color:#71C497">EE</td>
                    </tr>
                    <tr>
                        <td>Assigned Tasks</td>
                        <td>100%</td>
                        <td>81%</td>
                        <td class="achieved-cell" style="background-color:#71C497">EE</td>
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

        <section class="two-col-table">
            <div class="t-header">Key Strenghts</div>
            <div class="t-header">Development Areas</div>
            <div class="t-row">Research Publications</div>
            <div class="t-row">Research Productivity of PG Students</div>
            <div class="t-row">Knowledge Products</div>
            <div class="t-row">Assigned Tasks</div>
            <div class="t-row">Scholar's Satisfaction</div>
            <div class="t-row"></div>
        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>
    <!-- Page 4: INSTITUTIONAL ENGAGEMENT -->
    <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ Str::before($user->name, '-') }}</h5>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="year">2024-2025</div>
                <div class="issued">Issued on October 07, 2025</div>
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
                        Institutional engagement is evaluated based on contributions to academic governance, curriculum
                        design, strategic decision-making, and maintaining relationships with industry and academic
                        partners.
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
                        <td>Performance in Tasks</td>
                        <td>100%</td>
                        <td>95%</td>
                        <td class="achieved-cell" style="background-color:#6EA8FE">OS</td>
                    </tr>
                    <tr>
                        <td>Performance in Events</td>
                        <td>100%</td>
                        <td>70%</td>
                        <td class="achieved-cell" style="background-color:#FFF799">ME</td>
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

        <section class="two-col-table">
            <div class="t-header">Key Strenghts</div>
            <div class="t-header">Development Areas</div>
            <div class="t-row">Line Manager Satisfaction Rating</div>
            <div class="t-row">Event Performance</div>
            <div class="t-row">Achievement of Tasks Status</div>
            <div class="t-row"></div>
        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>
    <!-- Page 5: CHARACTER MASTERY -->
    <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ Str::before($user->name, '-') }}</h5>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="year">2024-2025</div>
                <div class="issued">Issued on October 07, 2025</div>
            </div>
        </header>

        <section class="char-intro">
            <div class="char-grid">
                <aside class="char-left">
                    <h2 class="char-heading">
                        <span class="char-red">Character</span>
                        <span class="char-blue">Virtue</span>
                    </h2>
                    <p>
                        Character traits performance focuses on evaluating an individual's ethical conduct, emotional
                        intelligence, sense of responsibility, and effective use of resources, fostering a positive and
                        productive professional environment.
                    </p>
                </aside>
                <div class="diamond-wrap">
                    <div class="card-body pt-2">
                        <canvas class="chartjs" id="radarCharacter" data-height="355"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <section class="kpi">
            <table class="kpi-table">
                <thead>
                    <tr>
                        <th>Sub KPA</th>
                        <th></th>
                        <th>Target</th>
                        <th>Achieved</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Integrity</td>
                        <td>100%</td>
                        <td>88%</td>
                        <td class="achieved-cell" style="background-color:#71C497">EE</td>
                    </tr>
                    <tr>
                        <td>Empathy</td>
                        <td>100%</td>
                        <td>67%</td>
                        <td class="achieved-cell" style="background-color:#FFD580">NI</td>
                    </tr>
                    <tr>
                        <td>Responsibility</td>
                        <td>100%</td>
                        <td>91%</td>
                        <td class="achieved-cell" style="background-color:#6EA8FE">OS</td>
                    </tr>
                    <tr>
                        <td>Humility</td>
                        <td>100%</td>
                        <td>59%</td>
                        <td class="achieved-cell" style="background-color:#F28B94">BE</td>
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

        <section class="two-col-table">
            <div class="t-header">Key Strenghts</div>
            <div class="t-header">Development Areas</div>
            <div class="t-row">Responsibility</div>
            <div class="t-row">Empathy</div>
            <div class="t-row">Integrity</div>
            <div class="t-row">Humility</div>
        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div>

    <!-- Page 6: DEVELOPMENT SUGGESTIONS -->
    <!-- <div class="page A4">
        <header class="page-header">
            <div class="identity">
                <h5 class="name">{{ Str::before($user->name, '-') }}</h5>
                <div class="role">{{ $user->job_title }}</div>
                <div class="dept">{{ $user->department }}</div>
            </div>
            <div class="report-title">
                <div class="title">Performance Insight Report</div>
                <div class="year">2023-2024</div>
                <div class="issued">Issued on November 02, 2024</div>
            </div>
        </header>

        <section class="dev-suggest">
            <div class="dev-heading">
                <span class="dev">DEVELOPMENT</span>
                <span class="sugg">SUGGESTIONS</span>
            </div>

            <div class="dev-grid">
                <div class="dev-card">
                    <div class="dev-pill green">Stewardship</div>
                    <p>
                        To improve stewardship, you should focus on taking greater responsibility for both individual
                        and team outcomes. This includes being proactive in identifying challenges, offering solutions,
                        and ensuring that tasks are completed efficiently. Developing stronger communication skills and
                        demonstrating accountability in decision-making will help build trust and foster a culture of
                        shared ownership within the team.
                    </p>
                </div>
                <div class="dev-card">
                    <div class="dev-pill blue">Industrial Research Engagement</div>
                    <p>
                        For industrial research engagement, you should actively seek opportunities to collaborate with
                        industry partners and understand current industry challenges. Attending relevant conferences,
                        workshops, and networking events can open doors to partnerships that benefit both academic and
                        industrial growth. Applying research findings to practical industry problems will also bridge
                        the gap between theory and practice, enhancing the value of your work.
                    </p>
                </div>
                <div class="dev-card">
                    <div class="dev-pill magenta">Teaching Innovation</div>
                    <p>
                        In order to innovate in teaching, you should explore new teaching methods, such as integrating
                        technology or using interactive, student-centered approaches. Experimenting with flipped
                        classrooms, gamification, or real-time student feedback can lead to more engaging and effective
                        learning experiences. Regularly reflecting on your teaching practices and staying updated on
                        educational trends will help adapt to evolving student needs and improve course delivery.
                    </p>
                </div>
                <div class="dev-card">
                    <div class="dev-pill orange">Research Output</div>
                    <p>
                        To increase your research output, you should set clear, realistic goals for publishing and
                        dedicate time for focused writing. Developing a structured approach to research, such as setting
                        deadlines for each phase, can help maintain consistent progress. Collaborating with colleagues
                        and seeking mentorship can also help improve the quality of work, streamline the publication
                        process, and increase the chances of having research published in high-impact journals.
                    </p>
                </div>
            </div>
        </section>

        <footer class="page-footer">Performance Insight Report of {{ Str::before($user->name, '-') }}</footer>
    </div> -->

    <!-- Chart.js and init -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            const chartLabels = [
                "Teaching and Learning",
                "Research, Innovation and Commercialisation",
                "Institutional Engagement",
                "Character Virtue"
            ];
            const shortLabels = ["T&L", "RIC", "IE", "CV"];
            const dataset1 = [90, 85, 80, 75];
            const labelColors = ['#6EA8FE', '#71C497', '#FFD580', '#FFF799', '#F28B94'];

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
                const labels = ['Teaching Delivery', 'Teaching Management', 'Teaching Output'];
                const dataValues = [91, 78, 56];

                // --- Function to get color based on avg ---
                const getColor = (avg) => {
                    if (avg < 60) return '#F28B94';      // red
                    if (avg < 70) return '#FFD580';      // orange
                    if (avg < 80) return '#FFF799';      // yellow
                    if (avg < 90) return '#71C497';      // green
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
                const labels = ['RP&Q', 'KP', 'RS PG Level', 'Assigned Tasks'];
                const dataValues = [95, 85, 83, 81];

                // --- Function to get color based on avg ---
                const getColor = (avg) => {
                    if (avg < 60) return '#F28B94';      // red
                    if (avg < 70) return '#FFD580';      // orange
                    if (avg < 80) return '#FFF799';      // yellow
                    if (avg < 90) return '#71C497';      // green
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
                const labels = ['Performance in Tasks', 'Performance in Events'];
                const dataValues = [95, 70];

                // --- Function to get color based on avg ---
                const getColor = (avg) => {
                    if (avg < 60) return '#F28B94';      // red
                    if (avg < 70) return '#FFD580';      // orange
                    if (avg < 80) return '#FFF799';      // yellow
                    if (avg < 90) return '#71C497';      // green
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
                    if (avg < 60) return '#FF4C4C';   // red
                    if (avg < 70) return '#FFD580';   // orange
                    if (avg < 80) return '#FFD700';   // yellow
                    if (avg < 90) return '#6cc04a';   // green
                    return '#32b6e6';                 // blue
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
                                borderColor: '#6cc04a',
                                backgroundColor: 'rgba(108,192,74,0.15)',
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
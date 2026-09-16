@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4">

        {{-- ========================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================================================= --}}

        <div class="goal-page-header mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="header-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            Line Manager Feedback
                        </h3>

                        <p class="mb-0 text-muted">
                            View your Line Manager feedback through the Virtue Mirror analysis.
                        </p>

                    </div>

                </div>

                <div class="d-flex align-items-center gap-2">

                    <span class="goal-id-badge">

                        <i class="fas fa-user-check me-1"></i>

                        Line Manager Review

                    </span>

                    <a href="{{ url()->previous() }}"
                       class="btn btn-light border shadow-sm px-4">

                        <i class="fas fa-arrow-left me-2"></i>

                        Back

                    </a>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- NO FEEDBACK --}}
        {{-- ========================================================= --}}

        @if(!$lineManagerFeedback)

            <div class="section-card">

                <div class="section-body">

                    <div class="empty-state">

                        <div class="empty-icon">

                            <i class="fas fa-comment-slash"></i>

                        </div>

                        <h5 class="fw-bold mb-2">
                            No Line Manager Feedback Available
                        </h5>

                        <p class="mb-0 text-muted">
                            Approved Line Manager feedback has not been submitted yet.
                        </p>

                    </div>

                </div>

            </div>

        @else

            {{-- ========================================================= --}}
            {{-- MAIN CONTENT --}}
            {{-- ========================================================= --}}

            <div class="row g-4">

                {{-- ===================================================== --}}
                {{-- LEFT : SPIDER CHART --}}
                {{-- ===================================================== --}}

                <div class="col-lg-8">

                    <div class="section-card h-100">

                        {{-- ============================================= --}}
                        {{-- SECTION HEADER --}}
                        {{-- ============================================= --}}

                        <div class="section-header">

                            <div class="section-title">

                                <div class="section-number">

                                    <i class="fas fa-chart-radar"></i>

                                </div>

                                <div>

                                    <h5 class="mb-1 fw-bold">
                                        Virtue Mirror
                                    </h5>

                                    <small>
                                        Line Manager feedback across key virtue competencies.
                                    </small>

                                </div>

                            </div>

                        </div>

                        {{-- ============================================= --}}
                        {{-- CHART BODY --}}
                        {{-- ============================================= --}}

                        <div class="section-body">

                            <div class="chart-wrapper">

                                <canvas id="virtueChart"></canvas>

                            </div>

                            <div class="chart-scale-note">

                                <i class="fas fa-info-circle me-2"></i>

                                Scores are displayed on a 0–100 scale.

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===================================================== --}}
                {{-- RIGHT : VIRTUE SCORES --}}
                {{-- ===================================================== --}}

                <div class="col-lg-4">

                    <div class="section-card h-100">

                        <div class="section-header">

                            <div class="section-title">

                                <div class="section-number">

                                    <i class="fas fa-star"></i>

                                </div>

                                <div>

                                    <h5 class="mb-1 fw-bold">
                                        Virtue Scores
                                    </h5>

                                    <small>
                                        Individual feedback scores.
                                    </small>

                                </div>

                            </div>

                        </div>

                        <div class="section-body">

                            <div class="virtue-list">

                                @foreach($virtueScores as $virtue => $score)

                                    @php

                                        /*
                                        |--------------------------------------------------------------------------
                                        | Scores are already on 0-100 scale
                                        |--------------------------------------------------------------------------
                                        */

                                        $score100 = $score !== null
                                            ? round((float) $score, 2)
                                            : null;

                                    @endphp

                                    <div class="virtue-item">

                                        <div class="virtue-left">

                                            <div class="virtue-icon">

                                                <i class="fas fa-star"></i>

                                            </div>

                                            <div>

                                                <div class="virtue-name">
                                                    {{ $virtue }}
                                                </div>

                                                <small class="virtue-help">
                                                    Line Manager Assessment
                                                </small>

                                            </div>

                                        </div>

                                        <div class="virtue-score">

                                            @if($score100 !== null)

                                                {{ number_format($score100, 2) }}

                                                <span>/100</span>

                                            @else

                                                <span class="pending-score">
                                                    —
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                            {{-- ========================================= --}}
                            {{-- OVERALL --}}
                            {{-- ========================================= --}}

                            <div class="overall-score-card">

                                <div>

                                    <div class="overall-title">
                                        Overall Feedback Score
                                    </div>

                                    <small>
                                        Average of all assessed virtues
                                    </small>

                                </div>

                                <div class="overall-score">

                                    @if($feedbackScore100 !== null)

                                        {{ number_format((float) $feedbackScore100, 2) }}

                                        <span>/100</span>

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        @endif

    </div>
    {{-- ========================================================= --}}
    {{-- STYLES --}}
    {{-- ========================================================= --}}

    <style>

        :root {

            --pms-primary: #1f4e79;

            --pms-primary-dark: #173a5c;

            --pms-light: #f4f7fb;

            --pms-border: #e4e9f0;

            --pms-text: #253449;

            --pms-muted: #718096;

        }

        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .goal-page-header {

            background: linear-gradient(
                135deg,
                #ffffff 0%,
                #f5f8fc 100%
            );

            border: 1px solid var(--pms-border);

            border-radius: 16px;

            padding: 22px 26px;

            box-shadow:
                0 4px 18px rgba(31, 78, 121, 0.06);
        }

        .header-icon {

            width: 48px;

            height: 48px;

            border-radius: 12px;

            background: var(--pms-primary);

            color: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;

            box-shadow:
                0 6px 14px rgba(31, 78, 121, 0.22);
        }

        .goal-id-badge {

            display: inline-flex;

            align-items: center;

            background: #eaf2f9;

            color: var(--pms-primary);

            border: 1px solid #d6e3ef;

            border-radius: 30px;

            padding: 8px 14px;

            font-size: 13px;

            font-weight: 700;

        }

        /* =========================================================
           SECTION CARD
        ========================================================= */

        .section-card {

            background: #fff;

            border: 1px solid var(--pms-border);

            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 4px 18px rgba(31, 78, 121, 0.06);
        }

        .section-header {

            background: #f8fafc;

            border-bottom: 1px solid var(--pms-border);

            padding: 18px 22px;
        }

        .section-title {

            display: flex;

            align-items: center;

            gap: 14px;
        }

        .section-title small {

            color: var(--pms-muted);

            font-size: 12px;
        }

        .section-number {

            width: 36px;

            height: 36px;

            border-radius: 10px;

            background: var(--pms-primary);

            color: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: 700;

            flex-shrink: 0;
        }

        .section-body {

            padding: 24px;
        }

        /* =========================================================
           CHART
        ========================================================= */

        .chart-wrapper {

            position: relative;

            width: 100%;

            height: 470px;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .chart-wrapper canvas {

            max-width: 100%;

            max-height: 100%;
        }

        .chart-scale-note {

            margin-top: 12px;

            background: #f4f7fb;

            border: 1px solid #e1e8f0;

            color: var(--pms-muted);

            border-radius: 10px;

            padding: 10px 13px;

            font-size: 12px;
        }

        .chart-scale-note i {

            color: var(--pms-primary);
        }

        /* =========================================================
           VIRTUE LIST
        ========================================================= */

        .virtue-list {

            display: flex;

            flex-direction: column;
        }

        .virtue-item {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;

            padding: 14px 0;

            border-bottom: 1px solid #edf1f5;
        }

        .virtue-item:last-child {

            border-bottom: 0;
        }

        .virtue-left {

            display: flex;

            align-items: center;

            gap: 11px;

            min-width: 0;
        }

        .virtue-icon {

            width: 36px;

            height: 36px;

            min-width: 36px;

            border-radius: 10px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 12px;
        }

        .virtue-name {

            color: var(--pms-text);

            font-size: 11px;

            font-weight: 700;

            line-height: 1.35;
        }

        .virtue-help {

            display: block;

            color: var(--pms-muted);

            font-size: 9px;

            margin-top: 2px;
        }

        .virtue-score {

            color: var(--pms-primary);

            font-size: 14px;

            font-weight: 800;

            white-space: nowrap;
        }

        .virtue-score span {

            color: var(--pms-muted);

            font-size: 8px;

            font-weight: 600;
        }

        .pending-score {

            color: #adb5bd !important;
        }

        /* =========================================================
           OVERALL SCORE
        ========================================================= */

        .overall-score-card {

            margin-top: 15px;

            padding: 16px;

            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #f5f8fc,
                #eef4fa
            );

            border: 1px solid #dce6f0;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;
        }

        .overall-title {

            color: var(--pms-text);

            font-size: 12px;

            font-weight: 800;
        }

        .overall-score-card small {

            color: var(--pms-muted);

            font-size: 9px;
        }

        .overall-score {

            color: var(--pms-primary);

            font-size: 21px;

            font-weight: 800;

            white-space: nowrap;
        }

        .overall-score span {

            color: var(--pms-muted);

            font-size: 9px;

            font-weight: 600;
        }

        /* =========================================================
           DETAILS
        ========================================================= */

        .detail-card {

            height: 100%;

            display: flex;

            align-items: center;

            gap: 12px;

            background: #fafcfe;

            border: 1px solid #e6ebf0;

            border-radius: 11px;

            padding: 13px 14px;
        }

        .detail-icon {

            width: 38px;

            height: 38px;

            min-width: 38px;

            border-radius: 10px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 12px;
        }

        .detail-icon.success {

            background: #e7f6ed;

            color: #198754;
        }

        .detail-card small {

            display: block;

            color: var(--pms-muted);

            font-size: 9px;

            margin-bottom: 3px;
        }

        .detail-card strong {

            display: block;

            color: var(--pms-text);

            font-size: 11px;

            font-weight: 700;
        }

        .status-approved {

            color: #198754 !important;
        }

        /* =========================================================
           UPDATE NOTE
        ========================================================= */

        .update-note-card {

            background: linear-gradient(
                135deg,
                #f5f8fc,
                #ffffff
            );

            border: 1px solid #dce6f0;

            border-radius: 14px;

            padding: 18px 20px;

            display: flex;

            align-items: flex-start;

            gap: 13px;

            box-shadow:
                0 4px 15px rgba(31, 78, 121, .04);
        }

        .update-note-icon {

            width: 40px;

            height: 40px;

            min-width: 40px;

            border-radius: 10px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .update-note-card h6 {

            color: var(--pms-text);
        }

        .update-note-card p {

            color: var(--pms-muted);

            font-size: 12px;

            line-height: 1.6;
        }

        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty-state {

            text-align: center;

            padding: 65px 20px;
        }

        .empty-icon {

            width: 55px;

            height: 55px;

            margin: 0 auto 12px;

            border-radius: 12px;

            background: #e8f1fa;

            color: var(--pms-primary);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;
        }

        .empty-state h5 {

            color: var(--pms-text);
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 991px) {

            .chart-wrapper {

                height: 420px;
            }

        }

        @media (max-width: 768px) {

            .goal-page-header {

                padding: 18px;
            }

            .goal-page-header .btn {

                width: 100%;
            }

            .section-body {

                padding: 18px;
            }

            .section-header {

                padding: 16px 18px;
            }

            .chart-wrapper {

                height: 360px;

                padding: 5px;
            }

            .goal-id-badge {

                display: none;
            }

            .update-note-card {

                padding: 16px;
            }

        }

        @media (max-width: 480px) {

            .chart-wrapper {

                height: 320px;
            }

            .virtue-name {

                font-size: 10px;
            }

            .virtue-score {

                font-size: 12px;
            }

            .section-title small {

                font-size: 10px;
            }

        }

    </style>

@endsection

<script>
(function () {

    function drawVirtueChart() {

        const canvas = document.getElementById('virtueChart');

        if (!canvas) {
            console.error('virtueChart canvas not found.');
            return;
        }

        const ctx = canvas.getContext('2d');

        /*
        |--------------------------------------------------------------------------
        | Values are already 0-100
        |--------------------------------------------------------------------------
        */

        const values = [
            Number(@json($virtueScores['Honesty & Integrity'] ?? 0)),
            Number(@json($virtueScores['Responsibility & Accountability'] ?? 0)),
            Number(@json($virtueScores['Humility & Service'] ?? 0)),
            Number(@json($virtueScores['Empathy & Compassion'] ?? 0)),
            Number(@json($virtueScores['Courage & Drive'] ?? 0))
        ];

        const labels = [
            ['Honesty &', 'Integrity'],
            ['Responsibility &', 'Accountability'],
            ['Humility &', 'Service'],
            ['Empathy &', 'Compassion'],
            ['Courage &', 'Drive']
        ];

        let points = [];

        let hoveredPoint = -1;

        /*
        |--------------------------------------------------------------------------
        | Canvas Size
        |--------------------------------------------------------------------------
        */

        function resizeCanvas() {

            const parent = canvas.parentElement;

            const width = parent.clientWidth;
            const height = parent.clientHeight;

            if (!width || !height) {
                return;
            }

            const ratio = window.devicePixelRatio || 1;

            canvas.width = width * ratio;
            canvas.height = height * ratio;

            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';

            ctx.setTransform(
                ratio,
                0,
                0,
                ratio,
                0,
                0
            );

            drawRadar(width, height);
        }

        /*
        |--------------------------------------------------------------------------
        | Draw Radar
        |--------------------------------------------------------------------------
        */

        function drawRadar(width, height) {

            ctx.clearRect(
                0,
                0,
                width,
                height
            );

            const centerX = width / 2;

            const centerY = height / 2;

            const radius =
                Math.min(width, height) * 0.31;

            const totalPoints = values.length;

            const angleStep =
                (Math.PI * 2) / totalPoints;

            const startAngle =
                -Math.PI / 2;

            /*
            |--------------------------------------------------------------------------
            | Reset Point Positions
            |--------------------------------------------------------------------------
            */

            points = [];

            /*
            |--------------------------------------------------------------------------
            | Background Rings
            |--------------------------------------------------------------------------
            */

            for (let ring = 1; ring <= 5; ring++) {

                const ringRadius =
                    radius * (ring / 5);

                ctx.beginPath();

                for (let i = 0; i < totalPoints; i++) {

                    const angle =
                        startAngle +
                        (i * angleStep);

                    const x =
                        centerX +
                        Math.cos(angle) * ringRadius;

                    const y =
                        centerY +
                        Math.sin(angle) * ringRadius;

                    if (i === 0) {

                        ctx.moveTo(x, y);

                    } else {

                        ctx.lineTo(x, y);

                    }
                }

                ctx.closePath();

                ctx.strokeStyle =
                    '#dce4ec';

                ctx.lineWidth = 1;

                ctx.stroke();
            }

            /*
            |--------------------------------------------------------------------------
            | Scale Values
            |--------------------------------------------------------------------------
            */

            ctx.fillStyle =
                '#718096';

            ctx.font =
                '9px Arial';

            ctx.textAlign =
                'left';

            ctx.textBaseline =
                'middle';

            for (let i = 1; i <= 5; i++) {

                const score =
                    i * 20;

                const y =
                    centerY -
                    (radius * (i / 5));

                ctx.fillText(
                    score,
                    centerX + 6,
                    y
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Axis Lines
            |--------------------------------------------------------------------------
            */

            for (let i = 0; i < totalPoints; i++) {

                const angle =
                    startAngle +
                    (i * angleStep);

                const x =
                    centerX +
                    Math.cos(angle) * radius;

                const y =
                    centerY +
                    Math.sin(angle) * radius;

                ctx.beginPath();

                ctx.moveTo(
                    centerX,
                    centerY
                );

                ctx.lineTo(
                    x,
                    y
                );

                ctx.strokeStyle =
                    '#dce4ec';

                ctx.lineWidth = 1;

                ctx.stroke();
            }

            /*
            |--------------------------------------------------------------------------
            | Data Polygon
            |--------------------------------------------------------------------------
            */

            ctx.beginPath();

            values.forEach(function (value, index) {

                const safeValue =
                    Math.max(
                        0,
                        Math.min(
                            100,
                            value
                        )
                    );

                const angle =
                    startAngle +
                    (index * angleStep);

                const pointRadius =
                    radius *
                    (safeValue / 100);

                const x =
                    centerX +
                    Math.cos(angle) *
                    pointRadius;

                const y =
                    centerY +
                    Math.sin(angle) *
                    pointRadius;

                if (index === 0) {

                    ctx.moveTo(
                        x,
                        y
                    );

                } else {

                    ctx.lineTo(
                        x,
                        y
                    );

                }

                /*
                |--------------------------------------------------------------------------
                | Store Point
                |--------------------------------------------------------------------------
                */

                points.push({
                    x: x,
                    y: y,
                    value: value,
                    label: labels[index]
                });

            });

            ctx.closePath();

            ctx.fillStyle =
                'rgba(31, 78, 121, 0.14)';

            ctx.fill();

            ctx.strokeStyle =
                '#1f4e79';

            ctx.lineWidth = 2;

            ctx.stroke();

            /*
            |--------------------------------------------------------------------------
            | Points
            |--------------------------------------------------------------------------
            */

            points.forEach(function (point, index) {

                const pointSize =
                    hoveredPoint === index
                        ? 7
                        : 5;

                /*
                | Outer white border
                */

                ctx.beginPath();

                ctx.arc(
                    point.x,
                    point.y,
                    pointSize + 2,
                    0,
                    Math.PI * 2
                );

                ctx.fillStyle =
                    '#ffffff';

                ctx.fill();

                /*
                | Point
                */

                ctx.beginPath();

                ctx.arc(
                    point.x,
                    point.y,
                    pointSize,
                    0,
                    Math.PI * 2
                );

                ctx.fillStyle =
                    '#1f4e79';

                ctx.fill();

                /*
                |--------------------------------------------------------------------------
                | Hover Value
                |--------------------------------------------------------------------------
                */

                if (hoveredPoint === index) {

                    drawTooltip(
                        point.x,
                        point.y,
                        point.value
                    );

                }

            });

            /*
            |--------------------------------------------------------------------------
            | Axis Labels
            |--------------------------------------------------------------------------
            */

            labels.forEach(function (label, index) {

                const angle =
                    startAngle +
                    (index * angleStep);

                const labelRadius =
                    radius + 48;

                const x =
                    centerX +
                    Math.cos(angle) *
                    labelRadius;

                const y =
                    centerY +
                    Math.sin(angle) *
                    labelRadius;

                ctx.fillStyle =
                    '#253449';

                ctx.font =
                    '600 10px Arial';

                ctx.textAlign =
                    'center';

                ctx.textBaseline =
                    'middle';

                label.forEach(function (
                    line,
                    lineIndex
                ) {

                    ctx.fillText(
                        line,
                        x,
                        y +
                        ((lineIndex - 0.5) * 13)
                    );

                });

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Tooltip
        |--------------------------------------------------------------------------
        */

        function drawTooltip(
            x,
            y,
            value
        ) {

            const text =
                Number(value).toFixed(2) +
                ' / 100';

            ctx.font =
                'bold 10px Arial';

            const textWidth =
                ctx.measureText(text).width;

            const boxWidth =
                textWidth + 16;

            const boxHeight =
                24;

            let boxX =
                x -
                (boxWidth / 2);

            let boxY =
                y - 38;

            /*
            |--------------------------------------------------------------------------
            | Keep tooltip inside canvas
            |--------------------------------------------------------------------------
            */

            if (boxX < 5) {

                boxX = 5;

            }

            if (
                boxX + boxWidth >
                canvas.clientWidth - 5
            ) {

                boxX =
                    canvas.clientWidth -
                    boxWidth -
                    5;

            }

            if (boxY < 5) {

                boxY =
                    y + 15;

            }

            /*
            |--------------------------------------------------------------------------
            | Tooltip background
            |--------------------------------------------------------------------------
            */

            ctx.fillStyle =
                '#173a5c';

            ctx.strokeStyle =
                '#173a5c';

            ctx.lineWidth = 1;

            drawRoundedRect(
                ctx,
                boxX,
                boxY,
                boxWidth,
                boxHeight,
                6
            );

            ctx.fill();

            ctx.stroke();

            /*
            |--------------------------------------------------------------------------
            | Tooltip Text
            |--------------------------------------------------------------------------
            */

            ctx.fillStyle =
                '#ffffff';

            ctx.font =
                'bold 10px Arial';

            ctx.textAlign =
                'center';

            ctx.textBaseline =
                'middle';

            ctx.fillText(
                text,
                boxX + (boxWidth / 2),
                boxY + (boxHeight / 2)
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Rounded Rectangle
        |--------------------------------------------------------------------------
        */

        function drawRoundedRect(
            context,
            x,
            y,
            width,
            height,
            radius
        ) {

            context.beginPath();

            context.moveTo(
                x + radius,
                y
            );

            context.lineTo(
                x + width - radius,
                y
            );

            context.quadraticCurveTo(
                x + width,
                y,
                x + width,
                y + radius
            );

            context.lineTo(
                x + width,
                y + height - radius
            );

            context.quadraticCurveTo(
                x + width,
                y + height,
                x + width - radius,
                y + height
            );

            context.lineTo(
                x + radius,
                y + height
            );

            context.quadraticCurveTo(
                x,
                y + height,
                x,
                y + height - radius
            );

            context.lineTo(
                x,
                y + radius
            );

            context.quadraticCurveTo(
                x,
                y,
                x + radius,
                y
            );

            context.closePath();

        }

        /*
        |--------------------------------------------------------------------------
        | Mouse Hover Detection
        |--------------------------------------------------------------------------
        */

        canvas.addEventListener(
            'mousemove',
            function (event) {

                const rect =
                    canvas.getBoundingClientRect();

                const mouseX =
                    event.clientX -
                    rect.left;

                const mouseY =
                    event.clientY -
                    rect.top;

                let foundPoint = -1;

                points.forEach(function (
                    point,
                    index
                ) {

                    const distance =
                        Math.sqrt(
                            Math.pow(
                                mouseX - point.x,
                                2
                            ) +
                            Math.pow(
                                mouseY - point.y,
                                2
                            )
                        );

                    if (distance <= 12) {

                        foundPoint =
                            index;

                    }

                });

                if (foundPoint !== hoveredPoint) {

                    hoveredPoint =
                        foundPoint;

                    drawRadar(
                        canvas.clientWidth,
                        canvas.clientHeight
                    );

                    canvas.style.cursor =
                        foundPoint !== -1
                            ? 'pointer'
                            : 'default';
                }

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Remove Hover
        |--------------------------------------------------------------------------
        */

        canvas.addEventListener(
            'mouseleave',
            function () {

                if (hoveredPoint !== -1) {

                    hoveredPoint = -1;

                    drawRadar(
                        canvas.clientWidth,
                        canvas.clientHeight
                    );
                }

                canvas.style.cursor =
                    'default';

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Initial Draw
        |--------------------------------------------------------------------------
        */

        resizeCanvas();

        /*
        |--------------------------------------------------------------------------
        | Resize
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'resize',
            resizeCanvas
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Run
    |--------------------------------------------------------------------------
    */

    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            drawVirtueChart
        );

    } else {

        drawVirtueChart();

    }

})();
</script>
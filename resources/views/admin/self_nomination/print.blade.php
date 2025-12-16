<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Self Nomination Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 20px;
            line-height: 1.5;
        }

        h2 {
            text-align: center;
            color: #004085;
            margin-bottom: 30px;
        }

        .employee-info {
            background: #e9f7ef;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .employee-info p {
            margin: 4px 0;
        }

        .section {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .section h5 {
            font-size: 14px;
            background: #cce5ff;
            color: #004085;
            padding: 6px 10px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .checkbox-list {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .checkbox-item {
            width: 48%;
            margin-bottom: 8px;
        }

        .checkbox-item input {
            margin-right: 6px;
        }

        textarea {
            width: 96%;
            /* full width */
            border: 1px solid #ced4da;
            /* soft border */
            border-radius: 8px;
            /* rounded corners */
            padding: 10px;
            /* comfortable padding */
            font-family: Arial, sans-serif;
            min-height: 100px;
            /* slightly taller */
            resize: none;
            background: #fefefe;
            /* subtle background */
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            /* subtle inner shadow */
            line-height: 1.5;
            margin-top: 5px;
            /* spacing from label/header */
            box-sizing: border-box;
            /* fix alignment */
        }

        /* Optional: highlight on focus */
        textarea:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
            background: #fff;
        }

        .disclaimer {
            border: 1px solid #f5c6cb;
            background: #f8d7da;
            padding: 12px;
            border-radius: 6px;
            font-size: 13px;
        }

        @media print {
            body {
                margin: 0;
            }

            .checkbox-item {
                width: 50%;
            }

            /* Keep each section together */
            .section {
                page-break-inside: avoid;
            }

            /* Page 2: Fakhr + Tamgha */
            .section:nth-of-type(2),
            /* Fakhr-e-Karkardagi */
            .section:nth-of-type(3)

            /* Tamgha-e-Tahqeeq */
                {
                page-break-before: always;
            }

            /* Page 3: Chaudhry + Service + Disclaimer */
            .section:nth-of-type(4),
            /* Chaudhry Muhammad Akram */
            .section:nth-of-type(5)

            /* Service Superheroes */
                {
                page-break-before: always;
            }

            .disclaimer {
                page-break-inside: avoid;
            }
        }
    </style>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <h2>Self Nomination Form</h2>

    <div class="employee-info">
        <p><b>Employee Code:</b> {{ optional($submission->user)->barcode ?? 'N/A' }}</p>
        <p><b>Name:</b>
            {{ optional($submission->user) ? trim(preg_replace('/[-\s]*\d+$/', '', $submission->user->name)) : 'N/A' }}
        </p>
        <p><b>Designation:</b> {{ optional($submission->user)->job_title ?? 'N/A' }}</p>
        <p><b>Department:</b> {{ optional($submission->user)->department ?? 'N/A' }}</p>
    </div>
    <div class="row employee-info">
        <div class="text-center mb-3">
            <span style="font-size: small;">Performance against mentioned areas is as follows:</span>
        </div>
        @php $kpaAverages = $submission->user ? getTopIndicatorsOfEmployee($submission->user->employee_id) : []; @endphp
        @foreach ($kpaAverages as $kpa) <div class="col-md-6 col-lg-4 mb-4">
                <div class="card scgrool-card-h hover-card text-white">
                    <div class="kpa-card">
                        <strong>{{ $kpa['performance_area'] ?? $kpa['kpa_short_code'] }}: </strong>
                        {{ number_format($kpa['avg'], 1) }}% — {{ $kpa['rating'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    @php
        $categories = [
            [
                'title' => 'Sitara-e-Qiyadat - Chairman’s Leadership Excellence Award',
                'name' => 'sitara_qiyadat_awards',
                'why' => 'sitara_qiyadat_why',
                'options' => [
                    'best_deen_of_year' => 'Best Deen of the Year',
                    'best_support_leader' => 'Best Support Leader',
                    'best_program_leader_ug' => 'Best Program Leader-UG of the Year',
                    'best_program_leader_pg' => 'Best Program Leader-PG of the Year',
                    'special_initiatives' => 'Special Initiatives',
                    'best_house_leader' => 'Best House Leader',
                    'best_hod_of_year' => 'Best HOD of Year'
                ]
            ],
            [
                'title' => 'Fakhr-e-Karkardagi - Rector’s Academic Excellence Awards',
                'name' => 'fakhr_karkardagi_awards',
                'why' => 'fakhr_karkardagi_why',
                'options' => [
                    'best_faculty_member' => 'Best Faculty Member',
                    'best_class_attendance' => 'Best Class Attendance',
                    'best_feedback' => 'Best Feedback',
                    'best_fyp_manager' => 'Best FYP Manager',
                    'best_qch' => 'Best QCH',
                    'best_batch_advisor' => 'Best Batch Advisor'
                ]
            ],
            [
                'title' => 'Tamgha-e-Tahqeeq - Research Excellence Awards',
                'name' => 'tamgha_tahqeeq_awards',
                'why' => 'tamgha_tahqeeq_why',
                'options' => [
                    'outstanding_researcher_of_year' => 'Outstanding Researcher',
                    'young_researcher_award' => 'Young Researcher Award',
                    'best_innovation_commercialization' => 'Best Innovation & Commercialization'
                ]
            ],
            [
                'title' => 'Chaudhry Muhammad Akram - Entrepreneurial Award',
                'name' => 'chaudhry_akram_awards',
                'why' => 'chaudhry_akram_why',
                'options' => [
                    'best_coach' => 'Best Coach',
                    'coach_participation_certificate' => 'Coach Participation Certificate',
                    'best_ettp_instructor' => 'Best ETTP Instructor'
                ]
            ],
            [
                'title' => 'Service Superheroes',
                'name' => 'service_superheroes_awards',
                'why' => 'service_superheroes_why',
                'options' => [
                    'best_office_boy' => 'Best Office Boy',
                    'best_security_guard' => 'Best Security Guard',
                    'best_technical_staff' => 'Best Technical Staff'
                ]
            ]
        ];
        $categories = $categories ?? [];
    @endphp

    @foreach($categories as $cat)
        @php $selected = $submission->{$cat['name']} ?? []; @endphp
        <div class="section">
            <h5>{{ $cat['title'] }}</h5>
            <div class="checkbox-list">
                @foreach($cat['options'] as $key => $label)
                    <div class="checkbox-item">
                        <input type="checkbox" disabled {{ in_array($key, $selected) ? 'checked' : '' }}> {{ $label }}
                    </div>
                @endforeach
            </div>
            <h5>Why Should This Award Be Given to You?</h5>
            <textarea readonly>{{ $submission->{$cat['why']} ?? '' }}</textarea>
        </div>
    @endforeach

    <div class="disclaimer">
        <b>Disclaimer:</b>
        {{ isset($submission->disclaimer) ? ($submission->disclaimer ? 'User has accepted the disclaimer.' : 'User did not accept the disclaimer.') : 'N/A' }}
    </div>

</body>

</html>
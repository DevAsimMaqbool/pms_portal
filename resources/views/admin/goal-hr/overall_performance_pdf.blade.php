<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Overall Performance Report</title>

    <style>
        @page {
            margin: 18px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 14px;
        }

        .header h1 {
            margin: 0;
            font-size: 17px;
            font-weight: bold;
            color: #1f4e79;
        }

        .header .subtitle {
            margin-top: 4px;
            font-size: 9px;
            color: #666;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .meta-table td {
            padding: 5px 7px;
            border: 1px solid #d9dee3;
            background: #f8f9fa;
        }

        .meta-label {
            font-weight: bold;
            color: #1f4e79;
            width: 80px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .report-table thead {
            display: table-header-group;
        }

        .report-table tr {
            page-break-inside: avoid;
        }

        .report-table th {
            background: #1f4e79;
            color: #ffffff;
            border: 1px solid #ffffff;
            padding: 6px 4px;
            text-align: center;
            vertical-align: middle;
            font-size: 7.5px;
            font-weight: bold;
        }

        .report-table td {
            border: 1px solid #d9dee3;
            padding: 5px 4px;
            vertical-align: middle;
            font-size: 7.5px;
        }

        .report-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .score {
            text-align: center;
            font-weight: 600;
        }

        .total-score {
            background: #edf4fb;
            font-weight: bold;
            text-align: center;
        }

        .hr-score {
            background: #faf5e8;
            font-weight: bold;
            text-align: center;
        }

        .final-score {
            background: #eaf6ee;
            font-weight: bold;
            text-align: center;
        }

        .rating {
            text-align: center;
            font-weight: bold;
            font-size: 8px;
        }

        .rating-os {
            color: #6EA8FE;
        }

        .rating-ee {
            color: #198754;
        }

        .rating-me {
            color: #b78116;
        }

        .rating-ni {
            color: #fd7e13;
        }

        .rating-be {
            color: #ff4c51;
        }

        .rating-default {
            color: #6c757d;
        }

        .total-heading {
            line-height: 1.15;
        }

        .total-heading-main {
            display: block;
            font-size: 7.5px;
            font-weight: bold;
        }

        .total-heading-sub {
            display: block;
            margin-top: 2px;
            font-size: 5.5px;
            font-weight: normal;
        }

        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 7px;
            color: #777;
        }

        /* Column widths */
        .col-name {
            width: 13%;
        }

        .col-employee-id {
            width: 7%;
        }

        .col-designation {
            width: 11%;
        }

        .col-department {
            width: 15%;
        }

        .col-score {
            width: 7%;
        }

        .col-feedback {
            width: 8%;
        }

        .col-total {
            width: 9%;
        }

        .col-hr {
            width: 7%;
        }

        .col-final {
            width: 8%;
        }

        .col-rating {
            width: 6%;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Overall Performance Report</h1>

        <div class="subtitle">
            Employee Performance Summary
        </div>
    </div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">
                Department
            </td>

            <td>
                {{ $department ?: 'All Departments' }}
            </td>

            <td class="meta-label">
                Generated
            </td>

            <td>
                {{ now()->format('d M Y') }}
            </td>

            <td class="meta-label">
                Employees
            </td>

            <td>
                {{ $rows->count() }}
            </td>
        </tr>
    </table>

    <table class="report-table">

        <thead>
            <tr>

                <th class="col-name">
                    Name
                </th>

                <th class="col-employee-id">
                    Employee ID
                </th>

                <th class="col-designation">
                    Designation
                </th>

                <th class="col-department">
                    Department
                </th>

                <th class="col-score">
                    Self Score
                </th>

                <th class="col-score">
                    Manager Score
                </th>

                <th class="col-feedback">
                    Manager Feedback
                </th>

                <th class="col-total">
                    <div class="total-heading">
                        <span class="total-heading-main">
                            Total Score
                        </span>

                        <span class="total-heading-sub">
                            70% Goal + 30% Feedback
                        </span>
                    </div>
                </th>

                <th class="col-hr">
                    HR Score
                </th>

                <th class="col-final">
                    Final Score
                </th>

                <th class="col-rating">
                    Rating
                </th>

            </tr>
        </thead>

        <tbody>

            @forelse ($rows as $row)

                @php
                    $rating = $row['Rating'] ?? 'BE';

                    $ratingClass = match ($rating) {
                        'OS' => 'rating-os',
                        'EE' => 'rating-ee',
                        'ME' => 'rating-me',
                        'NI' => 'rating-ni',
                        'BE' => 'rating-be',
                        default => 'rating-default',
                    };
                @endphp

                <tr>

                    <td class="text-left">
                        {{ $row['Name'] ?? '—' }}
                    </td>

                    <td class="text-center">
                        {{ $row['Employee ID'] ?? '—' }}
                    </td>

                    <td class="text-left">
                        {{ $row['Designation'] ?? '—' }}
                    </td>

                    <td class="text-left">
                        {{ $row['Department'] ?? '—' }}
                    </td>

                    <td class="score">
                        {{ $row['Self Score'] ?? '0.00' }}
                    </td>

                    <td class="score">
                        {{ $row['Manager Score'] ?? '0.00' }}
                    </td>

                    <td class="score">
                        {{ $row['Manager Feedback'] ?? '0.00' }}
                    </td>

                    <td class="total-score">
                        {{ $row['Total Score'] ?? '0.00' }}
                    </td>

                    <td class="hr-score">
                        {{ $row['HR Score'] ?? '0.00' }}
                    </td>

                    <td class="final-score">
                        {{ $row['Final Score'] ?? '0.00' }}
                    </td>

                    <td class="rating {{ $ratingClass }}">
                        {{ $rating }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td
                        colspan="11"
                        class="text-center"
                        style="padding: 15px;"
                    >
                        No employees found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="footer">
        Overall Performance Report - {{ now()->format('d M Y h:i A') }}
    </div>

</body>

</html>
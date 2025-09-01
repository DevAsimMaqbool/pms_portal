<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Survey Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Common container for alignment */
        .container {
            width: 95%;
            margin: 0 auto;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 2px solid #004080;
        }

        .header img {
            height: 50px;
        }

        .header .title {
            flex: 1;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .header p {
            margin: 0;
            font-size: 12px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-top: 20px;
        }

        th {
            background: #004080;
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 8px;
        }

        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #eaf2f8;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #777;
            position: fixed;
            bottom: -30px;
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header -->
        <div class="header">

            <div class="title">
                <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('admin/assets/img/avatars/SuperiorUniversityogo.svg'))) }}"
                    alt="Logo">
                <h2>Survey Performance Report</h2>
                <p>Generated on {{ now()->format('d M Y') }}</p>
            </div>
            <div style="width:50px;"></div> <!-- spacer -->
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Campus</th>
                    <th>Faculty Code</th>
                    <th>Faculty Name</th>
                    <th>Total Courses</th>
                    <th>Total Respondents</th>
                    <th>Obtained Score</th>
                    <th>Max Score</th>
                    <th>Avg Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->campus }}</td>
                        <td>{{ $row->faculty_code }}</td>
                        <td>{{ $row->faculty_name }}</td>
                        <td>{{ $row->total_courses }}</td>
                        <td>{{ $row->total_respondents }}</td>
                        <td>{{ $row->obtained_score }}</td>
                        <td>{{ $row->max_score }}</td>
                        <td>{{ $row->avg_score }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        Page <span class="pagenum"></span>
    </div>

    <!-- Page Numbers Script -->
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("DejaVu Sans", "normal");
                $size = 9;
                $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
                $x = 500;
                $y = 820;
                $pdf->text($x, $y, $pageText, $font, $size);
            ');
        }
    </script>

</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <title>Survey Performance Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px 0;
            border-bottom: 2px solid #004080;
            text-align: center;
        }

        .header img {
            height: 50px;
            margin-bottom: 8px;
        }

        .header .title {
            flex: 1;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            color: #004080;
        }

        .header p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: center;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .table th {
            background: #004080;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('admin/assets/img/avatars/SuperiorUniversityogo.svg'))) }}"
            alt="Logo">
        <h2>Survey Performance Report</h2>
        <p>Generated on {{ now()->format('d M Y') }}</p>
    </div>

    @if(!empty($record) && count($record) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Faculty Code</th>
                    <th>Faculty</th>
                    <th>Course</th>
                    <th>Question</th>
                    <th>Obtained Score</th>
                    <th>Max Score</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($record as $row)
                    <tr @if(empty($row->course) || empty($row->question)) style="background-color:#fee2e2;" @endif>
                        <td>{{ $row->faculty_code }}</td>
                        <td>{{ $row->faculty }}</td>
                        <td>{{ $row->course ?? '-' }}</td>
                        <td>{{ $row->question ?? '-' }}</td>
                        <td>{{ $row->obtained_score }}</td>
                        <td>{{ $row->max_score }}</td>
                        <td>{{ $row->percentage }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align:center;">No records found for faculty code <strong>{{ $faculty_code }}</strong>.</p>
    @endif

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
@extends('layouts.app')

@section('title', 'Survey Performance Report')

@push('style')
    <style>
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header img {
            height: 50px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background: #f2f2f2;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card p-4">
            <!-- Header -->
            <div class="header">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('admin/assets/img/avatars/SuperiorUniversityogo.svg'))) }}"
                        alt="Logo">
                    <span>Survey Performance Report</span>
                </div>
                <div>
                    <p>Generated on {{ now()->format('d M Y') }}</p>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('survey.report') }}" class="btn btn-secondary">
                    Back
                </a>
                <a href="{{ route('survey.downloadPdf', $faculty_code) }}" class="btn btn-danger" target="_blank">
                    Download as PDF
                </a>
            </div>
            <!-- Report Table -->
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
                <p>No records found for faculty code <strong>{{ $faculty_code }}</strong>.</p>
            @endif
        </div>

    </div>
@endsection
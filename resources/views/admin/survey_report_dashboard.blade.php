@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        {{-- 🔹 Page Header --}}
        <div class="row mb-4">
            <div class="col">
                <h3 class="fw-bold">Survey Dashboard</h3>
                <p class="text-muted">Overall survey data, teacher reports, and course breakdowns</p>
            </div>
        </div>

        <div class="row">

            {{-- 🔹 Survey Overview --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-light fw-bold">Survey Overview</div>
                    <div class="card-body">
                        <div id="surveyOverviewChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            {{-- 🔹 Survey Participation Trend --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-light fw-bold">Survey Participation Trend</div>
                    <div class="card-body">
                        <div id="surveyTrendChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            {{-- 🔹 Overall Teacher Report --}}
            <div class="col-lg-12 mb-4">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-light fw-bold">Overall Teacher Report</div>
                    <div class="card-body">
                        <div id="teacherReportChart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>

            {{-- 🔹 Teacher Leaderboard --}}
            <div class="col-lg-12 mb-4">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-light fw-bold">Teacher Leaderboard</div>
                    <div class="card-body">
                        <table id="teacherLeaderboard" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Teacher</th>
                                    <th>Average Rating</th>
                                    <th>Total Responses</th>
                                    <th>Best Course</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ number_format($teacher->avg_rating, 2) }}</td>
                                        <td>{{ $teacher->responses_count }}</td>
                                        <td>{{ $teacher->best_course }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 🔹 Single Teacher Report (Course Breakdown) --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-light fw-bold">Single Teacher - Course Ratings</div>
                    <div class="card-body">
                        <div id="courseReportChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            {{-- 🔹 Single Teacher Radar Report --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-light fw-bold">Teacher Strengths & Weaknesses</div>
                    <div class="card-body">
                        <div id="teacherRadarChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ---- Survey Overview (Donut)
            new ApexCharts(document.querySelector("#surveyOverviewChart"), {
                chart: { type: 'donut', height: 300 },
                series: @json($surveyRatings),
                labels: @json($surveyLabels),
                noData: { text: 'No data' }
            }).render();

            // ---- Survey Participation Trend (Line)
            new ApexCharts(document.querySelector("#surveyTrendChart"), {
                chart: { type: 'line', height: 300 },
                series: [{ name: 'Responses', data: @json($surveyTrendData) }],
                xaxis: { categories: @json($surveyTrendLabels) },
                noData: { text: 'No data' }
            }).render();

            // ---- Overall Teacher Report (Bar)
            new ApexCharts(document.querySelector("#teacherReportChart"), {
                chart: { type: 'bar', height: 400 },
                series: [{ name: 'Average Rating', data: @json($teacherRatings) }],
                xaxis: { categories: @json($teacherNames) },
                noData: { text: 'No data' }
            }).render();

            // ---- Single Teacher Report (Courses - Bar)
            new ApexCharts(document.querySelector("#courseReportChart"), {
                chart: { type: 'bar', height: 300 },
                series: [{ name: 'Course Rating', data: @json($courseRatings) }],
                xaxis: { categories: @json($courseNames) },
                noData: { text: 'No data' }
            }).render();

            // ---- Teacher Radar Chart
            new ApexCharts(document.querySelector("#teacherRadarChart"), {
                chart: { type: 'radar', height: 300 },
                series: [{ name: 'Performance', data: @json($teacherRadarData) }],
                labels: @json($criteriaLabels),
                noData: { text: 'No data' }
            }).render();

            // ---- DataTable
            if (window.$ && $('#teacherLeaderboard').length) {
                $('#teacherLeaderboard').DataTable();
            }
        });
    </script>
@endpush
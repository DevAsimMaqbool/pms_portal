<style>
    .bg-orange,
    .bg-label-orange {
        background-color: #fd7e1459 !important;
        color: #fd7e14 !important
    }

    .custom-modal {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.2);
    }

    .custom-tabs .nav-link {
        border-radius: 25px;
        margin: 0 5px;
        font-weight: 600;
        transition: 0.3s;
        background: #e1dcdc85;
    }

    .custom-tabs .nav-link.active {
        background: linear-gradient(45deg, #007bff, #00c6ff);
        color: white !important;
        box-shadow: 0px 4px 12px rgba(0, 123, 255, 0.4);
    }

    .custom-table th {
        font-weight: bold;
        text-align: center;
    }

    .custom-table td {
        text-align: center;
        vertical-align: middle;
    }
</style>
@php
    $activeRoleId = getRoleIdByName(activeRole());
    $totalFeedback = 0;

    $activeTerms = \App\Models\Term::where('status', '1')
        ->get()
        ->keyBy('term');

    $springTerm = $activeTerms->get('Spring');
    $fallTerm = $activeTerms->get('Fall');

    // Spring data
    $springAtt = $springTerm
        ? myClassesAttendanceData(
            Auth::user()->faculty_id,
            $springTerm->id
        )
        : collect();

    // Fall data
    $fallAtt = $fallTerm
        ? myClassesAttendanceData(
            Auth::user()->faculty_id,
            $fallTerm->id
        )
        : collect();

    // Spring overall
    $springTotalPresent = $springAtt->flatMap->attendances->sum('present_count');
    $springTotalStudents = $springAtt->flatMap->attendances->sum('total_students');

    $springScore = $springTotalStudents
        ? round(($springTotalPresent / $springTotalStudents) * 100, 2)
        : 0;

    // Fall overall
    $fallTotalPresent = $fallAtt->flatMap->attendances->sum('present_count');
    $fallTotalStudents = $fallAtt->flatMap->attendances->sum('total_students');

    $fallScore = $fallTotalStudents
        ? round(($fallTotalPresent / $fallTotalStudents) * 100, 2)
        : 0;

    // Average of Spring + Fall
    if ($springTerm && $fallTerm) {
        $overallAttendanceScore = round(
            ($springScore + $fallScore) / 2,
            2
        );
    } elseif ($springTerm) {
        $overallAttendanceScore = $springScore;
    } elseif ($fallTerm) {
        $overallAttendanceScore = $fallScore;
    } else {
        $overallAttendanceScore = 0;
    }
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', 113)['weightage'],
    ];

    $weightedScore = ($overallAttendanceScore * $weights['course_load']) / 100;
    $employeeId = getUserID(Auth::user()->faculty_id);
    saveIndicatorPercentage90Plus(
        $employeeId,
        $activeRoleId,
        1,
        3,
        113,
        $weightedScore
    );
@endphp
@if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor']))
    <!--  Payment Methods modal -->
    <div class="modal fade" id="StudentAttendance" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-rewind-backward-50 icon-md"></i></div> Student Attendance
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">
                        <div class="d-flex justify-content-center mb-3 mt-3">
                            <ul class="nav custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#student-attendance-spring"
                                        aria-controls="student-attendance-spring" aria-selected="true">
                                        🌸 Spring {{ date('Y') }}
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#student-attendance-fall" aria-controls="student-attendance-fall"
                                        aria-selected="false">
                                        🍂 Fall {{ date('Y') - 1 }}
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Spring -->
                            <div class="tab-pane fade show active" id="student-attendance-spring" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table
                                        class="table table-striped align-middle custom-table"">
                                                                                                                                                            <thead class="
                                        table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Avg Class Size</th>
                                            <th>Avg Present</th>
                                            <th>Avg Absent</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                        </thead>
                                        @php
                                            // Initialize totalFeedback to 0 in case nothing is set later
                                            $totalAvgPresent = 0;
                                        @endphp

                                        <tbody class="table-border-bottom-0">

                                            @php
                                                $att = myClassesAttendanceData(Auth::user()->faculty_id, $springTerm->id);
                                                $sr = 1;
                                                $totalAvgPresent = $att->isNotEmpty()
                                                    ? $att->avg('avg_present_percentage')
                                                    : 0;
                                            @endphp

                                            @foreach($att as $class)
                                                @php
                                                    $latestAttendance = $class->attendances->first();
                                                    if (!$latestAttendance)
                                                        continue;
                                                    $scheduled = \Carbon\Carbon::parse($latestAttendance->class_date)->format('d-m-Y');
                                                @endphp
                                                <tr>
                                                    <td>{{ $sr++ }}</td>
                                                    <td>{{ $class->code }}</td>
                                                    <td>{{ $latestAttendance->program_name }}</td>
                                                    <td>{{ $class->career_code }}</td>
                                                    <td>{{ round($class->totalStudentsClass / $class->total_classes, 1) }}</td>
                                                    <td>{{ round($class->avg_present_count, 1) }}</td>
                                                    <td>{{ round($class->avg_absent_count, 1) }}</td>
                                                    <td>
                                                        <div class="badge" style="background-color: {{ $class->color }}">
                                                            {{number_format($class->avg_present_percentage, 1) }}%
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge" style="background-color: {{ $class->color }}">
                                                            {{ $class->rating }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th class="text-end">Total</th>
                                                <th colspan="6" class="text-end"></th>

                                                <th style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMetaAsBg($springScore)->color }}">
                                                        {{ number_format($springScore, 1) }}%
                                                    </b>
                                                </th>

                                                <th class="text-end" style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMetaAsBg($springScore)->color }}">
                                                        {{ getRatingMetaAsBg($springScore)->rating }}
                                                    </b>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Fall -->
                            <div class="tab-pane fade" id="student-attendance-fall" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table
                                        class="table table-striped align-middle custom-table"">
                                                                                                                                                        <thead class="
                                        table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Avg Class Size</th>
                                            <th>Avg Present</th>
                                            <th>Avg Absent</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                        </thead>
                                        @php
                                            // Initialize totalFeedback to 0 in case nothing is set later
                                            $totalAvgPresent = 0;
                                        @endphp

                                        <tbody class="table-border-bottom-0">

                                            @php
                                                $att = myClassesAttendanceData(Auth::user()->faculty_id, $fallTerm->id);
                                                $sr = 1;
                                                $totalAvgPresent = $att->isNotEmpty()
                                                    ? $att->avg('avg_present_percentage')
                                                    : 0;
                                            @endphp

                                            @foreach($att as $class)
                                                @php
                                                    $latestAttendance = $class->attendances->first();
                                                    if (!$latestAttendance)
                                                        continue;
                                                    $scheduled = \Carbon\Carbon::parse($latestAttendance->class_date)->format('d-m-Y');
                                                @endphp
                                                <tr>
                                                    <td>{{ $sr++ }}</td>
                                                    <td>{{ $class->code }}</td>
                                                    <td>{{ $latestAttendance->program_name }}</td>
                                                    <td>{{ $class->career_code }}</td>
                                                    <td>{{ round($class->totalStudentsClass / $class->total_classes, 1) }}</td>
                                                    <td>{{ round($class->avg_present_count, 1) }}</td>
                                                    <td>{{ round($class->avg_absent_count, 1) }}</td>
                                                    <td>
                                                        <div class="badge" style="background-color: {{ $class->color }}">
                                                            {{number_format($class->avg_present_percentage, 1) }}%
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge" style="background-color: {{ $class->color }}">
                                                            {{ $class->rating }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th class="text-end">Total</th>
                                                <th colspan="6" class="text-end"></th>

                                                <th style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMetaAsBg($fallScore)->color }}">
                                                        {{ number_format($fallScore, 1) }}%
                                                    </b>
                                                </th>

                                                <th class="text-end" style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMetaAsBg($fallScore)->color }}">
                                                        {{ getRatingMetaAsBg($fallScore)->rating }}
                                                    </b>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if(in_array(getRoleName(activeRole()), ['HOD']))
    <!--  Payment Methods modal -->
    <div class="modal fade" id="StudentAttendance" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-rewind-backward-50 icon-md"></i></div>Student Attendance
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">
                        <!-- <div class="d-flex justify-content-center mb-3 mt-3">
                                                                                                                                                                    <ul class="nav custom-tabs" role="tablist">
                                                                                                                                                                        <li class="nav-item">
                                                                                                                                                                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                                                                                                                                                                data-bs-target="#student-attendance-spring" aria-controls="student-attendance-spring"
                                                                                                                                                                                aria-selected="true">
                                                                                                                                                                                🌸 Spring 2026
                                                                                                                                                                            </button>
                                                                                                                                                                        </li>
                                                                                                                                                                        <li class="nav-item">
                                                                                                                                                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                                                                                                                                                data-bs-target="#student-attendance-fall" aria-controls="student-attendance-fall"
                                                                                                                                                                                aria-selected="false">
                                                                                                                                                                                🍂 Fall 2025
                                                                                                                                                                            </button>
                                                                                                                                                                        </li>
                                                                                                                                                                    </ul>
                                                                                                                                                                </div> -->

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Spring -->
                            <div class="tab-pane fade show active" id="student-attendance-spring" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table
                                        class="table table-striped align-middle custom-table"">
                                                                                                                                                <thead class="
                                        table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Name</th>
                                            <th>Avg Class Size</th>
                                            <th>Avg Present</th>
                                            <th>Avg Absent</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                        </thead>

                                        <tbody class="table-border-bottom-0">
                                            @php
                                                $data = StudentAttendanceOfHOD(Auth::user()->employee_id, $activeRoleId);
                                                $grouped = collect($data)->groupBy('faculty_name');
                                                $sr = 1;
                                            @endphp

                                            @foreach($grouped as $facultyName => $rows)

                                                @php
                                                    $totalStudents = $rows->sum('total_students');
                                                    $present = $rows->sum('present_count');
                                                    $absent = $rows->sum('absent_count');

                                                    // ✅ SCORE CALCULATION
                                                    $score = $totalStudents > 0
                                                        ? ($present / $totalStudents) * 100
                                                        : 0;

                                                    // ✅ RATING + COLOR LOGIC
                                                    if ($score >= 90) {
                                                        $rating = 'OS';
                                                        $color = 'bg-primary';
                                                    } elseif ($score >= 80) {
                                                        $rating = 'EE';
                                                        $color = 'bg-success';
                                                    } elseif ($score >= 70) {
                                                        $rating = 'ME';
                                                        $color = 'bg-warning';
                                                    } elseif ($score >= 60) {
                                                        $rating = 'NI';
                                                        $color = 'bg-info';
                                                    } else {
                                                        $rating = 'BE';
                                                        $color = 'bg-danger';
                                                    }
                                                @endphp

                                                <tr>
                                                    <td>{{ $sr++ }}</td>

                                                    <td class="fw-bold">
                                                        {{ $facultyName }}
                                                    </td>

                                                    <td>
                                                        {{ $totalStudents }}
                                                    </td>

                                                    <td>
                                                        <span class="badge bg-success">
                                                            {{ $present }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <span class="badge bg-danger">
                                                            {{ $absent }}
                                                        </span>
                                                    </td>

                                                    <!-- ✅ SCORE -->
                                                    <td>
                                                        <span class="badge {{ $color }}">
                                                            {{ number_format($score, 1) }}%
                                                        </span>
                                                    </td>

                                                    <!-- ✅ RATING -->
                                                    <td>
                                                        <span class="badge {{ $color }}">
                                                            {{ $rating }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th colspan="2" class="text-end">Grand Total</th>

                                                <th>
                                                    {{ collect($data)->sum('total_students') }}
                                                </th>

                                                <th>
                                                    {{ collect($data)->sum('present_count') }}
                                                </th>

                                                <th>
                                                    {{ collect($data)->sum('absent_count') }}
                                                </th>
                                                <th style="font-size: 0.960rem;">
                                                    @php
                                                        $totalStudents = collect($data)->sum('total_students');
                                                        $present = collect($data)->sum('present_count');

                                                        $grandScore = $totalStudents > 0
                                                            ? ($present / $totalStudents) * 100
                                                            : 0;
                                                        $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', 113);
                                                        $weight = $indicatorWeight['weightage'] ?? 0;
                                                        $weightedScore = ($grandScore * $weight) / 100;

                                                        saveIndicatorPercentage90Plus(Auth::user()->employee_id, $activeRoleId, 1, 3, 113, $weightedScore, $grandScore);
                                                    @endphp

                                                    <span class="badge"
                                                        style="background-color: {{ getRatingMeta($grandScore)->color }}">
                                                        {{ number_format($grandScore, 1) }}%
                                                    </span>
                                                </th>
                                                <th style="font-size: 0.960rem;">
                                                    <span class="badge"
                                                        style="background-color: {{ getRatingMeta($grandScore)->color }}">
                                                        {{ getRatingMeta($grandScore)->rating }}
                                                    </span>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
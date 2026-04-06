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
// Initialize totalFeedback to 0 in case nothing is set later
$totalFeedback = 0;                                    
 @endphp
<!--  Payment Methods modal -->
@if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
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
                            class="icon-base ti tabler-calendar-clock icon-md"></i></div> Student Attendance
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <!-- <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio1" id="dailyRadio1" checked>
                            <label class="btn btn-outline-primary waves-effect" for="dailyRadio1">Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio1" id="monthlyRadio1">
                            <label class="btn btn-outline-primary waves-effect" for="monthlyRadio1">Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio1" id="yearlyRadio1">
                            <label class="btn btn-outline-primary waves-effect" for="yearlyRadio1">Yearly</label>
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
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
    $att = myClassesAttendanceData(Auth::user()->faculty_id);
    $sr = 1;
    $totalAvgPresent = $att->sum('avg_present_percentage');
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
                                        <th>
                                            <b>
                                                {{ number_format($totalAvgPresent, 1) }}
                                            </b>
                                        </th>
                                        <th class="text-end text-white"></th>
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
@endif
@if(in_array(getRoleName(activeRole()), ['HOD']))

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
                                    class="icon-base ti tabler-calendar-clock icon-md"></i></div> Student Attendance
                        </h3>
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                                <!-- <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradio1" id="dailyRadio1" checked>
                                    <label class="btn btn-outline-primary waves-effect" for="dailyRadio1">Weekly</label>

                                    <input type="radio" class="btn-check" name="btnradio1" id="monthlyRadio1">
                                    <label class="btn btn-outline-primary waves-effect" for="monthlyRadio1">Semesterly</label>

                                    <input type="radio" class="btn-check" name="btnradio1" id="yearlyRadio1">
                                    <label class="btn btn-outline-primary waves-effect" for="yearlyRadio1">Yearly</label>
                                </div> -->
                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped align-middle custom-table"">
                                        <thead class=" table-primary">
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
                                                <th>
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

        <span class="badge bg-dark">
            {{ number_format($grandScore, 1) }}%
        </span>
    </th>
    <th></th>
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
@endif
<!-- / Payment Methods modal -->
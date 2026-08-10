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

    $activeRoleId = getRoleIdByName(activeRole());

    $activeTerms = \App\Models\Term::where('status', '1')
        ->get()
        ->keyBy('term');

    $springTerm = $activeTerms->get('Spring');
    $fallTerm = $activeTerms->get('Fall');

    // Spring
    $springClasses = $springTerm
        ? myClassesAttendanceRecord(
            Auth::user()->faculty_id,
            $activeRoleId,
            $springTerm->id
        )
        : collect();

    // Fall
    $fallClasses = $fallTerm
        ? myClassesAttendanceRecord(
            Auth::user()->faculty_id,
            $activeRoleId,
            $fallTerm->id
        )
        : collect();

    // Individual scores
    $springScore = round($springClasses->avg('held_percentage') ?? 0, 2);
    $fallScore = round($fallClasses->avg('held_percentage') ?? 0, 2);

    // Overall score
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

    // Save ONLY the final overall score
    saveOverallAttendancePercentage(
        getUserID(Auth::user()->faculty_id),
        $overallAttendanceScore,
        1,
        3,
        117,
        $activeRoleId
    );
@endphp
@if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor']))
    <!--  Payment Methods modal -->
    <div class="modal fade" id="ClassesHeld" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-rewind-backward-50 icon-md"></i></div> Classes Held
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">
                        <div class="d-flex justify-content-center mb-3 mt-3">
                            <ul class="nav custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#classes-held-spring" aria-controls="classes-held-spring"
                                        aria-selected="true">
                                        🌸 Spring {{ date('Y') }}
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#classes-held-fall" aria-controls="classes-held-fall"
                                        aria-selected="false">
                                        🍂 Fall {{ date('Y') - 1 }}
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Spring -->
                            <div class="tab-pane fade show active" id="classes-held-spring" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped align-middle custom-table"">
                            <thead class=" table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Code</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Term</th>
                                            <th>Total Classes</th>
                                            <th>Held</th>
                                            <th>Not Held</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                        </thead>
                                        @php
                                            // Initialize totalFeedback to 0 in case nothing is set later
                                            $totalHeldPercentage = 0;
                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            @php $sr = 1;
                                                $classes = myClassesAttendanceRecord(Auth::user()->faculty_id, $activeRoleId, $springTerm->id);
                                                // 👇 SUM of held_percentage
                                                $totalHeldPercentage = $classes->avg('held_percentage');
                                            @endphp
                                            @foreach($classes as $class)
                                                <tr>
                                                    <td>{{ $sr++ }}</td>
                                                    <td>{{ $class->class_name }}</td>
                                                    <td>{{ $class->code }}</td>
                                                    <td>{{ $class->program ?? '-' }}</td>
                                                    <td>{{ $class->career_code }}</td>
                                                    <td>{{ $class->term }}</td>
                                                    <td>{{ $class->total_classes }}</td>
                                                    <td>{{ $class->class_held_count }}</td>
                                                    <td>{{ $class->class_not_held_count }}</td>
                                                    <td>
                                                        <div class="badge" style="background-color: {{ $class->color }}">
                                                            {{ number_format($class->held_percentage, 1) }}%
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge me-1" style="background-color: {{ $class->color }}">{{ $class->rating
                                                                                                }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th class="text-end">Total</th>
                                                <th colspan="8" class="text-end"></th>
                                                <th style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMeta100($totalHeldPercentage)->color }}">
                                                        {{ number_format($totalHeldPercentage, 1) }}%
                                                    </b>
                                                </th>
                                                <th style="font-size: 0.960rem;"><b class="badge"
                                                        style="background-color: {{ getRatingMeta100($totalHeldPercentage)->color }}">
                                                        {{ getRatingMeta100($totalHeldPercentage)->rating }}
                                                    </b></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Fall -->
                            <div class="tab-pane fade" id="classes-held-fall" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped align-middle custom-table"">
                            <thead class=" table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Code</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Term</th>
                                            <th>Total Classes</th>
                                            <th>Held</th>
                                            <th>Not Held</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                        </thead>
                                        @php
                                            // Initialize totalFeedback to 0 in case nothing is set later
                                            $totalHeldPercentage = 0;
                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            @php $sr = 1;
                                                $classes = myClassesAttendanceRecord(Auth::user()->faculty_id, $activeRoleId, $fallTerm->id);
                                                // 👇 SUM of held_percentage
                                                $totalHeldPercentage = $classes->avg('held_percentage');
                                            @endphp
                                            @foreach($classes as $class)
                                                <tr>
                                                    <td>{{ $sr++ }}</td>
                                                    <td>{{ $class->class_name }}</td>
                                                    <td>{{ $class->code }}</td>
                                                    <td>{{ $class->program ?? '-' }}</td>
                                                    <td>{{ $class->career_code }}</td>
                                                    <td>{{ $class->term }}</td>
                                                    <td>{{ $class->total_classes }}</td>
                                                    <td>{{ $class->class_held_count }}</td>
                                                    <td>{{ $class->class_not_held_count }}</td>
                                                    <td>
                                                        <div class="badge" style="background-color: {{ $class->color }}">
                                                            {{ number_format($class->held_percentage, 1) }}%
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge me-1" style="background-color: {{ $class->color }}">{{ $class->rating
                                                                                                }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th class="text-end">Total</th>
                                                <th colspan="8" class="text-end"></th>
                                                <th style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMeta100($totalHeldPercentage)->color }}">
                                                        {{ number_format($totalHeldPercentage, 1) }}%
                                                    </b>
                                                </th>
                                                <th style="font-size: 0.960rem;"><b class="badge"
                                                        style="background-color: {{ getRatingMeta100($totalHeldPercentage)->color }}">
                                                        {{ getRatingMeta100($totalHeldPercentage)->rating }}
                                                    </b></th>
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
    <div class="modal fade" id="ClassesHeld" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-rewind-backward-50 icon-md"></i></div> Classes Held
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">
                        <div class="d-flex justify-content-center mb-3 mt-3">
                            <ul class="nav custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#classes-held-spring" aria-controls="classes-held-spring"
                                        aria-selected="true">
                                        🌸 Spring 2026
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#classes-held-fall" aria-controls="classes-held-fall"
                                        aria-selected="false">
                                        🍂 Fall 2025
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Spring -->
                            <div class="tab-pane fade show active" id="classes-held-spring" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped align-middle custom-table"">
                            <thead class=" table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Total Classes</th>
                                            <th>Held</th>
                                            <th>Not Held</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @php
                                                $sr = 1;
                                                $classes = myDepartmentClassesAttendanceRecordHOD(
                                                    Auth::user()->employee_id,
                                                    $activeRoleId
                                                );
                                                $totalClasses = $classes->sum('total_rows');
                                                $totalHeld = $classes->sum('class_held_count');
                                                $totalNotHeld = $classes->sum('class_not_held_count');

                                                $overall = $totalClasses > 0
                                                    ? round(($totalHeld / $totalClasses) * 100, 2)
                                                    : 0;
                                                $overallAvg = $overall;
                                                // Rating
                                                if ($overall == 100) {
                                                    $color = 'warning';
                                                    $rating = 'ME';
                                                } elseif ($overall >= 90) {
                                                    $color = 'orange';
                                                    $rating = 'NI';
                                                } else {
                                                    $color = 'danger';
                                                    $rating = 'BE';
                                                }
                                            @endphp

                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $totalClasses }}</td>
                                                <td>{{ $totalHeld }}</td>
                                                <td>{{ $totalNotHeld }}</td>
                                                <td>
                                                    <div class="badge bg-{{ $color }}">
                                                        {{ number_format($overall, 1) }}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge me-1 bg-{{ $color }}">{{ $rating }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th>Total</th>
                                                <th colspan="3" class="text-end"></th>
                                                <th style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMeta100($overallAvg)->color }}">
                                                        {{ number_format($overallAvg, 1) }}%
                                                    </b>
                                                </th>
                                                <th style="font-size: 0.960rem;"><b class="badge"
                                                        style="background-color: {{ getRatingMeta100($overallAvg)->color }}">
                                                        {{ getRatingMeta100($overallAvg)->rating }}
                                                    </b></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Fall -->
                            <div class="tab-pane fade" id="classes-held-fall" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped align-middle custom-table"">
                            <thead class=" table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Total Classes</th>
                                            <th>Held</th>
                                            <th>Not Held</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @php
                                                $sr = 1;
                                                $classes = myDepartmentClassesAttendanceRecordHOD(
                                                    Auth::user()->employee_id,
                                                    $activeRoleId
                                                );
                                                $totalClasses = $classes->sum('total_rows');
                                                $totalHeld = $classes->sum('class_held_count');
                                                $totalNotHeld = $classes->sum('class_not_held_count');

                                                $overall = $totalClasses > 0
                                                    ? round(($totalHeld / $totalClasses) * 100, 2)
                                                    : 0;
                                                $overallAvg = $overall;
                                                // Rating
                                                if ($overall == 100) {
                                                    $color = 'warning';
                                                    $rating = 'ME';
                                                } elseif ($overall >= 90) {
                                                    $color = 'orange';
                                                    $rating = 'NI';
                                                } else {
                                                    $color = 'danger';
                                                    $rating = 'BE';
                                                }
                                            @endphp

                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $totalClasses }}</td>
                                                <td>{{ $totalHeld }}</td>
                                                <td>{{ $totalNotHeld }}</td>
                                                <td>
                                                    <div class="badge bg-{{ $color }}">
                                                        {{ number_format($overall, 1) }}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge me-1 bg-{{ $color }}">{{ $rating }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th>Total</th>
                                                <th colspan="3" class="text-end"></th>
                                                <th style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMeta100($overallAvg)->color }}">
                                                        {{ number_format($overallAvg, 1) }}%
                                                    </b>
                                                </th>
                                                <th style="font-size: 0.960rem;"><b class="badge"
                                                        style="background-color: {{ getRatingMeta100($overallAvg)->color }}">
                                                        {{ getRatingMeta100($overallAvg)->rating }}
                                                    </b></th>
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
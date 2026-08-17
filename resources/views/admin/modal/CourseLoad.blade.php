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

    $springData = $springTerm
        ? myClasses(
            Auth::user()->faculty_id,
            $activeRoleId,
            $springTerm->id
        )
        : null;

    $fallData = $fallTerm
        ? myClasses(
            Auth::user()->faculty_id,
            $activeRoleId,
            $fallTerm->id
        )
        : null;
    $spring = $springData['classes'] ?? collect();
    $fall = $fallData['classes'] ?? collect();

    $springWeightedCourseLoad = $springData['weightedCourseLoad'] ?? 0;
    $fallWeightedCourseLoad = $fallData['weightedCourseLoad'] ?? 0;

    $springWeightedPassScore = $springData['weightedPassScore'] ?? 0;
    $fallWeightedPassScore = $fallData['weightedPassScore'] ?? 0;

    $springWeightedMarksScore = $springData['weightedMarksScore'] ?? 0;
    $fallWeightedMarksScore = $fallData['weightedMarksScore'] ?? 0;

    $weightedCourseLoad = round(
        ($springWeightedCourseLoad + $fallWeightedCourseLoad) / 2,
        2
    );

    $weightedPassScore = round(
        ($springWeightedPassScore + $fallWeightedPassScore) / 2,
        2
    );

    $weightedMarksScore = round(
        ($springWeightedMarksScore + $fallWeightedMarksScore) / 2,
        2
    );

    $userId = getUserID(Auth::user()->faculty_id);

    DB::transaction(function () use ($userId, $activeRoleId, $weightedCourseLoad, $weightedPassScore, $weightedMarksScore) {
        if ($activeRoleId != 22) {

            saveIndicatorPercentage(
                $userId,
                $activeRoleId,
                1,
                3,
                122,
                $weightedCourseLoad
            );

            saveIndicatorPercentage90Plus(
                $userId,
                $activeRoleId,
                1,
                25,
                185,
                $weightedPassScore
            );

            saveIndicatorPercentage(
                $userId,
                $activeRoleId,
                1,
                25,
                186,
                $weightedMarksScore
            );
        }
    });

@endphp
@if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Demonstrator']))
    <!--  Payment Methods modal -->
    <div class="modal fade" id="CourseLoad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-rewind-backward-50 icon-md"></i></div> Course Load
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">
                        <div class="d-flex justify-content-center mb-3 mt-3">
                            <ul class="nav custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#course-load-spring" aria-controls="course-load-spring"
                                        aria-selected="true">
                                        🌸 Spring {{ date('Y') }}
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#course-load-fall" aria-controls="course-load-fall"
                                        aria-selected="false">
                                        🍂 Fall {{ date('Y') - 1 }}
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Spring -->
                            <div class="tab-pane fade show active" id="course-load-spring" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover align-middle custom-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Class Name</th>
                                                <th>Class Code</th>
                                                <th>Career</th>
                                                <th>Avg Class Size</th>
                                                <th>Program</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">

                                            @forelse($spring as $class)
                                                @php
                                                    // latest attendance or null
                                                    $latestAttendance = $class->attendances->first();
                                                    $scheduled = $latestAttendance
                                                        ? \Carbon\Carbon::parse($latestAttendance->class_date)->format('d-m-Y')
                                                        : '-';
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $class->class_name }}</td>
                                                    <td>{{ $class->code }}</td>
                                                    <td>{{ $class->career_code }}</td>
                                                    <td>{{ round($class->attendances->sum('total_students') / $class->attendances->count(), 1) }}
                                                    </td>
                                                    {{-- Program name (only if attendance exists) --}}
                                                    <td>{{ $latestAttendance->program_name ?? 'N/A' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">
                                                        no record found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Fall -->
                            <div class="tab-pane fade" id="course-load-fall" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover align-middle custom-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Class Name</th>
                                                <th>Class Code</th>
                                                <th>Career</th>
                                                <th>Avg Class Size</th>
                                                <th>Program</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">

                                            @forelse($fall as $class)
                                                @php
                                                    // latest attendance or null
                                                    $latestAttendance = $class->attendances->first();
                                                    $scheduled = $latestAttendance
                                                        ? \Carbon\Carbon::parse($latestAttendance->class_date)->format('d-m-Y')
                                                        : '-';
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $class->class_name }}</td>
                                                    <td>{{ $class->code }}</td>
                                                    <td>{{ $class->career_code }}</td>
                                                    <td>{{ round($class->attendances->sum('total_students') / $class->attendances->count(), 1) }}
                                                    </td>
                                                    {{-- Program name (only if attendance exists) --}}
                                                    <td>{{ $latestAttendance->program_name ?? 'N/A' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">
                                                        no record found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>

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
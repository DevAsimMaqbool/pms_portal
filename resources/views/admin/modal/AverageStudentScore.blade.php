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
@if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Demonstrator','Non Phd AP']))
    <!--  Payment Methods modal -->
    @php
    $activeRoleId = getRoleIdByName(activeRole());

    // Initialize totalFeedback to 0 in case nothing is set later
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

    /*
    |--------------------------------------------------------------------------
    | Exclude Courses With 0 Students
    |--------------------------------------------------------------------------
    */

    $springValid = $spring->filter(function ($class) {
        return $class->attendances->sum('total_students') > 0;
    });

    $fallValid = $fall->filter(function ($class) {
        return $class->attendances->sum('total_students') > 0;
    });

    /*
    |--------------------------------------------------------------------------
    | Average Student Marks
    |--------------------------------------------------------------------------
    */

    $springAvg = $springValid->isNotEmpty()
        ? $springValid->avg(
            fn($class) => (float) ($class->average_marks ?? 0)
        )
        : 0;

    $fallAvg = $fallValid->isNotEmpty()
        ? $fallValid->avg(
            fn($class) => (float) ($class->average_marks ?? 0)
        )
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Overall Average - Spring + Fall
    |--------------------------------------------------------------------------
    */

    $avgScore = ($springValid->isNotEmpty() && $fallValid->isNotEmpty())
        ? ($springAvg + $fallAvg) / 2
        : ($springValid->isNotEmpty()
            ? $springAvg
            : $fallAvg);

    $avgScore = round($avgScore, 2);
    $weights = [
        'marks' => getRoleWeightage($activeRoleId, 'indicator', 186)['weightage'],
    ];
    $weightedPassScore = ($avgScore * $weights['marks']) / 100;
    saveIndicatorPercentage(auth()->id(), $activeRoleId, 1, 25, 186, $weightedPassScore,$avgScore);
@endphp
    <div class="modal fade" id="AverageStudentScore" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-chart-histogram icon-md"></i></div> Average Student Score
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">
                        <div class="d-flex justify-content-center mb-3 mt-3">
                            <ul class="nav custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#AverageStudentScore-spring"
                                        aria-controls="AverageStudentScore-spring" aria-selected="true">
                                        🌸 Spring {{ date('Y') }}
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#AverageStudentScore-fall" aria-controls="AverageStudentScore-fall"
                                        aria-selected="false">
                                        🍂 Fall {{ date('Y') - 1 }}
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Spring -->
                            <div class="tab-pane fade show active" id="AverageStudentScore-spring" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover align-middle custom-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Class</th>
                                                <th>Program</th>
                                                <th>Career (PG/UG)</th>
                                                <th>Average Student Score</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Demonstrator','Non Phd AP']))

                                                @forelse($spring as $class)
                                                    @php
                                                        // latest attendance or null
                                                        $latestAttendance = $class->attendances->first();
                                                        $avg = $class->average_marks ?? 0;
                                                        // Determine rating
                                                        if ($avg >= 90) {
                                                            $color = 'primary';
                                                            $rating = 'OS';
                                                        } elseif ($avg >= 80) {
                                                            $color = 'success';
                                                            $rating = 'EE';
                                                        } elseif ($avg >= 70) {
                                                            $color = 'warning';
                                                            $rating = 'ME';
                                                        } elseif ($avg >= 60) {
                                                            $color = 'orange';
                                                            $rating = 'NI';
                                                        } else {
                                                            $color = 'danger';
                                                            $rating = 'BE';
                                                        }
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $class->class_name }}</td>
                                                        <td>{{ $latestAttendance->program_name ?? 'N/A' }}</td>
                                                        <td>{{ $class->career_code }}</td>
                                                        <td>{{ number_format($avg, 1) }}</td>
                                                        <td>
                                                            <div class="badge bg-{{ $color }}">
                                                                {{ number_format($avg, 1) }}%
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="badge bg-{{ $color }}">

                                                                {{ $rating }}
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">No record found</td>
                                                    </tr>
                                                @endforelse
                                            @endif
                                        </tbody>
                                        @if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Demonstrator','Non Phd AP']))
                                            <tfoot>
                                                <tr class="table-primary">
                                                    <th class="text-end">Total</th>
                                                    <th colspan="4" class="text-end"></th>
                                                    <th style="font-size: 0.960rem;">
                                                        <b class="badge"
                                                            style="background-color:{{ getRatingMeta($springAvg)->color }}">
                                                            {{ number_format($springAvg, 1) }}%
                                                        </b>
                                                    </th>
                                                    <th class="text-end" style="font-size: 0.960rem;"><b class="badge"
                                                            style="background-color:{{ getRatingMeta($springAvg)->color }}">
                                                            {{ getRatingMeta($springAvg)->rating }}
                                                        </b></th>
                                                </tr>
                                            </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <!-- Fall -->
                            <div class="tab-pane fade" id="AverageStudentScore-fall" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover align-middle custom-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Class</th>
                                                <th>Program</th>
                                                <th>Career (PG/UG)</th>
                                                <th>Average Student Score</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Demonstrator','Non Phd AP']))

                                                @forelse($fall as $class)
                                                    @php
                                                        // latest attendance or null
                                                        $latestAttendance = $class->attendances->first();
                                                        $avg = $class->average_marks ?? 0;
                                                        // Determine rating
                                                        if ($avg >= 90) {
                                                            $color = 'primary';
                                                            $rating = 'OS';
                                                        } elseif ($avg >= 80) {
                                                            $color = 'success';
                                                            $rating = 'EE';
                                                        } elseif ($avg >= 70) {
                                                            $color = 'warning';
                                                            $rating = 'ME';
                                                        } elseif ($avg >= 60) {
                                                            $color = 'orange';
                                                            $rating = 'NI';
                                                        } else {
                                                            $color = 'danger';
                                                            $rating = 'BE';
                                                        }
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $class->class_name }}</td>
                                                        <td>{{ $latestAttendance->program_name ?? 'N/A' }}</td>
                                                        <td>{{ $class->career_code }}</td>
                                                        <td>{{ number_format($avg, 1) }}</td>
                                                        <td>
                                                            <div class="badge bg-{{ $color }}">
                                                                {{ number_format($avg, 1) }}%
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="badge bg-{{ $color }}">

                                                                {{ $rating }}
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">No record found</td>
                                                    </tr>
                                                @endforelse
                                            @endif
                                        </tbody>
                                        @if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Demonstrator','Non Phd AP']))
                                            <tfoot>
                                                <tr class="table-primary">
                                                    <th class="text-end">Total</th>
                                                    <th colspan="4" class="text-end"></th>
                                                    <th style="font-size: 0.960rem;">
                                                        <b class="badge"
                                                            style="background-color:{{ getRatingMeta($fallAvg)->color }}">
                                                            {{ number_format($fallAvg, 1) }}%
                                                        </b>
                                                    </th>
                                                    <th class="text-end" style="font-size: 0.960rem;"><b class="badge"
                                                            style="background-color:{{ getRatingMeta($fallAvg)->color }}">
                                                            {{ getRatingMeta($fallAvg)->rating }}
                                                        </b></th>
                                                </tr>
                                            </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Payment Methods modal -->
@endif

@if(in_array(getRoleName(activeRole()), [
    'Program Leader UG',
    'Program Leader PG',
]))

@php
    $activeRoleId = getRoleIdByName(activeRole());
    $user = auth()->user();

    $activeTerms = \App\Models\Term::query()
        ->where('status', '1')
        ->whereIn('term', ['Spring', 'Fall'])
        ->get()
        ->keyBy('term');

    $springTerm = $activeTerms->get('Spring');
    $fallTerm = $activeTerms->get('Fall');

    $springData = $springTerm
        ? myClassesUG($activeRoleId, $springTerm->id, $user)
        : null;

    $fallData = $fallTerm
        ? myClassesUG($activeRoleId, $fallTerm->id, $user)
        : null;

    $springAvg = $springData['averageStudentScore'] ?? 0;
    $fallAvg = $fallData['averageStudentScore'] ?? 0;

    $springValid = $springData['validClasses'] ?? collect();
    $fallValid = $fallData['validClasses'] ?? collect();

    // Preserve the existing Spring/Fall average calculation.
    if ($springValid->isNotEmpty() && $fallValid->isNotEmpty()) {
        $avgScore = ($springAvg + $fallAvg) / 2;
    } elseif ($springValid->isNotEmpty()) {
        $avgScore = $springAvg;
    } elseif ($fallValid->isNotEmpty()) {
        $avgScore = $fallAvg;
    } else {
        $avgScore = 0;
    }

    $avgScore = round($avgScore, 2);

    // Save the combined score once.
    $marksWeight = getRoleWeightage(
        $activeRoleId,
        'indicator',
        186
    )['weightage'] ?? 0;
    $weightedPassScore = ($avgScore * $marksWeight) / 100;
    saveIndicatorPercentage(
        auth()->id(),
        $activeRoleId,
        1,
        25,
        186,
        $weightedPassScore,
        $avgScore
    );

   

    $semesterTabs = [
        'spring' => [
            'label' => '🌸 Spring ' . now()->year,
            'data' => $springData,
            'average' => $springAvg,
            'empty' => 'No Spring records found.',
        ],
        'fall' => [
            'label' => '🍂 Fall ' . (now()->year - 1),
            'data' => $fallData,
            'average' => $fallAvg,
            'empty' => 'No Fall records found.',
        ],
    ];
@endphp

<div class="modal fade"
    id="AverageStudentScore"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">

            <div class="modal-header">
                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body p-4">

                <h3 class="text-center mb-4 fw-bold text-primary">
                    <span class="badge bg-label-primary rounded p-2">
                        <i class="icon-base ti tabler-chart-histogram icon-md"></i>
                    </span>
                    Average Student Score (UG)
                </h3>

                <div class="nav-align-top nav-tabs-shadow">

                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">

                            @foreach($semesterTabs as $key => $semester)
                                <li class="nav-item">
                                    <button type="button"
                                        class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#AverageStudentScore-{{ $key }}"
                                        aria-controls="AverageStudentScore-{{ $key }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $semester['label'] }}
                                    </button>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                    <div class="tab-content">

                        @foreach($semesterTabs as $key => $semester)

                            @php
                                $classes = $semester['data']['classes'] ?? collect();
                                $average = $semester['average'];
                                $averageRating = getRatingMeta($average);
                            @endphp

                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="AverageStudentScore-{{ $key }}"
                                role="tabpanel">

                                <div class="table-responsive">

                                    <table class="table table-hover align-middle custom-table">

                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Class</th>
                                                <th>Program</th>
                                                <th>Career (UG)</th>
                                                <th>Average Student Score</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @forelse($classes as $class)

                                                @php
                                                    $latestAttendance = $class->attendances->first();
                                                    $avg = (float) ($class->average_marks ?? 0);
                                                    $ratingMeta = getRatingMeta($avg);
                                                @endphp

                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $class->class_name }}</td>
                                                    <td>{{ $latestAttendance->program_name ?? 'N/A' }}</td>
                                                    <td>{{ $class->career_code }}</td>
                                                    <td>{{ number_format($avg, 1) }}</td>

                                                    <td>
                                                        <span class="badge"
                                                            style="background-color: {{ $ratingMeta->color }}">
                                                            {{ number_format($avg, 1) }}%
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <span class="badge"
                                                            style="background-color: {{ $ratingMeta->color }}">
                                                            {{ $ratingMeta->rating }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            @empty

                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        {{ $semester['empty'] }}
                                                    </td>
                                                </tr>

                                            @endforelse

                                        </tbody>

                                        <tfoot>
                                            <tr class="table-primary">
                                                <th colspan="5" class="text-end">
                                                    Average Student Score
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                        style="background-color: {{ $averageRating->color }}">
                                                        {{ number_format($average, 1) }}%
                                                    </span>
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                        style="background-color: {{ $averageRating->color }}">
                                                        {{ $averageRating->rating }}
                                                    </span>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>

                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endif

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
@if(in_array(getRoleName(activeRole()), ['HOD']))
    <!--  Payment Methods modal -->

    <div class="modal fade" id="Employability" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div> % Employability
                    </h3>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                @php
                                    $data = EmployabilityOfHOD()->where('indicator_id', 103);
                                    $avgScore = $data->isNotEmpty()
                                        ? $data->avg(fn($r) => (float) $r->held_percentage)
                                        : 0;
                                @endphp

                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Faculty</th>
                                            <th>Department</th>
                                            <th>Program</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($data as $index => $row)
                                            <tr>
                                                <td>
                                                    {{ $row->class_name == 'Overall Department' ? 'Overall Department' : $index + 1 }}
                                                </td>

                                                <td>{{ $row->faculty_name }}</td>
                                                <td>{{ $row->department_name }}</td>
                                                <td>{{ $row->program_name }}</td>

                                                <td>
                                                    <div class="badge" style="background-color: {{ $row->color }}">
                                                        {{ number_format($row->held_percentage, 1) }}%
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="badge" style="background-color: {{ $row->color }}">
                                                        {{ $row->rating }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Payment Methods modal -->
@endif
@if(in_array(getRoleName(activeRole()), ['Dean']))
    <!--  Payment Methods modal -->

    <div class="modal fade" id="Employability" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>% Employability
                    </h3>
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Department</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $data = ResearchInnovationAndCommercialization(Auth::user()->employee_id, $activeRoleId, 1, 1, 103);

                                        @endphp
                                        @foreach($data['records'] as $record)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td> {{ $record->user?->department?->name ?? '' }}</td>
                                                <td>
                                                    <div class="badge bg-{{ $record->color }}">
                                                        {{ $record->score}}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="badge bg-label-{{ $record->color }}">

                                                        {{ $record->rating }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th class=""></th>
                                            <th class="">{{number_format($data['faculty_avg_percentage'], 2) }}</th>
                                            <th class="">W: {{number_format($data['weighted_score'], 1) }}</th>
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
    <!-- / Payment Methods modal -->
@endif
@if(in_array(getRoleName(activeRole()), ['Program Leader UG', 'Program Leader PG']))
    <!--  Payment Methods modal -->

    <div class="modal fade" id="Employability" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div> % Employability
                    </h3>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                @php
                                    $programLevel = match (getRoleName(activeRole())) {
                                        'Program Leader UG' => 'UG',
                                        'Program Leader PG' => 'PG',
                                        default => ''
                                    };

                                    $data = EmployabilityOfPL(Auth::id(), $programLevel);

                                    $employability = $data->firstWhere('indicator_id', 103);

                                    $programs = \App\Models\Program::where('leader_id', Auth::id())->get();

                                    $modalData = collect();

                                    foreach ($programs as $program) {

                                        $records = \App\Models\Employability::where('program_id', $program->id)
                                            ->where('program_level', $programLevel)
                                            ->get();

                                        $total = $records->count();
                                        $employed = $records->whereNotNull('date_of_appointment')->count();
                                        $unemployed = $total - $employed;

                                        $score = $total > 0 ? round(($employed / $total) * 100, 1) : 0;

                                        $color = getRatingMeta($score)->color;
                                        $rating = getRatingMeta($score)->rating;

                                        $modalData->push([
                                            'program_name' => $program->program_name,
                                            'total_students' => $total,
                                            'employed' => $employed,
                                            'unemployed' => $unemployed,
                                            'score' => $score,
                                            'color' => $color,
                                            'rating' => $rating,
                                        ]);
                                    }
                                @endphp

                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Program</th>
                                            <th>Total Students</th>
                                            <th>Employed</th>
                                            <th>Unemployed</th>
                                            <th>Score %</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($modalData as $index => $row)
                                            <tr>
                                                <td>
                                                    {{ $index + 1 }}
                                                </td>

                                                <td>{{ $row['program_name'] }}</td>
                                                <td>{{ $row['total_students'] }}</td>
                                                <td>{{ $row['employed'] }}</td>
                                                <td>{{ $row['unemployed'] }}</td>

                                                <td>
                                                    <div class="badge" style="background-color: {{ $row['color'] }}">
                                                        {{ number_format($row['score'], 1) }}%
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="badge" style="background-color: {{ $row['color']}}">
                                                        {{ $row['rating'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Payment Methods modal -->
@endif
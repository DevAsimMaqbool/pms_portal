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
@if(in_array(getRoleName(activeRole()), ['Associate Professor', 'Associate Professor', 'Professor']))
    <!-- / Payment Methods modal -->
    <div class="modal fade" id="ResearchProductivityofPGStudentsMSMPhilPhD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        Research Productivity of PG Students(MS / MPhil / PhD)
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Fall -->
                            <div class="tab-pane fade show active" id="ResearchProductivityofPGStudents(MS/MPhil/PhD)-fall"
                                role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover align-middle custom-table">

                                        <thead class="table-primary">
                                            <tr>
                                                <th>Category</th>
                                                <th>Journal Rank</th>
                                                <th>Target</th>
                                                <th>Achieved</th>
                                                <th>Student</th>
                                                <th>Career</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $ResearchProductivityofPGStudents = ResearchProductivityofPGStudents(Auth::user()->employee_id, $activeRoleId, 133);
                                            @endphp
                                            @foreach ($ResearchProductivityofPGStudents as $ResearchProductivityofPGStudent)
                                                <tr>
                                                    <td>{{ $ResearchProductivityofPGStudent['target_category'] }}</td>
                                                    <td>{{ $ResearchProductivityofPGStudent['journal_clasification'] }}</td>
                                                    <td>{{ $ResearchProductivityofPGStudent['value'] }}</td>
                                                    <td>{{ $ResearchProductivityofPGStudent['count'] }}</td>
                                                    <td>{{ $ResearchProductivityofPGStudent['student_roll_no'] }}</td>
                                                    <td>{{ $ResearchProductivityofPGStudent['student_career'] }}</td>
                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{$ResearchProductivityofPGStudent['color'] }}">
                                                            {{ number_format($ResearchProductivityofPGStudent['percentage'], 1) }}%
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{ $ResearchProductivityofPGStudent['color'] }}">

                                                            {{ $ResearchProductivityofPGStudent['rating'] }}
                                                        </div>
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
    </div>

    <!-- / Payment Methods modal -->
@endif
@if(in_array(getRoleName(activeRole()), ['HOD']))
    <!-- / Payment Methods modal -->
    <div class="modal fade" id="ResearchProductivityofPGStudentsMSMPhilPhD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        Research Productivity of PG Students(MS / MPhil / PhD)
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Fall -->
                            <div class="tab-pane fade show active" id="ResearchProductivityofPGStudents(MS/MPhil/PhD)-fall"
                                role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover align-middle custom-table">

                                        <thead class="table-primary">
                                            <tr>
                                                <th>Category</th>
                                                <th>Journal Rank</th>
                                                <th>Target</th>
                                                <th>Achieved</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $data = researchProductivityPGStudentsOfHOD($activeRoleId, 133);
                                            @endphp
                                            @foreach ($data['department_rows'] as $row)
                                                <tr>
                                                    <td>{{ $row['target_category'] }}</td>
                                                    <td>{{ $row['journal_clasification'] }}</td>
                                                    <td>{{ $row['value'] }}</td>
                                                    <td>{{ $row['count'] }}</td>
                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{ getRatingMeta($row['percentage'])->color }}">
                                                            {{ number_format($row['percentage'], 1) }}%
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{ getRatingMeta($row['percentage'])->color }}">
                                                            {{ getRatingMeta($row['percentage'])->rating }}
                                                        </div>
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
    </div>

    <!-- / Payment Methods modal -->
@endif
@if(in_array(getRoleName(activeRole()), ['Dean']))
    <!--  Payment Methods modal -->

    <div class="modal fade" id="ResearchProductivityofPGStudentsMSMPhilPhD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Research Productivity of PG
                        Students(MS / MPhil / PhD)
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
                                            $data = ResearchInnovationAndCommercialization(Auth::user()->employee_id, $activeRoleId, 2, 6, 133);

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

    <div class="modal fade" id="ResearchProductivityofPGStudentsMSMPhilPhD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Research Productivity of PG
                        Students (MS/MPhil/PhD)
                    </h3>
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Faculty</th>
                                            <th>Department</th>
                                            <th>Program</th>
                                            <th>Career</th>
                                            <th>Target</th>
                                            <th>Achieved</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $programLevel = match (getRoleName(activeRole())) {
                                            'Program Leader UG' => 'UG',
                                            'Program Leader PG' => 'PG',
                                            default => ''
                                        };

                                        $data = ResearchProductivityofPGStudentsOfPL(
                                            Auth::user()->id,
                                            $activeRoleId,
                                            133,
                                            $programLevel
                                        );
                                    @endphp
                                    <tbody>
                                        @forelse($data as $index => $row)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>

                                                <td>{{ $row['faculty_name'] }}</td>

                                                <td>{{ $row['department_name'] }}</td>

                                                <td>{{ $row['program_name'] }}</td>

                                                <td>{{ $row['student_career'] }}</td>

                                                <td>{{ $row['value'] }}</td>

                                                <td>{{ $row['count'] }}</td>


                                                <td>
                                                    <div class="badge"
                                                        style="background-color: {{ getRatingMeta($row['percentage'])->color }}">
                                                        {{ number_format($row['percentage'], 1) }}%
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="badge"
                                                        style="background-color: {{ getRatingMeta($row['percentage'])->color }}">
                                                        {{ getRatingMeta($row['percentage'])->rating }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No Data Found</td>
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
    <!-- / Payment Methods modal -->
@endif
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
@if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
    <!--  Payment Methods modal -->
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
                                        🌸 Spring 2026
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#AverageStudentScore-fall" aria-controls="AverageStudentScore-fall"
                                        aria-selected="false">
                                        🍂 Fall 2025
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
                                            <td colspan="7">no record found</td>

                                        </tbody>
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
                                            @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
                                                @php
        $data = myClasses(Auth::user()->faculty_id, $activeRoleId);
        $att = $data['classes'];
        $sr = 1;
        $avgScore = $att->isNotEmpty()
            ? $att->avg(fn($c) => (float) ($c->average_marks ?? 0))
            : 0;
                                                @endphp

                                                @forelse($att as $class)
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
                                                        <td>{{ $sr++ }}</td>
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
                                        @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
                                            <tfoot>
                                                <tr class="table-primary">
                                                    <th class="text-end">Total</th>
                                                    <th colspan="4" class="text-end"></th>
                                                    <th style="font-size: 0.960rem;">
                                                        <b class="badge" style="background-color:{{ getRatingMeta($avgScore)->color }}">
                                                            {{ number_format($avgScore, 1) }}%
                                                        </b>
                                                    </th>
                                                    <th class="text-end" style="font-size: 0.960rem;"><b
                                                            class="badge" style="background-color:{{ getRatingMeta($avgScore)->color }}">
                                                            {{ getRatingMeta($avgScore)->rating }}
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
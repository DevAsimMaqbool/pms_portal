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
                                    <th>Scheduled</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                    @php
                                        // Initialize totalFeedback to 0 in case nothing is set later
                                        $totalAvgPresent = 0;
                                    @endphp

                                <tbody class="table-border-bottom-0">
                                    @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
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
                                                <td>{{ $class->class_id }}</td>
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
                                    @endif
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

<!-- / Payment Methods modal -->
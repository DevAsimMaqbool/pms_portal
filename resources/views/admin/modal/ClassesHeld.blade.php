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
                            class="icon-base ti tabler-clock-hour-2 icon-md"></i></div> Classes Held
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <!-- <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="dailyRadio" checked>
                            <label class="btn btn-outline-primary waves-effect" for="dailyRadio">Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio" id="monthlyRadio">
                            <label class="btn btn-outline-primary waves-effect" for="monthlyRadio">Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio" id="yearlyRadio">
                            <label class="btn btn-outline-primary waves-effect" for="yearlyRadio">Yearly</label>
                        </div> -->
                    </div>
                    <div class="card-body">
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
    $classes = myClassesAttendanceRecord(Auth::user()->faculty_id, $activeRoleId);
    // 👇 SUM of held_percentage
    $totalHeldPercentage = $classes->sum('held_percentage');
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
                                                    <span class="badge me-1"
                                                        style="background-color: {{ $class->color }}">{{ $class->rating }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-primary">
                                        <th class="text-end">Total</th>
                                        <th colspan="8" class="text-end"></th>
                                        <th>
                                            <b>
                                                {{ number_format($totalHeldPercentage, 1) }}
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
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div> Classes Held
                    </h3>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                            <!-- <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="dailyRadio" checked>
                                <label class="btn btn-outline-primary waves-effect" for="dailyRadio">Weekly</label>

                                <input type="radio" class="btn-check" name="btnradio" id="monthlyRadio">
                                <label class="btn btn-outline-primary waves-effect" for="monthlyRadio">Semesterly</label>

                                <input type="radio" class="btn-check" name="btnradio" id="yearlyRadio">
                                <label class="btn btn-outline-primary waves-effect" for="yearlyRadio">Yearly</label>
                            </div> -->
                        </div>
                        <div class="card-body">
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
    $classes = myDepartmentClassesAttendanceRecordHOD(Auth::user()->employee_id, $activeRoleId);
    $totalClasses = $classes->sum('total_rows');
    $totalHeld = $classes->sum('class_held_count');
    $totalNotHeld = $classes->sum('class_not_held_count');

    $overall = $totalClasses > 0
        ? round(($totalHeld / $totalClasses) * 100, 2)
        : 0;

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
                                            <th class="text-end">Total</th>
                                            <th colspan="3" class="text-end"></th>
                                            <th></th>
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
<!-- / Payment Methods modal -->
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
<!--  Payment Methods modal -->
<div class="modal fade" id="StudentSatisfaction" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i
                            class="icon-base ti tabler-rewind-backward-50 icon-md"></i></div> Student Satisfaction
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#student-satisfaction-spring"
                                    aria-controls="student-satisfaction-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#student-satisfaction-fall"
                                    aria-controls="student-satisfaction-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="student-satisfaction-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Strength</th>
                                            <th>Respondent</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td colspan="8">no record found</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="student-satisfaction-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Strength</th>
                                            <th>Respondent</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td colspan="8">no record found</td>
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
<!--  Payment Methods modal -->

<div class="modal fade" id="QECObservation/PeerReview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i
                            class="icon-base ti tabler-binoculars icon-md"></i></div> QEC Observation / Peer Review
                </h3>
                <!-- ffffff-->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#QECObservation/PeerReview-spring"
                                    aria-controls="QECObservation/PeerReview-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#QECObservation/PeerReview-fall"
                                    aria-controls="QECObservation/PeerReview-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="QECObservation/PeerReview-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>1</td>
                                            <td>CBA601270-S25-PB-GCL-BSSEM-FALL 2024-2028-BSSE-2E</td>
                                            <td>BSSE</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-primary">91.67%</div>
                                            </td>
                                            <td><span class="badge bg-label-primary me-1">OS</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>CEE601360-S25-PB-GCL-BSSEM-FALL 2024-2028-BSSE-2E</td>
                                            <td>BSCS</td>
                                            <td>PG</td>
                                            <td>
                                                <div class=" badge bg-label-warning">85%</div>
                                            </td>
                                            <td><span class="badge bg-label-warning me-1">ME</span></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>CCQ601150-S25-PB-GCL-BSDSM-SPRING 2025-2029-BSDSM-S25-1A</td>
                                            <td>BSIT</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-success">75%</div>
                                            </td>
                                            <td><span class="badge bg-label-success me-1">EE</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="QECObservation/PeerReview-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>1</td>
                                            <td>CSE601110-F25-PB-GCL-BSSEM-FALL 2024-2028-BSSE-3A</td>
                                            <td>BSSE</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-primary">91%</div>
                                            </td>
                                            <td><span class="badge bg-label-primary me-1">OS</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>CSE601560-F25-PB-GCL-BSSEM-SPRING 2022-2026-BSSE-8A</td>
                                            <td>BSCS</td>
                                            <td>PG</td>
                                            <td>
                                                <div class=" badge bg-label-warning">85%</div>
                                            </td>
                                            <td><span class="badge bg-label-warning me-1">ME</span></td>
                                        </tr>


                                        <tr>
                                            <td>3</td>
                                            <td>CSE601180-F25-PB-GCL-BSSEM-FALL 2022-2026-GG-BSSE-F22</td>
                                            <td>BSIT</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-success">75%</div>
                                            </td>
                                            <td><span class="badge bg-label-success me-1">EE</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/fffff-->
            </div>
        </div>
    </div>
</div>
<!-- / Payment Methods modal -->
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
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio1" id="dailyRadio1" checked>
                            <label class="btn btn-outline-primary waves-effect" for="dailyRadio1">Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio1" id="monthlyRadio1">
                            <label class="btn btn-outline-primary waves-effect" for="monthlyRadio1">Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio1" id="yearlyRadio1">
                            <label class="btn btn-outline-primary waves-effect" for="yearlyRadio1">Yearly</label>
                        </div>
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
                                <tbody class="table-border-bottom-0">
                                    @php
                                        $att = myClassesAttendanceData(Auth::user()->faculty_id);
                                        $sr = 1;
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
                                            <td>{{ $class->avg_present_count }}</td>
                                            <td>{{ $class->avg_absent_count }}</td>
                                            <td>
                                                <div class="badge" style="background-color: {{ $class->color }}">
                                                    {{ $class->avg_present_percentage }}%
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

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Payment Methods modal -->
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
                            class="icon-base ti tabler-clock-hour-2 icon-md"></i></div> Classes Held
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="dailyRadio" checked>
                            <label class="btn btn-outline-primary waves-effect" for="dailyRadio">Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio" id="monthlyRadio">
                            <label class="btn btn-outline-primary waves-effect" for="monthlyRadio">Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio" id="yearlyRadio">
                            <label class="btn btn-outline-primary waves-effect" for="yearlyRadio">Yearly</label>
                        </div>
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
                                    <th>Scheduled</th>
                                    <th>Held</th>
                                    <th>Not Held</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @php $sr = 1; @endphp
                                    @foreach(myClassesAttendanceRecord(Auth::user()->faculty_id) as $class)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $class->class_name }}</td>
                                            <td>{{ $class->code }}</td>
                                            <td>{{ $class->program ?? '-' }}</td>
                                            <td>{{ $class->career_code }}</td>
                                            <td>{{ $class->term }}</td>
                                            <td>{{ $class->total_rows }}</td>
                                            <td>{{ $class->class_held_count }}</td>
                                            <td>{{ $class->class_not_held_count }}</td>
                                            <td>
                                                <div class="badge" style="background-color: {{ $class->color }}">
                                                    {{ $class->held_percentage }}%
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge me-1"
                                                    style="background-color: {{ $class->color }}">{{ $class->rating }}</span>
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
<!--  Payment Methods modal -->

<div class="modal fade" id="NumberofKnowledgeProducts" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i
                            class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Number of Knowledge Products
                </h3>
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Product</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <td colspan="5">no record found</td>
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
<!--  Payment Methods modal -->
<div class="modal fade" id="CompletionofCourseFolder" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i class="icon-base ti tabler-folder icon-md"></i>
                    </div> Completion of Course Folder
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#completion-course-spring" aria-controls="completion-course-spring"
                                    aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#completion-course-fall" aria-controls="completion-course-fall"
                                    aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="completion-course-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Status</th>
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
                        <div class="tab-pane fade" id="completion-course-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Status</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $CompletionofCourseFolders = CompletionofCourseFolder(Auth::user()->employee_id, 120);

                                        @endphp
                                        @foreach ($CompletionofCourseFolders as $CompletionofCourser)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $CompletionofCourser->facultyClass->code }}</td>
                                                <td>{{ $CompletionofCourser->facultyClass?->career_code ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="badge"
                                                        style="background-color: {{ $CompletionofCourser->color }}">
                                                        {{ $CompletionofCourser->status_folder }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="badge"
                                                        style="background-color: {{ $CompletionofCourser->color }}">

                                                        {{ $CompletionofCourser->completion_of_Course_folder }}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="badge"
                                                        style="background-color: {{ $CompletionofCourser->color }}">

                                                        {{ $CompletionofCourser->rating }}
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

<!--  Payment Methods modal -->
<div class="modal fade" id="ComplianceandUsageofLMS" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i class="icon-base ti tabler-rocket icon-md"></i>
                    </div> Compliance and Usage of LMS
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#ComplianceandUsageofLMS-spring"
                                    aria-controls="ComplianceandUsageofLMS-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#ComplianceandUsageofLMS-fall"
                                    aria-controls="ComplianceandUsageofLMS-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="ComplianceandUsageofLMS-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Status</th>
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
                        <div class="tab-pane fade" id="ComplianceandUsageofLMS-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Status</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $ComplianceandUsageofLMS = ComplianceandUsageofLMS(Auth::user()->employee_id, 121);

                                        @endphp
                                        @foreach ($ComplianceandUsageofLMS as $ComplianceandUsageofLMSData)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ComplianceandUsageofLMSData->facultyClass->code }}</td>
                                                <td>{{ $ComplianceandUsageofLMSData->facultyClass?->career_code ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <div class="badge"
                                                        style="background-color: {{ $ComplianceandUsageofLMSData->color }}">
                                                        {{ $ComplianceandUsageofLMSData->status_folder }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="badge"
                                                        style="background-color: {{ $ComplianceandUsageofLMSData->color }}">

                                                        {{ $ComplianceandUsageofLMSData->compliance_and_usage_of_lms }}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="badge"
                                                        style="background-color: {{ $ComplianceandUsageofLMSData->color }}">

                                                        {{ $ComplianceandUsageofLMSData->rating }}
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
<!--  Payment Methods modal -->

<div class="modal fade" id="StudentPunctuality" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Student Punctuality
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio01" id="dailyRadio01" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio01"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio01" id="monthlyRadio01">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio01"> 🎓
                                Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio01" id="yearlyRadio">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio01"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Class</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

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
<!--  Payment Methods modal -->
<div class="modal fade" id="TimelySubmissionofExamResults" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i
                            class="icon-base ti tabler-chart-bar-popular icon-md"></i></div>Timely Submission of Exam
                    Results

                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#SubmissionofExamResults-spring"
                                    aria-controls="SubmissionofExamResults-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#SubmissionofExamResults-fall"
                                    aria-controls="SubmissionofExamResults-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="SubmissionofExamResults-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Status</th>
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
                        <div class="tab-pane fade" id="SubmissionofExamResults-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Status</th>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- / Payment Methods modal -->
<!--  Payment Methods modal -->
<div class="modal fade" id="AssessmentQualityofExamsetc." tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i
                            class="icon-base ti tabler-antenna-bars-4 icon-md"></i></div> Assessment Quality of Exams
                    etc.
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#QualityofAssessment(ExamPaper-Projects-Assignments)-spring"
                                    aria-controls="QualityofAssessment(ExamPaper-Projects-Assignments)-spring"
                                    aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#QualityofAssessment(ExamPaper-Projects-Assignments)-fall"
                                    aria-controls="QualityofAssessment(ExamPaper-Projects-Assignments)-fall"
                                    aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active"
                            id="QualityofAssessment(ExamPaper-Projects-Assignments)-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="QualityofAssessment(ExamPaper-Projects-Assignments)-fall"
                            role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
                    <div class="badge bg-label-primary rounded p-2"><i class="icon-base ti tabler-loader-3 icon-md"></i>
                    </div> Course Load
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#CourseLoad-spring" aria-controls="CourseLoad-spring"
                                    aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#CourseLoad-fall" aria-controls="CourseLoad-fall"
                                    aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="CourseLoad-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Session</th>
                                            <th>Semester</th>
                                            <th>Course Name</th>
                                            <th>Program</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">no record found</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="align-top pe-6 ps-0 py-6 text-body">
                                            </td>
                                            <td class="px-0 w-px-100">
                                                <p class="fw-medium mb-2">Total Courses:</p>
                                                <!-- <p class="fw-medium mb-2">Overload By</p> -->
                                            </td>
                                            <td class="px-0 w-px-100 fw-medium text-heading">
                                                <p class="fw-medium mb-2"> 0 </p>
                                                <!-- <p class="fw-medium mb-2">0</p> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="CourseLoad-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class Name</th>
                                            <th>Class Code</th>
                                            <th>Career</th>
                                            <th>Program</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @php
                                            $att = myClasses(Auth::user()->faculty_id);
                                            $sr = 1;
                                        @endphp

                                        @foreach($att as $class)
                                            @php
                                                // latest attendance or null
                                                $latestAttendance = $class->attendances->first();
                                                $scheduled = $latestAttendance
                                                    ? \Carbon\Carbon::parse($latestAttendance->class_date)->format('d-m-Y')
                                                    : '-';
                                            @endphp

                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $class->class_name }}</td>
                                                <td>{{ $class->code }}</td>
                                                <td>{{ $class->career_code }}</td>

                                                {{-- Program name (only if attendance exists) --}}
                                                <td>{{ $latestAttendance->program_name ?? 'N/A' }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="align-top pe-6 ps-0 py-6 text-body">Total Courses:
                                                {{ count($att) }}
                                            </td>
                                            <td class="px-0 w-px-100">
                                                <span class="fw-medium">
                                                    <span class="badge bg-{{ count($att) > 3 ? 'danger' : 'success' }}">
                                                        {{ count($att) > 3 ? 'Overload' : 'Underload' }}
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
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
<!--  Payment Methods modal -->

<div class="modal fade" id="StudentAttendance(class/lab)" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Student Attendance (class/lab)
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio02" id="dailyRadioo2" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadioo2">Weekly</label>

                            <input type="radio" class="btn-check" name="btnradioo2" id="monthlyRadio02">
                            <label class="btn btn-outline-secondary waves-effect"
                                for="monthlyRadio02">Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio02" id="yearlyRadio02">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio02">Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Class</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

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
<div class="modal fade" id="AdoptionofActiveLearningTechniques" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Adoption of Active Learning Techniques
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradioo3" id="dailyRadioo3" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio03"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio03" id="monthlyRadio03">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio03"> 🎓
                                Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio03" id="yearlyRadio03">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio03"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Class</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

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
<!-- / Payment Methods modal -->
<div class="modal fade" id="StudentPassPercentage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i
                            class="icon-base ti tabler-percentage-75 icon-md"></i></div> Student Pass Percentage
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#StudentPassPercentage-spring"
                                    aria-controls="StudentPassPercentage-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#StudentPassPercentage-fall"
                                    aria-controls="StudentPassPercentage-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="StudentPassPercentage-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Pass %</th>
                                            <th>Failed %</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td colspan="8">no record found</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="StudentPassPercentage-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Pass %</th>
                                            <th>Failed %</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td colspan="8">no record found</td>
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
                                    🌸 Spring 2025
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
                                        <td colspan="7">no record found</td>
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
<!--  Payment Methods modal -->
<div class="modal fade" id="QualitativeFeedbackfromStudents" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Qualitative Feedback from Students
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#QualitativeFeedbackfromStudents-spring"
                                    aria-controls="QualitativeFeedbackfromStudents-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#QualitativeFeedbackfromStudents-fall"
                                    aria-controls="QualitativeFeedbackfromStudents-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="QualitativeFeedbackfromStudents-spring"
                            role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="QualitativeFeedbackfromStudents-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
<!-- / Payment Methods modal -->
<div class="modal fade" id="GuidancetoStudents" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Guidance to Students
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio05" id="dailyRadio05" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio05"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio05" id="monthlyRadio05">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio05"> 🎓
                                Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio05" id="yearlyRadio05">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio05"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Class</th>
                                    <th>%</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

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
<div class="modal fade" id="ResearchPublications" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Research Publications
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">


                    <!-- Tab Content -->
                    <div class="tab-content">


                        <!-- Fall -->
                        <div class="tab-pane fade show active"
                            id="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-fall"
                            role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Category</th>
                                            <th>Clasification</th>
                                            <th>Target</th>
                                            <th>Achieved</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $facultyData = ScopusPublications(Auth::user()->employee_id, 128);
                                            $sr = 1;
                                        @endphp
                                        @foreach ($facultyData as $row)
                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $row['target_category'] }}</td>
                                                <td>{{ $row['journal_clasification'] }}</td>
                                                <td>{{ $row['value'] }}</td>
                                                <td>{{ $row['count'] }}</td>
                                                <td>
                                                    <div class="badge" style="background-color: {{$row['color'] }}">
                                                        {{ $row['percentage'] }}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="badge" style="background-color: {{ $row['color'] }}">

                                                        {{ $row['rating'] }}
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
<!-- / Payment Methods modal -->
<div class="modal fade" id="ResearchProductivityofPGStudents(MS/Mphil/PhD)" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Research Productivity of PG Students(MS / Mphil / PhD)
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Fall -->
                        <div class="tab-pane fade show active" id="ResearchProductivityofPGStudents(MS/Mphil/PhD)-fall"
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
                                            $ResearchProductivityofPGStudents = ResearchProductivityofPGStudents(Auth::user()->employee_id, 128);
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
                                                        {{ $ResearchProductivityofPGStudent['percentage'] }}%
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
<!-- / Payment Methods modal -->
<div class="modal fade" id="achievementontasksassignedbythedean" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Achievement on tasks assigned by the dean
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#achievementontasksassignedbythedean-spring"
                                    aria-controls="achievementontasksassignedbythedean-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#achievementontasksassignedbythedean-fall"
                                    aria-controls="achievementontasksassignedbythedean-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="achievementontasksassignedbythedean-spring"
                            role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Task</th>
                                            <th>Status</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Committees Participated/Chaired</td>
                                            <td>
                                                <div class="badge bg-label-success">Completed</div>
                                            </td>
                                            <td><span class="badge bg-label-primary">91%</span></td>
                                            <td><span class="badge bg-label-primary me-1">OS</span></td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>Policy Development Contributions</td>
                                            <td>
                                                <div class="badge bg-label-success">Completed</div>
                                            </td>
                                            <td><span class="badge bg-label-success">82%</span></td>
                                            <td><span class="badge bg-label-success me-1">EE</span></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>Program Accreditation/Compliance Work</td>
                                            <td>
                                                <div class="badge bg-label-warning">Partially Completed</div>
                                            </td>
                                            <td><span class="badge bg-label-warning">75%</span></td>
                                            <td><span class="badge bg-label-warning me-1">ME</span></td>
                                        </tr>

                                        <tr>
                                            <td>4</td>
                                            <td>Quality Assurance Contributions</td>
                                            <td>
                                                <div class="badge bg-label-danger">Not Completed</div>
                                            </td>
                                            <td><span class="badge bg-label-danger">66%</span></td>
                                            <td><span class="badge bg-label-danger me-1">BE</span></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="achievementontasksassignedbythedean-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Task</th>
                                            <th>Status</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Cross-departmental Projects</td>
                                            <td>
                                                <div class="badge bg-label-success">Completed</div>
                                            </td>
                                            <td><span class="badge bg-label-primary">94%</span></td>
                                            <td><span class="badge bg-label-primary me-1">OS</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Committees Participated/Chaired</td>
                                            <td>
                                                <div class="badge bg-label-success">Completed</div>
                                            </td>
                                            <td><span class="badge bg-label-primary">91%</span></td>
                                            <td><span class="badge bg-label-primary me-1">OS</span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Policy Development Contributions</td>
                                            <td>
                                                <div class="badge bg-label-success">Completed</div>
                                            </td>
                                            <td><span class="badge bg-label-success">82%</span></td>
                                            <td><span class="badge bg-label-success me-1">EE</span></td>
                                        </tr>

                                        <tr>
                                            <td>4</td>
                                            <td>Program Accreditation/Compliance Work</td>
                                            <td>
                                                <div class="badge bg-label-warning">Partially Completed</div>
                                            </td>
                                            <td><span class="badge bg-label-warning">75%</span></td>
                                            <td><span class="badge bg-label-warning me-1">ME</span></td>
                                        </tr>

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
<!-- / Payment Methods modal -->
<div class="modal fade" id="NumberofKnowledgeProducts-PolicyAdvocacy" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Number of Knowledge Products -Policy Advocacy
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#NumberofKnowledgeProducts-PolicyAdvocacy-spring"
                                    aria-controls="NumberofKnowledgeProducts-PolicyAdvocacy-spring"
                                    aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#NumberofKnowledgeProducts-PolicyAdvocacy-fall"
                                    aria-controls="NumberofKnowledgeProducts-PolicyAdvocacy-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="NumberofKnowledgeProducts-PolicyAdvocacy-spring"
                            role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="NumberofKnowledgeProducts-PolicyAdvocacy-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
<!-- / Payment Methods modal -->
<div class="modal fade" id="LineManagersReview&RatingonTasks" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Line Manager's Review & Rating on Tasks
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#LineManagersReview&RatingonTasks-spring"
                                    aria-controls="LineManagersReview&RatingonTasks-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#LineManagersReview&RatingonTasks-fall"
                                    aria-controls="LineManagersReview&RatingonTasks-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="LineManagersReview&RatingonTasks-spring"
                            role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Virtue</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4">no record found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="LineManagersReview&RatingonTasks-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                @php
                                    $feedback = lineManagerRatingOnTasks(Auth::user()->employee_id)->first();
                                @endphp

                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Virtue</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if($feedback && $feedback->virtues)
                                            @foreach($feedback->virtues as $index => $virtue)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $virtue['name'] }}</td>

                                                    <td>
                                                        <span class="badge {{ $virtue['rating_data']['color'] }}">
                                                            {{ $virtue['rating_data']['percentage'] }}%
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <span class="badge {{ $virtue['rating_data']['color'] }}">
                                                            {{ $virtue['rating_data']['rating'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">No feedback available.</td>
                                            </tr>
                                        @endif
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
<!-- / Payment Methods modal -->
<div class="modal fade" id="AchievementoftasksStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Achievement of tasks Status
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#AchievementoftasksStatus-spring"
                                    aria-controls="AchievementoftasksStatus-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#AchievementoftasksStatus-fall"
                                    aria-controls="AchievementoftasksStatus-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="AchievementoftasksStatus-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="AchievementoftasksStatus-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
<!-- / Payment Methods modal -->
<div class="modal fade" id="EventPerformanceFeedback" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Event Performance Feedback
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <!-- <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio06" id="dailyRadio06" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio05"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio06" id="monthlyRadio06">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio05"> 🎓
                                Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio06" id="yearlyRadio06">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio06"> 📅 Yearly</label>
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            @php
                                $feedbacks = lineManagerRatingOnEvents(Auth::user()->employee_id);
                            @endphp

                            <table class="table table-striped align-middle custom-table">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Event</th>
                                        <th>Score</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach($feedbacks as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->event_name }}</td>
                                            <td>
                                                <div class="badge {{ $item->rating_data['color'] }}">
                                                    {{ $item->rating_data['percentage'] }}%
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge {{ $item->rating_data['color'] }} me-1">
                                                    {{ $item->rating_data['label'] }}
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
<!-- / Payment Methods modal -->
<div class="modal fade" id="Scorecardforeachroleisdevelopedseparately" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Scorecard for each role is developed separately
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio07" id="dailyRadio07" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio07"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio07" id="yearlyRadio07">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio07"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Class</th>
                                    <th>%</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

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
<!-- / Payment Methods modal -->
<div class="modal fade" id="Event/TaskPerformanceFeedback" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Event/Task Performance Feedback
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio08" id="dailyRadio08" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio08"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio08" id="yearlyRadio08">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio08"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Class</th>
                                    <th>%</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

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
<div class="modal fade" id="ScholarsSatisfaction(InThesisStage)" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Scholar's Satisfaction(In Thesis Stage)
                </h3>
                <div class="card">
                    <!-- <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio09" id="dailyRadio09" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio09"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio09" id="yearlyRadio09">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio09"> 📅 Yearly</label>
                        </div>
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Scholar Name</th>
                                    <th>Class</th>
                                    <th>Program</th>
                                    <th>Career (PG/UG)</th>
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Payment Methods modal -->

<!-- / Payment Methods modal -->
<div class="modal fade" id="ofGrantsWon" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    # of Grants Won
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $noofGrantsWon = noofGrantsWon(Auth::user()->employee_id, 135);

                                    @endphp
                                    @foreach ($noofGrantsWon as $noofGrantsWon_row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $noofGrantsWon_row->target }}</td> <!-- Required target -->
                                            <td>{{ $noofGrantsWon_row->achieved_count }}</td> <!-- Achieved count -->
                                            <td>
                                                <div class="badge"
                                                    style="background-color: {{ $noofGrantsWon_row->color }}">
                                                    {{ $noofGrantsWon_row->percentage }}%
                                                </div>
                                            </td>
                                            <td>
                                                <div class="badge"
                                                    style="background-color: {{ $noofGrantsWon_row->color }}">

                                                    {{ $noofGrantsWon_row->rating }}
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
<!-- / Payment Methods modal -->

<!-- / Payment Methods modal -->
<div class="modal fade" id="MultidisciplinaryProjects" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Multidisciplinary Projects
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $data = MultidisciplinaryProjects(Auth::user()->employee_id, 136);

                                    @endphp
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->target }}</td> <!-- Required target -->
                                            <td>{{ $row->achieved_count }}</td> <!-- Achieved count -->
                                            <td>
                                                <div class="badge" style="background-color: {{ $row->color }}">
                                                    {{ $row->percentage }}%
                                                </div>
                                            </td>
                                            <td>
                                                <div class="badge" style="background-color: {{ $row->color }}">

                                                    {{ $row->rating }}
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
<!-- / Payment Methods modal -->

<!-- / Payment Methods modal -->
<div class="modal fade" id="CommercialConsultancy/ResearchIncome" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Commercial Consultancy/Research Income
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Income</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $ResearchIncomes = CommercialGainsCounsultancyResearchIncome(Auth::user()->employee_id, 137);

                                    @endphp
                                    @foreach ($ResearchIncomes as $ResearchIncome)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ResearchIncome->target }}</td> <!-- Required target -->
                                            <td>{{ $ResearchIncome->achieved_count }}</td> <!-- Achieved count -->
                                            <td>{{ $ResearchIncome->total_fee }}</td>
                                            <td>
                                                <div class="badge" style="background-color: {{ $ResearchIncome->color }}">
                                                    {{ $ResearchIncome->percentage }}%
                                                </div>
                                            </td>
                                            <td>
                                                <div class="badge" style="background-color: {{ $ResearchIncome->color }}">

                                                    {{ $ResearchIncome->rating }}
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
<!-- / Payment Methods modal -->

<!-- / Payment Methods modal -->
<div class="modal fade" id="Patents/IntellectualProperty(IPR)" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Patents/Intellectual Property (IPR)
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $data = PatentsIntellectualProperty(Auth::user()->employee_id, 138);

                                    @endphp
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->target }}</td> <!-- Required target -->
                                            <td>{{ $row->achieved_count }}</td> <!-- Achieved count -->
                                            <td>
                                                <div class="badge" style="background-color: {{ $row->color }}">
                                                    {{ $row->percentage }}%
                                                </div>
                                            </td>
                                            <td>
                                                <div class="badge" style="background-color: {{ $row->color }}">

                                                    {{ $row->rating }}
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
<!-- / Payment Methods modal -->

<!-- / Payment Methods modal -->
<div class="modal fade" id="ofGrantProposalsSubmitted" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    # of Grant Proposals Submitted
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achived</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>3</td>
                                        <td>3</td>
                                        <td>
                                            <div class="badge bg-label-primary">100%</div>
                                        </td>
                                        <td><span class="badge bg-label-primary me-1">OS</span></td>
                                    </tr>
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

<!-- / Payment Methods modal -->
<div class="modal fade" id="SpinOffs" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Spin Offs
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>32</td>
                                        <td>30</td>
                                        <td>
                                            <div class=" badge bg-label-primary">90%</div>
                                        </td>
                                        <td><span class="badge bg-label-primary">OS</span></td>
                                    </tr>
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

<!-- / Payment Methods modal -->
<div class="modal fade" id="IndustrialVisits" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Industrial Visits
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td><span class="badge bg-label-warning">75%</span></td>
                                        <td><span class="badge bg-label-warning">ME</span></td>
                                    </tr>
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

<!-- / Payment Methods modal -->
<div class="modal fade" id="IndustrialProjects" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Industrial Projects
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>4</td>
                                        <td>3</td>
                                        <td><span class="badge bg-label-warning">75%</span></td>
                                        <td><span class="badge bg-label-warning">ME</span></td>
                                    </tr>
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

<!-- / Payment Methods modal -->
<div class="modal fade" id="ProductsDeliveredtoIndustry" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Products Delivered to Industry
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>1</td>
                                        <td>
                                            <div class=" badge bg-label-danger">50%</div>
                                        </td>
                                        <td><span class="badge bg-label-danger me-1">BE</span></td>
                                    </tr>
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

<!-- / Payment Methods modal -->
<div class="modal fade" id="ResearchProducts" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Research Products
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class=" table-primary">
                                <tr>
                                    <th>Sr#</th>
                                    <th>Target</th>
                                    <th>Achieved</th>
                                    <th>Score</th>
                                    <th>Rating</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>8</td>
                                        <td>7</td>
                                        <td>
                                            <div class=" badge bg-label-success">87%</div>
                                        </td>
                                        <td><span class="badge bg-label-success me-1">EE</span></td>
                                    </tr>
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
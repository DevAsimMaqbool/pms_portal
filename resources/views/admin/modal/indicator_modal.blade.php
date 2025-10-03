<style>
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
<div class="modal fade" id="StudentTeachingSatisfaction(feedback)" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Student Teaching Satisfaction (Feedback)
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
                                            <th>Career</th>
                                            <th>Strength</th>
                                            <th>Respondent</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>A</td>
                                            <td>BSCS</td>
                                            <td>UG</td>
                                            <td>50</td>
                                            <td>41</td>
                                            <td><span class="badge bg-success">85%</span></td>
                                            <td><span class="badge bg-info">ME</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>B</td>
                                            <td>BSSE</td>
                                            <td>UG</td>
                                            <td>60</td>
                                            <td>55</td>
                                            <td><span class="badge bg-success">91.67%</span></td>
                                            <td><span class="badge bg-warning">OS</span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>A</td>
                                            <td>BSIT</td>
                                            <td>UG</td>
                                            <td>45</td>
                                            <td>35</td>
                                            <td><span class="badge bg-danger">75%</span></td>
                                            <td><span class="badge bg-primary">EE</span></td>
                                        </tr>
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
                                            <th>Career</th>
                                            <th>Strength</th>
                                            <th>Respondent</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>A</td>
                                            <td>BSCS</td>
                                            <td>UG</td>
                                            <td>50</td>
                                            <td>41</td>
                                            <td><span class="badge bg-success">85%</span></td>
                                            <td><span class="badge bg-info">ME</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>B</td>
                                            <td>BSSE</td>
                                            <td>UG</td>
                                            <td>60</td>
                                            <td>55</td>
                                            <td><span class="badge bg-success">91.67%</span></td>
                                            <td><span class="badge bg-warning">OS</span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>A</td>
                                            <td>BSIT</td>
                                            <td>UG</td>
                                            <td>45</td>
                                            <td>35</td>
                                            <td><span class="badge bg-danger">75%</span></td>
                                            <td><span class="badge bg-primary">EE</span></td>
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

<div class="modal fade" id="QEC-Observation/Peerreview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 QEC - Observation / Peer review
                </h3>
                <!-- ffffff-->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#qec-observation-spring" aria-controls="qec-observation-spring"
                                    aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#qec-observation-fall" aria-controls="qec-observation-fall"
                                    aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="qec-observation-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>1</td>
                                            <td>A</td>
                                            <td>BSCS</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-success">85%</div>
                                            </td>
                                            <td><span class="badge bg-label-primary me-1">ME</span></td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>B</td>
                                            <td>BSSE</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-success">91.67%</div>
                                            </td>
                                            <td><span class="badge bg-label-success me-1">OS</span></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>A</td>
                                            <td>BSIT</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-success">75%</div>
                                            </td>
                                            <td><span class="badge bg-label-warning me-1">EE</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="qec-observation-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>1</td>
                                            <td>A</td>
                                            <td>BSCS</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-success">85%</div>
                                            </td>
                                            <td><span class="badge bg-label-primary me-1">ME</span></td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>B</td>
                                            <td>BSSE</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-success">91%</div>
                                            </td>
                                            <td><span class="badge bg-label-success me-1">OS</span></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>A</td>
                                            <td>BSIT</td>
                                            <td>UG</td>
                                            <td>
                                                <div class=" badge bg-label-success">75%</div>
                                            </td>
                                            <td><span class="badge bg-label-warning me-1">EE</span></td>
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
                    🎓 Student Attendance
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio1" id="dailyRadio1" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio1"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio1" id="monthlyRadio1">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio1"> 🎓 Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio1" id="yearlyRadio1">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio1"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Class</th>
                                        <th>Program</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                        <th>%</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>BSCS</td>
                                        <td>42</td>
                                        <td>8</td>
                                        <td>
                                            <div class="badge bg-label-success">84%</div>
                                        </td>
                                        <td><span class="badge bg-label-primary me-1">ME</span></td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>B</td>
                                        <td>BSSE</td>
                                        <td>42</td>
                                        <td>8</td>
                                        <td>
                                            <div class=" badge bg-label-success">70%</div>
                                        </td>
                                        <td><span class="badge bg-label-success me-1">OS</span></td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>A</td>
                                        <td>BSIT</td>
                                        <td>42</td>
                                        <td>8</td>
                                        <td>
                                            <div class="badge bg-label-danger">0.4%</div>
                                        </td>
                                        <td><span class="badge bg-label-warning me-1">EE</span></td>
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
<!--  Payment Methods modal -->

<div class="modal fade" id="ClassesHeldinTime/CommencementofClasses" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
            <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Classes Held in Time/Commencement of Classes
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="dailyRadio" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio" id="monthlyRadio">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio"> 🎓 Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio" id="yearlyRadio">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Class</th>
                                        <th>Scheduled</th>
                                        <th>Held</th>
                                        <th>Not Held</th>
                                        <th>%</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>32</td>
                                        <td>42</td>
                                        <td>8</td>
                                        <td>
                                            <div class="badge bg-label-success">84%</div>
                                        </td>
                                        <td><span class="badge bg-label-primary me-1">ME</span></td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>B</td>
                                        <td>22</td>
                                        <td>42</td>
                                        <td>8</td>
                                        <td>
                                            <div class=" badge bg-label-success">70%</div>
                                        </td>
                                        <td><span class="badge bg-label-success me-1">OS</span></td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>A</td>
                                        <td>21</td>
                                        <td>42</td>
                                        <td>8</td>
                                        <td>
                                            <div class="badge bg-label-danger">0.4%</div>
                                        </td>
                                        <td><span class="badge bg-label-warning me-1">EE</span></td>
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

<!--  Payment Methods modal -->
<div class="modal fade" id="CompletionofCourseFolderinHard" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Completion of Course Folder in Hard
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#completion-course-spring"
                                    aria-controls="completion-course-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#completion-course-fall"
                                    aria-controls="completion-course-fall" aria-selected="false">
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
                                            <th>Status</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>A</td>
                                            <td>
                                                <div class="badge bg-label-success">Complete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-success">70%</div>
                                            </td>
                                            <td><span class="badge bg-label-primary me-1">ME</span></td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>B</td>
                                            <td>
                                                <div class="badge bg-label-danger">InComplete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-success">70%</div>
                                            </td>
                                            <td><span class="badge bg-label-success me-1">OS</span></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>A</td>
                                            <td>
                                                <div class="badge bg-label-success">Complete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-danger">30%</div>
                                            </td>
                                            <td><span class="badge bg-label-warning me-1">EE</span></td>
                                        </tr>
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
                                            <th>Status</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>A</td>
                                            <td>
                                                <div class="badge bg-label-success">Complete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-success">90%</div>
                                            </td>
                                            <td><span class="badge bg-label-primary me-1">ME</span></td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>B</td>
                                            <td>
                                                <div class="badge bg-label-danger">InComplete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-success">60%</div>
                                            </td>
                                            <td><span class="badge bg-label-success me-1">OS</span></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>A</td>
                                            <td>
                                                <div class="badge bg-label-success">Complete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-danger">20%</div>
                                            </td>
                                            <td><span class="badge bg-label-warning me-1">EE</span></td>
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
<div class="modal fade" id="ComplianceandUsageofCMS" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Compliance and Usage of CMS
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#completion-spring"
                                    aria-controls="completion-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#completion-fall"
                                    aria-controls="completion-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="completion-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>A</td>
                                            <td>
                                                <div class="badge bg-label-success">Complete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-success">70%</div>
                                            </td>
                                            <td><span class="badge bg-label-primary me-1">ME</span></td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>B</td>
                                            <td>
                                                <div class="badge bg-label-danger">InComplete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-success">70%</div>
                                            </td>
                                            <td><span class="badge bg-label-success me-1">OS</span></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>A</td>
                                            <td>
                                                <div class="badge bg-label-success">Complete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-danger">30%</div>
                                            </td>
                                            <td><span class="badge bg-label-warning me-1">EE</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="completion-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td>1</td>
                                            <td>A</td>
                                            <td>
                                                <div class="badge bg-label-success">Complete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-success">90%</div>
                                            </td>
                                            <td><span class="badge bg-label-primary me-1">ME</span></td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>B</td>
                                            <td>
                                                <div class="badge bg-label-danger">InComplete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-success">60%</div>
                                            </td>
                                            <td><span class="badge bg-label-success me-1">OS</span></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>A</td>
                                            <td>
                                                <div class="badge bg-label-success">Complete</div>
                                            </td>
                                            <td>
                                                <div class=" badge bg-label-danger">20%</div>
                                            </td>
                                            <td><span class="badge bg-label-warning me-1">EE</span></td>
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
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio01"> 🎓 Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio01" id="yearlyRadio">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio01"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Class</th>
                                        <th>%</th>
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
<div class="modal fade" id="SubmissionofExamResultsasperTimeline" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Submission of Exam Results as per Timeline
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#SubmissionofExamResultsasperTimeline-spring"
                                    aria-controls="SubmissionofExamResultsasperTimeline-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#SubmissionofExamResultsasperTimeline-fall"
                                    aria-controls="SubmissionofExamResultsasperTimeline-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="SubmissionofExamResultsasperTimeline-spring" role="tabpanel">
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
                        <div class="tab-pane fade" id="SubmissionofExamResultsasperTimeline-fall" role="tabpanel">
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
<div class="modal fade" id="QualityofAssessment(ExamPaper-Projects-Assignments)" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Quality of Assessment (Exam Paper-Projects-Assignments)
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#QualityofAssessment(ExamPaper-Projects-Assignments)-spring"
                                    aria-controls="QualityofAssessment(ExamPaper-Projects-Assignments)-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#QualityofAssessment(ExamPaper-Projects-Assignments)-fall"
                                    aria-controls="QualityofAssessment(ExamPaper-Projects-Assignments)-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="QualityofAssessment(ExamPaper-Projects-Assignments)-spring" role="tabpanel">
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
                        <div class="tab-pane fade" id="QualityofAssessment(ExamPaper-Projects-Assignments)-fall" role="tabpanel">
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
                    🎓 Course Load
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#CourseLoad-spring"
                                    aria-controls="CourseLoad-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#CourseLoad-fall"
                                    aria-controls="CourseLoad-fall" aria-selected="false">
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
                        <div class="tab-pane fade" id="CourseLoad-fall" role="tabpanel">
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
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadioo2"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradioo2" id="monthlyRadio02">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio02"> 🎓 Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio02" id="yearlyRadio02">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio02"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Class</th>
                                        <th>%</th>
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
<div class="modal fade" id="Adoptionofactivelearningtechniques(flippedclassrooms-gamification-experientiallearning)" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
            <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Adoption of active learning techniques (flipped classrooms- gamification- experiential learning)
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradioo3" id="dailyRadioo3" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio03"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio03" id="monthlyRadio03">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio03"> 🎓 Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio03" id="yearlyRadio03">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio03"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Class</th>
                                        <th>%</th>
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
                    🎓 Student Pass Percentage
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio04" id="dailyRadio04" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio04"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio04" id="monthlyRadio04">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio04"> 🎓 Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio04" id="yearlyRadio04">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio04"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class="table-primary">
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
<!--  Payment Methods modal -->
<div class="modal fade" id="Improvementinstudentperformancemetricse.g.gradesfrommidtofinal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Improvement in student performance metrics e.g. grades from mid to final
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#mprovementinstudentperformancemetricse.g.gradesfrommidtofinal-spring"
                                    aria-controls="mprovementinstudentperformancemetricse.g.gradesfrommidtofinal-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#mprovementinstudentperformancemetricse.g.gradesfrommidtofinal-fall"
                                    aria-controls="mprovementinstudentperformancemetricse.g.gradesfrommidtofinal-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="mprovementinstudentperformancemetricse.g.gradesfrommidtofinal-spring" role="tabpanel">
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
                        <div class="tab-pane fade" id="mprovementinstudentperformancemetricse.g.gradesfrommidtofinal-fall" role="tabpanel">
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
<div class="modal fade" id="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Testimonials/Qualitative Feedback from Students on how the teaching has influenced them academically
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-spring"
                                    aria-controls="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-fall"
                                    aria-controls="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-spring" role="tabpanel">
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
                        <div class="tab-pane fade" id="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-fall" role="tabpanel">
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
<div class="modal fade" id="Guidanceofstudentsonprojectsresultinginimpactfulresearch" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
            <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    🎓 Guidance of students on projects resulting in impactful research
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio05" id="dailyRadio05" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio05"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio05" id="monthlyRadio05">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio05"> 🎓 Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio05" id="yearlyRadio05">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio05"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class="table-primary">
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
<div class="modal fade" id="ofResearchPublications(ScopusIndexed)" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    of Research Publications (Scopus Indexed)
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-spring"
                                    aria-controls="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-fall"
                                    aria-controls="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-spring" role="tabpanel">
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
                        <div class="tab-pane fade" id="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-fall" role="tabpanel">
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
<div class="modal fade" id="ResearchproductivityofPGstudents" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Research productivity of PG students
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#ResearchproductivityofPGstudents-spring"
                                    aria-controls="ResearchproductivityofPGstudents-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#ResearchproductivityofPGstudents-fall"
                                    aria-controls="ResearchproductivityofPGstudents-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="ResearchproductivityofPGstudents-spring" role="tabpanel">
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
                        <div class="tab-pane fade" id="ResearchproductivityofPGstudents-fall" role="tabpanel">
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
                        <div class="tab-pane fade show active" id="achievementontasksassignedbythedean-spring" role="tabpanel">
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
                        <div class="tab-pane fade" id="achievementontasksassignedbythedean-fall" role="tabpanel">
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
                                    aria-controls="NumberofKnowledgeProducts-PolicyAdvocacy-spring" aria-selected="true">
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
                        <div class="tab-pane fade show active" id="NumberofKnowledgeProducts-PolicyAdvocacy-spring" role="tabpanel">
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
<div class="modal fade" id="LineManagerSatisfactionRating" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Line Manager Satisfaction Rating
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#LineManagerSatisfactionRating-spring"
                                    aria-controls="LineManagerSatisfactionRating-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#LineManagerSatisfactionRating-fall"
                                    aria-controls="LineManagerSatisfactionRating-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="LineManagerSatisfactionRating-spring" role="tabpanel">
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
                        <div class="tab-pane fade" id="LineManagerSatisfactionRating-fall" role="tabpanel">
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
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio06" id="dailyRadio06" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio05"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio06" id="monthlyRadio06">
                            <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio05"> 🎓 Semesterly</label>

                            <input type="radio" class="btn-check" name="btnradio06" id="yearlyRadio06">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio06"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class="table-primary">
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
                                <thead class="table-primary">
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
                                <thead class="table-primary">
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
<div class="modal fade" id="ScholarsSatisfaction(inthesisstage)" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
            <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Scholar's Satisfaction (in thesis stage)
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio09" id="dailyRadio09" checked>
                            <label class="btn btn-outline-secondary waves-effect" for="dailyRadio09"> 📅 Weekly</label>

                            <input type="radio" class="btn-check" name="btnradio09" id="yearlyRadio09">
                            <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio09"> 📅 Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped align-middle custom-table"">
                                <thead class="table-primary">
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
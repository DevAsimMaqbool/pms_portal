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
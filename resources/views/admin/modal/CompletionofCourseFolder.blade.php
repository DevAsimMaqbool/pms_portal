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
                                        🌸 Spring 2026
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
                                        @php
    // Initialize totalFeedback to 0 in case nothing is set later
    $totalCompletion = 0;
                                        @endphp

                                        <tbody>
                                                @php
    $CompletionofCourseFolders = CompletionofCourseFolder(Auth::user()->employee_id, $activeRoleId, 120);
    // 👇 SUM of completion_of_Course_folder
    $totalCompletion = $CompletionofCourseFolders->sum('completion_of_Course_folder');
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
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th class="text-end">Total</th>
                                                <th colspan="3" class="text-end"></th>
                                                <th>
                                                    <b>
                                                        {{ number_format($totalCompletion, 1) }}
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
    </div>

    <!-- / Payment Methods modal -->
@endif

@if(in_array(getRoleName(activeRole()), ['HOD']))
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
                                        🌸 Spring 2026
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
                            <div class="tab-pane fade show" id="completion-course-fall" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                @php
    $CompletionofCourseFolders = CompletionOfCourseFolderForHOD($activeRoleId, 120);
@endphp

@foreach ($CompletionofCourseFolders as $programId => $records)

    @php
        $avg = $records->avg('completion_of_course_folder');
        $weightedScore = $records->avg('weighted_score');
    @endphp

    <table class="table table-hover align-middle custom-table">

        <thead class="table-primary">
            <tr>
                <th>Sr#</th>
                <th>Class</th>
                <th>Career</th>
                <th>Status</th>
                <th>Score</th>
                <th>Rating</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($records as $row)

                @php
                    $class = optional($row->facultyClass);
                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $class->code ?? 'N/A' }}</td>

                    <td>{{ $class->career_code ?? 'N/A' }}</td>

                    <td>
                        <span class="badge" style="background-color: {{ $row->color ?? '#ccc' }}">
                            {{ $row->status_folder ?? 'N/A' }}
                        </span>
                    </td>

                    <td>
                        <span class="badge" style="background-color: {{ $row->color ?? '#ccc' }}">
                            {{ $row->completion_of_course_folder ?? 0 }}%
                        </span>
                    </td>

                    <td>
                        <span class="badge" style="background-color: {{ $row->color ?? '#ccc' }}">
                            {{ $row->rating ?? 'N/A' }}
                        </span>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center text-danger">
                        No Data Found
                    </td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr class="table-primary">
                <th colspan="4" class="text-end">Program Avg</th>
                <th>{{ number_format($avg, 1) }}%</th>
                <th>{{ number_format($weightedScore, 1) }}</th>
            </tr>
        </tfoot>

    </table>

@endforeach
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
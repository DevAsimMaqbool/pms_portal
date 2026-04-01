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
                                        @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
                                            @php
                                                $data = myClasses(Auth::user()->faculty_id, $activeRoleId);
                                                $att = $data['classes'];
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
                                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- / Payment Methods modal -->
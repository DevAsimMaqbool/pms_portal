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

    @php
        $data = admissionTargetDepartmentAverage(
            Auth::user()->employee_id,
            $activeRoleId,
            143
        );

        // Overall S + F
        $leader_avg_percentage = $data['avg_percentage'] ?? 0;
        $meta_leader_avg_percentage = getRatingMeta($leader_avg_percentage);

        // Spring
        $spring = $data['records']['Spring'] ?? [
            'year' => 0,
            'total_target' => 0,
            'total_achieved' => 0,
            'percentage' => 0,
        ];

        $spring_percentage = $spring['percentage'] ?? 0;
        $meta_spring = getRatingMeta($spring_percentage);

        // Fall
        $fall = $data['records']['Fall'] ?? [
            'year' => 0,
            'total_target' => 0,
            'total_achieved' => 0,
            'percentage' => 0,
        ];

        $fall_percentage = $fall['percentage'] ?? 0;
        $meta_fall = getRatingMeta($fall_percentage);
    @endphp

    <div class="modal fade" id="ofAdmissionTargetsAchieved" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">

                <div class="modal-header">
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>

                <div class="modal-body p-4">

                    <h3 class="text-center mb-4 fw-bold text-primary">
                        % of Admission Targets Achieved
                    </h3>

                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">

                        <div class="d-flex justify-content-center mb-3 mt-3">
                            <ul class="nav custom-tabs" role="tablist">

                                <!-- Spring -->
                                <li class="nav-item">
                                    <button type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#ofAdmissionTargetsAchieved-spring"
                                            aria-controls="ofAdmissionTargetsAchieved-spring"
                                            aria-selected="true">
                                        🌸 Spring  {{ $spring['year'] }}
                                    </button>
                                </li>

                                <!-- Fall -->
                                <li class="nav-item">
                                    <button type="button"
                                            class="nav-link"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#ofAdmissionTargetsAchieved-fall"
                                            aria-controls="ofAdmissionTargetsAchieved-fall"
                                            aria-selected="false">
                                        🍂 Fall {{ $fall['year'] }}
                                    </button>
                                </li>

                            </ul>
                        </div>

                        <div class="tab-content">

                            <!-- ================= SPRING ================= -->
                            <div class="tab-pane fade show active"
                                 id="ofAdmissionTargetsAchieved-spring"
                                 role="tabpanel">

                                <div class="table-responsive text-nowrap">

                                    <table class="table table-striped align-middle custom-table">

                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Total Target</th>
                                                <th>Total Achieved</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>1</td>

                                                <td>
                                                    {{ number_format($spring['total_target'], 1) }}
                                                </td>

                                                <td>
                                                    {{ number_format($spring['total_achieved'], 1) }}
                                                </td>

                                                <td>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_spring->color }}">
                                                        {{ number_format($spring_percentage, 1) }}%
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_spring->color }}">
                                                        {{ $meta_spring->rating }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <tr class="table-primary">

                                                <th>Total (S + F)</th>

                                                <th>
                                                    {{ number_format($data['total_target'] ?? 0, 1) }}
                                                </th>

                                                <th>
                                                    {{ number_format($data['total_achieved'] ?? 0, 1) }}
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_leader_avg_percentage->color }}">
                                                        {{ number_format($leader_avg_percentage, 1) }}%
                                                    </span>
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_leader_avg_percentage->color }}">
                                                        {{ $meta_leader_avg_percentage->rating }}
                                                    </span>
                                                </th>

                                            </tr>
                                        </tfoot>

                                    </table>

                                </div>
                            </div>


                            <!-- ================= FALL ================= -->
                            <div class="tab-pane fade"
                                 id="ofAdmissionTargetsAchieved-fall"
                                 role="tabpanel">

                                <div class="table-responsive text-nowrap">

                                    <table class="table table-striped align-middle custom-table">

                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Total Target</th>
                                                <th>Total Achieved</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>1</td>

                                                <td>
                                                    {{ number_format($fall['total_target'], 1) }}
                                                </td>

                                                <td>
                                                    {{ number_format($fall['total_achieved'], 1) }}
                                                </td>

                                                <td>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_fall->color }}">
                                                        {{ number_format($fall_percentage, 1) }}%
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_fall->color }}">
                                                        {{ $meta_fall->rating }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <tr class="table-primary">

                                                <th>Total (S + F)</th>

                                                <th>
                                                    {{ number_format($data['total_target'] ?? 0, 1) }}
                                                </th>

                                                <th>
                                                    {{ number_format($data['total_achieved'] ?? 0, 1) }}
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_leader_avg_percentage->color }}">
                                                        {{ number_format($leader_avg_percentage, 1) }}%
                                                    </span>
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_leader_avg_percentage->color }}">
                                                        {{ $meta_leader_avg_percentage->rating }}
                                                    </span>
                                                </th>

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

@endif
@if(in_array(getRoleName(activeRole()), ['Dean']))
<!--  Payment Methods modal -->

    <div class="modal fade" id="ofAdmissionTargetsAchieved" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>% of Admission Targets Achieved
                    </h3>
                    <button type="button" class="mb-3 btn rounded-pill btn-primary waves-effect waves-light">Overall (S+F)</button>
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
                                                //$data=ResearchInnovationAndCommercialization(Auth::user()->employee_id, $activeRoleId, 3, 10, 143);
                                                $data=ResearchInnovationAndCommercializationYear(Auth::user()->employee_id, $activeRoleId, 3, 10, 143);
                                                $faculty_avg_percentage = $data['faculty_avg_percentage'] ?? 0;
                                                $meta_avg = getRatingMeta($faculty_avg_percentage);
                        
                                            @endphp
                                                @foreach($data['records'] as $record)
                                                @php
                                                $meta_avg_single = getRatingMeta($record->with_out_weight_score);
                                                $sumScore = min($record->with_out_weight_score, 100);
                                                @endphp
                                                <tr>
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td> {{ $record->user?->department?->name ?? '' }}</td>
                                                    <td><div class="badge" style="background-color: {{ $meta_avg_single->color }}">
                                                        {{ $sumScore}}%
                                                        </div></td>
                                                    <td>
                                                            <div class="badge" style="background-color: {{ $meta_avg_single->color }}">

                                                                {{ $meta_avg_single->rating }}
                                                            </div>
                                                    </td>    
                                                </tr>
                                            @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th class=""></th>
                                            {{-- <th class="">{{number_format($data['faculty_avg_percentage'], 2) }}</th>
                                           <th class="">W: {{number_format($data['weighted_score'], 1) }}</th> --}}
                                            <th class="fs-6"><span class="badge" style="background-color: {{ $meta_avg->color }}">{{number_format($faculty_avg_percentage, 2) }}</span></th>
                                            <th class="fs-6"><span class="badge" style="background-color: {{ $meta_avg->color }}">  {{ $meta_avg->rating }} </span></th>
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
@if(in_array(getRoleName(activeRole()), ['Program Leader UG','Program Leader PG']))
  @php
        $roleName = getRoleName(activeRole());
        $value = match($roleName) {
            'Program Leader UG' => 'UG',
            'Program Leader PG' => 'PG',
            default => ''
        };
        $data=admissionTargetAverageForPL(Auth::user()->employee_id, $activeRoleId, 3, 10, 143, $value);  

        // Overall S + F
        $leader_avg_percentage = $data['avg_percentage'] ?? 0;
        $meta_leader_avg_percentage = getRatingMeta($leader_avg_percentage);

        // Spring
        $spring = $data['records']['Spring'] ?? [
            'year' => 0,
            'total_target' => 0,
            'total_achieved' => 0,
            'percentage' => 0,
        ];

        $spring_percentage = $spring['percentage'] ?? 0;
        $meta_spring = getRatingMeta($spring_percentage);

        // Fall
        $fall = $data['records']['Fall'] ?? [
            'year' => 0,
            'total_target' => 0,
            'total_achieved' => 0,
            'percentage' => 0,
        ];

        $fall_percentage = $fall['percentage'] ?? 0;
        $meta_fall = getRatingMeta($fall_percentage);
    @endphp

    <div class="modal fade" id="ofAdmissionTargetsAchieved" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">

                <div class="modal-header">
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>

                <div class="modal-body p-4">

                    <h3 class="text-center mb-4 fw-bold text-primary">
                        % of Admission Targets Achieved
                    </h3>

                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">

                        <div class="d-flex justify-content-center mb-3 mt-3">
                            <ul class="nav custom-tabs" role="tablist">

                                <!-- Spring -->
                                <li class="nav-item">
                                    <button type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#ofAdmissionTargetsAchieved-spring"
                                            aria-controls="ofAdmissionTargetsAchieved-spring"
                                            aria-selected="true">
                                        🌸 Spring  {{ $spring['year'] }}
                                    </button>
                                </li>

                                <!-- Fall -->
                                <li class="nav-item">
                                    <button type="button"
                                            class="nav-link"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#ofAdmissionTargetsAchieved-fall"
                                            aria-controls="ofAdmissionTargetsAchieved-fall"
                                            aria-selected="false">
                                        🍂 Fall {{ $fall['year'] }}
                                    </button>
                                </li>

                            </ul>
                        </div>

                        <div class="tab-content">

                            <!-- ================= SPRING ================= -->
                            <div class="tab-pane fade show active"
                                 id="ofAdmissionTargetsAchieved-spring"
                                 role="tabpanel">

                                <div class="table-responsive text-nowrap">

                                    <table class="table table-striped align-middle custom-table">

                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Total Target</th>
                                                <th>Total Achieved</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>1</td>

                                                <td>
                                                    {{ number_format($spring['total_target'], 1) }}
                                                </td>

                                                <td>
                                                    {{ number_format($spring['total_achieved'], 1) }}
                                                </td>

                                                <td>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_spring->color }}">
                                                        {{ number_format($spring_percentage, 1) }}%
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_spring->color }}">
                                                        {{ $meta_spring->rating }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <tr class="table-primary">

                                                <th>Total (S + F)</th>

                                                <th>
                                                    {{ number_format($data['total_target'] ?? 0, 1) }}
                                                </th>

                                                <th>
                                                    {{ number_format($data['total_achieved'] ?? 0, 1) }}
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_leader_avg_percentage->color }}">
                                                        {{ number_format($leader_avg_percentage, 1) }}%
                                                    </span>
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_leader_avg_percentage->color }}">
                                                        {{ $meta_leader_avg_percentage->rating }}
                                                    </span>
                                                </th>

                                            </tr>
                                        </tfoot>

                                    </table>

                                </div>
                            </div>


                            <!-- ================= FALL ================= -->
                            <div class="tab-pane fade"
                                 id="ofAdmissionTargetsAchieved-fall"
                                 role="tabpanel">

                                <div class="table-responsive text-nowrap">

                                    <table class="table table-striped align-middle custom-table">

                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Total Target</th>
                                                <th>Total Achieved</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>1</td>

                                                <td>
                                                    {{ number_format($fall['total_target'], 1) }}
                                                </td>

                                                <td>
                                                    {{ number_format($fall['total_achieved'], 1) }}
                                                </td>

                                                <td>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_fall->color }}">
                                                        {{ number_format($fall_percentage, 1) }}%
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_fall->color }}">
                                                        {{ $meta_fall->rating }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <tr class="table-primary">

                                                <th>Total (S + F)</th>

                                                <th>
                                                    {{ number_format($data['total_target'] ?? 0, 1) }}
                                                </th>

                                                <th>
                                                    {{ number_format($data['total_achieved'] ?? 0, 1) }}
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_leader_avg_percentage->color }}">
                                                        {{ number_format($leader_avg_percentage, 1) }}%
                                                    </span>
                                                </th>

                                                <th>
                                                    <span class="badge"
                                                          style="background-color: {{ $meta_leader_avg_percentage->color }}">
                                                        {{ $meta_leader_avg_percentage->rating }}
                                                    </span>
                                                </th>

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



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
                                    
                                        @php
    $IndustrialProjects = IndustrialProjects(Auth::user()->employee_id, $activeRoleId, 198);
                                        @endphp
                                        @foreach ($IndustrialProjects as $project)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $project->target }}</td> <!-- Required target -->
                                                <td>{{ $project->achieved_count }}</td> <!-- Achieved count -->
                                                <td>
                                                    <div class="badge" style="background-color: {{ $project->color }}">
                                                        {{ number_format($project->percentage, 1) }}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="badge" style="background-color: {{ $project->color }}">

                                                        {{ $project->rating }}
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
@endif
@if(in_array(getRoleName(activeRole()), ['HOD']))
    <!--  Payment Methods modal -->

    <div class="modal fade" id="IndustrialProjects" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Industrial Projects
                    </h3>
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
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
                                            $data = departmentTargetIndicatorsAnalysisOfHOD(Auth::user()->employee_id, $activeRoleId, 2, 8, 198);
                                            $avg = $data['department_avg_percentage'];
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
                                        @if($data['total_target'] > 0)
                                            <tr>
                                                <td>1</td>
                                                <td>{{ $data['total_target'] }}</td>
                                                <td>{{ $data['total_submitted'] }}</td>
                                                <td>
                                                    <div class="badge bg-{{ $color }}">
                                                        {{number_format($data['department_avg_percentage']) }}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="badge bg-{{ $color }}">
                                                        {{ $rating }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No record found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th colspan="2" class="text-end"></th>
                                            <th>
                                                <b>
                                                    {{number_format($data['department_avg_percentage'], 1) }}
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
<!-- / Payment Methods modal -->
@if(in_array(getRoleName(activeRole()), ['Dean']))
<!--  Payment Methods modal -->

    <div class="modal fade" id="IndustrialProjects" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Industrial Projects
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
                                                $data=ResearchInnovationAndCommercialization(Auth::user()->employee_id, $activeRoleId, 2, 8, 198);
                        
                                            @endphp
                                                @foreach($data['records'] as $record)
                                                <tr>
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td> {{ $record->user?->department?->name ?? '' }}</td>
                                                    <td><div class="badge bg-{{ $record->color }}">
                                                        {{ $record->score}}%
                                                        </div></td>
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


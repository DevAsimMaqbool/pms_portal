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
<!-- / Payment Methods modal -->
<div class="modal fade" id="ofAdmissionTargetsAchieved" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    % of Admission Targets Achieved
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#ofAdmissionTargetsAchieved-spring"
                                    aria-controls="ofAdmissionTargetsAchieved-spring" aria-selected="true">
                                    🌸 Spring {{ date('Y') }}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#ofAdmissionTargetsAchieved-fall"
                                    aria-controls="ofAdmissionTargetsAchieved-fall" aria-selected="false">
                                    🍂 Fall {{ date('Y') }}
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="ofAdmissionTargetsAchieved-spring"
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
                                            @php
                                                $data=admissionTargetDepartmentAverage(Auth::user()->employee_id, $activeRoleId, 143); 
                                                if (!function_exists('ratingFunctions')) {
                                                    function ratingFunctions($average)
                                                    {
                                                        if ($average >= 90)
                                                            return ['OS', 'primary'];
                                                        if ($average >= 80)
                                                            return ['EE', 'success'];
                                                        if ($average >= 70)
                                                            return ['ME', 'warning'];
                                                        if ($average >= 60)
                                                            return ['NI', 'orange'];
                                                        return ['BE', 'danger'];
                                                    }
                                                }
                                            @endphp
                                                @php
                                                    [$rating, $color] = ratingFunctions($data['records']['Spring']['percentage']);
                                                    
                                                @endphp
                                                 <tr>
                                                    <td>1</td>
                                                    <td>{{ $data['records']['Spring']['total_target'] }}</td>
                                                    <td>{{ $data['records']['Spring']['total_achieved'] }}</td>
                                                    <td><div class="badge bg-{{ $color }}">{{ $data['records']['Spring']['percentage'] }}%</div></td>
                                                    <td><div class="badge bg-label-{{ $color }}">{{ $rating }}</div></td>
                                                </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th class="">Total (S+F){{number_format($data['total_target'], 1) }}</th>
                                            <th class="">Total (S+F){{number_format($data['total_achieved'], 1) }}</th>
                                            <th class="">AVG (S+F){{number_format($data['avg_percentage'], 1) }}</th>
                                           <th class="">W: {{number_format($data['weighted_score'], 1) }}</th>
                                        </tr>
                                    </tfoot>
                                    
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="ofAdmissionTargetsAchieved-fall" role="tabpanel">
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
                                            @php
                                                $data=admissionTargetDepartmentAverage(Auth::user()->employee_id, $activeRoleId, 143); 
                                                if (!function_exists('ratingFunctions')) {
                                                    function ratingFunctions($average)
                                                    {
                                                        if ($average >= 90)
                                                            return ['OS', 'primary'];
                                                        if ($average >= 80)
                                                            return ['EE', 'success'];
                                                        if ($average >= 70)
                                                            return ['ME', 'warning'];
                                                        if ($average >= 60)
                                                            return ['NI', 'orange'];
                                                        return ['BE', 'danger'];
                                                    }
                                                }
                                            @endphp
                                                @php
                                                    [$rating, $color] = ratingFunctions($data['records']['Fall']['percentage']);
                                                    
                                                @endphp
                                                 <tr>
                                                    <td>1</td>
                                                    <td>{{ $data['records']['Fall']['total_target'] }}</td>
                                                    <td>{{ $data['records']['Fall']['total_achieved'] }}</td>
                                                    <td><div class="badge bg-{{ $color }}">{{ $data['records']['Fall']['percentage'] }}%</div></td>
                                                    <td><div class="badge bg-label-{{ $color }}">{{ $rating }}</div></td>
                                                </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th class="">Total (S+F){{number_format($data['total_target'], 1) }}</th>
                                            <th class="">Total (S+F){{number_format($data['total_achieved'], 1) }}</th>
                                            <th class="">AVG (S+F){{number_format($data['avg_percentage'], 1) }}</th>
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
</div>

<!-- / Payment Methods modal -->
@endif
@if(in_array(getRoleName(activeRole()), ['Dean']))
<!--  Payment Methods modal -->

    <div class="modal fade" id="ofAdmissionTargetsAchieved" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>% of Admission Targets Achieved
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
                                                $data=ResearchInnovationAndCommercialization(Auth::user()->employee_id, $activeRoleId, 3, 10, 143);
                                                $faculty_avg_percentage = $data['faculty_avg_percentage'] ?? 0;
                                                $meta_avg = getRatingMeta($faculty_avg_percentage);
                        
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
<!-- / Payment Methods modal -->
<div class="modal fade" id="ofAdmissionTargetsAchieved" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    % of Admission Targets Achieved
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#ofAdmissionTargetsAchieved-spring"
                                    aria-controls="ofAdmissionTargetsAchieved-spring" aria-selected="true">
                                    🌸 Spring {{ date('Y') }}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#ofAdmissionTargetsAchieved-fall"
                                    aria-controls="ofAdmissionTargetsAchieved-fall" aria-selected="false">
                                    🍂 Fall {{ date('Y') }}
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="ofAdmissionTargetsAchieved-spring"
                            role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Program</th>
                                            <th>Total Target</th>
                                            <th>Total Achieved</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @php
                                                $roleName = getRoleName(activeRole());
                                                $value = match($roleName) {
                                                    'Program Leader UG' => 'UG',
                                                    'Program Leader PG' => 'PG',
                                                    default => ''
                                                };
                                                $data=admissionTargetAverageForPL(Auth::user()->employee_id, $activeRoleId, 3, 10, 143, $value); 
                                                if (!function_exists('ratingFunctions')) {
                                                    function ratingFunctions($average)
                                                    {
                                                        if ($average >= 90)
                                                            return ['OS', 'primary'];
                                                        if ($average >= 80)
                                                            return ['EE', 'success'];
                                                        if ($average >= 70)
                                                            return ['ME', 'warning'];
                                                        if ($average >= 60)
                                                            return ['NI', 'orange'];
                                                        return ['BE', 'danger'];
                                                    }
                                                }
                                            @endphp
                                                @foreach($data['records']['Spring'] ?? [] as $index => $Spring)
                                                    @php
                                                        [$rating, $color] = ratingFunctions($Spring['percentage']);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $Spring['program'] }}</td>
                                                        <td>{{ $Spring['target'] }}</td>
                                                        <td>{{ $Spring['achieved'] }}</td>
                                                        <td><div class="badge bg-{{ $color }}">{{ $Spring['percentage'] }}%</div></td>
                                                        <td><div class="badge bg-label-{{ $color }}">{{ $rating }}</div></td>
                                                    </tr>
                                                @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th class=""></th>
                                            <th class="">Total (S+F){{number_format($data['total_target'], 1) }}</th>
                                            <th class="">Total (S+F){{number_format($data['total_achieved'], 1) }}</th>
                                            <th class="">AVG (S+F){{number_format($data['avg_percentage'], 1) }}</th>
                                           <th class="">W: {{number_format($data['weighted_score'], 1) }}</th>
                                        </tr>
                                    </tfoot>
                                    
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="ofAdmissionTargetsAchieved-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                 <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Program</th>
                                            <th>Total Target</th>
                                            <th>Total Achieved</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @php
                                                $roleName = getRoleName(activeRole());
                                                $value = match($roleName) {
                                                    'Program Leader UG' => 'UG',
                                                    'Program Leader PG' => 'PG',
                                                    default => ''
                                                };
                                                $data=admissionTargetAverageForPL(Auth::user()->employee_id, $activeRoleId, 3, 10, 143, $value);  
                                                if (!function_exists('ratingFunctions')) {
                                                    function ratingFunctions($average)
                                                    {
                                                        if ($average >= 90)
                                                            return ['OS', 'primary'];
                                                        if ($average >= 80)
                                                            return ['EE', 'success'];
                                                        if ($average >= 70)
                                                            return ['ME', 'warning'];
                                                        if ($average >= 60)
                                                            return ['NI', 'orange'];
                                                        return ['BE', 'danger'];
                                                    }
                                                }
                                            @endphp
                                                @foreach($data['records']['Fall'] ?? [] as $index => $fall)
                                                @php
                                                    [$rating, $color] = ratingFunctions($fall['percentage']);
                                                @endphp
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $fall['program'] }}</td>
                                                    <td>{{ $fall['target'] }}</td>
                                                    <td>{{ $fall['achieved'] }}</td>
                                                    <td><div class="badge bg-{{ $color }}">{{ $fall['percentage'] }}%</div></td>
                                                    <td><div class="badge bg-label-{{ $color }}">{{ $rating }}</div></td>
                                                </tr>
                                            @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th class=""></th>
                                            <th class="">Total (S+F){{number_format($data['total_target'], 1) }}</th>
                                            <th class="">Total (S+F){{number_format($data['total_achieved'], 1) }}</th>
                                            <th class="">AVG (S+F){{number_format($data['avg_percentage'], 1) }}</th>
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
</div>

<!-- / Payment Methods modal -->
@endif



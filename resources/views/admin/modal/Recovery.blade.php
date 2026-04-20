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
<div class="modal fade" id="Recovery" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Recovery%
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#Recovery-spring"
                                    aria-controls="Recovery-spring" aria-selected="true">
                                    🌸 Yearly
                                </button>
                            </li>
                            
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="Recovery-spring"
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
                                                $data=recoveryTargetDepartmentAveraget(Auth::user()->employee_id, $activeRoleId, 146); 
                                                $avg_percentage = $data['avg_percentage'] ?? 0;
                                                $meta_avg_percentage = getRatingMeta($avg_percentage);
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
                                                @foreach($data['records'] as $record)
                                                @php
                                                    [$rating, $color] = ratingFunctions($record['percentage']);
                                                    
                                                @endphp
                                                <tr>
                                                   <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $record['program_name'] }}</td>
                                                    <td>{{ $record['total_target'] }}</td>
                                                    <td>{{ $record['total_achieved'] }}</td>
                                                    <td><div class="badge bg-{{ $color }}">
                                                        {{ $record['percentage']}}%
                                                        </div></td>
                                                    <td>
                                                            <div class="badge bg-label-{{ $color }}">

                                                                {{ $rating }}
                                                            </div>
                                                    </td>    
                                                </tr>
                                            @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th class=""></th>
                                            <th class="">{{number_format($data['total_target'], 1) }}</th>
                                            <th class="">{{number_format($data['total_achieved'], 1) }}</th>
                                            <th class="fs-6"><span class="badge" style="background-color: {{ $meta_avg_percentage->color }}">{{number_format($avg_percentage, 1) }}</span></th>
                                           {{-- <th class="">W: {{number_format($data['weighted_score'], 1) }}</th> --}}
                                           <th class="fs-6 text-white">
                                                 <span class="badge" style="background-color: {{ $meta_avg_percentage->color }}">
                                                                 {{ $meta_avg_percentage->rating }}
                                                 </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    
                                </table>    
                                    
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="Recovery-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                 
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

    <div class="modal fade" id="Recovery" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Recovery%
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
                                                $data=ResearchInnovationAndCommercialization(Auth::user()->employee_id, $activeRoleId, 3, 11, 146);
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
<div class="modal fade" id="Recovery" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Recovery%
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#Recovery-spring"
                                    aria-controls="Recovery-spring" aria-selected="true">
                                    🌸 Yearly
                                </button>
                            </li>
                            
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="Recovery-spring"
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
                                            $roleName = getRoleName(activeRole());
                                            $value = match($roleName) {
                                                'Program Leader UG' => 'UG',
                                                'Program Leader PG' => 'PG',
                                                default => ''
                                            }; 
                                            $data=recoveryTargetAverageForPL(Auth::user()->employee_id, $activeRoleId, 3, 11, 146,$value); 

                                            $avg = $data['avg_percentage'] ?? 0;
                                            $meta_avg = getRatingMeta($avg);
                                        @endphp
                                        @if($data['total_target'] > 0)
                                            <tr>
                                                <td>1</td>
                                                <td>{{ $data['total_target'] }}</td>
                                                <td>{{ $data['total_achieved'] }}</td>
                                                <td>
                                                    <span class="badge" style="background-color: {{ $meta_avg->color }}">
                                                        {{number_format($avg) }}%
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background-color: {{ $meta_avg->color }}">
                                                        {{ $meta_avg->rating }}
                                                    </span>
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
                                            <th class=""></th>
                                            <th class=""></th>
                                            <th class="fs-6">
                                                <span class="badge" style="background-color: {{ $meta_avg->color }}">
                                                    {{number_format($avg) }}%
                                                </span>
                                            </th>
                                            <th class="fs-6">
                                                <span class="badge" style="background-color: {{ $meta_avg->color }}">
                                                    {{ $meta_avg->rating }}
                                                </span>
                                            </th>
                                       
                                        </tr>
                                    </tfoot>
                                    
                                </table>    
                                    
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="Recovery-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                 
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

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
     $currentYear = SelectCurrentYear(1)->first();                                
 @endphp
 @if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor','Non Phd AP']))
<!--  Payment Methods modal -->

    <div class="modal fade" id="JournalQuartile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Journal Quartile
                    </h3>
                    <button type="button" class="mb-3 btn rounded-pill btn-primary waves-effect waves-light">{{ $currentYear->year }}</button>
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Total Q1</th>
                                            <th>Total Q2</th>
                                            <th>Total Q3</th>
                                            <th>Total Q4</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @php
                                                $data= calculateJournalQuartile(Auth::user()->employee_id, $activeRoleId, 128,$currentYear->id);
                                                $avg = $data['total_score'] ?? 0;
                                                $meta = getRatingMeta($avg);
                                            @endphp
                                            
                                                @if($data['total_score'] > 0)
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ number_format($data['q1_count']) }}</td>
                                                        <td>{{ number_format($data['q2_count']) }}</td>
                                                        <td>{{ number_format($data['q3_count']) }}</td>
                                                        <td>{{ number_format($data['q4_count']) }}</td>
                                                        <td>
                                                            <span class="badge" style="background-color: {{ $meta->color }}">
                                                                {{number_format($avg) }}%
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge" style="background-color: {{ $meta->color }}">
                                                                 {{ $meta->rating }}
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
                                            <th colspan="4" class="text-end"></th>
                                            <th class="fs-6">
                                                <span class="badge" style="background-color: {{ $meta->color }}">
                                                    {{number_format($avg, 1) }}
                                                </span>
                                            </th>
                                            <th class="fs-6 text-white">
                                                <span class="badge" style="background-color: {{ $meta->color }}">
                                                                 {{ $meta->rating }}
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
    <!-- / Payment Methods modal -->
@endif
@if(in_array(getRoleName(activeRole()), ['HOD']))
<!--  Payment Methods modal -->

    <div class="modal fade" id="JournalQuartile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Journal Quartile
                    </h3>
                    <button type="button" class="mb-3 btn rounded-pill btn-primary waves-effect waves-light">{{ $currentYear->year }}</button>
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Total Q1</th>
                                            <th>Total Q2</th>
                                            <th>Total Q3</th>
                                            <th>Total Q4</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @php
                                                $data=departmentScopusAnalysisOfHOD($activeRoleId, 128,2,5,$currentYear->id);
                                                $avg = $data['department_quartile_score'] ?? 0;
                                                $meta = getRatingMeta($avg);
                                            @endphp
                                                @if($data['total_target'] > 0)
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ number_format($data['q1_count']) }}</td>
                                                        <td>{{ number_format($data['q2_count']) }}</td>
                                                        <td>{{ number_format($data['q3_count']) }}</td>
                                                        <td>{{ number_format($data['q4_count']) }}</td>
                                                        <td>
                                                            <span class="badge" style="background-color: {{ $meta->color }}">
                                                                {{number_format($avg) }}%
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge" style="background-color: {{ $meta->color }}">
                                                                 {{ $meta->rating }}
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
                                            <th colspan="4" class="text-end"></th>
                                            <th class="fs-6">
                                                <span class="badge" style="background-color: {{ $meta->color }}">
                                                    {{number_format($avg, 1) }}
                                                </span>
                                            </th>
                                            <th class="fs-6 text-white">
                                                <span class="badge" style="background-color: {{ $meta->color }}">
                                                                 {{ $meta->rating }}
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
    <!-- / Payment Methods modal -->
@endif

@if(in_array(getRoleName(activeRole()), ['Dean']))

    @php

        $data = facultyScopusAnalysisOfDean(
            $activeRoleId,
            128,
            2,
            5,
            $currentYear->id
        );

        $avg = $data['department_quartile_score'] ?? 0;

        $meta = getRatingMeta($avg);

    @endphp

    <!-- Research Publications Modal -->

    <div class="modal fade" id="JournalQuartile" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content custom-modal">

                <div class="modal-header">

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                </div>

                <div class="modal-body text-center p-4">

                    <h3 class="text-center mb-4 fw-bold text-primary">

                        <div class="badge bg-label-primary rounded p-2">

                            <i class="icon-base ti tabler-clock-hour-2 icon-md"></i>

                        </div>

                        Journal Quartile

                    </h3>

                    <button type="button"
                            class="mb-3 btn rounded-pill btn-primary waves-effect waves-light">

                        {{ $currentYear->year }}

                    </button>

                    <div class="card">

                        <div class="card-body">

                            <!-- Faculty Summary -->

                            <h5 class="text-primary fw-bold mb-3">
                                Faculty Overall Journal Quartile
                            </h5>

                            <div class="table-responsive">

                                <table class="table table-striped align-middle custom-table">

                                    <thead class="table-primary">

                                        <tr>
                                            <th>Sr#</th>
                                            <th>Q1</th>
                                            <th>Q2</th>
                                            <th>Q3</th>
                                            <th>Q4</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @if($data['total_target'] > 0)

                                            <tr>

                                                <td>1</td>

                                                <td>
                                                    {{ number_format($data['q1_count']) }}
                                                </td>

                                                <td>
                                                    {{ number_format($data['q2_count']) }}
                                                </td>
                                                <td>
                                                    {{ number_format($data['q3_count']) }}
                                                </td>
                                                <td>
                                                    {{ number_format($data['q4_count']) }}
                                                </td>

                                                <td>

                                                    <span class="badge"
                                                          style="background-color: {{ $meta->color }}">

                                                        {{ number_format($avg, 2) }}%

                                                    </span>

                                                </td>

                                                <td>

                                                    <span class="badge"
                                                          style="background-color: {{ $meta->color }}">

                                                        {{ $meta->rating }}

                                                    </span>

                                                </td>

                                            </tr>

                                        @else

                                            <tr>

                                                <td colspan="5" class="text-center">
                                                    No record found
                                                </td>

                                            </tr>

                                        @endif

                                    </tbody>

                                    <tfoot>

                                        <tr class="table-primary">

                                            <th>Total</th>

                                            <th>
                                                {{ number_format($data['q1_count']) }}
                                            </th>

                                            <th>
                                                {{ number_format($data['q2_count']) }}
                                            </th>
                                              <th>
                                                {{ number_format($data['q3_count']) }}
                                            </th>
                                              <th>
                                                {{ number_format($data['q4_count']) }}
                                            </th>

                                            <th>

                                                <span class="badge"
                                                      style="background-color: {{ $meta->color }}">

                                                    {{ number_format($avg, 2) }}%

                                                </span>

                                            </th>

                                            <th>

                                                <span class="badge"
                                                      style="background-color: {{ $meta->color }}">

                                                    {{ $meta->rating }}

                                                </span>

                                            </th>

                                        </tr>

                                    </tfoot>

                                </table>

                            </div>

                            <hr class="my-4">

                            <!-- Individual HOD Details -->

                            <h5 class="text-primary fw-bold mb-3">
                                HOD Wise Journal Quartile
                            </h5>

                            <div class="table-responsive">

                                <table class="table table-striped table-bordered align-middle">

                                    <thead class="table-primary">

                                        <tr>

                                            <th>Sr#</th>
                                            <th>HOD Name</th>
                                            <th>Department</th>
                                            <th>Quartile Score</th>
                                            <th>Q1</th>
                                            <th>Q2</th>
                                            <th>Q3</th>
                                            <th>Q4</th>
                                            <th>Score</th>
                                            <th>Rating</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse($data['hod_details'] as $hodIndex => $hod)

                                            @php

                                                $hodMeta = getRatingMeta(
                                                    $hod['department_quartile_score']
                                                );

                                            @endphp

                                            <tr>

                                                <td>
                                                    {{ $hodIndex + 1 }}
                                                </td>

                                                <td>
                                                    {{ $hod['hod_name'] }}
                                                </td>

                                                <td>
                                                    {{ $hod['department_name'] }}
                                                </td>

                                                <td>
                                                    {{ number_format($hod['department_quartile_score'], 2) }}
                                                </td>

                                                <td>
                                                    {{ $hod['q1_count'] }}
                                                </td>

                                                <td>
                                                    {{ $hod['q2_count'] }}
                                                </td>

                                                <td>
                                                    {{ $hod['q3_count'] }}
                                                </td>

                                                <td>
                                                    {{ $hod['q4_count'] }}
                                                </td>

                                                <td>

                                                    <span class="badge"
                                                          style="background-color: {{ $hodMeta->color }}">

                                                        {{ number_format($hod['department_quartile_score'], 2) }}%

                                                    </span>

                                                </td>

                                                <td>

                                                    <span class="badge"
                                                          style="background-color: {{ $hodMeta->color }}">

                                                        {{ $hodMeta->rating }}

                                                    </span>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td colspan="13" class="text-center">
                                                    No HOD target records found.
                                                </td>

                                            </tr>

                                        @endforelse

                                    </tbody>

                                    <tfoot>

                                        <tr class="table-primary fw-bold">

                                            <th colspan="3">
                                                Faculty Total
                                            </th>


                                            <th>
                                                {{ number_format($data['department_quartile_score'], 2) }}
                                            </th>

                                            <th>
                                                {{ $data['q1_count'] }}
                                            </th>

                                            <th>
                                                {{ $data['q2_count'] }}
                                            </th>

                                            <th>
                                                {{ $data['q3_count'] }}
                                            </th>

                                            <th>
                                                {{ $data['q4_count'] }}
                                            </th>

                                            <th>

                                                <span class="badge"
                                                      style="background-color: {{ $meta->color }}">

                                                    {{ number_format($avg, 2) }}%

                                                </span>

                                            </th>

                                            <th>

                                                <span class="badge"
                                                      style="background-color: {{ $meta->color }}">

                                                    {{ $meta->rating }}

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

@endif

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
<!--  Payment Methods modal -->

    <div class="modal fade" id="ofFacultyEngagementinthedepartmentthroughvarioustasksassignmentsroles" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>% of Faculty Engagement in the department (through various tasks/assignments/roles)
                    </h3>
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Task</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @php
                                                $data=lineManagerReviewRatingOnTasks169(Auth::user()->employee_id, $activeRoleId);
                                               
                                            @endphp
                                            @foreach($data['ratings'] as $record)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $record->task }}</td>
                                                    <td>
                                                        <div class="badge {{ $record->rating_data['color'] }}">
                                                            {{ $record->rating_data['percentage'] }}%
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="badge bg-label-{{ str_replace('bg-', '', $record->rating_data['color']) }}">
                                                            {{ $record->rating_data['label'] }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th colspan="" class="text-end"></th>
                                            <th>
                                                <b>
                                                    {{number_format($data['total_score'], 1) }}
                                                </b>
                                            </th>
                                            <th>
                                                <b>
                                                    AVG: {{number_format($data['average_score'], 1) }}
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
    <!-- / Payment Methods modal -->
@endif

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
    $totalPercentage=0;                               
 @endphp
<!--  Payment Methods modal -->
<div class="modal fade" id="PerformanceOnTasksAssignedByTheDean" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Performance On Tasks Assigned By The Dean
                </h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                    </div>
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
                                    @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
                                        @php
                                            $feedbacks = lineManagerReviewRatingOnTasks(Auth::user()->employee_id, $activeRoleId);
                                            $totalPercentage = $feedbacks->sum(fn($item) => $item->rating_data['percentage']);
                                        @endphp
                                                @forelse($feedbacks as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->task }}</td>
                                                        <td>
                                                            <div class="badge {{ $item->rating_data['color'] }}">
                                                                {{ number_format($item->rating_data['percentage'], 1) }}%
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $item->rating_data['color'] }}">
                                                                {{ $item->rating_data['label'] }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No record found</td>
                                                    </tr>
                                                @endforelse
                                    @endif
                                </tbody>
                                <tfoot>
                                        <tr class="table-primary">
                                            <th class="">Total</th>
                                            <th  class="text-end"></th>
                                            <th>
                                                <b>
                                                    {{ number_format($totalPercentage, 1) }}
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
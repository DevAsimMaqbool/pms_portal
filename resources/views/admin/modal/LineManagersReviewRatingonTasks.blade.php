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
<!-- / Payment Methods modal -->
<div class="modal fade" id="LineManagersReviewRatingonTasks" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Line Manager's Review & Rating on Tasks
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#LineManagersReview&RatingonTasks-spring"
                                    aria-controls="LineManagersReview&RatingonTasks-spring" aria-selected="true">
                                    🌸 Spring 2026
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#LineManagersReview&RatingonTasks-fall"
                                    aria-controls="LineManagersReview&RatingonTasks-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="LineManagersReview&RatingonTasks-spring"
                            role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Virtue</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4">no record found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="LineManagersReview&RatingonTasks-fall" role="tabpanel">
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
                                    @php
                                        // Initialize totalFeedback to 0 in case nothing is set later
                                        $totalPercentage = 0;
                                    @endphp

                                    <tbody>
                                        @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
                                            @php
                                                $feedbacks = lineManagerReviewRatingOnTasks(Auth::user()->employee_id, $activeRoleId);
                                                // ✅ Fast sum of all rating percentages
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
                                            <th class="text-end"></th>
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
</div>

<!-- / Payment Methods modal -->
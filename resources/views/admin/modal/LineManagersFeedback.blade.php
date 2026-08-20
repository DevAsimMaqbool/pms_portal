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
<!-- / Payment Methods modal -->
<div class="modal fade" id="LineManagersFeedback" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    Line Manager's Feedback
                </h3>
                <button type="button" class="mb-3 btn rounded-pill btn-primary waves-effect waves-light">{{ $currentYear->year }}</button>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <!-- Tab Content -->
                    <div class="tab-content">

                        <!-- Fall -->
                        <div class="tab-pane fade show active" id="LineManagersFeedback-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Virtue</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>

                                    @php
                                        // Initialize totalPercentage to 0 in case nothing is set later
                                        $totalPercentage = 0;
                                    @endphp

                                    <tbody>
                                        @if(
                                                in_array(getRoleName(activeRole()), [
                                                    'Teacher',
                                                    'Assistant Professor',
                                                    'Associate Professor',
                                                    'Professor',
                                                    'Program Leader UG',
                                                    'Program Leader PG'
                                                ])
                                            )

                                            @php
                                                $feedbacks = lineManagerRatingOnTasks(
                                                    Auth::user()->employee_id,
                                                    $activeRoleId,
                                                    $currentYear->id
                                                );

                                                // Get all virtues from feedbacks
                                                $virtues = $feedbacks->flatMap(function ($item) {
                                                    return $item->virtues ?? [];
                                                });

                                                // Same existing total percentage logic, but based on virtues
                                                $totalPercentage = $virtues->avg(function ($item) {
                                                    return $item['rating_data']['percentage'];
                                                });
                                            @endphp

                                            @forelse($virtues as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>

                                                    <td>
                                                        {{ $item['name'] }}
                                                    </td>

                                                    <td>
                                                        <div class="badge {{ $item['rating_data']['color'] }}">
                                                            {{ number_format($item['rating_data']['percentage'], 1) }}%
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="badge {{ $item['rating_data']['color'] }}">
                                                            {{ number_format($item['rating_data']['percentage'], 1) }}%
                                                        </div>
                                                    </td>
                                                </tr>

                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        No record found
                                                    </td>
                                                </tr>
                                            @endforelse

                                        @endif
                                    </tbody>

                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="text-center">Total</th>

                                            <th colspan="" class="text-end"></th>

                                            <th style="font-size: 0.960rem;">
                                                <b class="badge"
                                                    style="background-color: {{ getRatingMeta($totalPercentage)->color }}">
                                                    {{ number_format($totalPercentage, 1) }}%
                                                </b>
                                            </th>

                                            <th style="font-size: 0.960rem;">
                                                <b class="badge"
                                                    style="background-color: {{ getRatingMeta($totalPercentage)->color }}">
                                                    {{ getRatingMeta($totalPercentage)->rating }}
                                                </b>
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
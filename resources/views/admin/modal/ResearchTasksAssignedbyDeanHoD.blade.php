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
    $totalPercentage = 0;
    $currentYear = SelectCurrentYear(1)->first();                             
 @endphp
@if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Program Leader UG', 'Program Leader PG']))
    <!-- / Payment Methods modal -->
    <div class="modal fade" id="ResearchTasksAssignedbyDeanHOD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        Research Tasks Assigned by Dean / HOD
                    </h3>
                    <button type="button"
                        class="mb-3 btn rounded-pill btn-primary waves-effect waves-light">{{ $currentYear->year }}</button>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">

                        <!-- Tab Content -->
                        <div class="tab-content">

                            <!-- Fall -->
                            <div class="tab-pane fade show active" id="ResearchTasksAssignedbyDeanHOD-spring"
                                role="tabpanel">
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
                                            @if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Program Leader UG', 'Program Leader PG']))
                                                @php
                                                    $feedbacks = ResearchTasksAssignedbyDeanHOD(Auth::user()->employee_id, $activeRoleId, $currentYear->id);
                                                    // ✅ Fast sum of all rating percentages
                                                    $totalPercentage = $feedbacks->sum(fn($item) => $item->rating_data['percentage']);
                                                    $meta_totalPercentage = getRatingMeta($totalPercentage);
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
                                                <th class="fs-6 text-white">
                                                    <span class="badge"
                                                        style="background-color: {{ $meta_totalPercentage->color }}">
                                                        {{ number_format($totalPercentage, 1) }}
                                                    </span>
                                                </th>
                                                <th class="fs-6 text-white">
                                                    <span class="badge"
                                                        style="background-color: {{ $meta_totalPercentage->color }}">
                                                        {{ $meta_totalPercentage->rating }}
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
@if(in_array(getRoleName(activeRole()), ['HOD']))
    <!--  Payment Methods modal -->
    <div class="modal fade" id="ResearchTasksAssignedbyDeanHOD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        Research Tasks Assigned by Dean / HOD
                    </h3>
                    <button type="button"
                        class="mb-3 btn rounded-pill btn-primary waves-effect waves-light">{{ $currentYear->year }}</button>
                    <!-- Tabs -->
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
                                            <th>Total Task</th>
                                            <th>Total Score</th>
                                            <th>Weight Score</th>
                                            <th>Avg Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $data = departmentResearchTasksAssignedbyDeanHOD(Auth::user()->employee_id, $activeRoleId, $currentYear->id);
                                            $avg = $data['department_avg_score'] ?? 0;
                                            $meta = getRatingMeta($avg);
                                        @endphp
                                        @if(!empty($data))
                                            <tr>
                                                <td>1</td>
                                                <td>{{ $data['total_task'] }}</td>
                                                <td>{{ $data['total_Score'] }}</td>
                                                <td>{{ $data['weighted_scores']['175'] }}</td>
                                                <td>
                                                    <div class="badge" style="background-color: {{ $meta->color }}">
                                                        {{number_format($avg) }}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="badge" style="background-color: {{ $meta->color }}">
                                                        {{ $meta->rating }}
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
                                            <th colspan="3" class="text-end"></th>
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
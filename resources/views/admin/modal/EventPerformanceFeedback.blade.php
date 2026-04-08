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
@if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
    <!-- / Payment Methods modal -->
    <div class="modal fade" id="EventPerformanceFeedback" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        Event Performance Feedback
                    </h3>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                            <!-- <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                                                                                <input type="radio" class="btn-check" name="btnradio06" id="dailyRadio06" checked>
                                                                                <label class="btn btn-outline-secondary waves-effect" for="dailyRadio05"> 📅 Weekly</label>

                                                                                <input type="radio" class="btn-check" name="btnradio06" id="monthlyRadio06">
                                                                                <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio05"> 🎓
                                                                                    Semesterly</label>

                                                                                <input type="radio" class="btn-check" name="btnradio06" id="yearlyRadio06">
                                                                                <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio06"> 📅 Yearly</label>
                                                                            </div> -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Event</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @php
                                            $feedbacks = lineManagerRatingOnEvents(Auth::user()->employee_id, $activeRoleId);
                                            // ✅ SUM of all rating percentages
                                            $totalPercentage = $feedbacks->sum(fn($item) => $item->rating_data['percentage']);
                                        @endphp
                                        @foreach($feedbacks as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->event_name }}</td>
                                                <td>
                                                    <div class="badge {{ $item->rating_data['color'] }}">
                                                        {{ $item->rating_data['percentage'] }}%
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $item->rating_data['color'] }} me-1">
                                                        {{ $item->rating_data['label'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach

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
@endif
@if(in_array(getRoleName(activeRole()), ['HOD']))
    <!-- / Payment Methods modal -->
    <div class="modal fade" id="EventPerformanceFeedback" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        Event Performance Feedback
                    </h3>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                            <!-- <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                                        <input type="radio" class="btn-check" name="btnradio06" id="dailyRadio06" checked>
                                        <label class="btn btn-outline-secondary waves-effect" for="dailyRadio05"> 📅 Weekly</label>

                                        <input type="radio" class="btn-check" name="btnradio06" id="monthlyRadio06">
                                        <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio05"> 🎓
                                            Semesterly</label>

                                        <input type="radio" class="btn-check" name="btnradio06" id="yearlyRadio06">
                                        <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio06"> 📅 Yearly</label>
                                    </div> -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Event</th>
                                            <th>Total Feedback</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @php
                                            $data = departmentEventFeedbackAverage(Auth::user()->employee_id, $activeRoleId, 13, 28, 189);
                                        @endphp
                                        @foreach($data->rows as $index => $row)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>

                                                <td>{{ $row['event_name'] }}</td>
                                                <td>{{ $row['total_entries'] }}</td>

                                                <td>
                                                    <div class="badge" style="background-color: {{ $row['color'] }}">
                                                        {{ number_format($row['score'], 1) }}%
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="badge" style="background-color: {{ $row['color'] }}">
                                                        {{ $row['rating'] }}
                                                    </span>
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
<!-- / Payment Methods modal -->
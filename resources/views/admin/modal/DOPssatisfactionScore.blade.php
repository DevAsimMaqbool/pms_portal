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
<!--  Payment Methods modal -->
@if(in_array(getRoleName(activeRole()), ['HOD']))
    <div class="modal fade" id="DOPssatisfactionScore" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        DOPs satisfaction Score
                    </h3>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class=" table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Category</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @php
                                            $data = calculateLineManagerFeedbackAverage(Auth::user(), $activeRoleId, 178);
                                            // Use RAW values (NO rounding here)
                                            $categories = collect($data['categories']);
                                            // SINGLE SOURCE → SAME RESULT ALWAYS
                                            $overallAvg = round($categories->avg(), 1);

                                        @endphp

                                        @foreach($data['categories'] as $label => $avg)

                                            @php
                                                $meta = getRatingMeta($avg);
                                            @endphp

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $label }}</td>

                                                <td>
                                                    <div class="badge" style="background-color: {{ $meta->color }}">
                                                        {{ number_format($avg, 1) }}%
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="badge" style="background-color: {{ $meta->color }}">
                                                        {{ $meta->rating }}
                                                    </span>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th>Overall</th>
                                            <th colspan="1" class="text-end"></th>
                                            <th style="font-size: 0.960rem;">
                                                <b class="badge"
                                                    style="background-color: {{ getRatingMeta($overallAvg)->color }}">
                                                    {{ number_format($overallAvg, 1) }}%
                                                </b>
                                            </th>
                                            <th style="font-size: 0.960rem;"><b class="badge"
                                                    style="background-color: {{ getRatingMeta($overallAvg)->color }}">
                                                    {{ getRatingMeta($overallAvg)->rating }}
                                                </b></th>
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

    <div class="modal fade" id="DOPssatisfactionScore" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>DOPs satisfaction Score
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
                                            $data = ResearchInnovationAndCommercialization(Auth::user()->employee_id, $activeRoleId, 7, 16, 180);
                                            $faculty_avg_percentage = $data['faculty_avg_percentage'] ?? 0;
                                            $meta_avg = getRatingMeta($faculty_avg_percentage);

                                        @endphp
                                        @foreach($data['records'] as $record)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td> {{ $record->user?->department?->name ?? '' }}</td>
                                                <td>
                                                    <div class="badge bg-{{ $record->color }}">
                                                        {{ $record->score}}%
                                                    </div>
                                                </td>
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
@if(in_array(getRoleName(activeRole()), ['Program Leader PG', 'Program Leader UG']))
    <div class="modal fade" id="DOPssatisfactionScore" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        DOPs satisfaction Score
                    </h3>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold text-primary"></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class=" table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Category</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @php
                                            $data = calculateLineManagerFeedbackAverage(Auth::user(), $activeRoleId, 178);
                                            // Use RAW values (NO rounding here)
                                            $categories = collect($data['categories']);
                                            // SINGLE SOURCE → SAME RESULT ALWAYS
                                            $overallAvg = round($categories->avg(), 1);
                                        @endphp

                                        @foreach($data['categories'] as $label => $avg)

                                            @php
                                                $meta = getRatingMeta($avg);
                                            @endphp

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $label }}</td>

                                                <td>
                                                    <div class="badge" style="background-color: {{ $meta->color }}">
                                                        {{ number_format($avg, 1) }}%
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="badge" style="background-color: {{ $meta->color }}">
                                                        {{ $meta->rating }}
                                                    </span>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th>Overall</th>
                                            <th colspan="1" class="text-end"></th>
                                            <th style="font-size: 0.960rem;">
                                                <b class="badge"
                                                    style="background-color: {{ getRatingMeta($overallAvg)->color }}">
                                                    {{ number_format($overallAvg, 1) }}%
                                                </b>
                                            </th>
                                            <th style="font-size: 0.960rem;"><b class="badge"
                                                    style="background-color: {{ getRatingMeta($overallAvg)->color }}">
                                                    {{ getRatingMeta($overallAvg)->rating }}
                                                </b></th>
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
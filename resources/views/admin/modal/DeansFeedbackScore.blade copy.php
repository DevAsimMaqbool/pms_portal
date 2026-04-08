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
    <div class="modal fade" id="DeansFeedbackScore" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        Dean's Feedback Score
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
    $departmentId = auth()->user()->department_id;
    $employeeId = auth()->user()->employee_id;

    $employeeIds = \App\Models\User::where('department_id', $departmentId)->where('manager_id', $employeeId)
        ->pluck('employee_id')
        ->filter()
        ->toArray();

    $records = \App\Models\LineManagerFeedback::whereIn('employee_id', $employeeIds)
        ->where('status', 1)
        ->get();

    $categories = [
        'Responsibility & Accountability' => ['responsibility_accountability_1', 'responsibility_accountability_2'],
        'Empathy & Compassion' => ['empathy_compassion_1', 'empathy_compassion_2'],
        'Humility & Service' => ['humility_service_1', 'humility_service_2'],
        'Honesty & Integrity' => ['honesty_integrity_1', 'honesty_integrity_2'],
        'Inspirational Leadership' => ['inspirational_leadership_1', 'inspirational_leadership_2'],
    ];
                                        @endphp

                                        @foreach($categories as $label => $cols)

                                            @php
        $values = $records->map(function ($r) use ($cols) {
            $vals = array_filter([
                $r->{$cols[0]},
                $r->{$cols[1]}
            ], fn($v) => !is_null($v));

            return count($vals) ? array_sum($vals) / count($vals) : null;
        })->filter();

        $avg = $values->count() ? round($values->avg(), 2) : 0;

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
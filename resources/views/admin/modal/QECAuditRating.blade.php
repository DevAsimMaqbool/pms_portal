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

<div class="modal fade" id="QECAuditRating" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    QEC Audit Rating
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
                                        <th>Audit Term</th>
                                        <th>Faculty</th>
                                        <th>Department</th>
                                        <th>Program</th>
                                        <th>Career (PG/UG)</th>
                                        <th>Total Score</th>
                                        <th>Obtained Score</th>
                                        <th>Score</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @if(in_array(getRoleName(activeRole()), ['HOD']))
                                        @php
                                            $feedbacks = QECAuditRatingOfHOD(Auth::user()->employee_id, $activeRoleId);
                                            $sr = 1;
                                        @endphp

                                        @foreach($feedbacks as $class)
                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $class->audit_term }}</td>
                                                <td>{{ $class->faculty }}</td>
                                                <td>{{ $class->department }}</td>
                                                <td>{{ $class->program }}</td>
                                                <td>{{ $class->career }}</td>
                                                <td>{{ $class->total_score }}</td>
                                                <td>{{ $class->obtained_score }}</td>
                                                <td>
                                                    <span class="badge" style="background-color: {{ $class->color }}">
                                                        {{ $class->percentage }}%
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background-color: {{ $class->color }}">
                                                        {{ $class->rating }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- / Payment Methods modal -->
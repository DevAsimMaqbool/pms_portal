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
<div class="modal fade" id="StudentSatisfaction" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i
                            class="icon-base ti tabler-rewind-backward-50 icon-md"></i></div> Student Satisfaction
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#student-satisfaction-spring"
                                    aria-controls="student-satisfaction-spring" aria-selected="true">
                                    🌸 Spring 2026
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#student-satisfaction-fall"
                                    aria-controls="student-satisfaction-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="student-satisfaction-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Strength</th>
                                            <th>Respondent</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td colspan="8">no record found</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fall -->
                        <div class="tab-pane fade" id="student-satisfaction-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Strength</th>
                                            <th>Respondent</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    @php
                                        // Initialize totalFeedback to 0 in case nothing is set later
                                        $totalFeedback = 0;
                                    @endphp
                                    <tbody>
                                        @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
                                            @php
                                                $feedbackData = getFacultyClassWiseFeedback(Auth::user()->faculty_id);

                                                $classFeedback = $feedbackData['collection'] ?? collect();
                                                $totalFeedback = $feedbackData['totalFeedback'] ?? 0;
                                                if (!function_exists('ratingMeta')) {
                                                    function ratingMeta($average)
                                                    {
                                                        if ($average >= 90)
                                                            return ['OS', 'primary'];
                                                        if ($average >= 80)
                                                            return ['EE', 'success'];
                                                        if ($average >= 70)
                                                            return ['ME', 'warning'];
                                                        if ($average >= 60)
                                                            return ['NI', 'orange'];
                                                        return ['BE', 'danger'];
                                                    }
                                                }
                                            @endphp

                                            @forelse ($classFeedback as $index => $feedback)

                                                @php
                                                    /*
                                                    👉 Decide how you calculate average
                                                    Example: if you already have percentage stored
                                                    */
                                                    $average = (float) $feedback->feedback;
                                                    // OR calculate from multiple columns if needed

                                                    [$rating, $color] = ratingMeta($average);
                                                @endphp

                                                <tr>
                                                    <td>{{ $index + 1 }}</td>

                                                    {{-- Class Code --}}
                                                    <td>{{ $feedback->class_code }}</td>

                                                    {{-- Program --}}
                                                    <td>{{ $feedback->program ?? '—' }}</td>

                                                    {{-- Career --}}
                                                    <td>{{ $feedback->career_code ?? 'UG' }}</td>

                                                    {{-- Strength --}}
                                                    <td>{{ $feedback->registered_students ?? 0 }}</td>

                                                    {{-- Respondent --}}
                                                    <td>{{ $feedback->attempts ?? 0 }}</td>

                                                    {{-- Score --}}
                                                    <td>
                                                        <span class="badge bg-label-{{ $color }}">
                                                            {{ number_format($average, 1) }}%
                                                        </span>
                                                    </td>

                                                    {{-- Rating --}}
                                                    <td>
                                                        <span class="badge bg-label-{{ $color }}">
                                                            {{ $rating }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">
                                                        No class-wise feedback found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th class="text-end">Total</th>
                                            <th colspan="5" class="text-end"></th>
                                            <th>
                                                <b>
                                                    {{ number_format($totalFeedback, 1) }}
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
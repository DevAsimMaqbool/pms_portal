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
<div class="modal fade" id="StudentPassPercentage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Title -->
                <h3 class="text-center mb-4 fw-bold text-primary">
                    <div class="badge bg-label-primary rounded p-2"><i
                            class="icon-base ti tabler-percentage-75 icon-md"></i></div> Student Pass Percentage
                </h3>
                <!-- Tabs -->
                <div class="nav-align-top nav-tabs-shadow">
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#StudentPassPercentage-spring"
                                    aria-controls="StudentPassPercentage-spring" aria-selected="true">
                                    🌸 Spring 2025
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#StudentPassPercentage-fall"
                                    aria-controls="StudentPassPercentage-fall" aria-selected="false">
                                    🍂 Fall 2025
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Spring -->
                        <div class="tab-pane fade show active" id="StudentPassPercentage-spring" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Pass %</th>
                                            <th>Failed %</th>
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
                        <div class="tab-pane fade" id="StudentPassPercentage-fall" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Class</th>
                                            <th>Program</th>
                                            <th>Career (PG/UG)</th>
                                            <th>Pass %</th>
                                            <th>Failed %</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
                                            @php
                                                $data = myClasses(Auth::user()->faculty_id, $activeRoleId);
                                                $att = $data['classes'];
                                                $sr = 1;
                                            @endphp

                                                            @forelse($att as $class)
                                                                @php
                                                                    // latest attendance or null
                                                                    $latestAttendance = $class->attendances->first();
                                                                    $scheduled = $latestAttendance
                                                                        ? \Carbon\Carbon::parse($latestAttendance->class_date)->format('d-m-Y')
                                                                        : '-';
                                                                    $pass = $class->passing_percentage ?? 0;
                                                                    $fail = max(0, 100 - $pass);
                                                                    // Determine rating
                                                                    if ($pass >= 95) {
                                                                        $color = 'primary';
                                                                        $rating = 'OS';
                                                                    } elseif ($pass >= 90) {
                                                                        $color = 'success';
                                                                        $rating = 'EE';
                                                                    } elseif ($pass >= 80) {
                                                                        $color = 'warning';
                                                                        $rating = 'ME';
                                                                    } elseif ($pass >= 70) {
                                                                        $color = 'orange';
                                                                        $rating = 'NI';
                                                                    } else {
                                                                        $color = 'danger';
                                                                        $rating = 'BE';
                                                                    }
                                                                @endphp

                                                                <tr>
                                                                    <td>{{ $sr++ }}</td>
                                                                    <td>{{ $class->class_name }}</td>
                                                                    <td>{{ $latestAttendance->program_name ?? 'N/A' }}</td>
                                                                    <td>{{ $class->career_code }}</td>
                                                                    {{-- Program name (only if attendance exists) --}}
                                                                    <td>{{ number_format($pass, 1) ?? 'N/A' }}</td>
                                                                    <td>{{ number_format($fail, 1) ?? 'N/A' }}</td>
                                                                    <td>
                                                                        <div class="badge" style="background-color: {{$color }}">
                                                                            {{ number_format($pass, 1) }}%
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="badge" style="background-color: {{ $color }}">

                                                                            {{ $rating }}
                                                                        </div>
                                                                    </td>

                                                                </tr>

                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center">No record found</td>
                                                                </tr>
                                                            @endforelse
                                        @endif
                                                        </tbody>
                                                         @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
                                                         <tfoot>
                                                            <tr class="table-primary">
                                                                <th class="text-end">Total</th>
                                                                <th colspan="5" class="text-end"></th>
                                                                <th>
                                                                    <b>
                                                                        {{ number_format($data['totalPassPercentage'], 1) }}
                                                                    </b>
                                                                </th>
                                                                <th class="text-end text-white"></th>
                                                            </tr>
                                                        </tfoot>
                                                        @endif
                                        
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
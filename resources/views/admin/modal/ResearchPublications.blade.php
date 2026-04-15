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
    <div class="modal fade" id="ResearchPublications" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        Research Publications
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">


                        <!-- Tab Content -->
                        <div class="tab-content">


                            <!-- Fall -->
                            <div class="tab-pane fade show active"
                                id="Testimonials/QualitativeFeedbackfromStudentsonhowtheteachinghasinfluencedthemacademically-fall"
                                role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover align-middle custom-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Category</th>
                                                <th>Clasification</th>
                                                <th>Target</th>
                                                <th>Achieved</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>
                                        @php
                                            // Initialize totalFeedback to 0 in case nothing is set later
                                            $sumPercentage = 0;
                                        @endphp
                                        <tbody>
                                            @if(in_array(getRoleName(activeRole()), ['Teacher', 'Associate Professor', 'Associate Professor', 'Professor']))
                                                @php
                                                    $facultyData = ScopusPublications(Auth::user()->employee_id, $activeRoleId, 128);
                                                    $sr = 1;
                                                    $sumPercentage = collect($facultyData)->sum('percentage');
                                                    if (!function_exists('ratingFunction')) {
                                                        function ratingFunction($average)
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
                                                @foreach ($facultyData as $row)
                                                    @php
                                                        [$rating, $color] = ratingFunction($row['percentage']);
                                                    @endphp
                                                        <tr>
                                                            <td>{{ $sr++ }}</td>
                                                            <td>{{ $row['target_category'] }}</td>
                                                            <td>{{ $row['journal_clasification'] }}</td>
                                                            <td>{{ $row['value'] }}</td>
                                                            <td>{{ $row['count'] }}</td>
                                                            <td>
                                                                <div  class="badge bg-label-{{ $color }}">
                                                                    {{ number_format($row['percentage'], 1) }}%
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="badge bg-label-{{ $color }}">

                                                                    {{ $rating }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th class="">Total</th>
                                                <th  colspan="4" class="text-end"></th>
                                                <th>
                                                    <b>
                                                        {{ number_format($sumPercentage, 1) }}
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
@endif
 @if(in_array(getRoleName(activeRole()), ['HOD']))
<!--  Payment Methods modal -->

    <div class="modal fade" id="ResearchPublications" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Research Publications
                    </h3>
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped align-middle custom-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Total Target</th>
                                            <th>Total Achieved</th>
                                            <th>Total International</th>
                                            <th>Score</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @php
                                                $data=departmentScopusAnalysisOfHOD($activeRoleId, 128);
                                                $avg = $data['department_avg_percentage'] ?? 0;
                                                $meta = getRatingMeta($avg);
                                            @endphp
                                                @if($data['total_target'] > 0)
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ number_format($data['total_target']) }}</td>
                                                        <td>{{ number_format($data['total_submit']) }}</td>
                                                        <td>{{ number_format($data['total_international']) }}</td>
                                                        <td>
                                                            <span class="badge" style="background-color: {{ $meta->color }}">
                                                                {{number_format($avg) }}%
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge" style="background-color: {{ $meta->color }}">
                                                                 {{ $meta->rating }}
                                                            </span>
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
                                                    {{number_format($avg) }}
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
@if(in_array(getRoleName(activeRole()), ['Dean']))
<!--  Payment Methods modal -->

    <div class="modal fade" id="ResearchPublications" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Research Publications
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
                                                $data=ResearchInnovationAndCommercialization(Auth::user()->employee_id, $activeRoleId, 2, 5, 128);
                                                $faculty_avg_percentage = $data['faculty_avg_percentage'] ?? 0;
                                                $meta_avg = getRatingMeta($faculty_avg_percentage);
                                            @endphp
                                                @foreach($data['records'] as $record)
                                                <tr>
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td> {{ $record->user?->department?->name ?? '' }}</td>
                                                    <td><div class="badge bg-{{ $record->color }}">
                                                        {{ $record->score}}%
                                                        </div></td>
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

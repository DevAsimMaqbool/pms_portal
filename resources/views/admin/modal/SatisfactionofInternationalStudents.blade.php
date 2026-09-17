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
@if(in_array(getRoleName(activeRole()), ['HOD']))
    <!--  Payment Methods modal -->

   <div class="modal fade"
     id="SatisfactionofInternationalStudents"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content custom-modal">

            <div class="modal-header">

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>


            <div class="modal-body p-4">

                <!-- Title -->

                <h3 class="text-center mb-4 fw-bold text-primary">

                    <div class="badge bg-label-primary rounded p-2">

                        <i class="icon-base ti tabler-clock-hour-2 icon-md"></i>

                    </div>

                    Satisfaction of International Students

                </h3>


                @php

                    $data = internationalStudentSatisfactionAverage(
                        Auth::user()->employee_id,
                        $activeRoleId,
                        176
                    );

                    $terms = collect($data->terms);
                    

                @endphp
                @if($terms->isEmpty())
                    <div class="alert alert-info">
                        No record exists.
                    </div>
                @else


                <!-- Tabs -->

                <div class="nav-align-top nav-tabs-shadow">

                    <div class="d-flex justify-content-center mb-3 mt-3">

                        <ul class="nav custom-tabs" role="tablist">

                            @foreach($terms as $index => $term)

                                <li class="nav-item">

                                    <button
                                        type="button"
                                        class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#satisfaction-term-{{ $term['term_id'] }}"
                                        aria-controls="satisfaction-term-{{ $term['term_id'] }}"
                                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}">

                                        {{ $term['term'] ?? 'Term' }}

                                        {{ $term['start_year'] ?? '' }}

                                    </button>

                                </li>

                            @endforeach

                        </ul>

                    </div>


                    <!-- Tab Content -->

                    <div class="tab-content">

                        @foreach($terms as $index => $term)

                            @php

                                $termRows = collect(
                                    $term['rows']
                                );

                            @endphp


                            <div
                                class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                id="satisfaction-term-{{ $term['term_id'] }}"
                                role="tabpanel">


                                <div class="card">

                                    <div class="card-body">

                                        <div class="table-responsive text-nowrap">

                                            <table class="table table-hover align-middle custom-table">

                                                <thead class="table-primary">

                                                    <tr>

                                                        <th>Sr#</th>

                                                        <th>Faculty</th>

                                                        <th>Department</th>

                                                        <th>Program</th>

                                                        <th>Program Level</th>

                                                        <th>Score</th>

                                                        <th>Rating</th>

                                                    </tr>

                                                </thead>


                                                <tbody>

                                                    @forelse(
                                                        $termRows
                                                        as $rowIndex => $row
                                                    )

                                                        <tr>

                                                            <td>
                                                                {{ $rowIndex + 1 }}
                                                            </td>


                                                            <td>
                                                                {{ $row['faculty'] ?? 'N/A' }}
                                                            </td>


                                                            <td>
                                                                {{ $row['department'] ?? 'N/A' }}
                                                            </td>


                                                            <td>
                                                                {{ $row['program'] ?? 'N/A' }}
                                                            </td>


                                                            <td>
                                                                {{ $row['program_level'] ?? 'N/A' }}
                                                            </td>


                                                            <td>

                                                                <div
                                                                    class="badge"
                                                                    style="background-color: {{ $row['color'] }}">

                                                                    {{ number_format(
                                                                        $row['score'],
                                                                        1
                                                                    ) }}%

                                                                </div>

                                                            </td>


                                                            <td>

                                                                <span
                                                                    class="badge"
                                                                    style="background-color: {{ $row['color'] }}">

                                                                    {{ $row['rating'] }}

                                                                </span>

                                                            </td>

                                                        </tr>

                                                    @empty

                                                        <tr>

                                                            <td
                                                                colspan="7"
                                                                class="text-center">

                                                                No data available.

                                                            </td>

                                                        </tr>

                                                    @endforelse

                                                </tbody>


                                                <!-- Term Total -->

                                                <tfoot>

                                                    <tr class="table-primary">

                                                        <th>
                                                            Total
                                                        </th>

                                                        <th colspan="4"
                                                            class="text-end">

                                                        </th>


                                                        <th>

                                                            <b
                                                                class="badge"
                                                                style="background-color: {{ $term['color'] }}">

                                                                {{ number_format(
                                                                    $term['average'],
                                                                    1
                                                                ) }}%

                                                            </b>

                                                        </th>


                                                        <th>

                                                            <b
                                                                class="badge"
                                                                style="background-color: {{ $term['color'] }}">

                                                                {{ $term['rating'] }}

                                                            </b>

                                                        </th>

                                                    </tr>

                                                </tfoot>

                                            </table>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach
                        @endif

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

    <div class="modal fade" id="SatisfactionofInternationalStudents" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i
                                class="icon-base ti tabler-clock-hour-2 icon-md"></i></div>Satisfaction of International
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
                                             $data = ResearchInnovationAndCommercialization(Auth::user()->employee_id, $activeRoleId, 4, 12, 176);
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
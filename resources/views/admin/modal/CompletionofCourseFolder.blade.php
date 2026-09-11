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
@if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Demonstrator']))
    <!--  Payment Methods modal -->
    @php

        $data = CompletionofCourseFolderNew(Auth::user()->employee_id, $activeRoleId, 120);
        $springData = $data['springData'];
        $fallData = $data['fallData'];
        $avgPercentage = $data['avgPercentage'];

    @endphp
    <div class="modal fade" id="CompletionofCourseFolder" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i class="icon-base ti tabler-folder icon-md"></i>
                        </div> Completion of Course Folder
                    </h3>
                    <!-- Tabs -->
                    <div class="nav-align-top nav-tabs-shadow">
                        <div class="d-flex justify-content-center mb-3 mt-3">
                            <ul class="nav custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#completion-course-spring" aria-controls="completion-course-spring"
                                        aria-selected="true">
                                        🌸 Spring {{ $springData->first()?->term?->start_year ?? date('Y') }}
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#completion-course-fall" aria-controls="completion-course-fall"
                                        aria-selected="false">
                                        🍂 Fall {{ $fallData->first()?->term?->start_year ?? date('Y') - 1 }}
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Spring -->
                            <div class="tab-pane fade show active" id="completion-course-spring" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover align-middle custom-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Class</th>
                                                <th>Career (PG/UG)</th>
                                                <th>Status</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($springData as $CompletionofCourser_spring)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <td>{{ $CompletionofCourser_spring->facultyClass->code ?? 'N/A' }}</td>

                                                    <td>{{ $CompletionofCourser_spring->facultyClass?->career_code ?? 'N/A' }}
                                                    </td>

                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{ $CompletionofCourser_spring->color ?? '#6c757d' }}">
                                                            {{ $CompletionofCourser_spring->status_folder ?? 'N/A' }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{ $CompletionofCourser_spring->color ?? '#6c757d' }}">
                                                            {{ number_format($CompletionofCourser_spring->completion_of_Course_folder ?? 0, 1) }}%
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{ $CompletionofCourser_spring->color ?? '#6c757d' }}">
                                                            {{ $CompletionofCourser_spring->rating ?? 'N/A' }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">
                                                        no record found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                        <tfoot>
                                            <tr class="table-primary">
                                                <th class="text-end">Total</th>
                                                <th colspan="2" class="text-end"></th>
                                                <th class="text-end">(S+F)</th>
                                                <th style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMeta($avgPercentage)->color }}">
                                                        {{ number_format($avgPercentage, 1) }}%
                                                    </b>
                                                </th>
                                                <th class="text-end" style="font-size: 0.960rem;"><b class="badge"
                                                        style="background-color: {{ getRatingMeta($avgPercentage)->color }}">
                                                        {{ getRatingMeta($avgPercentage)->rating }}
                                                    </b></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Fall -->
                            <div class="tab-pane fade" id="completion-course-fall" role="tabpanel">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover align-middle custom-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Class</th>
                                                <th>Career (PG/UG)</th>
                                                <th>Status</th>
                                                <th>Score</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($fallData as $CompletionofCourser_fall)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <td>{{ $CompletionofCourser_fall->facultyClass->code ?? 'N/A' }}</td>

                                                    <td>{{ $CompletionofCourser_fall->facultyClass?->career_code ?? 'N/A' }}
                                                    </td>

                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{ $CompletionofCourser_fall->color ?? '#6c757d' }}">
                                                            {{ $CompletionofCourser_fall->status_folder ?? 'N/A' }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{ $CompletionofCourser_fall->color ?? '#6c757d' }}">
                                                            {{ number_format($CompletionofCourser_fall->completion_of_Course_folder ?? 0, 1) }}%
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="badge"
                                                            style="background-color: {{ $CompletionofCourser_fall->color ?? '#6c757d' }}">
                                                            {{ $CompletionofCourser_fall->rating ?? 'N/A' }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">
                                                        no record found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th class="text-end">Total</th>
                                                <th colspan="2" class="text-end"></th>
                                                <th class="text-end">(S+F)</th>
                                                <th style="font-size: 0.960rem;">
                                                    <b class="badge"
                                                        style="background-color: {{ getRatingMeta($avgPercentage)->color }}">
                                                        {{ number_format($avgPercentage, 1) }}%
                                                    </b>
                                                </th>
                                                <th class="text-end" style="font-size: 0.960rem;"><b class="badge"
                                                        style="background-color: {{ getRatingMeta($avgPercentage)->color }}">
                                                        {{ getRatingMeta($avgPercentage)->rating }}
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
    </div>

    <!-- / Payment Methods modal -->
@endif

@if(in_array(getRoleName(activeRole()), ['HOD']))
   <!--  Payment Methods modal -->
   @php
   $courseFolderData = CompletionOfCourseFolderForHOD($activeRoleId, 120);

    $springProgramData =
        $courseFolderData['springProgramData']
        ?? collect();

    $fallProgramData =
        $courseFolderData['fallProgramData']
        ?? collect();

    $springScore =
        $courseFolderData['springScore']
        ?? 0;

    $fallScore =
        $courseFolderData['fallScore']
        ?? 0;

    $avgPercentage =
        $courseFolderData['avgPercentage']
        ?? 0;

    $weightedScore =
        $courseFolderData['weightedScore']
        ?? 0;

    $weightage =
        $courseFolderData['weightage']
        ?? 0;


    /*
    |--------------------------------------------------------------------------
    | Years
    |--------------------------------------------------------------------------
    */

    $springYear =
        $springProgramData
            ->flatMap(function ($program) {
                return $program['records'];
            })
            ->first()?->term?->start_year
            ?? date('Y');


    $fallYear =
        $fallProgramData
            ->flatMap(function ($program) {
                return $program['records'];
            })
            ->first()?->term?->start_year
            ?? date('Y');

@endphp
    <div class="modal fade" id="CompletionofCourseFolder" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Title -->
                    <h3 class="text-center mb-4 fw-bold text-primary">
                        <div class="badge bg-label-primary rounded p-2"><i class="icon-base ti tabler-folder icon-md"></i>
                        </div> Completion of Course Folder
                    </h3>
                    <!-- Tabs -->
                        @php

    $springData = $courseFolderData['springData'] ?? collect();

    $fallData = $courseFolderData['fallData'] ?? collect();

    $springScore = $courseFolderData['springScore'] ?? 0;

    $fallScore = $courseFolderData['fallScore'] ?? 0;

    $avgPercentage = $courseFolderData['avgPercentage'] ?? 0;

    $weightedScore = $courseFolderData['weightedScore'] ?? 0;

    $weightage = $courseFolderData['weightage'] ?? 0;


    /*
    |--------------------------------------------------------------------------
    | Spring Year
    |--------------------------------------------------------------------------
    */

    $springYear = $springData->first()?->term?->start_year
        ?? date('Y');


    /*
    |--------------------------------------------------------------------------
    | Fall Year
    |--------------------------------------------------------------------------
    */

    $fallYear = $fallData->first()?->term?->start_year
        ?? date('Y');

@endphp


<!-- =========================================================
     TABS
========================================================== -->

<div class="nav-align-top nav-tabs-shadow">

    <!-- =====================================================
         TAB HEADERS
    ====================================================== -->

    <div class="d-flex justify-content-center mb-3 mt-3">

        <ul class="nav custom-tabs" role="tablist">

            <!-- Spring -->

            <li class="nav-item">

                <button type="button"
                    class="nav-link active"
                    role="tab"
                    data-bs-toggle="tab"
                    data-bs-target="#completion-course-spring"
                    aria-controls="completion-course-spring"
                    aria-selected="true">

                    🌸 Spring {{ $springYear }}

                </button>

            </li>


            <!-- Fall -->

            <li class="nav-item">

                <button type="button"
                    class="nav-link"
                    role="tab"
                    data-bs-toggle="tab"
                    data-bs-target="#completion-course-fall"
                    aria-controls="completion-course-fall"
                    aria-selected="false">

                    🍂 Fall {{ $fallYear }}

                </button>

            </li>

        </ul>

    </div>


    <!-- =====================================================
         TAB CONTENT
    ====================================================== -->

    <div class="tab-content">


        <!-- =================================================
             SPRING
        ================================================== -->

        <div class="tab-pane fade show active"
            id="completion-course-spring"
            role="tabpanel">

            <div class="table-responsive text-nowrap">

                <table class="table table-hover align-middle custom-table">

                    <thead class="table-primary">

                        <tr>

                            <th>Sr#</th>

                            <th>Class</th>

                            <th>Career (PG/UG)</th>

                            <th>Status</th>

                            <th>Score</th>

                            <th>Rating</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($springData as $CompletionofCourser_spring)

                            <tr>

                                <!-- Sr -->

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <!-- Class -->

                                <td>

                                    {{ $CompletionofCourser_spring
                                        ->facultyClass
                                        ?->code
                                        ?? 'N/A' }}

                                </td>


                                <!-- Career -->

                                <td>

                                    {{ $CompletionofCourser_spring
                                        ->facultyClass
                                        ?->career_code
                                        ?? 'N/A' }}

                                </td>


                                <!-- Status -->

                                <td>

                                    <div class="badge"
                                        style="
                                            background-color:
                                            {{ $CompletionofCourser_spring
                                                ->color
                                                ?? '#6c757d' }};
                                        ">

                                        {{ $CompletionofCourser_spring
                                            ->status_folder
                                            ?? 'N/A' }}

                                    </div>

                                </td>


                                <!-- Score -->

                                <td>

                                    <div class="badge"
                                        style="
                                            background-color:
                                            {{ $CompletionofCourser_spring
                                                ->color
                                                ?? '#6c757d' }};
                                        ">

                                        {{ number_format(
                                            $CompletionofCourser_spring
                                                ->completion_of_Course_folder
                                                ?? 0,
                                            1
                                        ) }}%

                                    </div>

                                </td>


                                <!-- Rating -->

                                <td>

                                    <div class="badge"
                                        style="
                                            background-color:
                                            {{ $CompletionofCourser_spring
                                                ->color
                                                ?? '#6c757d' }};
                                        ">

                                        {{ $CompletionofCourser_spring
                                            ->rating
                                            ?? 'N/A' }}

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted">

                                    No record found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>


                    <!-- Spring Average -->

                    <tfoot>

                        <tr class="table-primary">

                            <th class="text-end">
                                Spring Average
                            </th>

                            <th colspan="2"></th>

                            <th></th>


                            <th>

                                <b class="badge"
                                    style="
                                        background-color:
                                        {{ getRatingMeta(
                                            $springScore
                                        )->color }};
                                    ">

                                    {{ number_format(
                                        $springScore,
                                        1
                                    ) }}%

                                </b>

                            </th>


                            <th>

                                <b class="badge"
                                    style="
                                        background-color:
                                        {{ getRatingMeta(
                                            $springScore
                                        )->color }};
                                    ">

                                    {{ getRatingMeta(
                                        $springScore
                                    )->rating }}

                                </b>

                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>


        <!-- =================================================
             FALL
        ================================================== -->

        <div class="tab-pane fade"
            id="completion-course-fall"
            role="tabpanel">

            <div class="table-responsive text-nowrap">

                <table class="table table-hover align-middle custom-table">

                    <thead class="table-primary">

                        <tr>

                            <th>Sr#</th>

                            <th>Class</th>

                            <th>Career (PG/UG)</th>

                            <th>Status</th>

                            <th>Score</th>

                            <th>Rating</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($fallData as $CompletionofCourser_fall)

                            <tr>

                                <!-- Sr -->

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <!-- Class -->

                                <td>

                                    {{ $CompletionofCourser_fall
                                        ->facultyClass
                                        ?->code
                                        ?? 'N/A' }}

                                </td>


                                <!-- Career -->

                                <td>

                                    {{ $CompletionofCourser_fall
                                        ->facultyClass
                                        ?->career_code
                                        ?? 'N/A' }}

                                </td>


                                <!-- Status -->

                                <td>

                                    <div class="badge"
                                        style="
                                            background-color:
                                            {{ $CompletionofCourser_fall
                                                ->color
                                                ?? '#6c757d' }};
                                        ">

                                        {{ $CompletionofCourser_fall
                                            ->status_folder
                                            ?? 'N/A' }}

                                    </div>

                                </td>


                                <!-- Score -->

                                <td>

                                    <div class="badge"
                                        style="
                                            background-color:
                                            {{ $CompletionofCourser_fall
                                                ->color
                                                ?? '#6c757d' }};
                                        ">

                                        {{ number_format(
                                            $CompletionofCourser_fall
                                                ->completion_of_Course_folder
                                                ?? 0,
                                            1
                                        ) }}%

                                    </div>

                                </td>


                                <!-- Rating -->

                                <td>

                                    <div class="badge"
                                        style="
                                            background-color:
                                            {{ $CompletionofCourser_fall
                                                ->color
                                                ?? '#6c757d' }};
                                        ">

                                        {{ $CompletionofCourser_fall
                                            ->rating
                                            ?? 'N/A' }}

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted">

                                    No record found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>


                    <!-- Fall Average -->

                    <tfoot>

                        <tr class="table-primary">

                            <th class="text-end">
                                Fall Average
                            </th>

                            <th colspan="2"></th>

                            <th></th>


                            <th>

                                <b class="badge"
                                    style="
                                        background-color:
                                        {{ getRatingMeta(
                                            $fallScore
                                        )->color }};
                                    ">

                                    {{ number_format(
                                        $fallScore,
                                        1
                                    ) }}%

                                </b>

                            </th>


                            <th>

                                <b class="badge"
                                    style="
                                        background-color:
                                        {{ getRatingMeta(
                                            $fallScore
                                        )->color }};
                                    ">

                                    {{ getRatingMeta(
                                        $fallScore
                                    )->rating }}

                                </b>

                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     OVERALL SPRING + FALL
========================================================== -->

<div class="card mt-4">

    <div class="card-header table-primary">

        <h5 class="mb-0">
            Overall Course Folder Score
        </h5>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered mb-0">

                <thead class="table-primary">

                    <tr>

                        <th>
                            Spring
                        </th>

                        <th>
                            Fall
                        </th>

                        <th>
                            Overall (S + F)
                        </th>

                        <th>
                            Weightage
                        </th>

                        <th>
                            Weighted Score
                        </th>

                        <th>
                            Rating
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <!-- Spring -->

                        <td>

                            <b class="badge"
                                style="
                                    background-color:
                                    {{ getRatingMeta(
                                        $springScore
                                    )->color }};
                                ">

                                {{ number_format(
                                    $springScore,
                                    1
                                ) }}%

                            </b>

                        </td>


                        <!-- Fall -->

                        <td>

                            <b class="badge"
                                style="
                                    background-color:
                                    {{ getRatingMeta(
                                        $fallScore
                                    )->color }};
                                ">

                                {{ number_format(
                                    $fallScore,
                                    1
                                ) }}%

                            </b>

                        </td>


                        <!-- Overall -->

                        <td>

                            <b class="badge"
                                style="
                                    background-color:
                                    {{ getRatingMeta(
                                        $avgPercentage
                                    )->color }};
                                ">

                                {{ number_format(
                                    $avgPercentage,
                                    1
                                ) }}%

                            </b>

                        </td>


                        <!-- Weightage -->

                        <td>

                            {{ number_format(
                                $weightage,
                                2
                            ) }}%

                        </td>


                        <!-- Weighted -->

                        <td>

                            <strong>

                                {{ number_format(
                                    $weightedScore,
                                    2
                                ) }}

                            </strong>

                        </td>


                        <!-- Rating -->

                        <td>

                            <b class="badge"
                                style="
                                    background-color:
                                    {{ getRatingMeta(
                                        $avgPercentage
                                    )->color }};
                                ">

                                {{ getRatingMeta(
                                    $avgPercentage
                                )->rating }}

                            </b>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>
                    <!--/Tabs -->
                </div>
            </div>
        </div>
    </div>

    <!-- / Payment Methods modal -->
@endif
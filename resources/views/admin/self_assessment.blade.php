@extends('layouts.app')
@push('style')
    <style>
        .avatar-xl {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
        }

        .metric {
            font-size: .9rem;
            color: #6c757d;
        }

        .mini-tile {
            border: 1px solid var(--bs-border-color);
            border-radius: .75rem;
            padding: 1rem;
            background: #fff;
            height: 100%;
        }

        .mini-tile .label {
            color: #6e6b7b;
            font-size: .8rem;
        }

        .mini-tile .value {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .spark-holder {
            height: 120px;
        }

        .kpa-card h6 {
            margin-bottom: .25rem;
        }

        .indicator-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .5rem 0;
            border-bottom: 1px dashed var(--bs-border-color);
        }

        .indicator-row:last-child {
            border-bottom: none;
        }

        .status-badge {
            padding: .35rem .5rem;
        }

        .filter-row .form-select {
            min-width: 220px;
        }
    </style>
@endpush
@php use Illuminate\Support\Str; @endphp
@section('content')
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row g-6">
                    <!-- Support Tracker -->
                    <div class="col-12 col-md-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">Self Assessment</h5>
                                <small class="text-body-secondary float-end"></small>
                            </div>
                            <div class="card-body">
                                <div class="card-datatable table-responsive">
                                    <form action="{{ route('self-assessment.store') }}" method="POST">
                                        @csrf
                                        <div class="col-md-2 mb-3">
                                            <label for="term" class="form-label">Select Term</label>
                                            <select id="term" class="form-select" name="term" required>
                                                <option value="">Select Option</option>
                                                <option value="Fall 2025" {{ isset($records) && $records->first()?->term == 'Fall 2025' ? 'selected' : '' }}>Fall 2025</option>
                                                <option value="Spring 2025" {{ isset($records) && $records->first()?->term == 'Spring 2025' ? 'selected' : '' }}>Spring 2025
                                                </option>
                                            </select>
                                        </div>

                                        <table class="table border-top">
                                            <thead>
                                                <tr>
                                                    <th>KPA</th>
                                                    <th>General Comments</th>
                                                    <th>Challenge</th>
                                                    <th>Strength</th>
                                                    <th>Training Required</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
    $kpas = [
        0 => 'Teaching and Learning',
        1 => 'Research, Innovation and Commercialisation',
        2 => 'Institutional Engagement (Core only)',
        3 => 'Institutional Engagement (Operational+ Character Strengths)',
    ];
                                                @endphp

                                                @foreach($kpas as $i => $kpa)
                                                    @php
        $record = $records[$kpa] ?? null;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $kpa }}</td>
                                                        <td>
                                                            <textarea name="data[{{ $i }}][general_comments]"
                                                                class="form-control">{{ $record->general_comments ?? '' }}</textarea>
                                                        </td>

                                                        <td>
                                                            <textarea name="data[{{ $i }}][challenge]"
                                                                class="form-control">{{ $record->challenge ?? '' }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="data[{{ $i }}][strength]"
                                                                class="form-control">{{ $record->strength ?? '' }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="data[{{ $i }}][working]"
                                                                class="form-control">{{ $record->working ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="col-1 mt-2" style="margin-left: 10px;">
                                            <button type="submit" class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                        </div>

                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="card-datatable table-responsive">
                                    <form id="selfAssessment" method="POST" action="{{ route('employee.rating.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-2" style="margin-left: 8px;">
                                                <label class="form-label" for="multicol-language">Year</label>
                                                <select name="year" id="select2Year" class="select2 form-select" required>
                                                    <option value="">-- Select Year --</option>$rating->
                                                    <option value="2025-2026" {{ optional($rating)->year == 20 ? '2025-2026' : '' }}>
                                                        2025-2026</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" id="assessmentType" name="assessment_type" value="self"
                                            class="form-control" />
                                        <input type="hidden" id="employeeId" name="employee_id"
                                            value="{{ Auth::user()->employee_id }}" class="form-control" />
                                        <div class="row"
                                            style="padding:20px; font-family:Arial; display:flex; flex-wrap:wrap; gap:15px;">

                                            <!-- Section 1 -->
                                            <h6
                                                style="width:100%; margin-top:20px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                                1- Responsibility & Accountability
                                            </h6>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I admit mistakes and take responsibility for correcting them.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;">
                                                        <input type="radio" name="responsibility_accountability_1" value="20" {{ optional($rating)->responsibility_accountability_1 == 20 ? 'checked' : '' }}>
                                                        Strongly Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="responsibility_accountability_1" value="40" {{ optional($rating)->responsibility_accountability_1 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="responsibility_accountability_1" value="60" {{ optional($rating)->responsibility_accountability_1 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="responsibility_accountability_1" value="80" {{ optional($rating)->responsibility_accountability_1 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="responsibility_accountability_1" value="100" {{ optional($rating)->responsibility_accountability_1 == 100 ? 'checked' : '' }}>
                                                        Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I keep commitments and meet deadlines consistently.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="responsibility_accountability_2" value="20" {{ optional($rating)->responsibility_accountability_2 == 20 ? 'checked' : '' }}>
                                                        Strongly Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="responsibility_accountability_2" value="40" {{ optional($rating)->responsibility_accountability_2 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="responsibility_accountability_2" value="60" {{ optional($rating)->responsibility_accountability_2 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="responsibility_accountability_2" value="80" {{ optional($rating)->responsibility_accountability_2 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="responsibility_accountability_2" value="100" {{ optional($rating)->responsibility_accountability_2 == 100 ? 'checked' : '' }}>
                                                        Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                            <!-- Section 2 -->
                                            <h6
                                                style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                                2- Empathy & Compassion
                                            </h6>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I demonstrate genuine care and concern for students and colleagues and listen
                                                    and respond to them empathetically.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="empathy_compassion_1" value="20" {{ optional($rating)->empathy_compassion_1 == 20 ? 'checked' : '' }}>
                                                        Strongly
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="empathy_compassion_1" value="40" {{ optional($rating)->empathy_compassion_1 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="empathy_compassion_1" value="60" {{ optional($rating)->empathy_compassion_1 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="empathy_compassion_1" value="80" {{ optional($rating)->empathy_compassion_1 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="empathy_compassion_1" value="100" {{ optional($rating)->empathy_compassion_1 == 100 ? 'checked' : '' }}>
                                                        Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I actively contribute to a collaborative and supportive team environment.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="empathy_compassion_2" value="20" {{ optional($rating)->empathy_compassion_2 == 20 ? 'checked' : '' }}>
                                                        Strongly
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="empathy_compassion_2" value="40" {{ optional($rating)->empathy_compassion_2 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="empathy_compassion_2" value="60" {{ optional($rating)->empathy_compassion_2 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="empathy_compassion_2" value="80" {{ optional($rating)->empathy_compassion_2 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="empathy_compassion_2" value="100" {{ optional($rating)->empathy_compassion_2 == 100 ? 'checked' : '' }}>
                                                        Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                            <!-- Section 3 -->
                                            <h6
                                                style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                                3- Humility & Service
                                            </h6>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I offer help without being asked, especially during high-pressure periods.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;"><input type="radio" name="humility_service_1"
                                                            value="20" {{ optional($rating)->humility_service_1 == 20 ? 'checked' : '' }}>
                                                        Strongly
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="humility_service_1"
                                                            value="40" {{ optional($rating)->humility_service_1 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="humility_service_1"
                                                            value="60" {{ optional($rating)->humility_service_1 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="humility_service_1"
                                                            value="80" {{ optional($rating)->humility_service_1 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="humility_service_1" value="100" {{ optional($rating)->humility_service_1 == 100 ? 'checked' : '' }}> Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I regularly volunteer for tasks that serve the larger goals of the department or
                                                    university.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;"><input type="radio" name="humility_service_2"
                                                            value="20" {{ optional($rating)->humility_service_2 == 20 ? 'checked' : '' }}>
                                                        Strongly
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="humility_service_2"
                                                            value="40" {{ optional($rating)->humility_service_2 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="humility_service_2"
                                                            value="60" {{ optional($rating)->humility_service_2 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="humility_service_2"
                                                            value="80" {{ optional($rating)->humility_service_2 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="humility_service_2" value="100" {{ optional($rating)->humility_service_2 == 100 ? 'checked' : '' }}> Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                            <!-- Section 4 -->
                                            <h6
                                                style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                                4- Honesty & Integrity
                                            </h6>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I speak the truth, even when it's difficult, and uphold ethical standards.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1"
                                                            value="20" {{ optional($rating)->honesty_integrity_1 == 20 ? 'checked' : '' }}>
                                                        Strongly
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1"
                                                            value="40" {{ optional($rating)->honesty_integrity_1 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1"
                                                            value="60" {{ optional($rating)->honesty_integrity_1 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1"
                                                            value="80" {{ optional($rating)->honesty_integrity_1 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="honesty_integrity_1" value="100" {{ optional($rating)->honesty_integrity_1 == 100 ? 'checked' : '' }}>
                                                        Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I build trusting relationships through respectful and consistent behavior.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2"
                                                            value="20" {{ optional($rating)->honesty_integrity_2 == 20 ? 'checked' : '' }}>
                                                        Strongly
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2"
                                                            value="40" {{ optional($rating)->honesty_integrity_2 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2"
                                                            value="60" {{ optional($rating)->honesty_integrity_2 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2"
                                                            value="80" {{ optional($rating)->honesty_integrity_2 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="honesty_integrity_2" value="100" {{ optional($rating)->honesty_integrity_2 == 100 ? 'checked' : '' }}>
                                                        Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                            <!-- Section 5 -->
                                            <h6
                                                style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                                5- Inspirational Leadership
                                            </h6>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I inspire others with a positive attitude and solutions-focused mindset.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="inspirational_leadership_1" value="20" {{ optional($rating)->inspirational_leadership_1 == 20 ? 'checked' : '' }}>
                                                        Strongly
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="inspirational_leadership_1" value="40" {{ optional($rating)->inspirational_leadership_1 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="inspirational_leadership_1" value="60" {{ optional($rating)->inspirational_leadership_1 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="inspirational_leadership_1" value="80" {{ optional($rating)->inspirational_leadership_1 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="inspirational_leadership_1" value="100" {{ optional($rating)->inspirational_leadership_1 == 100 ? 'checked' : '' }}>
                                                        Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-1"
                                                style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                                <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                                    I set a strong example of professional conduct and personal values.
                                                </label>
                                                <div style="margin-top:8px;">
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="inspirational_leadership_2" value="20" {{ optional($rating)->inspirational_leadership_2 == 20 ? 'checked' : '' }}>
                                                        Strongly
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="inspirational_leadership_2" value="40" {{ optional($rating)->inspirational_leadership_2 == 40 ? 'checked' : '' }}>
                                                        Disagree</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="inspirational_leadership_2" value="60" {{ optional($rating)->inspirational_leadership_2 == 60 ? 'checked' : '' }}>
                                                        Neutral</label>
                                                    <label style="margin-right:15px;"><input type="radio"
                                                            name="inspirational_leadership_2" value="80" {{ optional($rating)->inspirational_leadership_2 == 80 ? 'checked' : '' }}>
                                                        Agree</label>
                                                    <label><input type="radio" name="inspirational_leadership_2" value="100" {{ optional($rating)->inspirational_leadership_2 == 100 ? 'checked' : '' }}>
                                                        Strongly
                                                        Agree</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-1" style="margin-left: 10px;">
                                            <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- / Content -->
@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script src="{{ asset('admin/assets/js/cards-analytics.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#term').on('change', function () {
                var kfaId = $(this).val();

                $.ajax({
                    url: '{{ route("self-assessment.termData") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        term: kfaId
                    },
                    success: function (data) {
                        console.log(data);
                        var kpas = [
                            'Teaching and Learning',
                            'Research, Innovation and Commercialisation',
                            'Institutional Engagement (Core only)',
                            'Institutional Engagement (Operational+ Character Strengths)'
                        ];

                        kpas.forEach(function (kpa, index) {
                            var record = data[kpa] || {};
                            $('textarea[name="data[' + index + '][general_comments]"]').val(record.general_comments || '');
                            $('textarea[name="data[' + index + '][challenge]"]').val(record.challenge || '');
                            $('textarea[name="data[' + index + '][strength]"]').val(record.strength || '');
                            $('textarea[name="data[' + index + '][working]"]').val(record.working || '');
                        });
                    },
                    error: function (xhr) {
                        console.error('Error fetching term data', xhr);
                    }
                });
            });
        }); 
    </script>
@endpush
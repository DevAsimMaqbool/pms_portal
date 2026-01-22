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
        
        <div class="row g-6">

            <div class="col-12 col-md-12">
                <div class="card">
                <h5 class="card-header">FeedBack</h5>

                    <div class="card-body">
                        <div class="card-datatable table-responsive">
                            <form id="selfAssessment" method="POST" action=""
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="multicol-language">PMS Cycle</label>
                                        <select name="year" id="select2Year" class="select2 form-select" required>
                                            <option value="">-- Select --</option>$rating->
                                            <option value="2025-2026">2025-2026</option>
                                            <option value="2027-2028">2027-2028</option>
                                            <option value="2028-2029">2028-2029</option>

                                        </select>
                                    </div>
                                   
                                    <div class="col-md-4">
                                        <label class="form-label" for="multicol-language">Feedback Receiver Role</label>
                                        <select name="year" id="select2Year" class="select2 form-select" required>
                                            <option value="">-- Select --</option>
                                            <option value="Teacher">Teacher</option>
                                            <option value="HOD">HOD</option>
                                            <option value="Dean">Dean</option>
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
                                            Admits mistakes and take responsibility for correcting them.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;">
                                                <input type="radio" name="responsibility_accountability_1" value="20">
                                                Strongly Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="responsibility_accountability_1" value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="responsibility_accountability_1" value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="responsibility_accountability_1" value="80">
                                                Agree</label>
                                            <label><input type="radio" name="responsibility_accountability_1" value="100">
                                                Strongly
                                                Agree</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                            Keeps commitments and meet deadlines consistently.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="responsibility_accountability_2" value="20">
                                                Strongly Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="responsibility_accountability_2" value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="responsibility_accountability_2" value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="responsibility_accountability_2" value="80">
                                                Agree</label>
                                            <label><input type="radio" name="responsibility_accountability_2" value="100">
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
                                            Demonstrates genuine care and concern for students and colleagues and listen and respond to them empathetically
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_compassion_1" value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_compassion_1" value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_compassion_1" value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_compassion_1" value="80">
                                                Agree</label>
                                            <label><input type="radio" name="empathy_compassion_1" value="100">
                                                Strongly
                                                Agree</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                            Actively contributes to a collaborative and supportive team environment.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_compassion_2" value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_compassion_2" value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_compassion_2" value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_compassion_2" value="80">
                                                Agree</label>
                                            <label><input type="radio" name="empathy_compassion_2" value="100">
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
                                            Offers help without being asked, especially during high-pressure periods.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio" name="humility_service_1"
                                                    value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="humility_service_1"
                                                    value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="humility_service_1"
                                                    value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio" name="humility_service_1"
                                                    value="80">
                                                Agree</label>
                                            <label><input type="radio" name="humility_service_1" value="100"> Strongly
                                                Agree</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                            Regularly volunteers for tasks that serve the larger goals of the department or university.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio" name="humility_service_2"
                                                    value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="humility_service_2"
                                                    value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="humility_service_2"
                                                    value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio" name="humility_service_2"
                                                    value="80">
                                                Agree</label>
                                            <label><input type="radio" name="humility_service_2" value="100"> Strongly
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
                                            Speaks the truth, even when it's difficult, and uphold ethical standards.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1"
                                                    value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1"
                                                    value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1"
                                                    value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1"
                                                    value="80">
                                                Agree</label>
                                            <label><input type="radio" name="honesty_integrity_1" value="100">
                                                Strongly
                                                Agree</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                            Builds trusting relationships through respectful and consistent behavior.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2"
                                                    value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2"
                                                    value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2"
                                                    value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2"
                                                    value="80">
                                                Agree</label>
                                            <label><input type="radio" name="honesty_integrity_2" value="100">
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
                                            Inspires others with a positive attitude and solutions-focused mindset.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership_1" value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership_1" value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership_1" value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership_1" value="80">
                                                Agree</label>
                                            <label><input type="radio" name="inspirational_leadership_1" value="100">
                                                Strongly
                                                Agree</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                            Sets a strong example of professional conduct and personal values.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership_2" value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership_2" value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership_2" value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership_2" value="80">
                                                Agree</label>
                                            <label><input type="radio" name="inspirational_leadership_2" value="100">
                                                Strongly
                                                Agree</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-1">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                           Remarks
                                        </label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="4"></textarea>
                                    </div>

                                </div>
                                <div class="mt-3 text-end" style="margin-right: 10px;">
                                    <button class="btn btn-primary waves-effect waves-light">SUBMIT</button>
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
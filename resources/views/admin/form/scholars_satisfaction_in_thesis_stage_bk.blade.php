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

                    <div class="card-body">
                        <div class="card-datatable table-responsive">
                        <div class="d-flex justify-content-between">
                               <div>
                                <h5 class="mb-1">Scholar's Satisfaction (In Thesis Stage)</h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'scholars_satisfaction_in_thesis_stage', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div> 
                            <form id="researchForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="assessmentType" name="assessment_type" value="self"
                                    class="form-control" />
                                <input type="hidden" id="employeeId" name="employee_id"
                                    value="{{ Auth::user()->employee_id }}" class="form-control" />
                                <div class="row"
                                    style="padding:20px; font-family:Arial; display:flex; flex-wrap:wrap; gap:15px;">

                                    <!-- Section 1 -->
                                    <h6
                                        style="width:100%; margin-top:20px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                        1- Empathy and Compassion
                                    </h6>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                            My supervisor is kind, understanding, and supportive when I face challenges in my research.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;">
                                                <input type="radio" name="empathy_and_compassion" value="20">
                                                Strongly Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_and_compassion" value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_and_compassion" value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="empathy_and_compassion" value="80">
                                                Agree</label>
                                            <label><input type="radio" name="empathy_and_compassion" value="100">
                                                Strongly
                                                Agree</label>
                                        </div>
                                    </div>

                                    

                                    <!-- Section 2 -->
                                    <h6
                                        style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                        2- Inspirational Leadership
                                    </h6>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                            My supervisor motivates me to do my best and helps me see how my research can make a difference.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership" value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership" value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership" value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio"
                                                    name="inspirational_leadership" value="80">
                                                Agree</label>
                                            <label><input type="radio" name="inspirational_leadership" value="100">
                                                Strongly
                                                Agree</label>
                                        </div>
                                    </div>



                                    <!-- Section 3 -->
                                    <h6
                                        style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                        3- Honesty and Integrity
                                    </h6>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                            My supervisor gives honest, fair, and helpful feedback and promotes ethical research practices.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_and_integrity"
                                                    value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_and_integrity"
                                                    value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_and_integrity"
                                                    value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio" name="honesty_and_integrity"
                                                    value="80">
                                                Agree</label>
                                            <label><input type="radio" name="honesty_and_integrity" value="100"> Strongly
                                                Agree</label>
                                        </div>
                                    </div>

                                   

                                    <!-- Section 4 -->
                                    <h6
                                        style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                        4- Responsibility and Accountability
                                    </h6>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                            My supervisor respects my ideas and guides me with patience and a spirit of service.
                                        </label>
                                        <div style="margin-top:8px;">
                                            <label style="margin-right:15px;"><input type="radio" name="responsibility_and_accountability"
                                                    value="20">
                                                Strongly
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="responsibility_and_accountability"
                                                    value="40">
                                                Disagree</label>
                                            <label style="margin-right:15px;"><input type="radio" name="responsibility_and_accountability"
                                                    value="60">
                                                Neutral</label>
                                            <label style="margin-right:15px;"><input type="radio" name="responsibility_and_accountability"
                                                    value="80">
                                                Agree</label>
                                            <label><input type="radio" name="responsibility_and_accountability" value="100">
                                                Strongly
                                                Agree</label>
                                        </div>
                                    </div>

                                    

                                    <!-- Section 5 -->
                                    <h6
                                        style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                                        5- Humility and Service (At Institutional level) 
                                    </h6>

                                    <div class="col-md-6 mt-1"
                                        style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                                        <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                           5.Please share your suggestions or areas where the University can improve your thesis experience and help you do applied and commercial research.
(This will be open ended question, which will bring feedback about how students experience their academic journey. Themes for area of improvement will be made from the input of students on this question). 
                                        </label>
                                        <div style="margin-top:8px;">
                                            <textarea class="form-control" id="humility_and_service_at_institutional_level" name="humility_and_service_at_institutional_level" rows="4"></textarea>
                                           
                                        </div>
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
@push('script')
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            $(document).ready(function () {
              
              

                 $('#researchForm').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);
                     // Show loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                     
                    $.ajax({
                        url: "{{ route('scholars-satisfaction.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                            $('.select2').val(null).trigger('change');
                              // Remove all extra grant groups and keep only the first one
                            $('#grant-details-container .grant-group:not(:first)').remove();

                            // Reset the proof container of the first group
                            $('#grant-details-container .grant-group:first .proof-container').hide();

                            // Reset index to 1
                            grantIndex = 1;

                            document.getElementById("employer_satisfaction").value = "";
                            document.getElementById("graduate_satisfaction").value = "";

                            // Reset stars
                            employerRaty.setScore(0);
                            graduateRaty.setScore(0);
                        },
                        error: function (xhr) {
                            Swal.close();
                            // Clear previous errors before showing new ones
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                             if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Loop through all validation errors
                            $.each(errors, function (field, messages) {
                                let input = form.find('[name="' + field + '"]');

                                if (input.length) {
                                    input.addClass('is-invalid');

                                    // Show error message under input
                                    input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                }
                            });

                        } else if (xhr.status === 409) {
                            // 🔥 Duplicate record message
                            Swal.fire({
                                icon: 'error',
                                title: 'Duplicate Entry',
                                text: xhr.responseJSON.message
                            });

                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                        }
                    });
                });

                $('#importForm').on('submit', function (e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    Swal.fire({
                        title: 'Importing...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('employability.import') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            Swal.close();
                            Swal.fire('Success', res.message, 'success');
                            $('#importModal').modal('hide');
                            $('#importForm')[0].reset();
                        },
                        error: function (xhr) {
                            Swal.close();
                            Swal.fire('Error', xhr.responseJSON.message ?? 'Import failed', 'error');
                        }
                    });
                });
                 
               

            });
        </script>
    @endif
    @endpush
@extends('layouts.app')
@push('style')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
@endush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-datatable table-responsive card-body">

                <form id="researchForm" class="row">
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
                            <select name="employee_id" id="selectRole" class="select2 form-select" required>
                                <option value="">-- Select Faculty Member --</option>
                                @foreach($facultyMembers as $member)
                                    <option value="{{ $member->id }}" data-department="{{ $member->department }}"
                                        data-job_title="{{ $member->job_title }}" {{ request('employee_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-4 text-end">
                            <a class="btn btn-label-primary waves-effect" href="">
                                View
                            </a>
                        </div>

                    </div>
                    <div class="row" style="padding:20px; font-family:Arial; display:flex; flex-wrap:wrap; gap:15px;">

                        <!-- Section 1 -->
                        <h6 style="width:100%; margin-top:20px; margin-bottom:10px; font-weight:bold; font-size:18px;">
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
                                <label style="margin-right:15px;"><input type="radio" name="responsibility_accountability_1"
                                        value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="responsibility_accountability_1"
                                        value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="responsibility_accountability_1"
                                        value="80">
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
                                <label style="margin-right:15px;"><input type="radio" name="responsibility_accountability_2"
                                        value="20">
                                    Strongly Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="responsibility_accountability_2"
                                        value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="responsibility_accountability_2"
                                        value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="responsibility_accountability_2"
                                        value="80">
                                    Agree</label>
                                <label><input type="radio" name="responsibility_accountability_2" value="100">
                                    Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <h6 style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            2- Empathy & Compassion
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Demonstrates genuine care and concern for students and colleagues and listen and
                                respond to them empathetically
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_1"
                                        value="20">
                                    Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_1"
                                        value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_1"
                                        value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_1"
                                        value="80">
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
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_2"
                                        value="20">
                                    Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_2"
                                        value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_2"
                                        value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_2"
                                        value="80">
                                    Agree</label>
                                <label><input type="radio" name="empathy_compassion_2" value="100">
                                    Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <!-- Section 3 -->
                        <h6 style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            3- Humility & Service
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Offers help without being asked, especially during high-pressure periods.
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="humility_service_1" value="20">
                                    Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="humility_service_1" value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="humility_service_1" value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="humility_service_1" value="80">
                                    Agree</label>
                                <label><input type="radio" name="humility_service_1" value="100"> Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Regularly volunteers for tasks that serve the larger goals of the department or
                                university.
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="humility_service_2" value="20">
                                    Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="humility_service_2" value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="humility_service_2" value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="humility_service_2" value="80">
                                    Agree</label>
                                <label><input type="radio" name="humility_service_2" value="100"> Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <!-- Section 4 -->
                        <h6 style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            4- Honesty & Integrity
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Speaks the truth, even when it's difficult, and uphold ethical standards.
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1" value="20">
                                    Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1" value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1" value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_1" value="80">
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
                                <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2" value="20">
                                    Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2" value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2" value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="honesty_integrity_2" value="80">
                                    Agree</label>
                                <label><input type="radio" name="honesty_integrity_2" value="100">
                                    Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <!-- Section 5 -->
                        <h6 style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            5- Inspirational Leadership
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Inspires others with a positive attitude and solutions-focused mindset.
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_1"
                                        value="20">
                                    Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_1"
                                        value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_1"
                                        value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_1"
                                        value="80">
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
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_2"
                                        value="20">
                                    Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_2"
                                        value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_2"
                                        value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_2"
                                        value="80">
                                    Agree</label>
                                <label><input type="radio" name="inspirational_leadership_2" value="100">
                                    Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <!-- Section 6 -->
                        <h6 style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            6- Performance Highlights & Development Needs
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Strength
                            </label>
                            <div style="margin-top:8px;">
                                <input id="TagifyBasic" class="form-control" name="strength" value="Tag1, Tag2, Tag3" />
                            </div>
                        </div>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;background: #f9f9f9;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Area of Improvement
                            </label>
                            <div style="margin-top:8px;">
                                <input id="TagifyBasic1" class="form-control" name="area_of_improvement"
                                    value="Tag1, Tag2, Tag3" />
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
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js')}}"></script>
    <script src="{{ asset('admin/assets/js/forms-tagify.js')}}"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2();

            // AJAX form submit
            $('#researchForm').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('employee.rating.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Processing...',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function (response) {
                        Swal.close();
                        Swal.fire('Success', response.message, 'success').then(() => {
                            if (response.redirect) {
                                window.location.href = response.redirect; // redirect after alert
                            }
                        });
                        $('#researchForm')[0].reset();
                        $('.select2').val('').trigger('change'); // reset selects
                    },
                    error: function (xhr) {
                        Swal.close();
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMsg = '';
                            $.each(errors, function (key, val) {
                                errorMsg += val[0] + '\n';
                            });
                            Swal.fire('Validation Error', errorMsg, 'error');
                        } else {
                            Swal.fire('Error', 'Something went wrong!', 'error');
                        }
                    }
                });
            });
        });
    </script>
@endpush
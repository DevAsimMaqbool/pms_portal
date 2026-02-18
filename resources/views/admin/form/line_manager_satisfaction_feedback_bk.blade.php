@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                {{-- <h5>KPA to role</h5> --}}
                <form id="researchForm" enctype="multipart/form-data" class="row">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="multicol-language">Name of Faculty Member</label>
                            <select name="employee_id" id="select2Success" class="select2 form-select" required>
                                <option value="">-- Select Faculty Member --</option>
                                @foreach($facultyMembers as $member)
                                    <option value="{{ $member->id }}" data-department="{{ $member->department }}"
                                        data-job_title="{{ $member->job_title }}" {{ request('employee_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="multicol-language">Year</label>
                            <select name="year" id="select2Year" class="select2 form-select" required>
                                <option value="">-- Select Year --</option>
                                <option value="2025-2026">2025-2026</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="padding:20px; font-family:Arial; display:flex; flex-wrap:wrap; gap:15px;">


                        <!-- Section 1 -->
                        <h6 style="width:100%; margin-top:20px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            1- Responsibility & Accountability
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Admits mistakes and takes responsibility for correcting them
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="responsibility_accountability_1"
                                        value="20">
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
                                <label><input type="radio" name="responsibility_accountability_1" value="100"> Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Keeps commitments and meets deadlines consistently
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
                                <label><input type="radio" name="responsibility_accountability_2" value="100"> Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <h6 style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            2- Empathy & Compassion
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Demonstrates genuine care and concern for students and colleagues and listens empathetically
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_1"
                                        value="20"> Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_1"
                                        value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_1"
                                        value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_1"
                                        value="80"> Agree</label>
                                <label><input type="radio" name="empathy_compassion_1" value="100"> Strongly Agree</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Actively contributes to a collaborative and supportive team environment
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_2"
                                        value="20"> Strongly
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_2"
                                        value="40">
                                    Disagree</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_2"
                                        value="60">
                                    Neutral</label>
                                <label style="margin-right:15px;"><input type="radio" name="empathy_compassion_2"
                                        value="80"> Agree</label>
                                <label><input type="radio" name="empathy_compassion_2" value="100"> Strongly Agree</label>
                            </div>
                        </div>

                        <!-- Section 3 -->
                        <h6 style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            3- Humility & Service
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
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
                                <label><input type="radio" name="humility_service_1" value="100"> Strongly Agree</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Regularly volunteers for tasks that serve the larger goals of the department or university
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
                                <label><input type="radio" name="humility_service_2" value="100"> Strongly Agree</label>
                            </div>
                        </div>

                        <!-- Section 4 -->
                        <h6 style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            4- Honesty & Integrity
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Speaks the truth, even when it's difficult, and upholds ethical standards.
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
                                <label><input type="radio" name="honesty_integrity_1" value="100"> Strongly Agree</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
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
                                <label><input type="radio" name="honesty_integrity_2" value="100"> Strongly Agree</label>
                            </div>
                        </div>

                        <!-- Section 5 -->
                        <h6 style="width:100%; margin-top:30px; margin-bottom:10px; font-weight:bold; font-size:18px;">
                            5- Inspirational Leadership
                        </h6>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Inspires others with a positive attitude and solutions-focused mindset.
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_1"
                                        value="20"> Strongly
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
                                <label><input type="radio" name="inspirational_leadership_1" value="100"> Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-1"
                            style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">
                                Sets a strong example of professional conduct and personal values.
                            </label>
                            <div style="margin-top:8px;">
                                <label style="margin-right:15px;"><input type="radio" name="inspirational_leadership_2"
                                        value="20"> Strongly
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
                                <label><input type="radio" name="inspirational_leadership_2" value="100"> Strongly
                                    Agree</label>
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div style="width:100%; margin-top:30px; margin-bottom:20px;">
                            <label style="font-weight:bold; margin-bottom:8px; display:block;">Remarks*</label>
                            <textarea name="remarks"
                                style="width:100%; height:120px; padding:10px; border:1px solid #ccc; border-radius:6px;"
                                required
                                placeholder="Please provide details of the assigned task(s) and the employee’s designated role and responsibilities during the event."></textarea>
                        </div>

                    </div>
                    <div class="col-1 text-center demo-vertical-spacing">
                        <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
@endpush
@push('script')
    <script>
        $(document).ready(function () {
            // Submit form
            $('#researchForm').on('submit', function (e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);
                let hasError = false;

                // ======== CLIENT-SIDE VALIDATION ========
                $('.form-control, .form-select').removeClass('is-invalid');

                form.find('input[required], select[required]').each(function () {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        hasError = true;
                    }
                });

                if (hasError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill all required fields before submitting.'
                    });
                    return false;
                }

                // ======== AJAX REQUEST ========
                $.ajax({
                    url: "{{ route('employee.rating.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we save your data.',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function (response) {
                        Swal.close();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(() => {
                            // Redirect to employee.rating.index after closing the success alert
                            window.location.href = "{{ route('employee.rating.index') }}";
                        });
                        form[0].reset();
                        $('#extraFieldContainer').empty();
                    },
                    error: function (xhr) {
                        Swal.close();
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMsg = '';

                            $.each(errors, function (key, value) {
                                errorMsg += value[0] + '\n';
                                $('[name="' + key + '"]').addClass('is-invalid');
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Failed',
                                text: errorMsg
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong! Please try again later.'
                            });
                        }
                    }
                });
            });
        });
    </script>

@endpush
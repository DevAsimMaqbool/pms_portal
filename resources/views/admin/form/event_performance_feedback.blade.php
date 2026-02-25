@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
    @if(in_array(getRoleName(activeRole()), ['HOD','Dean']))
        <div class="card">
            <div class="card-datatable table-responsive card-body">

                <form id="researchForm" class="row">
                    @csrf

                    <div class="row g-3" style="padding:20px; font-family:Arial;">

                        <!-- Name of Faculty Member -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2 d-block">Name of Faculty Member</label>
                            <select name="employee_id" class="select2 form-select" required>
                                <option value="">-- Select Faculty Member --</option>
                                @foreach($facultyMembers as $member)
                                    <option value="{{ $member->id }}" data-department="{{ $member->department }}"
                                        data-job_title="{{ $member->job_title }}" {{ request('employee_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Event -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2 d-block">Event</label>
                            <select name="event_name[]" id="eventSelect" class="select2 form-select" required>
                                <option value="">-- Select Event --</option>
                                <option value="Sports Festival">Sports Festival</option>
                                <option value="Alumni Reunion">Alumni Reunion</option>
                                <option value="Canvocation">Canvocation</option>
                                <option value="Rector's Conference">Rector's Conference</option>
                                <option value="SEE Pakistan">SEE Pakistan</option>
                                <option value="Society Fair">Society Fair</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Other Event Input (Hidden by Default) -->
                        <div class="col-md-6 d-none" id="otherEventBox">
                            <label class="fw-bold mb-2 d-block">Please Specify Other Event</label>
                            <input type="text" name="other_event" id="otherEventInput" class="form-control"
                                placeholder="Enter event name">
                        </div>

                        <!-- Event Feedback Rating -->
                        <div class="col-md-6 mt-7">
                            <label class="fw-bold mb-2 d-block">Event Feedback Rating</label>
                            <div id="ratingBox" class="half-star-ratings raty" data-half="true" data-number="5">
                            </div>

                            <input type="hidden" name="rating" id="rating" value="">
                        </div>


                        <!-- Remarks -->
                        <div class="mt-7 mb-3 w-100">
                            <label class="fw-bold mb-2 d-block">Remarks*</label>
                            <textarea name="remarks" class="form-control" style="height:120px; resize:none;" required
                                placeholder="Please provide details of the assigned task(s) and the employee’s designated role and responsibilities during the event."></textarea>
                        </div>

                    </div>

                    <div class="col-1 text-center mb-3">
                        <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                    </div>

                </form>

            </div>
        </div>
    @else
        <div class="misc-wrapper">
            <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">401</h1>
            <h4 class="mb-2 mx-2">You are not authorized! 🔐</h4>
            <p class="mb-6 mx-2">You don’t have permission to access this page. Go back!</p>
            <div class="mt-12">
                <img src="{{ asset('admin/assets/img/illustrations/page-misc-you-are-not-authorized.png') }}" alt="page-misc-not-authorized" width="170" class="img-fluid" />
            </div>
        </div>
    @endif
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    @if(in_array(getRoleName(activeRole()), ['HOD','Dean']))
    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2();

            // AJAX form submit
            $('#researchForm').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('employee.feedback.store') }}",
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

        $('#eventSelect').on('change', function () {
            let selectedValues = $(this).val();

            if (selectedValues && selectedValues.includes('Other')) {
                $('#otherEventBox').removeClass('d-none');
                $('#otherEventInput').attr('required', true);
            } else {
                $('#otherEventBox').addClass('d-none');
                $('#otherEventInput').removeAttr('required').val('');
            }
        });
    </script>
    @endif
@endpush
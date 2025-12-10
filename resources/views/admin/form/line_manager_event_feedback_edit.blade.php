@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-datatable table-responsive card-body">
                @if ($errors->any())
                    <div id="errorAlert" class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <script>
                        setTimeout(function () {
                            const alert = document.getElementById('errorAlert');
                            if (alert) alert.style.display = 'none';
                        }, 2000); // 2000ms = 2 seconds
                    </script>
                @endif

                <form id="researchForm" class="row" method="POST"
                    action="{{ route('employee.feedback.update', $feedback->id) }}">
                    @csrf

                    <div class="row g-3" style="padding:20px; font-family:Arial;">

                        <!-- Name of Faculty Member -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2 d-block">Name of Faculty Member</label>
                            <select name="employee_id" class="select2 form-select" required>
                                <option value="">-- Select Faculty Member --</option>
                                @foreach($facultyMembers as $member)
                                    <option value="{{ $member->id }}" data-department="{{ $member->department }}"
                                        data-job_title="{{ $member->job_title }}" {{ isset($feedback) && $feedback->employee_id == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Event -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2 d-block">Event</label>
                            <select name="event_name" class="select2 form-select" required>
                                <option value="">-- Select Event --</option>
                                @foreach(['Sports Festival', 'Alumni Reunion', 'Canvocation', "Rector's Conference", 'SEE Pakistan', 'Society Fair'] as $event)
                                    <option value="{{ $event }}" {{ isset($feedback) && $feedback->event_name == $event ? 'selected' : '' }}>
                                        {{ $event }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Event Feedback Rating -->
                        <div class="col-md-6 mt-7">
                            <label class="fw-bold mb-2 d-block">Event Feedback Rating</label>
                            <div id="ratingBox" class="half-star-ratings raty" data-half="true"
                                data-score="{{ $starScore }}" data-number="5"></div>
                            <input type="hidden" name="rating" id="rating" value="{{ $starScore }}">
                        </div>

                        <!-- Remarks -->
                        <div class="mt-7 mb-3 w-100">
                            <label class="fw-bold mb-2 d-block">Remarks*</label>
                            <textarea name="remarks" class="form-control" style="height:120px; resize:none;" required
                                placeholder="Please provide details of the assigned task(s) and the employee’s designated role and responsibilities during the event.">{{ $feedback->remarks ?? '' }}</textarea>
                        </div>

                    </div>

                    <div class="col-4 text-center mb-3">
                        <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
@endpush
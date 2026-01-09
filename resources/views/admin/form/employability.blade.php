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
                <!-- Tab panes -->
                <div class="tab-content">
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <h5 class="mb-1">% Employability</h5>
                            <form id="researchForm" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                                <input type="hidden" id="indicator_id" name="employability_id" value="103">
                                <div class="row g-6 mt-0">
                                    <div id="grant-details-container">
                                        <div class="grant-group row g-3 mb-3 p-3 border border-primary">
                                            <div class="col-md-6">
                                                <label for="student_name" class="form-label">Student Name</label>
                                                <select name="student_id" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Faculty Member --</option>
                                                    @foreach($facultyMembers as $member)
                                                        <option value="{{ $member->id }}"
                                                            data-faculty_id="{{ $member->faculty_id }}"
                                                            data-department="{{ $member->department }}"
                                                            data-job_title="{{ $member->job_title }}">
                                                            {{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="faculty" class="form-label">Faculty</label>
                                                <select name="faculty_id" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Faculty Member --</option>
                                                    @foreach($facultyMembers as $member)
                                                        <option value="{{ $member->id }}"
                                                            data-faculty_id="{{ $member->faculty_id }}"
                                                            data-department="{{ $member->department }}"
                                                            data-job_title="{{ $member->job_title }}">
                                                            {{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="program" class="form-label">Program</label>
                                                <select name="program_id" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Faculty Member --</option>
                                                    @foreach($facultyMembers as $member)
                                                        <option value="{{ $member->id }}"
                                                            data-faculty_id="{{ $member->faculty_id }}"
                                                            data-department="{{ $member->department }}"
                                                            data-job_title="{{ $member->job_title }}">
                                                            {{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="batch" class="form-label">Batch</label>
                                                <select name="batch_id" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Faculty Member --</option>
                                                    @foreach($facultyMembers as $member)
                                                        <option value="{{ $member->id }}"
                                                            data-faculty_id="{{ $member->faculty_id }}"
                                                            data-department="{{ $member->department }}"
                                                            data-job_title="{{ $member->job_title }}">
                                                            {{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="passing_year" class="form-label">Passing Year</label>
                                                <select name="passing_year" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Faculty Member --</option>
                                                    @foreach($facultyMembers as $member)
                                                        <option value="{{ $member->id }}"
                                                            data-faculty_id="{{ $member->faculty_id }}"
                                                            data-department="{{ $member->department }}"
                                                            data-job_title="{{ $member->job_title }}">
                                                            {{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Employer Name</label>
                                                <input type="text" name="employer_name" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="sector" class="form-label">Sector</label>
                                                <select name="sector" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Sector --</option>
                                                    @foreach($facultyMembers as $member)

                                                        <option value="{{ $member->id }}"
                                                            data-faculty_id="{{ $member->faculty_id }}"
                                                            data-department="{{ $member->department }}"
                                                            data-job_title="{{ $member->job_title }}">
                                                            {{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Salary</label>
                                                <input type="number" name="salary" class="form-control" min="1" step="1"
                                                    required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="market_competitive_salary" class="form-label">Market Competitive
                                                    Salary</label>
                                                <select name="market_competitive_salary"
                                                    class="select2 form-select market_competitive_salary" required>
                                                    <option value="">-- Select --</option>
                                                    <option value="Above">Above</option>
                                                    <option value="At Par">At Par</option>
                                                    <option value="Low">Low</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label d-block">Job Relevancy</label>
                                                <div>
                                                    <input type="radio" name="rob_relevancy" id="yes" value="yes">
                                                    <label for="yes">Yes</label>

                                                    <input type="radio" name="rob_relevancy" id="rob_relevancy" value="no"
                                                        checked>
                                                    <label for="rob_relevancy">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="fw-bold mb-2 d-block">Employer Satisfaction</label>
                                                <div id="ratingBox" class="half-star-ratings raty" data-half="true"
                                                    data-number="5">
                                                </div>
                                                <input type="hidden" name="employer_satisfaction" id="employer_satisfaction"
                                                    value="">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="fw-bold mb-2 d-block">Graduate Satisfaction</label>
                                                <div class="onChange-event-ratings raty mb-4" data-half="true" data-number="5">
                                                </div>

                                                <input type="hidden" name="graduate_satisfaction" id="graduate_satisfaction"
                                                    value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 text-end" style="margin-left: -16px !important;">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>

                        </div>
                    @endif
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade" id="form3" role="tabpanel">
                            @if(auth()->user()->hasRole(['HOD']))
                                <div class="d-flex">
                                    <select id="bulkAction" class="form-select w-auto me-2">
                                        <option value="">-- Select Action --</option>
                                        <option value="2">Verified</option>
                                        <option value="1">UnVerified</option>
                                    </select>
                                    <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                                </div>
                            @endif
                            <table id="complaintTable3" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Created By</th>
                                        <th>Name</th>
                                        <th>Funding Agency</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endif

                </div>
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
@endpush
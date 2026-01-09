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
                            <h5 class="mb-1">Recovery %</h5>
                            <form id="researchForm" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                                <input type="hidden" id="indicator_id" name="employability_id" value="103">
                                <div class="row g-6 mt-0">
                                    <div id="grant-details-container">
                                        <div class="grant-group row g-3 mb-3 p-3 border border-primary">
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
                                                <label for="department_id" class="form-label">Department</label>
                                                <select name="department_id" class="select2 form-select department" required>
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
                                                <label for="period" class="form-label">Period</label>
                                                <select name="period" class="select2 form-select period" required>
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
                                                <label class="form-label">Recovery Target</label>
                                                <input type="number" name="recovery_target" class="form-control" min="1"
                                                    step="1" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Target Achieved</label>
                                                <input type="number" name="achieved_target" class="form-control" min="1"
                                                    step="1" required>
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
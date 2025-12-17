@extends('layouts.app')

@push('style')
    {{-- Vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
    <style>
        .form-disabled {
            color: #acaab1;
            background-color: #f3f2f3;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="nav-align-top">
            @if(auth()->user()->hasRole(['Dean']))
                <!-- Nav tabs -->
                <ul class="nav nav-pills mb-4" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Research Publication</a>
                    </li>
                </ul>
            @endif
            @if(auth()->user()->hasRole(['HOD']))
                <!-- Nav tabs -->
                <ul class="nav nav-pills mb-4" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Research Publication</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Research Target Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#form3" role="tab">Table</a>
                    </li>
                </ul>
            @endif

            <!-- Tab panes -->
            <div class="tab-content">

                {{-- ================= FORM 1 ================= --}}
                @if(auth()->user()->hasRole(['Teacher', 'HOD']))
                    <div class="tab-pane fade show active" id="form1" role="tabpanel">

                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Research Publication</h5>
                            </div>
                            <a href="{{ route('indicators_crud.index', ['slug' => 'achievement-of-publication-target', 'id' => $indicatorId]) }}"
                                class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                        </div>
                        <form id="researchForm1" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                            <input type="hidden" id="form_status" name="form_status" value="RESEARCHER" required>
                            <div class="row g-6 mt-0">
                                <div class="col-12 col-lg-8">
                                    <div class="card shadow-none bg-transparent border border-primary">
                                        <div class="card-body">
                                            <div class="row g-6">
                                                <div class="col-md-6">
                                                    <label class="form-label">Journal Category</label>
                                                    <select name="target_category" class="form-select">
                                                        <option value="">Select Target Category</option>
                                                        <option value="Scopus-Indexed">Scopus Indexed</option>
                                                        <option value="HEC">HEC</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Publications Link</label>
                                                    <input type="url" name="link_of_publications" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Journal Clasification</label>

                                                    <select name="journal_clasification" class="form-select"
                                                        id="journal_clasification" disabled>
                                                        <option value="">Select Journal Classification</option>
                                                        <option value="Q1" class="scopus scopus-q1-1">Q1</option>
                                                        <option value="Q2" class="scopus scopus-q2-1">Q2</option>
                                                        <option value="Q3" class="scopus scopus-q3-1">Q3</option>
                                                        <option value="Q4" class="scopus scopus-q4-1">Q4</option>
                                                        <option value="W" class="hec hec-w-1">W</option>
                                                        <option value="X" class="hec hec-x-1">X</option>
                                                        <option value="Y" class="hec hec-y-1">Y</option>
                                                        <option value="Medical" class="hec medical-recognized-1">Medical
                                                        </option>
                                                    </select>


                                                </div>
                                               


                                            </div>
                                        </div>
                                    </div>


                                    <div class="card shadow-none bg-transparent border border-primary mt-6">
                                        <div class="card-body">
                                            <div class="row g-6">

                                                <div class="col-md-6">
                                                    <label class="form-label">Your Rank (As Author)</label>
                                                    <input type="number" name="as_author_your_rank" class="form-control">
                                                </div>
                                                 <div class="col-md-6">
                                                    <label class="form-label d-block">Is there at least 1 international co-author?</label>
                                                    <div>
                                                        <input type="radio" name="nationality" id="national" value="National">
                                                        <label for="national">No</label>

                                                        <input type="radio" name="nationality" id="international"
                                                            value="International" checked>
                                                        <label for="international">Yes</label>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>
                                    </div>


                                    <div class="card shadow-none bg-transparent border border-primary mt-6">
                                        <div class="card-body">
                                            <div id="grant-details-container">
                                                <div class="row g-6 grant-group">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Co-Author Name</label>
                                                        <input type="text" name="co_author[0][name]" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Rank</label>
                                                        <input type="number" name="co_author[0][rank]" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">University Name</label>
                                                        <select name="co_author[0][univeristy_name]"
                                                            class="univeristy-dropdown select2 form-select">
                                                            <option value="">Select Univeristy</option>
                                                            @foreach(getUniveristyJson() as $uni)
                                                                <option value="{{ $uni['University Name'] }}">
                                                                    {{ $uni['University Name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Country</label>

                                                        <select name="co_author[0][country]"
                                                            class="country-dropdown select2 form-select">
                                                            <option value="">Select Country</option>
                                                            @foreach(getAllCountries() as $con)
                                                                <option value="{{ $con['code'] }}">
                                                                    {{ $con['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label d-block">Co-Author Role</label>
                                                        <div>
                                                            <input type="radio" name="co_author[0][your_role]" id="student"
                                                                value="Student" checked>
                                                            <label for="student">Student</label>

                                                            <input type="radio" name="co_author[0][your_role]" id="researcher"
                                                                value="Researcher">
                                                            <label for="other">Researcher</label>

                                                            <input type="radio" name="co_author[0][your_role]" id="professional"
                                                                value="Professional">
                                                            <label for="other">Professional</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="display:none">
                                                        <label class="form-label">Designation</label>
                                                        <input type="text" name="co_author[0][designation]"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Student Roll Number</label>
                                                        <input type="text" name="co_author[0][student_roll_no]"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">No Of Papers Co-Authored with this person in
                                                            the past.</label>
                                                        <input type="number" name="co_author[0][no_paper_past]"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Co-Author Email</label>
                                                        <input type="email" name="co_author[0][co_author_email]"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label d-block">Is the student first
                                                            Co-author?</label>
                                                        <div>
                                                            <input type="radio"
                                                                name="co_author[0][is_the_student_fitst_coauthor]"
                                                                id="is_the_student_fitst_coauthor_yes" value="YES">
                                                            <label for="is_the_student_fitst_coauthor_yes">Yes</label>

                                                            <input type="radio"
                                                                name="co_author[0][is_the_student_fitst_coauthor]"
                                                                id="is_the_student_fitst_coauthor_no" value="NO" checked>
                                                            <label for="is_the_student_fitst_coauthor_no">No</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Career</label>
                                                        <select name="co_author[0][career]" class="form-select">
                                                            <option value="">Select Career</option>
                                                            <option value="PG">PG</option>
                                                            <option value="MS">MS</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-body-secondary bg-label-secondary">
                                            <button type="button" class="btn btn-primary waves-effect waves-light mt-6"
                                                id="add-grant">
                                                <i class="icon-base ti tabler-plus me-1"></i>
                                                <span class="align-middle">Add</span>
                                            </button>
                                        </div>
                                    </div>



                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="card shadow-none bg-transparent border border-primary">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Targets</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-6">
                                                <label class="form-label" for="ecommerce-product-discount-price">Scopus</label>
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text">Q1</span>
                                                    <input type="number" class="form-control scopus-q1 form-disabled"
                                                        name="scopus_q1" readonly>
                                                </div>
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text">Q2</span>
                                                    <input type="number" class="form-control scopus-q2 form-disabled"
                                                        name="scopus_q2" readonly>
                                                </div>
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text">Q3</span>
                                                    <input type="number" class="form-control scopus-q3 form-disabled"
                                                        name="scopus_q3" readonly>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-text">Q4</span>
                                                    <input type="number" class="form-control scopus-q4 form-disabled"
                                                        name="scopus_q4" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-6">
                                                <label class="form-label" for="ecommerce-product-discount-price">HEC</label>
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text">W</span>
                                                    <input type="number" class="form-control hec-w form-disabled" name="hec_w"
                                                        readonly>
                                                </div>
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text">X</span>
                                                    <input type="number" class="form-control hec-x form-disabled" name="hec_x"
                                                        readonly>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-text">Y</span>
                                                    <input type="number" class="form-control hec-y form-disabled" name="hec_y"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="mb-6">
                                                <label class="form-label"> Medical</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Recognized</span>
                                                    <input type="number" class="form-control medical-recognized form-disabled"
                                                        name="medical_recognized" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-8 mt-3">
                                <button class="btn btn-primary float-end" style="margin-right: 7px;">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                @endif
                {{-- ================= FORM 2 ================= --}}
                @if(auth()->user()->hasRole(['HOD']))
                    <div class="tab-pane fade" id="form2" role="tabpanel">
                        <form id="researchForm2" enctype="multipart/form-data" class="row">
                            @csrf
                            <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                            <input type="hidden" id="form_status" name="form_status" value="HOD" required>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="faculty_member" class="form-label">Name of Faculty Member</label>
                                    <select name="faculty_member_id[]" id="select2Success" class="select2 form-select" multiple
                                        required>
                                        <option value="">-- Select Faculty Member --</option>
                                        @foreach($facultyMembers as $member)
                                            <option value="{{ $member->id }}" data-department="{{ $member->department }}"
                                                data-job_title="{{ $member->job_title }}">
                                                {{ $member->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>







                            </div>
                            <div class="row g-6 mt-0">
                                <div class="col-md-4">
                                    <small class="fw-medium d-block pt-4 mb-4">Scopus</small>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">Q1</span>
                                        <input type="number" class="form-control" name="scopus_q1" id="scopus-q1">
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">Q2</span>
                                        <input type="number" class="form-control" name="scopus_q2" id="scopus-q2">
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">Q3</span>
                                        <input type="number" class="form-control" name="scopus_q3" id="scopus-q3">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text">Q4</span>
                                        <input type="number" class="form-control" name="scopus_q4" id="scopus-q4">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <small class="fw-medium d-block pt-4 mb-4">HEC</small>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">W</span>
                                        <input type="number" class="form-control" name="hec_w" id="hec-w">
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">X</span>
                                        <input type="number" class="form-control" name="hec_x" id="hec-x">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text">Y</span>
                                        <input type="number" class="form-control" name="hec_y" id="hec-y">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <small class="fw-medium d-block pt-4 mb-4">Medical</small>
                                    <div class="input-group">
                                        <span class="input-group-text">Recognized</span>
                                        <input type="number" class="form-control" name="medical_recognized"
                                            id="medical-recognized">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-outline-secondary waves-effect w-100 total-target">Tota
                                        0</button>
                                    <input type="text" name="target" class="" style="display:none">
                                </div>
                                <div class="col-md-6">
                                    <label for="national" class="form-label">National</label>
                                    <input type="number" id="national" class="form-control" name="national">
                                </div>
                                <div class="col-md-6">
                                    <label for="international" class="form-label">Inter National</label>
                                    <input type="number" id="international" class="form-control" name="international">
                                </div>
                            </div>
                            <div class="col-4 demo-vertical-spacing">
                                <button class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                            </div>
                        </form>
                        <hr>
                        <div class="">
                            <div class="table-responsive text-nowrap">
                                <table id="geTtargetTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Indicator</th>
                                            <th>Target</th>
                                            <th>Q1</th>
                                            <th>Q2</th>
                                            <th>Q3</th>
                                            <th>Q4</th>
                                            <th>W</th>
                                            <th>X</th>
                                            <th>Y</th>
                                            <th>Medical Recognized</th>
                                            <th>National</th>
                                            <th>International</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
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
                                    <th>Indicator Category</th>
                                    <th>Classification</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                @endif
                @if(auth()->user()->hasRole(['Dean']))
                    <div class="tab-pane fade show active" id="form1" role="tabpanel">
                        <table id="complaintTable1" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Created By</th>
                                    <th>Indicator Category</th>
                                    <th>Classification</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="form2" role="tabpanel">

                        {{-- <table id="complaintTable2" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>#</th>
                                    <th>Created By</th>
                                    <th>Indicator Category</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table> --}}
                    </div>
                @endif
                @if(auth()->user()->hasRole(['ORIC']))
                    <div>
                        <div class="d-flex">
                            <select id="bulkAction" class="form-select w-auto me-2">
                                <option value="">-- Select Action --</option>
                                <option value="3">Verified</option>
                                <option value="2">UnVerified</option>
                            </select>
                            <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                        </div>
                        <table id="complaintTable3" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>#</th>
                                    <th>Created By</th>
                                    <th>Indicator Category</th>
                                    <th>Classification</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="viewFormModal" tabindex="-1" aria-labelledby="viewFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewFormModalLabel">Form Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Created By</th>
                                <td id="modalCreatedBy"></td>
                            </tr>
                            <tr>
                                <th>Target Category</th>
                                <td id="modalTargetCategory"></td>
                            </tr>
                            <tr id="status-approval">
                                <th>Status</th>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="approveCheckbox">
                                        <label class="form-check-label" for="approveCheckbox">Approved</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Created Date</th>
                                <td id="modalCreatedDate"></td>
                            </tr>
                            <tbody id="modalExtraFields"></tbody>
                        </table>
                        <h5 class="card-title mb-2 me-2 pt-1 mb-2 d-flex align-items-center"><i
                                class="icon-base ti tabler-history me-3"></i>History</h5>
                        <ul class="timeline mb-0" id="modalExtraFieldsHistory">
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Permission Modal -->
    </div>
@endsection

@push('script')
    {{-- Vendor Scripts --}}
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
        <script>
            $(document).ready(function () {
                $(document).on('change', 'select[name="target_category"]', function () {
                    let category = $(this).val();
                    let journalSelect = $('#journal_clasification');

                    // Reset select first
                    journalSelect.val('');
                    journalSelect.prop('disabled', true);

                    // Hide all options except placeholder
                    journalSelect.find('option').each(function () {
                        if ($(this).val() === '') {
                            //if use that hide in like q1 hide not show then remove this cod $(this).hide(); in if condition
                            $(this).hide();
                        } else {
                            $(this).hide(); // hide all others by default
                        }
                    });

                    // Stop if no category selected
                    if (!category) return;

                    // Enable the select
                    journalSelect.prop('disabled', false);

                    // Show only relevant options that have a value (ignore empty value options)
                    if (category === "Scopus-Indexed") {
                        journalSelect.find('.scopus').each(function () {
                            /*if ($(this).val() !== '') { 
                                $(this).show();
                            }*/
                            $(this).show();
                        });
                    } else if (category === "HEC") {
                        journalSelect.find('.hec').each(function () {
                            /*if ($(this).val() !== '') { 
                                $(this).show();
                            }*/
                            $(this).show();
                        });
                    }
                });

                // Function to toggle fields based on role within a specific row
                function toggleCoAuthorFieldsRow($row) {
                    let role = $row.find('input[name$="[your_role]"]:checked').val();

                    if (role === 'Student') {
                        // Show student-specific fields
                        $row.find('input[name$="[student_roll_no]"]').closest('.col-md-6').show();
                        $row.find('input[name$="[is_the_student_fitst_coauthor]"]').closest('.col-md-6').show();
                        $row.find('select[name$="[career]"]').closest('.col-md-6').show();

                        // Hide designation
                        $row.find('input[name$="[designation]"]').closest('.col-md-6').hide();
                    } else {
                        // Show designation
                        $row.find('input[name$="[designation]"]').closest('.col-md-6').show();

                        // Hide student-specific fields
                        $row.find('input[name$="[student_roll_no]"]').closest('.col-md-6').hide();
                        $row.find('input[name$="[is_the_student_fitst_coauthor]"]').closest('.col-md-6').hide();
                        $row.find('select[name$="[career]"]').closest('.col-md-6').hide();
                    }
                }

                // Initialize all existing rows on page load
                $('.grant-group').each(function () {
                    toggleCoAuthorFieldsRow($(this));
                });

                // Listen for role changes for any row (existing + future)
                $(document).on('change', 'input[name$="[your_role]"]', function () {
                    let $row = $(this).closest('.grant-group');
                    toggleCoAuthorFieldsRow($row);
                });









                function fetchTarget(formSelector, indicatorId) {
                    if (!indicatorId) {
                        clearTargetFields(formSelector);
                        return;
                    }

                    $.ajax({
                        url: "{{ route('faculty-target.getTarget') }}",
                        type: "GET",
                        data: { indicator_id: indicatorId },
                        success: function (res) {
                            if (!res.data) {
                                clearTargetFields(formSelector);
                                return;
                            }

                            // SCOPUS
                            toggleField(formSelector, '.scopus-q1', res.data.scopus_q1);
                            toggleField(formSelector, '.scopus-q2', res.data.scopus_q2);
                            toggleField(formSelector, '.scopus-q3', res.data.scopus_q3);
                            toggleField(formSelector, '.scopus-q4', res.data.scopus_q4);

                            // HEC
                            toggleField(formSelector, '.hec-w', res.data.hec_w);
                            toggleField(formSelector, '.hec-x', res.data.hec_x);
                            toggleField(formSelector, '.hec-y', res.data.hec_y);

                            // MEDICAL
                            toggleField(formSelector, '.medical-recognized', res.data.medical_recognized);
                        },
                        error: function () {
                            clearTargetFields(formSelector);
                            alert('Failed to fetch target data.');
                        }
                    });
                }

                // Show/hide field scoped to form
                function toggleField(formSelector, inputClass, value) {
                    let group = $(formSelector).find(inputClass).closest('.input-group');
                    if (value !== null && value !== '') {
                        group.show();
                        $(formSelector).find(inputClass).val(value);

                    } else {
                        group.hide();
                        $(formSelector).find(inputClass).val('');
                        $(formSelector).find(inputClass + '-1').val('').hide(); // targets .scopus-q-1

                    }
                }

                // Clear fields scoped to form
                function clearTargetFields(formSelector) {
                    $(formSelector).find('.input-group').hide();
                    $(formSelector).find('.input-group input').val('');
                }

                // Usage example for multiple forms
                fetchTarget('#researchForm1', {{ $indicatorId }});




                let grantIndex = 1; // start from 1 because 0 is initial block
                var countries = @json(getAllCountries());
                var universities = @json(getUniveristyJson());

                // Add new grant group
                $('#add-grant').click(function () {
                    let options = '<option value="">Select Country</option>';
                    let optionsUni = '<option value="">Select Univeristy</option>';

                    // Build options
                    countries.forEach(function (con) {
                        options += `<option value="${con['code']}">
                                        ${con['name']}
                                    </option>`;
                    });
                    universities.forEach(function (uni) {
                        optionsUni += `<option value="${uni['University Name']}">
                                        ${uni['University Name']}
                                    </option>`;
                    });


                    let newGroup = `
                    <div class="row g-6 grant-group mt-4">
                        <hr>
                        <div class="col-md-6">
                            <label class="form-label">Co-Author Name</label>
                            <input type="text" name="co_author[${grantIndex}][name]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rank</label>
                            <input type="number" name="co_author[${grantIndex}][rank]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">University Name</label>
                            <select name="co_author[${grantIndex}][univeristy_name]" class="univeristy-dropdown select2 form-select">
                                    ${optionsUni}
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <select name="co_author[${grantIndex}][country]" class="country-dropdown select2 form-select">
                                    ${options}
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Co-Author Role</label>
                            <div>
                                <input type="radio" name="co_author[${grantIndex}][your_role]" id="student_${grantIndex}" value="Student" checked>
                                <label for="student_${grantIndex}">Student</label>

                                <input type="radio" name="co_author[${grantIndex}][your_role]" id="researcher_${grantIndex}" value="Researcher">
                                <label for="other_${grantIndex}">Researcher</label>

                                <input type="radio" name="co_author[${grantIndex}][your_role]" id="professional_${grantIndex}" value="Professional">
                                <label for="other_${grantIndex}">Professional</label>
                            </div>
                        </div>
                        <div class="col-md-6" style="display:none">
                            <label class="form-label">Designation</label>
                            <input type="text" name="co_author[${grantIndex}][designation]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Student Roll Number</label>
                            <input type="text" name="co_author[${grantIndex}][student_roll_no]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Of Papers Co-Authored with this person in the past.</label>
                            <input type="number" name="co_author[${grantIndex}][no_paper_past]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Co-Author Email</label>
                            <input type="email" name="co_author[${grantIndex}][co_author_email]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Is the student first Co-author?</label>
                            <div>
                                <input type="radio" name="co_author[${grantIndex}][is_the_student_fitst_coauthor]" id="is_the_student_fitst_coauthor_yes_${grantIndex}" value="YES">
                                <label for="is_the_student_fitst_coauthor_yes_${grantIndex}">Yes</label>

                                <input type="radio" name="co_author[${grantIndex}][is_the_student_fitst_coauthor]" id="is_the_student_fitst_coauthor_no_${grantIndex}" value="NO" checked>
                                <label for="is_the_student_fitst_coauthor_no_${grantIndex}">No</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Career</label>
                            <select name="co_author[${grantIndex}][career]" class="form-select">
                                <option value="">Select Career</option>
                                <option value="PG">PG</option>
                                <option value="MS">MS</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <button type="button" class="btn btn-danger remove-grant">Remove</button>
                        </div>
                    </div>
                    `;

                    $('#grant-details-container').append(newGroup);
                    $('#grant-details-container').find('select.country-dropdown').last().select2({
                        width: '100%'
                    });
                    $('#grant-details-container').find('select.univeristy-dropdown').last().select2({
                        width: '100%'
                    });
                    grantIndex++;
                });

                // Remove a grant group
                $(document).on('click', '.remove-grant', function () {
                    $(this).closest('.grant-group').remove();
                });



                $('#researchForm1').on('submit', function (e) {
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
                        url: "{{ route('indicator-form.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });


                            // Fields to keep
                            let keepFields = ['scopus_q1', 'scopus_q2', 'scopus_q3', 'scopus_q4', 'hec_w', 'hec_x', 'hec_y', 'medical_recognized'];

                            // Store current values of fields to keep
                            let keepValues = {};
                            keepFields.forEach(function (name) {
                                keepValues[name] = form.find(`[name="${name}"]`).val();
                            });

                            // Reset the entire form
                            form[0].reset();
                            $('.country-dropdown').val(null).trigger('change');
                            $('.univeristy-dropdown').val(null).trigger('change');

                            // Restore the kept values
                            keepFields.forEach(function (name) {
                                form.find(`[name="${name}"]`).val(keepValues[name]);
                            });
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');

                            $('#grant-details-container .grant-group:not(:first)').remove();

                            // Reset the proof container of the first group
                            $('#grant-details-container .grant-group:first .proof-container').hide();

                            // Reset index to 1
                            grantIndex = 1;
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
                                    let fieldName;

                                    // Check if field contains a dot (dynamic field)
                                    if (field.indexOf('.') !== -1) {
                                        // Convert Laravel dot notation to input name format
                                        fieldName = field.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']';
                                        fieldName = fieldName.replace('[]]', ']'); // fix extra brackets
                                    } else {
                                        // Static field
                                        fieldName = field;
                                    }

                                    // Find input by name
                                    let input = form.find('[name="' + fieldName + '"]');

                                    if (input.length) {
                                        input.addClass('is-invalid');

                                        // Remove old error if exists
                                        input.next('.invalid-feedback').remove();

                                        // Show error message under input
                                        input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                    }
                                });

                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                            }
                        }
                    });
                });
            });
        </script>
    @endif
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            function fetchHodTarget() {
                $.ajax({
                    url: "{{ route('faculty-target.index') }}",
                    method: "GET",
                    data: {
                        status: "HOD",
                        indicator: {{ $indicatorId }}
                                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.user ? form.user.name : 'N/A',
                                form.indicator ? form.indicator.indicator : 'N/A',
                                form.target || 'N/A',
                                form.scopus_q1 || 'N/A',
                                form.scopus_q2 || 'N/A',
                                form.scopus_q3 || 'N/A',
                                form.scopus_q4 || 'N/A',
                                form.hec_w || 'N/A',
                                form.hec_x || 'N/A',
                                form.hec_y || 'N/A',
                                form.medical_recognized || 'N/A',
                                form.national || 'N/A',
                                form.international || 'N/A'
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#geTtargetTable')) {
                            $('#geTtargetTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "User" },
                                    { title: "Indicator" },
                                    { title: "Target" },
                                    { title: "Q1" },
                                    { title: "Q2" },
                                    { title: "Q3" },
                                    { title: "Q4" },
                                    { title: "W" },
                                    { title: "X" },
                                    { title: "Y" },
                                    { title: "Medical Recognized" },
                                    { title: "National" },
                                    { title: "International" }

                                ]
                            });
                        } else {
                            $('#geTtargetTable').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('indicator-form.index') }}",
                    method: "GET",
                    data: {
                        status: "HOD" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';

                            let statusText = 'N/A';
                            if (form.status == 1) statusText = 'Unverified';
                            else if (form.status == 2) statusText = 'Verified';

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.target_category || 'N/A',
                                form.journal_clasification || 'N/A',
                                `<span class="badge bg-label-primary">${statusText}</span>`,
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Indicator Category" },
                                    { title: "Classification" },
                                    { title: "Status" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#complaintTable3').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
            // ✅ Reusable function for single update
            function updateSingleStatus(id, status) {
                $.ajax({
                    url: `/indicator-form/${id}`,           // single row endpoint
                    type: 'POST',                            // POST with _method PUT
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: res.message || 'Status updated successfully!'
                        });

                        fetchIndicatorForms3();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong!'
                        });
                    }
                });
            }
            $(document).ready(function () {
                function updateTotal() {
                    let ids = [
                        '#scopus-q1', '#scopus-q2', '#scopus-q3', '#scopus-q4',
                        '#hec-w', '#hec-x', '#hec-y',
                        '#medical-recognized'
                    ];

                    let total = 0;
                    ids.forEach(id => {
                        total += Number($(id).val()) || 0;
                    });

                    $('.total-target').text('Total ' + total);
                    $('input[name="target"]').val(total);
                }

                // Trigger on input change
                $('#scopus-q1, #scopus-q2, #scopus-q3, #scopus-q4, #hec-w, #hec-x, #hec-y, #medical-recognized')
                    .on('input', updateTotal);
                fetchIndicatorForms3();
                fetchHodTarget();
                // Extra fields for Form 2
                $('#faculty_member').on('change', function () {
                    let selected = $(this).find(':selected');
                    let department = selected.data('department');
                    let job_title = selected.data('job_title');

                    $('#department').val(department ?? '');
                    $('#job_title').val(job_title ?? '');
                });
                $('#researchForm2').on('submit', function (e) {
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
                        url: "{{ route('faculty-target.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
                            $('#select2Success').val(null).trigger('change');
                            fetchHodTarget();
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

                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                            }
                        }
                    });
                });
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalExtraFieldsHistory').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalTargetCategory').text(form.target_category || 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.currentUserRole === 'HOD') {
                        $('#approveCheckbox').prop('checked', form.status == 2);
                        $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                        // Label text for HOD
                        let statusLabel = "Pending";
                        if (form.status == 1) {
                            statusLabel = "Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        }
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    } else {
                        $('#approveCheckbox').closest('.form-check-input').hide();

                        let statusLabel = "Pending"; // default
                        if (form.status == 1) {
                            statusLabel = "Not Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Approved";
                        }

                        // update the label text
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    }





                    if (form.link_of_publications) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Publications Link</th><td><a href="${form.link_of_publications}" target="_blank">${form.link_of_publications}</a></td></tr>`);
                    }
                    if (form.rank) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Rank</th><td>${form.rank}</td></tr>`);
                    }
                    if (form.nationality) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Nationality</th><td>${form.nationality}</td></tr>`);
                    }
                    if (form.scopus_q1) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q1</th><td>${form.scopus_q1}</td></tr>`);
                    }
                    if (form.scopus_q2) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q2</th><td>${form.scopus_q2}</td></tr>`);
                    }
                    if (form.scopus_q3) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q3</th><td>${form.scopus_q3}</td></tr>`);
                    }
                    if (form.scopus_q4) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q4</th><td>${form.scopus_q4}</td></tr>`);
                    }
                    if (form.hec_w) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>W</th><td>${form.hec_w}</td></tr>`);
                    }
                    if (form.hec_x) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>X</th><td>${form.hec_x}</td></tr>`);
                    }
                    if (form.hec_y) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Y</th><td>${form.hec_y}</td></tr>`);
                    }
                    if (form.medical_recognized) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Medical Recognized</th><td>${form.medical_recognized}</td></tr>`);
                    }
                    if (form.as_author_your_rank) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Your Rank (As Author)</th><td>${form.as_author_your_rank}</td></tr>`);
                    }
                    // ✅ append co Author dynamically
                    //alert(JSON.stringify(form));
                    if (form.co_authors && form.co_authors.length > 0) {

                        form.co_authors.forEach((coAuthor, index) => {
                            $('#modalExtraFields').append(`
                                                <tr class="optional-field">
                                                    <th>co Author ${index + 1}</th>
                                                    <td>
                                                        <strong>Name:</strong> ${coAuthor.name || 'N/A'}<br>
                                                        <strong>Rank:</strong> ${coAuthor.rank || 'N/A'}<br>
                                                        <strong>Univeristy Name:</strong> ${coAuthor.univeristy_name || 'N/A'}<br>
                                                        <strong>country:</strong> ${coAuthor.country || 'N/A'}<br>
                                                        <strong>No Paper Past:</strong> ${coAuthor.no_paper_past || 'N/A'}<br>
                                                        ${coAuthor.student_roll_no ? `<strong>student:</strong> ${coAuthor.student_roll_no}<br>` : ''}
                                                        ${coAuthor.career ? `<strong>Career:</strong> ${coAuthor.career}<br>` : ''}
                                                        ${coAuthor.designation ? `<strong>Designation:</strong> ${coAuthor.designation}<br>` : ''}
                                                    </td>
                                                </tr>
                                            `);
                        });
                    } else {
                        $('#modalExtraFields').append(`
                                            <tr class="optional-field">
                                                <th>co Author</th>
                                                <td>No co Author available</td>
                                            </tr>
                                        `);
                    }
                    if (form.update_history) {
                        // Parse JSON string if it's a string
                        let history = typeof form.update_history === 'string' ? JSON.parse(form.update_history) : form.update_history;

                        if (history.length > 0) {

                            let historyHtml = '';

                            history.forEach(update => {
                                let histortText = 'N/A';

                                // Role-based status mapping
                                if (update.role === 'HOD') {
                                    if (update.status == '1') histortText = 'Unverified';
                                    else if (update.status == '2') histortText = 'Verified';
                                } else if (update.role === 'ORIC') {
                                    if (update.status == '2') histortText = 'Unverified';
                                    else if (update.status == '3') histortText = 'Verified';
                                } else {
                                    histortText = update.status; // fallback
                                }
                                historyHtml += `
                                                        <li class="timeline-item timeline-item-transparent optional-field">
                                                            <span class="timeline-point timeline-point-primary"></span>
                                                            <div class="timeline-event">
                                                                <div class="timeline-header mb-3">
                                                                    <h6 class="mb-0">${update.user_name}</h6><small class="text-body-secondary">${new Date(update.updated_at).toLocaleString()}</small>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-1">
                                                                    <div class="badge bg-lighter rounded-3">
                                                                     <span class="h6 mb-0 text-body">${update.role || 'N/A'}</span>
                                                                    </div>
                                                                    <div class="badge bg-lighter rounded-3 ms-2">
                                                                     <span class="h6 mb-0 text-body">${histortText}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    `;
                            });

                            $('#modalExtraFieldsHistory').append(historyHtml);
                        }
                    }
                    else {
                        $('#modalExtraFieldsHistory').append(`
                                                <li class="optional-field">
                                                    <th>No History Avalable</th>
                                                </li>
                                            `);
                    }
                    $('#viewFormModal').modal('show');
                });

                // ✅ Single checkbox status change
                $(document).on('change', '#approveCheckbox', function () {
                    const id = $(this).data('id');
                    const status = $(this).is(':checked') ? 2 : 1;
                    updateSingleStatus(id, status);
                });

                // ✅ Bulk submit button
                $('#bulkSubmit').on('click', function () {
                    const status = $('#bulkAction').val();
                    let selectedIds = [];

                    $('#complaintTable3 .rowCheckbox:checked').each(function () {
                        selectedIds.push($(this).val());
                    });

                    if (!status) {
                        Swal.fire({ icon: 'warning', title: 'Select Action', text: 'Please select a status to update.' });
                        return;
                    }
                    if (!selectedIds.length) {
                        Swal.fire({ icon: 'warning', title: 'No Selection', text: 'Please select at least one row.' });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to change status for ${selectedIds.length} item(s).`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedIds.forEach(id => updateSingleStatus(id, status));
                        }
                    });
                });

                // ✅ Select / Deselect all checkboxes
                $(document).on('change', '#selectAll', function () {
                    $('.rowCheckbox').prop('checked', $(this).is(':checked'));
                });

            });
        </script>
    @endif
    @if(auth()->user()->hasRole(['Dean']))
        <script>

            function fetchIndicatorForms1() {
                $.ajax({
                    url: "{{ route('indicator-form.index') }}",
                    method: "GET",
                    data: {
                        status: "RESEARCHER" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.target_category || 'N/A',
                                form.journal_clasification || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable1')) {
                            $('#complaintTable1').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Indicator Category" },
                                    { title: "Classification" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#complaintTable1').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }

            $(document).ready(function () {
                fetchIndicatorForms1();

                // Handle click on View button
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalExtraFieldsHistory').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalTargetCategory').text(form.target_category || 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.currentUserRole === 'Dean') {
                        $('#status-approval').hide();
                        $('label[for="approveCheckbox"]').hide();
                        $('#approveCheckbox').closest('.form-check-input').hide();
                    } else {

                    }


                    if (form.link_of_publications) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Publications Link</th><td><a href="${form.link_of_publications}" target="_blank">${form.link_of_publications}</a></td></tr>`);
                    }
                    if (form.rank) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Rank</th><td>${form.rank}</td></tr>`);
                    }
                    if (form.nationality) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Nationality</th><td>${form.nationality}</td></tr>`);
                    }
                    if (form.scopus_q1) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q1</th><td>${form.scopus_q1}</td></tr>`);
                    }
                    if (form.scopus_q2) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q2</th><td>${form.scopus_q2}</td></tr>`);
                    }
                    if (form.scopus_q3) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q3</th><td>${form.scopus_q3}</td></tr>`);
                    }
                    if (form.scopus_q4) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q4</th><td>${form.scopus_q4}</td></tr>`);
                    }
                    if (form.hec_w) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>W</th><td>${form.hec_w}</td></tr>`);
                    }
                    if (form.hec_x) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>X</th><td>${form.hec_x}</td></tr>`);
                    }
                    if (form.hec_y) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Y</th><td>${form.hec_y}</td></tr>`);
                    }
                    if (form.medical_recognized) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Medical Recognized</th><td>${form.medical_recognized}</td></tr>`);
                    }
                    if (form.as_author_your_rank) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Your Rank (As Author)</th><td>${form.as_author_your_rank}</td></tr>`);
                    }
                    // ✅ append co Author dynamically
                    //alert(JSON.stringify(form));
                    if (form.co_authors && form.co_authors.length > 0) {

                        form.co_authors.forEach((coAuthor, index) => {
                            $('#modalExtraFields').append(`
                                                <tr class="optional-field">
                                                    <th>co Author ${index + 1}</th>
                                                    <td>
                                                        <strong>Name:</strong> ${coAuthor.name || 'N/A'}<br>
                                                        <strong>Rank:</strong> ${coAuthor.rank || 'N/A'}<br>
                                                        <strong>Univeristy Name:</strong> ${coAuthor.univeristy_name || 'N/A'}<br>
                                                        <strong>country:</strong> ${coAuthor.country || 'N/A'}<br>
                                                        <strong>No Paper Past:</strong> ${coAuthor.no_paper_past || 'N/A'}<br>
                                                        ${coAuthor.student_roll_no ? `<strong>student:</strong> ${coAuthor.student_roll_no}<br>` : ''}
                                                        ${coAuthor.career ? `<strong>Career:</strong> ${coAuthor.career}<br>` : ''}
                                                        ${coAuthor.designation ? `<strong>Designation:</strong> ${coAuthor.designation}<br>` : ''}
                                                    </td>
                                                </tr>
                                            `);
                        });
                    } else {
                        $('#modalExtraFields').append(`
                                            <tr class="optional-field">
                                                <th>co Author</th>
                                                <td>No co Author available</td>
                                            </tr>
                                        `);
                    }
                    if (form.update_history) {
                        // Parse JSON string if it's a string
                        let history = typeof form.update_history === 'string' ? JSON.parse(form.update_history) : form.update_history;

                        if (history.length > 0) {

                            let historyHtml = '';

                            history.forEach(update => {
                                let histortText = 'N/A';

                                // Role-based status mapping
                                if (update.role === 'HOD') {
                                    if (update.status == '1') histortText = 'Unverified';
                                    else if (update.status == '2') histortText = 'Verified';
                                } else if (update.role === 'ORIC') {
                                    if (update.status == '2') histortText = 'Unverified';
                                    else if (update.status == '3') histortText = 'Verified';
                                } else {
                                    histortText = update.status; // fallback
                                }
                                historyHtml += `
                                                        <li class="timeline-item timeline-item-transparent optional-field">
                                                            <span class="timeline-point timeline-point-primary"></span>
                                                            <div class="timeline-event">
                                                                <div class="timeline-header mb-3">
                                                                    <h6 class="mb-0">${update.user_name}</h6><small class="text-body-secondary">${new Date(update.updated_at).toLocaleString()}</small>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-1">
                                                                    <div class="badge bg-lighter rounded-3">
                                                                     <span class="h6 mb-0 text-body">${update.role || 'N/A'}</span>
                                                                    </div>
                                                                    <div class="badge bg-lighter rounded-3 ms-2">
                                                                     <span class="h6 mb-0 text-body">${histortText}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    `;
                            });

                            $('#modalExtraFieldsHistory').append(historyHtml);
                        }
                    }
                    else {
                        $('#modalExtraFieldsHistory').append(`
                                                <li class="optional-field">
                                                    <th>No History Avalable</th>
                                                </li>
                                            `);
                    }


                    $('#viewFormModal').modal('show');
                });





            });
        </script>
    @endif
    @if(auth()->user()->hasRole(['ORIC']))
        <script>
            function fetchIndicatorForms3() {
                $.ajax({
                    url: "{{ route('indicator-form.index') }}",
                    method: "GET",
                    data: {
                        status: "RESEARCHER" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';
                            let statusText = 'N/A';
                            if (form.status == 2) statusText = 'Unapprove';
                            else if (form.status == 3) statusText = 'Approve';

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.target_category || 'N/A',
                                form.journal_clasification || 'N/A',
                                `<span class="badge bg-label-primary">${statusText}</span>`,
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "<input type='checkbox' id='selectAll'>" },
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Indicator Category" },
                                    { title: "Classification" },
                                    { title: "Status" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#complaintTable3').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
            // ✅ Reusable function for single update
            function updateSingleStatus(id, status) {
                $.ajax({
                    url: `/indicator-form/${id}`,           // single row endpoint
                    type: 'POST',                            // POST with _method PUT
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: res.message || 'Status updated successfully!'
                        });

                        fetchIndicatorForms3();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong!'
                        });
                    }
                });
            }
            $(document).ready(function () {
                fetchIndicatorForms3();
                $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalExtraFieldsHistory').find('.optional-field').remove();

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalTargetCategory').text(form.target_category || 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                    if (window.currentUserRole === 'ORIC') {
                        $('#approveCheckbox').prop('checked', form.status == 3);
                        $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                        // Label text for Dean
                        let statusLabel = "Pending";
                        if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Verified";
                        }
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    } else {
                        $('#approveCheckbox').closest('.form-check-input').hide();

                        let statusLabel = "Pending"; // default
                        if (form.status == 1) {
                            statusLabel = "Not Verified";
                        } else if (form.status == 2) {
                            statusLabel = "Verified";
                        } else if (form.status == 3) {
                            statusLabel = "Approved";
                        }

                        // update the label text
                        $('label[for="approveCheckbox"]').text(statusLabel);
                    }


                    if (form.link_of_publications) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Publications Link</th><td><a href="${form.link_of_publications}" target="_blank">${form.link_of_publications}</a></td></tr>`);
                    }
                    if (form.rank) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Rank</th><td>${form.rank}</td></tr>`);
                    }
                    if (form.nationality) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Nationality</th><td>${form.nationality}</td></tr>`);
                    }
                    if (form.scopus_q1) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q1</th><td>${form.scopus_q1}</td></tr>`);
                    }
                    if (form.scopus_q2) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q2</th><td>${form.scopus_q2}</td></tr>`);
                    }
                    if (form.scopus_q3) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q3</th><td>${form.scopus_q3}</td></tr>`);
                    }
                    if (form.scopus_q4) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Q4</th><td>${form.scopus_q4}</td></tr>`);
                    }
                    if (form.hec_w) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>W</th><td>${form.hec_w}</td></tr>`);
                    }
                    if (form.hec_x) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>X</th><td>${form.hec_x}</td></tr>`);
                    }
                    if (form.hec_y) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Y</th><td>${form.hec_y}</td></tr>`);
                    }
                    if (form.medical_recognized) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Medical Recognized</th><td>${form.medical_recognized}</td></tr>`);
                    }
                    if (form.as_author_your_rank) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Your Rank (As Author)</th><td>${form.as_author_your_rank}</td></tr>`);
                    }
                    // ✅ append co Author dynamically
                    //alert(JSON.stringify(form));
                    if (form.co_authors && form.co_authors.length > 0) {

                        form.co_authors.forEach((coAuthor, index) => {
                            $('#modalExtraFields').append(`
                                                    <tr class="optional-field">
                                                        <th>co Author ${index + 1}</th>
                                                        <td>
                                                            <strong>Name:</strong> ${coAuthor.name || 'N/A'}<br>
                                                            <strong>Rank:</strong> ${coAuthor.rank || 'N/A'}<br>
                                                            <strong>Univeristy Name:</strong> ${coAuthor.univeristy_name || 'N/A'}<br>
                                                            <strong>country:</strong> ${coAuthor.country || 'N/A'}<br>
                                                            <strong>No Paper Past:</strong> ${coAuthor.no_paper_past || 'N/A'}<br>
                                                            ${coAuthor.student_roll_no ? `<strong>student:</strong> ${coAuthor.student_roll_no}<br>` : ''}
                                                            ${coAuthor.career ? `<strong>Career:</strong> ${coAuthor.career}<br>` : ''}
                                                            ${coAuthor.designation ? `<strong>Designation:</strong> ${coAuthor.designation}<br>` : ''}
                                                        </td>
                                                    </tr>
                                                `);
                        });
                    } else {
                        $('#modalExtraFields').append(`
                                                <tr class="optional-field">
                                                    <th>co Author</th>
                                                    <td>No co Author available</td>
                                                </tr>
                                            `);
                    }

                    if (form.update_history) {
                        // Parse JSON string if it's a string
                        let history = typeof form.update_history === 'string' ? JSON.parse(form.update_history) : form.update_history;

                        if (history.length > 0) {

                            let historyHtml = '';

                            history.forEach(update => {
                                let histortText = 'N/A';

                                // Role-based status mapping
                                if (update.role === 'HOD') {
                                    if (update.status == '1') histortText = 'Unverified';
                                    else if (update.status == '2') histortText = 'Verified';
                                } else if (update.role === 'ORIC') {
                                    if (update.status == '2') histortText = 'Unverified';
                                    else if (update.status == '3') histortText = 'Verified';
                                } else {
                                    histortText = update.status; // fallback
                                }
                                historyHtml += `
                                                        <li class="timeline-item timeline-item-transparent optional-field">
                                                            <span class="timeline-point timeline-point-primary"></span>
                                                            <div class="timeline-event">
                                                                <div class="timeline-header mb-3">
                                                                    <h6 class="mb-0">${update.user_name}</h6><small class="text-body-secondary">${new Date(update.updated_at).toLocaleString()}</small>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-1">
                                                                    <div class="badge bg-lighter rounded-3">
                                                                     <span class="h6 mb-0 text-body">${update.role || 'N/A'}</span>
                                                                    </div>
                                                                    <div class="badge bg-lighter rounded-3 ms-2">
                                                                     <span class="h6 mb-0 text-body">${histortText}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    `;
                            });

                            $('#modalExtraFieldsHistory').append(historyHtml);
                        }
                    }
                    else {
                        $('#modalExtraFieldsHistory').append(`
                                                <li class="optional-field">
                                                    <th>No History Avalable</th>
                                                </li>
                                            `);
                    }



                    $('#viewFormModal').modal('show');
                });



                // ✅ Single checkbox status change
                $(document).on('change', '#approveCheckbox', function () {
                    const id = $(this).data('id');
                    const status = $(this).is(':checked') ? 3 : 2;
                    updateSingleStatus(id, status);
                });

                // ✅ Bulk submit button
                $('#bulkSubmit').on('click', function () {
                    const status = $('#bulkAction').val();
                    let selectedIds = [];

                    $('#complaintTable3 .rowCheckbox:checked').each(function () {
                        selectedIds.push($(this).val());
                    });

                    if (!status) {
                        Swal.fire({ icon: 'warning', title: 'Select Action', text: 'Please select a status to update.' });
                        return;
                    }
                    if (!selectedIds.length) {
                        Swal.fire({ icon: 'warning', title: 'No Selection', text: 'Please select at least one row.' });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to change status for ${selectedIds.length} item(s).`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedIds.forEach(id => updateSingleStatus(id, status));
                        }
                    });
                });

                // ✅ Select / Deselect all checkboxes
                $(document).on('change', '#selectAll', function () {
                    $('.rowCheckbox').prop('checked', $(this).is(':checked'));
                });
            });
        </script>
    @endif

@endpush
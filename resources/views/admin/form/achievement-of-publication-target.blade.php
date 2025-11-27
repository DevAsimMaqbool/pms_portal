@extends('layouts.app')

@push('style')
    {{-- Vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="nav-align-top">
            @if(auth()->user()->hasRole(['Dean']))
            <!-- Nav tabs -->
            <ul class="nav nav-pills mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">% Achievement of Publication</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Research Target Setting</a>
                </li>
            </ul>
            @endif
            @if(auth()->user()->hasRole(['HOD']))
            <!-- Nav tabs -->
            <ul class="nav nav-pills mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">% Achievement of Publication</a>
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
                @if(auth()->user()->hasRole(['Teacher','HOD']))
                <div class="tab-pane fade show active" id="form1" role="tabpanel">
                    <form id="researchForm1" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                        <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER" required>
                        <div class="row g-6 mt-0">
                            <div class="col-12 col-lg-8">
                                   <div class="card shadow-none bg-transparent border border-primary">
                                        <div class="card-body">
                                            <div class="row g-6">
                                                <div class="col-md-6">
                                                    <label class="form-label">Target Category</label>
                                                    <select name="target_category" class="form-select" >
                                                        <option value="">Select Target Category</option>
                                                        <option value="Scopus-Indexed">Scopus Indexed</option>
                                                        <option value="HEC">HEC</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Link Of Publications</label>
                                                    <input type="url" name="link_of_publications" class="form-control" >
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Rank</label>
                                                    <input type="number" name="rank" class="form-control" >
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Nationality</label>
                                                    <input type="text" name="nationality" class="form-control" >
                                                </div>
                                                
                                               
                                            </div>
                                        </div>
                                    </div>


                                     <div class="card shadow-none bg-transparent border border-primary mt-6">
                                        <div class="card-body">
                                            <div class="row g-6">
                        
                                                <div class="col-md-6">
                                                    <label class="form-label">As Author Your Rank</label>
                                                    <input type="number" name="as_author_your_rank" class="form-control" >
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
                                                        <input type="text" name="co_author[0][name]" class="form-control" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Rank</label>
                                                        <input type="number" name="co_author[0][rank]" class="form-control" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">University Name</label>
                                                        <input type="text" name="co_author[0][univeristy_name]" class="form-control" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Country</label>
                                                        <input type="text" name="co_author[0][country]" class="form-control" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Designation</label>
                                                        <input type="text" name="co_author[0][designation]" class="form-control" >
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">No Of Papers Co-Authored with this person in the past.</label>
                                                        <input type="number" name="co_author[0][no_paper_past]" class="form-control" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label d-block">Does first author your superviser?</label>
                                                        <div>
                                                            <input type="radio" name="co_author[0][first_author_superviser]" id="first_author_superviser_yes_0" value="YES">
                                                            <label for="first_author_superviser_yes_0">Yes</label>

                                                            <input type="radio" name="co_author[0][first_author_superviser]" id="first_author_superviser_no_0" value="NO" checked>
                                                            <label for="first_author_superviser_no_0">No</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Student Roll Number</label>
                                                        <input type="text" name="co_author[0][student_roll_no]" class="form-control" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Career</label>
                                                        <input type="text" name="co_author[0][career]" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-body-secondary bg-label-secondary">
                                            <button type="button" class="btn btn-primary waves-effect waves-light mt-6" id="add-grant">
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
                                        <!-- Base Price -->
                                        <div class="mb-6">
                                        <label class="form-label" for="ecommerce-product-discount-price">Scopus</label>
                                            <div class="input-group mb-4">
                                                <span class="input-group-text">Q1</span>
                                                <input type="number" class="form-control scopus-q1" name="scopus_q1">
                                            </div>
                                            <div class="input-group mb-4">
                                                <span class="input-group-text">Q2</span>
                                                <input type="number" class="form-control scopus-q2" name="scopus_q2">
                                            </div>
                                            <div class="input-group mb-4">
                                                <span class="input-group-text">Q3</span>
                                                <input type="number" class="form-control scopus-q3" name="scopus_q3">
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">Q4</span>
                                                <input type="number" class="form-control scopus-q4" name="scopus_q4">
                                            </div>
                                        </div>    
                                        <!-- Discounted Price -->
                                        <div class="mb-6">
                                        <label class="form-label" for="ecommerce-product-discount-price">HEC</label>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">W</span>
                                            <input type="number" class="form-control hec-w" name="hec_w">
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">X</span>
                                            <input type="number" class="form-control hec-x" name="hec_x">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Y</span>
                                            <input type="number" class="form-control hec-y" name="hec_y" >
                                        </div>
                                        </div>
                                        <!-- Charge tax check box -->
                                        <div class="mb-6">
                                              <label class="form-label"> Medical</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Recognized</span>
                                                    <input type="number" class="form-control medical-recognized" name="medical_recognized" >
                                                </div>
                                        </div>
                                        <!-- Instock switch -->
                                        
                                    </div>
                                    </div>
                            </div>
                        </div>            
                       
                        
                        <div class="col-4 mt-3">
                            <button class="btn btn-primary w-100">SUBMIT</button>
                        </div>
                    </form>
                </div>
                  @endif
                {{-- ================= FORM 2 ================= --}}
                @if(auth()->user()->hasRole(['HOD']))
                <div class="tab-pane fade" id="form2" role="tabpanel">
                     <form id="researchForm2" enctype="multipart/form-data"class="row">
                        @csrf
                        <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                        <input type="hidden"  id="form_status" name="form_status" value="HOD" required>

                        <div class="row">
                            <div class="col-md-6">
                            <label for="faculty_member" class="form-label">Name of Faculty Member</label>
                            <select  name="faculty_member_id[]" id="select2Success" class="select2 form-select"  multiple required>
                                <option value="">-- Select Faculty Member --</option>
                                @foreach($facultyMembers as $member)
                                    <option 
                                        value="{{ $member->id }}" 
                                        data-department="{{ $member->department }}" 
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
                                    <input type="number" class="form-control" name="medical_recognized" id="medical-recognized">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-outline-secondary waves-effect w-100 total-target">Tota 0</button>
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
                        <div class="col-4 text-center demo-vertical-spacing">
                            <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                        </div>
                    </form>
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
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                 </div>
                 @endif
                 @if(auth()->user()->hasRole(['Dean']))
                 <div class="tab-pane fade show active" id="form1" role="tabpanel">
                     <div class="d-flex">
                                    <select id="bulkAction" class="form-select w-auto me-2">
                                        <option value="">-- Select Action --</option>
                                        <option value="3">Verified</option>
                                        <option value="2">UnVerified</option>
                                    </select>
                                    <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                     </div>
                   <table id="complaintTable1" class="table table-bordered table-striped" style="width:100%">
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
                                        <option value="4">Verified</option>
                                        <option value="3">UnVerified</option>
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
                    <tr><th>Created By</th><td id="modalCreatedBy"></td></tr>
                    <tr><th>Target Category</th><td id="modalTargetCategory"></td></tr>
                    <tr><th>Status</th><td>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="approveCheckbox">
                        <label class="form-check-label" for="approveCheckbox">Approved</label>
                    </div></td></tr>
                    <tr><th>Created Date</th><td id="modalCreatedDate"></td></tr>
                    <tbody id="modalExtraFields"></tbody>
                </table>
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
    @if(auth()->user()->hasRole(['HOD','Teacher']))
    <script>
    $(document).ready(function () {
            

            

           function fetchTarget(formSelector, indicatorId) {
    if (!indicatorId) {
        clearTargetFields(formSelector);
        return;
    }

    $.ajax({
        url: "{{ route('faculty-target.getTarget') }}",
        type: "GET",
        data: { indicator_id: indicatorId },
        success: function(res) {
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
        error: function() {
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

            // Add new grant group
            $('#add-grant').click(function () {
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
                            <input type="text" name="co_author[${grantIndex}][univeristy_name]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input type="text" name="co_author[${grantIndex}][country]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Designation</label>
                            <input type="text" name="co_author[${grantIndex}][designation]" class="form-control" >
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">No Of Papers Co-Authored with this person in the past.</label>
                            <input type="number" name="co_author[${grantIndex}][no_paper_past]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Does first author your superviser?</label>
                            <div>
                                <input type="radio" name="co_author[${grantIndex}][first_author_superviser]" id="first_author_superviser_yes_${grantIndex}" value="YES">
                                <label for="first_author_superviser_yes_${grantIndex}">Yes</label>

                                <input type="radio" name="co_author[${grantIndex}][first_author_superviser]" id="first_author_superviser_no_${grantIndex}" value="NO" checked>
                                <label for="first_author_superviser_no_${grantIndex}">No</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Student Roll Number</label>
                            <input type="text" name="co_author[${grantIndex}][student_roll_no]" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Career</label>
                            <input type="text" name="co_author[${grantIndex}][career]" class="form-control" >
                        </div>
                        <div class="col-md-12 mt-2">
                            <button type="button" class="btn btn-danger remove-grant">Remove</button>
                        </div>
                    </div>
                `;

                $('#grant-details-container').append(newGroup);
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
                    form[0].reset();
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
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                }
            });
        });
    });
    </script>
    @endif
    @if(auth()->user()->hasRole(['HOD']))
    <script>
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

                // Pass entire form as JSON in button's data attribute
                return [
                    `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                    i + 1,
                    form.creator ? form.creator.name : 'N/A',
                    form.target_category || 'N/A',
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
                        { title: "Created Date" },
                        { title: "Actions" }
                    ]
                });
            } else {
                $('#complaintTable3').DataTable().clear().rows.add(rowData).draw();
            }
        },
        error: function(xhr) {
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
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                }
            });
        });
         $(document).on('click', '.view-form-btn', function() {
                const form = $(this).data('form');
                $('#modalExtraFields').find('.optional-field').remove();

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
                    $('#modalExtraFields').append(`<tr class="optional-field"><th>As Author Your Rank</th><td>${form.as_author_your_rank}</td></tr>`);
                }
                // ✅ append projects dynamically
                //alert(JSON.stringify(form));
                    if (form.co_authors  && form.co_authors.length > 0) {
             
                        form.co_authors.forEach((coAuthor, index) => {
                            $('#modalExtraFields').append(`
                                <tr class="optional-field">
                                    <th>Project ${index + 1}</th>
                                    <td>
                                        <strong>Name:</strong> ${coAuthor.name || 'N/A'}<br>
                                        <strong>Rank:</strong> ${coAuthor.rank || 'N/A'}<br>
                                        <strong>Univeristy Name:</strong> ${coAuthor.univeristy_name || 'N/A'}<br>
                                        <strong>country:</strong> ${coAuthor.country || 'N/A'}<br>
                                        <strong>Designation:</strong> ${coAuthor.designation || 'N/A'}<br>
                                        <strong>No Paper Past:</strong> ${coAuthor.no_paper_past || 'N/A'}
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#modalExtraFields').append(`
                            <tr class="optional-field">
                                <th>Projects</th>
                                <td>No projects available</td>
                            </tr>
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
                    `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                    i + 1,
                    form.creator ? form.creator.name : 'N/A',
                    form.target_category || 'N/A',
                    createdAt,
                    `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
                ];
            });

            if (!$.fn.DataTable.isDataTable('#complaintTable1')) {
                $('#complaintTable1').DataTable({
                    data: rowData,
                    columns: [
                        { title: "<input type='checkbox' id='selectAll'>" },
                        { title: "#" },
                        { title: "Created By" },
                        { title: "Indicator Category" },
                        { title: "Created Date" },
                        { title: "Actions" }
                    ]
                });
            } else {
                $('#complaintTable1').DataTable().clear().rows.add(rowData).draw();
            }
        },
        error: function(xhr) {
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
                        
                        fetchIndicatorForms1();
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
          fetchIndicatorForms1();
      
       // Handle click on View button
    $(document).on('click', '.view-form-btn', function() {
        const form = $(this).data('form');
        $('#modalExtraFields').find('.optional-field').remove();

        $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
        $('#modalTargetCategory').text(form.target_category || 'N/A');
        $('#modalStatus').text(form.status || 'Pending');
        $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
        if (window.currentUserRole === 'Dean') {
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
                    }else {
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
                    $('#modalExtraFields').append(`<tr class="optional-field"><th>As Author Your Rank</th><td>${form.as_author_your_rank}</td></tr>`);
                }
                // ✅ append projects dynamically
                //alert(JSON.stringify(form));
                    if (form.co_authors  && form.co_authors.length > 0) {
             
                        form.co_authors.forEach((coAuthor, index) => {
                            $('#modalExtraFields').append(`
                                <tr class="optional-field">
                                    <th>Project ${index + 1}</th>
                                    <td>
                                        <strong>Name:</strong> ${coAuthor.name || 'N/A'}<br>
                                        <strong>Rank:</strong> ${coAuthor.rank || 'N/A'}<br>
                                        <strong>Univeristy Name:</strong> ${coAuthor.univeristy_name || 'N/A'}<br>
                                        <strong>country:</strong> ${coAuthor.country || 'N/A'}<br>
                                        <strong>Designation:</strong> ${coAuthor.designation || 'N/A'}<br>
                                        <strong>No Paper Past:</strong> ${coAuthor.no_paper_past || 'N/A'}
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#modalExtraFields').append(`
                            <tr class="optional-field">
                                <th>Projects</th>
                                <td>No projects available</td>
                            </tr>
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

                    $('#complaintTable1 .rowCheckbox:checked').each(function () {
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

                            // Pass entire form as JSON in button's data attribute
                            return [
                                `<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.target_category || 'N/A',
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

                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
            $('#modalTargetCategory').text(form.target_category || 'N/A');
            $('#modalStatus').text(form.status || 'Pending');
            $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
            if (window.currentUserRole === 'ORIC') {
                            $('#approveCheckbox').prop('checked', form.status == 4);
                            $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                            // Label text for Dean
                            let statusLabel = "Pending";
                            if (form.status == 3) {
                                statusLabel = "Verified";
                            } else if (form.status == 4) {
                                statusLabel = "Verified";
                            }
                            $('label[for="approveCheckbox"]').text(statusLabel);
                        }else {
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
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>As Author Your Rank</th><td>${form.as_author_your_rank}</td></tr>`);
                    }
                    // ✅ append projects dynamically
                    //alert(JSON.stringify(form));
                        if (form.co_authors  && form.co_authors.length > 0) {
                
                            form.co_authors.forEach((coAuthor, index) => {
                                $('#modalExtraFields').append(`
                                    <tr class="optional-field">
                                        <th>Project ${index + 1}</th>
                                        <td>
                                            <strong>Name:</strong> ${coAuthor.name || 'N/A'}<br>
                                            <strong>Rank:</strong> ${coAuthor.rank || 'N/A'}<br>
                                            <strong>Univeristy Name:</strong> ${coAuthor.univeristy_name || 'N/A'}<br>
                                            <strong>country:</strong> ${coAuthor.country || 'N/A'}<br>
                                            <strong>Designation:</strong> ${coAuthor.designation || 'N/A'}<br>
                                            <strong>No Paper Past:</strong> ${coAuthor.no_paper_past || 'N/A'}
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            $('#modalExtraFields').append(`
                                <tr class="optional-field">
                                    <th>Projects</th>
                                    <td>No projects available</td>
                                </tr>
                            `);
                        }

                    $('#viewFormModal').modal('show');
                });



                 // ✅ Single checkbox status change
                $(document).on('change', '#approveCheckbox', function () {
                    const id = $(this).data('id');
                    const status = $(this).is(':checked') ? 4 : 3;
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
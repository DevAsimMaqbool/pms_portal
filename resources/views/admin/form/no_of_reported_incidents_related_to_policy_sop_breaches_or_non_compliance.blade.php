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
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
               
                @if(auth()->user()->hasRole(['HOD']))
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab"># of reported incidents related to policy/SOPs breaches or non-compliance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#form3" role="tab">Table</a>
                    </li>
                </ul>
                @endif

                <!-- Tab panes -->
                <div class="tab-content">
                    {{-- ================= FORM 1 ================= --}}
                    @if(auth()->user()->hasRole(['HOD']))
                    
                    <div class="tab-pane fade show active" id="form1" role="tabpanel">
                    <div class="d-flex justify-content-between">
                               <div>
                                <h5 class="mb-1"># of reported incidents related to policy/SOPs breaches or non-compliance</h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'no_of_reported_incidents_related_to_policy_sop_breaches_or_non_compliance', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div>
                          <form id="researchForm1" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden"  id="form_status" name="form_status" value="HOD" required>
                                
                                <div class="row g-3 mt-0">
                                    

                                    <div class="col-md-6">
                                        <label class="form-label" for="total_reported_incidents">Total Reported Incidents</label>
                                        <input type="number" class="form-control" id="total_reported_incidents" placeholder="Total Reported Incidents" name="total_reported_incidents" aria-label="Total Reported Incidents">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="academic_misconduct_cases">Academic Misconduct Cases</label>
                                        <input type="number" class="form-control" id="academic_misconduct_cases" placeholder="Academic Misconduct Cases" name="academic_misconduct_cases" aria-label="Academic Misconduct Cases">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="administrative_breaches">Administrative Breaches</label>
                                        <input type="number" class="form-control" id="administrative_breaches" placeholder="Administrative Breaches" name="administrative_breaches" aria-label="Administrative Breaches">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="governance_protocol_violations">Governance Protocol Violations</label>
                                        <input type="number" class="form-control" id="governance_protocol_violations" placeholder="Governance Protocol Violations" name="governance_protocol_violations" aria-label="Governance Protocol Violations">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cpd_type" class="form-label">Severity Level</label>
                                        <select name="severity_level" class="select2 form-select severity_level" required>
                                            <option value="">-- Select --</option>
                                            <option value="Low "> Low </option>
                                            <option value="Medium">Medium </option>
                                            <option value="High"> High</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                        
                                        <label for="evidence_case_reference" class="form-label">Evidence / Case Reference</label>
                                        <input class="form-control" type="file" id="evidence_case_reference" name="evidence_case_reference" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="remarks">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                    </div>




                                </div>
                                <div class="col-12 demo-vertical-spacing">
                                    <button class="btn btn-primary waves-effect waves-light float-end" style="margin-right: 0px;">SUBMIT</button>
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
                                            <th>Project Name</th>
                                            <th>Contracting Industry</th>
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
@endpush

 

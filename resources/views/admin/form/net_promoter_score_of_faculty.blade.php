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
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Net Promoter Score of Faculty</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#form3" role="tab">Table</a>
                        </li>
                    </ul>
                @endif

                <!-- Tab panes -->
                <div class="tab-content">
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h5 class="mb-1">Net Promoter Score of Faculty</h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'net_promoter_score_of_faculty', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div> 
                            <form id="researchForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden"  id="form_status" name="form_status" value="HOD">

                                <div class="row g-6 mt-0">

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="total_faculty_surveyed">Total Faculty Surveyed</label>
                                                <input type="number" class="form-control" id="total_faculty_surveyed" placeholder="Total Faculty Surveyed" name="total_faculty_surveyed" aria-label="Total Faculty Surveyed">
                                            </div>
                                            <div class="col-md-6">
                                                 <label class="form-label" for="number_of_promoters">Number of Promoters (Score 9–10)</label>
                                                <input type="number" class="form-control" id="number_of_promoters" placeholder="Number of Promoters (Score 9–10)" name="number_of_promoters" aria-label="Number of Promoters (Score 9–10)">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="number_of_passives">Number of Passives (Score 7–8)</label>
                                                <input type="number" class="form-control" id="number_of_passives" placeholder="Number of Passives (Score 7–8)" name="number_of_passives">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="number_of_detractors">Number of Detractors (Score 0–6)</label>
                                                <input type="number" class="form-control" id="number_of_detractors" placeholder="Number of Detractors (Score 0–6)" name="number_of_detractors" aria-label="Number of Detractors (Score 0–6)">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label" for="evidence_reference">Evidence Reference</label>
                                                <input type="text" class="form-control" id="evidence_reference" placeholder="Evidence Reference" name="evidence_reference" aria-label="Evidence Reference">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label" for="remarks">Remarks</label>
                                                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                            </div>
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
                                        <th>Name</th>
                                        <th>Funding Agency</th>
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
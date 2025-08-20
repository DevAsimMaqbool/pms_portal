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
                {{-- <h5>KPA to role</h5> --}}
                <form id="researchForm" enctype="multipart/form-data"class="row">
                    @csrf
                    <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                    <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                    <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                    
                    <div class="row g-6">
                    <h5>Grants</h5>
                        <div id="grant-details-container" >
                            <div class="grant-group row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Name of Grant</label>
                                    <input type="text" name="grants[0][name]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Funding Agency</label>
                                    <input type="text" name="grants[0][funding_agency]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Grant Volume</label>
                                    <input type="text" name="grants[0][volume]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Grant Submitted</label>
                                    <select name="grants[0][submitted]" class="form-select" required>
                                        <option value="">-- Select --</option>
                                        <option value="PI">PI</option>
                                        <option value="CO-PI">CO-PI</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Proof of Submission</label>
                                    <input type="text" name="grants[0][proof]" class="form-control">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-label-danger mt-xl-6 waves-effec remove-grant"><i class="icon-base ti tabler-x me-1"></i><span class="align-middle">Delete</span></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-primary waves-effect waves-light" id="add-grant"><i class="icon-base ti tabler-plus me-1"></i> <span class="align-middle">Add</span></button>
                        </div>
                        
                    </div>
                    <div class="row g-6">
                    <h5>Grants Won</h5>
                        <div id="grantsWonWrapper">
                            <div class="grants-won-group row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">No of Grants Won</label>
                                    <input type="number" name="grants_won[0][count]" class="form-control" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Name of Grant Won</label>
                                    <input type="text" name="grants_won[0][name]" class="form-control" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Grant Award Letter</label>
                                    <input type="file" name="grants_won[0][letter]" class="form-control" />
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-label-danger mt-xl-6 waves-effec remove-grants-won"><i class="icon-base ti tabler-x me-1"></i> <span class="align-middle">Delete</span></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                         <button type="button" id="addGrantsWon" class="btn btn-primary waves-effect waves-light"><i class="icon-base ti tabler-plus me-1"></i> <span class="align-middle">Add</span></button>
                        </div>
                    </div>
                    <div class="col-4 text-center demo-vertical-spacing">
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
@endpush
@push('script')
<script>
$(document).ready(function () {
    let grantIndex = 1;
    let grantsWonIndex = 1;

    // Add new grant group
    $('#add-grant').click(function () {
        let newGroup = `<hr>
        <div class="grant-group row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Name of Grant</label>
                <input type="text" name="grants[${grantIndex}][name]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Funding Agency</label>
                <input type="text" name="grants[${grantIndex}][funding_agency]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Grant Volume</label>
                <input type="text" name="grants[${grantIndex}][volume]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Grant Submitted</label>
                <select name="grants[${grantIndex}][submitted]" class="form-select" required>
                    <option value="">-- Select --</option>
                    <option value="PI">PI</option>
                    <option value="CO-PI">CO-PI</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Proof of Submission</label>
                <input type="text" name="grants[${grantIndex}][proof]" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-grant"><i class="icon-base ti tabler-x me-1"></i><span class="align-middle">Delete</span></button>
            </div>
        </div>`;

        $('#grant-details-container').append(newGroup);
        grantIndex++;
    });

    // Remove a grant group
    $(document).on('click', '.remove-grant', function () {
        $(this).closest('.grant-group').remove();
    });

    // ===================== Grants Won Add =====================
    $("#addGrantsWon").click(function () {
        let html = `<hr>
        <div class="grants-won-group row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">No of Grants Won</label>
                <input type="number" name="grants_won[${grantsWonIndex}][count]" class="form-control" />
            </div>
            <div class="col-md-4">
                <label class="form-label">Name of Grant Won</label>
                <input type="text" name="grants_won[${grantsWonIndex}][name]" class="form-control" />
            </div>
            <div class="col-md-4">
                <label class="form-label">Grant Award Letter</label>
                <input type="file" name="grants_won[${grantsWonIndex}][letter]" class="form-control" />
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-grants-won"><i class="icon-base ti tabler-x me-1"></i><span class="align-middle">Delete</span></button>
            </div>
        </div>`;
        $("#grantsWonWrapper").append(html);
        grantsWonIndex++;
    });
    // Remove Grants Won
    $(document).on("click", ".remove-grants-won", function () {
        $(this).closest(".grants-won-group").remove();
    });
});
</script>
@endpush


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
                @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                    <h5 class="mb-1"># of Grants Won</h5>
                    <h5 class="text-primary">Target 5</h5>
                    <form id="researchForm" enctype="multipart/form-data" class="row">
                        @csrf
                        <input type="hidden" id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                        <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER">

                        <div class="row g-6 mt-0">

                            <div id="grant-details-container">
                                <div class="grant-group row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Name Of Grant</label>
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
                                        <label class="form-label">Your Role</label>
                                        <select name="grants[0][role]" class="form-select" required>
                                            <option value="">-- Select --</option>
                                            <option value="PI">PI</option>
                                            <option value="CO-PI">CO-PI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <select name="grants[0][grant_status]" class="form-select grant-status" required>
                                            <option value="">-- Select --</option>
                                            <option value="Submitted">Submitted</option>
                                            <option value="Won">Won</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 proof-container" style="display:none;">
                                        <label class="form-label proof-label">Proof Of Submission</label>
                                        <input type="file" name="grants[0][proof]" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <button type="button" class="btn btn-primary waves-effect waves-light" id="add-grant"><i
                                        class="icon-base ti tabler-plus me-1"></i> <span
                                        class="align-middle">Add</span></button>
                            </div>
                        </div>
                        <div class="col-4 text-center demo-vertical-spacing">
                            <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                        </div>
                    </form>
                @endif
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
    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
        <script>
            $(document).ready(function () {
                let grantIndex = 1;

                // Add new grant group
                $('#add-grant').click(function () {
                    let newGroup = `
                                                                                                                                                                                <div class="grant-group row g-3 mb-3">
                                                                                                                                                                                <hr>
                                                                                                                                                                                    <div class="col-md-4">
                                                                                                                                                                                        <label class="form-label">Name Of Grant</label>
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
                                                                                                                                                                                        <label class="form-label">Your Role</label>
                                                                                                                                                                                        <select name="grants[${grantIndex}][role]" class="form-select" required>
                                                                                                                                                                                            <option value="">-- Select --</option>
                                                                                                                                                                                            <option value="PI">PI</option>
                                                                                                                                                                                            <option value="CO-PI">CO-PI</option>
                                                                                                                                                                                        </select>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="col-md-4">
                                                                                                                                                                                        <label class="form-label">Status</label>
                                                                                                                                                                                        <select name="grants[${grantIndex}][grant_status]" class="form-select grant-status" required>
                                                                                                                                                                                            <option value="">-- Select --</option>
                                                                                                                                                                                            <option value="Submitted">Submitted</option>
                                                                                                                                                                                            <option value="Won">Won</option>
                                                                                                                                                                                        </select>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="col-md-4 proof-container" style="display:none;">
                                                                                                                                                                                        <label class="form-label proof-label">Proof Of Submission</label>
                                                                                                                                                                                        <input type="file" name="grants[${grantIndex}][proof]" class="form-control" required>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="col-md-2 d-flex align-items-end">
                                                                                                                                                                                        <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-grant">
                                                                                                                                                                                            <i class="icon-base ti tabler-x me-1"></i>
                                                                                                                                                                                            <span class="align-middle">Delete</span>
                                                                                                                                                                                        </button>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </div>`;

                    $('#grant-details-container').append(newGroup);
                    grantIndex++;
                });

                // Remove a grant group
                $(document).on('click', '.remove-grant', function () {
                    $(this).closest('.grant-group').remove();
                });

                // Show/hide proof field based on status
                $(document).on('change', '.grant-status', function () {
                    let status = $(this).val();
                    let container = $(this).closest('.grant-group').find('.proof-container');
                    let label = container.find('.proof-label');

                    if (status === 'Submitted') {
                        label.text('Provide Attachment (Approval)');
                        container.show();
                    } else if (status === 'Won') {
                        label.text('Proof (Award Letter)');
                        container.show();
                    } else {
                        container.hide();
                        container.find('input[type="file"]').val('');
                    }
                });

                $('#researchForm').on('submit', function (e) {
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
                        url: "{{ route('no-Of-GrantSubmit-And-Won.store') }}",
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
                              // Remove all extra grant groups and keep only the first one
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
                                        let fieldName = field.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']';
                                        fieldName = fieldName.replace('[]]', ']');
                                        let input = form.find('[name="' + fieldName + '"]');

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

            });
        </script>
    @endif
@endpush
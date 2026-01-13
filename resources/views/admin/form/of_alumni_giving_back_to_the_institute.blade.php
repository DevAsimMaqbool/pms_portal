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
                            <div class="d-flex justify-content-between">
                                <div>
                                <h5 class="mb-1">% of Alumni giving back to the institute</h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'no_of_professional_memberships_attained_vs_targets', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div> 
                            <form id="researchForm" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                <div class="row g-6 mt-0">
                                    <div id="grant-details-container">
                                        <div class="grant-group row g-3 mb-3 p-3 border border-primary">
                                            <div class="col-md-6">
                                                <label for="academic_year" class="form-label">Academic Year</label>
                                                <select name="academic_year" id="academic_year" class="select2 form-select faculty-member"
                                                    required>
                                                    <option value="">-- Select Year --</option>
                                                    <option value="2024-25">2024-25</option>
                                                    <option value="2023-24">2023-24</option>
                                                    <option value="2022-23">2022-23</option>
                                                    <option value="2021-22">2021-22</option>
                                                    <option value="2020-21">2020-21</option>
                                                    <option value="2019-20">2019-20</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="faculty_id" class="form-label">Alumni Name / ID</label>
                                                <input type="text" name="alumni_name" id="alumni_name" value="" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="graduation_year" class="form-label">Graduation Year</label>
                                                <select name="graduation_year" id="graduation_year" class="select2 form-select faculty-member"
                                                    required>
                                                    <option value="">-- Select Level --</option>
                                                    <option value="2025">2025</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2010">2010</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="faculty_id" class="form-label">Faculty / Program</label>
                                                <select name="faculty_id" id="faculty_id" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Faculty --</option>
                                                    <option value="cs">CS</option>
                                                    <option value="it">IT</option>
                                                    <option value="se">SE</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="type_of_contribution" class="form-label">Type of
                                                    Contribution</label>

                                                <select name="type_of_contribution[]" id="type_of_contribution" id="select2Multiple"
                                                    class="select2 form-select select2-hidden-accessible" multiple=""
                                                    data-select2-id="select2Multiple" tabindex="-1" aria-hidden="true">
                                                    <option value="">-- Select Type --</option>
                                                    <option value="financial ">Financial</option>
                                                    <option value="volunteering ">Volunteering</option>
                                                    <option value="mentoring ">Mentoring</option>
                                                    <option value="career_support ">Career Support</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label d-block">Description of Contribution</label>
                                                <div>
                                                    <textarea class="form-control" id="description_of_contribution"
                                                        name="description_of_contribution" rows="1"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="date_of_contribution" class="form-label">Date of
                                                    Contribution</label>
                                                <input type="date" name="date_of_contribution" id="date_of_contribution" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label d-block">Evidence (if applicable)</label>
                                                <div>
                                                    <input class="form-control" name="evidence_upload" type="file"
                                                        id="evidence_upload">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="contribution_verified_by" class="form-label">Contribution Verified
                                                    By</label>
                                                <select name="contribution_verified_by" id="contribution_verified_by" class="select2 form-select">
                                                    <option value="">-- Select--</option>
                                                    <option value="alumni_office">Alumni Office</option>
                                                    <option value="finance">Finance </option>
                                                    <option value="career_office">Career Office</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="verification_status" class="form-label">Verification
                                                    Status</label>
                                                <select name="verification_status" id="verification_status" class="select2 form-select">
                                                    <option value="">-- Select--</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="verified">Verified</option>
                                                </select>
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
@push('script')
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            $(document).ready(function () {



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
                        url: "{{ route('alumni-contribution.store') }}",
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
                            $('.select2').val(null).trigger('change');
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
                                    let input = form.find('[name="' + field + '"]');

                                    if (input.length) {
                                        input.addClass('is-invalid');

                                        // Show error message under input
                                        input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                    }
                                });

                            } else if (xhr.status === 409) {
                                // 🔥 Duplicate record message
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Duplicate Entry',
                                    text: xhr.responseJSON.message
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
@endpush
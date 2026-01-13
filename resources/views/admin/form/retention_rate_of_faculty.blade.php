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
                            <h5 class="mb-1">Retention Rate of Faculty</h5>
                            <form id="researchForm" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                <div class="row g-6 mt-0">
                                    <div id="grant-details-container">
                                        <div class="grant-group row g-3 mb-3 p-3 border border-primary">
                                            <div class="col-md-6">
                                                <label for="academic_year" class="form-label">Academic Year</label>
                                                <select name="academic_year" class="select2 form-select faculty-member"
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
                                                <label for="faculty_id" class="form-label">Faculty / School</label>
                                                <select name="faculty_id" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Faculty --</option>
                                                    <option value="cs">CS</option>
                                                    <option value="it">IT</option>
                                                    <option value="se">SE</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="department" class="form-label">Department</label>
                                                <select name="department_id" class="select2 form-select faculty-member"
                                                    required>
                                                    <option value="">-- Select Level --</option>
                                                    <option value="cs">CS</option>
                                                    <option value="it">IT</option>
                                                    <option value="se">SE</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="strength_at_start_of_month" class="form-label">Faculty Strength at
                                                    Start of
                                                    Month</label>
                                                <input type="number" name="strength_at_start_of_month" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="join_during_month" class="form-label">New Faculty Joined During
                                                    Month</label>
                                                <input type="number" name="join_during_month" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="left_during_month" class="form-label">Faculty Left During
                                                    Month</label>
                                                <input type="number" name="left_during_month" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="strength_end_month" class="form-label">Faculty Strength at End of
                                                    Month</label>
                                                <input type="number" name="strength_end_month" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="retention_rate" class="form-label">Retention Rate (%)</label>
                                                <input type="number" name="retention_rate" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="retention_status" class="form-label">Retention Status</label>
                                                <select name="retention_status" class="select2 form-select">
                                                    <option value="">-- Select Ranking--</option>
                                                    <option value="excellent">Excellent</option>
                                                    <option value="satisfactory ">Satisfactory</option>
                                                    <option value="needs_attention">Needs Attention</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label d-block">Remarks</label>
                                                <div>
                                                    <textarea class="form-control" id="TitleOfActivity" name="remarks"
                                                        rows="4"></textarea>
                                                </div>
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
@endpush
@push('script')
    <script>

        document.addEventListener("DOMContentLoaded", function () {

            // SVG stars
            const starOn = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23FFD700' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
            const starHalf = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cdefs%3E%3ClinearGradient id='halfStarGradient'%3E%3Cstop offset='50%25' style='stop-color:%23FFD700' /%3E%3Cstop offset='50%25' style='stop-color:%239e9e9e' /%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath fill='url(%23halfStarGradient)' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
            const starOff = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%239e9e9e' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";

            // Employer Rating
            const employerRaty = new Raty(document.getElementById("employerRating"), {
                number: 5,
                half: true,
                starOn: starOn,
                starHalf: starHalf,
                starOff: starOff,
                click: function (score) {
                    document.getElementById("employer_satisfaction").value = score;
                }
            }).init();

            // Graduate Rating
            const graduateRaty = new Raty(document.getElementById("graduateRating"), {
                number: 5,
                half: true,
                starOn: starOn,
                starHalf: starHalf,
                starOff: starOff,
                click: function (score) {
                    document.getElementById("graduate_satisfaction").value = score;
                }
            }).init();

        });




    </script>
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
                        url: "{{ route('employability.store') }}",
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

                            document.getElementById("employer_satisfaction").value = "";
                            document.getElementById("graduate_satisfaction").value = "";

                            // Reset stars
                            employerRaty.setScore(0);
                            graduateRaty.setScore(0);
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
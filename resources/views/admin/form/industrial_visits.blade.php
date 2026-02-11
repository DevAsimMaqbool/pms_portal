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

        <!-- new design -->

        <div class="app-ecommerce">
            <!-- tab open-->
            <div class="nav-align-top">

                <ul class="nav nav-pills mb-4" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home"
                            aria-selected="true">Industrial Visits</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                            aria-selected="false">Table</button>
                    </li>

                </ul>
                <!-- main tab-->
                <div class="tab-content" style="padding:0;background: none;border: none;box-shadow: none;">
                    @if(auth()->user()->hasRole(['HOD']))
                        <!-- first tab-->
                        <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">

                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                                <div class="d-flex flex-column justify-content-center">
                                    <h4 class="mb-1">Industrial Visits</h4>
                                </div>
                                <div class="d-flex align-content-center flex-wrap gap-4">
                                    <div class="d-flex gap-4">
                                        <a class="btn btn-label-primary"
                                            href="{{ route('indicators_crud.index', ['slug' => 'industrial_visits', 'id' => $indicatorId]) }}">View</a>
                                    </div>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                                        <i class="bx bx-upload"></i> Import Excel / CSV</button>
                                </div>
                            </div>
                            <form id="researchForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                <div class="row">
                                    <!-- First column-->
                                    <div class="col-12 col-lg-8">
                                        <!-- Product Information -->
                                        <div class="card mb-6">

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Employee Name</label>
                                                        <input type="text" name="employee_name" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Employee ID</label>
                                                        <input type="text" name="employee_id" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Designation</label>
                                                        <input type="text" name="designation" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Department / Program</label>
                                                        <input type="text" name="department_program" class="form-control"
                                                            required>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Campus / Unit</label>
                                                        <input type="text" name="campus_unit" class="form-control">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Industry / Organization Visited</label>
                                                        <input type="text" name="industry_organization" class="form-control"
                                                            required>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="sector" class="form-label">Industry Sector</label>
                                                        <select name="industry_sector" class="select2 form-selec" required>
                                                            <option value="">Select</option>
                                                            <option value="Manufacturing">Manufacturing</option>
                                                            <option value="Services">Services</option>
                                                            <option value="Information Technology (IT)">Information Technology
                                                                (IT)</option>
                                                            <option value="Banking & Finance">Banking & Finance</option>
                                                            <option value="Insurance">Insurance</option>
                                                            <option value="FMCG & Consumer Goods">FMCG & Consumer Goods</option>
                                                            <option value="Retail & E-Commerce">Retail & E-Commerce</option>
                                                            <option value="Energy & Utilities">Energy & Utilities</option>
                                                            <option value="Oil & Gas">Oil & Gas</option>
                                                            <option value="Construction & Real Estate">Construction & Real
                                                                Estate</option>
                                                            <option value="Healthcare & Pharmaceuticals">Healthcare &
                                                                Pharmaceuticals</option>
                                                            <option value="Agriculture & Agribusiness">Agriculture &
                                                                Agribusiness</option>
                                                            <option value="Education & Training">Education & Training</option>
                                                            <option value="Media & Communications">Media & Communications
                                                            </option>
                                                            <option value="Logistics & Transportation">Logistics &
                                                                Transportation</option>
                                                            <option value="Hospitality & Tourism">Hospitality & Tourism</option>
                                                            <option value="Telecommunications">Telecommunications</option>
                                                            <option value="Engineering & Industrial Services">Engineering &
                                                                Industrial Services</option>
                                                            <option value="Government / Public Sector">Government / Public
                                                                Sector</option>
                                                            <option value="Development Sector / NGO">Development Sector / NGO
                                                            </option>
                                                            <option value="Research & Development">Research & Development
                                                            </option>
                                                            <option value="Startups & Entrepreneurship">Startups &
                                                                Entrepreneurship</option>
                                                            <option value="Environmental & Sustainability">Environmental &
                                                                Sustainability</option>
                                                            <option value="Other (Specify)">Other (Specify)</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Purpose / Learning Objective</label>
                                                        <input type="text" name="purpose_learning_objective"
                                                            class="form-control" required>
                                                    </div>


                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Course / Subject Linked</label>
                                                        <input type="text" name="course_subject" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">No. of Students Involved</label>
                                                        <input type="number" name="students_involved" class="form-control"
                                                            required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Employee Role</label>
                                                        <select name="employee_role" class="form-control" required>
                                                            <option>Organizer</option>
                                                            <option>Coordinator</option>
                                                            <option>Faculty-in-Charge</option>
                                                            <option>Participant</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Visit Category</label>
                                                        <select name="visit_category" class="form-control" required>
                                                            <option>Local</option>
                                                            <option>National</option>
                                                            <option>International</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Evidence Upload</label>
                                                        <input type="file" name="evidence_upload" class="form-control" required>
                                                    </div>






                                                </div>
                                                <!-- Description -->

                                            </div>
                                        </div>
                                        <!-- /Product Information -->


                                    </div>
                                    <!-- /Second column -->

                                    <!-- Second column -->
                                    <div class="col-12 col-lg-4">
                                        <!-- Pricing Card -->
                                        <div class="card mb-3">

                                            <div class="card-body">


                                                <div class="mb-3">
                                                    <label class="form-label">Visit Start Date</label>
                                                    <input type="date" name="visit_start_date" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Visit End Date</label>
                                                    <input type="date" name="visit_end_date" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" name="location" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Visit Report Submitted</label>
                                                    <select name="visit_report_submitted" class="form-control" required>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Report Submission Date</label>
                                                    <input type="date" name="report_submission_date" class="form-control">
                                                </div>


                                            </div>
                                        </div>
                                        <!-- /Pricing Card -->
                                        <div class="">
                                            <button type="submit"
                                                class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                        </div>

                                    </div>
                                    <!-- /Second column -->
                                </div>
                            </form>

                        </div>
                        <!-- /first tab-->
                    @endif
                    <!-- /second tab-->
                    <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                    </div>
                    <!-- /second tab-->

                </div>
                <!-- /main tab-->

            </div>
            <!-- tab open-->
        </div>



        <!-- / close new design -->
        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="importForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                    <input type="hidden" name="form_status" value="HOD">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Import Employability Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <label class="form-label">Upload Excel / CSV</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>

                            <small class="text-muted d-block mt-2">
                                Allowed: xlsx, xls, csv
                            </small>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
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

                $('#importForm').on('submit', function (e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    Swal.fire({
                        title: 'Importing...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('employability.import') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            Swal.close();
                            Swal.fire('Success', res.message, 'success');
                            $('#importModal').modal('hide');
                            $('#importForm')[0].reset();
                        },
                        error: function (xhr) {
                            Swal.close();
                            Swal.fire('Error', xhr.responseJSON.message ?? 'Import failed', 'error');
                        }
                    });
                });


            });
        </script>
    @endif
@endpush
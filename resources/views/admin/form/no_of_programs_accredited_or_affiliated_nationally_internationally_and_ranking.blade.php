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
                                                    <h5 class="mb-1">No of Programs accredited or affiliated nationally/ Internationally and ranking
                                                    </h5>
                                                    <form id="researchForm" enctype="multipart/form-data" class="row">
                                                        @csrf
                                                        <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                                                        <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                                        <div class="row g-6 mt-0">
                                                            <div id="grant-details-container">
                                                                <div class="grant-group row g-3 mb-3 p-3 border border-primary">
                                                                    <div class="col-md-6">
                                                                        <label for="faculty" class="form-label">Faculty</label>
                                                                        <select name="faculty_id" id="faculty_id" class="select2 form-select faculty-member" required>
                                                                            <option value="">-- Select Faculty --</option>
                                                                            <option value="11"> Faculty of Business and Management Sciences-KCF</option>
                                                                            <option value="171">Faculty of Computer Science and Information
                                                                                Technology-CCL</option>
                                                                            <option value="158"> Faculty of  Arts and Humanities-CCL</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label for="department_id" class="form-label">Department</label>
                                                                        <select name="department_id" id="department_id" class="select2 form-select faculty-member"
                                                                            required>
                                                                            <option value="">-- Select Department --</option>
                                                                            <option value="11">CS</option>
                                                                            <option value="12">IT</option>
                                                                            <option value="13">SE</option>

                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label for="program" class="form-label">Program</label>
                                                                        <select name="program_id" id="program_id" class="select2 form-select faculty-member" required>
                                                                            <option value="">-- Select Program --</option>
                                                                            <option value="1"> BS Robotics</option>
                                                                            <option value="2">BS Gaming And Multimedia</option>
                                                                            <option value="3"> BS Cyber Security</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label for="program_level" class="form-label">Program Level</label>
                                                                        <select name="program_level" id="program_level" class="select2 form-select faculty-member"
                                                                           required >
                                                                            <option value="">-- Select Level --</option>
                                                                            <option value="ug">UG</option>
                                                                            <option value="grad">Grad</option>
                                                                            <option value="phd">PhD</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label for="recognition_type" class="form-label">Recognition Type</label>
                                                                        <select name="recognition_type" id="recognition_type" class="select2 form-select faculty-member"
                                                                           required >
                                                                            <option value="">-- Select Type --</option>
                                                                            <option value="accreditation">Accreditation</option>
                                                                            <option value="affiliation">Affiliation</option>
                                                                            <option value="membership">Membership</option>
                                                                            <option value="ranking">Ranking</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label for="ranking_body" class="form-label">Accrediting / Ranking Body</label>
                                                                        <select name="ranking_body" id="ranking_body" class="select2 form-select faculty-member" required>
                                                                            <option value="">-- Select Body --</option>
                                                                            <option value="PBC">Pakistan Bar Council (PBC)</option>
                                                                            <option value="PCATP">Pakistan Council for Architects and Town Planners
                                                                                (PCATP)</option>
                                                                            <option value="PMDC">Pakistan Medical & Dental Council (PMDC)</option>
                                                                            <option value="PEC">Pakistan Engineering Council (PEC)</option>
                                                                            <option value="PNC">Pakistan Nursing Council (PNC)</option>
                                                                            <option value="PCP">Pakistan Pharmacy Council (PCP)</option>
                                                                            <option value="PVMC">Pakistan Veterinary Medical Council (PVMC)</option>
                                                                            <option value="NCH">National Council for Homoeopathy (NCH)</option>
                                                                            <option value="NCT">National Council for Tibb (NCT)</option>
                                                                            <option value="AHP">Allied Health Professionals</option>
                                                                            <option value="NACTE">National Accreditation Council for Teachers Education
                                                                                (NACTE)</option>
                                                                            <option value="NAEAC">National Agricultural Education Accreditation Council
                                                                                (NAEAC)</option>
                                                                            <option value="NCEAC">National Computing Education Accreditation Council
                                                                                (NCEAC)</option>
                                                                            <option value="NBEAC">National Business Education Accreditation Council
                                                                                (NBEAC)</option>
                                                                            <option value="NTC">National Technology Council (NTC)</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label for="scope" class="form-label">Scope (Nat./Int.)</label>
                                                                        <select name="scope" id="scope" class="select2 form-select faculty-member" required>
                                                                            <option value="">-- Select Scope --</option>
                                                                            <option value="national">National</option>
                                                                            <option value="international">International</option>
                                                                        </select>
                                                                    </div>

                                                                    

                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Validity From</label>
                                                                        <input type="date" name="validity_from" id="validity_from" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Validity To</label>
                                                                        <input type="date" name="validity_to" id="validity_to" class="form-control" required>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label for="university_ranking" class="form-label">Ranking System (if any)</label>
                                                                            <select class="select2 form-select faculty-member" id="university_ranking" name="university_ranking" required>
                                                                            <option value="">-- Select Ranking --</option>    
                                                                            <option value="qs_world">QS World University Rankings</option>
                                                                                <option value="the">Times Higher Education (THE)</option>
                                                                                <option value="arwu">Academic Ranking of World Universities (ARWU)
                                                                                </option>
                                                                                <option value="us_news">U.S. News & World Report</option>
                                                                                <option value="webometrics">Webometrics Ranking of World Universities
                                                                                </option>
                                                                                <option value="cwts_leiden">CWTS Leiden Ranking</option>
                                                                                <option value="scimago">SCImago Institutions Rankings</option>
                                                                                <option value="round_university">Round University Ranking</option>
                                                                                <option value="unirank">UniRank</option>
                                                                                <option value="qs_asia">QS Asia University Rankings</option>
                                                                                <option value="qs_arab">QS Arab Region University Rankings</option>
                                                                                <option value="the_asia">THE Asia University Rankings</option>
                                                                                <option value="the_emerging">THE Emerging Economies Rankings</option>
                                                                            </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Ranking Position / Band</label>
                                                                        <input type="ranking_position" name="ranking_position" id="ranking_position" class="form-control"
                                                                            min="1" step="1" required>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label for="evidence_available" class="form-label">Evidence Available
                                                                            (Y/N)</label>
                                                                        <select name="evidence_available" id="evidence_available"
                                                                            class="select2 form-select evidence_available" required>
                                                                            <option value="">-- Select Evidence --</option>
                                                                            <option value="yes">Y</option>
                                                                            <option value="no">N</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label class="form-label d-block">Document Link / Ref</label>
                                                                        <div>
                                                                            <input class="form-control" name="document_link" type="file" id="document_link">
                                                                        </div>
                                                                    </div>

                        <div class="col-md-12">
                            <label class="form-label d-block">Remarks</label>
                            <div>
                                <textarea class="form-control" id="remarks"
                                                name="remarks"
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
                        url: "{{ route('no-of-programs-accredited.store') }}",
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